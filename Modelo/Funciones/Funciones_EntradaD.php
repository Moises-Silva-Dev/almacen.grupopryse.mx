<?php
// Función para buscar información en la tabla EntradaD
function SeleccionarInformacionEntradaD($conexion, $id_EntradaE) {
    // Preparar consulta SQL para insertar el registro
    $SetenciaBuscarEntradaD = "SELECT * FROM EntradaD WHERE IdEntradaE = ?";
    
    // Preparar la sentencia
    $StmtBuscarEntradaD = $conexion->prepare($SetenciaBuscarEntradaD);
    
    // Vibncula el parámetro IDRequisicionE a la consulta
    $StmtBuscarEntradaD->bind_param("i", $id_EntradaE);
    
    // Ejecuta la consulta
    $StmtBuscarEntradaD->execute();
    
    // Obtiene el resultado de la consulta
    $ResultadoStmtBuscarEntradaD = $StmtBuscarEntradaD->get_result();

    $data = []; // Variable para almacenar los datos de la consulta

    if ($ResultadoStmtBuscarEntradaD->num_rows > 0) {
        // Obtiene los datos de la consulta
        while ($fila = $ResultadoStmtBuscarEntradaD->fetch_assoc()) {
            // Almacena los datos en la variable data
            $data[] = $fila;
        }

        // Retorna los datos de la consulta
        return $data;
    } else {
        // Si no hay resultados, retornamos `null` o un array vacío
        return null;
    }
}

// Función para insertar la entrada en la tabla EntradaD
function InsertarNuevaEntradaD($conexion, $id_EntradaE, $idProducto, $idtall, $cant) {
    // Preparar la sentencia SQL
    $SetenciaInsertarEntradaD = "INSERT INTO EntradaD (IdEntradaE, IdProd, IdTalla, Cantidad) VALUES (?,?,?,?)";
    
    // Preparar la sentencia SQL con los parámetros
    $StmtInsertarEntradaD = $conexion->prepare($SetenciaInsertarEntradaD);

    // Asignar los valores a los parámetros
    $StmtInsertarEntradaD->bind_param("iiii", $id_EntradaE, $idProducto, $idtall, $cant);
    
    // Ejecutar la sentencia SQL
    if ($StmtInsertarEntradaD->execute()) {
        return true; // Si se ejecuta correctamente, devuelve true
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar nueva entradaD: " . $conexion->error);
    }
}

// Función para eliminar registros de la tabla EntradaD
function EliminarEntradaD($conexion, $id_EntradaE){
    // Preparar la sentencia SQL
    $SetenciaEliminarEntradaD = "DELETE FROM EntradaD WHERE IdEntradaE = ?";

    // Preparar la sentencia SQL con los parámetros
    $StmtSetenciaEliminarEntradaD = $conexion->prepare($SetenciaEliminarEntradaD);

    // Asignar los valores a los parámetros
    $StmtSetenciaEliminarEntradaD->bind_param("i", $id_EntradaE);

    // Ejecutar la sentencia SQL
    if ($StmtSetenciaEliminarEntradaD->execute()) {
        return true; // Si se ejecuta correctamente, devuelve true
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al eliminar entradaD: " . $conexion->error);
    }
}
?>