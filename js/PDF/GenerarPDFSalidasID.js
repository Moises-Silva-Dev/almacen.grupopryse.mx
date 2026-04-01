function Generar_PDF_Salida_ID(event) {
    // 1. Previene el comportamiento por defecto
    event.preventDefault();
    
    // 2. Obtener y validar el formulario
    var form = document.getElementById('salidaFormID');
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return; 
    }

    // 3. Mostrar SweetAlert de carga (Spinner)
    Swal.fire({
        title: 'Generando Reporte',
        text: 'Buscando el registro de salida...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // 4. Preparar datos y promesas
    var formData = new FormData(form);
    var url = '../../Controlador/Reportes/Reporte_Salida_Almacen_Por_ID.php';
    
    // Timer de 2 segundos para dar una sensación de procesamiento robusto
    const timer = new Promise(resolve => setTimeout(resolve, 2000));

    // Ejecución de la petición fetch
    const peticion = fetch(url, {
        method: 'POST',
        body: formData
    });

    // 5. Esperar a que terminen la petición Y el temporizador de 2 segundos
    Promise.all([peticion, timer])
    .then(([response]) => {
        const contentType = response.headers.get('Content-Type');

        // Caso A: El servidor devuelve un JSON (Error de negocio o registro no encontrado)
        if (contentType && contentType.includes('application/json')) {
            return response.json().then(json => {
                Swal.close(); // Cerramos el loading
                if (json.error) {
                    // Cargamos el mensaje en el modal de error existente
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
                
                // Asignar al iframe específico y mostrar el modal de éxito
                document.getElementById('pdfIframeSalidaID').src = pdfUrl;
                var pdfModalElement = document.getElementById('pdfModalSalidaID');
                var myModal = new bootstrap.Modal(pdfModalElement);
                myModal.show();
            });
        }
    })
    .catch(error => {
        // Manejo de errores de conexión o excepciones críticas
        Swal.close();
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de comunicación',
            text: 'No se pudo obtener el reporte de salida por ID.'
        });
    });
}