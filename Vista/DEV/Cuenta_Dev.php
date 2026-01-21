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
                        <i class="fas fa-users me-2 text-turquoise"></i>
                        Gestión de Cuentas
                    </h1>
                </div>
                <a href="INSERT/Insert_Cuenta_Dev.php" class="btn btn-primary">
                    <i class="fas fa-user-plus me-1"></i> Nueva Cuenta
                </a>
            </div>
        </div>
    </div>

    <!-- Barra de búsqueda -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8 mb-3 mb-md-0">
                            <form method="GET" action="" class="search-form">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-navy border-navy text-white">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg border-navy" name="search" placeholder="Buscar por nombre..." value="<?php echo htmlspecialchars($search ?? ''); ?>" aria-label="Buscar Cuentas">
                                    <?php if (empty($search)): ?>
                                        <button type="button" class="btn btn-outline-secondary border-navy" onclick="clearSearch()" title="Limpiar búsqueda">Limpiar</button>
                                    <?php endif; ?>
                                    <button type="submit" class="btn btn-navy">Buscar</button>
                                </div>
                                <?php if (!empty($search)): ?>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        Resultados para: <strong>"<?php echo htmlspecialchars($search); ?>"</strong>
                                        <a href="?" class="ms-2 text-turquoise text-decoration-none">
                                            <i class="fas fa-times me-1">Limpiar filtro</i>
                                        </a>
                                    </small>
                                </div>
                                <?php endif; ?>
                            </form>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="d-flex align-items-center justify-content-end">
                                <button class="btn btn-outline-navy" onclick="refreshPage()" title="Refrescar">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-navy text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>
                            Lista de Usuarios
                        </h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4 border-bottom border-navy">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </div>
                                    </th>
                                    <th class="py-3 px-4 border-bottom border-navy text-navy">
                                        <i class="fas fa-id-card me-2"></i>ID
                                    </th>
                                    <th class="py-3 px-4 border-bottom border-navy text-navy">
                                        <i class="fas fa-user me-2"></i>Nombre
                                    </th>
                                    <th class="py-3 px-4 border-bottom border-navy text-navy">
                                        <i class="fas fa-envelope me-2"></i>Num. Empleados
                                    </th>
                                    <th class="py-3 px-4 border-bottom border-navy text-navy text-center">
                                        <i class="fas fa-cogs me-2"></i>Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    try {
                                        // En la parte superior del archivo, antes de la consulta principal
                                        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
                                        
                                        // Consulta SQL modificada con búsqueda
                                        $sql = "SELECT * FROM Cuenta C WHERE 1=1";

                                        // Si hay búsqueda, agregar condiciones
                                        if (!empty($search)) {
                                            $searchTerm = "%$search%";
                                            $sql .= " AND (
                                                C.NombreCuenta LIKE ?
                                            )";
                                        }                                 
                                        
                                        $sql .= " GROUP BY C.ID DESC LIMIT ? OFFSET ?";

                                        // Calcular total para paginación (incluyendo búsqueda)
                                        $sql_total = "SELECT COUNT(*) as total FROM Cuenta C";

                                        if (!empty($search)) {
                                            $sql_total .= " WHERE ( 
                                                C.NombreCuenta LIKE ?
                                            )";
                                        }

                                        $conexion = (new Conectar())->conexion();
                                        
                                        $records_per_page = 10;
                                        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                                        $offset = ($page - 1) * $records_per_page;
                                        
                                        // Preparar la consulta principal
                                        $stmt = $conexion->prepare($sql);
                                        
                                        if (!empty($search)) {
                                            $searchTerm = "%$search%";
                                            $stmt->bind_param("sii", 
                                                $searchTerm, $records_per_page, $offset
                                            );
                                        } else {
                                            $stmt->bind_param("ii", $records_per_page, $offset);
                                        }
                                        
                                        $stmt->execute();
                                        $query = $stmt->get_result();
                                        
                                        // Obtener total de registros (con búsqueda si aplica)
                                        $stmt_total = $conexion->prepare($sql_total);
                                        
                                        if (!empty($search)) {
                                            $stmt_total->bind_param("s", $searchTerm);
                                        }
                                        
                                        $stmt_total->execute();
                                        $result_total = $stmt_total->get_result();
                                        $total_rows = $result_total->fetch_assoc()['total'];
                                        $total_pages = ceil($total_rows / $records_per_page);
                                        
                                        if ($query->num_rows > 0):
                                            while ($row = $query->fetch_assoc()):
                                ?>
                                <tr class="border-bottom border-light">
                                    <td class="py-3 px-4">
                                        <div class="form-check">
                                            <input class="form-check-input user-checkbox" type="checkbox" value="<?php echo $row['ID']; ?>">
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="badge bg-navy rounded-pill">#<?php echo $row['ID']; ?></span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="badge bg-light text-navy">
                                            <i class="fas fa-building me-1"></i>
                                            <?php echo htmlspecialchars($row['NombreCuenta']); ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="badge bg-light text-navy">
                                            <i class="fas fa-person me-2 text-turquoise"></i>
                                            <?php echo htmlspecialchars($row['NroElemetos']); ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Botón Editar -->
                                            <button class="btn btn-sm btn-outline-navy" 
                                                    onclick="editUser(<?php echo $row['ID']; ?>)"
                                                    title="Editar usuario">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            
                                            <!-- Botón Eliminar -->
                                            <button class="btn btn-sm btn-outline-danger" href="javascript:void(0);" onclick="eliminarRegistroCuenta(<?php echo $row['ID']; ?>)">
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
                                            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                                            <h5 class="text-navy">No se encontraron usuarios</h5>
                                            <p class="text-muted">
                                                <?php echo !empty($search) ? 
                                                    'No hay resultados para tu búsqueda.' : 
                                                    'No hay usuarios registrados en el sistema.'; ?>
                                            </p>
                                            <?php if (!empty($search)): ?>
                                            <a href="?" class="btn btn-navy">
                                                <i class="fas fa-times me-1"></i> Limpiar búsqueda
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    endif;
                                } catch (Exception $e) {
                                    error_log("Error en el sistema: " . $e->getMessage());
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
                    <?php if ($total_pages > 1): ?>
                    <div class="card-footer bg-white border-top border-navy">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    Mostrando <strong><?php echo min($records_per_page, $total_rows); ?></strong> 
                                    de <strong><?php echo $total_rows; ?></strong> usuarios
                                </small>
                            </div>
                            <nav aria-label="Paginación de usuarios">
                                <ul class="pagination pagination-sm mb-0">
                                    <!-- Primera página -->
                                    <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link text-navy" href="?page=1<?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">
                                            <i class="fas fa-angle-double-left"></i>
                                        </a>
                                    </li>
                                    
                                    <!-- Página anterior -->
                                    <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link text-navy" href="?page=<?php echo $page - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">
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
                                        <a class="page-link text-navy" href="?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                    <?php endfor; ?>
                                    
                                    <!-- Página siguiente -->
                                    <li class="page-item <?php echo $page == $total_pages ? 'disabled' : ''; ?>">
                                        <a class="page-link text-navy" href="?page=<?php echo $page + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">
                                            <i class="fas fa-angle-right"></i>
                                        </a>
                                    </li>
                                    
                                    <!-- Última página -->
                                    <li class="page-item <?php echo $page == $total_pages ? 'disabled' : ''; ?>">
                                        <a class="page-link text-navy" href="?page=<?php echo $total_pages; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">
                                            <i class="fas fa-angle-double-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                            
                            <!-- Selector de página -->
                            <div class="d-flex align-items-center">
                                <small class="me-2 text-muted">Ir a:</small>
                                <select class="form-select form-select-sm w-auto" 
                                        onchange="goToPage(this.value)">
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

<script src="../../js/Tablas/Tabla_Cuenta.js"></script>
<script src="../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Eliminar_Cuenta.js"></script>
    
<?php include('footer.php'); ?>