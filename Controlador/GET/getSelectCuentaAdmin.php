<?php
header('Content-Type: application/json'); // Establece el tipo de contenido como JSON

try {
    include('../../Modelo/Conexion.php'); // Incluye el archivo de conexión 
    $conexion = (new Conectar())->conexion(); // Crear una nueva conexión a la base de datos

    if ($conexion->connect_error) { // Verificar si hay un error de conexión
        // Si hay un error de conexión, lanzar una excepción
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

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

    $stmt = $conexion->prepare($sql); // Preparar la sentencia SQL
    $stmt->execute(); // Ejecuta la consulta
    $resultado = $stmt->get_result(); // Obtiene el resultado de la consulta

    $Cuenta = array(); // Recopilar los resultados

    while ($row = $resultado->fetch_assoc()) { // Recorrer los resultados
        $Cuenta[] = $row; // Agregar cada fila a un array
    }

    // Devolver los resultados como JSON
    echo json_encode($Cuenta);
} catch (Exception $e) {
    // Manejo de excepciones para errores de conexión o consultas
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
    exit; // Finalizar la ejecución del script en caso de error
} finally {
    $stmt->close(); // Cerrar la declaración preparada
    $conexion->close(); // Cerrar la conexión a la base de datos
}
?>