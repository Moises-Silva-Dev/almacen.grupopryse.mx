<?php
// Función para insertar un nuevo registro en la base de datos
function InsertarNuevaCuenta($conexion, $NombreCuenta, $NroElemetos) {
    // Preparar la consulta SQL para la inserción
    $SetenciaInsertarNuevaCuenta = "INSERT INTO Cuenta (NombreCuenta, NroElemetos) VALUES (?, ?)";

    // Preparar la sentencia
    $StmtInsertarNuevaCuenta = $conexion->prepare($SetenciaInsertarNuevaCuenta);

    // Vincular los parámetros
    $StmtInsertarNuevaCuenta->bind_param("si", $NombreCuenta, $NroElemetos);

    // Ejecutar la consulta de inserción
    if ($StmtInsertarNuevaCuenta->execute()) {
        return true; // Regresar true si la inserción fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de inserción.");
    }
}

// Función para eliminar el registro en la base de datos
function DeleteCuenta($conexion, $id_cuenta) {
    // Preparar la consulta SQL para la eliminación
    $SetenciaEliminarCuenta = "DELETE FROM Cuenta WHERE ID = ?";

    // Preparar la sentencia
    $StmtEliminarCuenta = $conexion->prepare($SetenciaEliminarCuenta);

    // Vincular el parámetro
    $StmtEliminarCuenta->bind_param("i", $id_cuenta);

    // Ejecutar la consulta de eliminación
    if ($StmtEliminarCuenta->execute()) {
        return true; // Regresar true si la eliminación fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de eliminación.");
    }
}

// Función para actualizar un registro en la base de datos
function UpdateCuenta($conexion, $NombreCuenta, $NroElemetos, $id_cuenta) {
    // Preparar la consulta SQL para actualizar la región
    $SetenciaActualizarCuenta = "UPDATE Cuenta SET NombreCuenta = ?, NroElemetos = ? WHERE ID = ?";

    // Preparar la sentencia
    $StmtActualizarCuenta = $conexion->prepare($SetenciaActualizarCuenta);

    // Vincular parámetros
    $StmtActualizarCuenta->bind_param("sii", $NombreCuenta, $NroElemetos, $id_cuenta);

    // Ejecutar la consulta de actualización
    if ($StmtActualizarCuenta->execute()) {
        return true; // Regresar true si la actualización fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de actualización.");
    }
}
?>