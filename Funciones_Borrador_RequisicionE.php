<?php
// Función para buscar información en la tabla Borrador_RequisicionE
function SeleccionarBorradorRequisicionEPorE($conexion, $BIDRequisicionE) {
    // Preparar la consulta SQL
    $SetenciaSeleccionarBorradorRequisicionEPorE = "SELECT * FROM Borrador_RequisicionE WHERE BIDRequisicionE = ?";
    
    // Preparar la sentencia SQL
    $StmtSeleccionarBorradorRequisicionEPorE = $conexion->prepare($SetenciaSeleccionarBorradorRequisicionEPorE);
    
    // Vincula el parámetro BIDRequisicionE a la consulta
    $StmtSeleccionarBorradorRequisicionEPorE->bind_param("i", $BIDRequisicionE);
    
    // Ejecuta la consulta
    $StmtSeleccionarBorradorRequisicionEPorE->execute();
    
    // Obtiene el resultado de la consulta
    $ResultadoSeleccionarBorradorRequisicionEPorE = $StmtSeleccionarBorradorRequisicionEPorE->get_result();
    
    // Recupera la fila como un array asociativo
    $filaSeleccionarBorradorRequisicionEPorE = $ResultadoSeleccionarBorradorRequisicionEPorE->fetch_assoc();
    
    // Devuelve la fila completa
    return $filaSeleccionarBorradorRequisicionEPorE;
}

// Función para insertar en la tabla Borrador_RequisicionE
function InsertarBorradorRequisicionERegresado($conexion, $FchEnvio, $InformacionRequisicionE) {
    $estatus = 'Modificacion_Solicitada'; // Define el estatus inicial

    // Preparar consulta SQL para insertar el registro
    $SetenciaInsertarBorradorRequisicionERegresado = "INSERT INTO Borrador_RequisicionE (BIdUsuario, BFchCreacion, BEstatus, BSupervisor, BIdCuenta, BIdRegion, BCentroTrabajo, BNroElementos, BReceptor, BTelReceptor, BRfcReceptor, BIdEstado, BMpio, BColonia, BCalle, BNro, BCP, BJustificacion) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Verifica si el número de columnas y valores coinciden
    $StmtInsertarBorradorRequisicionERegresado = $conexion->prepare($SetenciaInsertarBorradorRequisicionERegresado);

    // Vincula los parámetros, asegurándote de que el número de parámetros coincida con el número de columnas
    $StmtInsertarBorradorRequisicionERegresado->bind_param(
        "isssiisssssissssss",
        $InformacionRequisicionE['IdUsuario'], $FchEnvio, $estatus, $InformacionRequisicionE['Supervisor'], 
        $InformacionRequisicionE['IdCuenta'], $InformacionRequisicionE['IdRegion'], $InformacionRequisicionE['CentroTrabajo'], 
        $InformacionRequisicionE['NroElementos'], $InformacionRequisicionE['Receptor'], $InformacionRequisicionE['TelReceptor'], 
        $InformacionRequisicionE['RfcReceptor'], $InformacionRequisicionE['IdEstado'], $InformacionRequisicionE['Mpio'],
        $InformacionRequisicionE['Colonia'], $InformacionRequisicionE['Calle'], $InformacionRequisicionE['Nro'],
        $InformacionRequisicionE['CP'], $InformacionRequisicionE['Justificacion']);

    // Ejecutar la consulta
    if ($StmtInsertarBorradorRequisicionERegresado->execute()){
        return $conexion->insert_id; // Regresar true si la inserción fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de inserción.");
    }
}

// Función para insertar en la tabla RequisicionE
function InsertarNuevaRequisicionE($conexion, $id_Usuario, $FchCreacion, $Supervisor, $ID_Cuenta, $Region, $CentroTrabajo, $NroElementos, $Estado, $Receptor, $TelReceptor, $RfcReceptor, $Justificacion) {
    $estatus = 'Borrador'; // Define el estatus inicial 

    // Preparar consulta SQL para insertar el registro
    $SetenciaInsertarNuevoBorradorRequisicionE = "INSERT INTO Borrador_RequisicionE (BIdUsuario, BFchCreacion, BEstatus, BSupervisor, BIdCuenta, BIdRegion, BCentroTrabajo, BNroElementos, BIdEstado, BReceptor, BTelReceptor, BRfcReceptor, BJustificacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
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
function ActualizarRequisicionE($conexion, $FchCreacion, $Estatus, $Supervisor, $ID_Cuenta, $Region, $CentroTrabajo, $NroElementos, $Estado, $Receptor, $TelReceptor, $RfcReceptor, $Justificacion, $id_RequisionE) {
    // Actualizar los datos principales de la requisición
    $SetenciaActualizarRequisicionE = "UPDATE Borrador_RequisicionE SET BFchCreacion=?, BEstatus=?, BSupervisor=?, BIdCuenta = ?, BIdRegion=?, BCentroTrabajo=?, BNroElementos = ?, BIdEstado=?, BReceptor=?, BTelReceptor=?, BRfcReceptor=?, BJustificacion=? WHERE BIDRequisicionE = ?";
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
function ActualizarDomicilioRequisicionE($conexion, $Mpio, $Colonia, $Calle, $Nro, $CP, $ID_RequisionE) {
    // Preparar consulta SQL para actualizar el registro
    $SetenciaActualizarDomicilioRequisicionE = "UPDATE Borrador_RequisicionE SET BMpio=?, BColonia=?, BCalle=?, BNro=?, BCP=? WHERE BIDRequisicionE=?";
    
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

// Función para eliminar un registro de la tabla RequisicionE
function EliminarBorradorRequisicionE($conexion, $id_RequisionE) {
    // Preparar la consulta SQL para eliminar el registro
    $SetenciaEliminarBorradorRequisicionE = "DELETE FROM Borrador_RequisicionE WHERE BIDRequisicionE = ?";
    
    // Preparar la sentencia
    $StmtEliminarBorradorRequisicionE = $conexion->prepare($SetenciaEliminarBorradorRequisicionE);
    
    // Vincular parámetros
    $StmtEliminarBorradorRequisicionE->bind_param("i", $id_RequisionE);
    
    // Ejecutar la consulta
    if ($StmtEliminarBorradorRequisicionE->execute()) {
        return true; // Regresar true si la eliminación fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al eliminar el borrador de la requisiciónE: " . $conexion->error);
    }
}
?>