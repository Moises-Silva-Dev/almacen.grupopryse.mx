<?php
// Iniciamos sesión
session_start();
date_default_timezone_set('America/Mexico_City');

function cambiarEstatusSolicitud($idSolicitud, $fecha_alta) {
    // Verifica si se proporciona un ID válido
    if (!isset($idSolicitud) || empty($idSolicitud) || !is_numeric($idSolicitud) || $idSolicitud <= 0) {
        return "Error: El ID de la entrada proporcionado no es válido.";
    }

    // Incluye el archivo de conexión 
    include('../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();

    // Verifica la conexión
    if ($conexion->connect_error) {
        return "Error de conexión a la base de datos: " . $conexion->connect_error;
    }

    try {
        // Prepara la consulta SQL para cambiar el estatus a "Autorizado"
        $sql = "UPDATE RequisicionE SET Estatus = 'Autorizado', FchAutoriza = '$fecha_alta' WHERE IDRequisicionE = ?";

        // Prepara la sentencia
        $stmt = $conexion->prepare($sql);

        // Vincula parámetros
        $stmt->bind_param("i", $idSolicitud);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            $stmt->close();
            $conexion->close();
            return "¡Estatus cambiado a 'Autorizado' exitosamente!";
        } else {
            $stmt->close();
            $conexion->close();
            return "Error al intentar cambiar el estatus de la entrada.";
        }
    } catch (Exception $e) {
        // Maneja la excepción
        return "Error: " . $e->getMessage();
    }
}

// Verifica si se proporciona un ID a través de POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Id'])) {
    $idSolicitud = $_POST['Id'];
    $fecha_alta = date('Y-m-d H:i:s'); // Obtener la fecha y hora actual
    $mensaje = cambiarEstatusSolicitud($idSolicitud, $fecha_alta);

    echo '<script type="text/javascript">';
    echo 'alert("' . $mensaje . '");';
    echo 'window.location = "../../Vista/DEV/Solicitud_Dev.php";'; // Reemplaza con la ruta de redirección deseada
    echo '</script>';
    exit();
} else {
    // Si no se proporciona el ID, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: No se proporcionó un ID válido.");';
    echo 'window.location = "../../Vista/DEV/Solicitud_Dev.php";'; // Reemplaza con la ruta de redirección de error deseada
    echo '</script>';
    exit();
}
?>