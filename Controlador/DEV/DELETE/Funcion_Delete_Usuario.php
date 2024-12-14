<?php
// Iniciamos sesión
session_start();

function eliminarUsuario($id_usuario) {
    // Verificar si se proporciona un ID válido
    if (!isset($id_usuario) || empty($id_usuario) || !is_numeric($id_usuario) || $id_usuario <= 0) {
        return "Error: El ID de usuario proporcionado no es válido.";
    }

    // Conectar a la base de datos
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();

    try {
        // Iniciar transacción
        $conexion->begin_transaction();

        // Eliminar entradas relacionadas en Usuario_Cuenta
        $sql = "DELETE FROM Usuario_Cuenta WHERE ID_Usuarios = ?";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta para Usuario_Cuenta: " . $conexion->error);
        }
        $stmt->bind_param("i", $id_usuario);
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta para Usuario_Cuenta.");
        }
        $stmt->close();

        // Eliminar el usuario principal
        $sql = "DELETE FROM Usuario WHERE ID_Usuario = ?";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta para Usuario: " . $conexion->error);
        }
        $stmt->bind_param("i", $id_usuario);
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta para Usuario.");
        }
        $stmt->close();

        // Confirmar transacción
        $conexion->commit();
        $conexion->close();
        return "¡Registro eliminado exitosamente!";
    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $conexion->rollback();
        return "Error: " . $e->getMessage();
    }
}

// Verificar si se proporciona un ID a través de GET
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id_usuario = $_GET['id'];
    $mensaje = eliminarUsuario($id_usuario);

    echo '<script type="text/javascript">';
    echo 'alert("' . $mensaje . '");';
    echo 'window.location = "../../../Vista/DEV/Registro_Usuario_Dev.php";'; // Redirigir a la página de usuarios después de la operación
    echo '</script>';
    exit();
} else {
    // Si no se proporciona el ID, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: No se proporcionó un ID válido.");';
    echo 'window.location = "../../../Vista/DEV/Registro_Usuario_Dev.php";'; // Redirigir a la página de usuarios en caso de error
    echo '</script>';
    exit();
}
?>