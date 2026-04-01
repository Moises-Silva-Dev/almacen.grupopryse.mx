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

// Función para obtener todas las entradas de la tabla EntradaD
function ObtenerDevolucionD($conexion, $id_DevolucionE) {
    // Preparar la sentencia SQL
    $SentenciaObtenerDevolucionD = "SELECT IdCProd, IdTalla, Cantidad FROM DevolucionD WHERE IdDevE = ?";

    // Preparar la sentencia SQL con los parámetros
    $StmtObtenerDevolucionD = $conexion->prepare($SentenciaObtenerDevolucionD);
    $StmtObtenerDevolucionD->bind_param("i", $id_DevolucionE);

    // Ejecutar la sentencia SQL
    if ($StmtObtenerDevolucionD->execute()) {
        $result = $StmtObtenerDevolucionD->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // Devolver todos los resultados como un array asociativo
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al obtener devoluciónD: " . $conexion->error);
    }
}
?>