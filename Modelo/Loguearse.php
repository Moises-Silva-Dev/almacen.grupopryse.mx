<?php
// Iniciar la sesión
session_start(); 
// Desactivar la notificación de errores para evitar mostrar mensajes de error al usuario
error_reporting(0);
// Actualizar la última actividad
$_SESSION['LAST_ACTIVITY'] = time();
// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    // Mostrar alerta en JavaScript
    echo '<script>
        alert("Por favor, debes iniciar sesión.");
        window.location = "../../index.php";
    </script>';
    // Destruir la sesión
    session_destroy();
    // Finalizar la ejecución del script
    die();
}
?>