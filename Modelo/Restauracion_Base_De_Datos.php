<?php
header('Content-Type: application/json'); 

// Configuración de la base de datos
$user = "root";
$password = "";
$host = "localhost";
$database = "grupova9_Pryse";

// Directorio donde se guardarán las copias de seguridad
$backupDirectory = "./backups";
$backupPrefix = "backup_";
$dateTimeFormat = "Y-m-d_H-i-s";

// Verificar si se proporcionó el nombre del archivo
if (isset($_GET['archivo'])) {
    // Obtener el nombre del archivo desde la variable GET
    $archivo = $_GET['archivo'];

    // **Ejecutar respaldo y restauración**
    $backupFile = crearRespaldo($host, $user, $password, $database, $backupDirectory, $backupPrefix, $dateTimeFormat);
    
    // Verificar si se pudo crear el respaldo
    if (!$backupFile) {
        // Si no se pudo crear el archivo de respaldo, mostrar un mensaje de error
        echo json_encode(["success" => false, "message" => "Error al crear respaldo."]);
        exit(); // Salir del script
    }

    // Verificar si se proporcionó el nombre del archivo a restaurar
    if (!restaurarBaseDatos($host, $user, $password, $database, $archivo)) {
        // Si no se pudo restaurar la base de datos, mostrar un mensaje de error
        echo json_encode(["success" => false, "message" => "Error al restaurar base de datos."]);
        exit(); // Salir del script
    }

    // **Respuesta final**
    echo json_encode([
        "success" => true, // Indicar que la operación se realizó con éxito
        "message" => "Respaldo y restauración completados exitosamente.", // Mensaje de confirmación
        "backup_file" => $backupFile
    ]);
} else {
    // Retorna la respuesta en False
    echo json_encode([
        'success' => false,
        'message' => 'No se proporcionó el nombre del archivo.',
    ]);
}

