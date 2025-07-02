<?php include('head.php'); ?>
<!-- Contenedor de las alertas -->            
<div class="table-responsive">
    <center>
        <h2 class="mb-4">Registro de Accesos de Usuario</h2>
    </center>
    <!-- Tabla para mostrar los registros -->
    <table class="table table-hover table-striped mt-4">
        <thead class="table-light">
            <tr> 
                <th scope="col">#</th>
                <th scope="col">Nombre Completo</th>
                <th scope="col">Correo_Electronico</th>
                <th scope="col">Fecha de Acceso</th>
                <th scope="col">Hora de Acceso</th>
                <th scope="col">IP</th>
                <th scope="col">ID_Mac</th>
                <th scope="col">Ciudad</th>
                <th scope="col">País</th>
            </tr>
        </thead>
        <tbody>
            <?php
                try{
                    $conexion = (new Conectar())->conexion(); // Crear una nueva instancia de la clase Conectar y obtener la conexión
                        
                    $records_per_page = 10; // Número de registros por página
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Obtener la página actual, por defecto es 1
                    $offset = ($page - 1) * $records_per_page; // Calcular el offset para la consulta SQL
                        
                    // Consulta SQL para obtener los datos de la tabla Usuario
                    $sql = "SELECT 
                                RA.ID, U.Nombre, U.Apellido_Paterno, U.Apellido_Materno, 
                                U.Correo_Electronico, RA.FchAcceso, RA.HorAcceso, RA.IP, 
                                RA.ID_Mac, RA.Ciudad, RA.Pais
                            FROM
                                Registro_Acceso RA
                            INNER JOIN
                                Usuario U ON RA.IdUsuario = U.ID_Usuario
                            LIMIT 
                                ? OFFSET ?";

                    $stmt = $conexion->prepare($sql); // Preparar la consulta SQL
                    $stmt->bind_param("ii", $records_per_page, $offset); // Vincular los parámetros a la consulta
                    $stmt->execute(); // Ejecutar la consulta
                    $query = $stmt->get_result(); // Obtener el resultado de la consulta
                        
                    // Total de registros
                    $sql_total = "SELECT COUNT(*) FROM Registro_Acceso";
                    $result_total = mysqli_query($conexion, $sql_total);
                    $total_rows = mysqli_fetch_array($result_total)[0];
                    $total_pages = ceil($total_rows / $records_per_page);

                    // Itera sobre los resultados de la consulta
                    while ($row = mysqli_fetch_array($query)) {
                        $ID_Acceso = htmlspecialchars($row['ID'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir
                        $Nombre = htmlspecialchars($row['Nombre'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $Apellido_Paterno = htmlspecialchars($row['Apellido_Paterno'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $Apellido_Materno = htmlspecialchars($row['Apellido_Materno'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $Correo_Electronico = htmlspecialchars($row['Correo_Electronico'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $FchAcceso = htmlspecialchars($row['FchAcceso'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $HorAcceso = htmlspecialchars($row['HorAcceso'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $IP = htmlspecialchars($row['IP'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS 
                        $ID_Mac = htmlspecialchars($row['ID_Mac'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $Ciudad = htmlspecialchars($row['Ciudad'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $Pais = htmlspecialchars($row['Pais'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                ?>
                    <tr>
                        <td><?php echo $ID_Acceso; ?></td>
                        <td><?php echo $Nombre . " " . $Apellido_Paterno . " " . $Apellido_Materno; ?></td>
                        <td><?php echo $Correo_Electronico; ?></td>
                        <td><?php echo $FchAcceso; ?></td>
                        <td><?php echo $HorAcceso; ?></td>
                        <td><?php echo $IP; ?></td>
                        <td><?php echo $ID_Mac; ?></td>
                        <td><?php echo $Ciudad; ?></td>
                        <td><?php echo $Pais; ?></td>
                    </tr>
                <?php
                    }
                } catch (Exception $e) {
                    error_log("Error en el sistema: " . $e->getMessage()); // Registrar el error en el log del servidor
                    echo "<div class='alert alert-danger'>Ocurrió un error al procesar la solicitud. Por favor, inténtelo de nuevo más tarde.</div>";                
                } finally {
                    $stmt->close(); // Cerrar la consulta preparada
                    $result_total->close(); // Cerrar el resultado de la consulta total
                    $conexion->close(); // Cierra la conexión a la base de datos
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

<?php include('footer.php'); ?>