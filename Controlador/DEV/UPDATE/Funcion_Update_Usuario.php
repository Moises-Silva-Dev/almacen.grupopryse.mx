<?php
// Iniciamos sesión
session_start();

// Función para actualizar usuario
function actualizarUsuario($Opcion, $conexion, $nombre, $apellido_paterno, $apellido_materno, $num_tel, $correo_electronico, $contrasena, $num_contacto_sos, $id_usuario) {
    
    if ($Opcion == "SI") {
        // Preparar la consulta SQL para actualizar el usuario sin ID_Cuenta
        $sql = "UPDATE Usuario SET 
                    Nombre = ?, Apellido_Paterno = ?, Apellido_Materno = ?,
                    NumTel = ?, Correo_Electronico = ?, Constrasena = ?,
                    NumContactoSOS = ?
                WHERE ID_Usuario = ?";
        
        // Preparar la sentencia
        $stmt = $conexion->prepare($sql);
        
        // Vincular parámetros
        $stmt->bind_param("sssssssi", $nombre, $apellido_paterno, $apellido_materno, $num_tel, $correo_electronico, $contrasena, $num_contacto_sos, $id_usuario);
    } else {
        // Preparar la consulta SQL para actualizar el usuario con ID_Cuenta
        $sql = "UPDATE Usuario SET 
                    Nombre = ?, Apellido_Paterno = ?, Apellido_Materno = ?,
                    NumTel = ?, Correo_Electronico = ?, NumContactoSOS = ?
                WHERE ID_Usuario = ?";
        
        // Preparar la sentencia
        $stmt = $conexion->prepare($sql);
        
        // Vincular parámetros
        $stmt->bind_param("ssssssi", $nombre, $apellido_paterno, $apellido_materno, $num_tel, $correo_electronico, $num_contacto_sos, $id_usuario);
    }
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conectar a la base de datos
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();

    // Obtener datos del formulario
    $id_usuario = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $num_tel = $_POST['num_tel'];
    $correo_electronico = $_POST['correo_electronico'];
    $num_contacto_sos = $_POST['num_contacto_sos'];
    $Opcion = $_POST['Opcion'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Actualizar el usuario en la base de datos
        if (actualizarUsuario($Opcion, $conexion, $nombre, $apellido_paterno, $apellido_materno, $num_tel, $correo_electronico, $contrasena, $num_contacto_sos, $id_usuario)) {
            // Confirmar la transacción
            $conexion->commit();

            // Éxito: redirige o muestra un mensaje
            echo '<script type="text/javascript">';
            echo 'alert("¡Registro modificado exitosamente!");';
            echo 'window.location = "../../../Vista/DEV/Registro_Usuario_Dev.php";';
            echo '</script>';
            exit();
        } else {
            throw new Exception("Error al intentar modificar el registro.");
        }
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();

        // Muestra un mensaje de error
        echo '<script type="text/javascript">';
        echo 'alert("Error: ' . $e->getMessage() . '");';
        echo 'window.location = "../../../Vista/DEV/Registro_Usuario_Dev.php";';
        echo '</script>';
        exit();
    } finally {
        // Cerrar la conexión
        $conexion->close();
    }
} else {
    // Si no es una solicitud POST, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: Acceso no permitido.");';
    echo 'window.location = "../../../Vista/DEV/Registro_Usuario_Dev.php";';
    echo '</script>';
    exit();
}
?>