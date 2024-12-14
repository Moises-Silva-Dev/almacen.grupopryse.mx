<?php include('head.php'); ?>

<center><div class="container">
    <h2>Archivos de respaldo</h2>
    <a class="btn btn-primary" href="../../Modelo/Respaldo.php">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-sql" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
            <path d="M5 20.25c0 .414 .336 .75 .75 .75h1.25a1 1 0 0 0 1 -1v-1a1 1 0 0 0 -1 -1h-1a1 1 0 0 1 -1 -1v-1a1 1 0 0 1 1 -1h1.25a.75 .75 0 0 1 .75 .75" />
            <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
            <path d="M18 15v6h2" />
            <path d="M13 15a2 2 0 0 1 2 2v2a2 2 0 1 1 -4 0v-2a2 2 0 0 1 2 -2z" />
            <path d="M14 20l1.5 1.5" />
        </svg>Hacer un Respaldo</a>
<?php
    // Configura la localización a español
    setlocale(LC_ALL, 'es_ES');
    // Configura la zona horaria a Ciudad de México
    date_default_timezone_set('America/Mexico_City');
    
    $carpeta_backups = '../../Modelo/backups'; // Cambia esto al nombre de tu carpeta de respaldos
    
    // Obtener la lista de archivos en la carpeta de respaldos, excluyendo '.' y '..'
    $archivos = array_diff(scandir($carpeta_backups), array('.', '..'));
    
    // Filtrar solo archivos (excluir directorios)
    $archivos = array_filter($archivos, function($archivo) use ($carpeta_backups) {
        return is_file($carpeta_backups . '/' . $archivo);
    });
    
    // Ordenar archivos por fecha de modificación, más reciente primero
    usort($archivos, function($a, $b) use ($carpeta_backups) {
        return filemtime($carpeta_backups . '/' . $b) - filemtime($carpeta_backups . '/' . $a);
    });
    
    // Parámetros para la paginación
    $records_per_page = 10;
    $total_records = count($archivos);
    $total_pages = ceil($total_records / $records_per_page);
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max(1, min($total_pages, $page)); // Asegurarse de que la página esté dentro del rango
    $offset = ($page - 1) * $records_per_page;
    
    // Obtener el conjunto de archivos para la página actual
    $archivos_paginados = array_slice($archivos, $offset, $records_per_page);
?>

<table class="table table-hover table-striped mt-4">
    <thead>
        <tr class="table-primary">
            <th>Nombre de Archivo y Fecha</th>
            <th>Restaurar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($archivos_paginados as $archivo): ?>
            <tr>
                <td><?php echo $archivo . ' - ' . date("F d Y H:i:s.", filemtime($carpeta_backups . '/' . $archivo)); ?></td>
                <td>
                    <a href="../../Modelo/Restauracion.php?archivo=<?php echo urlencode($archivo); ?>" class="btn btn-success btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-restore" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M3.06 13a9 9 0 1 0 .49 -4.087" />
                            <path d="M3 4.001v5h5" />
                            <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                        </svg>Restaurar
                    </a>
                </td>
                <td>
                    <a onclick="return eliminar()" href="../../Controlador/ADMIN/DELETE/Funcion_Delete_SQL.php?archivo=<?php echo urlencode($archivo); ?>" class="btn btn-danger btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 7h16" />
                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            <path d="M10 12l4 4m0 -4l-4 4" />
                        </svg>Eliminar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
</div>

<?php include('footer.php'); ?>