// Este script JavaScript se encarga de generar un PDF de solicitudes basado en las fechas seleccionadas en un formulario. Una vez que se envían las fechas al script PHP que genera el PDF, el PDF se muestra en un visor dentro de una ventana modal.
function Generar_PDF_Solicitud_Fechas(event) {
    // Previene el comportamiento por defecto del formulario (evita el envío de formulario)
    event.preventDefault();
    
    // Obtener el formulario de entradas por fechas
    var form = document.getElementById('solicitudFormFechas');
    
    // Verificar si el formulario es válido
    if (!form.checkValidity()) {
        // Agregar una clase de validación si el formulario no es válido y salir de la función
        form.classList.add('was-validated');
        return;
    }

    // Crear un objeto FormData con los datos del formulario
    var formData = new FormData(form);
    
    // URL del script PHP que procesará la solicitud y generará el PDF
    var url = '../../Controlador/Reportes/Reporte_Solicitud_Por_Fechas.php';

    // Realizar una solicitud fetch para enviar los datos del formulario al servidor
    fetch(url, {
        method: 'POST',
        body: formData
    })
    // Convertir la respuesta a un objeto Blob
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
                    myModalError.show();
                } else {
                    // Si no hay error en el JSON, tratar el texto como contenido PDF
                    var pdfBlob = new Blob([text], { type: 'application/pdf' });
                    var pdfUrl = URL.createObjectURL(pdfBlob);
                    
                    // Establecer la fuente del visor de PDF para mostrar el PDF generado
                    document.getElementById('pdfIframeSolicitudFechas').src = pdfUrl;

                    // Mostrar la ventana modal que contiene el visor de PDF
                    var myModal = new bootstrap.Modal(document.getElementById('pdfModalSolicitudFechas'));
                    myModal.show();
                }
            } catch (e) {
                // Crear una URL local para el Blob generado
                var pdfUrl = URL.createObjectURL(blob);
                
                // Establecer la fuente del visor de PDF para mostrar el PDF generado
                document.getElementById('pdfIframeSolicitudFechas').src = pdfUrl;

                // Mostrar la ventana modal que contiene el visor de PDF
                var myModal = new bootstrap.Modal(document.getElementById('pdfModalSolicitudFechas'));
                myModal.show();
            }
        });
    })
    // Manejar errores si ocurren durante la solicitud fetch
    .catch(error => console.error('Error:', error));
}