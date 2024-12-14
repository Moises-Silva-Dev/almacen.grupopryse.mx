<?php
// Iniciamos sesión
session_start();

function cambiarEstatusSolicitud($idSolicitud) {
    // Verifica si se proporciona un ID válido
    if (!isset($idSolicitud) || empty($idSolicitud) || !is_numeric($idSolicitud) || $idSolicitud <= 0) {
        return "Error: El ID de la entrada proporcionado no es válido.";
    }

    // Incluye el archivo de conexión 
    include('../../../Modelo/Conexion.php');
    // Intentar establecer la conexión
    $conexion = (new Conectar())->conexion();

    // Verifica la conexión
    if ($conexion->connect_error) {
        return "Error de conexión a la base de datos: " . $conexion->connect_error;
    }

    try {
        //Eliminar Informacion de Tabla Borrador_RequisicionD
        EliminarBorradorRequisicionD($conexion, $idSolicitud);
        //Eliminar Informacion de Tabla Borrador_RequisicionE
        EliminarBorradorRequisicionE($conexion, $idSolicitud);

        //Retornar mensaje
        return "¡Requisicion Eliminado exitosamente!";
    } catch (Exception $e) {
        // Maneja la excepción
        return "Error: " . $e->getMessage();
    } finally {
        $conexion->close();
    }
}

function EliminarBorradorRequisicionD($conexion, $idSolicitud) {
    // Preparar la consulta SQL para eliminar el registro
    $sqlD = "DELETE FROM Borrador_RequisicionD WHERE BIdReqE = ?;";
    // Preparar la sentencia
    $stmtD = $conexion->prepare($sqlD);
    // Vincular parámetros
    $stmtD->bind_param("i", $idSolicitud);
    // Ejecutar la consulta
    $stmtD->execute();
    // Cerrar la sentencia
    $stmtD->close();
}

function EliminarBorradorRequisicionE($conexion, $idSolicitud) {
    // Preparar la consulta SQL para eliminar el registro
    $sqlE = "DELETE FROM Borrador_RequisicionE WHERE BIDRequisicionE = ?;";
    // Preparar la sentencia
    $stmtE = $conexion->prepare($sqlE);
    // Vincular parámetros
    $stmtE->bind_param("i", $idSolicitud);
    // Ejecutar la consulta
    $stmtE->execute();
    // Cerrar la sentencia
    $stmtE->close();
}

// Verifica si se proporciona un ID a través de GET
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    // Variable
    $idSolicitud = $_GET['id'];

    // Retorna el mensaje
    $mensaje = cambiarEstatusSolicitud($idSolicitud);

    //Mostrar Notificación
    echo '<script type="text/javascript">';
    echo 'alert("' . $mensaje . '");';
    echo 'window.location = "../../../Vista/ADMIN/Solicitud_ADMIN.php";';
    echo '</script>';
    exit();
} else {
    // Si no se proporciona el ID, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: No se proporcionó un ID válido.");';
    echo 'window.location = "../../../Vista/ADMIN/Solicitud_ADMIN.php";';
    echo '</script>';
    exit();
}
?>