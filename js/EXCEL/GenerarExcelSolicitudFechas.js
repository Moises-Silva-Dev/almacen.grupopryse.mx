function Generar_Excel_Solicitud_Fechas(event) {
    event.preventDefault();
        
    var form = document.getElementById('solicitudFormFechas');
        
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    // 1. Iniciar SweetAlert de carga
    Swal.fire({
        title: 'Generando Requisiciones',
        text: 'Procesando las solicitudes por fecha, por favor espere...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    var formData = new FormData(form);
    var url = '../../Controlador/EXCEL/Excel_Solicitud_Por_Fechas.php';

    // 2. Temporizador mínimo de 2 segundos para suavizar la UX
    const timer = new Promise(resolve => setTimeout(resolve, 2000));

    // 3. Petición al servidor
    const peticion = fetch(url, {
        method: 'POST',
        body: formData
    }).then(response => {
        if (!response.ok) {
            throw new Error('Error en el servidor: ' + response.statusText);
        }
        return response.blob();
    });

    // 4. Sincronización de descarga y temporizador
    Promise.all([peticion, timer])
    .then(([blob]) => {
        // Validar que el servidor envió datos
        if (blob.size === 0) {
            throw new Error('El reporte no contiene información para el periodo seleccionado.');
        }

        // Cerramos el estado de carga
        Swal.close();

        // Proceso de descarga
        const urlDownload = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = urlDownload;
        
        const fechaStr = new Date().toISOString().slice(0, 19).replace(/[-T]/g, '_').replace(/:/g, '-');
        a.download = `Requisiciones_${fechaStr}.xlsx`;

        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        
        URL.revokeObjectURL(urlDownload);

        // 5. Aviso de éxito
        Swal.fire({
            icon: 'success',
            title: '¡Excel Generado!',
            text: 'El reporte de solicitudes se descargó correctamente.',
            timer: 2000,
            showConfirmButton: false
        });
    })
    .catch(error => {
        // Cerrar carga y mostrar el error ocurrido
        Swal.close();
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de proceso',
            text: 'No se pudo generar el Excel: ' + error.message
        });
    });
}