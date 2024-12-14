<?php
// Establecer la configuración regional y la zona horaria
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/Mexico_City');

// Configuración de la base de datos
$mysqlUserName = "grupova9_TecPryse";
$mysqlPassword = "M0ch1t*_619";
$mysqlHostName = "localhost";
$DbName = "grupova9_Pryse";

// Directorio donde se guardarán las copias de seguridad
$backupDirectory = "./backups";

// Prefijo para el nombre del archivo de copia de seguridad
$backupPrefix = "backup_";

// Formato de fecha y hora para el nombre del archivo de copia de seguridad
$dateTimeFormat = "Y-m-d_H-i-s";

// Definir el orden deseado de las tablas en la copia de seguridad
$tableOrder = array(
    'Regiones',
    'Estados',
    'Estado_Region',
    'Cuenta',
    'Cuenta_Region',
    'Centro_Trabajo',
    'Tipo_Usuarios',
    'Tipo_Colaboradores',
    'Usuario',
    'Colaborador',
    'Respaldo_Equipo',
    'CEmpresas',
    'CCategorias',
    'CTipoTallas',
    'CTallas',
    'Producto',
    'Inventario',
    'EntradaE',
    'EntradaD',
    'RequisicionE',
    'RequisicionD',
    'Borrador_RequisicionE',
    'Borrador_RequisicionD',
    'Salida_E',
    'Salida_D'
);

// Llamar a la función de copia de seguridad de la base de datos
backupDatabase($mysqlHostName, $mysqlUserName, $mysqlPassword, $DbName, $backupDirectory, $backupPrefix, $dateTimeFormat, $tableOrder);

// Función para realizar la copia de seguridad de la base de datos
function backupDatabase($host, $user, $pass, $name, $backupDirectory, $backupPrefix, $dateTimeFormat, $tableOrder)
{
    // Crear el directorio de copias de seguridad si no existe
    if (!is_dir($backupDirectory)) {
        mkdir($backupDirectory, 0755, true);
    }

    try {
        // Establecer la conexión con la base de datos
        $mysqli = new mysqli($host, $user, $pass, $name);

        // Verificar si la conexión fue exitosa
        if ($mysqli->connect_error) {
            throw new Exception("Connection failed: " . $mysqli->connect_error);
        }

        // Seleccionar la base de datos
        $mysqli->select_db($name);
        $mysqli->query("SET NAMES 'utf8'");

        // Obtener la lista de tablas en la base de datos
        $tables = array();
        $queryTables = $mysqli->query('SHOW TABLES');

        while ($row = $queryTables->fetch_row()) {
            $tables[] = $row[0];
        }

        // Crear el nombre del archivo de copia de seguridad
        $backupFile = $backupDirectory . '/' . $backupPrefix . date($dateTimeFormat) . '.sql';

        // Abrir el archivo de copia de seguridad en modo escritura
        $handle = fopen($backupFile, 'w');

        // Verificar si se pudo abrir el archivo
        if (!$handle) {
            throw new Exception("Cannot open backup file for writing.");
        }

        // Agregar detalles de conexión MySQL al archivo de copia de seguridad
        fwrite($handle, "-- MySQL Host: $host\n");
        fwrite($handle, "-- MySQL User: $user\n");
        fwrite($handle, "-- MySQL Password: $pass\n");
        fwrite($handle, "-- Database Name: $name\n\n");

        // Loop sobre las tablas en el orden deseado
        foreach ($tableOrder as $table) {
            // Obtener la estructura de la tabla
            $result = $mysqli->query('SHOW CREATE TABLE ' . $table);
            $tableMLine = $result->fetch_row();

            // Escribir la estructura de la tabla en el archivo de copia de seguridad
            fwrite($handle, "-- Table structure for table `$table`\n");
            fwrite($handle, $tableMLine[1] . ";\n\n");

            // Escribir los datos de la tabla en el archivo de copia de seguridad
            fwrite($handle, "-- Dumping data for table `$table`\n");
            $result = $mysqli->query('SELECT * FROM ' . $table);
            $fieldsAmount = $result->field_count;

            while ($row = $result->fetch_row()) {
                fwrite($handle, "INSERT INTO $table VALUES (");
                for ($j = 0; $j < $fieldsAmount; $j++) {
                    $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
                    if (isset($row[$j])) {
                        fwrite($handle, '"' . $row[$j] . '"');
                    } else {
                        fwrite($handle, '""');
                    }
                    if ($j < ($fieldsAmount - 1)) {
                        fwrite($handle, ',');
                    }
                }
                fwrite($handle, ");\n");
            }

            // Agregar una línea en blanco después de cada tabla
            fwrite($handle, "\n");
        }

        // Obtener y escribir procedimientos almacenados, funciones y triggers
        $queryProcedures = $mysqli->query("SHOW PROCEDURE STATUS WHERE Db = '$name'");
        $queryFunctions = $mysqli->query("SHOW FUNCTION STATUS WHERE Db = '$name'");
        $queryTriggers = $mysqli->query("SHOW TRIGGERS FROM $name");

        while ($row = $queryProcedures->fetch_assoc()) {
            $procedureName = $row['Name'];
            $result = $mysqli->query("SHOW CREATE PROCEDURE $procedureName");
            $procedureMLine = $result->fetch_row();
            fwrite($handle, "-- Procedure structure for procedure `$procedureName`\n");
            fwrite($handle, $procedureMLine[2] . ";\n\n");
        }

        while ($row = $queryFunctions->fetch_assoc()) {
            $functionName = $row['Name'];
            $result = $mysqli->query("SHOW CREATE FUNCTION $functionName");
            $functionMLine = $result->fetch_row();
            fwrite($handle, "-- Function structure for function `$functionName`\n");
            fwrite($handle, $functionMLine[2] . ";\n\n");
        }

        while ($row = $queryTriggers->fetch_assoc()) {
            $triggerName = $row['Trigger'];
            $result = $mysqli->query("SHOW CREATE TRIGGER $triggerName");
            $triggerMLine = $result->fetch_row();
            fwrite($handle, "-- Trigger structure for trigger `$triggerName`\n");
            fwrite($handle, $triggerMLine[2] . ";\n\n");
        }

        // Cerrar el archivo de copia de seguridad
        fclose($handle);

        // Mostrar un mensaje de éxito en JavaScript
        echo '<script type="text/javascript">';
        echo 'alert("¡Copia de seguridad de la base de datos completada exitosamente!\n ¡Archivo guardado como: ' . $backupFile . '!");';
        echo 'window.location = "../Vista/DEV/Restauracion_SQL_Dev.php";';
        echo '</script>';

    } catch (Exception $e) {
        // Manejar cualquier excepción y mostrar un mensaje de error
        echo "Error: " . $e->getMessage(); 
    }
}
?>