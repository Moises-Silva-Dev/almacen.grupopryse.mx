<?php
// Iniciamos sesión
session_start();

function eliminarRegistroRegion($id_region) {
    // Verifica si se proporciona un ID válido
    if (!isset($id_region) || empty($id_region) || !is_numeric($id_region) || $id_region <= 0) {
        return "Error: El ID de la región proporcionado no es válido.";
    }

    include('../../../Modelo/Conexion.php');    // Incluye el archivo de conexión 
    $conexion = (new Conectar())->conexion();

    // Verifica la conexión
    if ($conexion->connect_error) {
        return "Error de conexión a la base de datos: " . $conexion->connect_error;
    }

    try {
        // Comienza la transacción
        $conexion->begin_transaction();
        
        // eliminar registros Cuenta_Region
        deleteCuentaRegion($conexion, $id_region);
        
        // eliminar registros Estado_Region
        deleteEstadoRegion($conexion, $id_region);

        // Prepara la consulta SQL para eliminar el registro
        $sql = "DELETE FROM Regiones WHERE ID_Region = ?";

        // Prepara la sentencia
        $stmt = $conexion->prepare($sql);

        // Vincula parámetros
        $stmt->bind_param("i", $id_region);

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

function deleteEstadoRegion($conexion, $id_region) {
    $sql = "DELETE FROM Estado_Region WHERE ID_Regiones = ?;";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_region);
    return $stmt->execute();
}

function deleteCuentaRegion($conexion, $id_region) {
    $sql = "DELETE FROM Cuenta_Region WHERE ID_Regiones = ?;";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_region);
    return $stmt->execute();
}

// Verifica si se proporciona un ID a través de GET
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id_region = $_GET['id'];
    $mensaje = eliminarRegistroRegion($id_region);

    echo '<script type="text/javascript">';
    echo 'alert("' . $mensaje . '");';
    echo 'window.location = "../../../Vista/DEV/Regiones_Dev.php";'; // Reemplaza con la ruta de redirección deseada
    echo '</script>';
    exit();
} else {
    // Si no se proporciona el ID, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: No se proporcionó un ID válido.");';
    echo 'window.location = "../../../Vista/DEV/Regiones_Dev.php";'; // Reemplaza con la ruta de redirección de error deseada
    echo '</script>';
    exit();
}
?>