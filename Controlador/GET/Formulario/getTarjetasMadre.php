<?php
header('Content-Type: application/json');

try {
    $tarjetas = [
        'ASUS Prime', 'ASUS ROG', 'Gigabyte', 'MSI', 'ASRock', 'Otra', 'VORAGO Original',
        'Intel Original', 'Dell Original', 'HP Original', 'Lenovo Original'
    ];
    
    echo json_encode([
        'success' => true,
        'data' => $tarjetas
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>