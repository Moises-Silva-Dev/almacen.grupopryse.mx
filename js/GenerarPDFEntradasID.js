// Este script JavaScript se encarga de generar un PDF de entrada basado en la ID seleccionada en un formulario.
// Una vez que se envíe la ID al script PHP que genera el PDF, el PDF se muestra en un visor dentro de una ventana modal.
function Generar_PDF_Entrada_ID(event) {
    // Previene el comportamiento por defecto del formulario (evita el envío del formulario y la recarga de la página)
    event.preventDefault();
    
    // Obtener el formulario de entradas por ID a través de su ID
    var form = document.getElementById('entradaFormID');
    
    // Verificar si el formulario cumple con las reglas de validación
    if (!form.checkValidity()) {
        // Agregar la clase CSS 'was-validated' para mostrar errores de validación visualmente
        form.classList.add('was-validated');
        return; // Salir de la función si el formulario no es válido
    }

    // Crear un objeto FormData con los datos del formulario
    var formData = new FormData(form);
    
    // Definir la URL del script PHP que generará el PDF
    var url = '../../Controlador/Reportes/Reporte_Entrada_Almacen_Por_ID.php';

    // Realizar una solicitud fetch para enviar los datos del formulario
    fetch(url, {
        method: 'POST', // Especificar el método HTTP
        body: formData   // Incluir los datos del formulario en el cuerpo de la solicitud
    })
    // Verificar si la respuesta fue exitosa
    .then(response => {
        if (response.ok) {
            // Si la respuesta es exitosa, convertirla en un Blob
            return response.blob();
        } else {
            // Si la respuesta no es exitosa, obtener el texto y lanzar una excepción con el mensaje
            return response.text().then(text => {
                throw new Error(text);
            });
        }
    })
    // Procesar el Blob recibido
    .then(blob => {
        // Intentar interpretar el Blob como texto para detectar errores JSON
        blob.text().then(text => {
            try {
                // Intentar analizar el texto como un objeto JSON
                const json = JSON.parse(text);

                // Verificar si el JSON contiene un mensaje de error
                if (json.error) {
                    // Mostrar el mensaje de error en el elemento correspondiente
                    document.getElementById('errorMessage').innerText = json.error;

                    // Mostrar la ventana modal con el mensaje de error
                    var myModalError = new bootstrap.Modal(document.getElementById('pdfModalERROR'));
                    myModalError.show();
                }
            } catch (e) {
                // Si no es un JSON de error, tratar el Blob como un PDF
                var pdfUrl = URL.createObjectURL(blob);

                // Configurar el visor de PDF con la URL generada
                document.getElementById('pdfIframeEntradaID').src = pdfUrl;

                // Mostrar la ventana modal que contiene el visor de PDF
                var myModal = new bootstrap.Modal(document.getElementById('pdfModalEntradaID'));
                myModal.show();
            }
        });
    })
    // Manejar errores que ocurran en la solicitud fetch o durante el procesamiento
    .catch(error => {
        // Mostrar el mensaje de error en el elemento correspondiente
        document.getElementById('errorMessage').innerText = 'Ocurrió un error al generar el PDF: ' + error.message;

        // Mostrar la ventana modal con el mensaje de error
        var myModalError = new bootstrap.Modal(document.getElementById('pdfModalERROR'));
        myModalError.show();
    });
}