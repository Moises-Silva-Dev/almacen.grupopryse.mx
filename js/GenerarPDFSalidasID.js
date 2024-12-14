// Este script JavaScript se encarga de generar un PDF de salida basado en la ID seleccionada en un formulario. 
// Una vez que se envié la ID al script PHP que genera el PDF, el PDF se muestra en un visor dentro de una ventana modal.
function Generar_PDF_Salida_ID(event) {
    // Previene el comportamiento por defecto del formulario (evita el envío de formulario)
    event.preventDefault();
    
    // Obtener el formulario de salidas por ID
    var form = document.getElementById('salidaFormID');
    
    // Verificar si el formulario es válido
    if (!form.checkValidity()) {
        // Agregar una clase de validación si el formulario no es válido y salir de la función
        form.classList.add('was-validated');
        return;
    }

    // Crear un objeto FormData con los datos del formulario
    var formData = new FormData(form);
    
    // URL del script PHP que procesará la solicitud y generará el PDF
    var url = '../../Controlador/Reportes/Reporte_Salida_Almacen_Por_ID.php';

    // Realizar una solicitud fetch para enviar los datos del formulario al servidor
    fetch(url, {
        method: 'POST',
        body: formData
    })
    // Convertir la respuesta a un objeto Blob
    .then(response => {
        if (response.ok) {
            return response.blob(); // Convertir la respuesta en un Blob si es exitosa
        } else {
            return response.text().then(text => {
                // Si la respuesta no es ok, asumir que es un error y lanzar una excepción
                throw new Error(text);
            });
        }
    })
    .then(blob => {
        // Intentar analizar el Blob como texto para verificar si es un JSON de error
        blob.text().then(text => {
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
                }
            } catch (e) {
                // Crear una URL local para el Blob generado
                var pdfUrl = URL.createObjectURL(blob);
                
                // Establecer la fuente del visor de PDF para mostrar el PDF generado
                document.getElementById('pdfIframeSalidaID').src = pdfUrl;

                // Mostrar la ventana modal que contiene el visor de PDF
                var myModal = new bootstrap.Modal(document.getElementById('pdfModalSalidaID'));
                myModal.show();
            }
        });
    })
    // Manejar errores si ocurren durante la solicitud fetch
    .catch(error => {
        // Mostrar un mensaje de error en el modal si ocurre un error
        document.getElementById('errorMessage').innerText = 'Ocurrió un error al generar el PDF: ' + error.message;

        // Mostrar la ventana modal que contiene el visor de error
        var myModalError = new bootstrap.Modal(document.getElementById('pdfModalERROR'));
        myModalError.show();
    });
}