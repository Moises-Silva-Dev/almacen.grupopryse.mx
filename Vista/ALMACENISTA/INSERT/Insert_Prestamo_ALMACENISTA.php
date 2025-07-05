<?php include('head.php'); ?>

<?php
include('../../../Modelo/Conexion.php'); // Conectar a la base de datos

// Verifica si la variable $_GET['id'] está definida y no es nula
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $ID_Solicitud = $_GET['id'];

    // Realiza la consulta para obtener la información del empleado
    $conexion = (new Conectar())->conexion();

    //Setencia SQL
    $consulta = $conexion->prepare("SELECT 
                            PE.IdPrestamoE, U.Nombre, U.Apellido_Paterno, 
                            U.Apellido_Materno, PE.Justificacion, PE.Estatus
                        FROM 
                            PrestamoE PE
                        INNER JOIN 
                            Usuario U ON PE.IdUsuario = U.ID_Usuario
                        WHERE 
                            PE.IdPrestamoE = ?");

    //Parametros
    $consulta->bind_param("i", $ID_Solicitud);
    $consulta->execute();
    $resultado = $consulta->get_result();

    // Verifica si se encontraron resultados
    if ($row = $resultado->fetch_assoc()) {
        // Ahora, $row contiene la información del empleado que puedes usar en el formulario
        $query = "SELECT PE.IdPrestamoE, PD.IdCProd AS Identificador_Producto, 
                    PD.IdTallas AS Identificador_Talla, PD.Cantidad AS Solicitada, P.Descripcion AS Descripcion_Producto,
                    P.IMG, CT.Talla AS Talla_Producto, CC.Descrp,
                    I.Cantidad AS Cantidad_Disponible
                    FROM PrestamoD PD
                    INNER JOIN PrestamoE PE on PD.IdPresE = PE.IdPrestamoE
                    INNER JOIN Producto P on PD.IdCProd = P.IdCProducto
                    INNER JOIN CTallas CT on PD.IdTallas = CT.IdCTallas
                    LEFT JOIN Inventario I ON PD.IdCProd = I.IdCPro AND PD.IdTallas = I.IdCTal
                    INNER JOIN CCategorias CC on P.IdCCat = CC.IdCCate
                    INNER JOIN CTipoTallas CTT on CT.IdCTipTal = CTT.IdCTipTall
                    INNER JOIN CEmpresas CE on P.IdCEmp = CE.IdCEmpresa
                    WHERE PE.IdPrestamoE = ?";
                    
                    $stmt = $conexion->prepare($query);
                    $stmt->bind_param("i", $ID_Solicitud);
                    $stmt->execute();
                    $resultadoConsulta = $stmt->get_result();
    } else {
        // No se encontró ningún empleado con la ID proporcionada, puedes manejar esto según tus necesidades
        echo "No se encontró ningún registro con la ID proporcionada.";
        exit; // Puedes salir del script o redirigir a otra página
    }
} else {
    // La variable $_GET['id'] no está definida o es nula, puedes manejar esto según tus necesidades
    echo "ID de empleado no proporcionada.";
    exit; // Puedes salir del script o redirigir a otra página
}
?>

<div class="container mt-5">
    <center><h2>Registrar Salida Prestamo</h2></center>
    <!-- Formulario -->
    <form id="FormInsertSalidaPrestamoNueva" class="needs-validation" action="../../../Controlador/Usuarios/INSERT/Funcion_Insert_Salida_Prestamo.php" method="post" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="IdPrestamoE" id="IdPrestamoE" value="<?php echo $ID_Solicitud; ?>">
        <input type="hidden" id="datosTablaInsertSalida" name="datosTablaInsertSalida">
        <div class="mb-3">
            <label for="NombreCompleto" class="form-label">Nombre Completo:</label>
            <input type="text" class="form-control" value="<?php echo $row['Nombre'] . ' ' . $row['Apellido_Paterno'] . ' ' . $row['Apellido_Materno']; ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="Justificacion" class="form-label">Justificación:</label>
            <textarea class="form-control" disabled><?php echo $row['Justificacion'];  ?></textarea>
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
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Mostrar los productos solicitados
                        if ($resultadoConsulta->num_rows > 0) {
                        // Verificar si se obtuvieron resultados de la consulta de productos
                            while ($row1 = $resultadoConsulta->fetch_assoc()) {
                    ?>
                                <tr scope="row">
                                    <td><?php echo $row1['Identificador_Producto']; ?></td>
                                    <td><?php echo $row1['Descripcion_Producto']; ?></td>
                                    <td><?php echo $row1['Talla_Producto']; ?></td>
                                    <td><?php echo $row1['Solicitada']; ?></td>
                                    <td><?php echo isset($row1['Entregada']) ? $row1['Entregada'] : 0; ?></td>
                                    <td><?php echo $row1['Solicitada']; ?></td>
                                    <td><?php echo isset($row1['Cantidad_Disponible']) ? $row1['Cantidad_Disponible'] : 0; ?></td>
                                    <td><input type="text" class="form-control" name="Cant[]" onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" required></td>
                                    <td><input type="hidden" class="form-control" name="Id_Talla[]" value="<?php echo $row1['Identificador_Talla']; ?>"></td>
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
            <a href="../Prestamo_ALMACENISTA.php" class="btn btn-danger">
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
<script src="../../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Insertar_Salida_Prestamo.js"></script>

<?php include('footer.php'); ?>