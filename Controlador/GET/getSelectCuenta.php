<?php
header('Content-Type: application/json'); // Establece el tipo de contenido como JSON

try {
    include('../../Modelo/Conexion.php'); // Incluir dependencias necesarias
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

    $stmt = $conexion->prepare($sql); // Preparar la sentencia SQL
    $stmt->execute(); // Ejecutar la consulta
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