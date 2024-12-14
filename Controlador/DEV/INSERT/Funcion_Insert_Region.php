<?php
// Iniciar sesión
session_start();
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/Mexico_City');

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();

    // Recuperar los datos del formulario
    $ID_Cuenta = $_POST["ID_Cuenta"];
    $Nombre_Region = $_POST["Nombre_Region"];
    $registro = date('Y-m-d H:i:s', time()); // Obtener la fecha y hora actual

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Recuperar la ID de la región
        $ID_region = insertarNuevoRegion($conexion, $Nombre_Region, $registro);
        
        // Insertar en la tabla Region_Cuenta
        insertarNuevoRegionCuenta($conexion, $ID_Cuenta, $ID_region);

        // Verifica si $_POST['datosTabla'] está definido
        if (isset($_POST['datosTabla'])) {
            // Decodifica los datos del formulario
            $datosTabla = json_decode($_POST['datosTabla'], true);

            // Verifica si la decodificación fue exitosa
            if (json_last_error() === JSON_ERROR_NONE) {
                // Obtiene la cantidad de filas en los datos de la tabla
                $numFilas = count($datosTabla);

                // Itera sobre los datos de la tabla oculta utilizando un bucle for
                for ($i = 0; $i < $numFilas; $i++) {
                    $idEstado = $datosTabla[$i]['idEstado'];

                    // Inserta en la tabla Estado_Region
                    insertarNuevoEstadoRegion($conexion, $ID_region, $idEstado);
                }
            } else {
                // Maneja el caso en el que $_POST['datosTabla'] no es un JSON válido
                throw new Exception("Los datos de la tabla no están en el formato JSON esperado.");
            }
        } else {
            // Maneja el caso en el que $_POST['datosTabla'] no está definido
            throw new Exception("No se recibieron datos de la tabla.");
        }

        // Si todo fue bien, hacer commit de la transacción
        $conexion->commit();

        // Éxito: mostrar un mensaje
        echo '<script type="text/javascript">';
        echo 'alert("¡El registro fue exitoso!");';
        echo 'window.location = "../../../Vista/DEV/Regiones_Dev.php";'; // Reemplazar con la ruta de redirección deseada
        echo '</script>';
        exit();

    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();

        // Mostrar un mensaje de error
        echo '<script type="text/javascript">';
        echo 'alert("ERROR: ' . $e->getMessage() . '");';
        echo 'window.location = "../../../Vista/DEV/INSERT/Insert_Region_Dev.php";'; // Reemplazar con la ruta de redirección de error deseada
        echo '</script>';
        exit();
    } finally {
        // Cerrar la conexión
        $conexion->close();
    }
}

// Función para insertar un nuevo registro de regiones en la base de datos
function insertarNuevoRegion($conexion, $Nombre_Region, $registro) {
    // Preparar consulta SQL para insertar el registro
    $sql = "INSERT INTO Regiones (Nombre_Region, Fch_Registro) VALUES (?, ?)";

    // Preparar la sentencia
    $stmt_count = $conexion->prepare($sql);

    // Vincular parámetros
    $stmt_count->bind_param("ss", $Nombre_Region, $registro);

    // Ejecutar la consulta
    $stmt_count->execute();

    // returna la ID
    return $conexion->insert_id;
}

// Función para insertar un nuevo registro en la base de datos
function insertarNuevoRegionCuenta($conexion, $ID_Cuenta, $ID_region) {
    // Preparar consulta SQL para insertar el registro
    $sql = "INSERT INTO Cuenta_Region (ID_Cuentas, ID_Regiones) VALUES (?, ?)";

    // Preparar la sentencia
    $stmt_count = $conexion->prepare($sql);

    // Vincular parámetros
    $stmt_count->bind_param("ii", $ID_Cuenta, $ID_region);

    // Ejecutar la consulta
    return $stmt_count->execute();
}

// Función para insertar un nuevo registro en la base de datos
function insertarNuevoEstadoRegion($conexion, $ID_region, $idEstado) {
    // Preparar consulta SQL para insertar el registro
    $sql = "INSERT INTO Estado_Region (ID_Regiones, ID_Estados) VALUES (?, ?)";

    // Preparar la sentencia
    $stmt_count = $conexion->prepare($sql);

    // Vincular parámetros
    $stmt_count->bind_param("ii", $ID_region, $idEstado);

    // Ejecutar la consulta
    return $stmt_count->execute();
}
?>