<?php
header('Content-Type: application/json');

try {
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();
    
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
    
    $sql = "SELECT Id_Estado, Nombre_estado FROM Estados ORDER BY Nombre_estado";
    $sql_stmt = $conexion->prepare($sql);
    $sql_stmt->execute();
    $result = $sql_stmt->get_result();
    
    if ($result === false) {
        throw new Exception("Error en la consulta: " . $conexion->error);
    }
    
    $estados = [];
    while ($row = $result->fetch_assoc()) {
        $estados[] = [
            'Id_Estado' => $row['Id_Estado'],
            'Nombre_estado' => $row['Nombre_estado']
        ];
    }
    
    echo json_encode([
        'success' => true,
        'data' => $estados
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($conexion)) $conexion->close();
}
?>