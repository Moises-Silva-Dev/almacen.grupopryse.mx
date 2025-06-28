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
?>