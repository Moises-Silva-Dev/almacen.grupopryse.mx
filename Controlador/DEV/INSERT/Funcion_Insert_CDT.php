<?php
// Inicia la sesión
session_start();
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/Mexico_City');

// Función para insertar un nuevo centro de trabajo
function insertarCentroTrabajo($nombreCentro, $numEmpleados, $serviciosOfrecidos, $turnosTrabajo, $region, $ID_Estados, $registro) {
    // Incluye el archivo de conexión 
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();

    // Comienza la transacción
    $conexion->begin_transaction();

    try {
        // Prepara la consulta SQL para la inserción
        $sql = "INSERT INTO Centro_Trabajo (Nombre_Centro, Num_Empleados, Servicios_Ofrecidos, Turnos_Trabajo, Fecha_Creacion, IDRegion, IDEstado)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Prepara la sentencia
        $stmt = $conexion->prepare($sql);

        // Vincula los parámetros
        $stmt->bind_param("sisssii", $nombreCentro, $numEmpleados, $serviciosOfrecidos, $turnosTrabajo, $registro, $region, $ID_Estados);

        // Ejecuta la consulta de inserción
        if ($stmt->execute()) {
            // Confirma la transacción
            $conexion->commit();
            return true;
        } else {
            // Lanza una excepción para activar el bloque catch
            throw new Exception("Error en la ejecución de la consulta de inserción.");
        }
    } catch (Exception $e) {
        // Revierte la transacción en caso de error
        $conexion->rollback();
        return false;
    } finally {
        // Cierra la conexión y la sentencia
        $stmt->close();
        $conexion->close();
    }
}

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario
    $nombreCentro = $_POST["nombre_centro"];
    $numEmpleados = $_POST["num_empleados"];
    $serviciosOfrecidos = $_POST["servicios_ofrecidos"];
    $turnosTrabajo = $_POST["turnos_trabajo"];
    $region = $_POST['ID_Region'];
    $ID_Estados = $_POST['ID_Estados'];
    $registro = date('Y-m-d H:i:s', time()); // Obtiene la fecha y hora actual

    // Insertar el centro de trabajo
    if (insertarCentroTrabajo($nombreCentro, $numEmpleados, $serviciosOfrecidos, $turnosTrabajo, $region, $ID_Estados, $registro)) {
        // Éxito: muestra un mensaje
        echo '<script type="text/javascript">';
        echo 'alert("¡El registro fue exitoso!");';
        echo 'window.location = "../../../Vista/DEV/Centro_Trabajo_Dev.php";'; // Reemplaza con la ruta de redirección deseada
        echo '</script>';
        exit();
    } else {
        // Muestra un mensaje de error
        echo '<script type="text/javascript">';
        echo 'alert("ERROR, no se pudo realizar el registro.");';
        echo 'window.location = "../../../Vista/DEV/INSERT/Insert_CDT_Dev.php";'; // Reemplaza con la ruta de redirección de error deseada
        echo '</script>';
        exit();
    }
}
?>