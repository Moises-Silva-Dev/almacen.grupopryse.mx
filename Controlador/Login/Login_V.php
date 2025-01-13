<?php
session_start();
include('../../Modelo/Conexion.php');
$conexion = (new Conectar())->conexion();

$Correo = $_POST['correo'];
$Clave = $_POST['contrasena'];

$sql_usuario = "SELECT * FROM Usuario WHERE Correo_Electronico = ?";
$stmt = mysqli_prepare($conexion, $sql_usuario);
mysqli_stmt_bind_param($stmt, "s", $Correo);
mysqli_stmt_execute($stmt);
$result_usuario = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result_usuario) > 0) {
    $row = mysqli_fetch_assoc($result_usuario);
    $hashed_password = $row['Constrasena'];
    $tipoUsuario = $row['ID_Tipo_Usuario'];

    if (password_verify($Clave, $hashed_password)) {
        $_SESSION['usuario'] = $Correo;

        // Respuesta de éxito con la URL según tipo de usuario
        $urls = [
            1 => "Vista/DEV/index_DEV.php",
            2 => "Vista/SUPERADMIN/index_SUPERADMIN.php",
            3 => "Vista/ADMIN/index_ADMIN.php",
            4 => "Vista/USER/index_USER.php",
            5 => "Vista/ALMACENISTA/index_ALMACENISTA.php"
        ];

        echo json_encode([
            "success" => true,
            "message" => "Inicio de sesión exitoso.",
            "redirect" => $urls[$tipoUsuario] ?? "../../index.php"
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Contraseña incorrecta."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Error, al parecer no estás registrado."]);
}
exit();
?>