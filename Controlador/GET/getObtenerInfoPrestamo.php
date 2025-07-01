<?php
include('../../Modelo/Conexion.php'); // Include the database connection file

if (isset($_GET['id']) && !empty($_GET['id'])) { // Verifica si se ha pasado un ID de solicitud
    $ID_Solicitud = $_GET['id']; // Obtiene el ID de la solicitud desde la URL
    $conexion = (new Conectar())->conexion(); // Crea una nueva instancia de la clase Conectar y obtiene la conexión a la base de datos

    $consulta = $conexion->prepare("SELECT PE.IdPrestamoE, U.Nombre, U.Apellido_Paterno, U.Apellido_Materno, PE.Justificacion 
                                    FROM PrestamoE PE 
                                    INNER JOIN Usuario U ON PE.IdUsuario = U.ID_Usuario
                                    WHERE PE.IdPrestamoE = ?");
    $consulta->bind_param("i", $ID_Solicitud); // Prepara la consulta para evitar inyecciones SQL
    $consulta->execute(); // Ejecuta la consulta
    $resultado = $consulta->get_result(); // Obtiene el resultado de la consulta

    if ($row = $resultado->fetch_assoc()) { // Si se encuentra un resultado
        $stmt = $conexion->prepare("SELECT P.Descripcion, P.Especificacion, CE.Nombre_Empresa, CT.Talla, CC.Descrp, PD.Cantidad 
                                    FROM PrestamoD PD
                                    INNER JOIN PrestamoE PE on PD.IdPresE = PE.IdPrestamoE
                                    INNER JOIN Producto P on PD.IdCProd = P.IdCProducto
                                    INNER JOIN CTallas CT on PD.IdTallas = CT.IdCTallas
                                    INNER JOIN CCategorias CC on P.IdCCat = CC.IdCCate
                                    INNER JOIN CEmpresas CE on P.IdCEmp = CE.IdCEmpresa
                                    WHERE PE.IdPrestamoE = ?");
        $stmt->bind_param("i", $ID_Solicitud); // Prepara la consulta para obtener los detalles del préstamo
        $stmt->execute(); // Ejecuta la consulta para obtener los detalles del préstamo
        $detalles = $stmt->get_result(); // Obtiene el resultado de los detalles del préstamo

        echo "<p><strong>Solicitante:</strong> {$row['Nombre']} {$row['Apellido_Paterno']} {$row['Apellido_Materno']}</p>";
        echo "<p><strong>Justificación:</strong> {$row['Justificacion']}</p>";
        echo "<table class='table table-hover table-striped mt-4'>
                <thead class='table-light'>
                    <tr>
                        <th scope='col'>Descripcion</th>
                        <th scope='col'>Especificación</th>
                        <th scope='col'>Talla</th>
                        <th scope='col'>Cantidad</th>
                        <th scope='col'>Empresa</th>
                    </tr>
                </thead>
                <tbody>";

        while ($detalle = $detalles->fetch_assoc()) { // Itera sobre los detalles del préstamo
            echo "<tr>
                    <td>{$detalle['Descripcion']}</td>
                    <td>{$detalle['Descrp']}</td>
                    <td>{$detalle['Talla']}</td>
                    <td>{$detalle['Cantidad']}</td>
                    <td>{$detalle['Nombre_Empresa']}</td>
                </tr>";
        }

        echo "</tbody></table>"; // Cierra la tabla
    } else {
        echo "No se encontró el préstamo."; // Si no se encuentra el préstamo, muestra un mensaje
    }
}
?>