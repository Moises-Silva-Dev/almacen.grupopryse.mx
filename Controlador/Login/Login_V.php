<?php
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
include('../../Modelo/Conexion.php'); // Incluir la conexión a la base de datos
$conexion = (new Conectar())->conexion(); // Conectar a la base de datos

// Recuperar los datos del formulario
$Correo = $_POST['correo'];
$Clave = $_POST['contrasena'];

// Verificar si el correo electrónico existe en la base de datos
$sql_usuario = "SELECT * FROM Usuario WHERE Correo_Electronico = ?"; // Consulta SQL para verificar el correo electrónico
$stmt = mysqli_prepare($conexion, $sql_usuario); // Preparar la consulta SQL
mysqli_stmt_bind_param($stmt, "s", $Correo); // Enlazar los parámetros con la consulta SQL
mysqli_stmt_execute($stmt); // Ejecutar la consulta SQL
$result_usuario = mysqli_stmt_get_result($stmt); // Obtener el resultado de la consulta SQL

if (mysqli_num_rows($result_usuario) > 0) { // Verificar si hay resultados
    $row = mysqli_fetch_assoc($result_usuario); // Obtener la fila asociada
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
            5 => "Vista/ALMACENISTA/index_ALMACENISTA.php" // URL para el tipo de usuario 5
        ];

        echo json_encode([ // Enviar la respuesta en formato JSON
            "success" => true, // Indicar que la autenticación fue exitosa
            "message" => "Inicio de sesión exitoso.", // Mensaje de éxito
            "redirect" => $urls[$tipoUsuario] ?? "../../index.php"
        ]);
    } else {
        echo json_encode([ // Enviar la respuesta en formato JSON
            "success" => false, // Indicar que la autenticación falló
            "message" => // Mensaje de error
            "Contraseña incorrecta."]); 
    }
} else {
    echo json_encode([
        "success" => false, // Indicar que la autenticación falló
        "message" => "Error, al parecer no estás registrado."]); // Mensaje de error
}
exit(); // Finalizar la ejecución del script
?>