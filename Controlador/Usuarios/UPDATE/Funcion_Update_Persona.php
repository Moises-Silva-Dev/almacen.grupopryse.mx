<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México

// Incluir dependencias necesarias
include('../../../Modelo/Conexion.php'); // Incluir el archivo de conexión
require_once("../../../Modelo/Funciones/Funciones_Persona.php"); // Carga la clase de funciones de la cuenta
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
    $ID_Persona = $_POST['ID_Persona']; // Asegúrate de que este campo esté en el formulario
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
    $opcion = $_POST['opcion'];
    $imagen_frente = $_FILES['imagen_frente'];
    $imagen_izquierda = $_FILES['imagen_izquierda'];
    $imagen_derecha = $_FILES['imagen_derecha'];

    $ID_Cuenta = $_POST['ID_Cuenta'];

    $usuario = $_SESSION["usuario"]; // Recuperar el usuario de la sesión
    $registro = date("Y-m-d H:i:s", time()); // Obtener la fecha y hora actual

    // Validar que los campos no estén vacíos
    if (!$nombres || !$ap_paterno || !$ap_materno || !$fecha_nacimiento || 
        !$estado_nacimiento || !$municipio_nacimiento || !$sexo || !$telefono || 
        !$estado_civil || !$escolaridad || !$escuela || !$especialidad || 
        !$rfc || !$elector || !$cartilla || !$curp || !$noolvides_el_matricula || 
        !$tipo_sangre || !$factor_rh || !$lentes || !$estatura || !$peso || 
        !$complexion || !$alergias || !$nombre_SOS || !$parentesco_SOS || 
        !$contactoTel_SOS || !$altaimss || !$padecimientos || !$ID_Cuenta || 
        !$opcion) {
        echo json_encode([ // Devuelve un arreglo JSON con el mensaje de error
            "success" => false, // Indica que la operación no fue exitosa
            "message" => "Datos inválidos. Por favor, revise la información enviada." // Mostrar el mensaje de error
        ]);
        exit; // Salir del script
    }
    
    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Actualizar datos en la tabla Persona_IMG
        if (!ActualizarPersona($conexion, $nombres, $ap_paterno, $ap_materno, $fecha_nacimiento, $estado_nacimiento, $municipio_nacimiento, $sexo, $telefono, $estado_civil, $escolaridad, $escuela, $especialidad, $rfc, $elector, $cartilla, $curp, $noolvides_el_matricula, $ID_Persona)) {
            throw new Exception("Error al actualizar datos en la tabla Persona_IMG");
        }

        // Actualizar datos en la tabla Extras
        if (!ActualizarExtraInformacion($conexion, $tipo_sangre, $factor_rh, $lentes, $estatura, $peso, $complexion, $alergias, $nombre_SOS, $parentesco_SOS, $contactoTel_SOS, $altaimss, $padecimientos, $ID_Persona)) {
            throw new Exception("Error al actualizar datos en la tabla Extras");
        }

        // Si se seleccionó la opción de subir imágenes
        if ($opcion == "SI") {
            // Eliminar antiguas imágenes
            if (!DeleteIMGProducto($conexion, $ID_Persona)) {
                throw new Exception("Error al eliminar imágenes");
            }

            // Subir nuevas imágenes
            $Fotos = subirImagenesPersona($ID_Persona, $imagen_izquierda, $imagen_frente, $imagen_derecha);
            if (!$Fotos) {
                throw new Exception("Error al subir imágenes");
            }

            // Actualizar las rutas de las imágenes en la base de datos
            if (!ActualizarFotosPersona($conexion, $Fotos, $ID_Persona)) {
                throw new Exception("Error al actualizar las imágenes en la base de datos");
            }
        }

        // Actualizar la relación Persona_Cuenta
        if (!UpdatePersonaCuenta($conexion, $ID_Cuenta, $ID_Persona)) {
            throw new Exception("Error al actualizar la relación Persona_Cuenta");
        }

        // Confirmar la transacción
        $conexion->commit();

        // Redireccionar según el tipo de usuario
        $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion);
        $urls = [
            1 => "../../../Vista/DEV/Cuenta_Dev.php",
            2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php",
            3 => "../../../Vista/ADMIN/index_ADMIN.php",
            4 => "../../../Vista/USER/index_USER.php",
            5 => "../../../Vista/ALMACENISTA/index_ALMACENISTA.php",
            6 => "../../../Vista/RH/Personas_RH.php",
        ];

        echo json_encode([
            "success" => true,
            "message" => "Se ha guardado correctamente.",
            "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php"
        ]);
    } catch (Exception $e) {
        $conexion->rollback(); // Cancelar la transacción
        echo json_encode([
            "success" => false,
            "message" => "No se pudo realizar el registro: " . $e->getMessage()
        ]);
    } finally {
        $conexion->close(); // Cerrar la conexión
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "No se proporcionó un ID válido."
    ]);
}
?>