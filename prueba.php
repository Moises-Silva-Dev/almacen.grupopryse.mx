<?php
// =============================================================================
// punto_reorden_individual.php - Con Control de Parámetros por SKU
// =============================================================================
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'Modelo/Conexion.php';

$conectar = new Conectar();
$mysqli = $conectar->conexion();

// Parámetros GET
$id_producto_seleccionado = isset($_GET['id_producto']) ? (int)$_GET['id_producto'] : 0;
$id_talla_seleccionada = isset($_GET['id_talla']) ? (int)$_GET['id_talla'] : 0;
$dias_analisis = isset($_GET['dias']) ? (int)$_GET['dias'] : 90;

// =============================================================================
// GUARDAR PARÁMETROS (Si se envió el formulario de actualización)
// =============================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_parametros'])) {
    $id_prod = (int)$_POST['id_producto'];
    $id_talla = (int)$_POST['id_talla'];
    $stock_min = (int)$_POST['stock_min'];
    $stock_max = (int)$_POST['stock_max'];
    $punto_reorden = (int)$_POST['punto_reorden'];
    $lead_time = (int)$_POST['lead_time'];
    $stock_seg = (int)$_POST['stock_seguridad'];
    
    $sql_upsert = "
        INSERT INTO Inventario_Control (IdCPro, IdCTal, StockMinimo, StockMaximo, PuntoReorden, LeadTimeDias, StockSeguridad, UltimaActualizacion)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ON DUPLICATE KEY UPDATE 
            StockMinimo = VALUES(StockMinimo),
            StockMaximo = VALUES(StockMaximo),
            PuntoReorden = VALUES(PuntoReorden),
            LeadTimeDias = VALUES(LeadTimeDias),
            StockSeguridad = VALUES(StockSeguridad),
            UltimaActualizacion = NOW()
    ";
    $stmt_upsert = $mysqli->prepare($sql_upsert);
    $stmt_upsert->bind_param("iiiiiii", $id_prod, $id_talla, $stock_min, $stock_max, $punto_reorden, $lead_time, $stock_seg);
    $stmt_upsert->execute();
    $stmt_upsert->close();
    
    // Redirigir para evitar reenvío del formulario
    header("Location: ?id_producto=$id_prod&id_talla=$id_talla&dias=$dias_analisis&guardado=1");
    exit;
}

// =============================================================================
// 1. LISTADO DE PRODUCTOS PARA EL SELECT
// =============================================================================
$sql_productos = "
    SELECT 
        p.IdCProducto, 
        p.Descripcion, 
        t.IdCTallas, 
        t.Talla,
        CONCAT(p.Descripcion, ' (', t.Talla, ') - Stock: ', IFNULL(i.Cantidad, 0)) as NombreCompleto
    FROM Producto p
    INNER JOIN CTipoTallas tip ON p.IdCTipTal = tip.IdCTipTall
    INNER JOIN CTallas t ON t.IdCTipTal = tip.IdCTipTall
    LEFT JOIN Inventario i ON i.IdCPro = p.IdCProducto AND i.IdCTal = t.IdCTallas
    WHERE i.Cantidad IS NOT NULL OR i.Cantidad > 0
    ORDER BY p.Descripcion, t.Talla
";
$result_productos = $mysqli->query($sql_productos);
$listado_productos = [];
if ($result_productos) {
    while ($row = $result_productos->fetch_assoc()) {
        $listado_productos[] = $row;
    }
}

// =============================================================================
// 2. OBTENER DATOS DEL SKU SELECCIONADO (Producto + Parámetros de Control)
// =============================================================================
$producto_data = null;
$control_data = null;
$labels_historial = [];
$data_salidas = [];
$stock_actual = 0;
$promedio_diario = 0;
$punto_reorden_calculado = 0;

// Valores por defecto si no hay configuración guardada
$lead_time_dias = 15;
$stock_seguridad = 5;
$stock_minimo = 5;
$stock_maximo = 100;

