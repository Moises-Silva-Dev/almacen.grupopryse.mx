<?php include('head.php'); ?>

<!-- CSS Personalizado -->
<link rel="stylesheet" href="../../css/diseno_tablas_general.css">

<div class="container-fluid py-4">
    <!-- Encabezado -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-navy">
                        <i class="fas fa-clipboard-list me-2 text-turquoise"></i>
                        Estado de Requisiciones
                    </h1>
                </div>
                <button class="btn btn-turquoise" onclick="refreshPage()">
                    <i class="fas fa-sync-alt me-1"></i> Actualizar
                </button>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-navy text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-filter me-2"></i>
                        Filtros de Búsqueda
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="GET" action="" class="row g-3" id="filterForm">
                        <div class="col-md-6 col-lg-4">
                            <label for="cuenta" class="form-label text-navy">
                                <i class="fas fa-building me-1"></i> Seleccionar Cuenta
                            </label>
                            <select class="form-select form-select-lg border-navy" id="cuenta" name="cuenta" required>
                                <option value="" disabled selected>-- Selecciona una cuenta --</option>
                                <?php
                                try {
                                    $conexion = (new Conectar())->conexion();
                                    $sqlCuentas = "SELECT ID, NombreCuenta FROM Cuenta ORDER BY NombreCuenta ASC";
                                    $resultCuentas = $conexion->query($sqlCuentas);
                                    
                                    if ($resultCuentas === false) {
                                        throw new Exception("Error al obtener las cuentas: " . $conexion->error);
                                    }
                                    
                                    $selectedCuenta = $_GET['cuenta'] ?? '';
                                    
                                    while ($rowC = $resultCuentas->fetch_assoc()) {
                                        $selected = ($selectedCuenta == $rowC['ID']) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($rowC['ID']) . '" ' . $selected . '>' 
                                            . htmlspecialchars($rowC['NombreCuenta']) . '</option>';
                                    }
                                } catch (Exception $e) {
                                    error_log("Error en el sistema: " . $e->getMessage());
                                    echo '<option value="">Error al cargar cuentas</option>';
                                } finally {
                                    if (isset($conexion)) $conexion->close();
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6 col-lg-3">
                            <label for="estatus" class="form-label text-navy">
                                <i class="fas fa-tag me-1"></i> Filtrar por Estatus
                            </label>
                            <select class="form-select form-select-lg border-navy" id="estatus" name="estatus">
                                <option value="">Todos los estatus</option>
                                <?php
                                $estatusOptions = [
                                    'Pendiente' => 'Pendiente',
                                    'Autorizado' => 'Autorizado',
                                    'Parcial' => 'Parcial',
                                    'Surtido' => 'Surtido'
                                ];
                                
                                $selectedEstatus = $_GET['estatus'] ?? '';
                                
                                foreach ($estatusOptions as $value => $label) {
                                    $selected = ($selectedEstatus == $value) ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($value) . '" ' . $selected . '>' 
                                        . htmlspecialchars($label) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6 col-lg-2 d-flex align-items-end">
                            <div class="d-grid w-100">
                                <button type="submit" class="btn btn-navy btn-lg">
                                    <i class="fas fa-search me-1"></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <?php if (isset($_GET['cuenta']) && !empty($_GET['cuenta'])): ?>
                    <div class="mt-3">
                        <div class="alert alert-light border-navy d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-info-circle text-turquoise me-2"></i>
                                <small class="text-muted">
                                    Filtros activos: 
                                    <span class="badge bg-navy me-2">Cuenta: <?php echo htmlspecialchars($selectedCuenta); ?></span>
                                    <?php if (!empty($selectedEstatus)): ?>
                                    <span class="badge bg-turquoise me-2">Estatus: <?php echo htmlspecialchars($selectedEstatus); ?></span>
                                    <?php endif; ?>
                                </small>
                            </div>
                            <a href="?" class="btn btn-sm btn-outline-navy">
                                <i class="fas fa-times me-1"></i> Limpiar filtros
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de requisiciones -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-navy text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>
                            Lista de Requisiciones
                            <?php if (isset($total_rows)): ?>
                            <small class="ms-2 opacity-75">(<?php echo $total_rows; ?> registros)</small>
                            <?php endif; ?>
                        </h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="tablaSolicitudes">
                            <thead class="table-light">
                                <tr>
                                    <th width="60" class="py-3 px-4 border-bottom border-navy"># ID</th>
                                    <th class="py-3 px-4 border-bottom border-navy text-navy">
                                        <i class="fas fa-user me-2"></i>Solicitante
                                    </th>
                                    <th class="py-3 px-4 border-bottom border-navy text-navy">
                                        <i class="fas fa-calendar me-2"></i>Fecha
                                    </th>
                                    <th class="py-3 px-4 border-bottom border-navy text-navy">
                                        <i class="fas fa-tag me-2"></i>Estatus
                                    </th>
                                    <th class="py-3 px-4 border-bottom border-navy text-navy">
                                        <i class="fas fa-building me-2"></i>Cuenta
                                    </th>
                                    <th class="py-3 px-4 border-bottom border-navy text-navy">
                                        <i class="fas fa-user-check me-2"></i>Receptor
                                    </th>
                                    <th width="180" class="py-3 px-4 border-bottom border-navy text-navy text-center">
                                        <i class="fas fa-cogs me-2"></i>Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_GET['cuenta']) && !empty($_GET['cuenta'])):
                                    try {
                                        $conexion = (new Conectar())->conexion();
                                        $cuenta_filtro = (int)$_GET['cuenta'];
                                        $estatus_filtro = $_GET['estatus'] ?? '';
                                        
                                        $records_per_page = 10;
                                        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                                        $offset = ($page - 1) * $records_per_page;

                                        // Consulta principal
                                        $sql = "SELECT RE.IDRequisicionE, U.Nombre, U.Apellido_Paterno, U.Apellido_Materno,
                                                    DATE(RE.FchCreacion) AS Fecha, RE.Estatus, C.NombreCuenta, RE.Receptor, RE.Estatus
                                                FROM RequisicionE RE
                                                INNER JOIN Usuario U ON RE.IdUsuario = U.ID_Usuario
                                                INNER JOIN Cuenta C ON RE.IdCuenta = C.ID
                                                WHERE RE.IdCuenta = ?";
                                        
                                        $params = [$cuenta_filtro];
                                        $types = "i";
                                        
                                        // Agregar filtro por estatus
                                        if (!empty($estatus_filtro)) {
                                            $sql .= " AND RE.Estatus = ?";
                                            $params[] = $estatus_filtro;
                                            $types .= "s";
                                        }
                                        
                                        // Agregar paginación
                                        $sql .= " ORDER BY RE.FchCreacion DESC LIMIT ? OFFSET ?";
                                        $params[] = $records_per_page;
                                        $params[] = $offset;
                                        $types .= "ii";

                                        $stmt = $conexion->prepare($sql);
                                        $stmt->bind_param($types, ...$params);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        
                                        // Contadores para estadísticas
                                        $pendientes = 0;
                                        $autorizadas = 0;
                                        $surtidas = 0;

                                        if ($result->num_rows > 0):
                                            while ($row = $result->fetch_assoc()):
                                                // Actualizar contadores
                                                switch ($row['Estatus']) {
                                                    case 'Pendiente': $pendientes++; break;
                                                    case 'Autorizado': $autorizadas++; break;
                                                    case 'Surtido': $surtidas++; break;
                                                }
                                                
                                                $IDRequisicionE = htmlspecialchars($row['IDRequisicionE']);
                                                $NombreCompleto = htmlspecialchars($row['Nombre'] . ' ' . $row['Apellido_Paterno'] . ' ' . $row['Apellido_Materno']);
                                                $FchCreacion = htmlspecialchars($row['Fecha']);
                                                $Estatus = htmlspecialchars($row['Estatus']);
                                                $NombreCuenta = htmlspecialchars($row['NombreCuenta']);
                                                $Receptor = htmlspecialchars($row['Receptor']);
                                                
                                                // Determinar clase CSS según estatus
                                                $estatusClass = '';
                                                $estatusBadge = '';
                                                switch ($Estatus) {
                                                    case 'Pendiente':
                                                        $estatusClass = 'bg-warning text-dark';
                                                        $estatusBadge = 'warning';
                                                        break;
                                                    case 'Autorizado':
                                                        $estatusClass = 'bg-success text-white';
                                                        $estatusBadge = 'success';
                                                        break;
                                                    case 'Parcial':
                                                        $estatusClass = 'bg-info text-white';
                                                        $estatusBadge = 'info';
                                                        break;
                                                    case 'Surtido':
                                                        $estatusClass = 'bg-primary text-white';
                                                        $estatusBadge = 'primary';
                                                        break;
                                                    default:
                                                        $estatusClass = 'bg-light text-dark';
                                                        $estatusBadge = 'secondary';
                                                }
                                ?>
                                <tr class="border-bottom border-light">
                                    <td class="py-3 px-4">
                                        <span class="badge bg-navy rounded-pill">#<?php echo $IDRequisicionE; ?></span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3">
                                                <div class="avatar-title bg-turquoise text-white rounded-circle">
                                                    <?php echo strtoupper(substr($row['Nombre'], 0, 1) . substr($row['Apellido_Paterno'], 0, 1)); ?>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-navy"><?php echo $NombreCompleto; ?></h6>
                                                <small class="text-muted">Solicitante</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-navy">
                                            <i class="fas fa-calendar-day me-1 text-turquoise"></i>
                                            <?php echo date('d/m/Y', strtotime($FchCreacion)); ?>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="badge bg-<?php echo $estatusBadge; ?>">
                                            <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                            <?php echo $Estatus; ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="badge bg-light text-navy border border-navy">
                                            <i class="fas fa-building me-1"></i>
                                            <?php echo $NombreCuenta; ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="text-navy">
                                            <i class="fas fa-user-check me-1 text-turquoise"></i>
                                            <?php echo $Receptor; ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Botón Ver Detalles -->
                                            <button class="btn btn-sm btn-outline-navy" onclick="mostrarInfoRequisicion(<?php echo $IDRequisicionE; ?>)" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            
                                            <!-- Botón Descargar -->
                                            <button type="button" class="btn btn-sm btn-outline-danger BtnDescargarRequisicion" data-id="<?php echo $IDRequisicionE; ?>" title="Descargar requisición">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                            endwhile;
                                        else:
                                ?>
                                <tr>
                                    <td colspan="8" class="py-5 text-center">
                                        <div class="empty-state">
                                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                            <h5 class="text-navy">No se encontraron requisiciones</h5>
                                            <p class="text-muted">
                                                No hay requisiciones con los filtros seleccionados.
                                            </p>
                                            <a href="?" class="btn btn-navy">
                                                <i class="fas fa-times me-1"></i> Limpiar filtros
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                        endif;

                                        // Consulta para total de registros
                                        $sql_total = "SELECT COUNT(*) AS total FROM RequisicionE RE 
                                                    INNER JOIN Cuenta C ON RE.IdCuenta = C.ID 
                                                    WHERE RE.IdCuenta = ?";
                                        
                                        $params_total = [$cuenta_filtro];
                                        $types_total = "i";
                                        
                                        if (!empty($estatus_filtro)) {
                                            $sql_total .= " AND RE.Estatus = ?";
                                            $params_total[] = $estatus_filtro;
                                            $types_total .= "s";
                                        }
                                        
                                        $stmt_total = $conexion->prepare($sql_total);
                                        $stmt_total->bind_param($types_total, ...$params_total);
                                        $stmt_total->execute();
                                        $result_total = $stmt_total->get_result();
                                        $total_rows = $result_total->fetch_assoc()['total'];
                                        $total_pages = ceil($total_rows / $records_per_page);

                                        $stmt->close();
                                        $stmt_total->close();
                                        
                                    } catch (Exception $e) {
                                        error_log("Error en el sistema: " . $e->getMessage());
                                        echo '<tr><td colspan="8" class="py-5 text-center">
                                                <div class="alert alert-danger">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                                    Ocurrió un error al procesar la solicitud.
                                                </div>
                                            </td></tr>';
                                    }
                                else:
                                ?>
                                <tr>
                                    <td colspan="8" class="py-5 text-center">
                                        <div class="empty-state">
                                            <i class="fas fa-filter fa-3x text-muted mb-3"></i>
                                            <h5 class="text-navy">Selecciona una cuenta</h5>
                                            <p class="text-muted">
                                                Por favor, selecciona una cuenta para ver las requisiciones.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación -->
                    <?php if (isset($total_pages) && $total_pages > 1): ?>
                    <div class="card-footer bg-white border-top border-navy">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <div class="mb-2 mb-md-0">
                                <small class="text-muted">
                                    Mostrando 
                                    <strong><?php echo min($records_per_page, ($result->num_rows ?? 0)); ?></strong> 
                                    de <strong><?php echo $total_rows ?? 0; ?></strong> requisiciones
                                </small>
                            </div>
                            
                            <nav aria-label="Paginación de requisiciones" class="mb-2 mb-md-0">
                                <ul class="pagination pagination-sm mb-0">
                                    <?php
                                    // Construir parámetros de URL para paginación
                                    $urlParams = [];
                                    if (!empty($cuenta_filtro)) $urlParams['cuenta'] = $cuenta_filtro;
                                    if (!empty($estatus_filtro)) $urlParams['estatus'] = $estatus_filtro;
                                    $queryString = http_build_query($urlParams);
                                    ?>
                                    
                                    <!-- Primera página -->
                                    <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link text-navy" href="?page=1<?php echo $queryString ? '&' . $queryString : ''; ?>">
                                            <i class="fas fa-angle-double-left"></i>
                                        </a>
                                    </li>
                                    
                                    <!-- Página anterior -->
                                    <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link text-navy" href="?page=<?php echo $page - 1; ?><?php echo $queryString ? '&' . $queryString : ''; ?>">
                                            <i class="fas fa-angle-left"></i>
                                        </a>
                                    </li>
                                    
                                    <!-- Números de página -->
                                    <?php
                                    $start = max(1, $page - 2);
                                    $end = min($total_pages, $page + 2);
                                    
                                    for ($i = $start; $i <= $end; $i++):
                                        $active = $i == $page ? 'active bg-navy' : '';
                                    ?>
                                    <li class="page-item <?php echo $active; ?>">
                                        <a class="page-link text-navy" href="?page=<?php echo $i; ?><?php echo $queryString ? '&' . $queryString : ''; ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                    <?php endfor; ?>
                                    
                                    <!-- Página siguiente -->
                                    <li class="page-item <?php echo $page == $total_pages ? 'disabled' : ''; ?>">
                                        <a class="page-link text-navy" href="?page=<?php echo $page + 1; ?><?php echo $queryString ? '&' . $queryString : ''; ?>">
                                            <i class="fas fa-angle-right"></i>
                                        </a>
                                    </li>
                                    
                                    <!-- Última página -->
                                    <li class="page-item <?php echo $page == $total_pages ? 'disabled' : ''; ?>">
                                        <a class="page-link text-navy" href="?page=<?php echo $total_pages; ?><?php echo $queryString ? '&' . $queryString : ''; ?>">
                                            <i class="fas fa-angle-double-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                            
                            <!-- Selector de página -->
                            <div class="d-flex align-items-center">
                                <small class="me-2 text-muted d-none d-md-inline">Ir a:</small>
                                <select class="form-select form-select-sm w-auto" 
                                        onchange="goToPage(this.value)"
                                        id="pageSelector">
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php echo $i == $page ? 'selected' : ''; ?>>
                                        Página <?php echo $i; ?>
                                    </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para detalles de requisición -->
