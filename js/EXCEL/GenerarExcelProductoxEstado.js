function Generar_Excel_Producto_x_Estado(event) {
    event.preventDefault();

    // 1. Notificación visual de inicio de proceso
    Swal.fire({
        title: 'Generando reporte...',
        text: 'Por favor, espere mientras se procesa el archivo Excel.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading(); // Activa el spinner de carga
        }
    });

    const url = '../../Controlador/EXCEL/Excel_Producto_x_Estado.php';

    fetch(url, {
        method: 'GET',
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en el servidor: ' + response.statusText);
        }
        return response.blob();
    })
    .then(blob => {
        // 2. Validación de contenido (evita descargar archivos vacíos o errores PHP ocultos)
        if (blob.size === 0) {
            throw new Error('El archivo recibido está vacío.');
        }

        // 3. Gestión de la descarga mediante ObjectURL
        const urlBlob = URL.createObjectURL(blob);
        const a = document.createElement('a');
        
        // Generación dinámica del nombre de archivo (Timestamping)
        const timestamp = new Date().toISOString().slice(0, 19).replace(/[-T]/g, '_').replace(/:/g, '-');
        
        a.href = urlBlob;
        a.download = `Producto_x_Estado_${timestamp}.xlsx`;
        
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(urlBlob);

        // 4. Notificación de éxito
        Swal.fire({
            icon: 'success',
            title: '¡Descarga completada!',
            text: 'El reporte se ha generado correctamente.',
            timer: 2000,
            showConfirmButton: false
        });
    })
    .catch(error => {
        // 5. Gestión de excepciones y errores de red
        console.error('Runtime Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de generación',
            text: 'No se pudo generar el archivo. ' + error.message,
            confirmButtonText: 'Entendido'
        });
    });
}