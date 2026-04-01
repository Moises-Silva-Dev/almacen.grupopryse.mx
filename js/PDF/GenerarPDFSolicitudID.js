function Generar_PDF_Solicitud_ID(event) {
    // 1. Previene el comportamiento por defecto
    event.preventDefault();
    
    // 2. Obtener y validar el formulario
    var form = document.getElementById('solicitudFormID');
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return; 
    }

    // 3. Mostrar SweetAlert de carga (Spinner)
    Swal.fire({
        title: 'Generando Reporte',
        text: 'Consultando los datos de la solicitud...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // 4. Preparar datos y promesas
    var formData = new FormData(form);
    var url = '../../Controlador/Reportes/Reporte_Solicitud_Por_ID.php';
    
    // Timer de 2 segundos para mantener la consistencia visual del sistema
    const timer = new Promise(resolve => setTimeout(resolve, 2000));

    // Petición fetch al servidor
    const peticion = fetch(url, {
        method: 'POST',
        body: formData
    });

    // 5. Esperar a que terminen la petición Y el temporizador
    Promise.all([peticion, timer])
    .then(([response]) => {
        const contentType = response.headers.get('Content-Type');

        // Caso A: El servidor devuelve un JSON (Error de ID no encontrado o validación)
        if (contentType && contentType.includes('application/json')) {
            return response.json().then(json => {
                Swal.close(); // Cerramos el loading
                if (json.error) {
                    // Cargamos el mensaje en tu modal de error estándar
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
                
                // Configurar el iframe específico y mostrar el modal de la solicitud
                document.getElementById('pdfIframeSolicitudID').src = pdfUrl;
                var pdfModalElement = document.getElementById('pdfModalSolicitudID');
                var myModal = new bootstrap.Modal(pdfModalElement);
                myModal.show();
            });
        }
    })
    .catch(error => {
        // Manejo de fallos de red o errores inesperados
        Swal.close();
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'No se pudo generar el reporte. Verifique su conexión o intente más tarde.'
        });
    });
}