<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México

// Incluir dependencias necesarias
include('../../../Modelo/Conexion.php'); // Incluir el archivo de conexión
require_once("../../../Modelo/Funciones/Funciones_Regiones.php"); // Incluir el archivo de funciones de regiones
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
    $ID_Cuenta = $_POST["ID_Cuenta"];
    $Nombre_Region = $_POST["Nombre_Region"];
    $registro = date('Y-m-d H:i:s', time()); // Obtener la fecha y hora actual
    $usuario = $_SESSION["usuario"]; // Recuperar el usuario de la sesión

    if (!$ID_Cuenta || !$Nombre_Region || !$usuario) { // Verificar que los campos no estén vacíos
        echo json_encode([ // Devuelve un arreglo JSON con el mensaje de error
            "success" => false, // Indica que la operación no se realizó con éxito
            "message" => "Datos inválidos. Por favor, revise la información enviada."
        ]);
        exit; // Salir del script
    }

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Recuperar la ID de la región
        $ID_region = insertarNuevoRegion($conexion, $Nombre_Region, $registro);

        if (!$ID_region) { // Verificar si se ha insertado correctamente la región
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al insertar en la tabla region.");
        }
        
        // Insertar en la tabla Region_Cuenta
        if (!insertarNuevoRegionCuenta($conexion, $ID_Cuenta, $ID_region)){
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al insertar en la tabla Region_Cuenta");
        }

        // Verifica si $_POST['datosTabla'] está definido
        if (isset($_POST['datosTablaInsertRegion'])) {
            // Decodifica los datos del formulario
            $datosTabla = json_decode($_POST['datosTablaInsertRegion'], true);

            // Verifica si la decodificación fue exitosa
            if (json_last_error() === JSON_ERROR_NONE) {
                // Obtiene la cantidad de filas en los datos de la tabla
                $numFilas = count($datosTabla);

                // Itera sobre los datos de la tabla oculta utilizando un bucle for
                for ($i = 0; $i < $numFilas; $i++) {
                    // Obtiene los datos de la fila actual
                    $idEstado = $datosTabla[$i]['idEstado'];

                    // Inserta en la tabla Estado_Region
                    if (!insertarNuevoEstadoRegion($conexion, $ID_region, $idEstado)) {
                        throw new Exception("Error al insertar en estado Region");
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
            1 => "../../../Vista/DEV/Regiones_Dev.php", // URL para el tipo de usuario 1
            2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php", // URL para el tipo de usuario 2
            3 => "../../../Vista/ADMIN/index_ADMIN.php", // URL para el tipo de usuario 3
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
            "message" => "Error al realizar el registro: " . htmlspecialchars($e->getMessage()) // Mostrar el mensaje de error
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