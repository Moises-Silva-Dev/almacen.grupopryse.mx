<?php include('head.php'); ?>
<!-- Contenedor de las alertas -->            
<div class="table-responsive">    
    <center>
        <h2 class="mb-4">Devoluciones Registrados</h2>
        <!-- Botones -->
        <a class="btn btn-primary" href="INSERT/Insert_Devolucion_ALMACENISTA.php">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                <path d="M16 19h6" />
                <path d="M19 16v6" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
            </svg>Nuevo Prestamo</a>
    </center>
    <!-- Tabla para mostrar los registros -->
    <table class="table table-hover table-striped mt-4">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Telefono</th>
                <th scope="col">Justificación</th>
                <th scope="col">Fecha</th>
                <th scope="col">Tipo</th>
                <th scope="col"><center>Acción</center></th>
            </tr>
        </thead>
        <tbody>
            <?php
                try {
                    $conexion = (new Conectar())->conexion(); // Crear una instancia de la clase Conectar y obtener la conexión
                    
                    $records_per_page = 10; // Número de registros por página
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Obtener el número de página actual, por defecto es 1
                    $offset = ($page - 1) * $records_per_page; // Calcular el desplazamiento para la paginación
                    
                    // Consulta para obtener las requisiciones
                    $sql = "SELECT 
                            DE.IdDevolucionE, DE.Nombre_Devuelve, DE.Telefono_Devuelve, DE.Justificacion,
                            DE.Fch_Devolucion, DE.IdPrestE, DE.IdRequiE
                        FROM 
                            DevolucionE DE
                        ORDER BY 
                            DE.Fch_Devolucion DESC
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
                            $IdDevolucionE = htmlspecialchars($row['IdDevolucionE'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $Nombre_Devuelve = htmlspecialchars($row['Nombre_Devuelve'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $Telefono_Devuelve = htmlspecialchars($row['Telefono_Devuelve'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $Justificacion = htmlspecialchars($row['Justificacion'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $Fch_Devolucion = htmlspecialchars($row['Fch_Devolucion'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $IdPrestE = htmlspecialchars($row['IdPrestE'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $IdRequiE = htmlspecialchars($row['IdRequiE'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
            ?>
                            <tr class="table-light">
                                <td><?php echo $IdDevolucionE; ?></td>
                                <td><?php echo $Nombre_Devuelve;?></td>
                                <td><?php echo $Telefono_Devuelve; ?></td>
                                <td><?php echo $Justificacion; ?></td>
                                <td><?php echo $Fch_Devolucion; ?></td>
                                <td><?php if (isset($IdPrestE)){ echo "Requisición"; } elseif (isset($IdRequiE)){ echo "Prestamo"; } else { echo "No esta Vinculada"; } ?></td>
                            </tr>
            <?php
                        }
                    } else {
                        echo "<tr><td colspan='10' class='text-center'>No hay registros</td></tr>";
                    }
                    
                    // Total de registros para paginaci��n
                    $sql_total = "SELECT COUNT(*) AS total FROM DevolucionE"; // Consulta para obtener el total de registros
                    
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

<?php include('footer.php'); ?>