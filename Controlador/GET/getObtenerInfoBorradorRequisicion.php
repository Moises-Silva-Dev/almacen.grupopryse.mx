<?php
include('../../Modelo/Conexion.php'); // Include the database connection file

if (isset($_GET['id']) && !empty($_GET['id'])) { // Verifica si se ha pasado un ID de solicitud
    $ID_Solicitud = $_GET['id']; // Obtiene el ID de la solicitud desde la URL
    $conexion = (new Conectar())->conexion(); // Crea una nueva instancia de la clase Conectar y obtiene la conexión a la base de datos

    $consulta = $conexion->prepare("SELECT * FROM Borrador_RequisicionE BRE 
                                    INNER JOIN 
                                        Usuario U on BRE.BIdUsuario = U.ID_Usuario
                                    INNER JOIN 
                                        Cuenta C on BRE.BIdCuenta = C.ID
                                    INNER JOIN 
                                        Regiones R on BRE.BIdRegion = R.ID_Region
                                    INNER JOIN 
                                        Estados E on BRE.BIdEstado = E.Id_Estado
                                    WHERE 
                                        BRE.BIDRequisicionE = ?");
    $consulta->bind_param("i", $ID_Solicitud); // Prepara la consulta para evitar inyecciones SQL
    $consulta->execute(); // Ejecuta la consulta
    $resultado = $consulta->get_result(); // Obtiene el resultado de la consulta

    if ($row = $resultado->fetch_assoc()) { // Si se encuentra un resultado
        $stmt = $conexion->prepare("SELECT BRE.BIDRequisicionE, P.IMG, CE.Nombre_Empresa, P.Descripcion, 
                                        P.Especificacion, CC.Descrp, CT.Talla, BRD.BCantidad
                                    FROM 
                                        Borrador_RequisicionD BRD
                                    INNER JOIN 
                                        Borrador_RequisicionE BRE on BRD.BIdReqE = BRE.BIDRequisicionE
                                    INNER JOIN 
                                        Producto P on BRD.BIdCProd = P.IdCProducto
                                    INNER JOIN 
                                        CTallas CT on BRD.BIdTalla = CT.IdCTallas
                                    INNER JOIN 
                                        CCategorias CC on P.IdCCat = CC.IdCCate
                                    INNER JOIN 
                                        CTipoTallas CTT on CT.IdCTipTal = CTT.IdCTipTall
                                    INNER JOIN 
                                        CEmpresas CE on P.IdCEmp = CE.IdCEmpresa
                                    WHERE 
                                        BRE.BIDRequisicionE = ?");
        $stmt->bind_param("i", $ID_Solicitud); // Prepara la consulta para obtener los detalles del préstamo
        $stmt->execute(); // Ejecuta la consulta para obtener los detalles del préstamo
        $detalles = $stmt->get_result(); // Obtiene el resultado de los detalles del préstamo

        echo "<p><strong>Supervisor:</strong> {$row['BSupervisor']}</p>";
        echo "<p><strong>Cuenta:</strong> {$row['NombreCuenta']}</p>";
        echo "<p><strong>Región:</strong> {$row['Nombre_Region']}</p>";
        echo "<p><strong>Centro de trabajo:</strong> {$row['BCentroTrabajo']}</p>";
        echo "<p><strong>Numero de elementos:</strong> {$row['BNroElementos']}</p>";
        echo "<p><strong>Nombre del Receptor:</strong> {$row['BReceptor']}</p>";
        echo "<p><strong>Telefono del Receptor:</strong> {$row['BTelReceptor']}</p>";
        echo "<p><strong>RFC del Receptor:</strong> {$row['BRfcReceptor']}</p>";
        echo "<p><strong>Justificación:</strong> {$row['BJustificacion']}</p>";
        echo "<p><strong>Dirección:</strong> {$row['BMpio']}, {$row['BColonia']}, {$row['BCalle']}, {$row['BNro']}, {$row['BCP']}, {$row['Nombre_estado']}.</p>";

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
                    <td>{$detalle['BCantidad']}</td>
                </tr>";
        }

        echo "</tbody></table>"; // Cierra la tabla
    } else {
        echo "No se encontró el préstamo."; // Si no se encuentra el préstamo, muestra un mensaje
    }
}
?>