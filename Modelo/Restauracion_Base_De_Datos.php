<?php
header('Content-Type: application/json');

// Configuración de la base de datos
$user = "root";
$password = "";
$host = "localhost";
$database = "grupova9_Pryse";

// Verificar si se proporcionó el nombre del archivo
if (isset($_GET['archivo'])) {
    // Obtener el nombre del archivo desde la variable GET
    $archivo = $_GET['archivo'];
    // Ruta completa al archivo de respaldo
    $ruta_archivo = 'backups/' . $archivo;

    // Crear una nueva conexión a MySQL
    $conn = new mysqli($host, $user, $password, $database);

    // Verificar si la conexión fue exitosa, sino retorna false
    if ($conn->connect_error) {
        echo json_encode([
            'success' => false,
            'message' => 'Error de conexión a la base de datos.',
        ]);
        exit();
    }

    // Leer el contenido del archivo SQL
    $sqlFile = file_get_contents($ruta_archivo);

    // Desactivar las restricciones de clave foránea temporalmente
    $conn->query("SET foreign_key_checks = 0");

    // Obtener la lista de tablas en la base de datos
    $tables = $conn->query("SHOW TABLES");

    //Itera hasta donde le permita el arreglo
    while ($row = $tables->fetch_array()) {
        // Eliminar cada tabla individualmente
        $conn->query("DROP TABLE IF EXISTS " . $row[0]);
    }

    // Reactivar las restricciones de clave foránea
    $conn->query("SET foreign_key_checks = 1");

    // Ejecutar todos los comandos SQL del archivo
    if ($conn->multi_query($sqlFile)) {
        // Retorna la respuesta en True
        echo json_encode([
            'success' => true,
            'message' => '¡Restauración de la base de datos completada exitosamente!',
        ]);
    } else {
        // Retorna la respuesta en False
        echo json_encode([
            'success' => false,
            'message' => 'Error al restaurar la base de datos: ' . $conn->error,
        ]);
    }
    // Cierra la conexión de la base de datos
    $conn->close();
} else {
    // Retorna la respuesta en False
    echo json_encode([
        'success' => false,
        'message' => 'No se proporcionó el nombre del archivo.',
    ]);
}
?>