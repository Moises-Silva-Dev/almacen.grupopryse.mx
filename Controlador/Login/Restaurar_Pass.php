<?php
// Habilitar la visualización de errores de PHP
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar la sesión
session_start();
// iniciar Lenguaje al Español
setlocale(LC_ALL, 'es_ES');
// iniciar hora y fecha de mexico
date_default_timezone_set('America/Mexico_City');

// Importar clases necesarias de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Incluir el archivo de conexión a la base de datos
include('../../Modelo/Conexion.php');

// Incluir las clases necesarias de PHPMailer
require '../../librerias/PHPMailer/src/Exception.php';
require '../../librerias/PHPMailer/src/PHPMailer.php';
require '../../librerias/PHPMailer/src/SMTP.php';

// Obtener la instancia de conexión a la base de datos
$conexion = (new Conectar())->conexion();

// Verificar si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verificar si el campo de correo electrónico está definido
    if (isset($_POST['Correo_Electronico'])) {
        // Obtener el correo electrónico proporcionado en el formulario
        $Correo_Electronico = $_POST['Correo_Electronico'];

        // Buscar el usuario en la tabla y contraseña
        $Resultado = BuscarUsuario($conexion, $Correo_Electronico);

        // Verificar si se encontró un usuario con el correo electrónico proporcionado
        if ($Resultado != NULL) {
            // Recuperar la contraseña y enviar por correo electrónico
            recuperarContrasena($Correo_Electronico, $conexion, $Resultado);
        } else {
            // Si no se encontró un usuario con el correo electrónico proporcionado, mostrar un mensaje de error en JavaScript
            echo '<script type="text/javascript">';
            echo 'alert("ERROR, No existe Ningun Usuario con ese Correo");';
            echo 'window.location = "../../index.php";';
            echo '</script>';
        }
    } else {
        // Si el campo de correo electrónico no está definido, mostrar un mensaje de error en JavaScript
        echo '<script type="text/javascript">';
        echo 'alert("Por favor, proporcione un correo electrónico.");';
        echo 'window.location = "../../index.php";';
        echo '</script>';
    }
}

// Cerrar la conexión a la base de datos
$conexion->close();

// Función para generar una contraseña aleatoria combinando "Pryse" con 5 números aleatorios
function generarContrasenaAleatoria() {
    // Cadena base
    $cadenaBase = "PRY$3_";

    // Generar 5 números aleatorios
    $numerosAleatorios = "";
    for ($i = 0; $i < 5; $i++) {
        // Genera un número aleatorio entre 0 y 9
        $numerosAleatorios .= mt_rand(0, 9);
    }

    // Combinar la cadena base con los números aleatorios
    $contrasenaAleatoria = $cadenaBase . $numerosAleatorios;

    // Retorna la contraseña creada
    return $contrasenaAleatoria;
}

// Función para buscar el usuario en las tablas y recuperar la contraseña
function BuscarUsuario($conexion, $Correo_Electronico) {

    // Consultar la base de datos para obtener la contraseña asociada al correo electrónico
    $sql = "SELECT Constrasena FROM Usuario WHERE Correo_Electronico = ?";
    $stmt = $conexion->prepare($sql);
    
    // Asocia el parámetro de la consulta con el correo electrónico proporcionado
    $stmt->bind_param("s", $Correo_Electronico);
    
    // Ejecuta la consulta
    $stmt->execute();
    
    // Obtiene el resultado de la consulta
    $result = $stmt->get_result();

    // Si se encuentra un resultado, retorna el nombre de la tabla y la contraseña
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
            return ["Contrasena" => $row['Constrasena']];
    }

    // Si no se encuentra ningún usuario, retorna null
    return null;
}

