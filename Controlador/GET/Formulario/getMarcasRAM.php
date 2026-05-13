<?php
header('Content-Type: application/json');

try {
    $marcasRAM = [
        'Kingston', 'Corsair', 'Crucial', 'G.Skill', 'ADATA', 'Otra',
        'Samsung', 'Hynix', 'Micron', 'Patriot', 'Team Group'
    ];
    
    echo json_encode([
        'success' => true,
        'data' => $marcasRAM
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>