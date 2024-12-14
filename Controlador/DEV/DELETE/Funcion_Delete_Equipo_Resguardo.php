<?php
// Iniciamos sesión
session_start();

function eliminarEquipoRespaldo($id_equipo) {
    // Verificar si se proporciona un ID válido
    if (!isset($id_equipo) || empty($id_equipo) || !is_numeric($id_equipo) || $id_equipo <= 0) {
        return "Error: El ID del equipo de respaldo proporcionado no es válido.";
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

        // Comienza la transacción
        $conexion->begin_transaction();

        // Preparar la consulta SQL para eliminar el equipo de respaldo
        $sql = "DELETE FROM Respaldo_Equipo WHERE ID_Equipo = ?";

        // Preparar la sentencia
        $stmt = $conexion->prepare($sql);

        // Verificar si la sentencia preparada se creó correctamente
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $conexion->error);
        }

        // Vincular parámetros
        $stmt->bind_param("i", $id_equipo);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Éxito: commit la transacción
            $conexion->commit();

            // Cerrar la conexión y la sentencia
            $stmt->close();
            $conexion->close();

            return "¡Equipo de respaldo eliminado exitosamente!";
        } else {
            // Error: rollback la transacción
            $conexion->rollback();

            // Cerrar la conexión y la sentencia
            $stmt->close();
            $conexion->close();

            return "Error al intentar eliminar el equipo de respaldo: " . $conexion->error;
        }
    } catch (Exception $e) {
        // Manejar la excepción
        return "Error: " . $e->getMessage();
    }
}

// Verificar si es una solicitud GET válida y si se proporciona un ID
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id_equipo = $_GET['id'];
    $mensaje = eliminarEquipoRespaldo($id_equipo);

    echo '<script type="text/javascript">';
    echo 'alert("' . $mensaje . '");';
    echo 'window.location = "../../../Vista/DEV/Resguardo_Equipo_Dev.php";';
    echo '</script>';
    exit();
} else {
    // Si no es una solicitud GET válida, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: Acceso no permitido.");';
    echo 'window.location = "../../../Vista/DEV/Resguardo_Equipo_Dev.php";';
    echo '</script>';
    exit();
}
?>