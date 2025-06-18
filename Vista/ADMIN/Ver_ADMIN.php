<?php include('head.php'); ?>
<!-- Contenedor de las alertas -->            
<div class="table-responsive">    
    <center>
        <h2 class="mb-4">Estado de Requisición</h2>
    </center>
    <!-- Formulario para seleccionar el estatus, alineado a la derecha -->
    <form method="GET" class="form-inline d-flex justify-content-end mb-4">
        <div class="form-group mb-2">
            <label for="estatus" class="mr-2">Filtrar por estatus:</label>
        </div>
        <div class="form-group mx-sm-3 mb-2">
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
                    $usuario = $_SESSION['usuario']; // Obtener el correo electrónico del usuario desde la sesión
                    $estatus_filtro = isset($_GET['estatus']) ? htmlspecialchars($_GET['estatus']) : ''; // Obtener el estatus del filtro, si existe
        
                    $conexion = (new Conectar())->conexion(); // Crear una nueva instancia de la clase Conectar y obtener la conexión a la base de datos
        
                    $records_per_page = 10; // Número de registros por página
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual, por defecto es 1
                    $offset = ($page - 1) * $records_per_page; // Calcular el desplazamiento para la consulta SQL

                    // Consulta principal con filtrado por estatus
                    $sql = "SELECT RE.IDRequisicionE, U.Nombre, U.Apellido_Paterno, U.Apellido_Materno,
                                RE.FchCreacion, RE.Estatus, C.NombreCuenta, RE.CentroTrabajo,
                                RE.Receptor FROM RequisicionE RE
                            INNER JOIN 
                                Usuario U ON RE.IdUsuario = U.ID_Usuario
                            INNER JOIN 
                                Cuenta C ON RE.IdCuenta = C.ID
                            WHERE 
                                U.Correo_Electronico = ?";
                    
                    if (!empty($estatus_filtro)) { // Si hay filtro de estatus
                        $sql .= " AND RE.Estatus = ?"; // Agregar filtro de estatus si existe
                    }

                    $sql .= " GROUP BY 
                                RE.IDRequisicionE
                            ORDER 
                                BY RE.FchCreacion DESC 
                            LIMIT 
                                ? OFFSET ?";

                    $stmt = $conexion->prepare($sql); // Preparar la consulta SQL
                    if (!$stmt) { // Manejo de errores al preparar la consulta
                        throw new Exception("Error al preparar la consulta: " . $conexion->error);
                    }
                    
                    // Bind parameters según si hay filtro o no
                    if (!empty($estatus_filtro)) {
                        $stmt->bind_param("ssii", $usuario, $estatus_filtro, $records_per_page, $offset); // Si hay filtro de estatus, agregarlo al bind_param
                    } else {
                        $stmt->bind_param("sii", $usuario, $records_per_page, $offset); // Si no hay filtro de estatus, solo bind el usuario y los parámetros de paginación
                    }
                    
                    $stmt->execute(); // Ejecutar la consulta preparada
                    $result = $stmt->get_result(); // Obtener el resultado de la consulta ejecutada

                    // Mostrar resultados
                    while ($row = $result->fetch_assoc()) {
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
                                <a class="btn btn-success" onclick="mostrarInfoRequisicion(<?php echo $IDRequisicionE; ?>)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M12 4c4.29 0 7.863 2.429 10.665 7.154l.22 .379l.045 .1l.03 .083l.014 .055l.014 .082l.011 .1v.11l-.014 .111a.992 .992 0 0 1 -.026 .11l-.039 .108l-.036 .075l-.016 .03c-2.764 4.836 -6.3 7.38 -10.555 7.499l-.313 .004c-4.396 0 -8.037 -2.549 -10.868 -7.504a1 1 0 0 1 0 -.992c2.831 -4.955 6.472 -7.504 10.868 -7.504zm0 5a3 3 0 1 0 0 6a3 3 0 0 0 0 -6z" stroke-width="0" fill="currentColor" />
                                </svg>Ver</a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning BtnDescargarRequisicion" data-id="<?php echo $IDRequisicionE; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="1.5"> 
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
                    
                    // Consulta para el total de registros (con filtro si existe)
                    $sql_total = "SELECT COUNT(*) AS total FROM RequisicionE RE
                        INNER JOIN 
                            Usuario U ON RE.IdUsuario = U.ID_Usuario
                        WHERE 
                            U.Correo_Electronico = ?"; 
                        
                    if (!empty($estatus_filtro)) { // Si hay filtro de estatus, agregar condición
                        $sql_total .= " AND RE.Estatus = ?"; // Agregar filtro de estatus si existe
                    }
                    
                    $stmt_total = $conexion->prepare($sql_total); // Preparar la consulta para obtener el total de registros
                    if (!$stmt_total) { // Manejo de errores al preparar la consulta
                        throw new Exception("Error al preparar la consulta de conteo: " . $conexion->error); // Manejo de errores al preparar la consulta
                    }
                    
                    if (!empty($estatus_filtro)) { // Si hay filtro de estatus, bind ambos parámetros
                        $stmt_total->bind_param("ss", $usuario, $estatus_filtro); // Bind el usuario y el estatus si hay filtro
                    } else { 
                        $stmt_total->bind_param("s", $usuario); // Bind solo el usuario si no hay filtro de estatus
                    }
                    
                    if (!$stmt_total->execute()) { // Manejo de errores al ejecutar la consulta
                        throw new Exception("Error al ejecutar la consulta de conteo: " . $stmt_total->error); // Manejo de errores al ejecutar la consulta
                    }
                    
                    $result_total = $stmt_total->get_result(); // Ejecutar la consulta para obtener el total de registros
                    $total_data = $result_total->fetch_assoc(); // Obtener el total de registros
                    $total_rows = $total_data['total']; // Obtener el total de registros
                    $total_pages = ceil($total_rows / $records_per_page); // Cálculo de la cantidad de páginas         
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
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center flex-wrap text-center">
            <!-- Botón anterior -->
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&estatus=<?php echo htmlspecialchars($estatus_filtro); ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php
                $range = 2; // Cantidad de páginas a mostrar a la izquierda y derecha de la actual
                $show_dots_start = false; // Flag para mostrar puntos suspensivos antes de la primera página
                $show_dots_end = false; // Flag para mostrar puntos suspensivos después de la última página

                if ($page > $range + 2) { // Si la página actual está más allá del rango inicial
                    echo '<li class="page-item"><a class="page-link" href="?page=1&estatus=' . htmlspecialchars($estatus_filtro) . '">1</a></li>';
                    $show_dots_start = true; // Indicar que se deben mostrar puntos suspensivos al inicio
                }

                if ($show_dots_start) { // Mostrar puntos suspensivos al inicio
                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>'; // Puntos suspensivos
                }

                for ($i = max(1, $page - $range); $i <= min($total_pages, $page + $range); $i++) { // Mostrar páginas del rango central
                    $active = $i == $page ? 'active' : ''; // Marcar la página actual como activa
                    echo '<li class="page-item ' . $active . '">
                            <a class="page-link" href="?page=' . $i . '&estatus=' . htmlspecialchars($estatus_filtro) . '">' . $i . '</a>
                        </li>'; // Enlace a la página
                }

                if ($page + $range < $total_pages - 1) { // Si la página actual está más cerca del final que del rango
                    $show_dots_end = true; // Indicar que se deben mostrar puntos suspensivos al final
                }

                if ($show_dots_end) { // Mostrar puntos suspensivos al final
                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>'; // Puntos suspensivos
                }

                if ($page + $range < $total_pages) { // Si la página actual está más cerca del inicio que del rango
                    echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . '&estatus=' . htmlspecialchars($estatus_filtro) . '">' . $total_pages . '</a></li>'; // Enlace a la última página
                }
            ?>
            <!-- Botón siguiente -->
            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&estatus=<?php echo htmlspecialchars($estatus_filtro); ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
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