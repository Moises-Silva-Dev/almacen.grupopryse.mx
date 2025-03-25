<?php
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
include('../../Modelo/Conexion.php'); // Incluir la conexión a la base de datos

try {
    $conexion = (new Conectar())->conexion(); // Conectar a la base de datos

    // Consulta para obtener conexión con la base de datos
    if (!$conexion || $conexion->connect_error) {
        // Si la conexión falla, mostrar un mensaje de error
        throw new Exception("Error en la conexión: " . $conexion->connect_error);
    }

    // Recuperar los datos del formulario
    $Correo = $_POST['correo'];
    $Clave = $_POST['contrasena'];

    if (!$Correo || !$Clave) { // Verificar que los campos no estén vacíos
        // Si alguno de los campos está vacío, mostrar un mensaje de error
        throw new Exception("Datos inválidos. Por favor, revise la información enviada.");
    }

    // Verificar si el correo electrónico existe en la base de datos
    $sql_usuario = "SELECT * FROM Usuario WHERE Correo_Electronico = ?"; // Consulta SQL para verificar el correo electrónico
    $stmt = $conexion->prepare($sql_usuario); // Preparar la consulta SQL

    if (!$stmt) { // Verificar si la consulta se preparó correctamente
        // Si la consulta no se preparó correctamente, mostrar un mensaje de error
        throw new Exception("Error al preparar la consulta: " . $conexion->error);
    }

    $stmt->bind_param("s", $Correo); // Enlazar los parámetros con la consulta SQL
    $stmt->execute(); // Ejecutar la consulta SQL
    $result_usuario = $stmt->get_result(); // Obtener el resultado de la consulta SQL

    if ($result_usuario->num_rows > 0) { // Verificar si hay resultados
        $row = $result_usuario->fetch_assoc(); // Obtener la fila asociada
        $hashed_password = $row['Constrasena']; // Obtener la contraseña hashada
        $tipoUsuario = $row['ID_Tipo_Usuario']; // Obtener el tipo de usuario

        if (password_verify($Clave, $hashed_password)) { // Verificar la contraseña
            $_SESSION['usuario'] = $Correo; // Establecer la sesión del usuario

            // Respuesta de éxito con la URL según tipo de usuario
            $urls = [
                1 => "Vista/DEV/index_DEV.php", // URL para el tipo de usuario 1
                2 => "Vista/SUPERADMIN/index_SUPERADMIN.php", // URL para el tipo de usuario 2
                3 => "Vista/ADMIN/index_ADMIN.php", // URL para el tipo de usuario 3
                4 => "Vista/USER/index_USER.php", // URL para el tipo de usuario 4
                5 => "Vista/ALMACENISTA/index_ALMACENISTA.php", // URL para el tipo de usuario 5
                6 => "Vista/RH/index_RH.php", // URL para el tipo de usuario 6
            ];

            echo json_encode([ // Enviar la respuesta en formato JSON
                "success" => true, // Indicar que la autenticación fue exitosa
                "message" => "Inicio de sesión exitoso.", // Mensaje de éxito
                "redirect" => $urls[$tipoUsuario] ?? "../../index.php"
            ]);
        } else {
            // Si la contraseña no coincide, mostrar un mensaje de error
            throw new Exception("Contraseña incorrecta.");
        }
    } else {
        // Si no hay resultados, mostrar un mensaje de error
        throw new Exception("Error, al parecer no estás registrado.");
    }

    $stmt->close(); // Cerrar statement
    $conexion->close(); // Cerrar conexión

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => htmlspecialchars($e->getMessage())
    ]);
}
exit(); // Finalizar la ejecución del script
?>