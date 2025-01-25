<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México
include('../../../Modelo/Conexion.php'); // Incluir el archivo de conexión
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php"); // Carga la clase de funciones de tipo de usuario
require_once("../../../Modelo/Funciones/Funciones_Usuarios.php"); // Carga la clase de funciones de usuarios

$conexion = (new Conectar())->conexion(); // Conectar a la base de datos

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar el correo electrónico del formulario
    $correo_electronico = $_POST["correo_electronico"];
    $nombre = $_POST["nombre"];
    $apellido_paterno = $_POST["apellido_paterno"];
    $apellido_materno = $_POST["apellido_materno"];
    $num_tel = $_POST["num_tel"];
    $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT);
    $num_contacto_sos = $_POST["num_contacto_sos"];
    $ID_Tipo = $_POST["ID_Tipo"];
    $usuario = $_SESSION["usuario"]; // Recuperar el usuario de la sesión

    if (!$correo_electronico || !$nombre || !$apellido_paterno || !$apellido_materno || 
        !$num_tel || !$contrasena || !$num_contacto_sos || !$ID_Tipo) { // Verificar que los campos no estén vacíos
        echo json_encode([ // Devuelve un arreglo JSON con el mensaje de error
            "success" => false, // Indica que la operación no se realizó con éxito
            "message" => "Datos inválidos. Por favor, revise la información enviada."
        ]);
        exit; // Salir del script
    }

    // Verificar si el correo electrónico ya está registrado
    if (VerificarCorreoExistente($conexion, $correo_electronico)) {
        echo json_encode([ // Devuelve un arreglo JSON con el mensaje de error
            "success" => false, // Indica que la operación no se realizó con éxito
            "message" => "Correo Electronico inválido. Por favor, cambiarlo."
        ]);
        exit; // Salir del script
    }
    
    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Insertar el usuario y obtener su ID
        $id_Usuario = InsertarNuevoUsuario($conexion, $nombre, $apellido_materno, $apellido_paterno, $num_tel, $correo_electronico, $contrasena, $num_contacto_sos, $ID_Tipo);

        if (!$id_Usuario) { // Verificar si se ha insertado correctamente la región
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al insertar en la tabla region.");
        }
        
        // Si el tipo de usuario es 3 o 4, procesar las cuentas
        if ($ID_Tipo == 3 || $ID_Tipo == 4) {
            // Verifica si $_POST['datosTabla'] está definido
            if (isset($_POST['DatosTablaInsertCuentaUsuario'])) {
                // Decodifica los datos del formulario
                $datosTabla = json_decode($_POST['DatosTablaInsertCuentaUsuario'], true);

                // Verifica si la decodificación fue exitosa
                if (json_last_error() === JSON_ERROR_NONE) {
                    // Obtiene la cantidad de filas en los datos de la tabla
                    $numFilas = count($datosTabla);

                    // Itera sobre los datos de la tabla oculta utilizando un bucle for
                    for ($i = 0; $i < $numFilas; $i++) {
                        // Obtiene los datos de cuenta
                        $cuentaId = $datosTabla[$i]['cuentaId']; 

                        // Inserta en la tabla Usuario_Cuenta
                        if (!InsertarNuevoUsuarioCuenta($conexion, $id_Usuario, $cuentaId)) {
                            throw new Exception("Error al insertar en usuario cuenta");
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
        } else {
            // Si el tipo de usuario no es 3 o 4, insertar con ID_Cuenta como NULL
            if (!InsertarNuevoUsuarioCuenta($conexion, $id_Usuario, $cuentaId = NULL)) {
                throw new Exception("Error al insertar en usuario cuenta");
            }
        }

        // Si todo fue bien, hacer commit de la transacción
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
            "message" => "Se ha Guardado Correctamente.",
            "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php" // Redireccionar a la página de inicio
        ]);
    } catch (Exception $e) {
        $conexion->rollback(); // Cancelar la transacción
        echo json_encode([ // Enviar la respuesta en formato JSON
            "success" => false, // Indicar que la operación falló
            "message" => "Error al realizar el registro: " . htmlspecialchars($e->getMessage())
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