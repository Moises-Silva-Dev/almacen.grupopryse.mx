<?php
// Evitar que cualquier error previo ensucie la salida de headers
ob_start(); 

// Configurar parametros de la cookie (UNA SOLA VEZ)
session_set_cookie_params([
    'lifetime' => 18000,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Strict'
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si quieres ver el error real en la pantalla blanca, activa esto temporalmente:
error_reporting(E_ALL);
ini_set('display_errors', 1);
define('SESSION_TIMEOUT', 18000); 

// Comprobar si el usuario esta autenticado
if (!isset($_SESSION['usuario'])) {
    session_unset();
    session_destroy();
    header("Location: ../../index.php?auth=failed");
    exit();
}

// Logica de timeout
if (!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();
} elseif (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT) {
    session_unset();
    session_destroy();
    header("Location: ../../index.php?auth=timeout");
    exit();
}

$_SESSION['last_activity'] = time();
// Al final, liberamos el buffer si todo salio bien
ob_end_flush();
?>