<div class="modal fade" id="requisicionModal" tabindex="-1" aria-labelledby="requisicionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title" id="requisicionModalLabel">
                    <i class="fas fa-clipboard-list me-2"></i>
                    Detalles de la Requisición
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-light text-navy">
                                <h6 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Información General
                                </h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th><i class="fas fa-user me-2 text-turquoise"></i>Solicitante:</th>
                                            <td id="infoSupervisor"></td>
                                        </tr>
                                        <tr>
                                            <th><i class="fas fa-building me-2 text-turquoise"></i>Cuenta:</th>
                                            <td id="infoCuenta"></td>
                                        </tr>
                                        <tr>
                                            <th><i class="fas fa-building me-2 text-turquoise"></i>Región:</th>
                                            <td id="infoRegion"></td>
                                        </tr>
                                        <tr>
                                            <th><i class="fas fa-map-marker-alt me-2 text-turquoise"></i>Centro de Trabajo:</th>
                                            <td id="infoCentroTrabajo"></td>
                                        </tr>
                                        <tr>
                                            <th><i class="fas fa-map-marker-alt me-2 text-turquoise"></i>Número de Elementos:</th>
                                            <td id="infoElementos"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-light text-navy">
                                <h6 class="mb-0">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    Información Adicional
                                </h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th><i class="fas fa-user-check me-2 text-turquoise"></i>Receptor:</th>
                                            <td id="infoReceptor"></td>
                                        </tr>
                                        <tr>
                                            <th><i class="fas fa-phone me-2 text-turquoise"></i>Teléfono Receptor:</th>
                                            <td id="infoTelReceptor"></td>
                                        </tr>
                                        <tr>
                                            <th><i class="fas fa-id-card me-2 text-turquoise"></i>RFC Receptor:</th>
                                            <td id="infoRfcReceptor"></td>
                                        </tr>
                                        <tr>
                                            <th><i class="fas fa-map me-2 text-turquoise"></i>Justificación:</th>
                                            <td id="infoJustificacion"></td>
                                        </tr>
                                        <tr>
                                            <th><i class="fas fa-map me-2 text-turquoise"></i>Dirección:</th>
                                            <td id="infoDireccion"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light text-navy">
                        <h6 class="mb-0">
                            <i class="fas fa-boxes me-2"></i>
                            Productos Solicitados
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                </thead>
                                <tbody id="productosBody">
                                    <!-- Productos se cargarán aquí -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="../../js/DescargarRequisicion.js"></script>
<script src="../../js/MostrarInfoRequisicion.js"></script>

<?php include('footer.php'); ?>