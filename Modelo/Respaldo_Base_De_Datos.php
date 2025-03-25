<?php
// Respues tio JSON
header('Content-Type: application/json');

// Establecer la configuración regional y la zona horaria
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/Mexico_City');

// Configuración de la base de datos
$mysqlUserName = "root";
$mysqlPassword = "";
$mysqlHostName = "localhost";
$DbName = "grupova9_Pryse";

// Directorio donde se guardarán las copias de seguridad
$backupDirectory = "./backups";

// Prefijo para el nombre del archivo de copia de seguridad
$backupPrefix = "backup_";

// Formato de fecha y hora para el nombre del archivo de copia de seguridad
$dateTimeFormat = "Y-m-d_H-i-s";

try {
    // Crear el directorio de copias de seguridad si no existe
    if (!is_dir($backupDirectory)) {
        // Crear el directorio
        mkdir($backupDirectory, 0755, true);
    }

    // Establecer la conexión con la base de datos
    $mysqli = new mysqli($mysqlHostName, $mysqlUserName, $mysqlPassword, $DbName);

    // Verificar si la conexión fue exitosa
    if ($mysqli->connect_error) {
        // Si la conexión falló, mostrar un mensaje de error
        throw new Exception("Error de conexión: " . $mysqli->connect_error);
    }

    // Seleccionar la base de datos
    $mysqli->select_db($DbName);

    // Establecer el conjunto de caracteres
    $mysqli->query("SET NAMES 'utf8'");

    // Crear el nombre del archivo de copia de seguridad
    $backupFile = $backupDirectory . '/' . $backupPrefix . date($dateTimeFormat) . '.sql';

    // Abrir el archivo de copia de seguridad en modo escritura
    $handle = fopen($backupFile, 'w');

    // Realizar la copia de seguridad
    if (!$handle) {
        // Si no se pudo abrir el archivo, mostrar un mensaje de error
        throw new Exception("No se pudo abrir el archivo de copia de seguridad para escritura.");
    }

    // Escribir encabezados en el archivo de respaldo
    fwrite($handle, "-- Respaldo de la base de datos `$DbName`\n");
    fwrite($handle, "-- Fecha de creación: " . date('Y-m-d H:i:s') . "\n");
    fwrite($handle, "-- Host: $mysqlHostName\n");
    fwrite($handle, "-- Usuario: $mysqlUserName\n");
    fwrite($handle, "-- Password: $mysqlPassword\n\n");
    fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n\n");

    // Obtener la lista de tablas en la base de datos
    $tables = [];

    // Obtener la lista de tablas
    $queryTables = $mysqli->query('SHOW TABLES');

    // Recorrer las tablas
    while ($row = $queryTables->fetch_row()) {
        // Agregar la tabla a la lista
        $tables[] = $row[0];
    }

    // Escribir la estructura y datos de las tablas en el archivo
    foreach ($tables as $table) {
        // Estructura de la tabla
        $result = $mysqli->query('SHOW CREATE TABLE ' . $table);
        // Obtener la estructura de la tabla
        $tableMLine = $result->fetch_row();
        // Escribir la estructura de la tabla en el archivo
        fwrite($handle, "-- Estructura de la tabla `$table`\n");
        // Escribir la estructura de la tabla
        fwrite($handle, $tableMLine[1] . ";\n\n");

        // Datos de la tabla
        fwrite($handle, "-- Datos de la tabla `$table`\n");
        // Obtener los datos de la tabla
        $result = $mysqli->query('SELECT * FROM ' . $table);
        // Recorrer los datos de la tabla
        $fieldsAmount = $result->field_count;

        // Escribir los datos de la tabla en el archivo
        while ($row = $result->fetch_row()) {
            // Escribir los datos de la fila en el archivo
            fwrite($handle, "INSERT INTO `$table` VALUES (");
            // Recorrer los campos de la fila
            for ($j = 0; $j < $fieldsAmount; $j++) {
                // Agregar el valor del campo en el archivo
                $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
                // Agregar el valor del campo en el archivo
                fwrite($handle, isset($row[$j]) ? '"' . $row[$j] . '"' : 'NULL');
                // Agregar una coma si no es el último campo
                if ($j < ($fieldsAmount - 1)) fwrite($handle, ',');
            }
            // Agregar un cierre de paréntesis en el archivo
            fwrite($handle, ");\n");
        }
        // Agregar un salto de línea en el archivo
        fwrite($handle, "\n");
    }

    // Obtener y respaldar procedimientos almacenados
    $queryProcedures = $mysqli->query("SHOW PROCEDURE STATUS WHERE Db = '$DbName'");
    // Recorrer los procedimientos almacenados
    while ($row = $queryProcedures->fetch_assoc()) {
        // Obtener el código del procedimiento almacenado
        $procedureName = $row['Name'];
        // Obtener el código del procedimiento almacenado
        $result = $mysqli->query("SHOW CREATE PROCEDURE `$procedureName`");
        // Obtener el código del procedimiento almacenado
        $procedureMLine = $result->fetch_assoc();
        // Escribir el código del procedimiento almacenado en el archivo
        fwrite($handle, "-- Procedimiento almacenado `$procedureName`\n");
        // Escribir el código del procedimiento almacenado
        fwrite($handle, $procedureMLine['Create Procedure'] . ";\n\n");
    }

    // Obtener y respaldar funciones almacenadas
    $queryFunctions = $mysqli->query("SHOW FUNCTION STATUS WHERE Db = '$DbName'");
    // Recorrer las funciones almacenadas
    while ($row = $queryFunctions->fetch_assoc()) {
        // Obtener el nombre de la función almacenada
        $functionName = $row['Name'];
        // Obtener el código de la función almacenada
        $result = $mysqli->query("SHOW CREATE FUNCTION `$functionName`");
        // Obtener el código de la función almacenada
        $functionMLine = $result->fetch_assoc();
        // Escribir el código de la función almacenada en el archivo
        fwrite($handle, "-- Función almacenada `$functionName`\n");
        // Escribir el código de la función almacenada
        fwrite($handle, $functionMLine['Create Function'] . ";\n\n");
    }

    // Obtener y respaldar triggers
    $queryTriggers = $mysqli->query("SHOW TRIGGERS");
    // Recorrer los triggers
    while ($row = $queryTriggers->fetch_assoc()) {
        // Obtener el nombre del trigger
        $triggerName = $row['Trigger'];
        // Obtener el código del trigger
        $result = $mysqli->query("SHOW CREATE TRIGGER `$triggerName`");
        // Obtener el código del trigger
        $triggerMLine = $result->fetch_assoc();
        // Escribir el código del trigger en el archivo
        fwrite($handle, "-- Trigger `$triggerName`\n");
        // Escribir el código del trigger
        fwrite($handle, $triggerMLine['SQL Original Statement'] . ";\n\n");
    }

    // Finalizar el archivo de respaldo
    fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");
    fclose($handle); // Cerrar el archivo de respaldo

    // Respuesta de éxito
    echo json_encode([
        "success" => true, // Indicamos que la operación se realizó con éxito
        "message" => "Copia de seguridad creada exitosamente.", // Mensaje de confirmación
        "file" => $backupFile, // Ruta del archivo de respaldo
    ]);
} catch (Exception $e) {
    // Manejo de errores
    echo json_encode([
        "success" => false, // Indicamos que la operación falló
        "message" => 'Ocurrió un Error' . $e->getMessage(), // Mensaje de error
    ]);
}
?>