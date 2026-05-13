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
?>