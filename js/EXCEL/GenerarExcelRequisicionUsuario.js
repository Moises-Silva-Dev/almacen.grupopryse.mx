function Generar_Excel_Requisicion_Usuario(event) {
    event.preventDefault();
        
    var form = document.getElementById('RequisicionUsuarioFormID');
        
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    // 1. Mostrar SweetAlert de carga
    Swal.fire({
        title: 'Generando Reporte de Usuario',
        text: 'Consultando requisiciones, por favor espere...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    var formData = new FormData(form);
    var url = '../../Controlador/EXCEL/Excel_Requision_Usuario_Por_ID.php';

    // 2. Definir el tiempo mínimo de espera (2 segundos)
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

    // 4. Esperar a que AMBAS promesas terminen
    Promise.all([peticion, timer])
    .then(([blob]) => {
        // Validación de contenido
        if (blob.size === 0) {
            throw new Error('El archivo generado está vacío.');
        }

        // Cerramos el cargando
        Swal.close();

        // Crear la descarga del archivo
        const urlDownload = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = urlDownload;
        
        const fecha = new Date().toISOString().slice(0, 19).replace(/[-T]/g, '_').replace(/:/g, '-');
        a.download = `Requisiciones_Usuario_${fecha}.xlsx`;

        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        
        // Liberar memoria
        URL.revokeObjectURL(urlDownload);

        // 5. Mostrar aviso de éxito
        Swal.fire({
            icon: 'success',
            title: '¡Reporte Generado!',
            text: 'Las requisiciones del usuario se han descargado correctamente.',
            timer: 2000,
            showConfirmButton: false
        });
    })
    .catch(error => {
        // En caso de error, cerrar carga y notificar al usuario
        Swal.close();
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo generar el reporte: ' + error.message
        });
    });
}