<?php
header('Content-Type: application/json');
session_start();

include('../../Modelo/Conexion.php');
require_once("../../Modelo/Funciones/Funciones_Equipos_Documentos.php");

$conexion = (new Conectar())->conexion();

if (!$conexion || $conexion->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Error en la conexión: " . $conexion->connect_error
    ]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = json_decode(file_get_contents('php://input'), true);
    $id_Documento = $input['id'] ?? null;
    $ubicacion = $input['ubicacion'] ?? null;
    
    if (!$id_Documento) {
        echo json_encode([
            "success" => false,
            "message" => "ID de documento no proporcionado."
        ]);
        exit;
    }
    
    $conexion->begin_transaction();
    
    try {
        $result = EliminarDocumento($conexion, $id_Documento, $ubicacion);
        
        if (!$result) {
            throw new Exception("Error al eliminar el documento.");
        }
        
        $conexion->commit();
        
        echo json_encode([
            "success" => true,
            "message" => "Documento eliminado correctamente."
        ]);
        
    } catch (Exception $e) {
        $conexion->rollback();
        echo json_encode([
            "success" => false,
            "message" => "Error: " . $e->getMessage()
        ]);
    } finally {
        $conexion->close();
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido."
    ]);
}
?>