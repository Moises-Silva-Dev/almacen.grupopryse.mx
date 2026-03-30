<?php
header('Content-Type: application/json');

try {
    include('../../../Modelo/Conexion.php');
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        throw new Exception('ID de producto no proporcionado');
    }
    
    $id = intval($_GET['id']);
    $conexion = (new Conectar())->conexion();

    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
    
    $sql = "SELECT 
                CTA.IdCTallas,
                CTA.Talla
            FROM 
                Producto P
            INNER JOIN 
                CTipoTallas CT ON P.IdCTipTal = CT.IdCTipTall
            INNER JOIN
                CTallas CTA ON CT.IdCTipTall = CTA.IdCTipTal
            WHERE 
                P.IdCProducto = ?
            ORDER BY 
                CTA.Talla ASC";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $tallas = [];
    while ($row = $result->fetch_assoc()) {
        $tallas[] = [
            'IdCTallas' => $row['IdCTallas'],
            'Talla' => $row['Talla']
        ];
    }
    
    echo json_encode([
        'success' => true,
        'data' => $tallas
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