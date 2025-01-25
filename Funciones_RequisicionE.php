<?php
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

// Función para insertar en la tabla RequisicionE
function InsertarNuevaBorradorRequisicionE($conexion, $FchEnvio, $requisicionesE) {
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

// Funcion para eliminar información en la tabla RequisicionE
function EliminarBorradorRequisicionE($conexion, $idSolicitud) {
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

//Función para actualizar el estatus de salida
function ActualizarEstatusRequisionESalida($conexion, $ID_Requisicion){
    // Preparar la consulta SQL para actualizar el estatus de salida
    $SetenciaCalcularCantidadSalidad = "SELECT 
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
                RD.IdReqE = ?";

    // Prepara la sentencia
    $StmtCalcularCantidadSalidad = $conexion->prepare($SetenciaCalcularCantidadSalidad);
    
    // Vincula parámetros
    $StmtCalcularCantidadSalidad->bind_param("ii", $ID_Requisicion, $ID_Requisicion);

    // Ejecuta la consulta
    if ($StmtCalcularCantidadSalidad->execute()) {
        // Obtiene el resultado de la consulta
        $ResultadoStmtCalcularCantidadSalidad = $StmtCalcularCantidadSalidad->get_result();

        // Obtiene el primer registro de la consulta
        $row = $ResultadoStmtCalcularCantidadSalidad->fetch_assoc();

        // Obtiene el valor del campo 'Estado'
        $estado = $row['Estado'];
    
        // Preparar la consulta SQL para actualizar 
        $SetenciaActualizarEstatusRequisionESalida = "UPDATE RequisicionE SET Estatus = ? WHERE IDRequisicionE = ?";

        // Prepara la sentencia
        $StmtActualizarEstatusRequisionESalida = $conexion->prepare($SetenciaActualizarEstatusRequisionESalida);

        // Vincula parámetros
        $StmtActualizarEstatusRequisionESalida->bind_param("si", $estado, $ID_Requisicion);

        // Ejecuta la consulta
        if ($StmtActualizarEstatusRequisionESalida->execute()){
            return true;
        } else {
            // Lanzar una excepción para activar el bloque catch
            throw new Exception("Error en la ejecucion de modificacion de estatus.");
        }
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta calculo de salida.");
    }
}
?>