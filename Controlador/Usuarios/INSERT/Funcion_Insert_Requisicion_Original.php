<?php
// Configuración inicial
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
ob_start(); // Limpia cualquier salida previa
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México

// Inclusión de archivos necesarios
include('../../../Modelo/Conexion.php'); // Conexión a la base de datos
require_once("../../../Modelo/Funciones/Funciones_Borrador_RequisicionD.php");
require_once("../../../Modelo/Funciones/Funciones_Borrador_RequisicionE.php");
require_once("../../../Modelo/Funciones/Funciones_RequisicionD.php");
require_once("../../../Modelo/Funciones/Funciones_RequisicionE.php");
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php");

// Conexión a la base de datos
$conexion = (new Conectar())->conexion();

// Verificar si la conexión a la base de datos fue exitosa
if (!$conexion || $conexion->connect_error) {
    echo json_encode([ // Si la conexión falla, enviar un mensaje de error
        "success" => false, // Indicar si la operación fue exitosa
        "message" => "Error en la conexión: " . $conexion->connect_error // Mostrar el error de conexión
    ]);
    exit; // Salir del script
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Id'])) {        
    // Obtiene la fecha y hora de creación de la requisición 
    $FchEnvio = date('Y-m-d H:i:s');
    $usuario = $_SESSION['usuario']; // Obtiene el usuario actualmente conectado

    // Validación de datos
    $BIDRequisicionE = $_POST['Id'];

    if (!$BIDRequisicionE) { // Verificar que los campos no estén vacíos
        echo json_encode([ // Devuelve un arreglo JSON con el mensaje de error
            "success" => false, // Indica que la operación no se realizó con éxito
            "message" => "Datos inválidos. Por favor, revise la información enviada."
        ]);
        exit; // Salir del script
    }

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Obtener información del borrador de requisiciones
        $requisicionesE = SeleccionarInformacionBorradorRequisicionE($conexion, $BIDRequisicionE);
        $requisicionesD = SeleccionarInformacionBorradorRequisicionD($conexion, $BIDRequisicionE);

        if (!$requisicionesE) {
            throw new Exception('No se encontró información para la requisiciónE.');
        }

        if (!$requisicionesD) {
            throw new Exception('No se encontró información para la requisiciónD.');
        }

        // Crear nueva requisición en RequisicionE
        $ID_RequisionE = InsertarNuevaRequisicionE($conexion, $FchEnvio, $requisicionesE);

        if (!$ID_RequisionE) { // Verificar que la inserción se haya realizado correctamente
            throw new Exception('Error al insertar datos en la tabla RequisicionE.');
        }

        // Insertar detalles en RequisicionD
        $resultadoDetalles = InsertarNuevaRequisicionD($conexion, $ID_RequisionE, $requisicionesD);

        if (!$resultadoDetalles) { // Verificar que la inserción se haya realizado correctamente
            throw new Exception('Error al insertar detalles en la tabla RequisicionD.');
        }

        if (!EliminarBorradorRequisicionD($conexion, $BIDRequisicionE)){
            // Si la eliminación falla, se lanza una excepción
            throw new Exception('Error al eliminar el borrador de requisición D.');
        }

        if (EliminarBorradorRequisicionE($conexion, $BIDRequisicionE)) { // Si la eliminación es exitosa, se continúa con la transacción
            // Confirmar la transacción
            $conexion->commit();

            $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion); // Buscar y retornar el tipo de usuario

            // Respuesta de éxito con la URL según tipo de usuario
            $urls = [
                1 => "../../Vista/DEV/index_DEV.php", // URL para el tipo de usuario 1
                2 => "../../Vista/SUPERADMIN/index_SUPERADMIN.php", // URL para el tipo de usuario 2
                3 => "../../Vista/ADMIN/Solicitud_ADMIN.php", // URL para el tipo de usuario 3
                4 => "../../Vista/USER/Solicitud_USER.php", // URL para el tipo de usuario 4
                5 => "../../Vista/ALMACENISTA/index_ALMACENISTA.php" // URL para el tipo de usuario 5
            ];

            echo json_encode([  // Enviar la respuesta en formato JSON
                    "success" => true, // Indicar que la operación fue exitosa
                    "message" => "Se ha Guardado Correctamente.",
                "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php" // Redireccionar a la página de inicio
            ]);
        }
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.'
    ]);
}
?>