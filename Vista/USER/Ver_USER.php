<?php include('head.php'); ?>

<center>
<div class="table-responsive">
    <h2 class="mb-4">Estado de Requisición</h2>

    <!-- Formulario para seleccionar la cuenta y estatus -->
    <form method="GET" class="form-inline d-flex justify-content-end mb-4">
        <div class="form-group mb-2">
            <label for="cuenta" class="mr-2">Seleccionar Cuenta:</label>
            <select class="form-select" id="cuenta" name="cuenta">
                <!-- Las opciones de cuenta se cargarán aquí con PHP -->
                <?php
                include('../../Modelo/Conexion.php'); 
                $conexion = (new Conectar())->conexion();
                
                $sqlCuentas = "SELECT ID, NombreCuenta FROM Cuenta;";
                $resultCuentas = $conexion->query($sqlCuentas);
                while ($rowC = $resultCuentas->fetch_assoc()) {
                    echo '<option value="' . $rowC['ID'] . '">' . $rowC['NombreCuenta'] . '</option>';
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
        <thead>
            <tr class="table-primary"> 
                <th scope="col">Nmr.</th>
                <th scope="col">Nombre Solicitante</th>
                <th scope="col">Fecha</th>
                <th scope="col">Estatus</th>
                <th scope="col">Cuenta</th>
                <th scope="col">Centro de Trabajo</th>
                <th scope="col">Receptor</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_GET['cuenta'])) {
                $cuenta_filtro = $_GET['cuenta'];
                $estatus_filtro = isset($_GET['estatus']) ? $_GET['estatus'] : '';

                // Parámetros para la paginación
                $records_per_page = 10;
                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $records_per_page;

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

                if ($estatus_filtro) {
                    $sql .= " AND RE.Estatus = ?";
                }

                $sql .= " GROUP BY 
                            RE.IDRequisicionE
                        ORDER BY 
                            RE.FchCreacion DESC 
                        LIMIT 
                            ? OFFSET ?;";

                $stmt = $conexion->prepare($sql);
                if ($estatus_filtro) {
                    $stmt->bind_param("isii", $cuenta_filtro, $estatus_filtro, $records_per_page, $offset);
                } else {
                    $stmt->bind_param("iii", $cuenta_filtro, $records_per_page, $offset);
                }
                $stmt->execute();
                $result = $stmt->get_result();

                // Muestra los resultados en la tabla
                $has_records = false;
                while ($row = $result->fetch_assoc()) {
                    $has_records = true;
                    ?>
                        <tr>
                            <td><?php echo $row['IDRequisicionE']; ?></td>
                            <td><?php echo $row['Nombre'] . ' ' . $row['Apellido_Paterno'] . ' ' . $row['Apellido_Materno']; ?></td>
                            <td><?php echo $row['FchCreacion']; ?></td>
                            <td class="table-warning"><?php echo $row['Estatus']; ?></td>
                            <td><?php echo $row['NombreCuenta']; ?></td>
                            <td><?php echo $row['CentroTrabajo']; ?></td>
                            <td><?php echo $row['Receptor']; ?></td>
                            <td><a class="btn btn-success" href="Visualizar/Infor_Requisicion.php?id=<?php echo $row['IDRequisicionE']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-filled" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 4c4.29 0 7.863 2.429 10.665 7.154l.22 .379l.045 .1l.03 .083l.014 .055l.014 .082l.011 .1v.11l-.014 .111a.992 .992 0 0 1 -.026 .11l-.039 .108l-.036 .075l-.016 .03c-2.764 4.836 -6.3 7.38 -10.555 7.499l-.313 .004c-4.396 0 -8.037 -2.549 -10.868 -7.504a1 1 0 0 1 0 -.992c2.831 -4.955 6.472 -7.504 10.868 -7.504zm0 5a3 3 0 1 0 0 6a3 3 0 0 0 0 -6z" stroke-width="0" fill="currentColor" />
                                </svg>Ver</a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning BtnDescargarRequisicion" data-id="<?php echo $row['IDRequisicionE']; ?>">
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

                if (!$has_records) {
                    echo '<tr><td colspan="8" class="text-center">No se encontraron registros para la cuenta y estatus seleccionados.</td></tr>';
                }

                $stmt->close();

                // Total de registros para paginación con filtrado
                $sql_total = "SELECT COUNT(*) AS total FROM RequisicionE RE
                    INNER JOIN Usuario U ON RE.IdUsuario = U.ID_Usuario
                    WHERE RE.IdCuenta = ?";
                    
                if ($estatus_filtro) {
                    $sql_total .= " AND RE.Estatus = ?";
                }
                
                $stmt_total = $conexion->prepare($sql_total);
                if ($estatus_filtro) {
                    $stmt_total->bind_param("ss", $cuenta_filtro, $estatus_filtro);
                } else {
                    $stmt_total->bind_param("s", $cuenta_filtro);
                }
                $stmt_total->execute();
                $result_total = $stmt_total->get_result();
                $total_rows = $result_total->fetch_assoc()['total'];
                $total_pages = ceil($total_rows / $records_per_page);
                
                $conexion->close();
            } else {
                echo '<tr><td colspan="8" class="text-center">Debe seleccionar una cuenta para filtrar.</td></tr>';
            }
            ?>
        </tbody>
    </table>

    <?php if (isset($_GET['cuenta'])): ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>&cuenta=<?php echo htmlspecialchars($cuenta_filtro); ?>&estatus=<?php echo htmlspecialchars($estatus_filtro); ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&cuenta=<?php echo htmlspecialchars($cuenta_filtro); ?>&estatus=<?php echo htmlspecialchars($estatus_filtro); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

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
</center>

<?php include('footer.php'); ?>