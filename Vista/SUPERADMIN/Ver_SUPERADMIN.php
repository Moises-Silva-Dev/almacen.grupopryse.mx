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
                <?php
                    try {
                        $conexion = (new Conectar())->conexion(); // Establecer conexión a la base de datos
                        $sqlCuentas = "SELECT ID, NombreCuenta FROM Cuenta;"; // Consulta para obtener las cuentas
                        $resultCuentas = $conexion->query($sqlCuentas); // Ejecutar la consulta
                        
                        if ($resultCuentas === false) { // 
                            throw new Exception("Error al obtener las cuentas: " . $conexion->error); // Verificar si hubo un error en la consulta
                        }
                        
                        while ($rowC = $resultCuentas->fetch_assoc()) { // Iterar sobre los resultados
                            echo '<option value="' . htmlspecialchars($rowC['ID']) . '">' . htmlspecialchars($rowC['NombreCuenta']) . '</option>';
                        }
                    } catch (Exception $e) {
                        error_log("Error en el sistema: " . $e->getMessage()); // Registrar el error en el log del servidor
                        echo '<option value="">Error al cargar cuentas</option>'; // Mostrar un mensaje de error en el select
                    } finally {
                        $conexion->close();
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
                    $conexion = (new Conectar())->conexion(); // Establecer conexión a la base de datos
                    
                    if (isset($_GET['cuenta'])) { // Verificar si se ha seleccionado una cuenta
                        $cuenta_filtro = (int)$_GET['cuenta']; // Obtener el ID de la cuenta seleccionada
                        $estatus_filtro = isset($_GET['estatus']) ? $_GET['estatus'] : ''; // Obtener el estatus seleccionado
                        $records_per_page = 10; // Número de registros por página
                        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Obtener el número de página actual, por defecto es 1
                        $offset = ($page - 1) * $records_per_page; // Calcular el desplazamiento para la paginación

                        // Consulta principal con filtros
                        $sql = "SELECT RE.IDRequisicionE, U.Nombre, U.Apellido_Paterno, U.Apellido_Materno,
                                    RE.FchCreacion, RE.Estatus, C.NombreCuenta, RE.CentroTrabajo,
                                    RE.Receptor FROM RequisicionE RE
                                INNER JOIN Usuario U ON RE.IdUsuario = U.ID_Usuario
                                INNER JOIN Cuenta C ON RE.IdCuenta = C.ID
                                WHERE RE.IdCuenta = ?";

                        $params = [$cuenta_filtro]; // Parámetros para la consulta
                        $types = "i"; // Tipos de datos para los parámetros
                        
                        if ($estatus_filtro) { // Si se ha seleccionado un estatus, agregarlo a la consulta
                            $sql .= " AND RE.Estatus = ?"; // Agregar filtro por estatus
                            $params[] = $estatus_filtro; // Agregar parámetro para el estatus
                            $types .= "s"; // Agregar tipo de dato para el estatus
                        }

                        // Agregar paginación a la consulta
                        $sql .= " GROUP BY RE.IDRequisicionE 
                                ORDER BY RE.FchCreacion DESC 
                                LIMIT ? OFFSET ?";
                        
                        $params[] = $records_per_page; // Agregar el número de registros por página
                        $params[] = $offset; // Agregar el desplazamiento para la paginación
                        $types .= "ii"; // Agregar tipos de datos para los parámetros de paginación

                        $stmt = $conexion->prepare($sql); // Preparar la consulta
                        if ($stmt === false) { // Verificar si hubo un error al preparar la consulta
                            throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
                        }

                        $stmt->bind_param($types, ...$params); // Vincular los parámetros a la consulta
                        if (!$stmt->execute()) { // Ejecutar la consulta y verificar si hubo un error
                            throw new Exception("Error al ejecutar la consulta: " . $stmt->error); // Verificar si hubo un error al ejecutar la consulta
                        }

                        $result = $stmt->get_result(); // Obtener los resultados de la consulta
                        $has_records = false; // Verificar si hay registros

                        while ($row = $result->fetch_assoc()) { // Iterar sobre los resultados
                            $has_records = true; // Marcar que hay registros
                            $IDRequisicionE = htmlspecialchars($row['IDRequisicionE'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                            $Nombre = htmlspecialchars($row['Nombre'], ENT_QUOTES, 'UTF-8'); // Escapar el nombre del solicitante
                            $Apellido_Paterno = htmlspecialchars($row['Apellido_Paterno'], ENT_QUOTES, 'UTF-8'); // Escapar el apellido paterno del solicitante
                            $Apellido_Materno = htmlspecialchars($row['Apellido_Materno'], ENT_QUOTES, 'UTF-8'); // Escapar el apellido materno del solicitante
                            $FchCreacion = htmlspecialchars($row['FchCreacion'], ENT_QUOTES, 'UTF-8'); // Escapar la fecha de creación
                            $Estatus = htmlspecialchars($row['Estatus'], ENT_QUOTES, 'UTF-8'); // Escapar el estatus de la requisición
                            $NombreCuenta = htmlspecialchars($row['NombreCuenta'], ENT_QUOTES, 'UTF-8'); // Escapar el nombre de la cuenta
                            $CentroTrabajo = htmlspecialchars($row['CentroTrabajo'], ENT_QUOTES, 'UTF-8'); // Escapar el centro de trabajo
                            $Receptor = htmlspecialchars($row['Receptor'], ENT_QUOTES, 'UTF-8'); // Escapar el nombre del receptor
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
                                    <a class="btn btn-success" onclick="mostrarInfoRequisicion(<?php echo $IDRequisicionE; ?>)">
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

                        if (!$has_records) { // Si no hay registros, mostrar un mensaje
                            echo '<tr><td colspan="8" class="text-center">No se encontraron registros para la cuenta y estatus seleccionados.</td></tr>'; // Mostrar un mensaje si no hay registros
                        }

                        // Consulta para el total de registros
                        $sql_total = "SELECT COUNT(*) AS total FROM RequisicionE RE 
                                    INNER JOIN Cuenta C ON RE.IdCuenta = C.ID 
                                    WHERE RE.IdCuenta = ?";
                        
                        $params_total = [$cuenta_filtro]; // Parámetros para la consulta total
                        $types_total = "i"; // Tipo de dato para el parámetro de la cuenta
                        
                        if ($estatus_filtro) { // Si se ha seleccionado un estatus, agregarlo a la consulta total
                            $sql_total .= " AND RE.Estatus = ?"; // Agregar el estatus a la consulta total
                            $params_total[] = $estatus_filtro; // Agregar el parámetro para el estatus
                            $types_total .= "s"; // Agregar tipo de dato para el estatus
                        }
                        
                        $stmt_total = $conexion->prepare($sql_total); // Preparar la consulta total
                        if ($stmt_total === false) { // Verificar si hubo un error al preparar la consulta total
                            throw new Exception("Error en la preparación de la consulta total: " . $conexion->error); // Verificar si hubo un error en la consulta total
                        }

                        $stmt_total->bind_param($types_total, ...$params_total); // Vincular los parámetros a la consulta total
                        if (!$stmt_total->execute()) { // Ejecutar la consulta total y verificar si hubo un error
                            throw new Exception("Error al ejecutar la consulta total: " . $stmt_total->error); // Verificar si hubo un error al ejecutar la consulta total
                        }

                        $result_total = $stmt_total->get_result(); // Obtener los resultados de la consulta total
                        $total_rows = $result_total->fetch_assoc()['total']; // Obtener el total de registros
                        $total_pages = ceil($total_rows / $records_per_page); // Calcular el total de páginas
                    } else {
                        echo '<tr><td colspan="8" class="text-center">Debe seleccionar una cuenta para filtrar.</td></tr>'; // Si no se ha seleccionado una cuenta, mostrar un mensaje
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
    <!-- Paginación -->
    <?php if (isset($_GET['cuenta'])): // Mostrar la paginación solo si se ha seleccionado una cuenta ?> 
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center flex-wrap text-center">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page - 1 ?>&cuenta=<?= htmlspecialchars($cuenta_filtro) ?>&estatus=<?= htmlspecialchars($estatus_filtro) ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php
                    $range = 2; // Número de páginas a mostrar antes y después de la página actual
                    $show_dots_start = false; // Variable para controlar si se deben mostrar puntos suspensivos al inicio
                    $show_dots_end = false; // Variable para controlar si se deben mostrar puntos suspensivos al final

                    if ($page > $range + 2) { // Si la página actual es mayor que el rango más 2
                        echo '<li class="page-item"><a class="page-link" href="?page=1&cuenta=' . htmlspecialchars($cuenta_filtro) . '&estatus=' . htmlspecialchars($estatus_filtro) . '">1</a></li>'; // Mostrar el enlace a la página 1
                        $show_dots_start = true; // Mostrar puntos suspensivos al inicio
                    }

                    if ($show_dots_start) { // Si se deben mostrar puntos suspensivos al inicio
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>'; // Mostrar puntos suspensivos al inicio
                    }

                    for ($i = max(1, $page - $range); $i <= min($total_pages, $page + $range); $i++) { // Iterar entre las páginas en el rango
                        $active = $i == $page ? 'active' : ''; // Marcar la página actual como activa
                        echo '<li class="page-item ' . $active . '"> 
                                <a class="page-link" href="?page=' . $i . '&cuenta=' . htmlspecialchars($cuenta_filtro) . '&estatus=' . htmlspecialchars($estatus_filtro) . '">' . $i . '</a>
                            </li>'; // Mostrar el enlace a la página actual
                    }

                    if ($page + $range < $total_pages - 1) { // Si la página actual más el rango es menor que el total de páginas menos 1
                        $show_dots_end = true; // Mostrar puntos suspensivos al final
                    }

                    if ($show_dots_end) { // Si se deben mostrar puntos suspensivos al final
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>'; // Mostrar puntos suspensivos al final
                    }

                    if ($page + $range < $total_pages) { // Si la página actual más el rango es menor que el total de páginas
                        echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . '&cuenta=' . htmlspecialchars($cuenta_filtro) . '&estatus=' . htmlspecialchars($estatus_filtro) . '">' . $total_pages . '</a></li>'; // Mostrar el enlace a la última página
                    }
                ?>
                <!-- Botón de siguiente página -->
                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page + 1 ?>&cuenta=<?= htmlspecialchars($cuenta_filtro) ?>&estatus=<?= htmlspecialchars($estatus_filtro) ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="requisicionModal" tabindex="-1" aria-labelledby="productoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Información de la Requisición</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-striped mt-4">
                    <thead>
                        <tr class="table-primary"> 
                            <th colspan="2" scope="row"><center>Información General</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><th scope="row">Supervisor:</th><td id="infoSupervisor"></td></tr>
                        <tr><th scope="row">Cuenta:</th><td id="infoCuenta"></td></tr>
                        <tr><th scope="row">Región:</th><td id="infoRegion"></td></tr>
                        <tr><th scope="row">Centro de Trabajo:</th><td id="infoCentroTrabajo"></td></tr>
                        <tr><th scope="row">Número de Elementos:</th><td id="infoElementos"></td></tr>
                        <tr><th scope="row">Nombre del Receptor:</th><td id="infoReceptor"></td></tr>
                        <tr><th scope="row">Número de Teléfono del Receptor:</th><td id="infoTelReceptor"></td></tr>
                        <tr><th scope="row">RFC del Receptor:</th><td id="infoRfcReceptor"></td></tr>
                        <tr><th scope="row">Justificación:</th><td id="infoJustificacion"></td></tr>
                        <tr><th scope="row">Dirección:</th><td id="infoDireccion"></td></tr>
                    </tbody>
                </table>
                
                <table class="table table-hover table-striped mt-4">
                    <thead>
                        <tr class="table-primary"> 
                            <th colspan="5" scope="row"><center>Información del Producto</center></th>
                        </tr>
                    </thead>
                    <tbody id="productosBody">
                        <!-- Aquí se insertarán los productos dinámicamente -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="../../js/DescargarRequisicion.js"></script>
<script src="../../js/MostrarInfoRequisicion.js"></script>

<?php include('footer.php'); ?>