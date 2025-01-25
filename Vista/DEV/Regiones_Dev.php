<?php include('head.php'); ?>

<center>
    <div class="table-responsive">
        <h2 class="mb-4">Regiones Registradas</h2>
        
        <!-- Botón para agregar una nueva región -->
        <a class="btn btn-primary" href="INSERT/Insert_Region_Dev.php">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                <path d="M16 19h6" />
                <path d="M19 16v6" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
            </svg> Nuevo
        </a>
                
        <!-- Formulario para seleccionar el estatus, alineado a la derecha -->
        <form method="GET" class="form-inline d-flex justify-content-end mb-4">
            <div class="form-group mb-2">
                <label for="estatus" class="mr-2">Filtrar por estatus:</label>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <select class="form-select" id="cuenta" name="cuenta">
                    <!-- Las opciones de cuenta se cargaron aquí con PHP -->
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
            <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
        </form>
    
        <!-- Tabla para mostrar los registros -->
        <table class="table table-hover table-striped mt-4">
            <thead>
                <tr class="table-primary">
                    <th scope="col">Nmr.</th>
                    <th scope="col">Nombre de la Regi車n</th>
                    <th scope="col">Nombre de Cuenta</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (isset($_GET['cuenta']) && is_numeric($_GET['cuenta'])) {
                        $cuenta_filtro = (int)$_GET['cuenta'];

                        // Par芍metros para la paginaci車n
                        $records_per_page = 10;
                        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($page - 1) * $records_per_page;

                        // Consulta SQL con el filtro
                        $sql = "SELECT R.ID_Region, R.Nombre_Region, C.NombreCuenta 
                                FROM Regiones R
                                INNER JOIN Cuenta_Region CR ON R.ID_Region = CR.ID_Regiones
                                INNER JOIN Cuenta C ON CR.ID_Cuentas = C.ID
                                WHERE C.ID = ? 
                                LIMIT ? OFFSET ?";

                        $stmt = $conexion->prepare($sql);
                        $stmt->bind_param("iii", $cuenta_filtro, $records_per_page, $offset);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Muestra los resultados en la tabla
                        $has_records = false;
                        while ($row = $result->fetch_assoc()) {
                            $has_records = true;
                            ?>
                                <tr class="table-light">
                                    <td><?php echo $row['ID_Region']; ?></td>
                                    <td><?php echo $row['Nombre_Region']; ?></td>
                                    <td><?php echo $row['NombreCuenta']; ?></td>
                                    <td><a class="btn btn-warning" href="Update/Update_Region_Dev.php?id=<?php echo $row['ID_Region']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                <path d="M16 5l3 3" />
                                            </svg> Actualizar
                                        </a>
                                    </td>
                                    <td><a class="btn btn-danger" onclick="eliminarRegistroRegion(<?php echo $row['ID_Region']; ?>)" href="javascript:void(0);">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x-filled" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16zm-9.489 5.14a1 1 0 0 0 -1.218 1.567l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.497 1.32l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.32 -1.497l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.497 -1.32l-1.293 1.292l-1.293 -1.292l-.094 -.083z" stroke-width="0" fill="currentColor" />
                                                <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor" />
                                            </svg> Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php
                        }
                        
                        if (!$has_records) {
                            echo '<tr><td colspan="8" class="text-center">No se encontraron registros para la cuenta seleccionada.</td></tr>';
                        }
        
                        $stmt->close();

                        // Consulta para el total de registros para la paginaci車n
                        $sql_total = "SELECT COUNT(*) AS total FROM Regiones R 
                                      INNER JOIN Cuenta_Region CR ON R.ID_Region = CR.ID_Regiones 
                                      INNER JOIN Cuenta C ON CR.ID_Cuentas = C.ID
                                      WHERE C.ID = ?";
                        
                        $stmt_total = $conexion->prepare($sql_total);
                        $stmt_total->bind_param("i", $cuenta_filtro);
                        $stmt_total->execute();
                        $result_total = $stmt_total->get_result();
                        $total_records = $result_total->fetch_assoc()['total'];
                        $total_pages = ceil($total_records / $records_per_page);
                        $stmt_total->close();
                    } else {
                        echo '<tr><td colspan="8" class="text-center">Debe seleccionar una cuenta para filtrar.</td></tr>';
                    }
                ?>
            </tbody>
        </table>

        <!-- Paginaci車n -->
        <?php if (isset($total_pages) && $total_pages > 1): ?>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?cuenta=<?php echo $cuenta_filtro; ?>&page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?cuenta=<?php echo $cuenta_filtro; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>
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
</center>

<script src="../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Eliminar_Region.js"></script>

<?php include('footer.php'); ?>