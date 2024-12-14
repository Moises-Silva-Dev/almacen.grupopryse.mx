<?php
// Iniciamos sesión
session_start();

function eliminarProducto($id_registro) {
    // Verificar si se proporciona un ID válido
    if (!isset($id_registro) || empty($id_registro) || !is_numeric($id_registro) || $id_registro <= 0) {
        return "Error: El ID del producto proporcionado no es válido.";
    }

    // Conectar a la base de datos 
    include('../../../Modelo/Conexion.php'); 
    $conexion = (new Conectar())->conexion();

    // Verificar la conexión
    if ($conexion->connect_error) {
        return "Error de conexión a la base de datos: " . $conexion->connect_error;
    }

    // Obtener la información del archivo y la carpeta antes de eliminar el registro
    $sql_info = "SELECT IMG FROM Producto WHERE IdCProducto = ?";
    $stmt_info = $conexion->prepare($sql_info);
    $stmt_info->bind_param("i", $id_registro);
    $stmt_info->execute();
    $stmt_info->bind_result($IMG);
    $stmt_info->fetch();
    $stmt_info->close();

    // Comienza la transacción
    $conexion->begin_transaction();

    try {
        // Eliminar el registro de la base de datos
        $sql_eliminar_producto = "DELETE FROM Producto WHERE IdCProducto = ?";
        $stmt_eliminar_producto = $conexion->prepare($sql_eliminar_producto);
        $stmt_eliminar_producto->bind_param("i", $id_registro);
        
        if ($stmt_eliminar_producto->execute()) {
            // Éxito: elimina también la imagen y la carpeta
            unlink($IMG); // Elimina el archivo
            // Confirma la transacción
            $conexion->commit();
            return "¡Registro y archivos asociados eliminados exitosamente!";
        } else {
            // Error: Revierte la transacción en caso de error
            $conexion->rollback();
            return "Error al intentar eliminar el registro.";
        }
    } catch (Exception $e) {
        // Revierte la transacción en caso de excepción
        $conexion->rollback();
        return "Error al intentar eliminar el registro. " . $e->getMessage();
    } finally {
        // Finaliza la transacción
        $conexion->autocommit(TRUE);
    }

    // Cierra la conexión y la sentencia
    $stmt_eliminar_producto->close();
    $conexion->close();
}

// Verificar si se proporciona un ID a través de GET
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id_registro = $_GET['id'];
    $mensaje = eliminarProducto($id_registro);

    echo '<script type="text/javascript">';
    echo 'alert("' . $mensaje . '");';
    echo 'window.location = "../../../Vista/DEV/Producto_Dev.php";';
    echo '</script>';
    exit();
} else {
    // Si no se proporciona el ID, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: No se proporcionó un ID válido.");';
    echo 'window.location = "../../../Vista/DEV/Producto_Dev.php";';
    echo '</script>';
    exit();
}
?>