<?php
header('Content-Type: application/json');

try {
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();
    
    $sql = "SELECT IdCCate, Descrp FROM CCategorias ORDER BY Descrp";
    $result = $conexion->query($sql);
    
    $categorias = [];
    while ($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $categorias
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>