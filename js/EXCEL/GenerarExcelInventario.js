// Función para generar y descargar un archivo Excel basado en las fechas seleccionadas en el formulario
function Generar_Excel_Inventario(event) {
    // Previene el comportamiento por defecto del formulario (evita el envío y recarga de la página)
    event.preventDefault();
        
    // Crear la URL para enviar las fechas al script PHP que genera el archivo Excel
    var url = '../../Controlador/EXCEL/Excel_Inventario.php';

    // Usar fetch para realizar la solicitud al servidor con el método GET
    fetch(url, {
        method: 'GET', // Indica que los datos se solicitan mediante el método GET
    })
    // Verificar si la respuesta del servidor fue exitosa
    .then(response => {
        if (!response.ok) {
            // Lanzar un error si la respuesta no es satisfactoria (status code >= 400)
            throw new Error('Error en la respuesta del servidor: ' + response.statusText);
        }
        // Convertir la respuesta a un objeto Blob (representación binaria del archivo)
        return response.blob();
    })
    // Manejar el Blob recibido para descargar el archivo Excel
    .then(blob => {
        // Crear una URL temporal para el archivo Blob
        var url = URL.createObjectURL(blob);
            
        // Crear un elemento <a> dinámicamente para descargar el archivo
        var a = document.createElement('a');
        a.href = url; // Asignar la URL del archivo al atributo href
        a.download = 'Inventario_' + 
            new Date().toISOString().slice(0, 19) // Obtener la fecha y hora actual en formato ISO
            .replace(/[-T]/g, '_') // Reemplazar caracteres no válidos en nombres de archivo
            .replace(/:/g, '-') + 
            '.xlsx'; // Agregar extensión .xlsx al archivo

        // Agregar el elemento <a> al DOM, simular un clic para descargar el archivo, y luego eliminarlo
        document.body.appendChild(a); // Agregar el enlace al DOM
        a.click(); // Simular el clic en el enlace para iniciar la descarga
        document.body.removeChild(a); // Eliminar el enlace del DOM después de descargar
            
        // Revocar la URL temporal para liberar memoria
        URL.revokeObjectURL(url);
    })
    // Manejar errores si ocurren durante la solicitud fetch o procesamiento del archivo
    .catch(error => console.error('Error al generar el archivo Excel:', error)); 
}