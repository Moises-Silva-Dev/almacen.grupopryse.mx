<?php include('head.php'); ?>
<!-- Contenedor de las alertas -->            
<div class="table-responsive">
    <center>
        <h2 class="mb-4">Salidas Registradas</h2>
    </center>
    <!-- Tabla para mostrar los registros -->
    <table id="requisicionesTable" class="table table-hover table-striped mt-4">
        <thead class="table-light">
            <tr> 
                <th scope="col">#</th>
                <th scope="col">Estatus</th>
                <th scope="col">Solicitante</th>
                <th scope="col">Centro de Trabajo</th>
                <th scope="col">Fecha de Solicitud</th>
                <th colspan="2" scope="col"><center>Acciones</center></th>
            </tr>
        </thead>
        <tbody>
            <?php
                try{
                    $conexion = (new Conectar())->conexion(); // Crear una nueva instancia de la clase Conectar y obtener la conexión
            
                    $records_per_page = 10; // Número de registros por página
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Obtener la página actual, por defecto es 1
                    $offset = ($page - 1) * $records_per_page; // Calcular el offset para la consulta SQL
                    
                    // Preparar la consulta SQL con LIMIT y OFFSET
                    $sql = "SELECT 
                                RE.IDRequisicionE, 
                                RE.Estatus AS Estado,
                                RE.Receptor, 
                                RE.CentroTrabajo, 
                                DATE(RE.FchCreacion) AS Fecha
                            FROM 
                                RequisicionE RE
                            WHERE 
                                RE.Estatus = 'Autorizado' OR RE.Estatus = 'Parcial'
                            ORDER BY 
                                RE.FchAutoriza DESC
                            LIMIT 
                                ? OFFSET ?";

                    $stmt = $conexion->prepare($sql); // Preparar la consulta SQL
                    $stmt->bind_param("ii", $records_per_page, $offset); // Vincular los parámetros a la consulta
                    $stmt->execute(); // Ejecutar la consulta
                    $query = $stmt->get_result(); // Obtener el resultado de la consulta
                                        
                    // Consulta para contar el total de registros con los mismos filtros
                    $sql_total = "SELECT 
                                    COUNT(*) AS total
                                FROM 
                                    RequisicionE RE
                                WHERE 
                                    RE.Estatus = 'Autorizado' OR RE.Estatus = 'Parcial'";
                    
                    $result_total = mysqli_query($conexion, $sql_total); // Ejecutar la consulta para obtener el total de registros
                    $total_rows = mysqli_fetch_array($result_total)['total']; // Obtener el total de registros
                    $total_pages = ceil($total_rows / $records_per_page); // Calcular el total de páginas

                    while ($row = mysqli_fetch_array($query)) { // Iterar sobre los resultados de la consulta
                        $IDRequisicionE = htmlspecialchars($row['IDRequisicionE'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $Estado = htmlspecialchars($row['Estado'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $Receptor = htmlspecialchars($row['Receptor'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $CentroTrabajo = htmlspecialchars($row['CentroTrabajo'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $Fecha = htmlspecialchars($row['Fecha'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                ?>
                        <tr>
                            <td><?php echo $IDRequisicionE; ?></td>
                            <td><?php echo $Estado; ?></td>
                            <td><?php echo $Receptor; ?></td>
                            <td><?php echo $CentroTrabajo; ?></td>
                            <td><?php echo $Fecha; ?></td>
                            <td><a class="btn btn-primary" href="INSERT/Insert_Salida_Dev.php?id=<?php echo $IDRequisicionE; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ballpen" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M14 6l7 7l-4 4" />
                                    <path d="M5.828 18.172a2.828 2.828 0 0 0 4 0l10.586 -10.586a2 2 0 0 0 0 -2.829l-1.171 -1.171a2 2 0 0 0 -2.829 0l-10.586 10.586a2.828 2.828 0 0 0 0 4z" />
                                    <path d="M4 20l1.768 -1.768" />
                                </svg>Salida</a>
                            </td>
                            <td><a class="btn btn-danger" onclick="return eliminar()" href="../../Controlador/DEV/DELETE/Funcion_Delete_Salida.php?id=<?php echo $IDRequisicionE; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16zm-9.489 5.14a1 1 0 0 0 -1.218 1.567l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.497 1.32l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.32 -1.497l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.497 -1.32l-1.293 1.292l-1.293 -1.292l-.094 -.083z" stroke-width="0" fill="currentColor" />
                                    <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor" />
                                </svg>Eliminar</a>
                            </td>
                        </tr>
            <?php
                    }
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage(); // Mostrar el mensaje de error
                    echo "<div class='alert alert-danger'>Ocurrió un error al procesar la solicitud. Por favor, inténtelo de nuevo más tarde.</div>"; // Mostrar un mensaje de error
                } finally {
                    $stmt->close(); // Cerrar la consulta preparada
                    $result_total->close(); // Cerrar el resultado de la consulta total
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
        
<script src="../../js/Ocultar_Estatus.js"></script>

<?php include('footer.php'); ?>