<?php
include('../../Modelo/Conexion.php'); // Include the database connection file

if (isset($_GET['id']) && !empty($_GET['id'])) { // Verifica si se ha pasado un ID de solicitud
    $ID_Solicitud = $_GET['id']; // Obtiene el ID de la solicitud desde la URL
    $conexion = (new Conectar())->conexion(); // Crea una nueva instancia de la clase Conectar y obtiene la conexión a la base de datos

    $consulta = $conexion->prepare("SELECT * FROM RequisicionE RE 
                                    INNER JOIN 
                                        Usuario U on RE.IdUsuario = U.ID_Usuario
                                    INNER JOIN 
                                        Cuenta C on RE.IdCuenta = C.ID
                                    INNER JOIN 
                                        Regiones R on RE.IdRegion = R.ID_Region
                                    INNER JOIN 
                                        Estados E on RE.IdEstado = E.Id_Estado
                                    WHERE 
                                        RE.IDRequisicionE = ?");
    $consulta->bind_param("i", $ID_Solicitud); // Prepara la consulta para evitar inyecciones SQL
    $consulta->execute(); // Ejecuta la consulta
    $resultado = $consulta->get_result(); // Obtiene el resultado de la consulta

    if ($row = $resultado->fetch_assoc()) { // Si se encuentra un resultado
        $stmt = $conexion->prepare("SELECT RE.IDRequisicionE, P.IMG, CE.Nombre_Empresa, P.Descripcion, 
                                        P.Especificacion, CC.Descrp, CT.Talla, RD.Cantidad
                                    FROM 
                                        RequisicionD RD
                                    INNER JOIN 
                                        RequisicionE RE on RD.IdReqE = RE.IDRequisicionE
                                    INNER JOIN 
                                        Producto P on RD.IdCProd = P.IdCProducto
                                    INNER JOIN 
                                        CTallas CT on RD.IdTalla = CT.IdCTallas
                                    INNER JOIN 
                                        CCategorias CC on P.IdCCat = CC.IdCCate
                                    INNER JOIN 
                                        CTipoTallas CTT on CT.IdCTipTal = CTT.IdCTipTall
                                    INNER JOIN 
                                        CEmpresas CE on P.IdCEmp = CE.IdCEmpresa
                                    WHERE 
                                        RE.IDRequisicionE = ?");
        $stmt->bind_param("i", $ID_Solicitud); // Prepara la consulta para obtener los detalles del préstamo
        $stmt->execute(); // Ejecuta la consulta para obtener los detalles del préstamo
        $detalles = $stmt->get_result(); // Obtiene el resultado de los detalles del préstamo

        echo "<p><strong>Supervisor:</strong> {$row['Supervisor']}</p>";
        echo "<p><strong>Cuenta:</strong> {$row['NombreCuenta']}</p>";
        echo "<p><strong>Región:</strong> {$row['Nombre_Region']}</p>";
        echo "<p><strong>Centro de trabajo:</strong> {$row['CentroTrabajo']}</p>";
        echo "<p><strong>Numero de elementos:</strong> {$row['NroElementos']}</p>";
        echo "<p><strong>Nombre del Receptor:</strong> {$row['Receptor']}</p>";
        echo "<p><strong>Telefono del Receptor:</strong> {$row['TelReceptor']}</p>";
        echo "<p><strong>RFC del Receptor:</strong> {$row['RfcReceptor']}</p>";
        echo "<p><strong>Justificación:</strong> {$row['Justificacion']}</p>";
        echo "<p><strong>Dirección:</strong> {$row['Mpio']}, {$row['Colonia']}, {$row['Calle']}, {$row['Nro']}, {$row['CP']}, {$row['Nombre_estado']}.</p>";

        echo "<table class='table table-hover table-striped mt-4'>
                <thead class='table-light'>
                    <tr>
                        <th scope='col'>Empresa</th>
                        <th scope='col'>Descripcion</th>
                        <th scope='col'>Especificación</th>
                        <th scope='col'>Categoría</th>
                        <th scope='col'>Talla</th>
                        <th scope='col'>Cantidad</th>
                    </tr>
                </thead>
                <tbody>";

        while ($detalle = $detalles->fetch_assoc()) { // Itera sobre los detalles del préstamo
            echo "<tr>
                    <td>{$detalle['Nombre_Empresa']}</td>
                    <td>{$detalle['Descripcion']}</td>
                    <td>{$detalle['Especificacion']}</td>
                    <td>{$detalle['Descrp']}</td>
                    <td>{$detalle['Talla']}</td>
                    <td>{$detalle['Cantidad']}</td>
                </tr>";
        }

        echo "</tbody></table>"; // Cierra la tabla
    } else {
        echo "No se encontró el préstamo."; // Si no se encuentra el préstamo, muestra un mensaje
    }
}
?>