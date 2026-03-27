<?php
header('Content-Type: application/json');

try {
    include('../../../Modelo/Conexion.php');
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        throw new Exception('ID de región no proporcionado');
    }
    
    $id = intval($_GET['id']);
    $conexion = (new Conectar())->conexion();
    
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
    
    // Obtener información básica de la región
    $sqlRegion = "SELECT R.ID_Region, R.Nombre_Region, CR.ID_Cuentas 
                  FROM Regiones R
                  INNER JOIN Cuenta_Region CR ON R.ID_Region = CR.ID_Regiones
                  WHERE R.ID_Region = ?";
    
    $stmt = $conexion->prepare($sqlRegion);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultRegion = $stmt->get_result();
    
    if ($resultRegion->num_rows === 0) {
        throw new Exception('Región no encontrada');
    }
    
    $region = $resultRegion->fetch_assoc();
    $stmt->close();
    
    // Obtener estados de la región
    $sqlEstados = "SELECT E.Id_Estado, E.Nombre_estado 
                   FROM Estados E
                   INNER JOIN Estado_Region ER ON E.Id_Estado = ER.ID_Estados
                   WHERE ER.ID_Regiones = ?
                   ORDER BY E.Nombre_estado";
    
    $stmtEstados = $conexion->prepare($sqlEstados);
    $stmtEstados->bind_param("i", $id);
    $stmtEstados->execute();
    $resultEstados = $stmtEstados->get_result();
    
    $estados = [];
    while ($estado = $resultEstados->fetch_assoc()) {
        $estados[] = $estado;
    }
    $stmtEstados->close();
    
    echo json_encode([
        'success' => true,
        'data' => [
            'ID_Region' => $region['ID_Region'],
            'Nombre_Region' => $region['Nombre_Region'],
            'ID_Cuentas' => $region['ID_Cuentas'],
            'estados' => $estados
        ]
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