function Generar_PDF_Entrada_ID(event) {
    // 1. Previene el comportamiento por defecto
    event.preventDefault();
    
    // 2. Obtener y validar el formulario
    var form = document.getElementById('entradaFormID');
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return; 
    }

    // 3. Mostrar SweetAlert de carga (Spinner)
    Swal.fire({
        title: 'Generando Reporte',
        text: 'Buscando entrada por ID...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // 4. Preparar datos y promesas
    var formData = new FormData(form);
    var url = '../../Controlador/Reportes/Reporte_Entrada_Almacen_Por_ID.php';
    
    // Timer de 2 segundos para evitar parpadeos si el servidor es muy rápido
    const timer = new Promise(resolve => setTimeout(resolve, 2000));

    // Petición fetch
    const peticion = fetch(url, {
        method: 'POST',
        body: formData
    });

    // 5. Esperar a que AMBAS promesas se cumplan
    Promise.all([peticion, timer])
    .then(([response]) => {
        const contentType = response.headers.get('Content-Type');

        // Caso A: El servidor devuelve un JSON (Error de negocio)
        if (contentType && contentType.includes('application/json')) {
            return response.json().then(json => {
                Swal.close(); // Cerramos el loading
                if (json.error) {
                    // Cargamos el error en tu modal de error tradicional
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
                document.getElementById('pdfIframeEntradaID').src = pdfUrl;
                var pdfModalElement = document.getElementById('pdfModalEntradaID');
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
            title: 'Error inesperado',
            text: 'No se pudo procesar la solicitud del ID.'
        });
    });
}