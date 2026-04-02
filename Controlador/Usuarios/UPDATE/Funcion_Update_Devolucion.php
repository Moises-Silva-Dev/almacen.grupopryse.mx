<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México

// Incluir dependencias necesarias
include('../../../Modelo/Conexion.php'); // Incluir el archivo de conexión
require_once("../../../Modelo/Funciones/Funciones_DevolucionD.php"); // Carga la clase de funciones de la devolucionD
require_once("../../../Modelo/Funciones/Funciones_DevolucionE.php"); // Carga la clase de funciones de la devolucionE
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php"); // Carga la clase de funciones de tipo de usuario

$conexion = (new Conectar())->conexion(); // Conectar a la base de datos

// Verificar si la conexión a la base de datos fue exitosa
if (!$conexion || $conexion->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Error en la conexión: " . $conexion->connect_error
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $id_DevolucionE = $_POST['id'] ?? null; // Cambiado de IdDevolucionE a id
    $Nombre_Devuelve = $_POST['Nombre_Devuelve'] ?? null;
    $Telefono_Devuelve = $_POST['Telefono_Devuelve'] ?? null;
    $Justificacion = $_POST['Justificacion'] ?? null;
    $Tipo = $_POST['Tipo'] ?? null; // Cambiado de Opcion a Tipo
    $Identificador = $_POST['Identificador'] ?? null;
    $usuario = $_SESSION["usuario"] ?? null;
    $fecha = date('Y-m-d H:i:s', time()); // Obtiene la fecha y hora actual

    // Validar campos requeridos
    if (!$id_DevolucionE || !$Nombre_Devuelve || !$Telefono_Devuelve || !$Justificacion || !$usuario) {
        echo json_encode([
            "success" => false,
            "message" => "Datos inválidos. Por favor, revise la información enviada."
        ]);
        exit;
    }

    // Validar teléfono (10 dígitos)
    if (!preg_match('/^\d{10}$/', $Telefono_Devuelve)) {
        echo json_encode([
            "success" => false,
            "message" => "El teléfono debe tener 10 dígitos."
        ]);
        exit;
    }

    // Comienza la transacción
    $conexion->begin_transaction();

    try {
        // Actualizar la entrada en la tabla DevolucionE
        if (!ActualizarDevolucionE($conexion, $Nombre_Devuelve, $Telefono_Devuelve, $Justificacion, $fecha, $Tipo, $Identificador, $id_DevolucionE)) {
            throw new Exception("Error al actualizar la tabla DevolucionE.");
        }

        // Eliminar los detalles antiguos de DevolucionD
        if (!EliminarDevolucionD($conexion, $id_DevolucionE)) {
            throw new Exception('Error al eliminar los detalles antiguos de DevolucionD');
        }

        // Verificar si hay nuevos datos de productos
        if (isset($_POST['datosTablaUpdateDevolucion']) && !empty($_POST['datosTablaUpdateDevolucion'])) {
            // Decodifica los datos del formulario
            $datosTabla = json_decode($_POST['datosTablaUpdateDevolucion'], true);
                    
            // Verifica si la decodificación fue exitosa
            if (json_last_error() === JSON_ERROR_NONE && is_array($datosTabla) && count($datosTabla) > 0) {
                // Itera sobre los datos de la tabla
                foreach ($datosTabla as $fila) {
                    $idProducto = $fila['idProduct'] ?? null;
                    $idtall = $fila['idtall'] ?? null;
                    $cant = $fila['cant'] ?? null;
                    
                    // Validar datos del producto
                    if (!$idProducto || !$idtall || !$cant || $cant <= 0) {
                        continue; // Saltar filas inválidas
                    }
                    
                    // Insertar en DevolucionD
                    if (!InsertarNuevaDevolucionD($conexion, $id_DevolucionE, $idProducto, $idtall, $cant)) {
                        throw new Exception("Error al insertar en DevolucionD para el producto: $idProducto");
                    }
                }
            } else {
                throw new Exception("Los datos de la tabla no están en el formato JSON esperado o están vacíos.");
            }
        } else {
            throw new Exception("No se recibieron datos de productos para la devolución.");
        }

        // Si todo fue bien, hacer commit de la transacción
        $conexion->commit();

        $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion);

        // Respuesta de éxito con la URL según tipo de usuario
        $urls = [
            1 => "../../../Vista/DEV/Devolucion_Dev.php",
            2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php",
            3 => "../../../Vista/ADMIN/index_ADMIN.php",
            4 => "../../../Vista/USER/index_USER.php",
            5 => "../../../Vista/ALMACENISTA/Devolucion_ALMACENISTA.php"
        ];

        echo json_encode([
            "success" => true,
            "message" => "Devolución actualizada correctamente.",
            "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php"
        ]);
        
    } catch (Exception $e) {
        $conexion->rollback();
        echo json_encode([
            "success" => false,
            "message" => "No se pudo actualizar la devolución: " . $e->getMessage()
        ]);
    } finally {
        $conexion->close();
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido."
    ]);
}
?>