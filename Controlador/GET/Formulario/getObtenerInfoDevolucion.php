<?php
header('Content-Type: application/json');

try {
    include('../../../Modelo/Conexion.php');
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        throw new Exception('ID de devolución no proporcionado');
    }
    
    $id = intval($_GET['id']);
    $conexion = (new Conectar())->conexion();
    
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
    
    // Obtener información general de la devolución (sin estatus ni fecha)
    $sqlGeneral = "SELECT IdDevolucionE, Nombre_Devuelve, Telefono_Devuelve, Justificacion, 
                        IdUsuario, IdPrestE, IdRequiE
                FROM DevolucionE WHERE IdDevolucionE = ?";
    
    $stmtGeneral = $conexion->prepare($sqlGeneral);
    $stmtGeneral->bind_param("i", $id);
    $stmtGeneral->execute();
    $resultGeneral = $stmtGeneral->get_result();
    
    if ($resultGeneral->num_rows === 0) {
        throw new Exception('Devolución no encontrada');
    }
    
    $infoGeneral = $resultGeneral->fetch_assoc();
    
    // Determinar tipo y ID de referencia
    $tipo = 'NO';
    $idReferencia = null;
    
    if ($infoGeneral['IdRequiE'] && $infoGeneral['IdRequiE'] > 0) {
        $tipo = 'Requisicion';
        $idReferencia = $infoGeneral['IdRequiE'];
    } elseif ($infoGeneral['IdPrestE'] && $infoGeneral['IdPrestE'] > 0) {
        $tipo = 'Prestamo';
        $idReferencia = $infoGeneral['IdPrestE'];
    }
    
    // Obtener productos de la devolución
    $sqlProductos = "SELECT DD.IdCProd, DD.IdTalla, DD.Cantidad,
                            CE.Nombre_Empresa, CC.Descrp AS Categoria,
                            P.Descripcion, P.Especificacion, CT.Talla
                    FROM DevolucionD DD
                    INNER JOIN Producto P ON DD.IdCProd = P.IdCProducto
                    INNER JOIN CTallas CT ON DD.IdTalla = CT.IdCTallas
                    INNER JOIN CCategorias CC ON P.IdCCat = CC.IdCCate
                    INNER JOIN CEmpresas CE ON P.IdCEmp = CE.IdCEmpresa
                    WHERE DD.IdDevE = ?";
    
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
        'data' => [
            'IdDevolucionE' => $infoGeneral['IdDevolucionE'],
            'Tipo' => $tipo,
            'IdReferencia' => $idReferencia,
            'Nombre_Devuelve' => $infoGeneral['Nombre_Devuelve'],
            'Telefono_Devuelve' => $infoGeneral['Telefono_Devuelve'],
            'Justificacion' => $infoGeneral['Justificacion'],
            'productos' => $productos
        ]
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