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
                        <i class="fas fa-database me-2 text-turquoise"></i>
                        Gestión de Respaldos de Base de Datos
                    </h1>
                </div>
                <button id="BtnRespaldoDB" class="btn btn-primary">
                    <i class="fas fa-file-export me-1"></i> Crear Respaldo
                </button>
            </div>
        </div>
    </div>

    <!-- Tabla de respaldos -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-navy text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>
                            Archivos de Respaldo Disponibles
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
                                            <input class="form-check-input" type="checkbox" id="selectAllBackups">
                                        </div>
                                    </th>
                                    <th class="py-3 px-4 border-bottom border-navy text-navy">
                                        <i class="fas fa-file me-2"></i>Archivo
                                    </th>
                                    <th class="py-3 px-4 border-bottom border-navy text-navy">
                                        <i class="fas fa-calendar-alt me-2"></i>Fecha de Creación
                                    </th>
                                    <th class="py-3 px-4 border-bottom border-navy text-navy">
                                        <i class="fas fa-ruler me-2"></i>Tamaño
                                    </th>
                                    <th class="py-3 px-4 border-bottom border-navy text-navy">
                                        <i class="fas fa-info-circle me-2"></i>Información
                                    </th>
                                    <th width="150" class="py-3 px-4 border-bottom border-navy text-navy text-center">
                                        <i class="fas fa-cogs me-2"></i>Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Configura la localización a español
                                setlocale(LC_ALL, 'es_ES');
                                date_default_timezone_set('America/Mexico_City');
                                
                                $carpeta_backups = '../../Modelo/backups';
                                
                                // Obtener archivos
                                $archivos = array_diff(scandir($carpeta_backups), array('.', '..'));
                                $archivos = array_filter($archivos, function($archivo) use ($carpeta_backups) {
                                    return is_file($carpeta_backups . '/' . $archivo);
                                });
                                
                                // Ordenar por fecha de modificación (más reciente primero)
                                usort($archivos, function($a, $b) use ($carpeta_backups) {
                                    return filemtime($carpeta_backups . '/' . $b) - filemtime($carpeta_backups . '/' . $a);
                                });
                                
                                // Paginación
                                $records_per_page = 10;
                                $total_records = count($archivos);
                                $total_pages = ceil($total_records / $records_per_page);
                                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                                $page = max(1, min($total_pages, $page));
                                $offset = ($page - 1) * $records_per_page;
                                $archivos_paginados = array_slice($archivos, $offset, $records_per_page);
                                
                                if (count($archivos_paginados) > 0):
                                    foreach ($archivos_paginados as $archivo):
                                        $rutaArchivo = $carpeta_backups . '/' . $archivo;
                                        $tamano = filesize($rutaArchivo);
                                        $fechaModificacion = filemtime($rutaArchivo);
                                        $extension = pathinfo($archivo, PATHINFO_EXTENSION);
                                        
                                        // Determinar tipo de archivo
                                        $tipoArchivo = getFileType($extension);
                                        $iconoArchivo = getFileIcon($extension);
                                        $colorArchivo = getFileColor($extension);
                                ?>
                                <tr class="border-bottom border-light">
                                    <td class="py-3 px-4">
                                        <div class="form-check">
                                            <input class="form-check-input backup-checkbox" type="checkbox" value="<?php echo urlencode($archivo); ?>">
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3">
                                                <div class="avatar-title rounded-circle" style="background-color: <?php echo $colorArchivo; ?>; color: white;">
                                                    <i class="<?php echo $iconoArchivo; ?>"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-navy">
                                                    <?php echo htmlspecialchars($archivo); ?>
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-file-alt me-1"></i>
                                                    <?php echo $tipoArchivo; ?>
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3">
                                                <div class="avatar-title bg-light text-navy border border-navy rounded-circle">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-navy">
                                                    <?php echo date("d/m/Y", $fechaModificacion); ?>
                                                </h6>
                                                <small class="text-muted">
                                                    <?php echo date("H:i:s", $fechaModificacion); ?>
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="badge bg-light text-navy border border-navy">
                                            <i class="fas fa-weight-hanging me-1"></i>
                                            <?php echo formatSizeUnits($tamano); ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="d-flex flex-wrap gap-1">
                                            <span class="badge bg-turquoise text-navy">
                                                <i class="fas fa-database me-1"></i>MySQL
                                            </span>
                                            <span class="badge bg-light text-navy border border-navy">
                                                <i class="fas fa-code me-1"></i>SQL
                                            </span>
                                            <?php if ($fechaModificacion > strtotime('-1 day')): ?>
                                            <span class="badge bg-success">
                                                <i class="fas fa-star me-1"></i>Reciente
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Botón Restaurar -->
                                            <button class="btn btn-sm btn-outline-turquoise" onclick="confirmarRestauracion('<?php echo urlencode($archivo); ?>')" title="Restaurar base de datos">
                                                <i class="fas fa-redo"></i>
                                            </button>
                                            
                                            <!-- Botón Eliminar -->
                                            <button class="btn btn-sm btn-outline-danger" onclick="confirmarEliminacion('<?php echo urlencode($archivo); ?>')" title="Eliminar archivo">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    endforeach;
                                else:
                                ?>
                                <tr>
                                    <td colspan="6" class="py-5 text-center">
                                        <div class="empty-state">
                                            <i class="fas fa-database fa-3x text-muted mb-3"></i>
                                            <h5 class="text-navy">No hay respaldos disponibles</h5>
                                            <p class="text-muted mb-3">
                                                No se encontraron archivos de respaldo en el sistema.
                                                Crea tu primer respaldo para comenzar.
                                            </p>
                                            <button id="BtnRespaldoDB" class="btn btn-primary">
                                                <i class="fas fa-file-export me-1"></i> Crear primer respaldo
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pie de tabla con acciones múltiples -->
                    <?php if (count($archivos_paginados) > 0): ?>
                    <div class="card-footer bg-white border-top border-navy">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Mostrando <strong><?php echo count($archivos_paginados); ?></strong> 
                                de <strong><?php echo $total_records; ?></strong> archivos
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Paginación -->
    <?php if ($total_pages > 1): ?>
    <div class="row mt-4">
        <div class="col-12">
            <nav aria-label="Paginación de respaldos">
                <ul class="pagination justify-content-center mb-0">
                    <!-- Primera página -->
                    <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                        <a class="page-link text-navy" href="?page=1">
                            <i class="fas fa-angle-double-left"></i>
                        </a>
                    </li>
                    
                    <!-- Página anterior -->
                    <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                        <a class="page-link text-navy" href="?page=<?php echo $page - 1; ?>">
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
                        <a class="page-link text-navy" href="?page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                    
                    <!-- Página siguiente -->
                    <li class="page-item <?php echo $page == $total_pages ? 'disabled' : ''; ?>">
                        <a class="page-link text-navy" href="?page=<?php echo $page + 1; ?>">
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </li>
                    
                    <!-- Última página -->
                    <li class="page-item <?php echo $page == $total_pages ? 'disabled' : ''; ?>">
                        <a class="page-link text-navy" href="?page=<?php echo $total_pages; ?>">
                            <i class="fas fa-angle-double-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Información adicional -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="alert alert-info bg-light border-navy">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle fa-2x text-turquoise me-3"></i>
                    <div>
                        <h6 class="mb-1 text-navy">Información importante sobre respaldos</h6>
                        <ul class="mb-0 text-muted small">
                            <li>Los respaldos se guardan automáticamente en la carpeta <code>Modelo/backups</code></li>
                            <li>Recomendamos mantener al menos los últimos 7 días de respaldos</li>
                            <li>Verifica regularmente la integridad de los archivos</li>
                            <li>Los archivos más antiguos se eliminan automáticamente después de 30 días</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Funciones PHP auxiliares -->
