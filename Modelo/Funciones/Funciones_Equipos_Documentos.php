<?php
// Función para insertar un nuevo documento asociado a un equipo
function InsertarNuevoDocumento($conexion, $id_Equipo, $nombreDocumento, $ubicacion, $fechaRegistro) {
    $sql = "INSERT INTO Equipo_Documentos (Id_Equipo, Nombre_Documento, Ubicacion, Fecha_Registro) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        error_log("Error en prepare documentos: " . $conexion->error);
        return false;
    }
    
    $stmt->bind_param("isss", $id_Equipo, $nombreDocumento, $ubicacion, $fechaRegistro);
    $result = $stmt->execute();
    
    if (!$result) {
        error_log("Error en execute documentos: " . $stmt->error);
    }
    
    $stmt->close();
    return $result;
}

// Función para eliminar un documento asociado a un equipo
function EliminarDocumento($conexion, $id_Documento, $ubicacion) {
    // Primero, eliminar el registro de la base de datos
    $sql = "DELETE FROM Equipo_Documentos WHERE Id = ?";
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        error_log("Error en prepare delete: " . $conexion->error);
        return false;
    }
    
    $stmt->bind_param("i", $id_Documento);
    $result = $stmt->execute();
    $stmt->close();
    
    if (!$result) {
        return false;
    }
    
    // Si se eliminó correctamente el registro, eliminar el archivo físico
    if (!empty($ubicacion)) {
        $rutaArchivo = '../../../uploads/documentos_equipos/' . $ubicacion;
        if (file_exists($rutaArchivo)) {
            if (!unlink($rutaArchivo)) {
                error_log("Error al eliminar el archivo físico: " . $rutaArchivo);
                // No lanzamos excepción porque el registro ya se eliminó
                // Solo registramos el error en el log
            }
        }
    }
    
    return true;
}
?>