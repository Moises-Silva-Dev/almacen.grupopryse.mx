<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México

// Incluir dependencias necesarias
include('../../../Modelo/Conexion.php'); // Conexión a la base de datos
require_once("../../../Modelo/Funciones/Funciones_PrestamoD.php"); // Incluir la clase de funciones para el borrador de requisiciónD
require_once("../../../Modelo/Funciones/Funciones_PrestamoE.php"); // Incluir la clase de funciones para el borrador de requisiciónE

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
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
    $id_PrestamoE = $_GET['id']; // Obtiene el ID de la solicitud de requisición

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // eliminar en la tabla Region_Cuenta
        if (!EliminarPrestamoD($conexion, $id_PrestamoE)){
            // Si hay un error, se cancela la transacción
            throw new Exception("Error al insertar en la tabla Estado_Region");
        }

        // eliminar en la tabla Region
        if (EliminarPrestamoE($conexion, $id_PrestamoE)) {
            $conexion->commit(); // Confirmar la transacción

            echo json_encode([  // Enviar la respuesta en formato JSON
                "success" => true, // Indicar que la operación fue exitosa
                "message" => "Se ha Guardado Correctamente.", // Mostrar un mensaje de éxito
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([ // Devuelve un JSON con el resultado
            "success" => false, // Indica que la operación falló
            "message" => "Error: " . $e->getMessage() // Muestra el mensaje de error
        ]);
    }finally {
        // Cerrar la conexión
        $conexion->close();
    }
} else {
    echo json_encode([ // Devuelve un JSON con el resultado
        "success" => false, // Indica que la operación falló
        "message" => "No se proporcionó un ID válido." // Muestra un mensaje de error
    ]);
}
?>