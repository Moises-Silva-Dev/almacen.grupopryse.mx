<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México
require_once("../../../Modelo/Funciones/Funciones_Cuenta.php"); // Carga la clase de funciones de la cuenta
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php"); // Carga la clase de funciones de tipo de usuario

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar que la sesión tenga un usuario
    if (empty($_SESSION["usuario"])) {
        echo json_encode([ // Devuelve un arreglo JSON con el mensaje de error
            "success" => false,
            "message" => "Sesión no iniciada. Por favor, inicie sesión."
        ]);
        exit; // Termina la ejecución del script
    }

    // Incluir el archivo de conexión
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion(); // Conectar a la base de datos

    // Recuperar los datos del formulario
    $NombreCuenta = $_POST["NombreCuenta"];
    $NroElemetos = $_POST["NroElemetos"];
    $usuario = $_SESSION["usuario"];

    if (!$NombreCuenta || !$NroElemetos) { // Verificar que los campos no estén vacíos
        echo json_encode([ // Devuelve un arreglo JSON con el mensaje de error
            "success" => false, 
            "message" => "Datos inválidos. Por favor, revise la información enviada."
        ]);
        exit; // Salir del script
    }
    
    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Insertar el nuevo registro
        if (insertarNuevoRegistro($NombreCuenta, $NroElemetos, $conexion)) {
            $conexion->commit(); // Confirmar la transacción

            $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion); // Buscar y retornar el tipo de usuario

            // Respuesta de éxito con la URL según tipo de usuario
            $urls = [
                1 => "../../../Vista/DEV/index_DEV.php", // URL para el tipo de usuario 1
                2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php", // URL para el tipo de usuario 2
                3 => "../../../Vista/ADMIN/index_ADMIN.php", // URL para el tipo de usuario 3
                4 => "../../../Vista/USER/index_USER.php", // URL para el tipo de usuario 4
                5 => "../../../Vista/ALMACENISTA/index_ALMACENISTA.php" // URL para el tipo de usuario 5
            ];
            
            echo json_encode([  // Enviar la respuesta en formato JSON
                "success" => true, // Indicar que la operación fue exitosa
                "message" => "Se ha Guardado Correctamente.",
                "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php" // Redireccionar a la página de inicio
            ]);
        } else {
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error en la inserción del nuevo registro.");
        }
    } catch (Exception $e) {
        $conexion->rollback(); // Cancelar la transacción
        echo json_encode([ // Enviar la respuesta en formato JSON
            "success" => false, // Indicar que la operación falló
            "message" => "No se pudo realizar el registro: " . $e->getMessage()
        ]);
    } finally {
        // Cerrar la conexión
        $conexion->close();
    }
}
?>