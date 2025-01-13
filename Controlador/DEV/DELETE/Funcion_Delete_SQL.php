<?php
header('Content-Type: application/json');

if (isset($_GET['archivo'])) {
    $archivo = $_GET['archivo'];
    $ruta_archivo = '../../../Modelo/backups/' . $archivo;

    if (unlink($ruta_archivo)) {
        echo json_encode([
            'success' => true,
            'message' => "¡El archivo $archivo ha sido eliminado correctamente!",
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => "¡Error al intentar eliminar el archivo $archivo!",
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => "No se proporcionó el nombre del archivo.",
    ]);
}
?>