function Generar_Excel_Conteo_Salidas_Solicitud_Fechas(event) {
    event.preventDefault();
        
    var form = document.getElementById('conteoSalidaSolicitudFormFechas');
        
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    // 1. Mostrar SweetAlert de carga inmediatamente
    Swal.fire({
        title: 'Generando Reporte',
        text: 'Procesando datos de salidas, por favor espere...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    var formData = new FormData(form);
    var url = '../../Controlador/EXCEL/Excel_Conteo_Salidas_Requisiciones.php';

    // 2. Definir el tiempo mínimo de espera (2 segundos) para una UX suave
    const timer = new Promise(resolve => setTimeout(resolve, 2000));

    // 3. Iniciar la petición fetch
    const peticion = fetch(url, {
        method: 'POST',
        body: formData
    }).then(response => {
        if (!response.ok) {
            throw new Error('Error en el servidor: ' + response.statusText);
        }
        return response.blob();
    });

    // 4. Esperar a que la petición Y el temporizador terminen
    Promise.all([peticion, timer])
    .then(([blob]) => {
        // Cerramos la alerta de carga
        Swal.close();

        // Crear la descarga del archivo
        const urlDownload = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = urlDownload;
        
        // Generar nombre de archivo con marca de tiempo
        const fecha = new Date().toISOString().slice(0, 19).replace(/[-T]/g, '_').replace(/:/g, '-');
        a.download = `Conteo_Salidas_Requisiciones_${fecha}.xlsx`;

        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        
        // Liberar memoria
        URL.revokeObjectURL(urlDownload);

        // 5. Mostrar aviso de éxito
        Swal.fire({
            icon: 'success',
            title: '¡Generado!',
            text: 'El reporte de salidas se descargó correctamente.',
            timer: 2000,
            showConfirmButton: false
        });
    })
    .catch(error => {
        // En caso de error, cerrar carga y mostrar mensaje de error
        Swal.close();
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo generar el reporte. Verifique los datos o intente más tarde.'
        });
    });
}