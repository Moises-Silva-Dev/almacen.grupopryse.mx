function Generar_PDF_Entradas_Fechas(event) {
    // 1. Previene el comportamiento por defecto
    event.preventDefault();
    
    // 2. Validación previa del formulario
    var form = document.getElementById('entradasFormFechas');
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return; 
    }

    // 3. Mostrar SweetAlert de carga
    Swal.fire({
        title: 'Generando Reporte',
        text: 'Consultando entradas de almacén...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // 4. Preparar datos y promesas
    var formData = new FormData(form);
    var url = '../../Controlador/Reportes/Reporte_Entrada_Almacen_Por_Fechas.php';
    
    // Definimos el temporizador de 2 segundos
    const timer = new Promise(resolve => setTimeout(resolve, 2000));

    // Ejecutamos la petición fetch
    const peticion = fetch(url, {
        method: 'POST',
        body: formData
    });

    // 5. Esperar a que AMBAS terminen (la petición Y los 2 segundos)
    Promise.all([peticion, timer])
    .then(([response]) => {
        const contentType = response.headers.get('Content-Type');

        // Caso A: El servidor responde con JSON (probablemente un error)
        if (contentType && contentType.includes('application/json')) {
            return response.json().then(json => {
                Swal.close(); // Cerramos carga
                if (json.error) {
                    document.getElementById('errorMessage').innerText = json.error;
                    var myModalError = new bootstrap.Modal(document.getElementById('pdfModalERROR'));
                    myModalError.show();
                }
            });
        } 
        // Caso B: El servidor responde con el archivo PDF (Blob)
        else {
            return response.blob().then(blob => {
                Swal.close(); // Cerramos carga

                var pdfUrl = URL.createObjectURL(blob);
                
                // Establecer la fuente del visor y mostrar el modal correspondiente
                document.getElementById('pdfViewerEntradasFechas').src = pdfUrl;
                var pdfModalElement = document.getElementById('pdfModalEntradaFechas');
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
            title: 'Error de red',
            text: 'No se pudo generar el reporte de entradas.'
        });
    });
}