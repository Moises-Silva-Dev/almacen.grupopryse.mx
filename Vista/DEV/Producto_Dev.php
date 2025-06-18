<?php include('head.php'); ?>
<!-- Contenedor de las alertas -->            
<div class="table-responsive">
    <center>
        <h2 class="mb-4">Productos Registrados</h2>
        <!-- Botones -->
        <a class="btn btn-primary mb-3" href="INSERT/Insert_Producto_Dev.php">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                <path d="M16 19h6" />
                <path d="M19 16v6" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
            </svg> Nuevo Producto
        </a>
    </center>
    <!-- Tabla para mostrar los registros -->
    <table class="table table-hover table-striped mt-4">
        <thead class="table-light">
            <tr> 
                <th scope="col">#</th>
                <th scope="col">Empresa</th>
                <th scope="col">Categoria</th>
                <th scope="col">Tipo</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Especificacion</th>
                <th colspan="3" scope="col"><center>Acciones</center></th>
            </tr>
        </thead>
        <tbody>
            <?php
                try {
                    $conexion = (new Conectar())->conexion(); // Crear una nueva instancia de la clase Conectar y obtener la conexión
                
                    $records_per_page = 10; // Número de registros por página
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Obtener la página actual, por defecto es 1
                    $offset = ($page - 1) * $records_per_page; // Calcular el offset para la consulta SQL
                    
                    // Consulta SQL con LIMIT y OFFSET
                    $sql = "SELECT * FROM Producto P
                            INNER JOIN 
                                CEmpresas CE on P.IdCEmp = CE.IdCEmpresa
                            INNER JOIN 
                                CCategorias CC on P.IdCCat = CC.IdCCate
                            INNER JOIN 
                                CTipoTallas CTT on P.IdCTipTal = CTT.IdCTipTall
                            ORDER BY 
                                IdCProducto
                            LIMIT
                                ? OFFSET ?";
                    
                    $stmt = $conexion->prepare($sql); // Preparar la consulta SQL
                    $stmt->bind_param("ii", $records_per_page, $offset); // Vincular los parámetros a la consulta
                    $stmt->execute(); // Ejecutar la consulta                    
                    $query = $stmt->get_result(); // Obtener el resultado de la consulta
                                        
                    $sql_total = "SELECT COUNT(*) FROM Producto"; // Consulta para obtener el total de registros
                    $result_total = mysqli_query($conexion, $sql_total); // Ejecutar la consulta para obtener el total de registros
                    $total_rows = mysqli_fetch_array($result_total)[0]; // Obtener el total de registros
                    $total_pages = ceil($total_rows / $records_per_page); // Calcular el total de páginas

                    while ($row = mysqli_fetch_array($query)) { // Iterar sobre los resultados
                        $IdCProducto = htmlspecialchars($row['IdCProducto'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $Nombre_Empresa = htmlspecialchars($row['Nombre_Empresa'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $Descrp = htmlspecialchars($row['Descrp'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $Descrip = htmlspecialchars($row['Descrip'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $Descripcion = htmlspecialchars($row['Descripcion'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
                        $Especificacion = htmlspecialchars($row['Especificacion'], ENT_QUOTES, 'UTF-8'); // Escapar los datos para prevenir XSS
            ?>
                        <tr class="table-light">
                            <td><?php echo $IdCProducto; ?></td>
                            <td><?php echo $Nombre_Empresa; ?></td>
                            <td><?php echo $Descrp; ?></td>
                            <td><?php echo $Descrip; ?></td>
                            <td><?php echo $Descripcion; ?></td>
                            <td><?php echo $Especificacion; ?></td>
                            <td>
                                <a class="btn btn-warning" href="Update/Update_Producto_Dev.php?id=<?php echo $IdCProducto; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                    </svg>Modificar
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-danger" onclick="eliminarRegistroProducto(<?php echo $IdCProducto; ?>)" href="javascript:void(0);">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16zm-9.489 5.14a1 1 0 0 0 -1.218 1.567l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.497 1.32l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.32 -1.497l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.497 -1.32l-1.293 1.292l-1.293 -1.292l-.094 -.083z" stroke-width="0" fill="currentColor" />
                                        <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor" />
                                    </svg>Eliminar
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-success" onclick="mostrarProducto(<?php echo $IdCProducto; ?>)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>Visualizar
                                </a>
                            </td>
                        </tr>
            <?php
                    }
                } catch (Exception $e) {
                    error_log("Error en el sistema: " . $e->getMessage()); // Registrar el error en el log del servidor
                    echo "<div class='alert alert-danger'>Ocurrió un error al procesar la solicitud. Por favor, inténtelo de nuevo más tarde.</div>"; // Mostrar un mensaje de error en la página
                } finally {
                    $stmt->close(); // Cerrar la declaración preparada
                    $result_total->close(); // Cerrar el resultado de la consulta total
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
<!-- Modal -->
<div class="modal fade" id="productoModal" tabindex="-1" aria-labelledby="productoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productoModalLabel">Detalles del Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="productoIMG" src="" alt="Imagen del Producto" class="img-fluid rounded">
                    </div>
                    <div class="col-md-6">
                        <br>
                        <h4 style="font-size: 30px;" id="productoDescripcion"></h4>
                        <br>
                        <p style="font-size: 20px;">
                            <strong>Especificaciones:</strong>
                            <br>
                            <span id="productoEspecificacion"></span>
                        </p>
                        <p style="font-size: 20px;">
                            <strong>Empresa:</strong>
                            <br>
                            <span id="productoEmpresa"></span>
                        </p>
                        <p style="font-size: 20px;">
                            <strong>Categoría:</strong>
                            <br>
                            <span id="productoCategoria"></span>
                        </p>
                        <p style="font-size: 20px;">
                            <strong>Tipo de Talla:</strong>
                            <br>
                            <span id="productoTipoTalla"></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Eliminar_Producto.js"></script>
<script src="../../js/MostrarFotoProductoInfo.js"></script>

<?php include('footer.php'); ?>