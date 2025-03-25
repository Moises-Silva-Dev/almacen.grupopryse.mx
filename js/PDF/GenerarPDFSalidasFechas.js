// Este script JavaScript se encarga de generar un PDF de salidas de almacén basado en las fechas seleccionadas en un formulario. 
// Una vez que se envían las fechas al script PHP que genera el PDF, el PDF se muestra en un visor dentro de una ventana modal.
function Generar_PDF_Salidas_Fechas(event) {
    // Previene el comportamiento por defecto del formulario (evita el envío del formulario y la recarga de la página)
    event.preventDefault();
    
    // Obtener el formulario de entradas por fechas
    var form = document.getElementById('salidasFormFechas');
    
    // Verificar si el formulario cumple con las reglas de validación
    if (!form.checkValidity()) {
        // Agregar la clase CSS 'was-validated' para mostrar errores de validación visualmente
        form.classList.add('was-validated');
        return; // Salir de la función si el formulario no es válido
    }

    // Crear un objeto FormData con los datos del formulario
    var formData = new FormData(form);
    
    // URL del script PHP que procesará la solicitud y generará el PDF
    var url = '../../Controlador/Reportes/Reporte_Salida_Almacen_Por_Fechas.php';

    // Realizar una solicitud fetch para enviar los datos del formulario al servidor
    fetch(url, {
        method: 'POST', // Especificar el método HTTP
        body: formData // Incluir los datos del formulario en el cuerpo de la solicitud
    })
    // Convertir la respuesta del servidor en un objeto Blob
    .then(response => response.blob())
    .then(blob => {
        // Convertir el blob a texto para comprobar si es un error
        return blob.text().then(text => {
            try {
                // Intentar analizar el texto como JSON
                const json = JSON.parse(text);
                
                // Verificar si el JSON contiene un mensaje de error
                if (json.error) {
                    // Mostrar el mensaje de error en el modal
                    document.getElementById('errorMessage').innerText = json.error;

                    // Mostrar la ventana modal que contiene el visor de PDF
                    var myModalError = new bootstrap.Modal(document.getElementById('pdfModalERROR'));
                    myModalError.show(); // Mostrar la ventana modal
                } else {
                    // Si no hay error en el JSON, tratar el texto como contenido PDF
                    var pdfBlob = new Blob([text], { type: 'application/pdf' });
                    var pdfUrl = URL.createObjectURL(pdfBlob); // Crear una URL temporal para el Blob
                    
                    // Establecer la fuente del visor de PDF para mostrar el PDF generado
                    document.getElementById('pdfViewerSalidasFechas').src = pdfUrl;

                    // Mostrar la ventana modal que contiene el visor de PDF
                    var myModal = new bootstrap.Modal(document.getElementById('pdfModalSalidaFechas'));
                    myModal.show(); // Mostrar la ventana modal
                }
            } catch (e) {
                // Crear una URL local para el Blob generado
                var pdfUrl = URL.createObjectURL(blob);
                
                // Establecer la fuente del visor de PDF para mostrar el PDF generado
                document.getElementById('pdfViewerSalidasFechas').src = pdfUrl;

                // Mostrar la ventana modal que contiene el visor de PDF
                var myModal = new bootstrap.Modal(document.getElementById('pdfModalSalidaFechas'));
                myModal.show(); // Mostrar la ventana modal
            }
        });
    })
    // Manejar errores si ocurren durante la solicitud fetch
    .catch(error => console.error('Error:', error));
}