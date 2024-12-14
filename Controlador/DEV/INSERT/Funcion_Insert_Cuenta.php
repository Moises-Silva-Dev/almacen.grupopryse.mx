<?php
// Iniciar sesión
session_start();
setlocale(LC_ALL, 'es_ES');

// Función para insertar un nuevo registro en la base de datos
function insertarNuevoRegistro($nombre_estado, $nombre_municipio, $conexion) {
    // Preparar la consulta SQL para la inserción
    $sql = "INSERT INTO Cuenta (NombreCuenta, NroElemetos) VALUES (?, ?)";

    // Preparar la sentencia
    $stmt = $conexion->prepare($sql);

    // Vincular los parámetros
    $stmt->bind_param("si", $nombre_estado, $nombre_municipio);

    // Ejecutar la consulta de inserción
    if ($stmt->execute()) {
        // Confirmar la transacción
        $conexion->commit();
        return true;
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de inserción.");
    }
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();

    // Recuperar los datos del formulario
    $NombreCuenta = $_POST["NombreCuenta"];
    $NroElemetos = $_POST["NroElemetos"];
    date_default_timezone_set('America/Mexico_City');

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Insertar el nuevo registro
        if (insertarNuevoRegistro($NombreCuenta, $NroElemetos, $conexion)) {
            // Éxito: mostrar un mensaje
            echo '<script type="text/javascript">';
            echo 'alert("¡El registro fue exitoso!");';
            echo 'window.location = "../../../Vista/DEV/Cuenta_Dev.php";'; // Reemplazar con la ruta de redirección deseada
            echo '</script>';
            exit();
        } else {
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error en la inserción del nuevo registro.");
        }
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();

        // Mostrar un mensaje de error
        echo '<script type="text/javascript">';
        echo 'alert("ERROR, no se pudo realizar el registro.");';
        echo 'window.location = "../../../Vista/DEV/INSERT/Cuenta_Dev.php";'; // Reemplazar con la ruta de redirección de error deseada
        echo '</script>';
        exit();
    } finally {
        // Cerrar la conexión
        $conexion->close();
    }
}
?>