<?php
// Iniciamos sesión
session_start();

function eliminarColaborador($id_colaborador) {
    // Verificar si se proporciona un ID válido
    if (!isset($id_colaborador) || empty($id_colaborador) || !is_numeric($id_colaborador) || $id_colaborador <= 0) {
        return "Error: El ID del colaborador proporcionado no es válido.";
    }

    // Conectar a la base de datos
    include('../../../Modelo/Conexion.php'); 

    try {
        // Intentar establecer la conexión
        $conexion = (new Conectar())->conexion();

        // Verificar la conexión
        if ($conexion->connect_error) {
            throw new Exception("Error de conexión a la base de datos: " . $conexion->connect_error);
        }

        // Comenzar la transacción
        $conexion->begin_transaction();

        // Preparar la consulta SQL para eliminar el colaborador
        $sql = "DELETE FROM Colaborador WHERE ID_Colaborador = ?";

        // Preparar la sentencia
        $stmt = $conexion->prepare($sql);

        // Verificar si la sentencia preparada se creó correctamente
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $conexion->error);
        }

        // Vincular parámetros
        $stmt->bind_param("i", $id_colaborador);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Éxito: commit la transacción
            $conexion->commit();

            // Cerrar la conexión y la sentencia
            $stmt->close();
            $conexion->close();
            return "¡Colaborador eliminado exitosamente!";
        } else {
            // Error: rollback la transacción
            $conexion->rollback();

            // Cerrar la conexión y la sentencia
            $stmt->close();
            $conexion->close();
            return "Error al intentar eliminar el colaborador: " . $conexion->error;
        }
    } catch (Exception $e) {
        // Manejar la excepción
        return "Error: " . $e->getMessage();
    }
}

// Verificar si se proporciona un ID a través de GET
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id_colaborador = $_GET['id'];
    $mensaje = eliminarColaborador($id_colaborador);

    echo '<script type="text/javascript">';
    echo 'alert("' . $mensaje . '");';
    echo 'window.location = "../../../Vista/DEV/Colaboradores_Dev.php";';
    echo '</script>';
    exit();
} else {
    // Si no se proporciona el ID, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: No se proporcionó un ID válido.");';
    echo 'window.location = "../../../Vista/DEV/Colaboradores_Dev.php";';
    echo '</script>';
    exit();
}
?>