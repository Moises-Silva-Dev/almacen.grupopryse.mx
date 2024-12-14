<?php
// Verifica si se proporcionó el nombre del archivo a eliminar
if (isset($_GET['archivo'])) {
    // Obtiene el nombre del archivo desde la variable GET
    $archivo = $_GET['archivo'];
    
    // Ruta completa al archivo a eliminar
    $ruta_archivo = '../../../Modelo/backups/' . $archivo;

    // Intenta eliminar el archivo
    if (unlink($ruta_archivo)) {
        // Si la eliminación fue exitosa, muestra un mensaje de éxito en JavaScript
        echo '<script type="text/javascript">';
        echo 'alert("¡El archivo ' . $archivo . ' ha sido eliminado correctamente!");';
        echo 'window.location = "../../../Vista/DEV/Restauracion_SQL_Dev.php";';
        echo '</script>';
    } else {
        // Si hubo un error al intentar eliminar el archivo, muestra un mensaje de error en JavaScript
        echo '<script type="text/javascript">';
        echo 'alert("¡Error al intentar eliminar el archivo ' . $archivo . '.!");';
        echo 'window.location = "../../../Vista/DEV/Restauracion_SQL_Dev.php";';
        echo '</script>';
    }
} else {
    // Si no se proporcionó el nombre del archivo, muestra un mensaje indicando esto
    echo 'No se proporcionó el nombre del archivo.';
}
?>