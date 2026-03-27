<?php
header('Content-Type: application/json');

try {
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();
    
    $sql = "SELECT IdCTipTall, Descrip FROM CTipoTallas ORDER BY Descrip";
    $result = $conexion->query($sql);
    
    $tiposTalla = [];
    while ($row = $result->fetch_assoc()) {
        $tiposTalla[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $tiposTalla
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>