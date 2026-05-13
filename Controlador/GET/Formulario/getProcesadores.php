<?php
header('Content-Type: application/json');

try {
    $procesadores = [
        'Intel Core i3 12th Gen', 'Intel Core i5 12th Gen', 'Intel Core i7 12th Gen', 'Intel Core i9 12th Gen', 'Intel Pentium Gold', 'Intel Celeron', 
        'AMD Ryzen 3', 'AMD Ryzen 5', 'AMD Ryzen 7', 'AMD Ryzen 9', 'AMD Athlon', 
        'Apple M1', 'Apple M2', 'Apple M3', 'Otra'
    ];
    
    echo json_encode([
        'success' => true,
        'data' => $procesadores
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>