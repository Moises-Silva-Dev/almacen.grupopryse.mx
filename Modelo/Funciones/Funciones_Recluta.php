<?php
function InsertarNuevoRecluta($conexion, $nombre, $ap_paterno, $ap_materno, $fecha_nacimiento, $origen_vacante, $fecha_envio, $transferido, $estado, $municipio, $centro_trabajo, $telefono, $servicio, $escolaridad, $edad, $transferido_a, $estatus, $observaciones, $registro, $reclutador){
    // Preparar la consulta SQL para la inserción
    $SetenciaInsertarNuevoRecluta = "INSERT INTO Recluta (Nombre, AP_Paterno, AP_Materno, Fecha_Nacimiento, Origen_Vacante, Fecha_Envio, Transferido, Estado, Municipio, Centro_Trabajo, Telefono, Servicio, Escolaridad, Edad, Transferido_A, Estatus, Observaciones, Fecha_Registro, Reclutador) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Preparar la sentencia
    $StmtInsertarNuevoRecluta = $conexion->prepare($SetenciaInsertarNuevoRecluta);

    // Vincular los parámetros
    $StmtInsertarNuevoRecluta->bind_param("sssssssssssssisssss", $nombre, $ap_paterno, $ap_materno, $fecha_nacimiento, $origen_vacante, $fecha_envio, $transferido, $estado, $municipio, $centro_trabajo, $telefono, $servicio, $escolaridad, $edad, $transferido_a, $estatus, $observaciones, $registro, $reclutador);

    // Ejecutar la consulta de inserción
    if ($StmtInsertarNuevoRecluta->execute()) {
        return true; // Regresar true si la inserción fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de inserción.");
    }
}

function ActualizarRecluta($conexion, $nombre, $ap_paterno, $ap_materno, $fecha_nacimiento, $origen_vacante, $fecha_envio, $transferido, $estado, $municipio, $centro_trabajo, $telefono, $servicio, $escolaridad, $edad, $transferido_a, $estatus, $observaciones, $registro, $reclutador, $ID_Recluta){
    // Preparar la consulta SQL para la actualización
    $SetenciaActualizarRecluta = "UPDATE Recluta SET Nombre = ?, AP_Paterno = ?, AP_Materno = ?, Fecha_Nacimiento = ?, Origen_Vacante = ?, Fecha_Envio = ?, Transferido = ?, Estado = ?, Municipio = ?, Centro_Trabajo = ?, Telefono = ?, Servicio = ?, Escolaridad = ?, Edad = ?, Transferido_A = ?, Estatus = ?, Observaciones = ?, Fecha_Registro = ?, Reclutador = ? WHERE ID_Recluta = ?";

    // Preparar la sentencia
    $StmtActualizarRecluta = $conexion->prepare($SetenciaActualizarRecluta);

    // Vincular los parámetros
    $StmtActualizarRecluta->bind_param("sssssssssssssisssssi", $nombre, $ap_paterno, $ap_materno, $fecha_nacimiento, $origen_vacante, $fecha_envio, $transferido, $estado, $municipio, $centro_trabajo, $telefono, $servicio, $escolaridad, $edad, $transferido_a, $estatus, $observaciones, $registro, $reclutador, $ID_Recluta);

    if ($StmtActualizarRecluta->execute()) {
        return true; // Regresar true si la actualización fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de actualización.");
    }
}
?>