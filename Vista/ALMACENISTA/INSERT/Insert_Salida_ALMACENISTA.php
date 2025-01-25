<?php include('head.php'); ?>

<?php
include('../../../Modelo/Conexion.php'); 
$conexion = (new Conectar())->conexion();

// Verifica si la variable $_GET['id'] está definida y no es nula
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Obtiene el ID de requisición seleccionado
    $requisicion_id = $_GET["id"]; 

    //Obtener informacion de la Requisicion
    $sql1 = $conexion->prepare("SELECT C.NombreCuenta, RE.Supervisor, R.Nombre_Region,
        RE.CentroTrabajo, RE.Receptor, RE.TelReceptor, RE.RfcReceptor, RE.Justificacion,
        RE.Mpio, RE.Colonia, RE.Calle, RE.Nro, RE.CP, E.Nombre_estado FROM RequisicionE RE
        INNER JOIN Usuario U on RE.IdUsuario = U.ID_Usuario
        INNER JOIN Estados E on RE.IdEstado = E.Id_Estado
        INNER JOIN Regiones R on RE.IdRegion = R.ID_Region
        INNER JOIN Cuenta C on RE.IdCuenta = C.ID
    WHERE RE.IDRequisicionE = ?;");

    $sql1->bind_param("i", $requisicion_id);
    $sql1->execute();
    $result1 = $sql1->get_result(); // Obtener el resultado de la consulta
    $row = $result1->fetch_assoc(); // Obtener la fila de resultados como una matriz asociativa

    //validar si ya se hizo una salida
    $sql2 = $conexion->prepare("SELECT * FROM Salida_D 
            INNER JOIN Salida_E SE ON Salida_D.Id = SE.Id_SalE 
                WHERE ID_ReqE=?;");

    $sql2->bind_param("i", $requisicion_id);
    $sql2->execute();
    $resultado2 = $sql2->get_result(); // Obtener el resultado de la consulta

    if ($resultado2->num_rows > 0) {
        // Consulta para obtener la información adicional de los productos relacionados
        $sql3 = $conexion->prepare("SELECT
            rd.IdCProd AS Identificador_Producto,
            p.Descripcion AS Descripcion_Producto,
            rd.IdTalla AS Identificador_Talla,
            ct.Talla AS Talla_Requisicion,
            rd.Cantidad AS Solicitado,
            COALESCE(sd.Entregada, 0) AS Entregada,
            CASE
                WHEN rd.Cantidad - COALESCE(sd.Entregada, 0) <= 0 THEN 0
                ELSE rd.Cantidad - COALESCE(sd.Entregada, 0)
            END AS Faltante,
            i.Cantidad AS Cantidad_Disponible,
            p.IMG AS IMG_Producto
        FROM
            RequisicionD rd
        JOIN
            Producto p ON rd.IdCProd = p.IdCProducto
        LEFT JOIN
            (
                SELECT 
                    IdCProd, IdTallas, SUM(Cantidad) AS Entregada
                FROM 
                    Salida_D
                WHERE 
                    Id IN (SELECT Id_SalE FROM Salida_E WHERE ID_ReqE = ?)
                GROUP BY 
                    IdCProd, IdTallas
            ) sd ON rd.IdCProd = sd.IdCProd AND rd.IdTalla = sd.IdTallas
        LEFT JOIN
            Inventario i ON rd.IdCProd = i.IdCPro AND rd.IdTalla = i.IdCTal
        LEFT JOIN
            CTallas ct ON rd.IdTalla = ct.IdCTallas
        WHERE
            rd.IdReqE = ?
        GROUP BY
            rd.IdCProd, p.Descripcion, rd.IdTalla, ct.Talla, rd.Cantidad, i.Cantidad, p.IMG;");

        $sql3->bind_param("ii", $requisicion_id, $requisicion_id);
        $sql3->execute();
        $result3 = $sql3->get_result();

    } else {
        // Consulta para obtener la información adicional de los productos relacionados
        $sql3 = $conexion->prepare("SELECT 
                rd.IdCProd AS Identificador_Producto,
                p.Descripcion AS Descripcion_Producto,
                rd.IdTalla AS Identificador_Talla,
                ct.Talla AS Talla_Requisicion,
                p.IMG AS IMG_Producto, 
                rd.Cantidad AS Solicitado, 
                i.Cantidad AS Cantidad_Disponible  
                FROM
                    RequisicionD rd
                JOIN
                    Producto p ON rd.IdCProd = p.IdCProducto
                LEFT JOIN
                    Salida_D sd ON rd.IdCProd = sd.IdCProd AND rd.IdTalla = sd.IdTallas
                LEFT JOIN
                    Inventario i ON rd.IdCProd = i.IdCPro AND rd.IdTalla = i.IdCTal
                LEFT JOIN
                    CTallas ct ON rd.IdTalla = ct.IdCTallas
                WHERE 
                    rd.IdReqE = ?
                GROUP BY
                    rd.IdCProd, rd.IdTalla;");

                $sql3->bind_param("i", $requisicion_id);
                $sql3->execute();
                $result3 = $sql3->get_result();
    }

} else {
    // Manejar la situación donde el parámetro "id" no está presente en la URL
    exit("El parámetro 'id' no está presente en la URL o es inválido.");
}
?>

<div class="container mt-5">
    <center><h2>Registrar Salida</h2></center>
    <!-- Formulario -->
    <form id="FormInsertSalidaNueva" class="needs-validation" action="../../../Controlador/Usuarios/INSERT/Funcion_Insert_Salida.php" method="post" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="ID_RequisicionE" id="ID_RequisicionE" value="<?php echo $requisicion_id; ?>">
        <input type="hidden" id="datosTablaInsertSalida" name="datosTablaInsertSalida">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header " id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Información General
                    </button>
                </h2>  
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="mb-3">
                            <label for="Administrador" class="form-label">Cuenta:</label>
                            <input type="text" class="form-control" value="<?php echo $row['NombreCuenta'] ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="Supervisor" class="form-label">Supervisor:</label>
                            <input type="text" class="form-control" value="<?php echo $row['Supervisor'] ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="Region" class="form-label">Región:</label>
                            <input type="text" class="form-control" value="<?php echo $row['Nombre_Region'] ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="CentroTrabajo" class="form-label">Centro de Trabajo:</label>
                            <input type="text" class="form-control" value="<?php echo $row['CentroTrabajo'] ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="Receptor" class="form-label">Nombre del Receptor:</label>
                            <input type="text" class="form-control" value="<?php echo $row['Receptor'] ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="num_tel" class="form-label">Número de Teléfono del Receptor:</label>
                            <input type="tel" class="form-control" value="<?php echo $row['TelReceptor'] ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="RFC" class="form-label">RFC del Receptor:</label>
                            <input type="text" class="form-control" value="<?php echo $row['RfcReceptor'] ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="RFC" class="form-label">Dirección:</label>
                            <?php
                                $direccion = "";
                                
                                // Concatenar los valores si están definidos y no están vacíos
                                if (!empty(trim($row['Mpio']))) {
                                    $direccion .= "{$row['Mpio']}, ";
                                }
                                if (!empty(trim($row['Colonia']))) {
                                    $direccion .= "{$row['Colonia']}, ";
                                }
                                if (!empty(trim($row['Calle']))) {
                                    $direccion .= "{$row['Calle']} {$row['Nro']}, ";
                                }
                                if (!empty(trim($row['CP']))) {
                                    $direccion .= "{$row['CP']}, ";
                                }
                                if (!empty(trim($row['Nombre_estado']))) {
                                    $direccion .= "{$row['Nombre_estado']}";
                                }
                                
                                // Eliminar la última coma y espacios si están presentes
                                $direccion = rtrim($direccion, ', ');
                            
                                // Mostrar la dirección si hay información
                                if (!empty(trim($direccion))) {
                                    echo '<input type="text" class="form-control" value="' . htmlspecialchars($direccion) . '" disabled>';
                                } else {
                                    echo '<input type="text" class="form-control" value="No disponible" disabled>';
                                }
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="RFC" class="form-label">Justificación:</label>
                            <input type="text" class="form-control" value="<?php echo $row['Justificacion'] ?>" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-sm table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Talla</th>
                        <th scope="col">Solicitado</th>
                        <th scope="col">Entregado</th>
                        <th scope="col">Faltante</th>
                        <th scope="col">Disponible</th>
                        <th scope="col">Cantidad a Entregar</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Mostrar los productos solicitados
                        if ($result3->num_rows > 0) {
                        // Verificar si se obtuvieron resultados de la consulta de productos
                            while ($row1 = $result3->fetch_assoc()) {
                        ?>
                                <tr scope="row">
                                    <td><?php echo $row1['Identificador_Producto']; ?></td>
                                    <td><?php echo $row1['Descripcion_Producto']; ?></td>
                                    <td><?php echo $row1['Talla_Requisicion']; ?></td>
                                    <td><?php echo isset($row1['Solicitada']) ? $row1['Solicitada'] : $row1['Solicitado']; ?></td>
                                    <td><?php echo isset($row1['Entregada']) ? $row1['Entregada'] : 0; ?></td>
                                    <td><?php echo isset($row1['Faltante']) ? $row1['Faltante'] : $row1['Solicitado']; ?></td>
                                    <td><?php echo isset($row1['Cantidad_Disponible']) ? $row1['Cantidad_Disponible'] : 0; ?></td>
                                    <td><input type="text" class="form-control" name="Cant[]" onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" required></td>
                                    <td><input type="hidden" class="form-control" name="Id_Talla[]" value="<?php echo $row1['Identificador_Talla']; ?>"></td>
                                    <td><img src="<?php echo $row1['IMG_Producto']; ?>" height="20" width="20"></td>
                                    <td><button type="button" class="btn btn-info" onclick="mostrarImagen('<?php echo $row1['IMG_Producto']; ?>')">
                                            Visualizar
                                        </button></td>
                                </tr>
                        <?php
                            }
                        } else {
                            // No se encontraron productos para la requisición
                            echo "<tr><td colspan='10'>No se encontraron productos para la requisición.</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="infoModalLabel">Información de la Fila</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="imagenAmpliada">
                        <!-- Aquí se mostrará la información de la fila -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cerrarModalBtn">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="mb-3">
            <button id="botonGuardar" type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                    <path d="M16 19h6" />
                    <path d="M19 16v6" />
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                </svg>Guardar
            </button>
            <a href="../Salidas_ALMACENISTA.php" class="btn btn-danger">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M4 7l16 0" />
                    <path d="M10 11l0 6" />
                    <path d="M14 11l0 6" />
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                </svg>Cancelar
            </a>
        </div>
    </form>
</div>

<script src="../../../js/Insert_Salida_Requision_datosTabla.js"></script>
<script src="../../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Insertar_Salida_Requisicion.js"></script>

<?php include('footer.php'); ?>