// Función para crear respaldo de la base de datos
function crearRespaldo($host, $user, $password, $database, $backupDirectory, $backupPrefix, $dateTimeFormat) {
    try {
        // Crear el directorio de copias de seguridad si no existe
        if (!is_dir($backupDirectory)) {
            // Crear el directorio
            mkdir($backupDirectory, 0755, true);
        }

        // Establecer la conexión con la base de datos
        $mysqli = new mysqli($host, $user, $password, $database);

        // Verificar si la conexión fue exitosa
        if ($mysqli->connect_error) {
            // Si la conexión falló, devolver false
            throw new Exception("Error de conexión: " . $mysqli->connect_error);
        }

        // Seleccionar la base de datos
        $mysqli->select_db($database);
        
        // Establecer el conjunto de caracteres
        $mysqli->query("SET NAMES 'utf8'"); 

        // Crear el nombre del archivo de copia de seguridad
        $backupFile = $backupDirectory . '/' . $backupPrefix . date($dateTimeFormat) . '.sql';

        // Abrir el archivo de copia de seguridad en modo escritura
        $handle = fopen($backupFile, 'w');

        // Realizar la copia de seguridad de la base de datos
        if (!$handle) {
            // Si no se puede abrir el archivo, devolver mensaje            
            throw new Exception("No se pudo abrir el archivo de copia de seguridad para escritura.");
        }

        // Escribir encabezados en el archivo de respaldo
        fwrite($handle, "-- Respaldo de la base de datos `$database`\n");
        fwrite($handle, "-- Fecha de creación: " . date('Y-m-d H:i:s') . "\n");
        fwrite($handle, "-- Host: $host\n");
        fwrite($handle, "-- Usuario: $user\n");
        fwrite($handle, "-- Password: $password\n\n");
        fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n\n");

        // Obtener la lista de tablas en la base de datos
        $tables = [];

        // Obtener la lista de tablas
        $queryTables = $mysqli->query('SHOW TABLES');

        // Recorrer las tablas
        while ($row = $queryTables->fetch_row()) {
            $tables[] = $row[0]; // Agregar el nombre de la tabla a la lista
        }

        // Escribir la estructura y datos de las tablas en el archivo
        foreach ($tables as $table) {
            // Estructura de la tabla
            $result = $mysqli->query('SHOW CREATE TABLE ' . $table);
            // Obtener la estructura de la tabla
            $tableMLine = $result->fetch_row();
            // Escribir la estructura de la tabla en el archivo
            fwrite($handle, "-- Estructura de la tabla `$table`\n");
            // Escribir la estructura de la tabla en el archivo
            fwrite($handle, $tableMLine[1] . ";\n\n");

            // Datos de la tabla
            fwrite($handle, "-- Datos de la tabla `$table`\n");
            // Obtener los datos de la tabla
            $result = $mysqli->query('SELECT * FROM ' . $table);
            // Recorrer los datos de la tabla
            $fieldsAmount = $result->field_count;

            // Escribir los datos de la tabla en el archivo
            while ($row = $result->fetch_row()) {
                // Escribir los datos de la tabla en el archivo
                fwrite($handle, "INSERT INTO `$table` VALUES (");
                // Recorrer los campos de la fila
                for ($j = 0; $j < $fieldsAmount; $j++) {
                    // Escribir el valor del campo en el archivo
                    $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
                    // Escribir el valor del campo en el archivo
                    fwrite($handle, isset($row[$j]) ? '"' . $row[$j] . '"' : 'NULL');
                    // Agregar una coma después del valor del campo
                    if ($j < ($fieldsAmount - 1)) fwrite($handle, ',');
                }
                // Agregar un cierre de paréntesis después de los valores de la fila
                fwrite($handle, ");\n");
            }
            // Agregar un salto de línea después de los datos de la tabla
            fwrite($handle, "\n");
        }

        // Obtener y respaldar procedimientos almacenados
        $queryProcedures = $mysqli->query("SHOW PROCEDURE STATUS WHERE Db = '$database'");
        // Recorrer los procedimientos almacenados
        while ($row = $queryProcedures->fetch_assoc()) {
            // Obtener el nombre del procedimiento almacenado
            $procedureName = $row['Name']; 
            // Obtener la estructura del procedimiento almacenado
            $result = $mysqli->query("SHOW CREATE PROCEDURE `$procedureName`"); 
            // Obtener la estructura del procedimiento almacenado
            $procedureMLine = $result->fetch_assoc(); 
            // Escribir el procedimiento almacenado en el archivo
            fwrite($handle, "-- Procedimiento almacenado `$procedureName`\n"); 
            // Escribir el procedimiento almacenado en el archivo
            fwrite($handle, $procedureMLine['Create Procedure'] . ";\n\n"); 
        }

        // Obtener y respaldar funciones almacenadas
        $queryFunctions = $mysqli->query("SHOW FUNCTION STATUS WHERE Db = '$database'");
        // Recorrer las funciones almacenadas
        while ($row = $queryFunctions->fetch_assoc()) {
            // Obtener el nombre de la función almacenada
            $functionName = $row['Name'];
            // Obtener la estructura de la función almacenada
            $result = $mysqli->query("SHOW CREATE FUNCTION `$functionName`");
            // Obtener la estructura de la función almacenada
            $functionMLine = $result->fetch_assoc();
            // Escribir la función almacenada en el archivo
            fwrite($handle, "-- Función almacenada `$functionName`\n");
            // Escribir la función almacenado en el archivo
            fwrite($handle, $functionMLine['Create Function'] . ";\n\n");
        }

        // Obtener y respaldar triggers
        $queryTriggers = $mysqli->query("SHOW TRIGGERS");
        // Recorrer los triggers
        while ($row = $queryTriggers->fetch_assoc()) {
            // Obtener el nombre del trigger
            $triggerName = $row['Trigger'];
            // Obtener la estructura del trigger
            $result = $mysqli->query("SHOW CREATE TRIGGER `$triggerName`");
            // Obtener la estructura del trigger
            $triggerMLine = $result->fetch_assoc();
            // Escribir el trigger en el archivo
            fwrite($handle, "-- Trigger `$triggerName`\n");
            // Escribir el trigger en el archivo
            fwrite($handle, $triggerMLine['SQL Original Statement'] . ";\n\n");
        }

        // Finalizar el archivo de respaldo
        fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");
        fclose($handle); // Cerrar el archivo de respaldo

        // Devolver el nombre del archivo de respaldo
        return $backupFile;
    } catch (Exception $e) {
        return false; // o cualquier otro valor que desee devolver
    } finally {
        // Cierra la conexión de la base de datos
        $mysqli->close();
    }
}

// Función para restaurar la base de datos
function restaurarBaseDatos($host, $user, $password, $database, $archivo) {
    try {
        // Ruta completa al archivo de respaldo
        $ruta_archivo = 'backups/' . $archivo;

        // Conectar a la base de datos
        $conn = new mysqli($host, $user, $password, $database);

        // Verificar si la conexión fue exitosa
        if ($conn->connect_error) {
            // Si hay un error de conexión, devolver false
            throw new Exception("Error de conexión: " . $conn->connect_error);
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
            return true;
        } else {
            // Si hay un error, devuelve el error
            return false;
        }
    } catch (Exception $e) {
        // Si hay un error, devuelve el mensaje de error
        return false;
    } finally {
        // Cierra la conexión de la base de datos
        $conn->close();
    }
}
?>