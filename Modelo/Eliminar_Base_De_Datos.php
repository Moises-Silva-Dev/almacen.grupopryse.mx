<?php
// Respuesta tipo JSON
header('Content-Type: application/json');

// Establecer configuración regional
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/Mexico_City');

// 1. Validar método (Opcional pero recomendado: usar DELETE o POST en lugar de GET)
// Por seguridad, las acciones destructivas no deberían hacerse por GET,
// pero si necesitas mantenerlo así, asegúrate de tener autenticación.

if (!isset($_GET['archivo']) || empty($_GET['archivo'])) {
    echo json_encode(['success' => false, 'message' => 'No se proporcionó el nombre del archivo.']);
    exit;
}

// 2. SEGURIDAD: Limpiar el nombre del archivo
// basename() elimina cualquier ruta de directorio (como ../ o /home/user/)
$nombreArchivo = basename(urldecode($_GET['archivo']));
$rutaBase = __DIR__ . '/backups/'; // Usar __DIR__ es más seguro para rutas absolutas
$rutaCompleta = $rutaBase . $nombreArchivo;

// 3. Verificaciones de seguridad adicionales
// Asegurarnos de que el archivo realmente está dentro de la carpeta backups y no es un directorio
if (!file_exists($rutaCompleta) || is_dir($rutaCompleta)) {
    echo json_encode(['success' => false, 'message' => 'El archivo no existe o no es válido.']);
    exit;
}

// 4. Intentar eliminar
// Usamos el operador de supresión de errores (@) para evitar que PHP imprima
// un warning en el HTML si falla, lo cual rompería el JSON.
if (@unlink($rutaCompleta)) {
    echo json_encode([
        "success" => true,
        "message" => "Copia eliminada exitosamente.",
        "file" => $nombreArchivo, // Variable corregida
    ]);
} else {
    // Obtener el último error si existe
    $error = error_get_last();
    $mensajeError = isset($error['message']) ? $error['message'] : 'Error desconocido de permisos o bloqueo.';

    echo json_encode([
        "success" => false,
        "message" => 'Ocurrió un error al eliminar: ' . $mensajeError,
    ]);
}
?>