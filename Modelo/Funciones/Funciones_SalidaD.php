<?php
// Función para insertar un registro de detalle de salida en la tabla Salida_D
function InsertarNuevaSalidaD($conexion, $ID_SalidaE, $IdCProd, $Id_Talla, $Cant) {
    // Preparar la consulta SQL
    $SetenciaInsertarNuevaSalidaD = "INSERT INTO Salida_D (Id, IdCProd, IdTallas, Cantidad) VALUES (?, ?, ?, ?)";

    // Preparar la sentencia
    $StmtInsertarNuevaSalidaD = $conexion->prepare($SetenciaInsertarNuevaSalidaD);

    // Vincular los parámetros
    $StmtInsertarNuevaSalidaD->bind_param("iiii", $ID_SalidaE, $IdCProd, $Id_Talla, $Cant);

    // Ejecutar la sentencia
    if ($StmtInsertarNuevaSalidaD->execute()){ 
        return true; // Si se ejecuta correctamente, devuelve true
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de inserción.");
    }
}
?>