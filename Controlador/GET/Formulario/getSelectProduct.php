<?php
header('Content-Type: application/json');

try {
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();
    
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
    
    $sql = "SELECT 
                P.IdCProducto,
                P.Descripcion,
                P.Especificacion,
                P.IMG,
                CE.Nombre_Empresa,
                CC.Descrp AS Categoria,
                CTT.Descrip AS TipoTalla
            FROM 
                Producto P
            INNER JOIN 
                CEmpresas CE ON P.IdCEmp = CE.IdCEmpresa
            INNER JOIN 
                CCategorias CC ON P.IdCCat = CC.IdCCate
            INNER JOIN 
                CTipoTallas CTT ON P.IdCTipTal = CTT.IdCTipTall
            ORDER BY 
                P.IdCProducto ASC";
    
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $productos = [];
    while ($row = $result->fetch_assoc()) {
        $productos[] = [
            'IdCProducto' => $row['IdCProducto'],
            'Descripcion' => $row['Descripcion'],
            'Especificacion' => $row['Especificacion'],
            'IMG' => $row['IMG'],
            'Nombre_Empresa' => $row['Nombre_Empresa'],
            'Descrp' => $row['Categoria'],
            'TipoTalla' => $row['TipoTalla']
        ];
    }
    
    echo json_encode([
        'success' => true,
        'data' => $productos
    ]);
    
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