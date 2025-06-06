<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México

// Incluir dependencias necesarias
include('../../../Modelo/Conexion.php'); // Incluir el archivo de conexión
require_once("../../../Modelo/Funciones/Funciones_Producto.php"); // Carga la clase de funciones de la cuenta
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

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $ID_Producto = $_POST['id'];
    $ID_Empresa = $_POST['ID_Empresas'];
    $ID_Categoria = $_POST['Id_cate']; // Ajusta según el nombre real del campo en el formulario
    $ID_TipTalla = $_POST['Id_TipTall'];
    $Descripcion = $_POST['Descripcion'];
    $Especificacion = $_POST['Especificacion']; 
    $opcion = $_POST['opcion'];
    $SubirImagen = $_FILES['Imagen'];
    $registro = date('Y-m-d H:i:s', time()); // Obtiene la fecha y hora actual
    $usuario = $_SESSION["usuario"]; // Recuperar el usuario de la sesión

    if (!$ID_Producto || !$ID_Empresa || !$ID_Categoria || !$Descripcion || 
        !$Especificacion || !$ID_TipTalla || !$usuario) { // Verificar que los campos no estén vacíos
        echo json_encode([ // Devuelve un arreglo JSON con el mensaje de error
            "success" => false, // Indica que la operación no fue exitosa
            "message" => "Datos inválidos. Por favor, revise la información enviada." // Mensaje de error
        ]);
        exit; // Salir del script
    }

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        if ($opcion === 'SI') { // Si la opción es SI
            $imagen = subirImagen($SubirImagen); // Llamar a la función de subir imagen

            if (!$imagen) { 
                // Lanzar una excepción en caso de error en la inserción
                throw new Exception("Error al guardar la imagen.");
            }
        } else {
            $imagen = null; // Si la opción no es SI, establecer la imagen en nulo
        }

        // Actualizar el producto en la base de datos
        if (ActualizarProducto($conexion, $ID_Empresa, $ID_Categoria, $ID_TipTalla, $Descripcion, $Especificacion, $imagen, $registro, $ID_Producto)) {
            // Confirmar la transacción
            $conexion->commit();

            $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion); // Buscar y retornar el tipo de usuario

            // Respuesta de éxito con la URL según tipo de usuario
            $urls = [
                1 => "../../../Vista/DEV/Producto_Dev.php", // URL para el tipo de usuario 1
                2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php", // URL para el tipo de usuario 2
                3 => "../../../Vista/ADMIN/index_ADMIN.php", // URL para el tipo de usuario 3
                4 => "../../../Vista/USER/index_USER.php", // URL para el tipo de usuario 4
                5 => "../../../Vista/ALMACENISTA/Producto_ALMACENISTA.php" // URL para el tipo de usuario 5
            ];
            
            echo json_encode([  // Enviar la respuesta en formato JSON
                "success" => true, // Indicar que la operación fue exitosa
                "message" => "Se ha Modificado Correctamente.", // Mensaje de éxito
                "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php" // Redireccionar a la página de inicio
            ]);
        } else {
            // Lanzar una excepción en caso de error en la actualización
            throw new Exception("Error al intentar modificar el registro del producto."); 
        }
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
} else {
    echo json_encode([ // Devuelve un JSON con el resultado
        "success" => false, // Indica que la operación falló
        "message" => "No se proporcionó un ID válido." // Mensaje de error
    ]);
}
?>