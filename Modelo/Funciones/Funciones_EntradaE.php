<?php
// Función para insertar la entrada en la tabla EntradaE
function InsertarNuevaEntradaE($conexion, $registro, $id_Usuario, $Proveedor, $Receptor, $Comentarios, $estatus) {
    // Preparar la sentencia SQL
    $SetenciaInsertarEntradaE = "INSERT INTO EntradaE (Fecha_Creacion, Usuario_Creacion, Proveedor, Receptor, Comentarios, Estatus) VALUES (?,?,?,?,?,?);";
    
    // Preparar la sentencia SQL con los parámetros
    $StmtInsertarEntradaE = $conexion->prepare($SetenciaInsertarEntradaE);
    
    // Asignar los valores a los parámetros
    $StmtInsertarEntradaE->bind_param("sissss", $registro, $id_Usuario, $Proveedor, $Receptor, $Comentarios, $estatus);
    
    // Ejecutar la sentencia SQL
    if ($StmtInsertarEntradaE->execute()) {
        return $conexion->insert_id; // Devuelve el ID de la entrada recién insertada
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar nueva entradaE: " . $conexion->error);
    }
}

function ActualizarEstatusEntradaE($conexion, $id_EntradaE) {
    // Prepara la consulta SQL para cambiar el estatus a "Eliminado"
    $SetenciaActualizarEstatusEntradaE = "UPDATE EntradaE SET Estatus = 'Eliminado' WHERE IdEntE = ?";

    // Prepara la sentencia
    $StmtActualizarEstatusEntradaE = $conexion->prepare($SetenciaActualizarEstatusEntradaE);

    // Vincula parámetros
    $StmtActualizarEstatusEntradaE->bind_param("i", $id_EntradaE);

    // Ejecuta la consulta
    if ($StmtActualizarEstatusEntradaE->execute()) {
        return true;
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al cambiar estatus de entradaE: " . $conexion->error);
    }
}

// Función para actualizar la entrada
function ActualizarEntradE($conexion, $registro, $nuevoNumeroModif, $Proveedor, $Receptor, $Comentarios, $estatus, $id_EntradaE) {
    // Preparar la consulta SQL para actualizar la entrada
    $SetenciaActualizarEntradaE = "UPDATE EntradaE SET Fecha_Modificacion = ?, Nro_Modif = ?, Proveedor = ?, Receptor = ?, Comentarios = ?, Estatus = ? WHERE IdEntE = ?";

    // Preparar la sentencia
    $StmtActualizarEntradaE = $conexion->prepare($SetenciaActualizarEntradaE);

    // Vincular parámetros
    $StmtActualizarEntradaE->bind_param("sissssi", $registro, $nuevoNumeroModif, $Proveedor, $Receptor, $Comentarios, $estatus, $id_EntradaE);

    // Ejecutar la consulta
    if ($StmtActualizarEntradaE->execute()) {
        return true;
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al actualizar entradaE: " . $conexion->error);
    }
}
?>