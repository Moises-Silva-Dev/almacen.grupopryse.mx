// Función para generar y descargar un archivo Excel basado del filtro seleccionadas en el formulario
function Generar_Excel_Filtrar_Reclutas(event) {
    // Previene el comportamiento por defecto del formulario (evita el envío del formulario y recarga de la página)
    event.preventDefault();
        
    // Obtener el formulario de filtro de reclutas
    var form = document.getElementById('reclutasFormFiltro');
        
    // Verificar si el formulario es válido
    if (!form.checkValidity()) {
        // Agregar una clase CSS para mostrar visualmente los errores de validación
        form.classList.add('was-validated');
        return; // Salir de la función si el formulario no es válido
    }

    // Crear un objeto FormData con los datos del formulario
    var formData = new FormData(form);
        
    // Definir la URL del script PHP que generará el archivo Excel
    var url = '../../Controlador/EXCEL/Excel_Filtrar_Reclutas.php';

    // Usar fetch para enviar los datos al servidor utilizando el método POST
    fetch(url, {
        method: 'POST', // Especificar el método HTTP
        body: formData   // Incluir los datos del formulario en la solicitud
    })
    // Convertir la respuesta en un objeto Blob (representación binaria del archivo generado)
    .then(response => response.blob()) 
    .then(blob => {
        // Crear una URL temporal para el objeto Blob
        var url = URL.createObjectURL(blob);
            
        // Crear dinámicamente un elemento <a> para descargar el archivo
        var a = document.createElement('a');
        a.href = url; // Asignar la URL del Blob al atributo href
        a.download = 'Filtar_Reclutas_' + 
            new Date().toISOString().slice(0, 19) // Generar una marca de tiempo
            .replace(/[-T]/g, '_') // Reemplazar caracteres no válidos en nombres de archivo
            .replace(/:/g, '-') + 
            '.xlsx'; // Agregar la extensión del archivo
            
        // Agregar el enlace temporal al DOM, simular un clic para iniciar la descarga y luego eliminarlo
        document.body.appendChild(a); // Insertar el enlace en el documento
        a.click(); // Simular un clic en el enlace
        document.body.removeChild(a); // Eliminar el enlace del DOM
            
        // Revocar la URL temporal para liberar memoria
        URL.revokeObjectURL(url);

        // Limpiar el formulario después de la descarga
        resetFormFiltro();
    })
    // Manejar errores si ocurren durante el proceso de solicitud o descarga
    .catch(error => console.error('Error:', error)); 
}