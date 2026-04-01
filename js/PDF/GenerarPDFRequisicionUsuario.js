function Generar_PDF_Requisicion_Usuario(event) {
    // 1. Previene el comportamiento por defecto
    event.preventDefault();
    
    // 2. Obtener y validar el formulario
    var form = document.getElementById('RequisicionUsuarioFormID');
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return; 
    }

    // 3. Mostrar SweetAlert de carga
    Swal.fire({
        title: 'Generando Reporte',
        text: 'Procesando la requisición del usuario...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // 4. Preparar datos y promesas
    var formData = new FormData(form);
    var url = '../../Controlador/Reportes/Reporte_Requision_Usuario_Por_ID.php';
    
    // Timer de 2 segundos para mantener la consistencia visual
    const timer = new Promise(resolve => setTimeout(resolve, 2000));

    // Petición fetch al controlador PHP
    const peticion = fetch(url, {
        method: 'POST',
        body: formData
    });

    // 5. Esperar a que terminen la petición Y el tiempo de espera mínimo
    Promise.all([peticion, timer])
    .then(([response]) => {
        const contentType = response.headers.get('Content-Type');

        // Caso A: El servidor devuelve JSON (Indica un error de validación o datos)
        if (contentType && contentType.includes('application/json')) {
            return response.json().then(json => {
                Swal.close(); // Cerramos el loading
                if (json.error) {
                    // Cargamos el mensaje en el modal de error clásico
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
                
                // Asignar al iframe específico y mostrar el modal de la requisición
                document.getElementById('pdfIframeRequisicionUsuario').src = pdfUrl;
                var pdfModalElement = document.getElementById('pdfModalRequisicionUsuario');
                var myModal = new bootstrap.Modal(pdfModalElement);
                myModal.show();
            });
        }
    })
    .catch(error => {
        // Manejo de fallos críticos (red, servidor caído, etc.)
        Swal.close();
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de comunicación',
            text: 'Ocurrió un problema al intentar generar el PDF de la requisición.'
        });
    });
}