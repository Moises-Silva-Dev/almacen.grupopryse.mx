<?php
// Iniciamos sesión
session_start();
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/Mexico_City');

function actualizarRegion($conexion, $Nombre_Region, $registro, $id_region) {
    $sql = "UPDATE Regiones SET 
            Nombre_Region = ?,
            Fch_Registro = ?
            WHERE ID_Region = ?;";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssi", $Nombre_Region, $registro, $id_region);
    return $stmt->execute();
}

function updateRegionCuenta($conexion, $ID_Cuenta, $id_region) {
    $sql = "UPDATE Cuenta_Region SET ID_Cuentas = ? WHERE ID_Regiones = ?;";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $ID_Cuenta, $id_region);
    return $stmt->execute();
}

function deleteEstadoRegion($conexion, $id_region) {
    $sql = "DELETE FROM Estado_Region WHERE ID_Regiones = ?;";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_region);
    return $stmt->execute();
}

function insertarNuevoEstadoRegion($conexion, $id_region, $idEstado) {
    $sql = "INSERT INTO Estado_Region (ID_Regiones, ID_Estados) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $id_region, $idEstado);
    return $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../../Modelo/Conexion.php'); 
    $conexion = (new Conectar())->conexion();

    if (!$conexion) {
        echo '<script type="text/javascript">';
        echo 'alert("Error: No se pudo conectar a la base de datos.");';
        echo 'window.location = "../../../Vista/DEV/Regiones_Dev.php";';
        echo '</script>';
        exit();
    }

    $ID_Cuenta = $_POST['ID_Cuenta'];
    $id_region = $_POST['id_region'];
    $Nombre_Region = $_POST['Nombre_Region'];
    $registro = date('Y-m-d H:i:s', time());

    $conexion->begin_transaction();

    try {
        if (actualizarRegion($conexion, $Nombre_Region, $registro, $id_region)) {
            updateRegionCuenta($conexion, $ID_Cuenta, $id_region);
            deleteEstadoRegion($conexion, $id_region);

            if (isset($_POST['datosTabla'])) {
                $datosTabla = json_decode($_POST['datosTabla'], true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    $numFilas = count($datosTabla);

                    for ($i = 0; $i < $numFilas; $i++) {
                        $idEstado = $datosTabla[$i]['idEstado'];
                        insertarNuevoEstadoRegion($conexion, $id_region, $idEstado);
                    }
                } else {
                    throw new Exception("Los datos de la tabla no están en el formato JSON esperado.");
                }
            } else {
                throw new Exception("No se recibieron datos de la tabla.");
            }

            $conexion->commit();
            echo '<script type="text/javascript">';
            echo 'alert("¡Registro modificado exitosamente!");';
            echo 'window.location = "../../../Vista/DEV/Regiones_Dev.php";';
            echo '</script>';
            exit();
        } else {
            throw new Exception("Error al intentar modificar el registro.");
        }
    } catch (Exception $e) {
        $conexion->rollback();
        echo '<script type="text/javascript">';
        echo 'alert("Error: ' . $e->getMessage() . '");';
        echo 'window.location = "../../../Vista/DEV/Regiones_Dev.php";';
        echo '</script>';
        exit();
    } finally {
        // Cierra todas las sentencias utilizadas
        $conexion->close();
    }
} else {
    echo '<script type="text/javascript">';
    echo 'alert("Error: Acceso no permitido.");';
    echo 'window.location = "../../../Vista/DEV/Regiones_Dev.php";';
    echo '</script>';
    exit();
}
?>