<?php
header('Content-Type: application/json');

try {
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();

    if ($conexion->connect_error) { // Verificar si hay un error de conexión
        // Si hay un error de conexión, lanzar una excepción
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
    
    $sql = "SELECT ID, Tipo_Usuario FROM Tipo_Usuarios ORDER BY ID"; // Preparar la consulta SQL
    $stmt = $conexion->prepare($sql); // Preparar la sentencia SQL
    $stmt->execute(); // Ejecutar la consulta
    $result = $stmt->get_result(); // Obtiene el resultado de la consulta

    if ($result === false) {
        throw new Exception("Error en la consulta: " . $conexion->error);
    }

    $tiposUsuario = [];
    while ($row = $result->fetch_assoc()) {
        $tiposUsuario[] = [
            'id' => $row['ID'],
            'nombre' => $row['Tipo_Usuario']
        ];
    }

    echo json_encode([
        'success' => true,
        'data' => $tiposUsuario
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
    exit;
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conexion)) $conexion->close();
}
?>