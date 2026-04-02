// Selecciona todos los botones con la clase BtnDescargarRequisicion_SUPERADMIN
document.querySelectorAll('.BtnDescargarRequisicion_SUPERADMIN').forEach(button => {
    button.addEventListener('click', function () {
        // 1. Obtener el ID de la requisición
        var idRequisicion = this.dataset.id;

        // 2. Mostrar SweetAlert de carga inmediatamente
        Swal.fire({
            title: 'Generando PDF',
            text: `Preparando el reporte #${idRequisicion}, por favor espere...`,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const urlScript = `../../Controlador/Reportes/Descargar_Requisicion_SUPERADMIN.php?nocache=${Date.now()}`;

        // 3. Definir el tiempo mínimo de espera (2 segundos) para una UX consistente
        const timer = new Promise(resolve => setTimeout(resolve, 2000));

        // 4. Iniciar la petición fetch
        const peticion = fetch(urlScript, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ Id_Solicitud: idRequisicion }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al generar el PDF en el servidor');
            }
            return response.blob();
        });

        // 5. Esperar a que AMBAS terminen (Petición + Timer)
        Promise.all([peticion, timer])
        .then(([blob]) => {
            // Validar que el archivo no esté vacío
            if (blob.size === 0) {
                throw new Error('El archivo PDF se generó vacío.');
            }

            // Cerramos la alerta de carga
            Swal.close();

            // Gestión de la descarga
            const urlBlob = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = urlBlob;
            link.download = `Reporte_Requisicion_${idRequisicion}.pdf`;
            
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            // Liberar memoria
            window.URL.revokeObjectURL(urlBlob);

            // 6. Notificación de éxito (opcional, se cierra sola en 1.5s)
            Swal.fire({
                icon: 'success',
                title: 'PDF Listo',
                text: 'La descarga ha comenzado.',
                timer: 1500,
                showConfirmButton: false
            });
        })
        .catch(error => {
            // Cerrar carga y mostrar error detallado
            Swal.close();
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error de Reporte',
                text: 'No se pudo generar el PDF: ' + error.message,
                confirmButtonText: 'Entendido'
            });
        });
    });
});