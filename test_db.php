<?php
require_once 'Modelo/Conexion.php'; // Asegúrate de que la ruta sea correcta

try {
    $con = new Conectar();
    $db = $con->conexion();
    
    if ($db) {
        echo "<h1>✅ ¡Éxito!</h1>";
        echo "<p>PHP se conectó correctamente a MySQL dentro de Docker.</p>";
        
        // Probamos una consulta simple
        $resultado = $db->query("SELECT VERSION() AS version");
        $fila = $resultado->fetch_assoc();
        echo "<p>Versión de MySQL: <strong>" . $fila['version'] . "</strong></p>";
    }
} catch (Exception $e) {
    echo "<h1>❌ Error de conexión</h1>";
    echo "<p>El error fue: " . $e->getMessage() . "</p>";
    echo "<br><strong>Tips de revisión:</strong>";
    echo "<ul>
            <li>¿El servicio 'db' está corriendo? (docker ps)</li>
            <li>¿El host en Conectar.php es 'db'?</li>
            <li>¿El usuario y contraseña coinciden con el docker-compose.yml?</li>
          </ul>";
}
?>