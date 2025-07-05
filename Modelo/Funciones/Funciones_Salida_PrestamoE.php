<?php
// Función para insertar el registro de salida en la tabla Salida_E prestamo 
function InsertarNuevaSalidaPrestamoE($conexion, $IdPrestamoE, $ID_Usuario, $fecha_salida) {
    // Preparar la consulta SQL
    $SetenciaInsertarNuevaSalidaPrestamoE= "INSERT INTO Salida_PresE (ID_PresE, ID_Usuario_SalPres, FchSalidaPres) VALUES (?, ?, ?)";

    // Preparar la setencia
    $StmtInsertarNuevaSalidaPrestamoE = $conexion->prepare($SetenciaInsertarNuevaSalidaPrestamoE);

    // Vincular los parámetros 
    $StmtInsertarNuevaSalidaPrestamoE->bind_param("iis", $IdPrestamoE, $ID_Usuario, $fecha_salida);

    // Ejecutar la consulta SQL
    if ($StmtInsertarNuevaSalidaPrestamoE->execute()) {
        return $conexion->insert_id; // Devuelve el ID del registro insertado
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de inserción.");
    }
}
?>