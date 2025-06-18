<?php include('head.php'); ?>
<!-- Contenedor de las alertas -->            
<div class="table-responsive">
    <center>
        <h2 class="mb-4">Regiones Registradas</h2>
        <!-- Botones -->
        <a class="btn btn-primary" href="INSERT/Insert_Region_Dev.php">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                <path d="M16 19h6" />
                <path d="M19 16v6" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
            </svg>Nueva Región
        </a>
    </center>     
    <!-- Formulario para seleccionar el estatus, alineado a la derecha -->
    <form method="GET" class="form-inline d-flex justify-content-end mb-4">
        <div class="form-group mb-2">
            <label for="estatus" class="mr-2">Filtrar por estatus:</label>
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <select class="form-select" id="cuenta" name="cuenta">
                <!-- Las opciones de cuenta se cargaron aquí con PHP -->
                <?php
                    $conexion = (new Conectar())->conexion(); // Crear una nueva instancia de la clase Conectar y obtener la conexión
                    $sqlCuentas = "SELECT ID, NombreCuenta FROM Cuenta;"; // Consulta para obtener las cuentas
                    $resultCuentas = $conexion->query($sqlCuentas); // Ejecutar la consulta para obtener las cuentas
                    while ($rowC = $resultCuentas->fetch_assoc()) { // Iterar sobre los resultados de la consulta
                        echo '<option value="' . $rowC['ID'] . '">' . $rowC['NombreCuenta'] . '</option>'; // Mostrar las opciones de cuenta
                    }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                <path d="M21 21l-6 -6" />
            </svg>Filtrar
        </button>
    </form>
    <!-- Tabla para mostrar los registros -->
    <table class="table table-hover table-striped mt-4">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Región</th>
                <th scope="col">Cuenta</th>
                <th colspan="2" scope="col"><center>Acciones</center></th>
            </tr>
        </thead>
        <tbody>
            <?php
                try{
                    if (isset($_GET['cuenta']) && is_numeric($_GET['cuenta'])) { // Verificar si se ha seleccionado una cuenta y es un número
                        $cuenta_filtro = (int)$_GET['cuenta']; // Obtener el ID de la cuenta seleccionada para filtrar

                        $records_per_page = 10; // Número de registros por página
                        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Obtener la página actual, por defecto es 1
                        $offset = ($page - 1) * $records_per_page; // Calcular el offset para la consulta SQL

                        // Consulta SQL con el filtro
                        $sql = "SELECT R.ID_Region, R.Nombre_Region, C.NombreCuenta 
                                FROM Regiones R
                                INNER JOIN Cuenta_Region CR ON R.ID_Region = CR.ID_Regiones
                                INNER JOIN Cuenta C ON CR.ID_Cuentas = C.ID
                                WHERE C.ID = ? 
                                LIMIT ? OFFSET ?";

                        $stmt = $conexion->prepare($sql); // Preparar la consulta SQL
                        $stmt->bind_param("iii", $cuenta_filtro, $records_per_page, $offset); // Vincular los parámetros a la consulta
                        $stmt->execute(); // Ejecutar la consulta
                        $result = $stmt->get_result(); // Obtener el resultado de la consulta

                        $has_records = false; // Muestra los resultados en la tabla
                        while ($row = $result->fetch_assoc()) {
                            $ID_Region = htmlspecialchars($row['ID_Region'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $Nombre_Region = htmlspecialchars($row['Nombre_Region'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $NombreCuenta = htmlspecialchars($row['NombreCuenta'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir 
                            $has_records = true;
            ?>
                            <tr class="table-light">
                                <td><?php echo $ID_Region; ?></td>
                                <td><?php echo $Nombre_Region; ?></td>
                                <td><?php echo $NombreCuenta; ?></td>
                                <td><a class="btn btn-warning" href="Update/Update_Region_Dev.php?id=<?php echo $ID_Region; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                            <path d="M16 5l3 3" />
                                        </svg>Modificar
                                    </a>
                                </td>
                                <td><a class="btn btn-danger" onclick="eliminarRegistroRegion(<?php echo $ID_Region; ?>)" href="javascript:void(0);">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16zm-9.489 5.14a1 1 0 0 0 -1.218 1.567l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.497 1.32l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.32 -1.497l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.497 -1.32l-1.293 1.292l-1.293 -1.292l-.094 -.083z" stroke-width="0" fill="currentColor" />
                                            <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor" />
                                        </svg>Eliminar
                                    </a>
                                </td>
                            </tr>
            <?php
                        }
                        
                        if (!$has_records) { // Si no hay registros, mostrar un mensaje
                            echo '<tr><td colspan="8" class="text-center">No se encontraron registros para la cuenta seleccionada.</td></tr>';
                        }

                        // Consulta para el total de registros para la paginaci車n
                        $sql_total = "SELECT COUNT(*) AS total FROM Regiones R 
                                        INNER JOIN Cuenta_Region CR ON R.ID_Region = CR.ID_Regiones 
                                        INNER JOIN Cuenta C ON CR.ID_Cuentas = C.ID
                                        WHERE C.ID = ?";
                        
                        $stmt_total = $conexion->prepare($sql_total); // Preparar la consulta SQL para el total de registros
                        $stmt_total->bind_param("i", $cuenta_filtro); // Vincular el parámetro de la cuenta
                        $stmt_total->execute(); // Ejecutar la consulta
                        $result_total = $stmt_total->get_result(); // Obtener el resultado de la consulta
                        $total_records = $result_total->fetch_assoc()['total']; // Obtener el total de registros
                        $total_pages = ceil($total_records / $records_per_page); // Calcular el total de páginas
                    } else {
                        echo '<tr><td colspan="8" class="text-center">Debe seleccionar una cuenta para filtrar.</td></tr>';
                    }
                } catch (Exception $e) {
                    error_log("Error al conectar a la base de datos: " . $e->getMessage()); // Registrar el error en el log
                    echo '<tr><td colspan="8" class="text-center text-danger">Ocurrió un error al procesar su solicitud. Por favor, inténtelo nuevamente.</td></tr>';
                } finally {
                    $stmt->close(); // Cerrar la consulta preparada
                    $stmt_total->close(); // Cerrar la consulta preparada para el total de registros
                    $conexion->close(); // Cerrar la conexión a la base de datos
                }
            ?>
        </tbody>
    </table>
    <!-- Paginación -->
    <?php if (isset($total_pages) && $total_pages > 1): ?>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center flex-wrap text-center">
                <!-- Botón anterior -->
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?cuenta=<?php echo $cuenta_filtro; ?>&page=<?php echo $page - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php
                    $range = 2; // número de páginas antes y después de la actual
                    $show_dots_start = false; // Inicializar las variables para los puntos suspensivos
                    $show_dots_end = false; // Inicializar las variables para los puntos suspensivos

                    if ($page > $range + 2) { // Si la página actual es mayor que el rango más 2
                        echo '<li class="page-item"><a class="page-link" href="?cuenta=' . $cuenta_filtro . '&page=1">1</a></li>'; // Mostrar siempre la primera página
                        $show_dots_start = true; // Mostrar puntos suspensivos al inicio
                    }

                    if ($show_dots_start) { // Mostrar puntos suspensivos al inicio
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>'; // Mostrar puntos suspensivos al inicio
                    }

                    // Páginas centrales
                    for ($i = max(1, $page - $range); $i <= min($total_pages, $page + $range); $i++) { // Iterar desde la página anterior hasta la página siguiente
                        $active = ($i == $page) ? 'active' : ''; // Marcar la página actual como activa
                        echo '<li class="page-item ' . $active . '"><a class="page-link" href="?cuenta=' . $cuenta_filtro . '&page=' . $i . '">' . $i . '</a></li>'; // Mostrar el número de página
                    }

                    if ($page + $range < $total_pages - 1) { // Mostrar puntos suspensivos al final si no está cerca de la última página
                        $show_dots_end = true; // Mostrar puntos suspensivos al final
                    }

                    if ($show_dots_end) { // Mostrar puntos suspensivos al final
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>'; // Mostrar puntos suspensivos
                    }

                    if ($page + $range < $total_pages) { // Mostrar la última página si no está cerca
                        echo '<li class="page-item"><a class="page-link" href="?cuenta=' . $cuenta_filtro . '&page=' . $total_pages . '">' . $total_pages . '</a></li>'; // Mostrar siempre la última página
                    }
                ?>
                <!-- Botón siguiente -->
                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?cuenta=<?php echo $cuenta_filtro; ?>&page=<?php echo $page + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<script src="../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Eliminar_Region.js"></script>

<?php include('footer.php'); ?>