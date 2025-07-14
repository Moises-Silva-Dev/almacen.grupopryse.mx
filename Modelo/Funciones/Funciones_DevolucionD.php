<?php
// Función para insertar la entrada en la tabla EntradaD
function InsertarNuevaDevolucionD($conexion, $id_DevolucionE, $idProducto, $idtall, $cant) {
    // Preparar la sentencia SQL
    $SetenciaInsertarEntradaD = "INSERT INTO DevolucionD (IdDevE, IdCProd, IdTalla, Cantidad) VALUES (?,?,?,?)";
    
    // Preparar la sentencia SQL con los parámetros
    $StmtInsertarEntradaD = $conexion->prepare($SetenciaInsertarEntradaD);

    // Asignar los valores a los parámetros
    $StmtInsertarEntradaD->bind_param("iiii", $id_DevolucionE, $idProducto, $idtall, $cant);
    
    // Ejecutar la sentencia SQL
    if ($StmtInsertarEntradaD->execute()) {
        return true; // Si se ejecuta correctamente, devuelve true
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar nueva entradaD: " . $conexion->error);
    }
}
?>