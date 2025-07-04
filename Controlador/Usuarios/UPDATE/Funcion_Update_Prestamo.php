<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México

// Incluir dependencias necesarias
include('../../../Modelo/Conexion.php'); // Conexión a la base de datos
require_once("../../../Modelo/Funciones/Funciones_PrestamoD.php"); // Funciones para el prestamoE
require_once("../../../Modelo/Funciones/Funciones_PrestamoE.php"); // Funciones para el prestamoD
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php"); // Funciones para el tipo de usuario
require_once("../../../Modelo/Funciones/Funciones_Usuarios.php"); // Funciones para los usuarios

$conexion = (new Conectar())->conexion(); // Conectar a la base de datos

// Verificar si la conexión a la base de datos fue exitosa
if (!$conexion || $conexion->connect_error) {
    echo json_encode([ // Si la conexión falla, enviar un mensaje de error
        "success" => false, // Indicar si la operación fue exitosa
        "message" => "Error en la conexión: " . $conexion->connect_error // Mostrar el error de conexión
    ]);
    exit; // Salir del script
}

// Procesamiento del formulario cuando se recibe una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $IdPrestamoE = $_POST['IdPrestamoE'];
    $Justificacion = $_POST['Justificacion'];
    $usuario = $_SESSION['usuario']; // Obtiene el Correo del usuario actual

    // Establecer la fecha y hora actual
    $FchActualizacion = date('Y-m-d H:i:s'); // Fecha y hora actual
    $Estatus = 'Pendiente_Modificado'; // Nuevo estatus

    if (!$Justificacion || !$usuario) { // Verificar que los campos no estén vacíos
        echo json_encode([ // Devuelve un arreglo JSON con el mensaje de error
            "success" => false, // Indica que la operación no se realizó con éxito
            "message" => "Datos inválidos. Por favor, revise la información enviada." // Mensaje de error
        ]);
        exit; // Salir del script
    }

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Buscar el identificador del usuario
        $id_Usuario = ObtenerIdentificadorUsuario($conexion, $usuario);

        if (!$id_Usuario) {
            // Si no se encuentra el identificador del usuario, se devuelve un mensaje de error
            throw new Exception("No se encontró el identificador del usuario");
        }

        // Actualizar la requisición en la tabla RequisicionE
        if (!ActualizarPrestamoE($conexion, $FchActualizacion, $Justificacion, $IdPrestamoE)) {
            // Si la actualización falla, se lanza una excepción
            throw new Exception("Error al actualizar la requisiciónE");
        }

        // Eliminar la requisición en la tabla RequisicionD
        if (!EliminarPrestamoD($conexion, $IdPrestamoE)) {
            // Si la eliminación falla, se lanza una excepción
            throw new Exception("Error al eliminar el prestamoD");
        }

        // Verifica si $_POST['datosTabla'] está definido
        if (isset($_POST['datosTabla'])) {
            // Decodifica los datos del formulario
            $datosTabla = json_decode($_POST['datosTabla'], true);

            // Verifica si la decodificación fue exitosa
            if (json_last_error() === JSON_ERROR_NONE) {
                // Obtiene la cantidad de filas en los datos de la tabla
                $numFilas = count($datosTabla);

                // Itera sobre los datos de la tabla oculta utilizando un bucle for
                for ($i = 0; $i < $numFilas; $i++) {
                    // Obtiene los datos de la fila actual
                    $idProducto = $datosTabla[$i]['idProduct'];
                    $idtall = $datosTabla[$i]['idtall'];
                    $cant = $datosTabla[$i]['cant'];

                    // Inserta en la tabla RequisicionD
                    if (!InsertarNuevoPrestamoD($conexion, $IdPrestamoE, $idProducto, $idtall, $cant)) {
                        // Si la inserción falla, se lanza una excepción
                        throw new Exception("Error al insertar en la tabla RequisicionD");
                    }
                }
            } else {
                // Maneja el caso en el que $_POST['datosTabla'] no es un JSON válido
                throw new Exception("Los datos de la tabla no están en el formato JSON esperado.");
            }
        } else {
            // Maneja el caso en el que $_POST['datosTabla'] no está definido
            throw new Exception("No se recibieron datos de la tabla.");
        }

        // Si todo fue bien, hacer commit de la transacción
        $conexion->commit();

        $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion); // Buscar y retornar el tipo de usuario

        // Respuesta de éxito con la URL según tipo de usuario
        $urls = [
            1 => "../../../Vista/DEV/index_DEV.php", // URL para el tipo de usuario 1
            2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php", // URL para el tipo de usuario 2
            3 => "../../../Vista/ADMIN/Prestamo_ADMIN.php", // URL para el tipo de usuario 3
            4 => "../../../Vista/USER/index_USER.php", // URL para el tipo de usuario 4
            5 => "../../../Vista/ALMACENISTA/index_ALMACENISTA.php" // URL para el tipo de usuario 5
        ];

        echo json_encode([  // Enviar la respuesta en formato JSON
            "success" => true, // Indicar que la operación fue exitosa
            "message" => "Se ha Guardado Correctamente.", // Mensaje de éxito
            "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php" // Redireccionar a la página de inicio
        ]);
    } catch (Exception $e) {
        $conexion->rollback(); // Cancelar la transacción
        echo json_encode([ // Enviar la respuesta en formato JSON
            "success" => false, // Indicar que la operación falló
            "message" => "Error al realizar el registro: " . htmlspecialchars($e->getMessage()) // Mensaje de error
        ]);
    } finally {
        // Cerrar la conexión
        $conexion->close();
    }
} else {
    echo json_encode([ // Devuelve un JSON con el resultado
        "success" => false, // Indica que la operación falló
        "message" => "No se proporcionó un ID válido." // Mensaje de error
    ]);
}
?>