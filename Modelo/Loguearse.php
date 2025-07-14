<?php
// Configurar parámetros de la cookie ANTES de iniciar la sesión
session_set_cookie_params([
    'lifetime' => 18000,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_start(); // Iniciar la sesión
error_reporting(0); // Desactivar la notificación de errores para evitar mostrar mensajes de error al usuario
define('SESSION_TIMEOUT', 18000); // 5 horas en segundos

// Comprobar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    session_destroy(); // Destruir la sesión
    // Redirigir al index con un mensaje de SweetAlert
    header("Location: ../../index.php?auth=failed");
    exit(); // Finalizar la ejecución del script
}

// Regenerar el ID de sesión solo si está autenticado
if (!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time(); // Inicializar tiempo de actividad
} elseif (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT) {
    session_unset();  // Limpiar variables de sesión
    session_destroy(); // Destruir la sesión
    header("Location: ../../index.php?auth=timeout"); // Redirigir con mensaje de timeout
    exit();
}

$_SESSION['last_activity'] = time(); // Actualizar el tiempo de actividad
?>