<?php
header('Content-Type: application/json');

try {
    include('../../../Modelo/Conexion.php');
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        throw new Exception('ID de entrada no proporcionado');
    }
    
    $id = intval($_GET['id']);
    $conexion = (new Conectar())->conexion();
    
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
    
    // Obtener información general de la entrada
    $sqlGeneral = "SELECT IdEntE, Nro_Modif, Proveedor, Receptor, Comentarios FROM EntradaE WHERE IdEntE = ?";
    $stmtGeneral = $conexion->prepare($sqlGeneral);
    $stmtGeneral->bind_param("i", $id);
    $stmtGeneral->execute();
    $resultGeneral = $stmtGeneral->get_result();
    
    if ($resultGeneral->num_rows === 0) {
        throw new Exception('Entrada no encontrada');
    }
    
    $infoGeneral = $resultGeneral->fetch_assoc();
    
    // Obtener productos de la entrada
    $sqlProductos = "SELECT ED.IdProd, CE.Nombre_Empresa, CC.Descrp, 
                            P.Descripcion, P.Especificacion, ED.IdTalla, CT.Talla, ED.Cantidad
                    FROM EntradaD ED
                    INNER JOIN Producto P ON ED.IdProd = P.IdCProducto
                    INNER JOIN CTallas CT ON ED.IdTalla = CT.IdCTallas
                    INNER JOIN CCategorias CC ON P.IdCCat = CC.IdCCate
                    INNER JOIN CEmpresas CE ON P.IdCEmp = CE.IdCEmpresa
                    WHERE ED.IdEntradaE = ?";
    
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