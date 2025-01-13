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
        mkdir($backupDirectory, 0755, true);
    }

    // Establecer la conexión con la base de datos
    $mysqli = new mysqli($mysqlHostName, $mysqlUserName, $mysqlPassword, $DbName);

    // Verificar si la conexión fue exitosa
    if ($mysqli->connect_error) {
        throw new Exception("Error de conexión: " . $mysqli->connect_error);
    }

    // Seleccionar la base de datos
    $mysqli->select_db($DbName);
    $mysqli->query("SET NAMES 'utf8'");

    // Crear el nombre del archivo de copia de seguridad
    $backupFile = $backupDirectory . '/' . $backupPrefix . date($dateTimeFormat) . '.sql';

    // Abrir el archivo de copia de seguridad en modo escritura
    $handle = fopen($backupFile, 'w');
    if (!$handle) {
        throw new Exception("No se pudo abrir el archivo de copia de seguridad para escritura.");
    }

    // Escribir encabezados en el archivo de respaldo
    fwrite($handle, "-- Respaldo de la base de datos `$DbName`\n");
    fwrite($handle, "-- Fecha de creación: " . date('Y-m-d H:i:s') . "\n");
    fwrite($handle, "-- Host: $mysqlHostName\n");
    fwrite($handle, "-- Usuario: $mysqlUserName\n\n");
    fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n\n");

    // Obtener la lista de tablas en la base de datos
    $tables = [];
    $queryTables = $mysqli->query('SHOW TABLES');
    while ($row = $queryTables->fetch_row()) {
        $tables[] = $row[0];
    }

    // Escribir la estructura y datos de las tablas en el archivo
    foreach ($tables as $table) {
        // Estructura de la tabla
        $result = $mysqli->query('SHOW CREATE TABLE ' . $table);
        $tableMLine = $result->fetch_row();
        fwrite($handle, "-- Estructura de la tabla `$table`\n");
        fwrite($handle, $tableMLine[1] . ";\n\n");

        // Datos de la tabla
        fwrite($handle, "-- Datos de la tabla `$table`\n");
        $result = $mysqli->query('SELECT * FROM ' . $table);
        $fieldsAmount = $result->field_count;

        while ($row = $result->fetch_row()) {
            fwrite($handle, "INSERT INTO `$table` VALUES (");
            for ($j = 0; $j < $fieldsAmount; $j++) {
                $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
                fwrite($handle, isset($row[$j]) ? '"' . $row[$j] . '"' : 'NULL');
                if ($j < ($fieldsAmount - 1)) fwrite($handle, ',');
            }
            fwrite($handle, ");\n");
        }
        fwrite($handle, "\n");
    }

    // Obtener y respaldar procedimientos almacenados
    $queryProcedures = $mysqli->query("SHOW PROCEDURE STATUS WHERE Db = '$DbName'");
    while ($row = $queryProcedures->fetch_assoc()) {
        $procedureName = $row['Name'];
        $result = $mysqli->query("SHOW CREATE PROCEDURE `$procedureName`");
        $procedureMLine = $result->fetch_assoc();
        fwrite($handle, "-- Procedimiento almacenado `$procedureName`\n");
        fwrite($handle, $procedureMLine['Create Procedure'] . ";\n\n");
    }

    // Obtener y respaldar funciones almacenadas
    $queryFunctions = $mysqli->query("SHOW FUNCTION STATUS WHERE Db = '$DbName'");
    while ($row = $queryFunctions->fetch_assoc()) {
        $functionName = $row['Name'];
        $result = $mysqli->query("SHOW CREATE FUNCTION `$functionName`");
        $functionMLine = $result->fetch_assoc();
        fwrite($handle, "-- Función almacenada `$functionName`\n");
        fwrite($handle, $functionMLine['Create Function'] . ";\n\n");
    }

    // Obtener y respaldar triggers
    $queryTriggers = $mysqli->query("SHOW TRIGGERS");
    while ($row = $queryTriggers->fetch_assoc()) {
        $triggerName = $row['Trigger'];
        $result = $mysqli->query("SHOW CREATE TRIGGER `$triggerName`");
        $triggerMLine = $result->fetch_assoc();
        fwrite($handle, "-- Trigger `$triggerName`\n");
        fwrite($handle, $triggerMLine['SQL Original Statement'] . ";\n\n");
    }

    // Finalizar el archivo de respaldo
    fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");
    fclose($handle);

    // Respuesta de éxito
    echo json_encode([
        "success" => true,
        "message" => "Copia de seguridad creada exitosamente.",
        "file" => $backupFile,
    ]);
} catch (Exception $e) {
    // Manejo de errores
    echo json_encode([
        "success" => false,
        "message" => 'Ocurrió un Error' . $e->getMessage(),
    ]);
}
?>