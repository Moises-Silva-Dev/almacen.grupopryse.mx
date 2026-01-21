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
                        <i class="fas fa-map-marked-alt me-2 text-turquoise"></i>
                        Gestión de Regiones
                    </h1>
                    <p class="text-muted mb-0">Administra las regiones asociadas a las cuentas</p>
                </div>
                <a href="INSERT/Insert_Region_Dev.php" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-1"></i> Nueva Región
                </a>
            </div>
        </div>
    </div>

    <!-- Filtro de cuenta -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form method="GET" action="" id="filterForm">
                        <div class="row align-items-center">
                            <div class="col-lg-8 mb-3 mb-lg-0">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="cuenta" class="form-label fw-semibold text-navy">
                                            <i class="fas fa-filter me-1"></i> Filtrar por cuenta:
                                        </label>
                                        <select class="form-select form-select-lg border-navy" 
                                                id="cuenta" 
                                                name="cuenta"
                                                onchange="this.form.submit()">
                                            <option value="">-- Seleccionar cuenta --</option>
                                            <?php
                                            try {
                                                $conexion = (new Conectar())->conexion();
                                                $sqlCuentas = "SELECT ID, NombreCuenta FROM Cuenta ORDER BY NombreCuenta";
                                                $resultCuentas = $conexion->query($sqlCuentas);
                                                
                                                $selectedCuenta = isset($_GET['cuenta']) ? (int)$_GET['cuenta'] : 0;
                                                
                                                while ($rowC = $resultCuentas->fetch_assoc()) {
                                                    $selected = $rowC['ID'] == $selectedCuenta ? 'selected' : '';
                                                    echo '<option value="' . $rowC['ID'] . '" ' . $selected . '>' . htmlspecialchars($rowC['NombreCuenta']) . '</option>';
                                                }
                                            } catch (Exception $e) {
                                                error_log("Error al cargar cuentas: " . $e->getMessage());
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-lg-end">
                                <div class="d-flex align-items-center justify-content-lg-end">
                                    <?php if (isset($_GET['cuenta']) && !empty($_GET['cuenta'])): ?>
                                    <div class="me-3">
                                        <button type="button" class="btn btn-outline-navy" onclick="clearFilter()" title="Limpiar filtros">
                                            <i class="fas fa-times me-1"></i> Limpiar
                                        </button>
                                    </div>
                                    <?php endif; ?>
                                    <button class="btn btn-outline-navy" onclick="refreshPage()" title="Refrescar">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (isset($_GET['cuenta']) && !empty($_GET['cuenta'])): 
                            $cuentaNombre = "";
                            if (isset($conexion)) {
                                $stmt = $conexion->prepare("SELECT NombreCuenta FROM Cuenta WHERE ID = ?");
                                $stmt->bind_param("i", $_GET['cuenta']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($row = $result->fetch_assoc()) {
                                    $cuentaNombre = $row['NombreCuenta'];
                                }
                            }
                        ?>
                        <div class="mt-3">
                            <div class="alert alert-info bg-light border-navy py-2 mb-0">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle me-2 text-turquoise"></i>
                                    <div>
                                        <strong>Filtro activo:</strong> Mostrando regiones de 
                                        <span class="badge bg-navy ms-1"><?php echo htmlspecialchars($cuentaNombre); ?></span>
                                        <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                                        y que coincidan con 
                                        <span class="badge bg-turquoise text-navy ms-1">"<?php echo htmlspecialchars($_GET['search']); ?>"</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de regiones -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-navy text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>
                            Lista de Regiones
                        </h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="50" class="py-3 px-4 border-bottom border-navy">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </div>
                                    </th>
                                    <th class="py-3 px-4 border-bottom border-navy text-navy">
                                        <i class="fas fa-hashtag me-2"></i>ID
                                    </th>
                                    <th class="py-3 px-4 border-bottom border-navy text-navy">
                                        <i class="fas fa-map-marker-alt me-2"></i>Región
                                    </th>
                                    <th class="py-3 px-4 border-bottom border-navy text-navy">
                                        <i class="fas fa-building me-2"></i>Cuenta
                                    </th>
                                    <th width="150" class="py-3 px-4 border-bottom border-navy text-navy text-center">
                                        <i class="fas fa-cogs me-2"></i>Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    $has_records = false;
                                    
                                    if (isset($_GET['cuenta']) && is_numeric($_GET['cuenta'])) {
                                        $cuenta_filtro = (int)$_GET['cuenta'];
                                        
                                        $records_per_page = 10;
                                        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                                        $offset = ($page - 1) * $records_per_page;
                                        
                                        // Construir consulta base
                                        $sql = "SELECT R.ID_Region, R.Nombre_Region, C.NombreCuenta 
                                                FROM Regiones R
                                                INNER JOIN Cuenta_Region CR ON R.ID_Region = CR.ID_Regiones
                                                INNER JOIN Cuenta C ON CR.ID_Cuentas = C.ID
                                                WHERE C.ID = ?";
                                        
                                        // Agregar búsqueda si existe
                                        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
                                        if (!empty($search)) {
                                            $sql .= " AND R.Nombre_Region LIKE ?";
                                        }
                                        
                                        $sql .= " ORDER BY R.Nombre_Region LIMIT ? OFFSET ?";
                                        
                                        $stmt = $conexion->prepare($sql);
                                        
                                        if (!empty($search)) {
                                            $searchTerm = "%$search%";
                                            $stmt->bind_param("isii", $cuenta_filtro, $searchTerm, $records_per_page, $offset);
                                        } else {
                                            $stmt->bind_param("iii", $cuenta_filtro, $records_per_page, $offset);
                                        }
                                        
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        
                                        // Contar total de registros
                                        $sql_total = "SELECT COUNT(*) AS total 
                                                    FROM Regiones R
                                                    INNER JOIN Cuenta_Region CR ON R.ID_Region = CR.ID_Regiones
                                                    INNER JOIN Cuenta C ON CR.ID_Cuentas = C.ID
                                                    WHERE C.ID = ?";
                                                    
                                        if (!empty($search)) {
                                            $sql_total .= " AND R.Nombre_Region LIKE ?";
                                        }
                                        
                                        $stmt_total = $conexion->prepare($sql_total);
                                        
                                        if (!empty($search)) {
                                            $stmt_total->bind_param("is", $cuenta_filtro, $searchTerm);
                                        } else {
                                            $stmt_total->bind_param("i", $cuenta_filtro);
                                        }
                                        
                                        $stmt_total->execute();
                                        $result_total = $stmt_total->get_result();
                                        $total_rows = $result_total->fetch_assoc()['total'];
                                        $total_pages = ceil($total_rows / $records_per_page);
                                        
                                        if ($result->num_rows > 0):
                                            $has_records = true;
                                            while ($row = $result->fetch_assoc()):
                                                $ID_Region = htmlspecialchars($row['ID_Region']);
                                                $Nombre_Region = htmlspecialchars($row['Nombre_Region']);
                                                $NombreCuenta = htmlspecialchars($row['NombreCuenta']);
                                                
                                                // Generar color único basado en el ID
                                                $hue = ($ID_Region * 137) % 360; // Algoritmo para generar colores distintos
                                ?>
                                <tr class="border-bottom border-light">
                                    <td class="py-3 px-4">
                                        <div class="form-check">
                                            <input class="form-check-input region-checkbox" type="checkbox" value="<?php echo $ID_Region; ?>">
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="badge bg-light text-navy border border-navy">
                                            #<?php echo $ID_Region; ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3">
                                                <div class="avatar-title rounded-circle" style="background-color: hsl(<?php echo $hue; ?>, 70%, 85%); color: hsl(<?php echo $hue; ?>, 50%, 30%);">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-navy"><?php echo $Nombre_Region; ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3">
                                                <div class="avatar-title bg-light text-navy border border-navy rounded-circle">
                                                    <i class="fas fa-building"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="fw-semibold text-navy"><?php echo $NombreCuenta; ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Botón Editar -->
                                            <button class="btn btn-sm btn-outline-navy" 
                                                    onclick="editRegion(<?php echo $ID_Region; ?>)"
                                                    title="Editar región">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            
                                            <!-- Botón Eliminar -->
                                            <button class="btn btn-sm btn-outline-danger" onclick="eliminarRegistroRegion(<?php echo $ID_Region; ?>)" title="Eliminar región">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                            endwhile;
                                        else:
                                ?>
                                <tr>
                                    <td colspan="5" class="py-5 text-center">
                                        <div class="empty-state">
                                            <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                                            <h5 class="text-navy">No se encontraron regiones</h5>
                                            <p class="text-muted mb-3">
                                                <?php 
                                                if (isset($_GET['search']) && !empty($_GET['search'])) {
                                                    echo 'No hay regiones que coincidan con tu búsqueda para la cuenta seleccionada.';
                                                } else {
                                                    echo 'No hay regiones registradas para la cuenta seleccionada.';
                                                }
                                                ?>
                                            </p>
                                            <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                                            <button class="btn btn-navy" onclick="clearSearch()">
                                                <i class="fas fa-times me-1"></i> Limpiar búsqueda
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                        endif;
                                    } else {
                                ?>
                                <tr>
                                    <td colspan="5" class="py-5 text-center">
                                        <div class="empty-state">
                                            <i class="fas fa-filter fa-3x text-muted mb-3"></i>
                                            <h5 class="text-navy">Selecciona una cuenta</h5>
                                            <p class="text-muted">Para ver las regiones, primero selecciona una cuenta del filtro.</p>
                                            <div class="mt-3">
                                                <div class="alert alert-warning bg-light border-warning py-2 mb-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                                        <div>
                                                            <small>Selecciona una cuenta del filtro superior para mostrar las regiones asociadas.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    }
                                } catch (Exception $e) {
                                    error_log("Error en el sistema: " . $e->getMessage());
                                ?>
                                <tr>
                                    <td colspan="5" class="py-5 text-center">
                                        <div class="empty-state">
                                            <i class="fas fa-exclamation-circle fa-3x text-danger mb-3"></i>
                                            <h5 class="text-danger">Error del sistema</h5>
                                            <p class="text-muted">Ocurrió un error al cargar las regiones. Por favor, inténtalo de nuevo.</p>
                                            <button class="btn btn-navy" onclick="refreshPage()">
                                                <i class="fas fa-redo me-1"></i> Reintentar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                } finally {
                                    if (isset($stmt)) $stmt->close();
                                    if (isset($stmt_total)) $stmt_total->close();
                                    if (isset($conexion)) $conexion->close();
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación -->
                    <?php if (isset($has_records) && $has_records && isset($total_pages) && $total_pages > 1): ?>
                    <div class="card-footer bg-white border-top border-navy">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <div class="mb-2 mb-md-0">
                                <small class="text-muted">
                                    Mostrando 
                                    <strong><?php echo min($records_per_page, $total_rows); ?></strong> 
                                    de <strong><?php echo $total_rows; ?></strong> regiones
                                    <?php if (isset($cuenta_filtro)): ?>
                                    para la cuenta <strong><?php echo htmlspecialchars($cuentaNombre); ?></strong>
                                    <?php endif; ?>
                                </small>
                            </div>
                            
                            <nav aria-label="Paginación de regiones" class="mb-2 mb-md-0">
                                <ul class="pagination pagination-sm mb-0">
                                    <?php
                                    // Construir URL base con parámetros
                                    $params = [];
                                    if (isset($_GET['cuenta'])) $params[] = 'cuenta=' . urlencode($_GET['cuenta']);
                                    if (isset($_GET['search']) && !empty($_GET['search'])) $params[] = 'search=' . urlencode($_GET['search']);
                                    $queryString = !empty($params) ? '&' . implode('&', $params) : '';
                                    ?>
                                    
                                    <!-- Primera página -->
                                    <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link text-navy" href="?page=1<?php echo $queryString; ?>">
                                            <i class="fas fa-angle-double-left"></i>
                                        </a>
                                    </li>
                                    
                                    <!-- Página anterior -->
                                    <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link text-navy" href="?page=<?php echo $page - 1; ?><?php echo $queryString; ?>">
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
                                        <a class="page-link text-navy" href="?page=<?php echo $i; ?><?php echo $queryString; ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                    <?php endfor; ?>
                                    
                                    <!-- Página siguiente -->
                                    <li class="page-item <?php echo $page == $total_pages ? 'disabled' : ''; ?>">
                                        <a class="page-link text-navy" href="?page=<?php echo $page + 1; ?><?php echo $queryString; ?>">
                                            <i class="fas fa-angle-right"></i>
                                        </a>
                                    </li>
                                    
                                    <!-- Última página -->
                                    <li class="page-item <?php echo $page == $total_pages ? 'disabled' : ''; ?>">
                                        <a class="page-link text-navy" href="?page=<?php echo $total_pages; ?><?php echo $queryString; ?>">
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

<!-- JS Personalizado -->
<script src="../../js/Tablas/Tabla_Region.js"></script>
<script src="../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Eliminar_Region.js"></script>

<?php include('footer.php'); ?>