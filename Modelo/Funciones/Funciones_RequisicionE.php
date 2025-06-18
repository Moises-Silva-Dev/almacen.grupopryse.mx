<?php
// Función para insertar en la tabla RequisicionE
function InsertarNuevaRequisicionEAdmin($conexion, $id_Usuario, $FchCreacion, $Supervisor, $ID_Cuenta, $Region, $CentroTrabajo, $NroElementos, $Estado, $Receptor, $TelReceptor, $RfcReceptor, $Justificacion) {
    $estatus = 'Pendiente'; // Define el estatus inicial 

    // Preparar consulta SQL para insertar el registro
    $SetenciaInsertarNuevoBorradorRequisicionE = "INSERT INTO RequisicionE (IdUsuario, FchCreacion, Estatus, Supervisor, IdCuenta, IdRegion, CentroTrabajo, NroElementos, IdEstado, Receptor, TelReceptor, RfcReceptor, Justificacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Verifica si el número de columnas y valores coinciden
    $StmtInsertarNuevoBorradorRequisicionE = $conexion->prepare($SetenciaInsertarNuevoBorradorRequisicionE);
    
    // Vincula los parámetros, asegurándote de que el número de parámetros
    $StmtInsertarNuevoBorradorRequisicionE->bind_param("isssiississss", $id_Usuario, $FchCreacion, $estatus, $Supervisor, $ID_Cuenta, $Region, $CentroTrabajo, $NroElementos, $Estado, $Receptor, $TelReceptor, $RfcReceptor, $Justificacion);
    
    if ($StmtInsertarNuevoBorradorRequisicionE->execute()) {
        return $conexion->insert_id; // Regresar true si la inserción fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar nueva región: " . $conexion->error);
    }
}

// Función para actualizar la tabla RequisicionE con datos principales y envío
function ActualizarRequisicionEAdmin($conexion, $FchCreacion, $Estatus, $Supervisor, $ID_Cuenta, $Region, $CentroTrabajo, $NroElementos, $Estado, $Receptor, $TelReceptor, $RfcReceptor, $Justificacion, $id_RequisionE) {
    // Actualizar los datos principales de la requisición
    $SetenciaActualizarRequisicionE = "UPDATE RequisicionE SET FchCreacion=?, Estatus=?, Supervisor=?, IdCuenta = ?, IdRegion=?, CentroTrabajo=?, NroElementos = ?, IdEstado=?, Receptor=?, TelReceptor=?, RfcReceptor=?, Justificacion=? WHERE IDRequisicionE = ?";
    // Preparar la consulta SQL para actualizar el registro
    $StmtActualizarRequisicionE = $conexion->prepare($SetenciaActualizarRequisicionE);
    // Vincula los parámetros
    $StmtActualizarRequisicionE->bind_param("sssiississssi", $FchCreacion, $Estatus, $Supervisor, $ID_Cuenta, $Region, $CentroTrabajo, $NroElementos, $Estado, $Receptor, $TelReceptor, $RfcReceptor, $Justificacion, $id_RequisionE);
    // Ejecutar la consulta
    if ($StmtActualizarRequisicionE->execute()) {
        return true;
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al actualizar la requisiciónE: " . $conexion->error);
    }
}

// Función para actualizar la tabla RequisicionE con datos de envío
function ActualizarDomicilioRequisicionEAdmin($conexion, $Mpio, $Colonia, $Calle, $Nro, $CP, $ID_RequisionE) {
    // Preparar consulta SQL para actualizar el registro
    $SetenciaActualizarDomicilioRequisicionE = "UPDATE RequisicionE SET Mpio=?, Colonia=?, Calle=?, Nro=?, CP=? WHERE IDRequisicionE=?";
    
    // Verifica si el número de columnas y valores coinciden
    $StmtActualizarDomicilioRequisicionE = $conexion->prepare($SetenciaActualizarDomicilioRequisicionE);
    
    // Vincula los parámetros, asegurándote de que el número de parámetros
    $StmtActualizarDomicilioRequisicionE->bind_param("sssssi", $Mpio, $Colonia, $Calle, $Nro, $CP, $ID_RequisionE);
    
    if ($StmtActualizarDomicilioRequisicionE->execute()) {
        return true; // Regresar true si la actualización fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al actualizar el domicilio de la requisición: " . $conexion->error);
    }
}

