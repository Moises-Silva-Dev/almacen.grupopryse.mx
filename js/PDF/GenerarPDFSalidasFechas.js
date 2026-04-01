function Generar_PDF_Salidas_Fechas(event) {
    // 1. Previene el comportamiento por defecto
    event.preventDefault();
    
    // 2. Obtener y validar el formulario
    var form = document.getElementById('salidasFormFechas');
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return; 
    }

    // 3. Mostrar SweetAlert de carga (Spinner)
    Swal.fire({
        title: 'Generando Reporte',
        text: 'Consultando salidas de almacén por fechas...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // 4. Preparar datos y promesas
    var formData = new FormData(form);
    var url = '../../Controlador/Reportes/Reporte_Salida_Almacen_Por_Fechas.php';
    
    // Timer de 2 segundos para asegurar una transición suave
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

        // Caso A: El servidor devuelve un JSON (Error de negocio/datos vacíos)
        if (contentType && contentType.includes('application/json')) {
            return response.json().then(json => {
                Swal.close(); // Cerramos el loading
                if (json.error) {
                    // Cargamos el error en el modal de error general
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
                
                // Configurar el visor específico y mostrar el modal de salidas
                document.getElementById('pdfViewerSalidasFechas').src = pdfUrl;
                var pdfModalElement = document.getElementById('pdfModalSalidaFechas');
                var myModal = new bootstrap.Modal(pdfModalElement);
                myModal.show();
            });
        }
    })
    .catch(error => {
        // Manejo de errores de red o excepciones
        Swal.close();
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de servidor',
            text: 'No se pudo generar el reporte de salidas en este momento.'
        });
    });
}