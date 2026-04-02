<?php
header('Content-Type: application/json'); // Establece el tipo de contenido como JSON

try {
    include('../../../Modelo/Conexion.php'); // Incluye el archivo de conexión 
    $conexion = (new Conectar())->conexion(); // Crear una nueva conexión a la base de datos

    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    // Obtener el valor de 'ID_Region' desde la solicitud GET o POST
    $region_id = $_GET['id'] ?? $_POST['id'] ?? null;

    if (!$region_id) {
        throw new Exception("ID de región no proporcionado");
    }

    // Preparar una consulta SQL parametrizada para obtener los estados asociados a la región seleccionada
    $sql = $conexion->prepare("SELECT 
                                    E.Id_Estado, 
                                    E.Nombre_estado 
                                FROM 
                                    Estados E
                                INNER JOIN 
                                    Estado_Region ER ON E.Id_Estado = ER.ID_Estados 
                                WHERE 
                                    ER.ID_Regiones = ?
                                ORDER BY 
                                    E.Nombre_estado ASC");
                                    
    $sql->bind_param("i", $region_id);
    $sql->execute();
    $result = $sql->get_result();

    $Estados = array();

    while ($row = $result->fetch_assoc()) {
        $Estados[] = [
            'Id_Estado' => $row['Id_Estado'],
            'Nombre_estado' => $row['Nombre_estado']
        ];
    }

    // Devolver los resultados como JSON con estructura consistente
    echo json_encode([
        'success' => true,
        'data' => $Estados
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($sql)) $sql->close();
    if (isset($conexion)) $conexion->close();
}
?>