<?php include('head.php'); ?>

<center><div class="table-responsive">
    <h2 class="mb-4">Salidas</h2>
    <!-- Tabla para mostrar los registros -->
    <table id="requisicionesTable" class="table table-hover table-striped mt-4" class="table">
        <thead>
            <tr class="table-primary"> 
                <th scope="col">Nmr.</th>
                <th scope="col">Estatus</th>
                <th scope="col">Solicitante</th>
                <th scope="col">Centro de Trabajo</th>
                <th scope="col">Fecha de Solicitud</th>
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
                            RE.IDRequisicionE, 
                            RE.Estatus AS Estado,
                            RE.Receptor, 
                            RE.CentroTrabajo, 
                            RE.FchAutoriza
                        FROM 
                            RequisicionE RE
                        WHERE 
                            RE.Estatus = 'Autorizado'
                        ORDER BY 
                            FchAutoriza DESC
                        LIMIT 
                            $records_per_page OFFSET $offset;";
                    
                $query = mysqli_query($conexion, $sql);
                
                // Consulta para contar el total de registros con los mismos filtros
                $sql_total = "SELECT 
                                COUNT(DISTINCT RE.IDRequisicionE) AS total
                            FROM 
                                RequisicionD RD 
                            INNER JOIN 
                                RequisicionE RE on RD.IdReqE = RE.IDRequisicionE
                            WHERE 
                                RE.Estatus = 'Autorizado';";
                
                $result_total = mysqli_query($conexion, $sql_total);
                $total_rows = mysqli_fetch_array($result_total)['total'];
                $total_pages = ceil($total_rows / $records_per_page);

                while ($row = mysqli_fetch_array($query)) {
            ?>
                    <tr>
                        <td><?php echo $row['IDRequisicionE']; ?></td>
                        <td><?php echo $row['Estado']; ?></td>
                        <td><?php echo $row['Receptor']; ?></td>
                        <td><?php echo $row['CentroTrabajo']; ?></td>
                        <td><?php echo $row['FchAutoriza']; ?></td>
                        <td><a class="btn btn-primary" href="INSERT/Insert_Salida_ALMACENISTA.php?id=<?php echo $row['IDRequisicionE']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ballpen" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M14 6l7 7l-4 4" />
                                <path d="M5.828 18.172a2.828 2.828 0 0 0 4 0l10.586 -10.586a2 2 0 0 0 0 -2.829l-1.171 -1.171a2 2 0 0 0 -2.829 0l-10.586 10.586a2.828 2.828 0 0 0 0 4z" />
                                <path d="M4 20l1.768 -1.768" />
                            </svg>Salida</a>
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

<script src="../../js/Ocultar_Estatus.js"></script>

<?php include('footer.php'); ?>