<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México

// Incluir dependencias necesarias
include('../../../Modelo/Conexion.php'); // Conexión a la base de datos
require_once("../../../Modelo/Funciones/Funciones_Inventario.php"); // Incluir funciones de inventario
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php"); // Incluir funciones de tipo de usuario
require_once("../../../Modelo/Funciones/Funciones_Salida_PrestamoD.php"); // Incluir funciones de salida del prestamo de detalles
require_once("../../../Modelo/Funciones/Funciones_Salida_PrestamoE.php"); // Incluir funciones de salida del prestamo de especificación
require_once("../../../Modelo/Funciones/Funciones_PrestamoD.php"); // Incluir funciones de requisición de detalles
require_once("../../../Modelo/Funciones/Funciones_PrestamoE.php"); // Incluir funciones de requisición de elementos
require_once("../../../Modelo/Funciones/Funciones_Usuarios.php"); // Incluir funciones de usuarios

$conexion = (new Conectar())->conexion(); // Conectar a la base de datos

// Verificar si la conexión a la base de datos fue exitosa
if (!$conexion || $conexion->connect_error) {
    echo json_encode([ // Si la conexión falla, enviar un mensaje de error
        "success" => false, // Indicar si la operación fue exitosa
        "message" => "Error en la conexión: " . $conexion->connect_error // Mostrar el error de conexión
    ]);
    exit; // Salir del script
}

// Procesar solicitudes POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recuperar la información del formulario
    $usuario = $_SESSION['usuario'];            
    $IdPrestamoE = $_POST['IdPrestamoE'] ?? null;
    $fecha_salida = date('Y-m-d H:i:s');

    if (!$IdPrestamoE || !$usuario) { // Validar ID de requisición
        echo json_encode([
            "success" => false, // Indicar si la operación fue exitosa
            "message" => "Datos inválidos. Por favor, revise la información enviada." // Muestra el mensaje de error
        ]);
        exit;
    }

    // Iniciar transacción
    $conexion->begin_transaction();

    try {
        // Obtener el ID del usuario
        $ID_Usuario = ObtenerIdentificadorUsuario($conexion, $usuario);

        if (!$ID_Usuario) { // Validar ID de usuario
            // Si el ID de usuario no existe, mostrar un mensaje de error
            throw new Exception("Error al obtener el identificador del usuario.");
        }

        // Insertar en la tabla Salida_E
        $ID_SalidaPrestamoE = InsertarNuevaSalidaPrestamoE($conexion, $IdPrestamoE, $ID_Usuario, $fecha_salida);

        if (!$ID_SalidaPrestamoE) { // Validar ID de salida de elementos
            // Si el ID de salida de elementos no existe, mostrar un mensaje de error
            throw new Exception("Error al insertar en la tabla Salida_E.");
        }

        // Validar y procesar datos de la tabla
        if (isset($_POST['datosTablaInsertSalida'])) {
            // Procesar datos de la tabla
            $datosTabla = json_decode($_POST['datosTablaInsertSalida'], true);

            if (json_last_error() !== JSON_ERROR_NONE) { // Validar si los datos de la tabla son válidos
                // Si hay un error al parsear los datos, mostrar un mensaje de error
                throw new Exception("Los datos de la tabla no están en el formato JSON esperado.");
            }

            // Insertar en la tabla Salida_E_Detalle
            foreach ($datosTabla as $fila) {
                // Insertar cada fila en la tabla Salida_E_Detalle
                $IdCProd = $fila['IdCProd'] ?? null;
                $Id_Talla = $fila['Id_Talla'] ?? null;
                $Cant = isset($fila['Cant']) && is_numeric($fila['Cant']) ? (int)$fila['Cant'] : 0;

                // Obtiene los datos de la salidaD
                if (!$IdCProd || !$Id_Talla || $Cant <= 0) {
                    continue; // Ignorar filas inválidas
                }

                // Insertar en Salida_D
                if (!InsertarNuevaSalidaPrestamoD($conexion, $ID_SalidaPrestamoE, $IdCProd, $Id_Talla, $Cant)) {
                    // Si hay un error al insertar en la tabla Salida_D, mostrar un mensaje d
                    throw new Exception("Error al insertar en la tabla Salida_D.");
                }

                // Actualizar inventario
                if (!ActualizarInventarioPorSalidaRequisicion($conexion, $Cant, $IdCProd, $Id_Talla)) {
                    // Si hay un error al actualizar el inventario, mostrar un mensaje de error
                    throw new Exception("Error al actualizar el inventario.");
                }
            }
        } else {
            // Si no hay datos de la tabla, mostrar un mensaje de error
            throw new Exception("No se recibieron datos de la tabla.");
        }

        // Actualizar estatus de la requisición
        if (!ActualizarEstatusPrestamoESalida($conexion, $IdPrestamoE)) {
            // Si hay un error al actualizar el estatus de la requisición, mostrar un mensaje d
            throw new Exception("Error al actualizar el estatus de la requisición.");
        }

        // Confirmar transacción
        $conexion->commit();

        // Determinar la URL de redirección según el tipo de usuario
        $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion);

        // Respuesta de éxito con la URL según tipo de usuario
        $urls = [
            1 => "../../../Vista/DEV/Salidas_Dev.php", // URL para el tipo de usuario 1
            2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php", // URL para el tipo de usuario 2
            3 => "../../../Vista/ADMIN/index_ADMIN.php", // URL para el tipo de usuario 3
            4 => "../../../Vista/USER/index_USER.php", // URL para el tipo de usuario 4
            5 => "../../../Vista/ALMACENISTA/Salidas_ALMACENISTA.php" // URL para el tipo de usuario 5
        ];

        echo json_encode([ // Enviar la respuesta en formato JSON
            "success" => true, // Indicar que la operación fue exitosa
            "message" => "Se ha guardado correctamente.", // Mensaje de éxito
            "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php" // Redireccionar a la página de inicio
        ]);
    } catch (Exception $e) {
        $conexion->rollback(); // Revertir transacción en caso de error
        echo json_encode([ // Enviar la respuesta en formato JSON
            "success" => false, // Indicar que la operación falló
            "message" => "Error al realizar el registro: " . htmlspecialchars($e->getMessage()) // Mostrar el mensaje de error
        ]);
    } finally {
        $conexion->close(); // Cerrar conexión
    }
} else {
    echo json_encode([ // Enviar la respuesta en formato JSON
        "success" => false, // Indicar que la operación falló
        "message" => "Solicitud inválida." // Mostrar mensaje de error
    ]);
}
?>