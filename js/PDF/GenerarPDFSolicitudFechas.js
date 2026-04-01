function Generar_PDF_Solicitud_Fechas(event) {
    // 1. Previene el comportamiento por defecto
    event.preventDefault();
    
    // 2. Obtener y validar el formulario
    var form = document.getElementById('solicitudFormFechas');
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return; 
    }

    // 3. Mostrar SweetAlert de carga (Spinner)
    Swal.fire({
        title: 'Generando Reporte',
        text: 'Obteniendo historial de solicitudes...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // 4. Preparar datos y promesas
    var formData = new FormData(form);
    var url = '../../Controlador/Reportes/Reporte_Solicitud_Por_Fechas.php';
    
    // Temporizador de 2 segundos para estandarizar el tiempo de espera
    const timer = new Promise(resolve => setTimeout(resolve, 2000));

    // Petición fetch al controlador PHP
    const peticion = fetch(url, {
        method: 'POST',
        body: formData
    });

    // 5. Esperar a que terminen la petición Y el temporizador
    Promise.all([peticion, timer])
    .then(([response]) => {
        const contentType = response.headers.get('Content-Type');

        // Caso A: El servidor devuelve un JSON (Error o sin resultados)
        if (contentType && contentType.includes('application/json')) {
            return response.json().then(json => {
                Swal.close(); // Cerramos el loading
                if (json.error) {
                    // Cargamos el mensaje en el modal de error general
                    document.getElementById('errorMessage').innerText = json.error;
                    var myModalError = new bootstrap.Modal(document.getElementById('pdfModalERROR'));
                    myModalError.show();
                }
            });
        } 
        // Caso B: El servidor devuelve el PDF (Blob)
        else {
            return response.blob().then(blob => {
                Swal.close(); // Cerramos el loading

                var pdfUrl = URL.createObjectURL(blob);
                
                // Configurar el iframe específico y mostrar el modal de solicitudes
                document.getElementById('pdfIframeSolicitudFechas').src = pdfUrl;
                var pdfModalElement = document.getElementById('pdfModalSolicitudFechas');
                var myModal = new bootstrap.Modal(pdfModalElement);
                myModal.show();
            });
        }
    })
    .catch(error => {
        // Manejo de errores de red o excepciones graves
        Swal.close();
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de proceso',
            text: 'Hubo un fallo al intentar conectar con el servidor de reportes.'
        });
    });
}