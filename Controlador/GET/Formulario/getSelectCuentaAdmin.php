<?php
header('Content-Type: application/json'); // Establece el tipo de contenido como JSON

try {
    include('../../../Modelo/Conexion.php'); // Incluye el archivo de conexión 
    $conexion = (new Conectar())->conexion(); // Crear una nueva conexión a la base de datos
    
    // Obtener el correo electrónico desde GET o POST
    $correo_electronico = $_GET['correo_electronico'] ?? $_POST['correo_electronico'] ?? null;
    
    // Si no se proporciona correo, intentar obtener desde la sesión
    if (!$correo_electronico && session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!$correo_electronico && isset($_SESSION['usuario'])) {
        $correo_electronico = $_SESSION['usuario'];
    }
    
    if (!$correo_electronico) {
        throw new Exception('No se proporcionó un correo electrónico válido');
    }

    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    // Preparar la consulta SQL
    $sql = "SELECT DISTINCT C.ID, C.NombreCuenta 
            FROM Usuario U
            INNER JOIN Usuario_Cuenta UC ON U.ID_Usuario = UC.ID_Usuarios
            INNER JOIN Cuenta C ON UC.ID_Cuenta = C.ID
            WHERE U.Correo_Electronico = ?
            ORDER BY C.NombreCuenta ASC";

    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . $conexion->error);
    }
    
    $stmt->bind_param("s", $correo_electronico);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $Cuentas = array();

    while ($row = $resultado->fetch_assoc()) {
        $Cuentas[] = [
            'ID' => $row['ID'],
            'NombreCuenta' => $row['NombreCuenta']
        ];
    }

    // Devolver los resultados como JSON
    echo json_encode($Cuentas);
    
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