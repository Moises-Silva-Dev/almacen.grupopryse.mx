<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México

// Incluir dependencias necesarias
include('../../../Modelo/Conexion.php'); // Incluir el archivo de conexión
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php"); // Carga la clase de funciones de tipo de usuario
require_once("../../../Modelo/Funciones/Funciones_Usuarios.php"); // Carga la clase de funciones de la cuenta

try {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        throw new Exception("Método no permitido");
    }
    
    $conexion = (new Conectar())->conexion(); // Conectar a la base de datos
    
    if (!$conexion || $conexion->connect_error) { // Verificar si la conexión a la base de datos fue exitosa
        throw new Exception("Error en la conexión: " . $conexion->connect_error);
    }

    // Obtener datos del formulario
    $idUsuario = $_POST['id'] ?? null;
    $idTipoNuevo = $_POST['ID_Tipo'] ?? null;
    $usuario = $_SESSION["usuario"] ?? null; // Recuperar el usuario de la sesión
    $tipoActual = $_POST['idTipoActual'] ?? null;

    if (!$idUsuario || !$usuario || !$tipoActual) {
        throw new Exception("ID de usuario no proporcionado");
    }

    // Procesar DatosTablaCuenta
    $datosCuentas = [];
    if (isset($_POST['DatosTablaCuenta'])) {
        $datosCuentas = json_decode($_POST['DatosTablaCuenta'], true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Formato JSON inválido para DatosTablaCuenta");
        }
    }

    $conexion->begin_transaction(); // Comenzar la transacción

    if ($idTipoNuevo && !in_array($idTipoNuevo, [3, 4])) { // Caso 1: Cambio a tipo que no requiere cuentas (1, 2, 5)
        if (!EliminarUsuarioCuenta($conexion, $idUsuario)) { // Eliminar relaciones existentes
            throw new Exception("Error al eliminar relaciones con cuentas existentes");
        }

        if (!UpdateRolUsuario($conexion, $idTipoNuevo, $idUsuario)) {
            throw new Exception("Error al actualizar el rol del usuario");
        }

        if (!InsertarNuevoUsuarioCuenta($conexion, $idUsuario, $cuenta['id'] = NULL)) {
            throw new Exception("Error al agregar nueva relación con cuenta");
        }
    } elseif ($idTipoNuevo && in_array($idTipoNuevo, [3, 4])) { // Caso 2: Cambio a tipo que requiere cuentas (3, 4)
        // Validar que se hayan proporcionado cuentas
        if (empty($datosCuentas)) {
            throw new Exception("Debe asignar al menos una cuenta para este tipo de usuario");
        }

        if (!UpdateRolUsuario($conexion, $idTipoNuevo, $idUsuario)) {
            throw new Exception("Error al actualizar el rol del usuario");
        }

        // Eliminar relaciones existentes
        if (!EliminarUsuarioCuenta($conexion, $idUsuario)) {
            throw new Exception("Error al eliminar relaciones con cuentas existentes");
        }

        // Agregar nuevas relaciones
        foreach ($datosCuentas as $cuenta) {
            if (!InsertarNuevoUsuarioCuenta($conexion, $idUsuario, $cuenta['id'])) {
                throw new Exception("Error al agregar nueva relación con cuenta");
            }
        }
    } elseif (in_array($tipoActual, [3, 4])) { // Caso 3: Actualización de cuentas para tipo existente (3, 4)
        // Validar que se hayan proporcionado cuentas
        if (empty($datosCuentas)) {
            throw new Exception("Debe asignar al menos una cuenta para este tipo de usuario");
        }

        // Eliminar relaciones existentes
        if (!EliminarUsuarioCuenta($conexion, $idUsuario)) {
            throw new Exception("Error al eliminar relaciones con cuentas existentes");
        }

        // Agregar nuevas relaciones
        foreach ($datosCuentas as $cuenta) {
            if (!InsertarNuevoUsuarioCuenta($conexion, $idUsuario, $cuenta['id'])) {
                throw new Exception("Error al agregar nueva relación con cuenta");
            }
        }
    } else {
        throw new Exception("Operación no válida");
    }

    // Confirmar la transacción
    $conexion->commit();

    $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion); // Buscar y retornar el tipo de usuario

    // Respuesta de éxito con la URL según tipo de usuario
    $urls = [
        1 => "../../../Vista/DEV/Registro_Usuario_Dev.php", // URL para el tipo de usuario 1
        2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php", // URL para el tipo de usuario 2
        3 => "../../../Vista/ADMIN/index_ADMIN.php", // URL para el tipo de usuario 3
        4 => "../../../Vista/USER/index_USER.php", // URL para el tipo de usuario 4
        5 => "../../../Vista/ALMACENISTA/index_ALMACENISTA.php" // URL para el tipo de usuario 5
    ];

    echo json_encode([  // Enviar la respuesta en formato JSON
        "success" => true, // Indicar que la operación fue exitosa
        "message" => "Se ha Cambiado el Rol Correctamente.", // Mensaje de éxito
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
?>