<?php
// Iniciamos sesión
session_start();
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/Mexico_City');

function actualizarCuenta($conexion, $id_cuenta, $NombreCuenta, $NroElemetos) {
    // Preparar la consulta SQL para actualizar la región
    $sql = "UPDATE Cuenta SET 
            NombreCuenta = ?,
            NroElemetos = ?
            WHERE ID = ?";

    // Preparar la sentencia
    $stmt = $conexion->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("sii", $NombreCuenta, $NroElemetos, $id_cuenta);

    // Ejecutar la consulta
    return $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conectar a la base de datos
    include('../../../Modelo/Conexion.php'); 
    $conexion = (new Conectar())->conexion();

    // Obtener datos del formulario
    $id_cuenta = $_POST['ID_Cuenta'];
    $NombreCuenta = $_POST['NombreCuenta'];
    $NroElemetos = $_POST['NroElemetos'];

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        if (actualizarCuenta($conexion, $id_cuenta, $NombreCuenta, $NroElemetos)) {
            // Confirmar la transacción
            $conexion->commit();

            // Éxito: redirige o muestra un mensaje
            echo '<script type="text/javascript">';
            echo 'alert("¡Registro modificado exitosamente!");';
            echo 'window.location = "../../../Vista/DEV/Cuenta_Dev.php";'; // Reemplaza con la página correcta
            echo '</script>';
            exit();
        } else {
            // Lanzar una excepción para activar el bloque catch
            throw new Exception("Error al intentar modificar el registro.");
        }
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();

        // Muestra un mensaje de error
        echo '<script type="text/javascript">';
        echo 'alert("Error: ' . $e->getMessage() . '");';
        echo 'window.location = "../../../Vista/DEV/Cuenta_Dev.php";'; // Reemplaza con la página correcta
        echo '</script>';
        exit();
    } finally {
        // Cierra la conexión y la sentencia
        $stmt->close();
        $conexion->close();
    }
} else {
    // Si no es una solicitud POST, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: Acceso no permitido.");';
    echo 'window.location = "../../../Vista/DEV/Cuenta_Dev.php";'; // Reemplaza con la página correcta
    echo '</script>';
    exit();
}
?>