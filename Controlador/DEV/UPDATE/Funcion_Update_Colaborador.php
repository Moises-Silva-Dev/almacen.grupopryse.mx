<?php
// Iniciamos sesión
session_start();

function actualizarColaborador($conexion, $id_colaborador, $nombre, $apellido_paterno, $apellido_materno, $curp, $correo_electronico, $id_tipo_colaborador, $id_centro, $registro) {
    // Preparar la consulta SQL para actualizar el colaborador
    $sql = "UPDATE Colaborador SET 
            Nombre = ?,
            Apellido_Paterno = ?,
            Apellido_Materno = ?,
            CURP = ?,
            Correo_Electronico = ?,
            Fecha_Alta = ?,
            ID_Tipo_Colaborador = ?,
            ID_CentroT = ?
            WHERE ID_Colaborador = ?";

    // Preparar la sentencia
    $stmt = $conexion->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("ssssssssi", $nombre, $apellido_paterno, $apellido_materno, $curp, $correo_electronico, $registro, $id_tipo_colaborador, $id_centro, $id_colaborador);

    // Ejecutar la consulta
    return $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conectar a la base de datos 
    include('../../../Modelo/Conexion.php'); 
    // Obtiene la conexión a la base de datos
    $conexion = (new Conectar())->conexion();

    // Obtener datos del formulario
    $id_colaborador = $_POST['id_colaborador'];
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $curp = $_POST['curp'];
    $correo_electronico = $_POST['correo_electronico'];
    $id_tipo_colaborador = $_POST['tipo_colaborador'];
    $id_centro = $_POST['ID_CentroT'];
    date_default_timezone_set('America/Mexico_City');
    $registro = date('Y-m-d H:i:s', time()); 

    // Comienza la transacción
    $conexion->begin_transaction();

    try {
        if (actualizarColaborador($conexion, $id_colaborador, $nombre, $apellido_paterno, $apellido_materno, $curp, $correo_electronico, $id_tipo_colaborador, $id_centro, $registro)) {
            // Confirmar la transacción
            $conexion->commit();

            // Éxito: redirige o muestra un mensaje
            echo '<script type="text/javascript">';
            echo 'alert("¡Registro modificado exitosamente!");';
            echo 'window.location = "../../../Vista/DEV/Colaboradores_Dev.php";';
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
        echo 'window.location = "../../../Vista/DEV/Colaboradores_Dev.php";';
        echo '</script>';
        exit();
    } finally {
        // Cierra la conexión
        $conexion->close();
    }
} else {
    // Si no es una solicitud POST, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: Acceso no permitido.");';
    echo 'window.location = "../../../Vista/DEV/Colaboradores_Dev.php";';
    echo '</script>';
    exit();
}
?>