<?php
function getFileType($extension) {
    switch(strtolower($extension)) {
        case 'sql': return 'Archivo SQL';
        case 'zip': return 'Archivo comprimido';
        case 'gz': return 'Archivo GZIP';
        case 'tar': return 'Archivo TAR';
        default: return 'Archivo de respaldo';
    }
}

function getFileIcon($extension) {
    switch(strtolower($extension)) {
        case 'sql': return 'fas fa-database';
        case 'zip': return 'fas fa-file-archive';
        case 'gz': case 'tar': return 'fas fa-file-compress';
        default: return 'fas fa-file';
    }
}

function getFileColor($extension) {
    switch(strtolower($extension)) {
        case 'sql': return '#3498db';
        case 'zip': return '#9b59b6';
        case 'gz': return '#e74c3c';
        case 'tar': return '#f39c12';
        default: return '#001F3F';
    }
}

function formatSizeUnits($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        return $bytes . ' bytes';
    } elseif ($bytes == 1) {
        return $bytes . ' byte';
    } else {
        return '0 bytes';
    }
}
?>

<!-- JavaScript Personalizado -->
<script src="../../js/Tablas/Tabla_Respaldo_BD.js"></script>
<script src="../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_RespdaldoDB.js"></script>
<script src="../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_RestauracionDB.js"></script>
<script src="../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_BtnDeletedDB.js"></script>

<?php include('footer.php'); ?>