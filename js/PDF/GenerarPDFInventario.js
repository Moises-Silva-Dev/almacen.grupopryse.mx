// Funci��n llamada por el bot��n al hacer clic
function Generar_PDF_Inventario(event) {
    // Prevenir el comportamiento predeterminado del bot��n (como el env��o de un formulario)
    event.preventDefault();

    // URL del archivo PHP que genera el PDF
    var url = '../../Controlador/Reportes/Reporte_Inventario.php';

    // Realizar una solicitud `fetch` para obtener el PDF desde el servidor
    fetch(url, {
        method: 'GET', // Se utiliza el m��todo GET para obtener el recurso
    })
    .then(response => {
        // Obtener el tipo de contenido de la respuesta HTTP
        const contentType = response.headers.get('Content-Type');
        
        if (contentType && contentType.includes('application/json')) {
            // Si el contenido de la respuesta es JSON, se trata de un mensaje informativo o error
            return response.json().then(json => {
                // Verificar si el JSON contiene un campo `error`
                if (json.error) {
                    // Mostrar el mensaje de error en un elemento del DOM identificado por `errorMessage`
                    document.getElementById('errorMessage').innerText = json.error;

                    // Mostrar la ventana modal que contiene el mensaje de error
                    var myModalError = new bootstrap.Modal(document.getElementById('pdfModalERROR'));
                    myModalError.show(); // Mostrar la ventana modal
                }
            });
        } else {
            // Si el contenido no es JSON, se asume que es un archivo PDF
            return response.blob().then(blob => {
                // Crear una URL temporal para el archivo PDF
                var pdfUrl = URL.createObjectURL(blob);

                // Asignar la URL del PDF al iframe para mostrarlo
                document.getElementById('pdfIframe').src = pdfUrl;

                // Mostrar la ventana modal que contiene el visor de PDF
                $('#pdfModal').modal('show');
            });
        }
    })
    // Capturar y manejar cualquier error ocurrido durante la solicitud o procesamiento de datos
    .catch(error => console.error('Error:', error));
}

// Manejador de eventos para cuando se cierra la ventana modal
$('#pdfModal').on('hidden.bs.modal', function () {
    // Limpiar el atributo `src` del iframe para liberar la URL del PDF
    $('#pdfIframe').attr('src', '');
});