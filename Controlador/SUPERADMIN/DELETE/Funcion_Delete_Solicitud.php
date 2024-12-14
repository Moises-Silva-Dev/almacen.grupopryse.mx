<?php
// Inicia la sesión PHP
session_start();

// Configura la localización a español
setlocale(LC_ALL, 'es_ES');

// Configura la zona horaria a Ciudad de México
date_default_timezone_set('America/Mexico_City');

// Incluye el archivo de conexión a la base de datos
include('../../../Modelo/Conexion.php');
    
try{
    
    // Verifica si se proporciona un ID a través de GET
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
        
        // Obtiene la conexión a la base de datos
        $conexion = (new Conectar())->conexion();
    
        // Obtiene la fecha y hora de creación de la requisición 
        $FchEnvio = date('Y-m-d H:i:s', time());
        
        // Obtiene el ID del RequisicionE
        $idSolicitud = $_GET['id'];
        
        // Llamar a la función para recuperar la información de la requisición E relacionada
        $requisicionesE = SeleccionarRequisicionEPorE($conexion, $idSolicitud);

        // Llamar a la función para recuperar la información de la requisición D relacionada
        $requisicionesD = SeleccionarRequisicionDPorD($conexion, $idSolicitud);
        
        // Llamar a la función para eliminar la información de las tablas RequisicionE y RequisicionD 
        EliminarInformacionRequisiones($conexion, $idSolicitud);
        
        // Inserta en la tabla RequisicionE
        insertarBorradorRequisicionE($conexion, $FchEnvio, $requisicionesE);
        
        // Obtiene el ID de la requisición insertada
        $ID_RequisionE = obtenerUltimoID($conexion);
        
        // Inserta en la tabla RequisicionE
        if (insertarBorradorRequisicionD($conexion, $ID_RequisionE, $requisicionesD)) {
            // Notificación de inserción exitosa
            echo '<script type="text/javascript">';
            echo 'alert("¡La Solicitud Modificada fue Enviada Exitosamente!");';
            echo 'window.location = "../../../Vista/SUPERADMIN/Solicitud_SUPERADMIN.php";';
            echo '</script>';
        } else {
            // Notificación de inserción incorrecta
            echo '<script type="text/javascript">';
            echo 'alert("ERROR, No se puede solicitar modificacion:");';
            echo 'window.location = "../../../Vista/SUPERADMIN/Solicitud_SUPERADMIN.php";';
            echo '</script>';
        }
    } else {
    // Si no se proporciona el ID, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: No se proporcionó un ID válido.");';
    echo 'window.location = "../../../Vista/SUPERADMIN/Solicitud_SUPERADMIN.php";'; // Reemplaza con la ruta de redirección de error deseada
    echo '</script>';
    exit();
    }
        
} catch (Exception $e) {
    // Notificación de inserción incorrecta
    echo '<script type="text/javascript">';
    echo 'alert("¡Ocurrió un error durante la solicitud! ' . $e->getMessage() . '");';
    echo 'window.location = "../../../Vista/SUPERADMIN/Solicitud_SUPERADMIN.php";';
    echo '</script>';
}

