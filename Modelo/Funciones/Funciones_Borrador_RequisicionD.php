<?php
// Función para insertar en la tabla RequisicionD
function InsertarNuevoBorradorRequisicionD($conexion, $ID_RequisionE, $idProducto, $idtall, $cant) {
    // Convierte $ID_RequisionE y $idProducto a enteros
    $ID_RequisionE = (int)$ID_RequisionE;
    $idProducto = (int)$idProducto;

    // Preparar consulta SQL para insertar el registro
    $SetenciaInsertarNuevaRequisicionD = "INSERT INTO Borrador_RequisicionD (BIdReqE, BIdCProd, BIdTalla, BCantidad) VALUES (?, ?, ?, ?)";

    // Prepara la consulta
    $StmtInsertarNuevaRequisicionD = $conexion->prepare($SetenciaInsertarNuevaRequisicionD);

    // Vincula los parámetros y ejecuta la consulta
    $StmtInsertarNuevaRequisicionD->bind_param("iiii", $ID_RequisionE, $idProducto, $idtall, $cant);
    
    // Ejecuta la consulta
    if ($StmtInsertarNuevaRequisicionD->execute()) {
        return true; // Si la inserción es exitosa, devuelve true
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar nueva entradaD: " . $conexion->error);
    
    }
}

// Función para eliminar un registro de la tabla RequisicionD
function EliminarBorradorRequisicionD($conexion, $id_RequisionE) {
    // Preparar la consulta SQL para eliminar el registro
    $SetenciaEliminarBorradorRequisicionD = "DELETE FROM Borrador_RequisicionD WHERE BIdReqE = ?";

    // Preparar la sentencia
    $StmtEliminarBorradorRequisicionD = $conexion->prepare($SetenciaEliminarBorradorRequisicionD);

    // Vincular parámetros
    $StmtEliminarBorradorRequisicionD->bind_param("i", $id_RequisionE);

    // Ejecutar la consulta
    if ($StmtEliminarBorradorRequisicionD->execute()) {
        return true; // Si la eliminación es exitosa, devuelve true
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al eliminar borrador de RequisicionD: " . $conexion->error);
    }
}

// Función para insertar en la tabla RequisicionD
function InsertarBorradorRequisicionDRegresado($conexion, $ID_RequisionERegresado, $InformacionRequisicionD) {
    // Preparar consulta SQL para insertar el registro
    $SetenciaInsertarBorradorRequisicionDRegresado = "INSERT INTO Borrador_RequisicionD (BIdReqE, BIdCProd, BIdTalla, BCantidad) VALUES (?, ?, ?, ?)";
        
    // Prepara la consulta
    $StmtInsertarBorradorRequisicionDRegresado = $conexion->prepare($SetenciaInsertarBorradorRequisicionDRegresado);

    // Obtiene la cantidad de filas en los datos de la tabla
    $numFilas = count($InformacionRequisicionD);

    // Inicializa una variable para rastrear el éxito de la inserción
    $exito = true;
    
    // Recorre cada registro en InformacionRequisicionD y ejecuta la consulta 
    for ($i = 0; $i < $numFilas; $i++) {
        $idProducto = $InformacionRequisicionD[$i]['IdCProd'];
        $idtalla = $InformacionRequisicionD[$i]['IdTalla'];
        $cantidad = $InformacionRequisicionD[$i]['Cantidad'];

        $StmtInsertarBorradorRequisicionDRegresado->bind_param("iiii", $ID_RequisionERegresado, $idProducto, $idtalla, $cantidad);
        
        // Si alguna inserción falla, cambia la variable de éxito a false
        if (!$StmtInsertarBorradorRequisicionDRegresado->execute()) {
            $exito = false;
            break;
        }
    }
    // Retorna true si todas las inserciones fueron exitosas, de lo contrario false
    return $exito;
}

// Función para buscar información en la tabla Borrador_RequisicionD
function SeleccionarInformacionBorradorRequisicionD($conexion, $BIDRequisicionE) {
    // Preparar la consulta SQL
    $SetenciaSeleccionarBorradorRequisicionDPorD = "SELECT * FROM Borrador_RequisicionD WHERE BIdReqE = ?";

    // Preparar la sentencia SQL
    $StmtSeleccionarBorradorRequisicionDPorD = $conexion->prepare($SetenciaSeleccionarBorradorRequisicionDPorD);
    
    // Vincula el parámetro BIDRequisicionE a la consulta
    $StmtSeleccionarBorradorRequisicionDPorD->bind_param("i", $BIDRequisicionE);
    
    // Ejecuta la consulta
    $StmtSeleccionarBorradorRequisicionDPorD->execute();
    
    // Obtiene el resultado de la consulta
    $ResultadoSeleccionarBorradorRequisicionDPorD = $StmtSeleccionarBorradorRequisicionDPorD->get_result();
    
    // Recupera todas las filas como un array asociativo
    $filaSeleccionarBorradorRequisicionDPorD = $ResultadoSeleccionarBorradorRequisicionDPorD->fetch_all(MYSQLI_ASSOC);
    
    // Devuelve las filas completas
    return $filaSeleccionarBorradorRequisicionDPorD;
}

// Función para insertar en la tabla RequisicionD
function InsertarBorradorRequisicionDProductosPendientes($conexion, $ID_RequisionEProductos, $requisicionesD) {
    // Preparar consulta SQL para insertar el registro
    $SetenciaInsertarBorradorRequisicionDProductosPendientes = "INSERT INTO Borrador_RequisicionD (BIdReqE, BIdCProd, BIdTalla, BCantidad) VALUES (?, ?, ?, ?)";
        
    // Prepara la consulta
    $StmtInsertarBorradorRequisicionDProductosPendientes = $conexion->prepare($SetenciaInsertarBorradorRequisicionDProductosPendientes);

    // Obtiene la cantidad de filas en los datos de la tabla
    $numFilasE = count($requisicionesD);

    // Inicializa una variable para rastrear el éxito de la inserción
    $exito = true;
    
    // Recorre cada registro en InformacionRequisicionD y ejecuta la consulta 
    for ($i = 0; $i < $numFilasE; $i++) {
        $idProducto = $requisicionesD[$i]['IdCProd'];
        $idtalla = $requisicionesD[$i]['IdTalla'];
        $cantidad = $requisicionesD[$i]['Cantidad'];

        $StmtInsertarBorradorRequisicionDProductosPendientes->bind_param("iiii", $ID_RequisionEProductos, $idProducto, $idtalla, $cantidad);
        
        // Si alguna inserción falla, cambia la variable de éxito a false
        if (!$StmtInsertarBorradorRequisicionDProductosPendientes->execute()) {
            $exito = false;
            break;
        }
    }
    // Retorna true si todas las inserciones fueron exitosas, de lo contrario false
    return $exito;
}
?>