// Función para actualizar la contraseña del usuario en la base de datos y enviarla por correo electrónico
function recuperarContrasena($correoElectronico, $conexion, $Resultado) {
    try {
        // Iniciar una transacción
        $conexion->begin_transaction();

        // Generar una nueva contraseña aleatoria
        $nuevaContrasena1 = generarContrasenaAleatoria();

        // Encriptar la contraseña para la base de datos
        $nuevaContrasena = password_hash($nuevaContrasena1, PASSWORD_DEFAULT);

        // Actualizar la contraseña del usuario
        $sqlUpdate = "UPDATE Usuario SET Constrasena = ? WHERE Correo_Electronico = ?";
        $stmt = $conexion->prepare($sqlUpdate);
        $stmt->bind_param("ss", $nuevaContrasena, $correoElectronico);
        $stmt->execute();

        // Verificar si se actualizó correctamente
        if ($stmt->affected_rows > 0) {
            // Enviar la nueva contraseña por correo electrónico (la contraseña no encriptada)
            enviarCorreo($correoElectronico, $nuevaContrasena1);

            // Confirmar la transacción
            $conexion->commit();

            // Mostrar un mensaje de éxito en JavaScript
            echo '<script type="text/javascript">';
            echo 'alert("Se ha enviado la contraseña a tu correo electrónico.");';
            echo 'window.location = "../../index.php";';
            echo '</script>';
        } else {
            throw new Exception("No se pudo actualizar la contraseña del usuario.");
        }
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();
        echo '<script>alert("Error durante la recuperación de contraseña: ' . $e->getMessage() . '");</script>';
    }
}

// Función para enviar correo electrónico con la nueva contraseña
function enviarCorreo($correoElectronico, $nuevaContrasena1) {
    // Crear una nueva instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configurar la conexión SMTP para enviar el correo
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        // Dirección de correo electrónico de Gmail
        $mail->Username = 'SGMO201792@upemor.edu.mx';
        // Contraseña de Gmail o App Password
        $mail->Password = 'SIGM071001'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configurar el remitente y el destinatario del correo
        $mail->setFrom('SGMO201792@upemor.edu.mx', 'Moises Silva Gonzalez'); // Dirección de correo electrónico de Gmail y nombre del remitente
        // Correo del quien recibe el correo
        $mail->addAddress($correoElectronico);

        // Configurar el asunto del correo
        $mail->Subject = utf8_decode('Recuperación de Contraseña ');

        // Construir el cuerpo del correo con HTML
        $mensaje = '<html lang="es">';
        $mensaje .= '<head><meta charset="UTF-8">';
        $mensaje .= '<style>';
        $mensaje .= 'body { font-family: Arial, sans-serif; }';
        $mensaje .= 'h1 { color: #3498db; }';
        $mensaje .= 'p { font-size: 14px; color: #333; }';
        $mensaje .= 'picture { display: block; margin: 20px 0; }';
        $mensaje .= '</style>';
        $mensaje .= '</head>';
        $mensaje .= '<body>';
        $mensaje .= '<h1>Empresa Pryse</h1>';
        $mensaje .= '<p>Hola,</p>';
        $mensaje .= '<p>Hemos recibido una solicitud para restablecer tu contraseña. Tu nueva contraseña es:</p>';
        $mensaje .= '<p style="font-size: 16px; font-weight: bold;">' . $nuevaContrasena1 . '</p>';
        $mensaje .= '<p>Si no solicitaste un restablecimiento de contraseña, por favor contacta a nuestro soporte técnico.</p>';
        $mensaje .= '<p>Saludos,</p>';
        $mensaje .= '<p>El equipo de soporte de Pryse</p>';
        $mensaje .= '<picture>';
        $mensaje .= '  <source srcset="https://media3.giphy.com/media/48FhEMYGWji8/giphy.webp" type="image/webp">';
        $mensaje .= '  <source srcset="https://media3.giphy.com/media/48FhEMYGWji8/giphy.gif" type="image/gif">';
        $mensaje .= '  <img src="https://media3.giphy.com/media/48FhEMYGWji8/giphy.gif" alt="Logo de la empresa" style="width: 100%; max-width: 400px;">';
        $mensaje .= '</picture>';
        $mensaje .= '</body></html>';

        // Establecer el cuerpo del correo
        $mail->Body = $mensaje;
        $mail->AltBody = 'Hemos recibido una solicitud para restablecer tu contraseña. Tu nueva contraseña es: ' . $nuevaContrasena1 . ' Si no solicitaste un restablecimiento de contraseña, por favor contacta a nuestro soporte técnico.';

        // Enviar el correo
        $mail->send();
        
        return true;
    } catch (Exception $e) {
        // En caso de error al enviar el correo, mostrar un mensaje de error en JavaScript
        echo '<script>alert("Error al enviar el correo: ' . $mail->ErrorInfo . '");</script>';
        return false;
    }
}
?>