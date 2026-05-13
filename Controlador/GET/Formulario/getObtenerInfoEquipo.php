<?php
header('Content-Type: application/json');

try {
    include('../../../Modelo/Conexion.php');
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        throw new Exception('ID de equipo no proporcionado');
    }
    
    $id = intval($_GET['id']);
    $conexion = (new Conectar())->conexion();
    
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
    
    $sql = "SELECT * FROM Control_Equipos WHERE Id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Equipo no encontrado');
    }
    
    $equipo = $result->fetch_assoc();
    
    echo json_encode([
        'success' => true,
        'data' => $equipo
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conexion)) $conexion->close();
}
?>