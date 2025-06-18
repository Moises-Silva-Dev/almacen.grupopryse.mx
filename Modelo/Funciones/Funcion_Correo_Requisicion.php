<?php
// Iniciar la sesión
session_start();
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/Mexico_City');
require_once('../../../librerias/PHPMailer/vendor/autoload.php'); // Incluir autoload de Composer para cargar PHPMailer

// Incluir autoload de Composer para cargar TCPDF
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Función para enviar correo electrónico
function enviarCorreo($FchEnvio, $ID_RequisionE, $conexion) {
    try {
        // Generar el PDF y obtener el nombre del archivo generado
        $resultadoPDF = generarPDF($conexion, $ID_RequisionE);

        // Verificar si se generó correctamente el PDF
        if (is_array($resultadoPDF) && !$resultadoPDF['success']) {
            throw new Exception("Error al generar el PDF: " . $resultadoPDF['message']);
        }

        // Obtener el nombre del PDF generado
        $nombrePDF = $resultadoPDF;
        
        $rutaPDF = "../../../pdfs/" . $nombrePDF;
        
        // Configurar PHPMailer
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'mail.grupopryse.mx';
        $mail->SMTPAuth = true;
        $mail->Username = 'tecnico.ti@grupopryse.mx';
        $mail->Password = 'vi3ORwd,E-TE'; // Usar variable de entorno para la contraseña
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->CharSet = 'UTF-8';
    
        // Configurar remitente y destinatario
        $mail->setFrom('tecnico.ti@grupopryse.mx', 'Tecnico Pryse');
        $mail->addAddress('karen.lopez.pryse@gmail.com');
        $mail->addAddress('tecnico.pryse@gmail.com');
    
        // Adjuntar archivo si existe
        if (file_exists($rutaPDF)) {
            $mail->addAttachment($rutaPDF);
        } else {
            throw new Exception("El archivo PDF no existe: $rutaPDF");
        }
    
        // Configurar correo
        $mail->isHTML(true);
        $mail->Subject = 'Nueva Requisición';
        $mensaje = '<html lang="es"><head><meta charset="UTF-8">';
        $mensaje .= '<style>body { font-family: Arial, sans-serif; }</style></head><body>';
        $mensaje .= '<h1>Grupo Pryse Seguridad Privada S.A. de C.V.</h1>';
        $mensaje .= '<p>Hola,</p>';
        $mensaje .= '<p>Se ha hecho una nueva requisición a las: ' . htmlspecialchars($FchEnvio) . '</p>';
        $mensaje .= '<p>Número de la Requisición: ' . htmlspecialchars($ID_RequisionE) . '</p>';
        $mensaje .= '<p>Puedes descargar el PDF <a href="https://almacen.grupopryse.mx/pdfs/' . htmlspecialchars(basename($nombrePDF)) . '">aquí</a>.</p>';
        $mensaje .= '</body></html>';
        $mail->Body = $mensaje;
        $mail->AltBody = 'Número de la Requisición: ' . $ID_RequisionE . '. Puedes descargar el PDF aquí: https://almacen.grupopryse.mx/pdfs/' . basename($nombrePDF);
    
        // Enviar el correo
        $mail->send();

        return true; // Correo enviado con éxito
    } catch (Exception $e) {
        return ["success" => false, "message" => $e->getMessage()];
    }
}
?>