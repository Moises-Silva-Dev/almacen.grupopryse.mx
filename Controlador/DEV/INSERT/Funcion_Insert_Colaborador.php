<?php
// Iniciar sesión
session_start();
date_default_timezone_set('America/Mexico_City');

// Función para verificar si el correo electrónico ya está registrado
function verificarCorreoExistente($conexion, $correo_electronico) {
    $consulta_existencia_correo = $conexion->prepare("SELECT ID_Colaborador FROM Colaborador WHERE Correo_Electronico = ?");
    $consulta_existencia_correo->bind_param("s", $correo_electronico);
    $consulta_existencia_correo->execute();
    $consulta_existencia_correo->store_result();
    $num_rows = $consulta_existencia_correo->num_rows;
    $consulta_existencia_correo->free_result();
    return $num_rows > 0;
}

// Función para insertar un nuevo colaborador
function insertarColaborador($conexion, $datos_colaborador) {
    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Preparar la consulta SQL para la inserción
        $sql = "INSERT INTO Colaborador (Nombre, Apellido_Paterno, Apellido_Materno, CURP, Correo_Electronico, Fecha_Alta, ID_Tipo_Colaborador, ID_CentroT) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la sentencia
        $stmt = $conexion->prepare($sql);

        // Vincular parámetros
        $stmt->bind_param("ssssssii", $datos_colaborador['nombre'], $datos_colaborador['apellido_paterno'], $datos_colaborador['apellido_materno'], $datos_colaborador['curp'], $datos_colaborador['correo_electronico'], $datos_colaborador['fecha_alta'], $datos_colaborador['id_tipo_colaborador'], $datos_colaborador['id_centro']);

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
        // Cierra la conexión y la sentencia
        $stmt->close();
    }
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar a la base de datos 
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();

    // Recuperar los datos del formulario
    $correo_electronico = $_POST["correo_electronico"];
    $nombre = $_POST["Nombre"];
    $apellido_paterno = $_POST["Apellido_Paterno"];
    $apellido_materno = $_POST["Apellido_Materno"];
    $curp = $_POST["CURP"];
    $fecha_alta = date('Y-m-d H:i:s'); // Obtener la fecha y hora actual
    $id_tipo_colaborador = $_POST["Tipo_Colaborador"];
    $id_centro = $_POST['ID_CentroT'];

    // Verificar si el correo electrónico ya está registrado
    if (verificarCorreoExistente($conexion, $correo_electronico)) {
        echo '<script type="text/javascript">';
        echo 'alert("ERROR, El correo electrónico ya está registrado por otro colaborador.");';
        echo 'window.location = "../../../Vista/DEV/INSERT/Insert_Colaborador_Dev.php";';
        echo '</script>';
        exit();
    }

    // Datos del colaborador
    $datos_colaborador = [
        'nombre' => $nombre,
        'apellido_paterno' => $apellido_paterno,
        'apellido_materno' => $apellido_materno,
        'curp' => $curp,
        'correo_electronico' => $correo_electronico,
        'fecha_alta' => $fecha_alta,
        'id_tipo_colaborador' => $id_tipo_colaborador,
        'id_centro' => $id_centro
    ];

    // Insertar el colaborador
    if (insertarColaborador($conexion, $datos_colaborador)) {
        // Éxito: redirige o muestra un mensaje
        echo '<script type="text/javascript">';
        echo 'alert("¡¡El Registro fue Exitoso!!");';
        echo 'window.location = "../../../Vista/DEV/Colaboradores_Dev.php";';
        echo '</script>';
        exit();
    } else {
        // Muestra un mensaje de error
        echo '<script type="text/javascript">';
        echo 'alert("ERROR, Tipo de colaborador desconocido.");';
        echo 'window.location = "../../../Vista/DEV/INSERT/Insert_Colaborador_Dev.php";';
        echo '</script>';
        exit();
    }

    // Cierra la conexión
    $conexion->close();
}
?>