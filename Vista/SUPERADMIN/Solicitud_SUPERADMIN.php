<?php include('head.php'); ?>
<style>
    .disabled {
        pointer-events: none;
        opacity: 0.6;
    }
</style>
<center><div class="table-responsive">
        <h2 class="mb-4">Solicitud Registrados</h2>
        <!-- Tabla para mostrar los registros -->
        <table id="tablaSolicitudes" class="table table-hover table-striped mt-4" class="table">
            <thead>
                <tr class="table-primary"> 
                    <th scope="col">Nmr.</th>
                    <th scope="col">Nombre Solicitante</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Cuenta</th>
                    <th scope="col">Justificación</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Asegúrate de tener el resultado de la consulta asignado a $query antes de este bloque
                include('../../Modelo/Conexion.php'); 
                $conexion = (new Conectar())->conexion();
                
                // Parámetros para la paginación
                $records_per_page = 10;
                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $records_per_page;
                    
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
                            $records_per_page OFFSET $offset;";
                
                $query = mysqli_query($conexion, $sql);
                
                // Total de registros
                $sql_total = "SELECT COUNT(DISTINCT IDRequisicionE) AS total FROM RequisicionE";
                $result_total = mysqli_query($conexion, $sql_total);
                $total_rows = mysqli_fetch_array($result_total)['total'];
                $total_pages = ceil($total_rows / $records_per_page);

                while ($row = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                        <td><?php echo $row['IDRequisicionE']; ?></td>
                        <td><?php echo $row['Nombre'] . ' ' . $row['Apellido_Paterno'] . ' '. $row['Apellido_Materno'];?></td>
                        <td><?php echo $row['FchCreacion']; ?></td>
                        <td><?php echo $row['Estatus']; ?></td>
                        <td><?php echo $row['NombreCuenta']; ?></td>
                        <td><?php echo $row['Justificacion']; ?></td>
                        <td><a class="btn btn-success" href="Visualizar/Infor_Solicitud.php?id=<?php echo $row['IDRequisicionE']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ballpen-filled" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24V0H24z" fill="none"/>
                                <path d="M17.828 2a3 3 0 0 1 1.977 .743l.145 .136l1.171 1.17a3 3 0 0 1 .136 4.1l-.136 .144l-1.706 1.707l2.292 2.293a1 1 0 0 1 .083 1.32l-.083 .094l-4 4a1 1 0 0 1 -1.497 -1.32l.083 -.094l3.292 -3.293l-1.586 -1.585l-7.464 7.464a3.828 3.828 0 0 1 -2.474 1.114l-.233 .008c-.674 0 -1.33 -.178 -1.905 -.508l-1.216 1.214a1 1 0 0 1 -1.497 -1.32l.083 -.094l1.214 -1.216a3.828 3.828 0 0 1 .454 -4.442l.16 -.17l10.586 -10.586a3 3 0 0 1 1.923 -.873l.198 -.006zm0 2a1 1 0 0 0 -.608 .206l-.099 .087l-1.707 1.707l2.586 2.585l1.707 -1.706a1 1 0 0 0 .284 -.576l.01 -.131a1 1 0 0 0 -.207 -.609l-.087 -.099l-1.171 -1.171a1 1 0 0 0 -.708 -.293z" stroke-width="0" fill="currentColor" />
                            </svg>Autorizar</a>
                        </td>
                        <td><a class="btn btn-warning" onclick="SolicitarModificacionRequisicion(<?php echo $row['IDRequisicionE']; ?>)" href="javascript:void(0);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send-2" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4.698 4.034l16.302 7.966l-16.302 7.966a.503 .503 0 0 1 -.546 -.124a.555 .555 0 0 1 -.12 -.568l2.468 -7.274l-2.468 -7.274a.555 .555 0 0 1 .12 -.568a.503 .503 0 0 1 .546 -.124z" />
                                <path d="M6.5 12h14.5" />
                            </svg>Solcititar Modificación</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php endfor; ?>

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

<?php include('footer.php'); ?>