// Selecciona todos los botones con la clase BtnDescargarRequisicion
document.querySelectorAll('.BtnDescargarRequisicion').forEach(button => {
    button.addEventListener('click', function () {
        // 1. Obtener el ID de la requisición
        var idRequisicion = this.dataset.id;

        // 2. Mostrar SweetAlert de carga inmediatamente
        Swal.fire({
            title: 'Generando Reporte PDF',
            text: `Procesando la requisición #${idRequisicion}, por favor espere...`,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading(); // Activa el spinner
            }
        });

        const urlScript = `../../Controlador/Reportes/Descargar_Requisicion.php?nocache=${Date.now()}`;

        // 3. Temporizador mínimo de 2 segundos para una UX suave
        const timer = new Promise(resolve => setTimeout(resolve, 2000));

        // 4. Iniciar la petición fetch (POST con JSON)
        const peticion = fetch(urlScript, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ Id_Solicitud: idRequisicion }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('No se pudo establecer conexión con el generador de reportes.');
            }
            return response.blob();
        });

        // 5. Sincronizar Petición y Timer
        Promise.all([peticion, timer])
        .then(([blob]) => {
            // Verificar si el PDF tiene contenido
            if (blob.size === 0) {
                throw new Error('El reporte generado no contiene datos válidos.');
            }

            // Cerramos la alerta de carga
            Swal.close();

            // Crear el enlace de descarga
            const urlBlob = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = urlBlob;
            link.download = `Reporte_Requisicion_${idRequisicion}.pdf`;
            
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            // Liberar memoria del navegador
            window.URL.revokeObjectURL(urlBlob);

            // 6. Mensaje de éxito (opcional)
            Swal.fire({
                icon: 'success',
                title: '¡Descarga iniciada!',
                text: 'El archivo PDF se ha generado con éxito.',
                timer: 1800,
                showConfirmButton: false
            });
        })
        .catch(error => {
            // En caso de fallo, cerrar carga y mostrar alerta de error
            Swal.close();
            console.error('Error en generación PDF:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error de Generación',
                text: 'Hubo un problema: ' + error.message,
                confirmButtonText: 'Cerrar'
            });
        });
    });
});