<?php
// Configuración inicial
header('Content-Type: application/json');
ob_start();
session_start();
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/Mexico_City');

// Inclusión de archivos
include('../../../Modelo/Conexion.php');
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php");
require_once '../../Reportes/Generar_Reporte_Solicitud_a_Gmail.php';
require_once('../../../librerias/PHPMailer/vendor/autoload.php'); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Validación de solicitud
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "message" => "Método de solicitud no permitido."
    ]);
    exit;
}

$conexion = (new Conectar())->conexion();
$conexion->begin_transaction();

try {
    // Validación de datos de entrada
    $BIDRequisicionE = $_POST['Id'] ?? null;
    if (!$BIDRequisicionE) {
        throw new Exception("Datos inválidos. Por favor, revise la información enviada.");
    }

    $usuario = $_SESSION["usuario"];
    $FchEnvio = date('Y-m-d H:i:s', time());

    // Procesar datos de la requisición
    $requisicionesE = SeleccionarRequisicionEPorE($conexion, $BIDRequisicionE);
    $requisicionesD = SeleccionarRequisicionDPorD($conexion, $BIDRequisicionE);

    if (!$requisicionesE || !$requisicionesD) {
        throw new Exception("No se encontró información de la requisición.");
    }

    EliminarInformacionRequisiones($conexion, $BIDRequisicionE);
    insertarRequisicionE($conexion, $FchEnvio, $requisicionesE);
    $ID_RequisionE = obtenerUltimoID($conexion);
    insertarRequisicionD($conexion, $ID_RequisionE, $requisicionesD);

    // Enviar correo electrónico
    // enviarCorreo($FchEnvio, $ID_RequisionE, $conexion);

    $conexion->commit();

    // Redirección por tipo de usuario
    $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion);
    $urls = [
        1 => "../../../Vista/DEV/index_DEV.php",
        2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php",
        3 => "../../../Vista/ADMIN/Solicitud_ADMIN.php",
        4 => "../../../Vista/USER/Solicitud_USER.php",
        5 => "../../../Vista/ALMACENISTA/index_ALMACENISTA.php"
    ];

    echo json_encode([
        "success" => true,
        "message" => "Se ha guardado correctamente.",
        "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php"
    ]);
} catch (Exception $e) {
    $conexion->rollback();
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
} finally {
    $conexion->close();
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