<?php
// Función para buscar información en la tabla RequisicionD
function SeleccionarInformacionRequisicionD($conexion, $idSolicitud) {
    // Preparar consulta SQL para insertar el registro
    $SetenciaBuscarRequisicionD = "SELECT * FROM RequisicionD WHERE IdReqE = ?";

    // Preparar la sentencia
    $StmtBuscarRequisicionD = $conexion->prepare($SetenciaBuscarRequisicionD);
    
    // Vincula el parámetro BIDRequisicionE a la consulta
    $StmtBuscarRequisicionD->bind_param("i", $idSolicitud);
    
    // Ejecuta la consulta
    $StmtBuscarRequisicionD->execute();
    
    // Obtiene el resultado de la consulta
    $ResultadoBuscarRequisicionD = $StmtBuscarRequisicionD->get_result();
    
    // Recupera todas las filas como un array asociativo
    $filaResultadoBuscarRequisicionD = $ResultadoBuscarRequisicionD->fetch_all(MYSQLI_ASSOC);
    
    // Devuelve las filas completas
    return $filaResultadoBuscarRequisicionD;
}

// Función para insertar en la tabla RequisicionD
function InsertarNuevaRequisicionD($conexion, $idSolicitud, $requisicionesD) {
    // Preparar consulta SQL para insertar el registro
    $SetenciaInsertarNuevaRequisicionD = "INSERT INTO RequisicionD (IdReqE, IdCProd, IdTalla, Cantidad) VALUES (?, ?, ?, ?)";
    
    // Prepara la consulta
    $StmtInsertarNuevaRequisicionD = $conexion->prepare($SetenciaInsertarNuevaRequisicionD);

    // Obtiene la cantidad de filas en los datos de la tabla
    $numFilas = count($requisicionesD);

    // Inicializa una variable para rastrear el éxito de la inserción
    $exito = true;

    // Recorre cada registro en requisicionesD y ejecuta la consulta 
    for ($i = 0; $i < $numFilas; $i++) {
        $idProducto = $requisicionesD[$i]['BIdCProd'];
        $idtalla = $requisicionesD[$i]['BIdTalla'];
        $cantidad = $requisicionesD[$i]['BCantidad'];

        $StmtInsertarNuevaRequisicionD->bind_param("iiii", $idSolicitud, $idProducto, $idtalla, $cantidad);
        
        // Si alguna inserción falla, cambia la variable de éxito a false
        if (!$StmtInsertarNuevaRequisicionD->execute()) {
            $exito = false;
            break;
        }
    }
    // Retorna true si todas las inserciones fueron exitosas, de lo contrario false
    return $exito;
}

// Función para eliminar un registro de la tabla RequisicionD
function EliminarRequisicionD($conexion, $idSolicitud) {
    // Preparar la consulta SQL para eliminar el registro
    $SetenciaEliminarRequisicionD = "DELETE FROM RequisicionD WHERE IdReqE = ?;";
    
    // Preparar la sentencia
    $StmtEliminarRequisicionD = $conexion->prepare($SetenciaEliminarRequisicionD);

    // Vincular parámetros
    $StmtEliminarRequisicionD->bind_param("i", $idSolicitud);

    // Ejecutar la consulta
    if ($StmtEliminarRequisicionD->execute()) {
        return true; // Regresar true si la inserción fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de inserción.");
    }
}
?>