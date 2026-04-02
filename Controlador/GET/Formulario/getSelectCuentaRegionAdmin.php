<?php
header('Content-Type: application/json'); // Establece el tipo de contenido como JSON

try {
    include('../../../Modelo/Conexion.php'); // Incluye el archivo de conexión 
    $conexion = (new Conectar())->conexion(); // Crear una nueva conexión a la base de datos

    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    // Obtener el valor de 'ID_Cuenta' desde la solicitud GET o POST
    $cuenta_id = $_GET['id'] ?? $_POST['id'] ?? null;

    if (!$cuenta_id) {
        throw new Exception("ID de cuenta no proporcionado");
    }

    // Preparar una consulta SQL parametrizada para obtener las regiones asociadas a la cuenta seleccionada
    $sql = $conexion->prepare("SELECT DISTINCT
                                    R.ID_Region, 
                                    R.Nombre_Region 
                                FROM 
                                    Regiones R
                                INNER JOIN 
                                    Cuenta_Region CR ON R.ID_Region = CR.ID_Regiones 
                                WHERE
                                    CR.ID_Cuentas = ?
                                ORDER BY 
                                    R.Nombre_Region ASC");

    $sql->bind_param("i", $cuenta_id);
    $sql->execute();
    $result = $sql->get_result();

    $Regiones = array();

    while ($row = $result->fetch_assoc()) {
        $Regiones[] = [
            'ID_Region' => $row['ID_Region'],
            'Nombre_Region' => $row['Nombre_Region']
        ];
    }

    // Devolver los resultados como JSON con estructura consistente
    echo json_encode([
        'success' => true,
        'data' => $Regiones
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