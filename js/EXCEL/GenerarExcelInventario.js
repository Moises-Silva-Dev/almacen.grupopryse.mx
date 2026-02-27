function Generar_Excel_Inventario(event) {
    event.preventDefault();

    // 1. Mostrar SweetAlert de carga
    Swal.fire({
        title: 'Generando Excel',
        text: 'Preparando el inventario, por favor espere...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    const url = '../../Controlador/EXCEL/Excel_Inventario.php';

    // 2. Definir el tiempo mínimo de espera (2 segundos)
    const timer = new Promise(resolve => setTimeout(resolve, 2000));

    // 3. Iniciar la petición fetch
    const peticion = fetch(url).then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor: ' + response.statusText);
        }
        return response.blob();
    });

    // 4. Esperar a que AMBAS terminen
    Promise.all([peticion, timer])
    .then(([blob]) => {
        // Cerramos el cargando
        Swal.close();

        // Crear la descarga del archivo
        const urlDownload = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = urlDownload;
        
        // Nombre del archivo con fecha actual
        const fecha = new Date().toISOString().slice(0, 19).replace(/[-T]/g, '_').replace(/:/g, '-');
        a.download = `Inventario_${fecha}.xlsx`;

        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        
        // Liberar memoria
        URL.revokeObjectURL(urlDownload);

        // 5. Opcional: Mostrar aviso de éxito
        Swal.fire({
            icon: 'success',
            title: '¡Descarga lista!',
            text: 'El archivo Excel se ha generado correctamente.',
            timer: 2000, // Se cierra solo en 2 segundos
            showConfirmButton: false
        });
    })
    .catch(error => {
        Swal.close();
        console.error('Error al generar el archivo Excel:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo generar el archivo Excel. Intente de nuevo.'
        });
    });
}