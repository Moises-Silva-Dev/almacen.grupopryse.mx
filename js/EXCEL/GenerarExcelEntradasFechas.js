function Generar_Excel_Entradas_Fechas(event) {
    event.preventDefault();
        
    var form = document.getElementById('entradasFormFechas');
        
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    // 1. Mostrar SweetAlert de carga
    Swal.fire({
        title: 'Generando Reporte de Entradas',
        text: 'Buscando registros y preparando archivo, por favor espere...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    var formData = new FormData(form);
    var url = '../../Controlador/EXCEL/Excel_Entrada_Almacen_Por_Fechas.php';

    // 2. Definir tiempo mínimo de espera (2 segundos)
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

    // 4. Esperar a que AMBAS terminen (Petición + Timer)
    Promise.all([peticion, timer])
    .then(([blob]) => {
        // Cerramos el SweetAlert de carga
        Swal.close();

        // Crear la descarga del archivo
        const urlDownload = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = urlDownload;
        
        // Formatear fecha para el nombre del archivo
        const fecha = new Date().toISOString().slice(0, 19).replace(/[-T]/g, '_').replace(/:/g, '-');
        a.download = `Entradas_Almacen_${fecha}.xlsx`;

        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        
        // Liberar memoria
        URL.revokeObjectURL(urlDownload);

        // 5. Mostrar aviso de éxito
        Swal.fire({
            icon: 'success',
            title: '¡Reporte Listo!',
            text: 'El archivo de entradas se ha generado correctamente.',
            timer: 2000,
            showConfirmButton: false
        });
    })
    .catch(error => {
        Swal.close();
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de Generación',
            text: 'Hubo un problema al procesar las entradas. Por favor, intente de nuevo.'
        });
    });
}