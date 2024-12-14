<?php include('head.php'); ?>

<center><div class="table-responsive">
        <h2 class="mb-4">Borradores Registrados</h2>
            <!-- Botones -->
            <a class="btn btn-primary" href="INSERT/Insert_Solicitud_USER.php">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                    <path d="M16 19h6" />
                    <path d="M19 16v6" />
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                </svg>Nuevo</a>
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
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $usuario = $_SESSION['usuario'];
                
                // Asegúrate de tener el resultado de la consulta asignado a $query antes de este bloque
                include('../../Modelo/Conexion.php'); 
                $conexion = (new Conectar())->conexion();
                
                // Parámetros para la paginación
                $records_per_page = 10;
                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $records_per_page;
                
                $sql = "SELECT 
                            BRE.BIDRequisicionE, U.Nombre, U.Apellido_Paterno, U.Apellido_Materno,
                            BRE.BFchCreacion, BRE.BEstatus, C.NombreCuenta, BRE.BCentroTrabajo, BRE.BJustificacion,
                            BRE.BReceptor FROM Borrador_RequisicionE BRE
                        INNER JOIN 
                            Usuario U ON BRE.BIdUsuario = U.ID_Usuario
                        INNER JOIN
                            Usuario_Cuenta UC ON U.ID_Usuario = UC.ID_Usuarios
                        LEFT JOIN
                            Cuenta C ON UC.ID_Cuenta = C.ID
                        WHERE 
                            U.Correo_Electronico = '$usuario'
                        GROUP BY 
                            BRE.BIDRequisicionE
                        ORDER BY 
                            BRE.BFchCreacion DESC
                        LIMIT 
                            $records_per_page OFFSET $offset;";
                
                $query = mysqli_query($conexion, $sql);
                
                // Total de registros
                $sql_total = "SELECT COUNT(DISTINCT RE.BIDRequisicionE) AS total 
                                FROM Borrador_RequisicionE RE 
                            INNER JOIN 
                                Usuario U ON RE.BIdUsuario = U.ID_Usuario 
                            WHERE 
                                U.Correo_Electronico = '$usuario';";
                                
                $result_total = mysqli_query($conexion, $sql_total);
                $total_rows = mysqli_fetch_array($result_total)['total'];
                $total_pages = ceil($total_rows / $records_per_page);

                while ($row = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                        <td><?php echo $row['BIDRequisicionE']; ?></td>
                        <td><?php echo $row['Nombre'] . ' ' . $row['Apellido_Paterno'] . ' '. $row['Apellido_Materno'];?></td>
                        <td><?php echo $row['BFchCreacion']; ?></td>
                        <td><?php echo $row['BEstatus']; ?></td>
                        <td><?php echo $row['NombreCuenta']; ?></td>
                        <td><?php echo $row['BJustificacion']; ?></td>
                        <td><a class="btn btn-warning" href="Update/Update_Solicitud_USER.php?id=<?php echo $row['BIDRequisicionE']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg>Actualizar</a>
                        </td>
                        <td><a class="btn btn-success" href="Visualizar/Infor_Borrador.php?id=<?php echo $row['BIDRequisicionE']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-filled" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 4c4.29 0 7.863 2.429 10.665 7.154l.22 .379l.045 .1l.03 .083l.014 .055l.014 .082l.011 .1v.11l-.014 .111a.992 .992 0 0 1 -.026 .11l-.039 .108l-.036 .075l-.016 .03c-2.764 4.836 -6.3 7.38 -10.555 7.499l-.313 .004c-4.396 0 -8.037 -2.549 -10.868 -7.504a1 1 0 0 1 0 -.992c2.831 -4.955 6.472 -7.504 10.868 -7.504zm0 5a3 3 0 1 0 0 6a3 3 0 0 0 0 -6z" stroke-width="0" fill="currentColor" />
                            </svg>Visualizar</a>
                        </td>
                        <td><a class="btn btn-danger" onclick="return eliminar()" href="../../Controlador/USER/DELETE/Funcion_Delete_Solicitud.php?id=<?php echo $row['BIDRequisicionE']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x-filled" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16zm-9.489 5.14a1 1 0 0 0 -1.218 1.567l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.497 1.32l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.32 -1.497l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.497 -1.32l-1.293 1.292l-1.293 -1.292l-.094 -.083z" stroke-width="0" fill="currentColor" />
                                <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor" />
                            </svg>Eliminar</a>
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

<?php include('footer.php'); ?>