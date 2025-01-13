<?php
// Iniciar la sesión
session_start(); 
// Desactivar la notificación de errores para evitar mostrar mensajes de error al usuario
error_reporting(0);

// Comprobar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    // Mostrar alerta en JavaScript
    echo '<script>
        alert("Por favor, debes iniciar sesión.");
        window.location = "../../../index.php";
    </script>';
    // Destruir la sesión
    session_destroy();
    // Finalizar la ejecución del script
    die();
}

// Configurar la sesión para no expirar automáticamente
ini_set('session.gc_maxlifetime', 0); // La sesión nunca expira
ini_set('session.cookie_lifetime', 0); // La cookie de sesión nunca expira
?>