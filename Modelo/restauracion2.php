<?php
// Configuración de la base de datos de destino
$host = "localhost";
$user = "grupova9_TecPryse";
$password = "M0ch1t*_619";
$database = "grupova9_Pryse";

// Verificar si se proporcionó el nombre del archivo
if (isset($_GET['archivo'])) {
    // Obtener el nombre del archivo desde la variable GET
    $archivo = $_GET['archivo'];
    // Ruta completa al archivo de respaldo
    $ruta_archivo = 'backups/' . $archivo;

    // Crear una nueva conexión a MySQL
    $conn = new mysqli($host, $user, $password);

    // Verificar si la conexión fue exitosa
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Verificar si la base de datos ya existe
    $result = $conn->query("SHOW DATABASES LIKE '$database'");
    if ($result->num_rows > 0) {
        // La base de datos existe, eliminarla
        $conn->query("DROP DATABASE $database");
    }

    // Crear la base de datos
    $conn->query("CREATE DATABASE $database");
    $conn->select_db($database);

    // Leer el contenido del archivo SQL
    $sqlFile = file_get_contents($ruta_archivo);

    // Ejecutar todos los comandos SQL del archivo
    if ($conn->multi_query($sqlFile)) {
        // Mostrar un mensaje de éxito en JavaScript
        echo '<script type="text/javascript">';
        echo 'alert("¡Restauración de la base de datos completada exitosamente!");';
        echo 'window.location = "../Vista/ADMIN/Restauracion_SQL_ADMIN.php";';
        echo '</script>';
    } else {
        // Mostrar un mensaje de error si la restauración falla
        echo "Error al restaurar la base de datos: " . $conn->error;
    }

    // Cerrar la conexión a MySQL
    $conn->close();
} else {
    // Si no se proporcionó el nombre del archivo, mostrar un mensaje de error
    echo 'No se proporcionó el nombre del archivo.';
}
?>