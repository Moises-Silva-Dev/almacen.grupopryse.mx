<?php
header('Content-Type: application/json');

try {
    include('../../../Modelo/Conexion.php');
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        throw new Exception('ID de requisición no proporcionado');
    }
    
    $id = intval($_GET['id']);
    $conexion = (new Conectar())->conexion();
    
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
    
    // Obtener información general de la requisición
    $sqlGeneral = "SELECT C.NombreCuenta, RE.Supervisor, R.Nombre_Region,
                            RE.CentroTrabajo, RE.Receptor, RE.TelReceptor, RE.RfcReceptor, 
                            RE.Justificacion, RE.Mpio, RE.Colonia, RE.Calle, RE.Nro, RE.CP, 
                            E.Nombre_estado 
                    FROM RequisicionE RE
                    INNER JOIN Usuario U ON RE.IdUsuario = U.ID_Usuario
                    INNER JOIN Estados E ON RE.IdEstado = E.Id_Estado
                    INNER JOIN Regiones R ON RE.IdRegion = R.ID_Region
                    INNER JOIN Cuenta C ON RE.IdCuenta = C.ID
                    WHERE RE.IDRequisicionE = ?";
    
    $stmtGeneral = $conexion->prepare($sqlGeneral);
    $stmtGeneral->bind_param("i", $id);
    $stmtGeneral->execute();
    $resultGeneral = $stmtGeneral->get_result();
    
    if ($resultGeneral->num_rows === 0) {
        throw new Exception('Requisición no encontrada');
    }
    
    $infoGeneral = $resultGeneral->fetch_assoc();
    
    // Obtener productos de la requisición
    $sqlProductos = "SELECT 
                        rd.IdCProd AS Identificador_Producto,
                        p.Descripcion AS Descripcion_Producto,
                        rd.IdTalla AS Identificador_Talla,
                        ct.Talla AS Talla_Requisicion,
                        SUM(rd.Cantidad) AS Solicitado,
                        COALESCE((
                            SELECT SUM(sd.Cantidad) 
                            FROM Salida_D sd 
                            INNER JOIN Salida_E se ON sd.Id = se.Id_SalE 
                            WHERE se.ID_ReqE = ? AND sd.IdCProd = rd.IdCProd AND sd.IdTallas = rd.IdTalla
                        ), 0) AS Entregado,
                        MAX(i.Cantidad) AS Cantidad_Disponible  
                    FROM RequisicionD rd
                    JOIN Producto p ON rd.IdCProd = p.IdCProducto
                    LEFT JOIN Inventario i ON rd.IdCProd = i.IdCPro AND rd.IdTalla = i.IdCTal
                    LEFT JOIN CTallas ct ON rd.IdTalla = ct.IdCTallas
                    WHERE rd.IdReqE = ?
                    GROUP BY rd.IdCProd, rd.IdTalla";
    
    $stmtProductos = $conexion->prepare($sqlProductos);
    $stmtProductos->bind_param("ii", $id, $id);
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