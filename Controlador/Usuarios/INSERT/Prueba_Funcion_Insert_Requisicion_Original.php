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

// Incluir autoload de Composer para cargar TCPDF
require_once('../../../librerias/PHPMailer/vendor/autoload.php'); 

// Incluir autoload de Composer para cargar TCPDF
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Obtiene la conexión a la base de datos
$conexion = (new Conectar())->conexion();

// Verificar si la conexión a la base de datos fue exitosa
if (!$conexion || $conexion->connect_error) {
    echo json_encode([ // Si la conexión falla, enviar un mensaje de error
        "success" => false, // Indicar si la operación fue exitosa
        "message" => "Error en la conexión: " . $conexion->connect_error // Mostrar el error de conexión
    ]);
    exit; // Salir del script
}

try {
    // Obtiene la fecha y hora de creación de la requisición 
    $FchEnvio = date('Y-m-d H:i:s', time());

    // Obtiene el ID del Borrador_RequisicionE
    $BIDRequisicionE = $_POST['Id'];

    // Procesamiento del formulario cuando se recibe una solicitud POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Llamar a la función para recuperar la información de la requisición E relacionada
        $requisicionesE = SeleccionarRequisicionEPorE($conexion, $BIDRequisicionE);

        // Llamar a la función para recuperar la información de la requisición D relacionada
        $requisicionesD = SeleccionarRequisicionDPorD($conexion, $BIDRequisicionE);

        // Llamar a la función para eliminar la información de las tablas Borrador_RequisicionE y Borrador_RequisicionD 
        EliminarInformacionRequisiones($conexion, $BIDRequisicionE);

        // Inserta en la tabla RequisicionE
        insertarRequisicionE($conexion, $FchEnvio, $requisicionesE);

        // Obtiene el ID de la requisición insertada
        $ID_RequisionE = obtenerUltimoID($conexion);
        
        // Inserta en la tabla RequisicionD
        insertarRequisicionD($conexion, $ID_RequisionE, $requisicionesD);

        // Envía correo electrónico notificando la nueva solicitud
        $resultadoEnvioCorreo = enviarCorreo($FchEnvio, $ID_RequisionE, $conexion);
        
        // Verificar el resultado del envío de correo
        if ($resultadoEnvioCorreo === true) {
            // Notificación de inserción exitosa
            echo '<script type="text/javascript">';
            echo 'alert("¡El registro fue exitoso!");';
            echo 'window.location = "../../../Vista/ADMIN/Solicitud_ADMIN.php";';
            echo '</script>';
        } else {
            // Notificación de inserción incorrecta
            echo '<script type="text/javascript">';
            echo 'alert("Error al enviar el correo: ' . $resultadoEnvioCorreo['message'] . '");';
            echo 'window.location = "../../../Vista/ADMIN/Solicitud_ADMIN.php";';
            echo '</script>';
        }
    }
} catch (Exception $e) {
    // Notificación de inserción incorrecta
    echo '<script type="text/javascript">';
    echo 'alert("¡Ocurrió un error durante el registro! ' . $e->getMessage() . '");';
    echo 'window.location = "../../../Vista/ADMIN/Solicitud_ADMIN.php";';
    echo '</script>';
}

// Función para buscar información en la tabla Borrador_RequisicionE
function SeleccionarRequisicionEPorE($conexion, $BIDRequisicionE) {
    // Prepara la consulta SQL
    $SelectSQLE = $conexion->prepare("SELECT * FROM Borrador_RequisicionE WHERE BIDRequisicionE = ?;");
    
    // Vincula el parámetro BIDRequisicionE a la consulta
    $SelectSQLE->bind_param("i", $BIDRequisicionE);
    
    // Ejecuta la consulta
    $SelectSQLE->execute();
    
    // Obtiene el resultado de la consulta
    $ResultadoSQLE = $SelectSQLE->get_result();
    
    // Recupera la fila como un array asociativo
    $filaSQLE = $ResultadoSQLE->fetch_assoc();
    
    // Cierra la consulta
    $SelectSQLE->close();
    
    // Devuelve la fila completa
    return $filaSQLE;
}

