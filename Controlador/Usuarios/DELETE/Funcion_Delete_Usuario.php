<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México
include('../../../Modelo/Conexion.php'); // Incluir el archivo de conexión
require_once("../../../Modelo/Funciones/Funciones_Usuarios.php"); // Carga la clase de funciones de la cuenta

$conexion = (new Conectar())->conexion(); // Conectar a la base de datos

// Verifica si se proporciona un ID
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
    $id_Usuario = $_GET['id']; // Obtiene el ID de la cuenta
    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // eliminar en la tabla Region_Cuenta
        if (!EliminarUsuarioCuenta($conexion, $id_Usuario)){
            throw new Exception("Error al insertar en la tabla Estado_Region");
        }

        // eliminar en la tabla Region
        if (EliminarUsuario($conexion, $id_Usuario)) {
            $conexion->commit(); // Confirmar la transacción

            echo json_encode([  // Enviar la respuesta en formato JSON
                "success" => true, // Indicar que la operación fue exitosa
                "message" => "Se ha Guardado Correctamente.",
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([ // Devuelve un JSON con el resultado
            "success" => false, // Indica que la operación falló
            "message" => "Error: " . $e->getMessage()
        ]);
    }finally {
        // Cerrar la conexión
        $conexion->close();
    }
} else {
    echo json_encode([ // Devuelve un JSON con el resultado
        "success" => false, // Indica que la operación falló
        "message" => "No se proporcionó un ID válido."
    ]);
}
?>