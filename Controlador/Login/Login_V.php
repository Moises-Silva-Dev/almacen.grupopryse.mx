<?php
// Iniciar la sesión
session_start();

// Incluir el archivo de conexión a la base de datos
include('../../Modelo/Conexion.php');
// Obtener la instancia de conexión
$conexion = (new Conectar())->conexion();

// Obtener las credenciales de usuario desde el formulario de inicio de sesión
$Correo = $_POST['correo'];
$Clave = $_POST['contrasena'];

// Consultar la base de datos para obtener la contraseña hasheada
$sql_usuario = "SELECT * FROM Usuario WHERE Correo_Electronico = ?";
$stmt = mysqli_prepare($conexion, $sql_usuario);
mysqli_stmt_bind_param($stmt, "s", $Correo);
mysqli_stmt_execute($stmt);
$result_usuario = mysqli_stmt_get_result($stmt);

// Verificar si se encontró un usuario con el correo electrónico proporcionado
if (mysqli_num_rows($result_usuario) > 0) {
    // Obtener información del usuario
    $row = mysqli_fetch_assoc($result_usuario);
    $hashed_password = $row['Constrasena'];
    $tipoUsuario = $row['ID_Tipo_Usuario'];

    // Verificar la contraseña ingresada con la contraseña hasheada
    if (password_verify($Clave, $hashed_password)) {
        // Almacenar el correo electrónico del usuario en la sesión
        $_SESSION['usuario'] = $Correo;

        // Redirigir según el tipo de usuario
        switch ($tipoUsuario) {
            case 1:
                header("Location: ../../Vista/DEV/index_DEV.php");
                break;
            case 2:
                header("Location: ../../Vista/SUPERADMIN/index_SUPERADMIN.php");
                break;
            case 3:
                header("Location: ../../Vista/ADMIN/index_ADMIN.php");
                break;
            case 4:
                header("Location: ../../Vista/USER/index_USER.php");
                break;
            case 5:
                header("Location: ../../Vista/ALMACENISTA/index_ALMACENISTA.php");
                break;
            default:
                // En caso de un tipo de usuario desconocido, mostrar un mensaje de error y redirigir
                mostrarErrorYRedirigir("Usuario Desconocido");
                break;
        }
    } else {
        // Contraseña incorrecta
        mostrarErrorYRedirigir("Contraseña incorrecta.");
    }
} else {
    // Si no se encontró un usuario con las credenciales, mostrar un mensaje de error y redirigir
    mostrarErrorYRedirigir("Error, al parecer no estás registrado");
}

// Función para mostrar un mensaje de error y redirigir
function mostrarErrorYRedirigir($mensaje) {
    echo '<script type="text/javascript">';
    echo 'alert("' . $mensaje . '");';
    echo 'window.location = "../../index.php";';
    echo '</script>';
    exit(); // Detiene la ejecución después de mostrar el mensaje
}
?>