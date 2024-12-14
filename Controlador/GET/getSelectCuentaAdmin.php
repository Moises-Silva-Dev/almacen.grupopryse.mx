<?php
// Incluye el archivo de conexión 
include('../../Modelo/Conexion.php'); 

// Crear una nueva conexi贸n a la base de datos
$conexion = (new Conectar())->conexion();

// Preparar la consulta SQL
$sql = "SELECT 
            c.ID, c.NombreCuenta
        FROM 
            Cuenta c
        JOIN 
            Cuenta_Region cr ON c.ID = cr.ID_Cuentas
        JOIN 
            Estado_Region er ON cr.ID_Regiones = er.ID_Regiones
        WHERE 
            c.ID NOT IN (SELECT 
                            uc.ID_Cuenta
                        FROM 
                            Usuario_Cuenta uc
                        JOIN 
                            Usuario u ON uc.ID_Usuarios = u.ID_Usuario
                        JOIN 
                            Tipo_Usuarios tu ON u.ID_Tipo_Usuario = tu.ID
                        WHERE 
                            tu.Tipo_Usuario = 'Administrador'
                        )
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

    // Cerrar la declaraci贸n
    $stmt->close();
} else {
    echo json_encode(array("error" => "No se pudo preparar la consulta."));
}

// Cerrar la conexi贸n
$conexion->close();
?>