<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México

// Incluir dependencias necesarias
include('../../../Modelo/Conexion.php'); // Incluir el archivo de conexión
require_once("../../../Modelo/Funciones/Funciones_EntradaD.php"); // Carga la clase de funciones de la entradaD
require_once("../../../Modelo/Funciones/Funciones_EntradaE.php"); // Carga la clase de funciones de la entradaE
require_once("../../../Modelo/Funciones/Funciones_Inventario.php"); // Carga la clase de funciones de la inventario
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php"); // Carga la clase de funciones de tipo de usuario
require_once("../../../Modelo/Funciones/Funciones_Usuarios.php"); // Carga la clase de funciones de usuarios

$conexion = (new Conectar())->conexion(); // Conectar a la base de datos

// Verificar si la conexión a la base de datos fue exitosa
if (!$conexion || $conexion->connect_error) {
    echo json_encode([ // Si la conexión falla, enviar un mensaje de error
        "success" => false, // Indicar si la operación fue exitosa
        "message" => "Error en la conexión: " . $conexion->connect_error // Mostrar el error de conexión
    ]);
    exit; // Salir del script
}

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $Proveedor = $_POST["Proveedor"];
    $Receptor = $_POST["Receptor"];
    $Comentarios = $_POST['Comentarios'];
    $estatus = 'Creada';
    $registro = date('Y-m-d H:i:s', time()); // Obtener la fecha y hora actual
    $usuario = $_SESSION['usuario'];
    
    if (!$Proveedor || !$Receptor || !$Comentarios || !$usuario) { // Verificar que los campos no estén vacíos
        echo json_encode([ // Devuelve un arreglo JSON con el mensaje de error
            "success" => false, // Indica que la operación no se realizó con éxito
            "message" => "Datos inválidos. Por favor, revise la información enviada."
        ]);
        exit; // Salir del script
    }

    // Comenzar la transacción
    $conexion->begin_transaction();
    
    try {
        // Buscar el identificador del usuario
        $id_Usuario = ObtenerIdentificadorUsuario($conexion, $usuario);

        if (!$id_Usuario) { // Verificar si se ha insertado correctamente la región
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al buscar en la tabla usuario.");
        }

        $id_EntradaE = InsertarNuevaEntradaE($conexion, $registro, $id_Usuario, $Proveedor, $Receptor, $Comentarios, $estatus);

        if (!$id_EntradaE) { // Verificar si se ha insertado correctamente la región
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al insertar en la tabla entradaE.");
        }
        
        // Verifica si $_POST['datosTabla'] está definido
        if (isset($_POST['datosTablaInsertEntrada'])) {
            // Decodifica los datos del formulario
            $datosTabla = json_decode($_POST['datosTablaInsertEntrada'], true);

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

                    // Inserta en la tabla EntradaD
                    if (!InsertarNuevaEntradaD($conexion, $id_EntradaE, $idProducto, $idtall, $cant)) {
                        // Lanzar una excepción en caso de error en la inserción
                        throw new Exception("Error al insertar en EntradaD");
                    }

                    // Inserta en la tabla Inventario
                    if (!insertarInventario($conexion, $idProducto, $idtall, $cant)){
                        // Lanzar una excepción en caso de error en la inserción
                        throw new Exception("Error al insertar en Inventario");
                    }
                }
            } else {
                // Lanzar una excepción en caso de error en la decodificación
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
            1 => "../../../Vista/DEV/Almacen_Dev.php", // URL para el tipo de usuario 1
            2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php", // URL para el tipo de usuario 2
            3 => "../../../Vista/ADMIN/index_ADMIN.php", // URL para el tipo de usuario 3
            4 => "../../../Vista/USER/index_USER.php", // URL para el tipo de usuario 4
            5 => "../../../Vista/ALMACENISTA/Almacen_ALMACENISTA.php" // URL para el tipo de usuario 5
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