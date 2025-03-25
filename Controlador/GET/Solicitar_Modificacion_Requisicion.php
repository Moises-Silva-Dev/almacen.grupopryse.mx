<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
ob_start(); // Limpia cualquier salida previa
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México

// Incluir dependencias necesarias
include('../../Modelo/Conexion.php'); // Incluir el archivo de conexión
require_once("../../Modelo/Funciones/Funciones_Borrador_RequisicionD.php");
require_once("../../Modelo/Funciones/Funciones_Borrador_RequisicionE.php"); 
require_once("../../Modelo/Funciones/Funciones_RequisicionD.php"); 
require_once("../../Modelo/Funciones/Funciones_RequisicionE.php"); 
require_once("../../Modelo/Funciones/Funcion_TipoUsuario.php");

$conexion = (new Conectar())->conexion(); // Conectar a la base de datos

// Verificar si la conexión a la base de datos fue exitosa
if (!$conexion || $conexion->connect_error) {
    echo json_encode([ // Si la conexión falla, enviar un mensaje de error
        "success" => false, // Indicar si la operación fue exitosa
        "message" => "Error en la conexión: " . $conexion->connect_error // Mostrar el error de conexión
    ]);
    exit; // Salir del script
}

// Verifica si se proporciona un ID a través de GET
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true); // Decodificar JSON recibido
    $FchEnvio = date('Y-m-d H:i:s', time()); // Obtiene la fecha y hora de creación de la requisición 
    $idSolicitud = $data['id'] ?? null; // Obtener ID de la requisición
    $comentario = trim($data['comentario'] ?? ''); // Obtener comentario del usuario
    $usuario = $_SESSION["usuario"]; // Recuperar el usuario de la sesión

    if (!$idSolicitud || !$usuario || empty($comentario)) { // Verificar si se proporcionó un ID y un usuario
        echo json_encode([ // Si no se proporcionó un ID o un usuario, enviar un mensaje de error
            "success" => false, // Indicar si la operación fue exitosa
            "message" => "Datos inválidos. Por favor, revise la información enviada." // Mostrar un mensaje de error
        ]);
        exit; // Salir del script
    }

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Llamar a la función para recuperar la información de la requisición E relacionada
        $InformacionRequisicionE = SeleccionarInformacionRequisicionE($conexion, $idSolicitud);

        if (!$InformacionRequisicionE) { // Verificar si se ha insertado correctamente la región
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al buscar en la tabla requisicionE.");
        }

        // Llamar a la función para recuperar la información de la requisición D relacionada
        $InformacionRequisicionD = SeleccionarInformacionRequisicionD($conexion, $idSolicitud);

        if (!$InformacionRequisicionD) { // Verificar si se ha insertado correctamente la región
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al buscar en la tabla requisicionD.");
        }

        // Inserta en la tabla borrador RequisicionE
        $ID_RequisionERegresado = InsertarBorradorRequisicionERegresado($conexion, $FchEnvio, $InformacionRequisicionE, $comentario);
        
        if (!$ID_RequisionERegresado) { // Verificar si se ha insertado correctamente la región
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al insertar en la tabla borrador_requisicionE.");
        }

        // Inserta en la tabla borrador RequisicionD
        if (!InsertarBorradorRequisicionDRegresado($conexion, $ID_RequisionERegresado, $InformacionRequisicionD)){
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al insertar en la tabla borrador_requisicionD.");
        }
        
        //Eliminar Informacion de Tabla RequisicionD
        if (!EliminarRequisicionD($conexion, $idSolicitud)) {
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al eliminar en la tabla requisicionD.");
        }
                
        //Eliminar Informacion de Tabla RequisicionE
        if (!EliminarRequisicionE($conexion, $idSolicitud)) {
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al eliminar en la tabla requisicionE.");
        }

        // Confirmar la transacción
        $conexion->commit();

        $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion); // Buscar y retornar el tipo de usuario

        // Respuesta de éxito con la URL según tipo de usuario
        $urls = [
            1 => "../../Vista/DEV/index_DEV.php", // URL para el tipo de usuario 1
            2 => "../../Vista/SUPERADMIN/Solicitud_SUPERADMIN.php", // URL para el tipo de usuario 2
            3 => "../../Vista/ADMIN/index_ADMIN.php", // URL para el tipo de usuario 3
            4 => "../../Vista/USER/index_USER.php", // URL para el tipo de usuario 4
            5 => "../../Vista/ALMACENISTA/index_ALMACENISTA.php" // URL para el tipo de usuario 5
        ];
            
        echo json_encode([  // Enviar la respuesta en formato JSON
            "success" => true, // Indicar que la operación fue exitosa
            "message" => "Se ha Modificado Correctamente.", // Mensaje de confirmación
            "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php" // Redireccionar a la página de inicio
        ]);
    } catch (Exception $e) {
        $conexion->rollback(); // Cancelar la transacción
        echo json_encode([ // Enviar la respuesta en formato JSON
            "success" => false, // Indicar que la operación falló
            "message" => "No se pudo realizar el registro: " . $e->getMessage() // Mensaje de error
        ]);
    } finally {
        // Cerrar la conexión
        $conexion->close();
    }
} else {
    echo json_encode([ // Devuelve un JSON con el resultado
        "success" => false, // Indica que la operación falló
        "message" => "No se proceso correctamente la informacion del formulario." // Mensaje de error
    ]);
}
?>