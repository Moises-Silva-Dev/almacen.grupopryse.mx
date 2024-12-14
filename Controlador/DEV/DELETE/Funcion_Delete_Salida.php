<?php
// Iniciar sesión
session_start();
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/Mexico_City');

include('../../../Modelo/Conexion.php');
$conexion = (new Conectar())->conexion();

function obtenerIdSalidaE($conexion, $id) {
    $sql = "SELECT Id_SalE FROM Salida_D INNER JOIN Salida_E ON Salida_D.Id = Salida_E.Id_SalE WHERE Salida_E.ID_ReqE = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function eliminarSalidaD($conexion, $idSalidaE) {
    $sqlEliminarSalidaD = $conexion->prepare("DELETE FROM Salida_D WHERE Id = ?");
    $sqlEliminarSalidaD->bind_param("i", $idSalidaE);
    $sqlEliminarSalidaD->execute();
    $sqlEliminarSalidaD->close();
}

function eliminarSalidaE($conexion, $idSalidaE) {
    $sqlEliminarSalidaE = $conexion->prepare("DELETE FROM Salida_E WHERE Id_SalE = ?");
    $sqlEliminarSalidaE->bind_param("i", $idSalidaE);
    $sqlEliminarSalidaE->execute();
    $sqlEliminarSalidaE->close();
}

try {
    $conexion->begin_transaction(); // Iniciar transacción

    // Consulta SQL para seleccionar Id_SalE de Salida_D según el ID_ReqE
    $id = $_GET['id'];    
    $result = obtenerIdSalidaE($conexion, $id);
    
    // Eliminar registros de la tabla Salida_D y Salida_E
    while ($row = $result->fetch_assoc()) {
        $idSalidaE = $row['Id_SalE'];
        eliminarSalidaD($conexion, $idSalidaE);
        eliminarSalidaE($conexion, $idSalidaE);
    }

    // Commit de la transacción
    $conexion->commit();

    // Redirigir a una página de éxito o mostrar un mensaje de éxito
    echo '<script type="text/javascript">';
    echo 'alert("¡Los registros fueron eliminados exitosamente!");';
    echo 'window.location = "../../../Vista/DEV/Salidas_Dev.php";'; // Reemplazar con la ruta de redirección deseada
    echo '</script>';
    exit();
} catch (Exception $e) {
    // Revertir transacción en caso de error
    $conexion->rollback();
    echo '<script type="text/javascript">';
    echo 'alert("Ha ocurrido un error al eliminar los registros de Salida_D y Salida_E. Por favor, inténtelo de nuevo.");';
    echo 'window.location = "../../../Vista/DEV/Salidas_Dev.php";'; // Reemplazar con la ruta de redirección deseada
    echo '</script>';
    exit();
}
?>