<?php
// Iniciamos sesión
session_start();

function eliminarRegistroCentroTrabajo($id_registro) {
    // Verificar si se proporciona un ID válido
    if (!isset($id_registro) || empty($id_registro) || !is_numeric($id_registro) || $id_registro <= 0) {
        return "Error: El ID proporcionado no es válido.";
    }

    // Conectar a la base de datos
    include('../../../Modelo/Conexion.php'); 

    try {
        // Intentar establecer la conexión
        $conexion = (new Conectar())->conexion();

        if ($conexion->connect_error) {
            throw new Exception("Error de conexión a la base de datos: " . $conexion->connect_error);
        }

        // Comienza la transacción
        $conexion->begin_transaction();

        // Preparar la consulta SQL para eliminar el registro del centro de trabajo
        $sql = "DELETE FROM Centro_Trabajo WHERE ID_Centro = ?";

        // Preparar la sentencia
        $stmt = $conexion->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $conexion->error);
        }

        // Vincular parámetros
        $stmt->bind_param("i", $id_registro);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Éxito: commit la transacción
            $conexion->commit();

            // Cerrar la conexión y la sentencia
            $stmt->close();
            $conexion->close();
            return "¡Registro eliminado exitosamente!";
        } else {
            // Error: rollback la transacción
            $conexion->rollback();

            // Cerrar la conexión y la sentencia
            $stmt->close();
            $conexion->close();
            return "Error al intentar eliminar el registro: " . $conexion->error;
        }
    } catch (Exception $e) {
        // Manejar la excepción
        return "Error: " . $e->getMessage();
    }
}

// Verificar si se proporciona un ID a través de GET
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id_registro = $_GET['id'];
    $mensaje = eliminarRegistroCentroTrabajo($id_registro);

    echo '<script type="text/javascript">';
    echo 'alert("' . $mensaje . '");';
    echo 'window.location = "../../../Vista/DEV/Centro_Trabajo_Dev.php";';
    echo '</script>';
    exit();
} else {
    // Si no se proporciona el ID, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: No se proporcionó un ID válido.");';
    echo 'window.location = "../../../Vista/DEV/Centro_Trabajo_Dev.php";';
    echo '</script>';
    exit();
}
?>