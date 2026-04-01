function Generar_Excel_Producto_x_Estado(event) {
    event.preventDefault();

    // 1. Notificación visual de inicio de proceso
    Swal.fire({
        title: 'Generando reporte...',
        text: 'Por favor, espere mientras se procesa el archivo Excel.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    const url = '../../Controlador/EXCEL/Excel_Producto_x_Estado.php';

    // 2. Definir el tiempo mínimo de espera (2 segundos) para consistencia visual
    const timer = new Promise(resolve => setTimeout(resolve, 2000));

    // 3. Iniciar la petición fetch
    const peticion = fetch(url, {
        method: 'GET',
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en el servidor: ' + response.statusText);
        }
        return response.blob();
    });

    // 4. Esperar a que AMBAS (petición y timer) terminen
    Promise.all([peticion, timer])
    .then(([blob]) => {
        // Validación de contenido
        if (blob.size === 0) {
            throw new Error('El archivo recibido está vacío.');
        }

        // Cerramos la alerta de carga
        Swal.close();

        // Gestión de la descarga
        const urlBlob = URL.createObjectURL(blob);
        const a = document.createElement('a');
        
        const timestamp = new Date().toISOString().slice(0, 19).replace(/[-T]/g, '_').replace(/:/g, '-');
        
        a.href = urlBlob;
        a.download = `Producto_x_Estado_${timestamp}.xlsx`;
        
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(urlBlob);

        // 5. Notificación de éxito
        Swal.fire({
            icon: 'success',
            title: '¡Descarga completada!',
            text: 'El reporte se ha generado correctamente.',
            timer: 2000,
            showConfirmButton: false
        });
    })
    .catch(error => {
        // Gestión de errores
        Swal.close();
        console.error('Runtime Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de generación',
            text: 'No se pudo generar el archivo. ' + error.message,
            confirmButtonText: 'Entendido'
        });
    });
}