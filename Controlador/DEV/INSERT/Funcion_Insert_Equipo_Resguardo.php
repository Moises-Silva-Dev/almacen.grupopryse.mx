<?php
// Iniciamos sesión
session_start();

// Función para insertar un nuevo equipo de respaldo
function insertarEquipoRespaldo($conexion, $datos_equipo) {
    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Preparar la consulta SQL para la inserción
        $sql = "INSERT INTO Respaldo_Equipo (Marca, Modelo, Tipo, Procesador, GbRAM, Almacenamiento, Tipo_Almacenamiento, ID_Colaboradores) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la sentencia
        $stmt = $conexion->prepare($sql);

        // Vincular parámetros
        $stmt->bind_param("ssssiisi", $datos_equipo['marca'], $datos_equipo['modelo'], $datos_equipo['tipo'], $datos_equipo['procesador'], $datos_equipo['ram'], $datos_equipo['almacenamiento'], $datos_equipo['tipo_almacenamiento'], $datos_equipo['id_colaboradores']);

        // Ejecutar la consulta de inserción
        if ($stmt->execute()) {
            // Confirmar la transacción
            $conexion->commit();
            return true;
        } else {
            throw new Exception("Error en la ejecución de la consulta de inserción.");
        }
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();
        return false;
    } finally {
        // Cierra la sentencia
        $stmt->close();
    }
}

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar a la base de datos 
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();

    // Recuperar datos del formulario
    $datos_equipo = [
        'marca' => $_POST["Marca"],
        'modelo' => $_POST["Modelo"],
        'tipo' => $_POST["Tipo"],
        'procesador' => $_POST["Procesador"],
        'ram' => $_POST["GbRAM"],
        'almacenamiento' => $_POST["Almacenamiento"],
        'tipo_almacenamiento' => $_POST["Tipo_Almacenamiento"],
        'id_colaboradores' => $_POST["ID_Colaborador"]
    ];

    // Insertar el equipo de respaldo
    if (insertarEquipoRespaldo($conexion, $datos_equipo)) {
        // Éxito: redirige o muestra un mensaje
        echo '<script type="text/javascript">';
        echo 'alert("¡El Registro de Equipo fue Exitoso!");';
        echo 'window.location = "../../../Vista/DEV/Resguardo_Equipo_Dev.php";';
        echo '</script>';
        exit();
    } else {
        // Muestra un mensaje de error
        echo '<script type="text/javascript">';
        echo 'alert("ERROR, No se pudo insertar el equipo.");';
        echo 'window.location = "../../../Vista/DEV/Resguardo_Equipo_Dev.php";';
        echo '</script>';
        exit();
    }

    // Cierra la conexión
    $conexion->close();
}
?>