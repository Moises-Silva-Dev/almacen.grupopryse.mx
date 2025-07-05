<?php
// Función para insertar en la tabla RequisicionE
function InsertarNuevoPrestamoE($conexion, $id_Usuario, $FchCreacion, $Justificacion) {
    $estatus = 'Pendiente'; // Define el estatus inicial 

    // Preparar consulta SQL para insertar el registro
    $SetenciaInsertarNuevoPrestamoE = "INSERT INTO PrestamoE (IdUsuario, FchCreacion, Justificacion, Estatus) VALUES (?, ?, ?, ?)";
    
    // Verifica si el número de columnas y valores coinciden
    $StmtInsertarNuevoPrestamoE = $conexion->prepare($SetenciaInsertarNuevoPrestamoE);
    
    // Vincula los parámetros, asegurándote de que el número de parámetros
    $StmtInsertarNuevoPrestamoE->bind_param("isss", $id_Usuario, $FchCreacion, $Justificacion, $estatus);
    
    if ($StmtInsertarNuevoPrestamoE->execute()) {
        return $conexion->insert_id; // Regresar true si la inserción fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar nueva región: " . $conexion->error);
    }
}

// Función para eliminar un registro de la tabla RequisicionE
function EliminarPrestamoE($conexion, $id_PrestamoE) {
    // Preparar la consulta SQL para eliminar el registro
    $SetenciaEliminarPrestamoE = "DELETE FROM PrestamoE WHERE IdPrestamoE = ?";
    
    // Preparar la sentencia
    $StmtEliminarBorradorPrestamoE = $conexion->prepare($SetenciaEliminarPrestamoE);
    
    // Vincular parámetros
    $StmtEliminarBorradorPrestamoE->bind_param("i", $id_PrestamoE);
    
    // Ejecutar la consulta
    if ($StmtEliminarBorradorPrestamoE->execute()) {
        return true; // Regresar true si la eliminación fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al eliminar el borrador de la requisiciónE: " . $conexion->error);
    }
}

// Función para actualizar la tabla RequisicionE con datos principales y envío
function ActualizarPrestamoE($conexion, $FchActualizacion, $Justificacion, $IdPrestamoE) {
    $estatus = 'Pendiente'; // Define el estatus inicial
    // Actualizar los datos principales de la requisición
    $SetenciaActualizarPrestamoE = "UPDATE PrestamoE SET FchCreacion=?, Estatus=?, Justificacion=? WHERE IdPrestamoE = ?";
    // Preparar la consulta SQL para actualizar el registro
    $StmtActualizarPrestamoE = $conexion->prepare($SetenciaActualizarPrestamoE);
    // Vincula los parámetros
    $StmtActualizarPrestamoE->bind_param("sssi", $FchActualizacion, $estatus, $Justificacion, $IdPrestamoE);
    // Ejecutar la consulta
    if ($StmtActualizarPrestamoE->execute()) {
        return true;
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al actualizar la requisiciónE: " . $conexion->error);
    }
}

// Función para cambiar estatus de requisicion en la tabla RequisicionE
function CambiarEstatusPrestamoE($conexion, $fecha_alta, $idSolicitud) {
    // Declarar variables
    $NuevoEstatusPrestamo = "Autorizado";

    // Prepara la consulta SQL para cambiar el estatus a "Autorizado"
    $SetenciaModificarEstatusPrestamoE = "UPDATE PrestamoE SET Estatus = ?, FchAutoriza = ? WHERE IdPrestamoE = ?";

    // Prepara la sentencia
    $StmtModificarEstatusPrestamoE = $conexion->prepare($SetenciaModificarEstatusPrestamoE);

    // Vincula parámetros
    $StmtModificarEstatusPrestamoE->bind_param("ssi", $NuevoEstatusPrestamo, $fecha_alta, $idSolicitud);

    // Ejecuta la consulta
    if ($StmtModificarEstatusPrestamoE->execute()) {
        return true; // Regresar true si la inserción fue exitosa;
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de inserción.");
    }
}

// Función para actualizar el estatus de un préstamo después de una salida
function ActualizarEstatusPrestamoESalida($conexion, $IdPrestamoE){
    $SQLBuscarEstatus = $conexion->prepare("SELECT 
        CASE 
            WHEN SPD1.Cantidad = 0 THEN 'Pendiente'
            WHEN SPD1.Cantidad < SUM(PD.Cantidad) THEN 'Parcial'
            ELSE 'Surtido' END AS Estado
        FROM 
            PrestamoD PD
        INNER JOIN 
            (SELECT 
                SPE.ID_PresE, SUM(SPD.Cantidad) Cantidad
            FROM 
                Salida_PresE SPE
            INNER JOIN 
                Salida_PresD SPD ON SPE.Id_SalPresE = SPD.IdSalPresE
            WHERE 
                SPE.ID_PresE = ?) SPD1 ON PD.IdPresE = SPD1.ID_PresE
        WHERE 
            PD.IdPresE = ?");
            
    $SQLBuscarEstatus->bind_param("ii", $IdPrestamoE, $IdPrestamoE); // Asegúrate de que el ID de la requisición sea el mismo en ambas partes de la consulta
    $SQLBuscarEstatus->execute(); // Ejecutar la consulta
    $result = $SQLBuscarEstatus->get_result(); // Obtener el resultado de la consulta
    $row = $result->fetch_assoc(); // Obtener la fila del resultado
    $estado = $row['Estado']; // Obtener el estado calculado

    $SQLActualizarEstatus = $conexion->prepare("UPDATE PrestamoE SET Estatus = ? WHERE IdPrestamoE = ?"); // Preparar la consulta SQL para actualizar el estatus
    $SQLActualizarEstatus->bind_param("si", $estado, $IdPrestamoE); // Vincular los parámetros
    $SQLActualizarEstatus->execute(); // Ejecutar la consulta de actualización
    $SQLActualizarEstatus->close(); // Cerrar la sentencia
    $SQLBuscarEstatus->close(); // Cerrar la sentencia de búsqueda
    return true; // Retornar true si la actualización fue exitosa
}
?>