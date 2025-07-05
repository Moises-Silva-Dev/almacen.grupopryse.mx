<?php
// Función para insertar un registro de detalle de salida en la tabla Salida_D prestamo
function InsertarNuevaSalidaPrestamoD($conexion, $ID_SalidaPrestamoE, $IdCProd, $Id_Talla, $Cant) {
    // Preparar la consulta SQL
    $SetenciaInsertarNuevaSalidaPrestamoD = "INSERT INTO Salida_PresD (IdSalPresE, IdCProd, IdTallas, Cantidad) VALUES (?, ?, ?, ?)";

    // Preparar la sentencia
    $StmtInsertarNuevaSalidaPrestamoD = $conexion->prepare($SetenciaInsertarNuevaSalidaPrestamoD);

    // Vincular los parámetros
    $StmtInsertarNuevaSalidaPrestamoD->bind_param("iiii", $ID_SalidaPrestamoE, $IdCProd, $Id_Talla, $Cant);

    // Ejecutar la sentencia
    if ($StmtInsertarNuevaSalidaPrestamoD->execute()){ 
        return true; // Si se ejecuta correctamente, devuelve true
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de inserción.");
    }
}
?>