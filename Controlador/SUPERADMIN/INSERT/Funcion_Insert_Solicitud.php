<?php
// Inicia la sesión PHP
session_start();

// Configura la localización a español
setlocale(LC_ALL, 'es_ES');

// Configura la zona horaria a Ciudad de México
date_default_timezone_set('America/Mexico_City');

// Incluye el archivo de conexión a la base de datos
include('../../../Modelo/Conexion.php');

// Incluir el archivo donde está definida la función generarPDF()
require_once '../../Reportes/Generar_Reporte_Solicitud_a_Gmail.php';

// Incluye las clases necesarias de PHPMailer
require '../../../librerias/PHPMailer/src/Exception.php';
require '../../../librerias/PHPMailer/src/PHPMailer.php';
require '../../../librerias/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Obtiene la conexión a la base de datos
$conexion = (new Conectar())->conexion();

try {
    // Obtiene la fecha y hora de creación de la requisición 
    $FchCreacion = date('Y-m-d H:i:s', time());

    // Obtiene el ID del usuario actual
    $usuario = $_SESSION['usuario'];
    $ID_Usuario = obtenerIDUsuario($conexion, $usuario);

    // Procesamiento del formulario cuando se recibe una solicitud POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Captura los datos del formulario
        $Supervisor = $_POST['Supervisor'];
        $ID_Cuenta = $_POST['ID_Cuenta'];
        $Region = $_POST['Region'];
        $CentroTrabajo = $_POST['CentroTrabajo'];
        $Estado = $_POST['Estado'];
        $Receptor = $_POST['Receptor'];
        $TelReceptor = $_POST['num_tel']; // Se cambió el nombre del campo para coincidir con el formulario
        $RfcReceptor = $_POST['RFC'];
        $Opcion = $_POST['Opcion'];
        $Justificacion = $_POST['Justificacion'];

        // Inserta en la tabla RequisicionE
        insertarRequisicionE($conexion, $ID_Usuario, $FchCreacion, $Supervisor, $ID_Cuenta, $Region, $CentroTrabajo, $Estado, $Receptor, $TelReceptor, $RfcReceptor, $Justificacion);

        // Obtiene el ID de la requisición insertada
        $ID_RequisionE = obtenerUltimoID($conexion);

        // Si se seleccionó "Enviar a domicilio"
        if ($Opcion == 'SI') {
            // Captura los datos de envío
            $Mpio = $_POST['Mpio'];
            $Colonia = $_POST['Colonia'];
            $Calle = $_POST['Calle'];
            $Nro = $_POST['Nro'];
            $CP = $_POST['CP'];

            // Actualiza la requisición con los datos de envío
            actualizarRequisicionE($conexion, $Mpio, $Colonia, $Calle, $Nro, $CP, $ID_RequisionE);
        }

        // Verifica si $_POST['datosTabla'] está definido
        if (isset($_POST['datosTabla'])) {
            // Decodifica los datos del formulario
            $datosTabla = json_decode($_POST['datosTabla'], true);

            // Verifica si la decodificación fue exitosa
            if (json_last_error() === JSON_ERROR_NONE) {
                // Obtiene la cantidad de filas en los datos de la tabla
                $numFilas = count($datosTabla);

                // Itera sobre los datos de la tabla oculta utilizando un bucle for
                for ($i = 0; $i < $numFilas; $i++) {
                    $idProducto = $datosTabla[$i]['idProduct'];
                    $idtall = $datosTabla[$i]['idtall'];
                    $cant = $datosTabla[$i]['cant'];

                    // Inserta en la tabla RequisicionD
                    insertarRequisicionD($conexion, $ID_RequisionE, $idProducto, $idtall, $cant);
                }
            } else {
                // Maneja el caso en el que $_POST['datosTabla'] no es un JSON válido
                echo "Los datos de la tabla no están en el formato JSON esperado.";
            }
        } else {
            // Maneja el caso en el que $_POST['datosTabla'] no está definido
            echo "No se recibieron datos de la tabla.";
        }
        
        // Envía correo electrónico notificando la nueva solicitud
        $resultadoEnvioCorreo = enviarCorreo($FchCreacion, $ID_RequisionE, $conexion);
        
        // Verificar el resultado del envío de correo
        if ($resultadoEnvioCorreo === true) {
            // Notificación de inserción exitosa
            echo '<script type="text/javascript">';
            echo 'alert("¡El registro fue exitoso!");';
            echo 'window.location = "../../../Vista/SUPERADMIN/Solicitud_SUPERADMIN.php";';
            echo '</script>';
        } else {
             // Notificación de inserción incorrecta
            echo '<script type="text/javascript">';
            echo 'alert("Error al enviar el correo: ' . $resultadoEnvioCorreo['message'] . '");';
            echo 'window.location = "../../../Vista/SUPERADMIN/Solicitud_SUPERADMIN.php";';
            echo '</script>';
        }
    }
} catch (Exception $e) {
    // Notificación de inserción incorrecta
    echo '<script type="text/javascript">';
    echo 'alert("¡Ocurrió un error durante el registro! ' . $e->getMessage() . '");';
    echo 'window.location = "../../../Vista/SUPERADMIN/Solicitud_SUPERADMIN.php";';
    echo '</script>';
}

