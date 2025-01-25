<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México
include('../../../Modelo/Conexion.php'); // Incluir el archivo de conexión
require_once("../../../Modelo/Funciones/Funciones_Empresa.php");
require_once("../../../Modelo/Funciones/Funciones_Producto.php"); // Carga la clase de funciones de la cuenta
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php"); // Carga la clase de funciones de tipo de usuario

$conexion = (new Conectar())->conexion(); // Conectar a la base de datos

// Verifica si la solicitud es de tipo POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene la descripción del producto.
    $Descripcion = $_POST['Descripcion'];
    // Obtiene la especificación del producto.
    $Especificacion = $_POST['Especificacion'];
    $SubirImagen = $_FILES['Imagen'];

    // Obtiene la fecha y hora actual para el registro del producto.
    $registro = date('Y-m-d H:i:s', time());
    $usuario = $_SESSION["usuario"]; // Recuperar el usuario de la sesión

    // Obtiene los datos de la nueva empresa del formulario.
    $IdCEmpresa = $_POST['IdCEmpresa'];
    $Nombre_Empresa = $_POST['Nombre_Empresa'];
    $RazonSocial = $_POST['RazonSocial'];
    $RFC = $_POST['RFC'];
    $RegistroPatronal = $_POST['RegistroPatronal'];
    $Especif = $_POST['Especif'];

    // Obtiene la descripción de la nueva categoría del formulario.
    $IdCCate = $_POST['IdCCate'];
    $Descrp = $_POST['Descrp'];

    // Obtiene la descripción y talla de la nueva talla del formulario.
    $IdCTipTall = $_POST['IdCTipTall'];
    $Descrip = $_POST['descrip'];
    $Talla = $_POST['Talla'];

    if (!$IdCEmpresa || !$IdCCate || !$Descripcion || !$Especificacion || !$IdCTipTall) { // Verificar que los campos no estén vacíos
        echo json_encode([ // Devuelve un arreglo JSON con el mensaje de error
            "success" => false, // Indica que la operación no fue exitosa
            "message" => "Datos inválidos. Por favor, revise la información enviada."
        ]);
        exit; // Salir del script
    }

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Sube la imagen del producto y obtiene la ruta de la imagen.
        $imagen = subirImagen($SubirImagen);

        if (!$imagen) {
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al guardar la imagen.");
        }

        // Obtiene el ID de la empresa.
        $ID_Empresa = InsertarNuevaEmpresa($conexion, $IdCEmpresa, $Nombre_Empresa, $RazonSocial, $RFC, $RegistroPatronal, $Especif);

        if (!$ID_Empresa) { // Verificar si se insertó la empresa
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al insertar en la tabla empresa.");
        }

        // Obtiene el ID de la categoría.
        $ID_Categoria = InsertarNuevaCategoria($conexion, $IdCCate, $Descrp);

        if (!$ID_Categoria) { // Verificar si se insertó la empresa
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al insertar en la tabla categoría.");
        }

        // Obtiene el ID de la talla.
        $ID_TipoTalla = InsertarNuevaTipoTalla($conexion, $IdCTipTall, $Descrip, $Talla);

        if (!$ID_TipoTalla) { // Verificar si se insertó la empresa
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al insertar en la tabla TipoTalla.");
        }

        if (insertarNuevoProducto($conexion, $ID_Empresa, $ID_Categoria, $ID_TipoTalla, $Descripcion, $Especificacion, $imagen, $registro)) {
            // Si todo fue bien, hacer commit de la transacción
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
                "message" => "Se ha Guardado Correctamente.",
                "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php" // Redireccionar a la página de inicio
            ]);
        } else {
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error en la inserción del nuevo registro.");
        }
    } catch (Exception $e) {
        $conexion->rollback(); // Cancelar la transacción
        echo json_encode([ // Enviar la respuesta en formato JSON
            "success" => false, // Indicar que la operación falló
            "message" => "No se pudo realizar el registro: " . $e->getMessage()
        ]);
    } finally {
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