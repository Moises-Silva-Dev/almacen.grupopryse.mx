<?php
// Función para insertar o actualizar inventario
function insertarInventario($conexion, $idProducto, $idtall, $cant) {
    // Buscar en el inventario
    $Busqueda = BuscarProductoInventario($conexion, $idProducto, $idtall);
    
    if ($Busqueda) {
        // Consulta para actualizar el inventario
        $SetenciaActualizaInventario = "UPDATE Inventario SET Cantidad = Cantidad + ? WHERE IdInv = ?";

        // Preparar la consulta
        $StmtActualizaInventario = $conexion->prepare($SetenciaActualizaInventario);

        // Ejecutar la consulta
        $StmtActualizaInventario->bind_param("ii", $cant, $Busqueda['IdInv']);

        // Ejecutar la consulta
        if ($StmtActualizaInventario->execute()) {
            return true;
        } else {
            // Lanzar una excepción para activar el bloque catch
            throw new Exception("Error en la ejecución de la actualización en inventario.");
        }
    } else {
        // Insertar un nuevo registro si el producto no existe
        $SetenciaInsertarNuevoInventario = "INSERT INTO Inventario (IdCPro, IdCTal, Cantidad) VALUES (?,?,?)";

        // Preparar la consulta
        $StmtInsertarNuevoInventario = $conexion->prepare($SetenciaInsertarNuevoInventario);

        // Ejecutar la consulta
        $StmtInsertarNuevoInventario->bind_param("iii", $idProducto, $idtall, $cant);

        // Ejecutar la consulta
        if ($StmtInsertarNuevoInventario->execute()) {
            return true;
        } else {
            // Lanzar una excepción para activar el bloque catch
            throw new Exception("Error en la ejecución de la inserción en inventario.");
        }
    }
}

// Función para buscar en el inventario
function BuscarProductoInventario($conexion, $idProducto, $idtall) {
    // Buscar en el inventario
    $SetenciaBusquedaInventario = "SELECT IdInv, Cantidad FROM Inventario WHERE IdCPro = ? AND IdCTal = ?";
    
    // Preparar la sentencia
    $StmtBusquedaInventario = $conexion->prepare($SetenciaBusquedaInventario);
    
    // Enlazar los parámetros
    $StmtBusquedaInventario->bind_param("ii", $idProducto, $idtall);
    
    // Ejecutar la sentencia
    if ($StmtBusquedaInventario->execute()) {
        // Obtener los resultados
        $ResultadoBusquedaInventario = $StmtBusquedaInventario->get_result();

        // Verificar si hay resultados
        $fila = $ResultadoBusquedaInventario->fetch_assoc();

        return $fila; // Devuelve el resultado
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la busqueda en inventario.");
    }
}

// Función para actualizar el inventario
function ActualizarInventarioPorSalidaRequisicion($conexion, $Cant, $IdCProd, $Id_Talla) {
    // Consulta para actualizar el inventario
    $SetenciaActualizarInventarioPorSalidaRequisicion = "UPDATE Inventario SET Cantidad = Cantidad - ? WHERE IdCPro = ? AND IdCTal = ?";

    // Preparar la sentencia
    $StmtActualizarInventarioPorSalidaRequisicion = $conexion->prepare($SetenciaActualizarInventarioPorSalidaRequisicion);

    // Ejecutar la sentencia
    $StmtActualizarInventarioPorSalidaRequisicion->bind_param("iii", $Cant, $IdCProd, $Id_Talla);

    // Ejecutar la sentencia
    if ($StmtActualizarInventarioPorSalidaRequisicion->execute()){ 
        return true; // Si se ejecuta correctamente, devuelve true
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de inserción.");
    }
}

// Función para actualizar el inventario
function ActualizarInventario($conexion, $InformacionEntradaD){
    // Consulta para actualizar el inventario
    $SetenciaActualizarInventario = "UPDATE Inventario SET Cantidad = Cantidad - ? WHERE IdCPro = ? AND IdCTal = ?";

    // Preparar la sentencia
    $StmtActualizarInventario = $conexion->prepare($SetenciaActualizarInventario);

    // Obtiene la cantidad de filas en los datos de la tabla
    $numFilas = count($InformacionEntradaD);

    // Inicializa una variable para rastrear el éxito de la inserción
    $exito = true;

    // Recorre cada registro en InformacionRequisicionD y ejecuta la consulta 
    for ($i = 0; $i < $numFilas; $i++) {
        $idProductoEntradaD = intval($InformacionEntradaD[$i]['IdProd']);
        $idtallEntradaD = intval($InformacionEntradaD[$i]['IdTalla']);
        $cantEntradaD = intval($InformacionEntradaD[$i]['Cantidad']);
    
        // Vincular los parámetros
        $StmtActualizarInventario->bind_param("iii", $cantEntradaD, $idProductoEntradaD, $idtallEntradaD);
            
        // Si alguna inserción falla, cambia la variable de éxito a false
        if (!$StmtActualizarInventario->execute()) {
            $exito = false;
            break;
        }
    }

    // Retorna true si todas las inserciones fueron exitosas, de lo contrario false
    return $exito;
}
?>