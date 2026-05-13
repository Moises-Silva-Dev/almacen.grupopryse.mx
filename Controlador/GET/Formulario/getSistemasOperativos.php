<?php
header('Content-Type: application/json');

try {
    $sistemas = [
        'Windows 10 Pro', 'Windows 10 Home', 'Windows 11 Pro', 'Windows 11 Home',
        'Windows 7', 'Windows 8', 'Ubuntu 20.04', 'Ubuntu 22.04', 'Ubuntu 24.04',
        'macOS', 'Windows Server', 'macOS Monterey', 'macOS Ventura', 'macOS Sonoma', 
        'Linux Ubuntu', 'Linux Fedora', 'Linux Mint Debian', 'Linux Mint Cinnamon', 
        'Linux Mint MATE', 'Linux Debian', 'Linux Fedora', 'Otra'
    ];
    
    echo json_encode([
        'success' => true,
        'data' => $sistemas
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>