if ($id_producto_seleccionado > 0 && $id_talla_seleccionada > 0) {
    
    // 2.1 Datos del producto y stock actual
    $sql_detalle = "
        SELECT 
            p.Descripcion, 
            t.Talla, 
            i.Cantidad as Stock_Actual,
            p.IMG,
            cat.Descrp as Categoria
        FROM Producto p
        INNER JOIN CTallas t ON t.IdCTallas = ?
        INNER JOIN CCategorias cat ON p.IdCCat = cat.IdCCate
        LEFT JOIN Inventario i ON i.IdCPro = p.IdCProducto AND i.IdCTal = t.IdCTallas
        WHERE p.IdCProducto = ?
    ";
    $stmt_det = $mysqli->prepare($sql_detalle);
    $stmt_det->bind_param("ii", $id_talla_seleccionada, $id_producto_seleccionado);
    $stmt_det->execute();
    $result_det = $stmt_det->get_result();
    $producto_data = $result_det->fetch_assoc();
    $stmt_det->close();
    
    if ($producto_data) {
        $stock_actual = (int)$producto_data['Stock_Actual'];
        
        // 2.2 Obtener parámetros de control (si existen)
        $sql_control = "
            SELECT StockMinimo, StockMaximo, PuntoReorden, LeadTimeDias, StockSeguridad, ConsumoPromedioDiario
            FROM Inventario_Control
            WHERE IdCPro = ? AND IdCTal = ? AND Activo = 1
        ";
        $stmt_ctrl = $mysqli->prepare($sql_control);
        $stmt_ctrl->bind_param("ii", $id_producto_seleccionado, $id_talla_seleccionada);
        $stmt_ctrl->execute();
        $result_ctrl = $stmt_ctrl->get_result();
        $control_data = $result_ctrl->fetch_assoc();
        $stmt_ctrl->close();
        
        if ($control_data) {
            $lead_time_dias = (int)$control_data['LeadTimeDias'];
            $stock_seguridad = (int)$control_data['StockSeguridad'];
            $stock_minimo = (int)$control_data['StockMinimo'];
            $stock_maximo = (int)$control_data['StockMaximo'];
            $punto_reorden_calculado = (int)$control_data['PuntoReorden'];
        }
        
        // 2.3 Historial de Salidas
        $sql_hist = "
            SELECT 
                DATE(se.FchSalidad) as Fecha,
                SUM(sd.Cantidad) as Total_Salidas
            FROM Salida_D sd
            INNER JOIN Salida_E se ON sd.Id = se.Id_SalE
            WHERE sd.IdCProd = ? AND sd.IdTallas = ?
              AND se.FchSalidad >= DATE_SUB(NOW(), INTERVAL ? DAY)
            GROUP BY DATE(se.FchSalidad)
            ORDER BY Fecha ASC
        ";
        $stmt_hist = $mysqli->prepare($sql_hist);
        $stmt_hist->bind_param("iii", $id_producto_seleccionado, $id_talla_seleccionada, $dias_analisis);
        $stmt_hist->execute();
        $result_hist = $stmt_hist->get_result();
        $historial = [];
        while ($row = $result_hist->fetch_assoc()) {
            $historial[] = $row;
        }
        $stmt_hist->close();
        
        // Preparar datos para la gráfica
        $suma_total_salidas = 0;
        $mapa_salidas = [];
        foreach ($historial as $h) {
            $mapa_salidas[$h['Fecha']] = (int)$h['Total_Salidas'];
            $suma_total_salidas += (int)$h['Total_Salidas'];
        }
        
        $periodo = new DatePeriod(
            new DateTime("-$dias_analisis days"),
            new DateInterval('P1D'),
            new DateTime()
        );
        
        foreach ($periodo as $fecha_obj) {
            $fecha_str = $fecha_obj->format('Y-m-d');
            $labels_historial[] = $fecha_obj->format('d M');
            $cantidad = isset($mapa_salidas[$fecha_str]) ? $mapa_salidas[$fecha_str] : 0;
            $data_salidas[] = $cantidad;
        }
        
        // Calcular promedio diario
        $promedio_diario = ($dias_analisis > 0) ? $suma_total_salidas / $dias_analisis : 0;
        
        // Si no hay parámetros guardados, calcular automáticamente
        if (!$control_data) {
            $punto_base = $promedio_diario * $lead_time_dias;
            $punto_reorden_calculado = round($punto_base + $stock_seguridad);
            if ($punto_reorden_calculado <= 0) $punto_reorden_calculado = 3;
        }
        
        // Actualizar consumo promedio en la tabla de control
        if ($control_data || $promedio_diario > 0) {
            $sql_update_consumo = "
                INSERT INTO Inventario_Control (IdCPro, IdCTal, ConsumoPromedioDiario, UltimaActualizacion)
                VALUES (?, ?, ?, NOW())
                ON DUPLICATE KEY UPDATE 
                    ConsumoPromedioDiario = VALUES(ConsumoPromedioDiario),
                    UltimaActualizacion = NOW()
            ";
            $stmt_upd = $mysqli->prepare($sql_update_consumo);
            $stmt_upd->bind_param("iid", $id_producto_seleccionado, $id_talla_seleccionada, $promedio_diario);
            $stmt_upd->execute();
            $stmt_upd->close();
        }
    }
}

