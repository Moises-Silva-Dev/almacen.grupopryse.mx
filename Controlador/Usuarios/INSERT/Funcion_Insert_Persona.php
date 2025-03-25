<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México

// Incluir dependencias necesarias
include('../../../Modelo/Conexion.php'); // Conexión a la base de datos
require_once("../../../Modelo/Funciones/Funciones_Persona.php"); // Funciones para la cuenta
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php"); // Funciones para el tipo de usuario

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
    $nombres = $_POST['nombres'];
    $ap_paterno = $_POST['ap_paterno'];
    $ap_materno = $_POST['ap_materno'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $estado_nacimiento = $_POST['estado_nacimiento'];
    $municipio_nacimiento = $_POST['municipio_nacimiento'];
    $sexo = $_POST['sexo'];
    $telefono = $_POST['telefono'];
    $estado_civil = $_POST['estado_civil'];
    $escolaridad = $_POST['escolaridad'];
    $escuela = $_POST['escuela'];
    $especialidad = $_POST['especialidad'];
    $rfc = $_POST['rfc'];
    $elector = $_POST['elector'];
    $cartilla = $_POST['cartilla'];
    $curp = $_POST['curp'];
    $noolvides_el_matricula = $_POST['noolvides_el_matricula'];

    // Datos de la tabla extras
    $tipo_sangre = $_POST['tipo_sangre'];
    $factor_rh = $_POST['factor_rh'];
    $lentes = $_POST['lentes'];
    $estatura = $_POST['estatura'];
    $peso = $_POST['peso'];
    $complexion = $_POST['complexion'];
    $alergias = $_POST['alergias'];
    $nombre_SOS = $_POST['nombre_SOS'];
    $parentesco_SOS = $_POST['parentesco_SOS'];
    $contactoTel_SOS = $_POST['contactoTel_SOS'];
    $altaimss = $_POST['altaimss'];
    $padecimientos = $_POST['padecimientos'];

    // Manejo de imágenes
    $imagen_frente = $_FILES['imagen_frente'];
    $imagen_izquierda = $_FILES['imagen_izquierda'];
    $imagen_derecha = $_FILES['imagen_derecha'];

    $ID_Cuenta = $_POST['ID_Cuenta'];

    $usuario = $_SESSION["usuario"]; // Recuperar el usuario de la sesión
    $registro = date("Y-m-d H:i:s", time()); // Obtener la fecha y hora actual

    if (!$nombres || !$ap_paterno || !$ap_materno || !$fecha_nacimiento || !$estado_nacimiento || 
        !$municipio_nacimiento || !$sexo || !$telefono || !$estado_civil || !$escolaridad || 
        !$escuela || !$especialidad || !$rfc || !$elector || !$cartilla || 
        !$curp || !$noolvides_el_matricula || !$tipo_sangre || !$factor_rh || !$lentes || 
        !$estatura || !$peso || !$complexion || !$alergias || !$nombre_SOS ||
        !$parentesco_SOS || !$contactoTel_SOS || !$altaimss || !$padecimientos) { // Verificar que los campos no estén vacíos
        echo json_encode([ // Devuelve un arreglo JSON con el mensaje de error
            "success" => false, // Indica que la operación no fue exitosa
            "message" => "Datos inválidos. Por favor, revise la información enviada." // Mostrar el mensaje de error
        ]);
        exit; // Salir del script
    }
    
    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Insertar el nuevo registro
        $ID_Persona = InsertarNuevoPersona($conexion, $nombres, $ap_paterno, $ap_materno, $fecha_nacimiento, $estado_nacimiento, $municipio_nacimiento, $sexo, $telefono, $estado_civil, $escolaridad, $escuela, $especialidad, $rfc, $elector, $cartilla, $curp, $noolvides_el_matricula);

        if (!$ID_Persona) { // Verificar si el ID de la persona fue insertado correctamente
            throw new Exception("Error al insertar la persona");
        }

        // Insertar la información Extra
        if (!InsertarExtraInformacion($conexion, $ID_Persona, $tipo_sangre, $factor_rh, $lentes, $estatura, $peso, $complexion, $alergias, $nombre_SOS, $parentesco_SOS, $contactoTel_SOS, $altaimss, $padecimientos)){
            // Si hay un error al insertar la información extra, se lanza una excepción
            throw new Exception("Error al insertar la información extra");
        }

        // Insertar la imagen a carpeta de la persona
        $Fotos = subirImagenesPersona($ID_Persona, $imagen_izquierda, $imagen_frente, $imagen_derecha);

        if (!$Fotos) {
            // Si hay un error al subir las imágenes, se lanza una excepción
            throw new Exception("Error al subir las imágenes");
        }

        if (!ActualizarFotosPersona($conexion, $Fotos, $ID_Persona)) {
            // Si hay un error al insertar la información de la cuenta, se lanza una exc
            throw new Exception("Error al insertar la información de la cuenta");
        }

        if (InsertarPersonaCuenta($conexion, $ID_Persona, $ID_Cuenta)) {
            $conexion->commit(); // Confirmar la transacción

            $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion); // Buscar y retornar el tipo de usuario

            // Respuesta de éxito con la URL según tipo de usuario
            $urls = [
                1 => "../../../Vista/DEV/Cuenta_Dev.php", // URL para el tipo de usuario 1
                2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php", // URL para el tipo de usuario 2
                3 => "../../../Vista/ADMIN/index_ADMIN.php", // URL para el tipo de usuario 3
                4 => "../../../Vista/USER/index_USER.php", // URL para el tipo de usuario 4
                5 => "../../../Vista/ALMACENISTA/index_ALMACENISTA.php", // URL para el tipo de usuario 5
                6 => "../../../Vista/RH/Personas_RH.php", // URL para el tipo de usuario 6
            ];
            
            echo json_encode([  // Enviar la respuesta en formato JSON
                "success" => true, // Indicar que la operación fue exitosa
                "message" => "Se ha Guardado Correctamente.", // Mostrar un mensaje de éxito
                "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php" // Redireccionar a la página de inicio
            ]);
        } else {
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error en la inserción de la tabla cuenta.");
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
        "message" => "No se proporcionó un ID válido." // Mostrar el mensaje de error
    ]);
}
?>