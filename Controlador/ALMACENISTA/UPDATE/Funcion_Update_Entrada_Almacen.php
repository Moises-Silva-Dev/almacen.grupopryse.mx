<?php
// Iniciamos sesión
session_start();

// Configuración regional y zona horaria
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/Mexico_City');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conectar a la base de datos 
    include('../../../Modelo/Conexion.php'); 
    $conexion = (new Conectar())->conexion();

    // Obtener datos del formulario
    $id_EntradaD = $_POST['id'];
    $id_EntradaE = $_POST['IdEntE'];
    $Proveedor = $_POST['Proveedor'];
    $Receptor = $_POST['Receptor'];
    $Comentarios = $_POST['Comentarios'];
    $estatus = 'Modificado';
    $nuevoNumeroModif = intval($_POST['Nro_Modif']) + 1;
    $registro = date('Y-m-d H:i:s', time()); // Obtiene la fecha y hora actual

    // Comienza la transacción
    $conexion->begin_transaction();

    try {
        if (actualizarEntrada($conexion, $registro, $nuevoNumeroModif, $Proveedor, $Receptor, $Comentarios, $estatus, $id_EntradaE)) {
            
            // Eliminar la entrada en la tabla EntradaD
            eliminarEntradaD($conexion, $id_EntradaE);
            
            // Confirmar la transacción
            $conexion->commit();

            // Éxito: redirige o muestra un mensaje
            echo '<script type="text/javascript">';
            echo 'alert("¡Registro modificado exitosamente!");';
            echo 'window.location = "../../../Vista/ALMACENISTA/Almacen_ALMACENISTA.php";';
            echo '</script>';
            exit();
        } else {
            // Lanzar una excepción para activar el bloque catch
            throw new Exception("Error al intentar modificar el registro.");
        }
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();

        // Muestra un mensaje de error
        echo '<script type="text/javascript">';
        echo 'alert("Error: ' . $e->getMessage() . '");';
        echo 'window.location = "../../../Vista/ALMACENISTA/Almacen_ALMACENISTA.php";';
        echo '</script>';
        exit();
    } finally {
        // Cierra la conexión
        $conexion->close();
    }
} else {
    // Si no es una solicitud POST, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: Acceso no permitido.");';
    echo 'window.location = "../../../Vista/ALMACENISTA/Almacen_ALMACENISTA.php";';
    echo '</script>';
    exit();
}

// Función para actualizar la entrada
function actualizarEntrada($conexion, $registro, $nuevoNumeroModif, $Proveedor, $Receptor, $Comentarios, $estatus, $id_EntradaE) {
    // Preparar la consulta SQL para actualizar la entrada
    $sql = "UPDATE EntradaE SET 
            Fecha_Modificacion = ?, 
            Nro_Modif = ?, 
            Proveedor = ?, 
            Receptor = ?, 
            Comentarios = ?, 
            Estatus = ? 
            WHERE IdEntE = ?";

    // Preparar la sentencia
    $stmt = $conexion->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("sissssi", $registro, $nuevoNumeroModif, $Proveedor, $Receptor, $Comentarios, $estatus, $id_EntradaE);

    // Ejecutar la consulta
    return $stmt->execute();
}

// Función para insertar registros en la tabla EntradaD
function insertarEntradaD($conexion, $id_EntradaE, $idProducto, $idtall, $cant) {
    // Prepara la consulta
    $sql = "INSERT INTO EntradaD (IdEntradaE, IdProd, IdTalla, Cantidad) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    // Vincula los parámetros y ejecuta la consulta
    $stmt->bind_param("iiii", $id_EntradaE, $idProducto, $idtall, $cant);
    return $stmt->execute();
}

// Función para insertar o actualizar inventario
function insertarInventario($conexion, $idProducto, $idtall, $cant) {
    // Buscar en el inventario
    $Busqueda = BuscarInventario($conexion, $idProducto, $idtall);
    
    if ($Busqueda) {
        // Actualizar la cantidad si el producto ya existe
        $SQLUpdateI = "UPDATE Inventario SET Cantidad = Cantidad + ? WHERE IdInv = ?;";
        $stmtI = $conexion->prepare($SQLUpdateI);
        $stmtI->bind_param("ii", $cant, $Busqueda['IdInv']);
        return $stmtI->execute();
    } else {
        // Insertar un nuevo registro si el producto no existe
        $idProducto = (int)$idProducto;
        $sql = "INSERT INTO Inventario (IdCPro, IdCTal, Cantidad) VALUES (?,?,?);";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iii", $idProducto, $idtall, $cant);
        return $stmt->execute();
    }
}

// Función para buscar en el inventario
function BuscarInventario($conexion, $idProducto, $idtall) {
    $consulta = $conexion->prepare("SELECT IdInv, Cantidad FROM Inventario WHERE IdCPro = ? AND IdCTal = ?;");
    $consulta->bind_param("ii", $idProducto, $idtall);
    $consulta->execute();
    $resultado = $consulta->get_result();
    return $resultado->fetch_assoc();
}

// Función para eliminar registros de la tabla EntradaD
function eliminarEntradaD($conexion, $id_EntradaE){
    $eliminar = $conexion->prepare("DELETE FROM EntradaD WHERE IdEntradaE = ?");
    $eliminar->bind_param("i", $id_EntradaE);
    $eliminar->execute();
    
    // Verifica si $_POST['datosTabla'] está definido
    if (isset($_POST['datosTabla'])) {
        // Decodifica los datos del formulario
        $datosTabla = json_decode($_POST['datosTabla'], true);
        
        // Verifica si la decodificación fue exitosa
        if (json_last_error() === JSON_ERROR_NONE) {
            // Obtiene la cantidad de filas en los datos de la tabla
            $numFilas = count($datosTabla);
        
            // Itera sobre los datos de la tabla oculta utilizando un bucle for
            for ($i = 0; $i < $numFilas; $i++) {
                $idProducto = $datosTabla[$i]['idProduct'];
                $idtall = $datosTabla[$i]['idtall'];
                $cant = $datosTabla[$i]['cant'];
                    
                // Inserta en la tabla EntradaD
                if (!insertarEntradaD($conexion, $id_EntradaE, $idProducto, $idtall, $cant)) {
                    throw new Exception("Error al insertar en EntradaD");
                }

                // Inserta en la tabla Inventario
                if (!insertarInventario($conexion, $idProducto, $idtall, $cant)){
                    throw new Exception("Error al insertar en Inventario");
                }
            }
        } else {
            // Maneja el caso en el que $_POST['datosTabla'] no es un JSON válido
            throw new Exception("Los datos de la tabla no están en el formato JSON esperado.");
        }
    } else {
        // Maneja el caso en el que $_POST['datosTabla'] no está definido
        throw new Exception("No se recibieron datos de la tabla.");
    }
}
?>