<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México

// Incluir dependencias necesarias
include('../../../Modelo/Conexion.php'); // Incluir el archivo de conexión
require_once("../../../Modelo/Funciones/Funciones_Recluta.php"); // Carga la clase de funciones de la cuenta
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php"); // Carga la clase de funciones de tipo de usuario

$conexion = (new Conectar())->conexion(); // Conectar a la base de datos

// Verificar si la conexión a la base de datos fue exitosa
if (!$conexion || $conexion->connect_error) {
    echo json_encode([ // Si la conexión falla, enviar un mensaje de error
        "success" => false, // Indicar si la operación fue exitosa
        "message" => "Error en la conexión: " . $conexion->connect_error // Mostrar el error de conexión
    ]);
    exit; // Salir del script
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $ID_Recluta = $_POST['ID_Recluta'];
    $nombre = $_POST["nombre"];
    $ap_paterno = $_POST["ap_paterno"];
    $ap_materno = $_POST["ap_materno"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $origen_vacante = $_POST["origen_vacante"];
    $fecha_envio = $_POST["fecha_envio"];
    $transferido = $_POST["transferido"];
    $estado = $_POST["estado"];
    $municipio = $_POST["municipio"];
    $centro_trabajo = $_POST["centro_trabajo"];
    $telefono = $_POST["telefono"];
    $servicio = $_POST["servicio"];
    $escolaridad = $_POST["escolaridad"];
    $edad = $_POST["edad"];
    $transferido_a = $_POST["transferido_a"];
    $estatus = $_POST["estatus"];
    $observaciones = $_POST["observaciones"];
    $reclutador = $_POST["reclutador"];

    $usuario = $_SESSION["usuario"]; // Recuperar el usuario de la sesión
    $registro = date("Y-m-d H:i:s", time()); // Obtener la fecha y hora actual

    if (!$ID_Recluta || !$nombre || !$ap_paterno || !$ap_materno || !$fecha_nacimiento || 
        !$origen_vacante || !$fecha_envio || !$transferido || !$estado || !$fecha_envio || 
        !$transferido || !$estado || !$municipio || !$centro_trabajo || !$telefono || 
        !$servicio || !$escolaridad || !$edad || !$transferido_a || !$estatus || 
        !$observaciones || !$reclutador || !$usuario) { // Verificar que los campos no estén vacíos
        echo json_encode([ // Devuelve un arreglo JSON con el mensaje de error
            "success" => false, // Indica que la operación no fue exitosa
            "message" => "Datos inválidos. Por favor, revise la información enviada." // Mostrar el mensaje de error
        ]);
        exit; // Salir del script
    }
    
    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Insertar el nuevo registro
        if (ActualizarRecluta($conexion, $nombre, $ap_paterno, $ap_materno, $fecha_nacimiento, $origen_vacante, $fecha_envio, $transferido, $estado, $municipio, $centro_trabajo, $telefono, $servicio, $escolaridad, $edad, $transferido_a, $estatus, $observaciones, $registro, $reclutador, $ID_Recluta)) {
            $conexion->commit(); // Confirmar la transacción

            $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion); // Buscar y retornar el tipo de usuario

            // Respuesta de éxito con la URL según tipo de usuario
            $urls = [
                1 => "../../../Vista/DEV/Cuenta_Dev.php", // URL para el tipo de usuario 1
                2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php", // URL para el tipo de usuario 2
                3 => "../../../Vista/ADMIN/index_ADMIN.php", // URL para el tipo de usuario 3
                4 => "../../../Vista/USER/index_USER.php", // URL para el tipo de usuario 4
                5 => "../../../Vista/ALMACENISTA/index_ALMACENISTA.php", // URL para el tipo de usuario 5
                6 => "../../../Vista/RH/Reclutas_RH.php", // URL para el tipo de usuario 6
            ];
            
            echo json_encode([  // Enviar la respuesta en formato JSON
                "success" => true, // Indicar que la operación fue exitosa
                "message" => "Se ha Guardado Correctamente.", // Mostrar un mensaje de éxito
                "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php" // Redireccionar a la página de inicio
            ]);
        } else {
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error en la inserción de la tabla cuenta.");
        }
    } catch (Exception $e) {
        $conexion->rollback(); // Cancelar la transacción
        echo json_encode([ // Enviar la respuesta en formato JSON
            "success" => false, // Indicar que la operación falló
            "message" => "No se pudo realizar el registro: " . $e->getMessage() // Mostrar el mensaje de error
        ]);
    } finally {
        // Cerrar la conexión
        $conexion->close();
    }
} else {
    echo json_encode([ // Devuelve un JSON con el resultado
        "success" => false, // Indica que la operación falló
        "message" => "No se proporcionó un ID válido." // Mostrar el mensaje de error
    ]);
}
?>