// Función para obtener el ID de usuario
function obtenerIDUsuario($conexion, $usuario) {
    $consulta = $conexion->prepare("SELECT ID_Usuario FROM Usuario WHERE Correo_Electronico = ?");
    $consulta->bind_param("s", $usuario);
    $consulta->execute();
    $resultado = $consulta->get_result();
    $fila = $resultado->fetch_assoc();
    return $fila['ID_Usuario'];
}

// Función para insertar en la tabla RequisicionE
function insertarRequisicionE($conexion, $ID_Usuario, $FchCreacion, $Supervisor, $ID_Cuenta, $Region, $CentroTrabajo, $Estado, $Receptor, $TelReceptor, $RfcReceptor, $Justificacion) {
    $estatus = 'Pendiente'; // Define el estatus inicial
    $consultaRequisicionE = $conexion->prepare("INSERT INTO RequisicionE (IdUsuario, FchCreacion, Estatus, Supervisor, IdCuenta, IdRegion, CentroTrabajo, IdEstado, Receptor, TelReceptor, RfcReceptor, Justificacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $consultaRequisicionE->bind_param("isssiisissss", $ID_Usuario, $FchCreacion, $estatus, $Supervisor, $ID_Cuenta, $Region, $CentroTrabajo, $Estado, $Receptor, $TelReceptor, $RfcReceptor, $Justificacion);
    $consultaRequisicionE->execute();
}

// Función para obtener el último ID insertado
function obtenerUltimoID($conexion) {
    return $conexion->insert_id;
}

// Función para actualizar la tabla RequisicionE con datos de envío
function actualizarRequisicionE($conexion, $Mpio, $Colonia, $Calle, $Nro, $CP, $ID_RequisionE) {
    $actualizarRequisicionE = $conexion->prepare("UPDATE RequisicionE SET Mpio=?, Colonia=?, Calle=?, Nro=?, CP=? WHERE IDRequisicionE=?");
    $actualizarRequisicionE->bind_param("sssssi", $Mpio, $Colonia, $Calle, $Nro, $CP, $ID_RequisionE);
    $actualizarRequisicionE->execute();
}

// Función para insertar en la tabla RequisicionD
function insertarRequisicionD($conexion, $ID_RequisionE, $idProducto, $idtall, $cant) {
    // Convierte $ID_RequisionE y $idProducto a enteros
    $ID_RequisionE = (int)$ID_RequisionE;
    $idProducto = (int)$idProducto;
    // Prepara la consulta
    $consultaRequisicionD = $conexion->prepare("INSERT INTO RequisicionD (IdReqE, IdCProd, IdTalla, Cantidad) VALUES (?, ?, ?, ?)");
    // Vincula los parámetros y ejecuta la consulta
    $consultaRequisicionD->bind_param("iiii", $ID_RequisionE, $idProducto, $idtall, $cant);
    $consultaRequisicionD->execute();
}

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
        
        // Configurar PHPMailer para enviar correo
        $mail = new PHPMailer(true);
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
        $mail->setFrom('SGMO201792@upemor.edu.mx', 'Moises Silva Gonzalez');
        $mail->addAddress('mochito619@gmail.com');
        $mail->addAttachment($rutaPDF); // Adjuntar el archivo PDF generado
        $mail->isHTML(true);

        // Configurar el asunto del correo
        $mail->Subject = utf8_encode('Nueva Requisición');

        // Configurar el asunto del correo
        $mail->Subject = 'Nueva Requisición';
        
        // Construir el cuerpo del correo con HTML
        $mensaje = '<html lang="es">';
        $mensaje .= '<head><meta charset="UTF-8">';
        $mensaje .= '<style>';
        $mensaje .= 'body { font-family: Arial, sans-serif; }';
        $mensaje .= 'h1 { color: #3498db; }';
        $mensaje .= 'p { font-size: 14px; color: #333; }';
        $mensaje .= '.logo { display: block; margin: 20px auto; width: 150px; }';
        $mensaje .= 'a { color: #3498db; text-decoration: none; }';
        $mensaje .= 'a:hover { text-decoration: underline; }';
        $mensaje .= '</style>';
        $mensaje .= '</head>';
        $mensaje .= '<body>';
        $mensaje .= '<h1>Grupo Pryse Seguridad Privada S.A. de C.V.</h1>';
        $mensaje .= '<p>Hola,</p>';
        $mensaje .= '<p>Se ha hecho una nueva requisición a las: ' . $FchEnvio . '</p>';
        $mensaje .= '<p>Número de la Requisición: ' . $ID_RequisionE . '</p>';
        $mensaje .= '<p>Puedes descargar el PDF <a href="https://grupopryse.mx/pdfs/' . basename($nombrePDF) . '">aquí</a>.</p>';
        $mensaje .= '<img src="https://i.gifer.com/GzPz.gif" alt="Logo de la empresa" class="logo">';
        $mensaje .= '</body></html>';
        
        // Establecer el cuerpo del correo
        $mail->Body = $mensaje;
        $mail->AltBody = 'Número de la Requisición: ' . $ID_RequisionE . '. Puedes descargar el PDF aquí: https://grupopryse.mx/pdfs/' . basename($nombrePDF);
        
        // Enviar el correo
        $mail->send();

        return true;
    } catch (Exception $e) {
        return ["success" => false, "message" => $e->getMessage()];
    }
}
?>