<?php
// Función para insertar en la tabla RequisicionD
function InsertarNuevoPrestamoD($conexion, $ID_PrestamoE, $idProducto, $idtall, $cant) {    
    // Convierte $ID_RequisionE y $idProducto a enteros
    $ID_PrestamoE = (int)$ID_PrestamoE;
    $idProducto = (int)$idProducto;

    // Preparar consulta SQL para insertar el registro
    $SetenciaInsertarNuevoPrestamoD = "INSERT INTO PrestamoD (IdPresE, IdCProd, IdTallas, Cantidad) VALUES (?, ?, ?, ?)";

    // Prepara la consulta
    $StmtInsertarNuevoPrestamoD = $conexion->prepare($SetenciaInsertarNuevoPrestamoD);

    // Vincula los parámetros y ejecuta la consulta
    $StmtInsertarNuevoPrestamoD->bind_param("iiii", $ID_PrestamoE, $idProducto, $idtall, $cant);
    
    // Ejecuta la consulta
    if ($StmtInsertarNuevoPrestamoD->execute()) {
        return true; // Si la inserción es exitosa, devuelve true
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar nueva entradaD: " . $conexion->error);
    
    }
}

// Función para eliminar un registro de la tabla RequisicionD
function EliminarPrestamoD($conexion, $id_PrestamoE) {
    // Preparar la consulta SQL para eliminar el registro
    $SetenciaEliminarPrestamoD = "DELETE FROM PrestamoD WHERE IdPresE = ?";

    // Preparar la sentencia
    $StmtEliminarPrestamoD = $conexion->prepare($SetenciaEliminarPrestamoD);

    // Vincular parámetros
    $StmtEliminarPrestamoD->bind_param("i", $id_PrestamoE);

    // Ejecutar la consulta
    if ($StmtEliminarPrestamoD->execute()) {
        return true; // Si la eliminación es exitosa, devuelve true
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al eliminar borrador de RequisicionD: " . $conexion->error);
    }
}
?>