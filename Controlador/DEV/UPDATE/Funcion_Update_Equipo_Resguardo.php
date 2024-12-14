<?php
// Iniciamos sesión
session_start();

function actualizarResguardoEquipo($conexion, $id_equipo, $marca, $modelo, $tipo, $procesador, $gb_ram, $almacenamiento, $tipo_almacenamiento, $id_colaborador) {
    // Preparar la consulta SQL para actualizar el resguardo de equipo
    $sql = "UPDATE Respaldo_Equipo SET 
            Marca = ?,
            Modelo = ?,
            Tipo = ?,
            Procesador = ?,
            GbRAM = ?,
            Almacenamiento = ?,
            Tipo_Almacenamiento = ?,
            ID_Colaboradores = ?
            WHERE ID_Equipo = ?";

    // Preparar la sentencia
    $stmt = $conexion->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("ssssiissi", $marca, $modelo, $tipo, $procesador, $gb_ram, $almacenamiento, $tipo_almacenamiento, $id_colaborador, $id_equipo);

    // Ejecutar la consulta
    return $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conectar a la base de datos
    include('../../../Modelo/Conexion.php'); 
    $conexion = (new Conectar())->conexion();

    // Obtener datos del formulario
    $id_equipo = $_POST['id_equipo'];
    $marca = $_POST['Marca'];
    $modelo = $_POST['Modelo'];
    $tipo = $_POST['Tipo'];
    $procesador = $_POST['Procesador'];
    $gb_ram = $_POST['GbRAM'];
    $almacenamiento = $_POST['Almacenamiento'];
    $tipo_almacenamiento = $_POST['Tipo_Almacenamiento'];
    $id_colaborador = $_POST['ID_Colaborador'];

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Actualizar el resguardo del equipo
        if (actualizarResguardoEquipo($conexion, $id_equipo, $marca, $modelo, $tipo, $procesador, $gb_ram, $almacenamiento, $tipo_almacenamiento, $id_colaborador)) {
            // Confirmar la transacción
            $conexion->commit();

            // Éxito: redirige o muestra un mensaje
            echo '<script type="text/javascript">';
            echo 'alert("¡Registro modificado exitosamente!");';
            echo 'window.location = "../../../Vista/DEV/Resguardo_Equipo_Dev.php";';
            echo '</script>';
            exit();
        } else {
            // Lanzar una excepción para activar el bloque catch
            throw new Exception("Error al intentar modificar el registro.");
        }
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();

        // Muestra un mensaje de error
        echo '<script type="text/javascript">';
        echo 'alert("Error: ' . $e->getMessage() . '");';
        echo 'window.location = "../../../Vista/DEV/Resguardo_Equipo_Dev.php";';
        echo '</script>';
        exit();
    } finally {
        // Cierra la conexión
        $conexion->close();
    }
} else {
    // Si no es una solicitud POST, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: Acceso no permitido.");';
    echo 'window.location = "../../../Vista/DEV/Resguardo_Equipo_Dev.php";';
    echo '</script>';
    exit();
}
?>