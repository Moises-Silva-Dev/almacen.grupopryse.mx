<?php
// Función para insertar un nuevo registro de regiones en la base de datos
function insertarNuevoRegion($conexion, $Nombre_Region, $registro) {
    // Preparar consulta SQL para insertar el registro
    $SetenciaInsertarNuevaRegion = "INSERT INTO Regiones (Nombre_Region, Fch_Registro) VALUES (?, ?)";

    // Preparar la sentencia
    $StmtInsertarNuevaRegion = $conexion->prepare($SetenciaInsertarNuevaRegion);

    // Vincular parámetros
    $StmtInsertarNuevaRegion->bind_param("ss", $Nombre_Region, $registro);

    // Ejecutar la consulta
    if ($StmtInsertarNuevaRegion->execute()) {
        return $conexion->insert_id; // Devuelve el ID del registro insertado
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar nueva región: " . $conexion->error);
    }
}

// Función para insertar un nuevo registro en la base de datos
function insertarNuevoRegionCuenta($conexion, $ID_Cuenta, $ID_region) {
    // Preparar consulta SQL para insertar el registro
    $SetenciaInsertarNuevaRegionCuenta = "INSERT INTO Cuenta_Region (ID_Cuentas, ID_Regiones) VALUES (?, ?)";

    // Preparar la sentencia
    $StmtInsertarNuevaRegionCuenta = $conexion->prepare($SetenciaInsertarNuevaRegionCuenta);

    // Vincular parámetros
    $StmtInsertarNuevaRegionCuenta->bind_param("ii", $ID_Cuenta, $ID_region);

    // Ejecutar la consulta
    if ($StmtInsertarNuevaRegionCuenta->execute()) {
        return true; // Regresar true si la inserción fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de inserción.");
    }
}

// Función para insertar un nuevo registro en la base de datos
function insertarNuevoEstadoRegion($conexion, $ID_region, $idEstado) {
    // Preparar consulta SQL para insertar el registro
    $SetenciaInsertarNuevaEstadoRegion = "INSERT INTO Estado_Region (ID_Regiones, ID_Estados) VALUES (?, ?)";

    // Preparar la sentencia
    $StmtInsertarNuevaEstadoRegion = $conexion->prepare($SetenciaInsertarNuevaEstadoRegion);

    // Vincular parámetros
    $StmtInsertarNuevaEstadoRegion->bind_param("ii", $ID_region, $idEstado);

    // Ejecutar la consulta
    if ($StmtInsertarNuevaEstadoRegion->execute()) {
        return true; // Regresar true si la inserción fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de inserción.");
    }
}

// Función para eliminar un relacion de la base de datos
function deleteEstadoRegion($conexion, $id_region) {
    // Preparar consulta SQL para eliminar el registro
    $SetenciaEliminarEstadoRegion = "DELETE FROM Estado_Region WHERE ID_Regiones = ?;";

    // Preparar la sentencia
    $StmtEliminarEstadoRegion = $conexion->prepare($SetenciaEliminarEstadoRegion);

    // Vincular parámetros
    $StmtEliminarEstadoRegion->bind_param("i", $id_region);

    // Ejecutar la consulta
    if ($StmtEliminarEstadoRegion->execute()) {
        return true; // Regresar true si la inserción fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de inserción.");
    }
}

// Función para eliminar un relacion de la base de datos
function deleteCuentaRegion($conexion, $id_region) {
    // Preparar consulta SQL para eliminar el registro
    $SetenciaEliminarCuentaRegion = "DELETE FROM Cuenta_Region WHERE ID_Regiones = ?;";

    // Preparar la sentencia
    $StmtEliminarCuentaRegion = $conexion->prepare($SetenciaEliminarCuentaRegion);

    // Vincular parámetros
    $StmtEliminarCuentaRegion->bind_param("i", $id_region);

    // Ejecutar la consulta
    if ($StmtEliminarCuentaRegion->execute()) {
        return true; // Regresar true si la inserción fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de inserción.");
    }
}

// Función para eliminar un registro de la base de datos
function DeleteRegion($conexion, $id_region) {
    // Preparar consulta SQL para eliminar el registro
    $SetenciaEliminarRegion = "DELETE FROM Regiones WHERE ID_Region = ?";
    
    // Preparar la sentencia
    $StmtEliminarRegion = $conexion->prepare($SetenciaEliminarRegion); 

    // Vincular parámetros
    $StmtEliminarRegion->bind_param("i", $id_region); 

    if ($StmtEliminarRegion->execute()) { // Ejecutar la consulta
        return true; // Regresar true si la eliminación fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("No se pudo eliminar el registro de la región.");
    }
}

// Función para actualiza la información de región
function actualizarRegion($conexion, $Nombre_Region, $registro, $id_region) {
    // Preparar consulta SQL para actualizar el registro
    $SetenciaActualizarRegion = "UPDATE Regiones SET Nombre_Region = ?, Fch_Registro = ? WHERE ID_Region = ?;";

    // Preparar la sentencia
    $StmtActualizarRegion = $conexion->prepare($SetenciaActualizarRegion);

    // Vincular parámetros
    $StmtActualizarRegion->bind_param("ssi", $Nombre_Region, $registro, $id_region);

    if ($StmtActualizarRegion->execute()){ // Ejecutar la consulta
        return true; // Regresar true si la actualización fue exitosa
    }else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("No se pudo actualizar el registro de la región.");
    }
}

// Función para actualizar la relacion de region con un cuenta
function updateRegionCuenta($conexion, $ID_Cuenta, $id_region) {
    // Preparar consulta SQL para actualizar la relación de región con cuenta
    $sql = "UPDATE Cuenta_Region SET ID_Cuentas = ? WHERE ID_Regiones = ?;";

    // Preparar la sentencia
    $stmt = $conexion->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("ii", $ID_Cuenta, $id_region);

    if ($stmt->execute()) { // Ejecutar la consulta
        return true; // Regresar true si la actualización fue exitosa
    }else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("No se pudo actualizar el registro de la región.");
    }
}
?>