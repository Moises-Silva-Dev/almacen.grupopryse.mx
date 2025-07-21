<?php include('head.php'); ?>
<style>
    .disabled {
        pointer-events: none;
        opacity: 0.6;
    }
</style>
<!-- Contenedor de las alertas -->            
<div class="table-responsive">    
    <center>
        <h2 class="mb-4">Prestamos Registrados</h2>
    </center>
    <!-- Tabla para mostrar los registros -->
    <table class="table table-hover table-striped mt-4">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre Solicitante</th>
                <th scope="col">Fecha</th>
                <th scope="col">Estatus</th>
                <th scope="col">Justificación</th>
                <th scope="col"><center>Acción</center></th>
            </tr>
        </thead>
        <tbody>
            <?php
                try {
                    $conexion = (new Conectar())->conexion(); // Crear una instancia de la clase Conectar y obtener la conexión
                    $usuario = $_SESSION['usuario']; // Obtener el usuario de la sesión
                    
                    $records_per_page = 10; // Número de registros por página
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Obtener el número de página actual, por defecto es 1
                    $offset = ($page - 1) * $records_per_page; // Calcular el desplazamiento para la paginación
                    
                    // Consulta para obtener las requisiciones
                    $sql = "SELECT 
                            PE.IdPrestamoE, U.Nombre, U.Apellido_Paterno, U.Apellido_Materno,
                            PE.FchCreacion, PE.Justificacion, PE.Estatus
                        FROM 
                            PrestamoE PE
                        INNER JOIN 
                            Usuario U ON PE.IdUsuario = U.ID_Usuario
                        ORDER BY 
                            PE.FchCreacion DESC
                        LIMIT 
                            ? OFFSET ?";

                    $stmt = $conexion->prepare($sql);
                    $stmt->bind_param("ii", $records_per_page, $offset);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Verifica si hay resultados
                    if ($result->num_rows > 0) {
                        // Muestra los resultados en la tabla
                        while ($row = $result->fetch_assoc()) {
                            $IdPrestamoE = htmlspecialchars($row['IdPrestamoE'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $Nombre = htmlspecialchars($row['Nombre'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $Apellido_Paterno = htmlspecialchars($row['Apellido_Paterno'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $Apellido_Materno = htmlspecialchars($row['Apellido_Materno'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $FchCreacion = htmlspecialchars($row['FchCreacion'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $Estatus = htmlspecialchars($row['Estatus'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $Justificacion = htmlspecialchars($row['Justificacion'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $NombreCompleto = $Nombre . ' ' . $Apellido_Paterno . ' ' . $Apellido_Materno; // Concatenar el nombre completo
            ?>
                            <tr class="table-light">
                                <td><?php echo $IdPrestamoE; ?></td>
                                <td><?php echo $NombreCompleto;?></td>
                                <td><?php echo $FchCreacion; ?></td>
                                <td><?php echo $Estatus; ?></td>
                                <td><?php echo $Justificacion; ?></td>
                                <td>
                                    <button class="btn btn-success" onclick="abrirModal(<?php echo $IdPrestamoE; ?>)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24V0H24z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                    </svg>Autorizar</button>
                                </td>
                            </tr>
            <?php
                        }
                    } else {
                        echo "<tr><td colspan='10' class='text-center'>No hay registros</td></tr>";
                    }
                    
                    
                    $sql_total = "SELECT COUNT(*) AS total FROM PrestamoE"; // Total de registros para paginaci��n
                    $stmt_total = $conexion->prepare($sql_total); // Preparar la consulta SQL para el total de registros
                    $stmt_total->execute(); // Ejecutar la consulta
                    $result_total = $stmt_total->get_result(); // Obtener los resultados de la consulta
                    $total_rows = $result_total->fetch_assoc()['total']; // Obtener el total de registros
                    $total_pages = ceil($total_rows / $records_per_page); // Calcular el total de paginas
                } catch (Exception $e) {
                    error_log("Error en el sistema: " . $e->getMessage()); // Registrar el error en el log del servidor
                    echo '<tr><td colspan="8" class="text-center alert alert-danger">Ocurrió un error al procesar la solicitud. Por favor, inténtelo de nuevo más tarde.</td></tr>'; // Mostrar un mensaje de error si ocurre una excepción
                } finally {
                    $stmt->close(); // Cerrar la sentencia preparada
                    $stmt_total->close();
                    $conexion->close(); // Cerrar la conexión a la base de datos
                }
            ?>
        </tbody>
    </table>
    <!-- Paginación -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center flex-wrap text-center">
            <!-- Botón anterior -->
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php
                $range = 2; // Número de páginas a mostrar a cada lado de la página actual
                $show_dots_start = false; // Mostrar puntos suspensivos al inicio
                $show_dots_end = false; // Mostrar puntos suspensivos al final

                if ($page > $range + 2) { // Si la página actual es mayor que el rango más 2
                    echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>'; // Mostrar siempre la primera página
                    $show_dots_start = true; // Mostrar puntos suspensivos al inicio
                }

                if ($show_dots_start) { // Si se deben mostrar puntos suspensivos al inicio
                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>'; // Mostrar puntos suspensivos
                }

                for ($i = max(1, $page - $range); $i <= min($total_pages, $page + $range); $i++) { // Iterar desde la página actual menos el rango hasta la página actual más el rango
                    $active = $i == $page ? 'active' : ''; // Marcar la página actual como activa
                    echo "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>"; // Mostrar el número de página
                }

                if ($page + $range < $total_pages - 1) { // Si la página actual más el rango es menor que la última página menos 1
                    $show_dots_end = true; // Mostrar puntos suspensivos al final
                }

                if ($show_dots_end) { // Si se deben mostrar puntos suspensivos al final
                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>'; // Mostrar puntos suspensivos
                }

                if ($page + $range < $total_pages) { // Si la página actual más el rango es menor que la última página
                    echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . '">' . $total_pages . '</a></li>'; // Mostrar siempre la última página
                }
            ?>
            <!-- Botón siguiente -->
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

<!-- Modal -->
<div id="modalPrestamo" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5);">
    <div style="background:white; margin:10% auto; padding:20px; width:60%; position:relative;">
        <span style="position:absolute; top:10px; right:15px; cursor:pointer;" onclick="cerrarModal()">✖</span>
        <center><h3>Detalle del préstamo</h3></center>
        <div class="table-responsive" id="contenidoPrestamo">
            Cargando datos...
        </div>
        <button id="btnAutorizar" class="btn btn-success" onclick="autorizarPrestamo()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="44" height="44" stroke-width="1.5"> 
                <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path> 
                <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path> 
                <path d="M9 14h.01"></path> <path d="M9 17h.01"></path> 
                <path d="M12 16l1 1l3 -3"></path> 
            </svg>Autorizar
        </button>
    </div>
</div>

<script src="../../js/InvalidarBtnEstatus.js"></script>
<script src="../../js/MostrarInfoPrestamoEAutorizar.js"></script>
<script src="../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Autorizar_Prestamo.js"></script>

<?php include('footer.php'); ?>