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

// Función para recuperar los productos incompletos
function RequisicionDProductosPendientes($conexion, $ID_Requisicion) {
    // Preparar consulta SQL para insertar el registro
    $SetenciaRequisicionDProductosPendientes = "SELECT 
            RE.IDRequisicionE AS Identificador_Requisicion,
            RD.IdCProd AS Identificador_Producto,
            P.Descripcion AS Descripcion_Producto,
            P.Especificacion AS Especificacion_Producto,
            RD.IdTalla AS Identificador_Talla,
            CT.Talla AS Talla,
            RD.Cantidad AS Cantidad_Solicitada,
            IFNULL(SUM(SD.Cantidad), 0) AS Cantidad_Salida
        FROM 
            RequisicionE RE
        INNER JOIN 
            RequisicionD RD ON RD.IdReqE = RE.IDRequisicionE
        LEFT JOIN 
            Salida_E SE ON RE.IDRequisicionE = SE.ID_ReqE
        LEFT JOIN 
            Salida_D SD ON SE.Id_SalE = SD.Id AND SD.IdCProd = RD.IdCProd AND SD.IdTallas = RD.IdTalla
        INNER JOIN 
            Producto P ON RD.IdCProd = P.IdCProducto
        INNER JOIN 
            Ctallas CT ON RD.IdTalla = CT.IdCTallas
        WHERE 
            RE.IDRequisicionE = ?
        GROUP BY 
            RE.IDRequisicionE, RD.IdCProd, RD.IdCProd, RD.Cantidad, CT.Talla";

    // Prepara la consulta
    $StmtRequisicionDProductosPendientes = $conexion->prepare($SetenciaRequisicionDProductosPendientes);

    // Vincular parámetros
    $StmtRequisicionDProductosPendientes->bind_param("i", $ID_Requisicion);

    // Ejecutar la consulta
    $StmtRequisicionDProductosPendientes->execute();

    // Obtener los resultados
    $ResultadoRequisicionDProductosPendientes = $StmtRequisicionDProductosPendientes->get_result();

    $data = []; // Inicializar un arreglo para almacenar los datos

    // Recorrer los resultados
    while ($fila = $ResultadoRequisicionDProductosPendientes->fetch_assoc()) {
        if ($fila['Cantidad_Salida'] < $fila['Cantidad_Solicitada']) { // Si la cantidad solicitada es mayor que la cantidad salida
            // Agregar el producto incompleto al arreglo
            $data[] = [
                'IdCProd' => $fila['Identificador_Producto'],
                'IdTalla' => $fila['Identificador_Talla'],
                'Cantidad' => $fila['Cantidad_Solicitada'] - $fila['Cantidad_Salida']
            ];
        }
    }

    return !empty($data) ? $data : null; // Devuelve el arreglo de productos incompletos o null si no hay productos incompletos
}
?>