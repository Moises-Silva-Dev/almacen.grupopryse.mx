function Generar_Excel_Salidas_Fechas(event) {
    event.preventDefault();
        
    var form = document.getElementById('salidasFormFechas');
        
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    // 1. Mostrar SweetAlert de carga inmediatamente
    Swal.fire({
        title: 'Generando Reporte de Salidas',
        text: 'Procesando registros de almacén, por favor espere...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    var formData = new FormData(form);
    var url = '../../Controlador/EXCEL/Excel_Salida_Almacen_Por_Fechas.php';

    // 2. Definir tiempo mínimo de espera (2 segundos) para una transición suave
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

    // 4. Esperar a que AMBAS (Petición y Timer) terminen
    Promise.all([peticion, timer])
    .then(([blob]) => {
        // Validación de que el archivo no llegue vacío
        if (blob.size === 0) {
            throw new Error('El archivo generado no contiene datos.');
        }

        // Cerramos la alerta de carga
        Swal.close();

        // Gestión de la descarga
        const urlDownload = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = urlDownload;
        
        // Formatear fecha para el nombre del archivo
        const fecha = new Date().toISOString().slice(0, 19).replace(/[-T]/g, '_').replace(/:/g, '-');
        a.download = `Salidas_Almacen_${fecha}.xlsx`;

        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        
        // Liberar memoria
        URL.revokeObjectURL(urlDownload);

        // 5. Notificación de éxito
        Swal.fire({
            icon: 'success',
            title: '¡Descarga Exitosa!',
            text: 'El reporte de salidas se ha generado correctamente.',
            timer: 2000,
            showConfirmButton: false
        });
    })
    .catch(error => {
        // Cerrar carga y mostrar error
        Swal.close();
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de Reporte',
            text: 'No se pudo generar el archivo de salidas. ' + error.message
        });
    });
}