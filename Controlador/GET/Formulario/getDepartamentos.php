<?php
header('Content-Type: application/json');

try {
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();
    
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
    
    $sql = "SELECT Id, Nombre_Departamento FROM Departamento ORDER BY Nombre_Departamento ASC";
    $result = $conexion->query($sql);
    
    if ($result === false) {
        throw new Exception("Error en la consulta: " . $conexion->error);
    }
    
    $departamentos = [];
    while ($row = $result->fetch_assoc()) {
        $departamentos[] = [
            'Id' => $row['Id'],
            'Nombre_Departamento' => $row['Nombre_Departamento']
        ];
    }
    
    echo json_encode([
        'success' => true,
        'data' => $departamentos
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