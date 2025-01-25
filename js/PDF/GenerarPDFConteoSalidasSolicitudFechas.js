// Este script JavaScript se encarga de generar un PDF de conteo de salida de requisiciones de almacén basado en las fechas seleccionadas en un formulario. 
// Una vez que se envían las fechas al script PHP que genera el PDF, el PDF se muestra en un visor dentro de una ventana modal.
function Generar_PDF_Conteo_Salidas_Solicitud_Fechas(event) {
    // Previene el comportamiento por defecto del formulario (evita el envío del formulario y recarga de la página)
    event.preventDefault();
    
    // Obtener el formulario de entradas por fechas a través de su ID
    var form = document.getElementById('conteoSalidaSolicitudFormFechas');
    
    // Verificar si el formulario cumple con las reglas de validación
    if (!form.checkValidity()) {
        // Agregar una clase CSS para mostrar visualmente los errores de validación
        form.classList.add('was-validated');
        return; // Salir de la función si el formulario no es válido
    }

    // Crear un objeto FormData para recopilar los datos del formulario
    var formData = new FormData(form);
    
    // URL del script PHP que generará el PDF en el servidor
    var url = '../../Controlador/Reportes/Reporte_Conteo_Salidas_Requisiciones.php';

    // Realizar una solicitud fetch para enviar los datos del formulario
    fetch(url, {
        method: 'POST', // Especificar el método HTTP
        body: formData   // Incluir los datos del formulario en la solicitud
    })
    // Convertir la respuesta del servidor en un objeto Blob
    .then(response => response.blob())
    .then(blob => {
        // Convertir el Blob a texto para verificar si contiene un mensaje de error
        return blob.text().then(text => {
            try {
                // Intentar analizar el contenido como JSON
                const json = JSON.parse(text);
                
                // Verificar si el JSON contiene un mensaje de error
                if (json.error) {
                    // Mostrar el mensaje de error en el elemento correspondiente
                    document.getElementById('errorMessage').innerText = json.error;

                    // Mostrar la ventana modal que indica el error
                    var myModalError = new bootstrap.Modal(document.getElementById('pdfModalERROR'));
                    myModalError.show();
                } else {
                    // Si no hay error en el JSON, interpretar el texto como contenido PDF
                    var pdfBlob = new Blob([text], { type: 'application/pdf' });
                    var pdfUrl = URL.createObjectURL(pdfBlob);

                    // Establecer la fuente del visor de PDF para mostrar el PDF generado
                    document.getElementById('pdfIframeConteoSalidasSolicitudFechas').src = pdfUrl;

                    // Mostrar la ventana modal con el visor de PDF
                    var myModal = new bootstrap.Modal(document.getElementById('pdfModalConteoSalidasSolicitudFechas'));
                    myModal.show();
                }
            } catch (e) {
                // Si no es JSON válido, tratar el Blob directamente como contenido PDF
                var pdfUrl = URL.createObjectURL(blob);
                
                // Establecer la fuente del visor de PDF
                document.getElementById('pdfIframeConteoSalidasSolicitudFechas').src = pdfUrl;

                // Mostrar la ventana modal con el visor de PDF
                var myModal = new bootstrap.Modal(document.getElementById('pdfModalConteoSalidasSolicitudFechas'));
                myModal.show();
            }
        });
    })
    // Manejar errores en la solicitud o en el procesamiento de datos
    .catch(error => console.error('Error:', error));
}