// Función para buscar información en la tabla Borrador_RequisicionD
function SeleccionarRequisicionDPorD($conexion, $BIDRequisicionE) {
    // Prepara la consulta SQL para seleccionar registros de Borrador_RequisicionD usando BIDRequisicionE
    $SelectSQLD = $conexion->prepare("SELECT * FROM Borrador_RequisicionD WHERE BIdReqE = ?;");
    
    // Vincula el parámetro BIDRequisicionE a la consulta
    $SelectSQLD->bind_param("i", $BIDRequisicionE);
    
    // Ejecuta la consulta
    $SelectSQLD->execute();
    
    // Obtiene el resultado de la consulta
    $ResultadoSQLD = $SelectSQLD->get_result();
    
    // Recupera todas las filas como un array asociativo
    $filasSQLD = $ResultadoSQLD->fetch_all(MYSQLI_ASSOC);
    
    // Cierra la consulta
    $SelectSQLD->close();
    
    // Devuelve las filas completas
    return $filasSQLD;
}

// Función para eliminar información de las tablas Borrador_RequisicionE y Borrador_RequisicionD
function EliminarInformacionRequisiones($conexion, $BIDRequisicionE){
    $DeleteSQL2 = "DELETE FROM Borrador_RequisicionD WHERE BIdReqE = ?;";
    $stmtDD = $conexion->prepare($DeleteSQL2);
    
    // Vincula el parámetro BIDRequisicionE a la consulta
    $stmtDD->bind_param("i", $BIDRequisicionE);
    
    // Ejecuta la consulta
    $stmtDD->execute();
    
    // Cierra la consulta
    $stmtDD->close();

    // Preparando la sentencia
    $DeleteSQL1 = "DELETE FROM Borrador_RequisicionE WHERE BIDRequisicionE = ?;";
    $stmtDE = $conexion->prepare($DeleteSQL1);
    
    // Vincula el parámetro BIDRequisicionE a la consulta
    $stmtDE->bind_param("i", $BIDRequisicionE);
    
    // Ejecuta la consulta
    $stmtDE->execute();
    
    // Cierra la consulta
    $stmtDE->close();
}

// Función para insertar en la tabla RequisicionE
function insertarRequisicionE($conexion, $FchEnvio, $requisicionesE) {
    $estatus = 'Pendiente'; // Define el estatus inicial

    // Verifica si el número de columnas y valores coinciden
    $consultaRequisicionE = $conexion->prepare(
        "INSERT INTO RequisicionE (IdUsuario, FchCreacion, Estatus, Supervisor, IdCuenta, IdRegion, CentroTrabajo, NroElementos, Receptor, TelReceptor, RfcReceptor, IdEstado, Mpio, Colonia, Calle, Nro, CP, Justificacion) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Vincula los parámetros, asegurándote de que el número de parámetros coincida con el número de columnas
    $consultaRequisicionE->bind_param(
        "isssiisssssissssss",
        $requisicionesE['BIdUsuario'], $FchEnvio, $estatus, $requisicionesE['BSupervisor'], 
        $requisicionesE['BIdCuenta'], $requisicionesE['BIdRegion'], $requisicionesE['BCentroTrabajo'], 
        $requisicionesE['BNroElementos'], $requisicionesE['BReceptor'], $requisicionesE['BTelReceptor'], 
        $requisicionesE['BRfcReceptor'], $requisicionesE['BIdEstado'], $requisicionesE['BMpio'], 
        $requisicionesE['BColonia'], $requisicionesE['BCalle'], $requisicionesE['BNro'], 
        $requisicionesE['BCP'], $requisicionesE['BJustificacion']);

    $consultaRequisicionE->execute();
}

// Función para obtener el último ID insertado
function obtenerUltimoID($conexion) {
    return $conexion->insert_id;
}

// Función para insertar en la tabla RequisicionD
function insertarRequisicionD($conexion, $ID_RequisionE, $requisicionesD) {
    // Prepara la consulta
    $consultaRequisicionD = $conexion->prepare("INSERT INTO RequisicionD (IdReqE, IdCProd, IdTalla, Cantidad) VALUES (?, ?, ?, ?)");

    // Obtiene la cantidad de filas en los datos de la tabla
    $numFilas = count($requisicionesD);

    // Recorre cada registro en requisicionesD y ejecuta la consulta 
    for ($i = 0; $i < $numFilas; $i++) {
        $idProducto = $requisicionesD[$i]['BIdCProd'];
        $idtalla = $requisicionesD[$i]['BIdTalla'];
        $cantidad = $requisicionesD[$i]['BCantidad'];

        $consultaRequisicionD->bind_param("iiii", $ID_RequisionE, $idProducto, $idtalla, $cantidad);
        $consultaRequisicionD->execute();
    }

    // Cierra la consulta
    $consultaRequisicionD->close();
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
        echo 'Correo enviado exitosamente.';

        return true;
    } catch (Exception $e) {
        return ["success" => false, "message" => $e->getMessage()];
    }
}
?>