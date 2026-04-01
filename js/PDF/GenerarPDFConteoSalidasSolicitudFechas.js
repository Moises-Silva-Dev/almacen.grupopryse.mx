function Generar_PDF_Conteo_Salidas_Solicitud_Fechas(event) {
    event.preventDefault();
    
    // 1. Validación previa del formulario
    var form = document.getElementById('conteoSalidaSolicitudFormFechas');
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return; 
    }

    // 2. Mostrar SweetAlert de carga
    Swal.fire({
        title: 'Generando Reporte',
        text: 'Procesando solicitud de salidas...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // 3. Preparar datos y promesas
    var formData = new FormData(form);
    var url = '../../Controlador/Reportes/Reporte_Conteo_Salidas_Requisiciones.php';
    
    // Definimos el temporizador de 2 segundos
    const timer = new Promise(resolve => setTimeout(resolve, 2000));

    // Ejecutamos la petición fetch
    const peticion = fetch(url, {
        method: 'POST',
        body: formData
    });

    // 4. Esperar a que AMBAS terminen (la petición y los 2 segundos)
    Promise.all([peticion, timer])
    .then(([response]) => {
        // Revisamos si la respuesta es JSON (error) o PDF (éxito)
        const contentType = response.headers.get('Content-Type');

        if (contentType && contentType.includes('application/json')) {
            return response.json().then(json => {
                Swal.close(); // Cerramos carga
                if (json.error) {
                    // Mostrar error en tu modal específico o en Swal
                    document.getElementById('errorMessage').innerText = json.error;
                    var myModalError = new bootstrap.Modal(document.getElementById('pdfModalERROR'));
                    myModalError.show();
                }
            });
        } else {
            // Es un PDF (Blob)
            return response.blob().then(blob => {
                Swal.close(); // Cerramos carga

                var pdfUrl = URL.createObjectURL(blob);
                
                // Asignar al iframe y mostrar modal de éxito
                document.getElementById('pdfIframeConteoSalidasSolicitudFechas').src = pdfUrl;
                var pdfModalElement = document.getElementById('pdfModalConteoSalidasSolicitudFechas');
                var myModal = new bootstrap.Modal(pdfModalElement);
                myModal.show();
            });
        }
    })
    .catch(error => {
        Swal.close();
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'No se pudo establecer comunicación con el servidor.'
        });
    });
}