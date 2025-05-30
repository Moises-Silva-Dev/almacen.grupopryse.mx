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
if ($stmt = $conexion->prepare($sql)) { // Preparar la sentencia SQL
    $stmt->execute(); // Ejecuta la consulta
    $resultado = $stmt->get_result(); // Obtiene el resultado de la consulta

    // Recopilar los resultados
    $Cuenta = array();

    // Recorrer los resultados
    while ($row = $resultado->fetch_assoc()) {
        $Cuenta[] = $row; // Agregar cada fila a un array
    }

    // Devolver los resultados como JSON
    echo json_encode($Cuenta);

    // Cerrar la declaraci贸n
    $stmt->close();
} else {
    // Si la consulta falla, mostrar un mensaje de error
    echo json_encode(array("error" => "No se pudo preparar la consulta."));
}

// Cerrar la conexi贸n
$conexion->close();
?>