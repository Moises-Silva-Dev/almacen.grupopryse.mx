<?php
// Iniciamos sesión
session_start();
date_default_timezone_set('America/Mexico_City');

// Función para obtener la conexión a la base de datos
function obtenerConexion() {
    include('../../../Modelo/Conexion.php');
    return (new Conectar())->conexion();
}

// Función para obtener el ID del usuario a partir del correo electrónico
function obtenerIDUsuario($conexion, $usuario) {
    $consulta = $conexion->prepare("SELECT ID_Usuario FROM Usuario WHERE Correo_Electronico = ?;");
    $consulta->bind_param("s", $usuario);
    $consulta->execute();
    $resultado = $consulta->get_result();
    $fila = $resultado->fetch_assoc();
    return $fila['ID_Usuario'];
}

// Función para insertar la entrada en la tabla EntradaE
function insertarEntradaE($conexion, $usuario, $Proveedor, $Receptor, $Comentarios, $estatus) {
    $registro = date('Y-m-d H:i:s');
    $sql = "INSERT INTO EntradaE (Fecha_Creacion, Usuario_Creacion, Proveedor, Receptor, Comentarios, Estatus) VALUES (?,?,?,?,?,?);";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssss", $registro, $usuario, $Proveedor, $Receptor, $Comentarios, $estatus);
    $stmt->execute();
    return $conexion->insert_id;
}

// Función para insertar la entrada en la tabla EntradaD
function insertarEntradaD($conexion, $EntradaE, $idProducto, $idtall, $cant) {
    $EntradaE = (int)$EntradaE;
    $idProducto = (int)$idProducto;
    $sql = "INSERT INTO EntradaD (IdEntradaE, IdProd, IdTalla, Cantidad) VALUES (?,?,?,?);";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iiii", $EntradaE, $idProducto, $idtall, $cant);
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
    $fila = $resultado->fetch_assoc();
    return $fila;
}

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = obtenerConexion();

    try {
        // Comenzar la transacción
        $conexion->begin_transaction();

        // Recuperar datos del formulario
        $Proveedor = $_POST["Proveedor"];
        $Receptor = $_POST["Receptor"];
        $Comentarios = $_POST['Comentarios'];
        $estatus = 'Creada';

        $usuario = $_SESSION['usuario'];
        $ID_Usuario = obtenerIDUsuario($conexion, $usuario);

        $EntradaE = insertarEntradaE($conexion, $ID_Usuario, $Proveedor, $Receptor, $Comentarios, $estatus);

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
                    if (!insertarEntradaD($conexion, $EntradaE, $idProducto, $idtall, $cant)) {
                        throw new Exception("Error al insertar en EntradaD");
                    }

                    // Inserta en la tabla Inventario
                    if (!insertarInventario($conexion, $idProducto, $idtall, $cant)){
                        throw new Exception("Error al insertar en Inventario");
                    }
                }

                // Confirmar la transacción
                $conexion->commit();

                // Éxito: redirige o muestra un mensaje
                echo '<script type="text/javascript">';
                echo 'alert("¡¡El Registro fue Exitoso!!");';
                echo 'window.location = "../../../Vista/ALMACENISTA/Almacen_ALMACENISTA.php";';
                echo '</script>';
                exit();
            } else {
                throw new Exception("Los datos de la tabla no están en el formato JSON esperado.");
            }
        } else {
            throw new Exception("No se recibieron datos de la tabla.");
        }
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();

        // Muestra un mensaje de error
        echo '<script type="text/javascript">';
        echo 'alert("ERROR: ' . $e->getMessage() . '");';
        echo 'window.location = "../../../Vista/ALMACENISTA/INSERT/Insert_Almacen_ALMACENISTA.php";';
        echo '</script>';
        exit();
    } finally {
        // Cierra la conexión
        $conexion->close();
    }
}
?>