<?php
header('Content-Type: application/json');

try {
    include('../../../Modelo/Conexion.php');
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        throw new Exception('ID de borrador no proporcionado');
    }
    
    $id = intval($_GET['id']);
    $conexion = (new Conectar())->conexion();
    
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
    
    // Obtener información general del borrador
    $sqlGeneral = "SELECT BRE.*, C.*, U.Correo_Electronico 
                    FROM Borrador_RequisicionE BRE
                        INNER JOIN Usuario U ON BRE.BIdUsuario = U.ID_Usuario
                        INNER JOIN Cuenta C ON BRE.BIdCuenta = C.ID
                    WHERE BRE.BIDRequisicionE = ?";
    
    $stmtGeneral = $conexion->prepare($sqlGeneral);
    $stmtGeneral->bind_param("i", $id);
    $stmtGeneral->execute();
    $resultGeneral = $stmtGeneral->get_result();
    
    if ($resultGeneral->num_rows === 0) {
        throw new Exception('Borrador no encontrado');
    }
    
    $infoGeneral = $resultGeneral->fetch_assoc();
    
    // Obtener productos del borrador
    $sqlProductos = "SELECT RD.BIdCProd, RD.BIdTalla, RD.BCantidad,
                            CE.Nombre_Empresa, CC.Descrp,
                            P.Descripcion, P.Especificacion, CT.Talla
                    FROM Borrador_RequisicionD RD
                    INNER JOIN Producto P ON RD.BIdCProd = P.IdCProducto
                    INNER JOIN CTallas CT ON RD.BIdTalla = CT.IdCTallas
                    INNER JOIN CCategorias CC ON P.IdCCat = CC.IdCCate
                    INNER JOIN CEmpresas CE ON P.IdCEmp = CE.IdCEmpresa
                    WHERE RD.BIdReqE = ?";
    
    $stmtProductos = $conexion->prepare($sqlProductos);
    $stmtProductos->bind_param("i", $id);
    $stmtProductos->execute();
    $resultProductos = $stmtProductos->get_result();
    
    $productos = [];
    while ($producto = $resultProductos->fetch_assoc()) {
        $productos[] = $producto;
    }
    
    echo json_encode([
        'success' => true,
        'data' => array_merge($infoGeneral, ['productos' => $productos])
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($stmtGeneral)) $stmtGeneral->close();
    if (isset($stmtProductos)) $stmtProductos->close();
    if (isset($conexion)) $conexion->close();
}
?>