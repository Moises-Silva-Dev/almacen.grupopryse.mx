<?php
// Iniciar la sesión
session_start(); 

// Desactivar la notificación de errores para evitar mostrar mensajes de error al usuario
error_reporting(0);

session_regenerate_id(true); // Evita el secuestro de sesiones

// Comprobar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    // Destruir la sesión
    session_destroy();

    // Redirigir al index con un mensaje de SweetAlert
    header("Location: ../../../index.php?auth=failed");

    // Finalizar la ejecución del script
    exit();
}

// Configurar la sesión para no expirar automáticamente
ini_set('session.gc_maxlifetime', 0); // La sesión nunca expira
ini_set('session.cookie_lifetime', 0); // La cookie de sesión nunca expira
?>