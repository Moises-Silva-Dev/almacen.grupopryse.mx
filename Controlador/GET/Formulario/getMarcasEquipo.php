<?php
header('Content-Type: application/json');

try {
    // Lista predefinida de marcas comunes
    $marcas = [
        'HP', 'Dell', 'Lenovo', 'Apple', 'Acer', 'Asus', 'MSI', 'Otra', 'VORAGO', 'GIGABYTE', 
        'Xiaomi', 'Huawei', 'Toshiba', 'Samsung', 'Sony', 'Gateway', 'Alienware', 'Razer', 'Otra'
    ];
    
    echo json_encode([
        'success' => true,
        'data' => $marcas
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>