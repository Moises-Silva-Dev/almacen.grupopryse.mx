<?php
// Iniciamos sesión
session_start();

function cambiarEstatusEntrada($idEntrada) {
    // Verifica si se proporciona un ID válido
    if (!isset($idEntrada) || empty($idEntrada) || !is_numeric($idEntrada) || $idEntrada <= 0) {
        return "Error: El ID de la entrada proporcionado no es válido.";
    }

    // Incluye el archivo de conexión 
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();

    // Verifica la conexión
    if ($conexion->connect_error) {
        return "Error de conexión a la base de datos: " . $conexion->connect_error;
    }

    try {
        // Prepara la consulta SQL para cambiar el estatus a "Eliminado"
        $sql = "UPDATE EntradaE SET Estatus = 'Eliminado' WHERE IdEntE = ?";

        // Prepara la sentencia
        $stmt = $conexion->prepare($sql);

        // Vincula parámetros
        $stmt->bind_param("i", $idEntrada);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            $stmt->close();
            $conexion->close();
            return "¡Estatus cambiado a 'Eliminado' exitosamente!";
        } else {
            $stmt->close();
            $conexion->close();
            return "Error al intentar cambiar el estatus de la entrada.";
        }
    } catch (Exception $e) {
        // Maneja la excepción
        return "Error: " . $e->getMessage();
    }
}

// Verifica si se proporciona un ID a través de GET
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $idEntrada = $_GET['id'];
    $mensaje = cambiarEstatusEntrada($idEntrada);

    echo '<script type="text/javascript">';
    echo 'alert("' . $mensaje . '");';
    echo 'window.location = "../../../Vista/ALMACENISTA/Almacen_ALMACENISTA.php";'; // Reemplaza con la ruta de redirección deseada
    echo '</script>';
    exit();
} else {
    // Si no se proporciona el ID, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: No se proporcionó un ID válido.");';
    echo 'window.location = "../../../Vista/ALMACENISTA/Almacen_ALMACENISTA.php";'; // Reemplaza con la ruta de redirección de error deseada
    echo '</script>';
    exit();
}
?>