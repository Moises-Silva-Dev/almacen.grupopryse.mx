<?php include('head.php'); ?>
<!-- Contenedor de las alertas -->            
<div class="table-responsive">    
    <center>
        <h2 class="mb-4">Borradores Registrados</h2>
        <!-- Botones -->
        <a class="btn btn-primary" href="INSERT/Insert_Solicitud_USER.php">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                <path d="M16 19h6" />
                <path d="M19 16v6" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
            </svg>Nuevo Borrador</a>
    </center>
    <!-- Tabla para mostrar los registros -->
    <table id="tablaSolicitudes" class="table table-hover table-striped mt-4">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre Solicitante</th>
                <th scope="col">Fecha</th>
                <th scope="col">Estatus</th>
                <th scope="col">Cuenta</th>
                <th scope="col">Justificación</th>
                <th scope="col">Comentario para Modificación</th>
                <th colspan="2" scope="col"><center>Acciones</center></th>
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
                            BRE.BIDRequisicionE, U.Nombre, U.Apellido_Paterno, U.Apellido_Materno,
                            BRE.BFchCreacion, BRE.BEstatus, C.NombreCuenta, BRE.BCentroTrabajo, 
                            BRE.BJustificacion, BRE.BReceptor, BRE.BComentariosMod 
                        FROM 
                            Borrador_RequisicionE BRE
                        INNER JOIN 
                            Usuario U ON BRE.BIdUsuario = U.ID_Usuario
                        INNER JOIN
                            Cuenta C ON BRE.BIdCuenta = C.ID
                        WHERE 
                            U.Correo_Electronico = ?
                        GROUP BY 
                            BRE.BIDRequisicionE
                        ORDER BY 
                            BRE.BFchCreacion DESC
                        LIMIT 
                            ? OFFSET ?";

                    $stmt = $conexion->prepare($sql);
                    $stmt->bind_param("sii", $usuario, $records_per_page, $offset);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Verifica si hay resultados
                    if ($result->num_rows > 0) {
                        // Muestra los resultados en la tabla
                        while ($row = $result->fetch_assoc()) {
                            $BIDRequisicionE = htmlspecialchars($row['BIDRequisicionE'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $Nombre = htmlspecialchars($row['Nombre'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $Apellido_Paterno = htmlspecialchars($row['Apellido_Paterno'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $Apellido_Materno = htmlspecialchars($row['Apellido_Materno'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $BFchCreacion = htmlspecialchars($row['BFchCreacion'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $BEstatus = htmlspecialchars($row['BEstatus'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $NombreCuenta = htmlspecialchars($row['NombreCuenta'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $BJustificacion = htmlspecialchars($row['BJustificacion'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $BComentariosMod = htmlspecialchars($row['BComentariosMod'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $NombreCompleto = $Nombre . ' ' . $Apellido_Paterno . ' ' . $Apellido_Materno; // Concatenar el nombre completo
            ?>
                            <tr>
                                <td><?php echo $BIDRequisicionE; ?></td>
                                <td><?php echo $NombreCompleto;?></td>
                                <td><?php echo $BFchCreacion; ?></td>
                                <td><?php echo $BEstatus; ?></td>
                                <td><?php echo $NombreCuenta; ?></td>
                                <td><?php echo $BJustificacion; ?></td>
                                <td><?php echo $BComentariosMod; ?></td>
                                <td><a class="btn btn-warning" href="Update/Update_Solicitud_USER.php?id=<?php echo $BIDRequisicionE; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24V0H24z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                    </svg>Actualizar</a>
                                </td>
                                <td><a class="btn btn-danger" onclick="eliminarRegistroBorradorRequisicion(<?php echo $BIDRequisicionE; ?>)" href="javascript:void(0);">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x-filled" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24V0H24z" fill="none"/>
                                        <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16zm-9.489 5.14a1 1 0 0 0 -1.218 1.567l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.497 1.32l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.32 -1.497l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.497 -1.32l-1.293 1.292l-1.293 -1.292l-.094 -.083z" stroke-width="0" fill="currentColor" />
                                        <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor" />
                                    </svg>Eliminar</a>
                                </td>
                            </tr>
            <?php
                        }
                    } else {
                        echo "<tr><td colspan='10' class='text-center'>No hay registros</td></tr>";
                    }
                    
                    // Total de registros para paginaci��n
                    $sql_total = "SELECT COUNT(*) AS total 
                                FROM 
                                    Borrador_RequisicionE BRE 
                                INNER JOIN 
                                    Usuario U ON BRE.BIdUsuario = U.ID_Usuario
                                WHERE 
                                    U.Correo_Electronico = ?";
                    
                    $stmt_total = $conexion->prepare($sql_total); // Preparar la consulta SQL para el total de registros
                    $stmt_total->bind_param("s", $usuario); // Vincular el parámetro de la consultaa la variable $usuario
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

<script src="../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Eliminar_Borrador_Requisicion.js"></script>

<?php include('footer.php'); ?>