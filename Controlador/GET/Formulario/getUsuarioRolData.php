<?php
// Activar reporte de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

try {
    // Incluir conexión
    include('../../../Modelo/Conexion.php');
    
    // Verificar que se recibió el ID
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        throw new Exception('ID de usuario no proporcionado');
    }
    
    $id = intval($_GET['id']);
    
    // Crear conexión
    $conexion = (new Conectar())->conexion();
    
    if (!$conexion) {
        throw new Exception("Error de conexión a la base de datos");
    }
    
    // 1. Obtener información del usuario
    $sqlUsuario = "SELECT U.ID_Usuario, U.Nombre, U.Apellido_Paterno, U.Apellido_Materno,
                          U.ID_Tipo_Usuario, TU.Tipo_Usuario
                   FROM Usuario U
                   INNER JOIN Tipo_Usuarios TU ON U.ID_Tipo_Usuario = TU.ID
                   WHERE U.ID_Usuario = ?";
    
    $stmt = $conexion->prepare($sqlUsuario);
    if (!$stmt) {
        throw new Exception("Error al preparar consulta de usuario: " . $conexion->error);
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultUsuario = $stmt->get_result();
    
    if ($resultUsuario->num_rows === 0) {
        throw new Exception('Usuario no encontrado');
    }
    
    $usuario = $resultUsuario->fetch_assoc();
    $stmt->close();
    
    // 2. Obtener todos los tipos de usuario (excepto el actual)
    $sqlTipos = "SELECT ID, Tipo_Usuario FROM Tipo_Usuarios WHERE ID != ? ORDER BY Tipo_Usuario";
    $stmtTipos = $conexion->prepare($sqlTipos);
    if (!$stmtTipos) {
        throw new Exception("Error al preparar consulta de tipos: " . $conexion->error);
    }
    
    $stmtTipos->bind_param("i", $usuario['ID_Tipo_Usuario']);
    $stmtTipos->execute();
    $resultTipos = $stmtTipos->get_result();
    
    $tiposUsuario = [];
    while ($tipo = $resultTipos->fetch_assoc()) {
        $tiposUsuario[] = $tipo;
    }
    $stmtTipos->close();
    
    // 3. Obtener cuentas asociadas al usuario
    $sqlCuentas = "SELECT 
                        C.ID, 
                        C.NombreCuenta, 
                        COUNT(REQ.IDRequisicionE) AS TotalRequisiciones
                    FROM Cuenta C
                    INNER JOIN Usuario_Cuenta UC ON C.ID = UC.ID_Cuenta
                    LEFT JOIN RequisicionE REQ ON C.ID = REQ.IdCuenta 
                        AND REQ.IdUsuario = ?
                        AND REQ.Estatus IN ('Pendiente', 'Parcial', 'Autorizado')
                    WHERE UC.ID_Usuarios = ?
                    GROUP BY C.ID, C.NombreCuenta
                    ORDER BY C.NombreCuenta";
    
    $stmtCuentas = $conexion->prepare($sqlCuentas);
    if (!$stmtCuentas) {
        throw new Exception("Error al preparar consulta de cuentas: " . $conexion->error);
    }
    
    $stmtCuentas->bind_param("ii", $id, $id);
    $stmtCuentas->execute();
    $resultCuentas = $stmtCuentas->get_result();
    
    $cuentas = [];
    $tieneRequisiciones = false;
    
    while ($cuenta = $resultCuentas->fetch_assoc()) {
        $cuentas[] = [
            'ID' => $cuenta['ID'],
            'NombreCuenta' => $cuenta['NombreCuenta'],
            'TotalRequisiciones' => intval($cuenta['TotalRequisiciones'])
        ];
        if ($cuenta['TotalRequisiciones'] > 0) {
            $tieneRequisiciones = true;
        }
    }
    $stmtCuentas->close();
    
    // 4. Obtener cuentas disponibles para agregar
    $sqlCuentasDisponibles = "SELECT ID, NombreCuenta FROM Cuenta";
    
    $stmtDisponibles = $conexion->prepare($sqlCuentasDisponibles);
    if (!$stmtDisponibles) {
        throw new Exception("Error al preparar consulta de cuentas disponibles: " . $conexion->error);
    }
    
    $stmtDisponibles->execute();
    $resultDisponibles = $stmtDisponibles->get_result();
    
    $cuentasDisponibles = [];
    while ($cuenta = $resultDisponibles->fetch_assoc()) {
        $cuentasDisponibles[] = [
            'ID' => $cuenta['ID'],
            'NombreCuenta' => $cuenta['NombreCuenta']
        ];
    }
    $stmtDisponibles->close();
    
    // Cerrar conexión
    $conexion->close();
    
    // Respuesta exitosa
    echo json_encode([
        'success' => true,
        'usuario' => [
            'ID_Usuario' => $usuario['ID_Usuario'],
            'Nombre' => $usuario['Nombre'],
            'Apellido_Paterno' => $usuario['Apellido_Paterno'],
            'Apellido_Materno' => $usuario['Apellido_Materno'],
            'ID_Tipo_Usuario' => $usuario['ID_Tipo_Usuario'],
            'Tipo_Usuario' => $usuario['Tipo_Usuario']
        ],
        'tipos_usuario' => $tiposUsuario,
        'cuentas' => $cuentas,
        'cuentas_disponibles' => $cuentasDisponibles,
        'tiene_requisiciones' => $tieneRequisiciones
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}
?>