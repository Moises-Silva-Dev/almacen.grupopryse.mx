<?php
header('Content-Type: application/json');

try {
    include('../../../Modelo/Conexion.php');
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        throw new Exception('ID de usuario no proporcionado');
    }
    
    $id = intval($_GET['id']);
    $conexion = (new Conectar())->conexion();
    
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
    
    $sql = "SELECT ID_Usuario, Nombre, Apellido_Paterno, Apellido_Materno, 
                    NumTel, Correo_Electronico, NumContactoSOS, ID_Tipo_Usuario
            FROM 
                Usuario 
            WHERE 
                ID_Usuario = ?";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Usuario no encontrado');
    }
    
    $userData = $result->fetch_assoc();
    
    echo json_encode([
        'success' => true,
        'data' => $userData
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