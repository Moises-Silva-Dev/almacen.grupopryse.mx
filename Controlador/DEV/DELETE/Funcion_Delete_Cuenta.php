<?php
// Iniciamos sesión
session_start();

function eliminarRegistroCuenta($id_cuenta) {
    // Verifica si se proporciona un ID válido
    if (!isset($id_cuenta) || empty($id_cuenta) || !is_numeric($id_cuenta) || $id_cuenta <= 0) {
        return "Error: El ID de la región proporcionado no es válido.";
    }

    // Incluye el archivo de conexión 
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();

    // Verifica la conexión
    if ($conexion->connect_error) {
        return "Error de conexión a la base de datos: " . $conexion->connect_error;
    }

    try {
        // Comienza la transacción
        $conexion->begin_transaction();

        // Prepara la consulta SQL para eliminar el registro
        $sql = "DELETE FROM Cuenta WHERE ID = ?";

        // Prepara la sentencia
        $stmt = $conexion->prepare($sql);

        // Vincula parámetros
        $stmt->bind_param("i", $id_cuenta);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Éxito: confirma la transacción
            $conexion->commit();
            $stmt->close();
            $conexion->close();
            return "¡Registro eliminado exitosamente!";
        } else {
            // Error: revierte la transacción
            $conexion->rollback();
            $stmt->close();
            $conexion->close();
            return "Error al intentar eliminar el registro.";
        }
    } catch (Exception $e) {
        // Maneja la excepción
        return "Error: " . $e->getMessage();
    }
}

// Verifica si se proporciona un ID a través de GET
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id_cuenta = $_GET['id'];
    $mensaje = eliminarRegistroCuenta($id_cuenta);

    echo '<script type="text/javascript">';
    echo 'alert("' . $mensaje . '");';
    echo 'window.location = "../../../Vista/DEV/Cuenta_Dev.php";'; // Reemplaza con la ruta de redirección deseada
    echo '</script>';
    exit();
} else {
    // Si no se proporciona el ID, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: No se proporcionó un ID válido.");';
    echo 'window.location = "../../../Vista/DEV/Cuenta_Dev.php";'; // Reemplaza con la ruta de redirección de error deseada
    echo '</script>';
    exit();
}
?>