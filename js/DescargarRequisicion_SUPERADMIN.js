// Selecciona todos los botones con la clase BtnDescargarRequisicion
document.querySelectorAll('.BtnDescargarRequisicion_SUPERADMIN').forEach(button => {
    // Una vez que lo encuentre, simular un clic y realizar la funcion
    button.addEventListener('click', function () {
        // Obtiene el ID de la requisición desde el atributo `data-id` del botón clickeado.
        var idRequisicion = this.dataset.id;

        // Va ir al direccionamiento donde genera el PDF
        fetch(`../../Controlador/Reportes/Descargar_Requisicion_SUPERADMIN.php?nocache=${Date.now()}`, {
            // Define el método HTTP como POST.
            method: 'POST',
            headers: {
                // Especifica que el contenido enviado será en formato JSON.
                'Content-Type': 'application/json',
            },
            // Convierte el objeto con el ID de la solicitud en una cadena JSON y lo envía como cuerpo de la solicitud.
            body: JSON.stringify({ Id_Solicitud: idRequisicion }),
        })
        .then(response => {
            if (!response.ok) {
                // Lanza un error si la respuesta del servidor no es satisfactoria.
                throw new Error('Error al generar el PDF');
            }
            // Convierte la respuesta en un objeto Blob (para manejar archivos binarios como el PDF).
            return response.blob();
        })
        .then(blob => {
            // Crea una URL temporal para el archivo PDF generado.
            const url = window.URL.createObjectURL(blob);
            // Crea un elemento <a> dinámicamente.
            const link = document.createElement('a');
            // Asigna la URL del Blob como el atributo href del enlace.
            link.href = url;
            // Especifica el nombre del archivo que se descargará.
            link.download = `Reporte_Requisicion_${idRequisicion}.pdf`;
            // Añade temporalmente el enlace al DOM para que sea clickeable.
            document.body.appendChild(link);
            // Simula un clic en el enlace para iniciar la descarga.
            link.click();
            // Elimina el enlace del DOM después de completar la descarga.
            document.body.removeChild(link);
        })
        // Maneja cualquier error ocurrido durante el proceso y lo muestra en la consola.
        .catch(error => console.error(error));
    });
});