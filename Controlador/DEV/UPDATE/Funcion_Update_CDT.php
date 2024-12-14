<?php
// Iniciamos sesión
session_start();

// Configuración regional y zona horaria
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/Mexico_City');

function actualizarCentroTrabajo($conexion, $id_centro, $nombre_centro, $num_empleados, $servicios_ofrecidos, $turnos_trabajo, $region, $registro) {
    // Consulta SQL para actualizar el registro en la tabla Centro de Trabajo
    $sql = "UPDATE Centro_Trabajo SET 
            Nombre_Centro = ?,
            Num_Empleados = ?,
            Servicios_Ofrecidos = ?,
            Turnos_Trabajo = ?,
            Fecha_Creacion = ?,
            ID_Regiones = ?
            WHERE ID_Centro = ?";

    // Prepara la consulta SQL
    $stmt = $conexion->prepare($sql);

    // Asocia los parámetros a la consulta preparada
    $stmt->bind_param("sisssii", $nombre_centro, $num_empleados, $servicios_ofrecidos, $turnos_trabajo, $registro, $region, $id_centro);

    // Ejecuta la consulta
    return $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Incluye el archivo de conexión a la base de datos
    include('../../../Modelo/Conexion.php');
    
    // Obtiene la conexión a la base de datos
    $conexion = (new Conectar())->conexion();

    // Obtiene los datos del formulario enviado por POST
    $id_centro = $_POST['id'];
    $nombre_centro = $_POST['nombre_centro'];
    $num_empleados = $_POST['num_empleados'];
    $servicios_ofrecidos = $_POST['servicios_ofrecidos'];
    $turnos_trabajo = $_POST['turnos_trabajo'];
    $region = $_POST['ID_Region']; 
    $registro = date('Y-m-d H:i:s', time()); // Obtiene la fecha y hora actual

    // Comienza la transacción
    $conexion->begin_transaction();

    try {
        if (actualizarCentroTrabajo($conexion, $id_centro, $nombre_centro, $num_empleados, $servicios_ofrecidos, $turnos_trabajo, $region, $registro)) {
            // Confirmar la transacción
            $conexion->commit();

            // Éxito: redirige o muestra un mensaje
            echo '<script type="text/javascript">';
            echo 'alert("¡Registro del Centro de Trabajo modificado exitosamente!");';
            echo 'window.location = "../../../Vista/DEV/Centro_Trabajo_Dev.php";';  // Replace with the actual redirect path
            echo '</script>';
            exit();
        } else {
            // Lanzar una excepción para activar el bloque catch
            throw new Exception("Error al intentar modificar el registro en el Centro de Trabajo.");
        }
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();

        // Muestra un mensaje de error
        echo '<script type="text/javascript">';
        echo 'alert("Error: ' . $e->getMessage() . '");';
        echo 'window.location = "../../../Vista/DEV/INSERT/Insert_CDT_Dev.php";';  // Replace with the actual redirect path
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
    echo 'window.location = "../../../Vista/DEV/Centro_Trabajo_Dev.php";';  // Replace with the actual redirect path
    echo '</script>';
    exit();
}
?>