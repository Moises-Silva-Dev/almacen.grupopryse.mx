function Generar_PDF_Inventario(event) {
    event.preventDefault();

    // 1. Mostrar SweetAlert de carga
    Swal.fire({
        title: 'Generando Reporte',
        text: 'Preparando los datos del inventario...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    const url = '../../Controlador/Reportes/Reporte_Inventario.php';

    // 2. Definimos una promesa que dura exactamente 2 segundos
    const timer = new Promise(resolve => setTimeout(resolve, 2000));

    // 3. Ejecutamos el fetch
    const peticion = fetch(url);

    // 4. Usamos Promise.all para esperar a QUE AMBAS terminen
    // (La petición Y el tiempo de 2 segundos)
    Promise.all([peticion, timer])
    .then(([response]) => {
        const contentType = response.headers.get('Content-Type');
        
        if (contentType && contentType.includes('application/json')) {
            return response.json().then(json => {
                Swal.close(); // Cerramos carga
                if (json.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: json.error
                    });
                }
            });
        } else {
            return response.blob().then(blob => {
                // El servidor respondió y ya pasaron al menos 2 segundos
                Swal.close(); 

                var pdfUrl = URL.createObjectURL(blob);
                document.getElementById('pdfIframe').src = pdfUrl;

                var pdfModalElement = document.getElementById('pdfModal');
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
            title: 'Error de red',
            text: 'No se pudo obtener el reporte.'
        });
    });
}