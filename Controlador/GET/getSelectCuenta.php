<?php
include('../../Modelo/Conexion.php'); 

// Crear una nueva conexión a la base de datos
$conexion = (new Conectar())->conexion();

// Preparar la consulta SQL
$sql = "SELECT 
            c.ID, c.NombreCuenta
        FROM 
            Cuenta c
        INNER JOIN 
            Cuenta_Region cr ON c.ID = cr.ID_Cuentas
        INNER JOIN 
            Estado_Region er ON cr.ID_Regiones = er.ID_Regiones
        WHERE 
            er.ID_Regiones IS NOT NULL
        AND 
            er.ID_Estados IS NOT NULL
        GROUP BY 
            c.ID, c.NombreCuenta";

// Ejecutar la consulta
if ($stmt = $conexion->prepare($sql)) {
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Recopilar los resultados
    $Cuenta = array();
    while ($row = $resultado->fetch_assoc()) {
        $Cuenta[] = $row;
    }

    // Devolver los resultados como JSON
    echo json_encode($Cuenta);

    // Cerrar la declaración
    $stmt->close();
} else {
    echo json_encode(array("error" => "No se pudo preparar la consulta."));
}

// Cerrar la conexión
$conexion->close();
?>