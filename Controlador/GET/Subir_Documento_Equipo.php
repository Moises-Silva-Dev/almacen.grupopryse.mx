<?php
header('Content-Type: application/json');
session_start();
date_default_timezone_set('America/Mexico_City');

include('../../Modelo/Conexion.php');
require_once("../../Modelo/Funciones/Funciones_Equipos_Documentos.php");
require_once("../../Modelo/Funciones/Funcion_TipoUsuario.php");
require_once("../../Modelo/Funciones/Funciones_Usuarios.php");

$conexion = (new Conectar())->conexion();

if (!$conexion || $conexion->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Error en la conexión: " . $conexion->connect_error
    ]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_SESSION["usuario"] ?? null;
    
    if (!$usuario) {
        echo json_encode([
            "success" => false,
            "message" => "Usuario no autenticado."
        ]);
        exit;
    }
    
    $id_Equipo = $_POST['Id_Equipo'] ?? null;
    $nombreDocumento = trim($_POST['Nombre_Documento'] ?? '');
    
    if (!$id_Equipo) {
        echo json_encode([
            "success" => false,
            "message" => "ID de equipo no proporcionado."
        ]);
        exit;
    }
    
    if (empty($nombreDocumento)) {
        echo json_encode([
            "success" => false,
            "message" => "El nombre del documento es requerido."
        ]);
        exit;
    }
    
    // Verificar si se subió un archivo
    if (!isset($_FILES['documento_pdf']) || $_FILES['documento_pdf']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode([
            "success" => false,
            "message" => "No se ha seleccionado ningún archivo o hubo un error en la carga."
        ]);
        exit;
    }
    
    $archivo = $_FILES['documento_pdf'];
    
    // Validar tipo de archivo
    $tipoArchivo = mime_content_type($archivo['tmp_name']);
    if ($tipoArchivo !== 'application/pdf') {
        echo json_encode([
            "success" => false,
            "message" => "El archivo debe ser de tipo PDF."
        ]);
        exit;
    }
    
    // Validar tamaño (10MB máximo)
    $maxSize = 10 * 1024 * 1024; // 10MB
    if ($archivo['size'] > $maxSize) {
        echo json_encode([
            "success" => false,
            "message" => "El archivo no debe exceder los 10MB."
        ]);
        exit;
    }
    
    // Crear directorio si no existe
    $uploadDir = '../../uploads/documentos_equipos/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Generar nombre único para el archivo
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $nombreArchivo = 'equipo_' . $id_Equipo . '_' . time() . '_' . uniqid() . '.' . $extension;
    $rutaArchivo = $uploadDir . $nombreArchivo;
    
    // Mover el archivo al directorio de destino
    if (!move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
        echo json_encode([
            "success" => false,
            "message" => "Error al guardar el archivo en el servidor."
        ]);
        exit;
    }
    
    $fechaRegistro = date('Y-m-d H:i:s');
    
    $conexion->begin_transaction();
    
    try {
        $result = InsertarNuevoDocumento(
            $conexion,
            $id_Equipo,
            $nombreDocumento,
            $nombreArchivo,
            $fechaRegistro
        );
        
        if (!$result) {
            // Eliminar el archivo si falló la inserción
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }
            throw new Exception("Error al guardar el documento en la base de datos.");
        }
        
        $conexion->commit();
        
        $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion);
        
        $urls = [
            1 => "../../Vista/DEV/Control_Equipos_Dev.php",
            2 => "../../Vista/SUPERADMIN/index_SUPERADMIN.php",
            3 => "../../Vista/ADMIN/index_ADMIN.php",
            4 => "../../Vista/USER/index_USER.php",
            5 => "../../Vista/ALMACENISTA/Control_Equipos_ALMACENISTA.php"
        ];
        
        echo json_encode([
            "success" => true,
            "message" => "Documento subido correctamente.",
            "redirect" => $urls[$RetornarTipoUsuario] ?? "../../index.php"
        ]);
        
    } catch (Exception $e) {
        $conexion->rollback();
        // Eliminar el archivo si hubo error
        if (file_exists($rutaArchivo)) {
            unlink($rutaArchivo);
        }
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