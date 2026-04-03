<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
ob_start(); // Limpia cualquier salida previa
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México

// Incluir dependencias necesarias
include('../../Modelo/Conexion.php');
require_once("../../Modelo/Funciones/Funciones_DevolucionE.php");
require_once("../../Modelo/Funciones/Funciones_DevolucionD.php");
require_once("../../Modelo/Funciones/Funciones_Inventario.php");
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

// Verifica si se proporciona un ID a través de POST
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
    $usuario = $_SESSION['usuario'];
    $idSolicitud = $_GET['id']; // Obtener el ID de la solicitud
    $fecha_alta = date('Y-m-d H:i:s'); // Obtener la fecha y hora actual

    if (!$idSolicitud || !$usuario) { // Verificar si se proporcionó un ID y un usuario
        echo json_encode([ // Si no se proporcionó un ID o un usuario, enviar un mensaje de error
            "success" => false, // Indicar si la operación fue exitosa
            "message" => "Datos inválidos. Por favor, revise la información enviada." // Mostrar un mensaje de error
        ]);
        exit; // Salir del script
    }

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Buscamos la información de la entradaD
        $InformacionDevolucionD = ObtenerDevolucionD($conexion, $idSolicitud);

        if (!$InformacionDevolucionD) { // Verificar si se ha insertado correctamente la región
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al buscar en la tabla requisicionE.");
        }

        foreach ($InformacionDevolucionD as $item) {
            $idProductoDevolucionD = intval($item['IdCProd']);
            $idtallDevolucionD = intval($item['IdTalla']);
            $cantDevolucionD = intval($item['Cantidad']);

            if (!insertarInventario($conexion, $idProductoDevolucionD, $idtallDevolucionD, $cantDevolucionD)) { // Verificar si se ha insertado correctamente
                // Lanzar una excepción en caso de error en la inserción
                throw new Exception("Error al insertar el inventario.");
            }
        }

        if (ActualizarEstatusDevolucionE($conexion, $fecha_alta, $idSolicitud)) { // Verificar si se ha insertado correctamente la región
            // Si todo fue bien, hacer commit de la transacción
            $conexion->commit();

            $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion); // Buscar y retornar el tipo de usuario

            // Respuesta de éxito con la URL según tipo de usuario
            $urls = [
                1 => "../../Vista/DEV/Almacen_Dev.php", // URL para el tipo de usuario 1
                2 => "../../Vista/SUPERADMIN/index_SUPERADMIN.php", // URL para el tipo de usuario 2
                3 => "../../Vista/ADMIN/index_ADMIN.php", // URL para el tipo de usuario 3
                4 => "../../Vista/USER/index_USER.php", // URL para el tipo de usuario 4
                5 => "../../Vista/ALMACENISTA/Devolucion_ALMACENISTA.php" // URL para el tipo de usuario 5
            ];
            
            echo json_encode([  // Enviar la respuesta en formato JSON
                "success" => true, // Indicar que la operación fue exitosa
                "message" => "Se ha Inventariado Correctamente.", // Mensaje de éxito
                "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php" // Redireccionar a la página de inicio
            ]);
        } else {
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al actualizar el estatus de la entrada.");
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
        "message" => "No se proceso correctamente la informacion del formulario." // Muestra un mensaje de error
    ]);
}
?>