// JSON para Chart.js
$json_labels_hist = json_encode($labels_historial);
$json_data_salidas = json_encode($data_salidas);
$alerta_guardado = isset($_GET['guardado']) ? true : false;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Reorden | PRYSE Almacén</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7fc; font-family: 'Segoe UI', Roboto, sans-serif; }
        .card { border: none; border-radius: 20px; box-shadow: 0 10px 30px -5px rgba(0,0,0,0.05); margin-bottom: 24px; background: white; }
        .metric-card { background: white; border-radius: 16px; padding: 20px; border-left: 6px solid; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .metric-card.primary { border-color: #3b82f6; }
        .metric-card.success { border-color: #10b981; }
        .metric-card.warning { border-color: #f59e0b; }
        .metric-card.danger { border-color: #ef4444; }
        .metric-value { font-size: 2rem; font-weight: 700; }
        .chart-container { height: 350px; }
        .product-img { width: 70px; height: 70px; object-fit: cover; border-radius: 12px; }
        .btn-soft-primary { background: #e0e7ff; color: #4338ca; border: none; }
        .btn-soft-primary:hover { background: #c7d2fe; }
    </style>
</head>
<body>
<div class="container-fluid py-4 px-4">
    
    <?php if ($alerta_guardado): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> Parámetros de control guardados correctamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <h2 class="fw-bold mb-4"><i class="fas fa-warehouse me-2 text-primary"></i>Control de Reorden por SKU</h2>

    <!-- Selector de Producto -->
    <div class="card">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-semibold"><i class="fas fa-tshirt me-1"></i>Producto y Talla</label>
                    <select id="productoSelect" class="form-select">
                        <option value="">-- Buscar prenda --</option>
                        <?php foreach ($listado_productos as $prod): ?>
                            <?php 
                            $selected = ($id_producto_seleccionado == $prod['IdCProducto'] && $id_talla_seleccionada == $prod['IdCTallas']) ? 'selected' : '';
                            ?>
                            <option value="<?php echo $prod['IdCProducto'] . '-' . $prod['IdCTallas']; ?>" <?php echo $selected; ?>>
                                <?php echo htmlspecialchars($prod['NombreCompleto']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Historial (Días)</label>
                    <input type="number" id="diasInput" class="form-control" value="<?php echo $dias_analisis; ?>">
                </div>
                <div class="col-md-2">
                    <button id="applyBtn" class="btn btn-primary w-100 mt-4"><i class="fas fa-search me-1"></i>Analizar</button>
                </div>
            </div>
        </div>
    </div>

    <?php if ($producto_data): ?>
    <!-- Vista de Producto -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="d-flex align-items-center gap-3 bg-white p-3 rounded-4 shadow-sm">
                <img src="<?php echo !empty($producto_data['IMG']) ? htmlspecialchars($producto_data['IMG']) : 'https://placehold.co/70/f1f5f9/64748b'; ?>" class="product-img">
                <div>
                    <h5 class="fw-bold mb-0"><?php echo htmlspecialchars($producto_data['Descripcion']); ?></h5>
                    <span class="badge bg-secondary">Talla: <?php echo htmlspecialchars($producto_data['Talla']); ?></span>
                    <span class="badge bg-primary ms-1"><?php echo htmlspecialchars($producto_data['Categoria']); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Métricas -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="metric-card primary">
                <small class="text-muted text-uppercase">Stock Actual</small>
                <div class="metric-value text-primary"><?php echo $stock_actual; ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card success">
                <small class="text-muted text-uppercase">Prom. Diario Salidas</small>
                <div class="metric-value text-success"><?php echo number_format($promedio_diario, 2); ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card warning">
                <small class="text-muted text-uppercase">Punto Reorden</small>
                <div class="metric-value text-warning"><?php echo $punto_reorden_calculado; ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card <?php echo ($stock_actual <= $punto_reorden_calculado) ? 'danger' : 'success'; ?>">
                <small class="text-muted text-uppercase">Estado</small>
                <div class="metric-value <?php echo ($stock_actual <= $punto_reorden_calculado) ? 'text-danger' : 'text-success'; ?>">
                    <?php echo ($stock_actual <= $punto_reorden_calculado) ? 'CRÍTICO' : 'SALUDABLE'; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Gráfica -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-transparent p-4"><h5 class="mb-0"><i class="fas fa-chart-area me-2"></i>Historial de Salidas</h5></div>
                <div class="card-body"><div class="chart-container"><canvas id="historialChart"></canvas></div></div>
            </div>
        </div>
        
        <!-- Panel de Parámetros de Control -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-transparent p-4">
                    <h5 class="mb-0"><i class="fas fa-sliders-h me-2"></i>Parámetros de Control</h5>
                </div>
                <div class="card-body">
                    <form method="POST" id="parametrosForm">
                        <input type="hidden" name="id_producto" value="<?php echo $id_producto_seleccionado; ?>">
                        <input type="hidden" name="id_talla" value="<?php echo $id_talla_seleccionada; ?>">
                        <input type="hidden" name="guardar_parametros" value="1">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fas fa-arrow-down me-1"></i>Stock Mínimo</label>
                            <input type="number" name="stock_min" class="form-control" value="<?php echo $stock_minimo; ?>" min="0">
                            <small class="text-muted">Dispara la alerta de reorden</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fas fa-arrow-up me-1"></i>Stock Máximo</label>
                            <input type="number" name="stock_max" class="form-control" value="<?php echo $stock_maximo; ?>" min="0">
                            <small class="text-muted">Capacidad máxima del almacén</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fas fa-exclamation-triangle me-1"></i>Punto de Reorden</label>
                            <input type="number" name="punto_reorden" class="form-control" value="<?php echo $punto_reorden_calculado; ?>" min="0">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fas fa-truck me-1"></i>Lead Time (Días)</label>
                            <input type="number" name="lead_time" class="form-control" value="<?php echo $lead_time_dias; ?>" min="1">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fas fa-shield-alt me-1"></i>Stock Seguridad</label>
                            <input type="number" name="stock_seguridad" class="form-control" value="<?php echo $stock_seguridad; ?>" min="0">
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-1"></i> Guardar Parámetros
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="text-center py-5">
        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
        <h4>Selecciona un producto para comenzar</h4>
    </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#productoSelect').select2({
            theme: 'bootstrap-5',
            placeholder: 'Ej: Pantalón Comando 32...',
            allowClear: true,
            width: '100%'
        });

        $('#applyBtn').on('click', function() {
            const val = $('#productoSelect').val();
            if (!val) { alert('Selecciona un producto'); return; }
            const [idProd, idTalla] = val.split('-');
            const dias = $('#diasInput').val();
            window.location.href = `?id_producto=${idProd}&id_talla=${idTalla}&dias=${dias}`;
        });

        <?php if ($producto_data): ?>
        const ctx = document.getElementById('historialChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo $json_labels_hist; ?>,
                datasets: [{
                    label: 'Salidas Diarias',
                    data: <?php echo $json_data_salidas; ?>,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.05)',
                    borderWidth: 3,
                    tension: 0.3,
                    fill: true,
                    pointRadius: 3
                }, {
                    label: 'Punto Reorden (<?php echo $punto_reorden_calculado; ?>)',
                    data: new Array(<?php echo count($labels_historial); ?>).fill(<?php echo $punto_reorden_calculado; ?>),
                    borderColor: '#ef4444',
                    borderWidth: 2,
                    borderDash: [8,6],
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Unidades' } }
                }
            }
        });
        <?php endif; ?>
    });
</script>
</body>
</html>