// Función para cambiar estatus de requisicion en la tabla RequisicionE
function CambiarEstatusRequisicionE($conexion, $idSolicitud, $fecha_alta) {
    // Declarar variables
    $NuevoEstatusRequisicion = "Autorizado";

    // Prepara la consulta SQL para cambiar el estatus a "Autorizado"
    $SetenciaModificarEstatusRequisicionE = "UPDATE RequisicionE SET Estatus = ?, FchAutoriza = ? WHERE IDRequisicionE = ?";

    // Prepara la sentencia
    $StmtModificarEstatusRequisicionE = $conexion->prepare($SetenciaModificarEstatusRequisicionE);

    // Vincula parámetros
    $StmtModificarEstatusRequisicionE->bind_param("ssi", $NuevoEstatusRequisicion, $fecha_alta, $idSolicitud);

    // Ejecuta la consulta
    if ($StmtModificarEstatusRequisicionE->execute()) {
        return true; // Regresar true si la inserción fue exitosa;
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de inserción.");
    }
}

// Función para buscar información en la tabla RequisicionE
function SeleccionarInformacionRequisicionE($conexion, $idSolicitud) {
    // Preparar consulta SQL para insertar el registro
    $SetenciaBuscarRequisicionE = "SELECT * FROM RequisicionE WHERE IDRequisicionE = ?";
    
    // Preparar la sentencia
    $StmtBuscarRequisicionE = $conexion->prepare($SetenciaBuscarRequisicionE);
    
    // Vibncula el parámetro IDRequisicionE a la consulta
    $StmtBuscarRequisicionE->bind_param("i", $idSolicitud);
    
    // Ejecuta la consulta
    $StmtBuscarRequisicionE->execute();
    
    // Obtiene el resultado de la consulta
    $ResultadoBuscarRequisicionE = $StmtBuscarRequisicionE->get_result();
    
    // Recupera la fila como un array asociativo
    $filaResultadoBuscarRequisicionE = $ResultadoBuscarRequisicionE->fetch_assoc();
    
    // Devuelve la fila completa
    return $filaResultadoBuscarRequisicionE;
}

// Funcion para eliminar información en la tabla RequisicionE
function EliminarRequisicionE($conexion, $idSolicitud) {
    // Preparar la consulta SQL para eliminar el registro
    $SetenciaEliminarRequisicionE = "DELETE FROM RequisicionE WHERE IDRequisicionE = ?";

    // Preparar la sentencia
    $StmtEliminarRequisicionE = $conexion->prepare($SetenciaEliminarRequisicionE);
    
    // Vincular parámetros
    $StmtEliminarRequisicionE->bind_param("i", $idSolicitud);

    // Ejecutar la consulta
    if ($StmtEliminarRequisicionE->execute()) {
        return true; // Regresar true si la inserción fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de eliminacion requisicionE.");
    }
}

// Función para insertar en la tabla RequisicionE
function InsertarNuevaRequisicionE($conexion, $FchEnvio, $requisicionesE) {
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

    if ($consultaRequisicionE->execute()) {
        return $conexion->insert_id; // Regresar true si la inserción fue exitosa
    } else {
        // Lanzar una excepción si la inserción falla
        throw new Exception("Error al insertar en la tabla RequisicionE");
    }
}

function ActualizarEstatusRequisionESalida($conexion, $id_requisicion){
    $SQLBuscarEstatus = $conexion->prepare("SELECT 
        CASE 
            WHEN SD1.Cantidad = 0 THEN 'Pendiente'
            WHEN SD1.Cantidad < SUM(RD.Cantidad) THEN 'Parcial'
            ELSE 'Surtido' END AS Estado
        FROM 
            RequisicionD RD
        INNER JOIN 
            (SELECT 
                SE.ID_ReqE, SUM(SD.Cantidad) Cantidad
            FROM 
                Salida_E SE
            INNER JOIN 
                Salida_D SD ON SE.Id_SalE = SD.Id
            WHERE 
                SE.ID_ReqE = ?) SD1 ON RD.IdReqE = SD1.ID_ReqE
        WHERE 
            RD.IdReqE = ?");
            
    $SQLBuscarEstatus->bind_param("ii", $id_requisicion, $id_requisicion);
    $SQLBuscarEstatus->execute();
    $result = $SQLBuscarEstatus->get_result();
    $row = $result->fetch_assoc();
    $estado = $row['Estado'];

    $SQLActualizarEstatus = $conexion->prepare("UPDATE RequisicionE SET Estatus = ? WHERE IDRequisicionE = ?");
    $SQLActualizarEstatus->bind_param("si", $estado, $id_requisicion);
    $SQLActualizarEstatus->execute();
    $SQLActualizarEstatus->close();
    $SQLBuscarEstatus->close();
    return true;
}
?>