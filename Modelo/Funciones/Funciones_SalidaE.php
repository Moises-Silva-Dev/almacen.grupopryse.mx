<?php
// Función para insertar el registro de salida en la tabla Salida_E
function InsertarNuevaSalidaE($conexion, $ID_Requisicion, $ID_Usuario, $fecha_salida) {
    // Preparar la consulta SQL
    $SetenciaInsertarNuevaSalidaE= "INSERT INTO Salida_E (ID_ReqE, ID_Usuario_Salida, FchSalidad) VALUES (?, ?, ?)";

    // Preparar la setencia
    $StmtInsertarNuevaSalidaE = $conexion->prepare($SetenciaInsertarNuevaSalidaE);

    // Vincular los parámetros 
    $StmtInsertarNuevaSalidaE->bind_param("iis", $ID_Requisicion, $ID_Usuario, $fecha_salida);

    // Ejecutar la consulta SQL
    if ($StmtInsertarNuevaSalidaE->execute()) {
        return $conexion->insert_id; // Devuelve el ID del registro insertado
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de inserción.");
    }
}
?>