// Función para buscar información en la tabla RequisicionE
function SeleccionarRequisicionEPorE($conexion, $idSolicitud) {
    // Prepara la consulta SQL
    $SelectSQLE = $conexion->prepare("SELECT * FROM RequisicionE WHERE IDRequisicionE = ?;");
    
    // Vincula el parámetro BIDRequisicionE a la consulta
    $SelectSQLE->bind_param("i", $idSolicitud);
    
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

// Función para buscar información en la tabla RequisicionD
function SeleccionarRequisicionDPorD($conexion, $idSolicitud) {
    // Prepara la consulta SQL para seleccionar registros de Borrador_RequisicionD usando BIDRequisicionE
    $SelectSQLD = $conexion->prepare("SELECT * FROM RequisicionD WHERE IdReqE = ?;");
    
    // Vincula el parámetro BIDRequisicionE a la consulta
    $SelectSQLD->bind_param("i", $idSolicitud);
    
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

// Función para eliminar información de las tablas RequisicionE y RequisicionD
function EliminarInformacionRequisiones($conexion, $BIDRequisicionE){
    // Preparando la sentencia
    $DeleteSQL2 = "DELETE FROM RequisicionD WHERE IdReqE = ?;";
    $stmtDD = $conexion->prepare($DeleteSQL2);
    
    // Vincula el parámetro IDRequisicionE a la consulta
    $stmtDD->bind_param("i", $BIDRequisicionE);
    
    // Ejecuta la consulta
    $stmtDD->execute();
    
    // Cierra la consulta
    $stmtDD->close();

    // Preparando la sentencia
    $DeleteSQL1 = "DELETE FROM RequisicionE WHERE IDRequisicionE = ?;";
    $stmtDE = $conexion->prepare($DeleteSQL1);

    // Vincula el parámetro IDRequisicionE a la consulta
    $stmtDE->bind_param("i", $BIDRequisicionE);
    
    // Ejecuta la consulta
    $stmtDE->execute();
    
    // Cierra la consulta
    $stmtDE->close();
}

// Función para insertar en la tabla Borrador_RequisicionE
function insertarBorradorRequisicionE($conexion, $FchEnvio, $requisicionesE) {
    $estatus = 'Modificacion_Solicitada'; // Define el estatus inicial

    // Verifica si el número de columnas y valores coinciden
    $consultaRequisicionE = $conexion->prepare(
        "INSERT INTO Borrador_RequisicionE (BIdUsuario, BFchCreacion, BEstatus, BSupervisor, BIdCuenta, BIdRegion, BCentroTrabajo, BNroElementos, BReceptor, BTelReceptor, BRfcReceptor, BIdEstado, BMpio, BColonia, BCalle, BNro, BCP, BJustificacion) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Vincula los parámetros, asegurándote de que el número de parámetros coincida con el número de columnas
    $consultaRequisicionE->bind_param(
        "isssiisssssissssss",
        $requisicionesE['IdUsuario'], $FchEnvio, $estatus, $requisicionesE['Supervisor'], 
        $requisicionesE['IdCuenta'], $requisicionesE['IdRegion'], $requisicionesE['CentroTrabajo'], 
        $requisicionesE['NroElementos'], $requisicionesE['Receptor'], $requisicionesE['TelReceptor'], 
        $requisicionesE['RfcReceptor'], $requisicionesE['IdEstado'], $requisicionesE['Mpio'],
        $requisicionesE['Colonia'], $requisicionesE['Calle'], $requisicionesE['Nro'],
        $requisicionesE['CP'], $requisicionesE['Justificacion']);
        
    $consultaRequisicionE->execute();
}

// Función para obtener el último ID insertado
function obtenerUltimoID($conexion) {
    return $conexion->insert_id;
}

// Función para insertar en la tabla RequisicionD
function insertarBorradorRequisicionD($conexion, $ID_RequisionE, $requisicionesD) {
    // Prepara la consulta
    $consultaRequisicionD = $conexion->prepare("INSERT INTO Borrador_RequisicionD (BIdReqE, BIdCProd, BIdTalla, BCantidad) VALUES (?, ?, ?, ?)");

    // Obtiene la cantidad de filas en los datos de la tabla
    $numFilas = count($requisicionesD);

    // Inicializa una variable para rastrear el éxito de la inserción
    $exito = true;
    
    // Recorre cada registro en requisicionesD y ejecuta la consulta 
    for ($i = 0; $i < $numFilas; $i++) {
        $idProducto = $requisicionesD[$i]['IdCProd'];
        $idtalla = $requisicionesD[$i]['IdTalla'];
        $cantidad = $requisicionesD[$i]['Cantidad'];

        $consultaRequisicionD->bind_param("iiii", $ID_RequisionE, $idProducto, $idtalla, $cantidad);
        
        // Si alguna inserción falla, cambia la variable de éxito a false
        if (!$consultaRequisicionD->execute()) {
            $exito = false;
            break;
        }
    }

    // Cierra la consulta
    $consultaRequisicionD->close();

    // Retorna true si todas las inserciones fueron exitosas, de lo contrario false
    return $exito;
}
?>