<?php
// Iniciamos sesión
session_start();
// Configura la localización a español
setlocale(LC_ALL, 'es_ES');
// Configura la zona horaria a Ciudad de México
date_default_timezone_set('America/Mexico_City');

// Incluye el archivo de conexión a la base de datos
include('../../../Modelo/Conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Obtiene la conexión a la base de datos
        $conexion = (new Conectar())->conexion();

        // Obtener datos del formulario
        $ID_RequisicionE = $_POST['ID_RequisicionE'];
        $Supervisor = $_POST['Supervisor'];
        $ID_Cuenta = $_POST['ID_Cuenta'];
        $Region = $_POST['Region'];
        $CentroTrabajo = $_POST['CentroTrabajo'];
        $Estado = $_POST['Estado'];
        $Receptor = $_POST['Receptor'];
        $TelReceptor = $_POST['TelReceptor'];
        $RfcReceptor = $_POST['RfcReceptor'];
        $Justificacion = $_POST['Justificacion'];
        $Mpio = $_POST['Mpio'];
        $Colonia = $_POST['Colonia']; 
        $Calle = $_POST['Calle']; 
        $Nro = $_POST['Nro']; 
        $CP = $_POST['CP'];

        // Establecer la fecha y hora actual
        $FchCreacion = date('Y-m-d H:i:s'); // Fecha y hora actual
        $Estatus = 'Modificado'; // Nuevo estatus

        // Comenzar la transacción
        $conexion->begin_transaction();

        // Actualizar la requisición en la tabla RequisicionE
        actualizarRequisicionECompleto($conexion, $FchCreacion, $Estatus, $Supervisor, $ID_Cuenta, $Region, $CentroTrabajo, $Estado, $Receptor, $TelReceptor, $RfcReceptor, $Mpio, $Colonia, $Calle, $Nro, $CP, $Justificacion, $ID_RequisicionE);

        // Eliminar la requisición en la tabla RequisicionD
        eliminarRequisicionD($conexion, $ID_RequisicionE);

        // Confirmar la transacción
        $conexion->commit();

        // Éxito: redirige o muestra un mensaje
        echo '<script type="text/javascript">';
        echo 'alert("¡Requisición modificada exitosamente!");';
        echo 'window.location = "../../../Vista/SUPERADMIN/Solicitud_SUPERADMIN.php";'; // Reemplaza con la página correcta
        echo '</script>';
        exit();
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();

        // Muestra un mensaje de error
        echo '<script type="text/javascript">';
        echo 'alert("Error: ' . $e->getMessage() . '");';
        echo 'window.location = "../../../Vista/SUPERADMIN/Solicitud_SUPERADMIN.php";'; // Reemplaza con la página correcta
        echo '</script>';
        exit();
    } finally {
        // Cierra la conexión
        $conexion->close();
    }
} else {
    // Si no es una solicitud POST, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: Acceso no permitido.");';
    echo 'window.location = "../../../Vista/SUPERADMIN/Solicitud_SUPERADMIN.php";'; // Reemplaza con la página correcta
    echo '</script>';
    exit();
}

//Funcion para eliminar registros de la tabla RequisicionD
function eliminarRequisicionD($conexion, $ID_RequisicionE){
    $eliminar = $conexion->prepare("DELETE FROM RequisicionD WHERE IdReqE = ?");
    $eliminar->bind_param("i", $ID_RequisicionE);
    $eliminar->execute();
    
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
                insertarNewRequisicionD($conexion, $ID_RequisicionE, $idProducto, $idtall, $cant);
            }
        } else {
            // Maneja el caso en el que $_POST['datosTabla'] no es un JSON válido
            throw new Exception("Los datos de la tabla no están en el formato JSON esperado.");
        }
    } else {
        // Maneja el caso en el que $_POST['datosTabla'] no está definido
        throw new Exception("No se recibieron datos de la tabla.");
    }
}

//Funcion para insertar registros de la tabla RequisicionD
function insertarNewRequisicionD($conexion, $ID_RequisionE, $idProducto, $idtall, $cant){
    // Convierte $ID_RequisionE y $idProducto a enteros
    $ID_RequisionE = (int)$ID_RequisionE;
    $idProducto = (int)$idProducto;
    // Prepara la consulta
    $consultaRequisicionD = $conexion->prepare("INSERT INTO RequisicionD (IdReqE, IdCProd, IdTalla, Cantidad) VALUES (?, ?, ?, ?)");
    // Vincula los parámetros y ejecuta la consulta
    $consultaRequisicionD->bind_param("iiii", $ID_RequisionE, $idProducto, $idtall, $cant);
    $consultaRequisicionD->execute();
}

// Función para actualizar la tabla RequisicionE con datos de envío
function actualizarRequisicionE($conexion, $Mpio, $Colonia, $Calle, $Nro, $CP, $ID_RequisicionE) {
    $actualizarRequisicionE = $conexion->prepare("UPDATE RequisicionE SET Mpio=?, Colonia=?, Calle=?, Nro=?, CP=? WHERE IDRequisicionE=?;");
    $actualizarRequisicionE->bind_param("sssssi", $Mpio, $Colonia, $Calle, $Nro, $CP, $ID_RequisicionE);
    $actualizarRequisicionE->execute();
}

// Función para actualizar la tabla RequisicionE con datos principales y envío
function actualizarRequisicionECompleto($conexion, $FchCreacion, $Estatus, $Supervisor, $ID_Cuenta, $Region, $CentroTrabajo, $Estado, $Receptor, $TelReceptor, $RfcReceptor, $Mpio, $Colonia, $Calle, $Nro, $CP, $Justificacion, $ID_RequisicionE) {
    // Actualizar los datos principales de la requisición
    $consulta = "UPDATE RequisicionE SET FchCreacion=?, Estatus=?, Supervisor=?, IdCuenta = ?, IdRegion=?, CentroTrabajo=?, IdEstado=?, Receptor=?, TelReceptor=?, RfcReceptor=?, Justificacion=? WHERE IDRequisicionE = ?;";
    $consultaActualizarRequisicionE = $conexion->prepare($consulta);
    $consultaActualizarRequisicionE->bind_param("sssiisissssi", $FchCreacion, $Estatus, $Supervisor, $ID_Cuenta, $Region, $CentroTrabajo, $Estado, $Receptor, $TelReceptor, $RfcReceptor, $Justificacion, $ID_RequisicionE);
    $consultaActualizarRequisicionE->execute();

    // Si se seleccionó "Enviar a domicilio", actualizar los datos de envío
    if ($Mpio != '' || $Colonia != '' || $Calle != '' || $Nro != '' || $CP != '') {
        // Actualizar la requisición con los datos de envío
        actualizarRequisicionE($conexion, $Mpio, $Colonia, $Calle, $Nro, $CP, $ID_RequisicionE);
    }
}
?>