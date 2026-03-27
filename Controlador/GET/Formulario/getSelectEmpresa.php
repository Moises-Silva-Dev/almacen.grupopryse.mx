<?php
header('Content-Type: application/json');

try {
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();
    
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
    
    $sql = "SELECT IdCEmpresa, Nombre_Empresa FROM CEmpresas";
    $result = $conexion->query($sql);
    
    $empresas = [];
    while ($row = $result->fetch_assoc()) {
        $empresas[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $empresas
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