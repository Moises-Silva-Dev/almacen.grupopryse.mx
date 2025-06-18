<?php include('head.php'); ?>
<!-- Contenedor de las alertas -->            
<div class="table-responsive">    
    <center>
        <h2 class="mb-4">Estado de Requisición</h2>
    </center>
    <!-- Formulario para seleccionar la cuenta y estatus -->
    <form method="GET" class="form-inline d-flex justify-content-end mb-4">
        <div class="form-group mb-2">
            <label for="cuenta" class="mr-2">Seleccionar Cuenta:</label>
            <select class="form-select" id="cuenta" name="cuenta">
                <!-- Las opciones de cuenta se cargarán aquí con PHP -->
                <?php
                    $conexion = (new Conectar())->conexion(); // Conectar a la base de datos
                    $sqlCuentas = "SELECT ID, NombreCuenta FROM Cuenta"; // Consulta para obtener las cuentas
                    $resultCuentas = $conexion->query($sqlCuentas); // Ejecutar la consulta
                    while ($rowC = $resultCuentas->fetch_assoc()) { // Recorrer los resultados
                        echo '<option value="' . $rowC['ID'] . '">' . $rowC['NombreCuenta'] . '</option>'; // Mostrar las opciones en el select
                    }
                ?>
            </select>
        </div>
        <div class="form-group mb-2">
            <label for="estatus" class="mr-2">Filtrar por estatus:</label>
            <select class="form-select" id="estatus" name="estatus">
                <option value="">Todos</option>
                <option value="Pendiente" <?php echo isset($_GET['estatus']) && $_GET['estatus'] == 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                <option value="Autorizado" <?php echo isset($_GET['estatus']) && $_GET['estatus'] == 'Autorizado' ? 'selected' : ''; ?>>Autorizado</option>
                <option value="Parcial" <?php echo isset($_GET['estatus']) && $_GET['estatus'] == 'Parcial' ? 'selected' : ''; ?>>Parcial</option>
                <option value="Surtido" <?php echo isset($_GET['estatus']) && $_GET['estatus'] == 'Surtido' ? 'selected' : ''; ?>>Surtido</option>
                <!-- Agrega más opciones según sea necesario -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
    </form>

    <!-- Tabla para mostrar los registros -->
    <table id="tablaSolicitudes" class="table table-hover table-striped mt-4">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre Solicitante</th>
                <th scope="col">Fecha</th>
                <th scope="col">Estatus</th>
                <th scope="col">Cuenta</th>
                <th scope="col">Centro de Trabajo</th>
                <th scope="col">Receptor</th>
                <th colspan="2" scope="col"><center>Acciones</center></th>
            </tr>
        </thead>
        <tbody>
            <?php
                try {
                    if (isset($_GET['cuenta'])) {
                        $cuenta_filtro = $_GET['cuenta']; // Recupera el valor de la cuenta de los parámetros de la URL
                        $estatus_filtro = isset($_GET['estatus']) ? $_GET['estatus'] : ''; // Recupera el valor del estatus de los parámetros de la URL

                        $records_per_page = 10; // Definir el número de registros por página
                        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Recupera el número de página de los parámetros de la URL
                        $offset = ($page - 1) * $records_per_page; // Calcula el desplazamiento de registros

                        // Consulta para obtener las requisiciones con filtrado por cuenta y estatus
                        $sql = "SELECT RE.IDRequisicionE, U.Nombre, U.Apellido_Paterno, U.Apellido_Materno,
                                    RE.FchCreacion, RE.Estatus, C.NombreCuenta, RE.CentroTrabajo,
                                    RE.Receptor FROM RequisicionE RE
                                INNER JOIN 
                                    Usuario U ON RE.IdUsuario = U.ID_Usuario
                                INNER JOIN 
                                    Cuenta C ON RE.IdCuenta = C.ID
                                WHERE
                                    RE.IdCuenta = ?";

                        if (!empty($estatus_filtro)) {
                            $sql .= " AND RE.Estatus = ?";
                        }

                        $sql .= " GROUP BY RE.IDRequisicionE
                                ORDER BY RE.FchCreacion DESC 
                                LIMIT ? OFFSET ?";

                        $stmt = $conexion->prepare($sql); // Preparar la consulta
                        if (!empty($estatus_filtro)) { // Si hay filtro de estatus, agregar el parámetro al prepare
                            $stmt->bind_param("isii", $cuenta_filtro, $estatus_filtro, $records_per_page, $offset); // Agregar el parámetro al prepare
                        } else {
                            $stmt->bind_param("iii", $cuenta_filtro, $records_per_page, $offset); // Agregar el parámetro al prepare
                        }

                        $stmt->execute(); // Ejecutar la consulta
                        $result = $stmt->get_result(); // Obtener el resultado de la consulta
                        $has_records = false; // Variable para verificar si hay registros
                        while ($row = $result->fetch_assoc()) { // Recorrer los resultados
                            $has_records = true; // Establecer la variable a verdadero si hay registros
                            $IDRequisicionE = htmlspecialchars($row['IDRequisicionE'], ENT_QUOTES, 'UTF-8');
                            $Nombre = htmlspecialchars($row['Nombre'], ENT_QUOTES, 'UTF-8');
                            $Apellido_Paterno = htmlspecialchars($row['Apellido_Paterno'], ENT_QUOTES, 'UTF-8');
                            $Apellido_Materno = htmlspecialchars($row['Apellido_Materno'], ENT_QUOTES, 'UTF-8');
                            $FchCreacion = htmlspecialchars($row['FchCreacion'], ENT_QUOTES, 'UTF-8');
                            $Estatus = htmlspecialchars($row['Estatus'], ENT_QUOTES, 'UTF-8');
                            $NombreCuenta = htmlspecialchars($row['NombreCuenta'], ENT_QUOTES, 'UTF-8');
                            $CentroTrabajo = htmlspecialchars($row['CentroTrabajo'], ENT_QUOTES, 'UTF-8');
                            $Receptor = htmlspecialchars($row['Receptor'], ENT_QUOTES, 'UTF-8');
                            $NombreCompleto = $Nombre . ' ' . $Apellido_Paterno . ' ' . $Apellido_Materno; // Concatenar el nombre completo del solicitante
                ?>
                            <tr>
                                <td><?php echo $IDRequisicionE; ?></td>
                                <td><?php echo $NombreCompleto; ?></td>
                                <td><?php echo $FchCreacion; ?></td>
                                <td class="table-warning"><?php echo $Estatus; ?></td>
                                <td><?php echo $NombreCuenta; ?></td>
                                <td><?php echo $CentroTrabajo; ?></td>
                                <td><?php echo $Receptor; ?></td>
                                <td>
                                    <a class="btn btn-success" href="Visualizar/Infor_Requisicion.php?id=<?php echo $IDRequisicionE; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 4c4.29 0 7.863 2.429 10.665 7.154l.22 .379l.045 .1l.03 .083l.014 .055l.014 .082l.011 .1v.11l-.014 .111a.992 .992 0 0 1 -.026 .11l-.039 .108l-.036 .075l-.016 .03c-2.764 4.836 -6.3 7.38 -10.555 7.499l-.313 .004c-4.396 0 -8.037 -2.549 -10.868 -7.504a1 1 0 0 1 0 -.992c2.831 -4.955 6.472 -7.504 10.868 -7.504zm0 5a3 3 0 1 0 0 6a3 3 0 0 0 0 -6z" stroke-width="0" fill="currentColor" />
                                    </svg>Ver</a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning BtnDescargarRequisicion" data-id="<?php echo $IDRequisicionE; ?>">
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

                        if (!$has_records) { // No hay registros para la cuenta y estatus seleccionados
                            echo '<tr><td colspan="8" class="text-center">No se encontraron registros para la cuenta y estatus seleccionados.</td></tr>';
                        }

                        // Total de registros para paginación con filtrado
                        $sql_total = "SELECT COUNT(*) AS total FROM RequisicionE RE
                            INNER JOIN Usuario U ON RE.IdUsuario = U.ID_Usuario
                            WHERE RE.IdCuenta = ?";
                            
                        if ($estatus_filtro) { // Filtrar por estatus
                            $sql_total .= " AND RE.Estatus = ?"; // Agregar el filtro para el estatus
                        }
                        
                        $stmt_total = $conexion->prepare($sql_total); // Preparar la consulta

                        if (!empty($estatus_filtro)) { // Si se seleccionó un estatus, agregarlo al filtro
                            $stmt_total->bind_param("is", $cuenta_filtro, $estatus_filtro); // Agregar el parámetro para el estatus
                        } else {
                            $stmt_total->bind_param("i", $cuenta_filtro); // Agregar el parámetro para la cuenta
                        }

                        $stmt_total->execute(); // Ejecutar la consulta
                        $result_total = $stmt_total->get_result(); // Obtener el resultado
                        $total_rows = $result_total->fetch_assoc()['total']; // Obtener el total de registros
                        $total_pages = ceil($total_rows / $records_per_page); // Calcular el total de páginas
                    } else {
                        echo '<tr><td colspan="8" class="text-center">Debe seleccionar una cuenta para filtrar.</td></tr>';
                    }
                } catch (Exception $e) {
                    error_log("Error en el sistema: " . $e->getMessage()); // Registrar el error en el log del servidor
                    echo '<tr><td colspan="8" class="text-center alert alert-danger">Ocurrió un error al procesar la solicitud. Por favor, inténtelo de nuevo más tarde.</td></tr>'; // Mostrar un mensaje de error si ocurre una excepción
                } finally {
                    $stmt->close();
                    $stmt_total->close();
                    $conexion->close();
                }
            ?>
        </tbody>
    </table>
    <?php if (isset($_GET['cuenta'])): ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center flex-wrap text-center">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>&cuenta=<?php echo htmlspecialchars($cuenta_filtro); ?>&estatus=<?php echo htmlspecialchars($estatus_filtro); ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php
                    $range = 2; // Número de páginas a mostrar antes y después del número actual
                    $show_dots_start = false; // Mostrar puntos suspensivos al principio
                    $show_dots_end = false; // Mostrar puntos suspensivos al final

                    if ($page > $range + 2) { // Mostrar puntos suspensivos al principio
                        echo '<li class="page-item"><a class="page-link" href="?page=1&cuenta=' . htmlspecialchars($cuenta_filtro) . '&estatus=' . htmlspecialchars($estatus_filtro) . '">1</a></li>';
                        $show_dots_start = true; // Mostrar puntos suspensivos al principio
                    }

                    if ($show_dots_start) { // Mostrar puntos suspensivos al principio
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>'; // Mostrar puntos suspensivos al principio
                    }

                    for ($i = max(1, $page - $range); $i <= min($total_pages, $page + $range); $i++) { // Mostrar números de páginas
                        $active = $i == $page ? 'active' : ''; // Clase activa para el número de página actual
                        echo '<li class="page-item ' . $active . '">
                                <a class="page-link" href="?page=' . $i . '&cuenta=' . htmlspecialchars($cuenta_filtro) . '&estatus=' . htmlspecialchars($estatus_filtro) . '">' . $i . '</a>
                            </li>'; // Mostrar números de páginas
                    }

                    if ($page + $range < $total_pages - 1) { // Mostrar puntos suspensivos al final
                        $show_dots_end = true; // Mostrar puntos suspensivos al final
                    }

                    if ($show_dots_end) { // Mostrar puntos suspensivos al final
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>'; // Mostrar puntos suspensivos al final
                    }

                    if ($page + $range < $total_pages) { // Mostrar último número de página
                        echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . '&cuenta=' . htmlspecialchars($cuenta_filtro) . '&estatus=' . htmlspecialchars($estatus_filtro) . '">' . $total_pages . '</a></li>'; // Mostrar último número de página
                    }
                ?>
                <!-- Paginación -->
                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>&cuenta=<?php echo htmlspecialchars($cuenta_filtro); ?>&estatus=<?php echo htmlspecialchars($estatus_filtro); ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<script src="../../js/DescargarRequisicion.js"></script>

<?php include('footer.php'); ?>