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
        <h2 class="mb-4">Solicitud Registrados</h2>
    </center>
    <!-- Tabla para mostrar los registros -->
    <table class="table table-hover table-striped mt-4">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre Solicitante</th>
                <th scope="col">Fecha</th>
                <th scope="col">Estatus</th>
                <th scope="col">Cuenta</th>
                <th scope="col">Justificación</th>
                <th colspan="3" scope="col"><center>Acciones</center></th>
            </tr>
        </thead>
        <tbody>
            <?php
                try {
                    $conexion = (new Conectar())->conexion(); // Crear una nueva instancia de la clase Conectar y obtener la conexión
                
                    $records_per_page = 10; // Número de registros por página
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Obtener la página actual, por defecto es 1
                    $offset = ($page - 1) * $records_per_page; // Calcular el offset para la consulta SQL

                    // Preparar la consulta SQL con LIMIT y OFFSET    
                    $sql = "SELECT 
                                RE.IDRequisicionE, U.Nombre, U.Apellido_Paterno, U.Apellido_Materno,
                                RE.FchCreacion, RE.Estatus, C.NombreCuenta, RE.Justificacion,
                                RE.Receptor
                            FROM 
                                RequisicionE RE
                            INNER JOIN 
                                Usuario U ON RE.IdUsuario = U.ID_Usuario
                            INNER JOIN
                                Cuenta C ON RE.IdCuenta = C.ID
                            GROUP BY 
                                RE.IDRequisicionE
                            ORDER BY 
                                RE.FchCreacion DESC
                            LIMIT 
                                ? OFFSET ?";
                    
                    $stmt = $conexion->prepare($sql); // Preparar la consulta SQL
                    $stmt->bind_param("ii", $records_per_page, $offset); // Vincular los parámetros a la consulta
                    $stmt->execute(); // Ejecutar la consulta
                    $query = $stmt->get_result(); // Obtener el resultado de la consulta

                    $sql_total = "SELECT COUNT(*) AS total FROM RequisicionE"; // Consulta para obtener el total de registros
                    $result_total = mysqli_query($conexion, $sql_total); // Ejecutar la consulta para obtener el total de registros
                    $total_rows = mysqli_fetch_array($result_total)['total']; // Obtener el total de registros
                    $total_pages = ceil($total_rows / $records_per_page); // Calcular el total de páginas

                    while ($row = mysqli_fetch_array($query)) { // Recorrer los registros y mostrarlos en la tabla
                        $IDRequisicionE = htmlspecialchars($row['IDRequisicionE'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $Nombre = htmlspecialchars($row['Nombre'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $Apellido_Paterno = htmlspecialchars($row['Apellido_Paterno'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $Apellido_Materno = htmlspecialchars($row['Apellido_Materno'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $FchCreacion = htmlspecialchars($row['FchCreacion'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $Estatus = htmlspecialchars($row['Estatus'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $NombreCuenta = htmlspecialchars($row['NombreCuenta'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $Justificacion = htmlspecialchars($row['Justificacion'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $NombreCompleto = $Nombre . ' ' . $Apellido_Paterno . ' ' . $Apellido_Materno; // Concatenar el nombre completo
            ?>
                        <tr>
                            <td><?php echo $IDRequisicionE; ?></td>
                            <td><?php echo $NombreCompleto;?></td>
                            <td><?php echo $FchCreacion; ?></td>
                            <td><?php echo $Estatus; ?></td>
                            <td><?php echo $NombreCuenta; ?></td>
                            <td><?php echo $Justificacion; ?></td>
                            <td>
                                <a class="btn btn-success" href="Visualizar/Infor_Solicitud.php?id=<?php echo $IDRequisicionE; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ballpen-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24V0H24z" fill="none"/>
                                    <path d="M17.828 2a3 3 0 0 1 1.977 .743l.145 .136l1.171 1.17a3 3 0 0 1 .136 4.1l-.136 .144l-1.706 1.707l2.292 2.293a1 1 0 0 1 .083 1.32l-.083 .094l-4 4a1 1 0 0 1 -1.497 -1.32l.083 -.094l3.292 -3.293l-1.586 -1.585l-7.464 7.464a3.828 3.828 0 0 1 -2.474 1.114l-.233 .008c-.674 0 -1.33 -.178 -1.905 -.508l-1.216 1.214a1 1 0 0 1 -1.497 -1.32l.083 -.094l1.214 -1.216a3.828 3.828 0 0 1 .454 -4.442l.16 -.17l10.586 -10.586a3 3 0 0 1 1.923 -.873l.198 -.006zm0 2a1 1 0 0 0 -.608 .206l-.099 .087l-1.707 1.707l2.586 2.585l1.707 -1.706a1 1 0 0 0 .284 -.576l.01 -.131a1 1 0 0 0 -.207 -.609l-.087 -.099l-1.171 -1.171a1 1 0 0 0 -.708 -.293z" stroke-width="0" fill="currentColor" />
                                </svg>Autorizar</a>
                            </td>
                            <td>
                                <a class="btn btn-warning" onclick="SolicitarModificacionRequisicion(<?php echo $IDRequisicionE; ?>)" href="javascript:void(0);">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send-2" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4.698 4.034l16.302 7.966l-16.302 7.966a.503 .503 0 0 1 -.546 -.124a.555 .555 0 0 1 -.12 -.568l2.468 -7.274l-2.468 -7.274a.555 .555 0 0 1 .12 -.568a.503 .503 0 0 1 .546 -.124z" />
                                    <path d="M6.5 12h14.5" />
                                </svg>Solicitar Modificación</a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger BtnDescargarRequisicion" data-id="<?php echo $IDRequisicionE; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="20" height="20" stroke-width="1.5"> 
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4"></path> 
                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                        <path d="M12 17v-6"></path> 
                                        <path d="M9.5 14.5l2.5 2.5l2.5 -2.5"></path> 
                                    </svg>Descargar
                                </button>
                            </td>
                        </tr>
            <?php
                    }
                } catch (Exception $e) {
                    error_log("Error en el sistema: " . $e->getMessage()); // Registrar el error en el log del servidor
                    echo "<div class='alert alert-danger'>Ocurrió un error al procesar la solicitud. Por favor, inténtelo de nuevo más tarde.</div>";
                } finally {
                    $stmt->close(); // Cerrar la consulta preparada
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

<script src="../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_BtnSolicitarModificacion.js"></script>
<script src="../../js/InvalidarBtnEstatus.js"></script>
<script src="../../js/DescargarRequisicion.js"></script>

<?php include('footer.php'); ?>