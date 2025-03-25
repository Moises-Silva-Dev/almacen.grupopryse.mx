// Agrega un evento 'click' al elemento con el ID 'BtnRespaldoDB'
document.getElementById('BtnRespaldoDB').addEventListener('click', function (e) {
    e.preventDefault(); // Previene la acción predeterminada del botón (por ejemplo, un submit o enlace)

    // Realiza una solicitud HTTP para generar el respaldo de la base de datos
    fetch('../../Modelo/Respaldo_Base_De_Datos.php')
        // Convierte la respuesta a formato JSON
        .then(response => response.json())
        .then(data => {
            // Verifica si el respaldo fue exitoso
            if (data.success) {
                // Muestra un cuadro de diálogo de éxito con información del respaldo
                Swal.fire({
                    icon: 'success', // Icono de éxito
                    title: '¡Respaldo exitoso!', // Título del cuadro de diálogo
                    text: data.message + '\nArchivo: ' + data.file, // Mensaje del servidor y nombre del archivo generado
                    showConfirmButton: true, // Muestra un botón de confirmación
                }).then(() => {
                    // Recarga la página para reflejar los cambios
                    location.reload();
                });
            } else {
                // Muestra un cuadro de diálogo de error si hubo un problema con el respaldo
                Swal.fire({
                    icon: 'error', // Icono de error
                    title: 'Error al realizar el respaldo', // Título del cuadro de diálogo
                    text: data.message, // Mensaje de error devuelto por el servidor
                });
            }
        })
        .catch(error => {
            // Maneja errores en la comunicación con el servidor
            Swal.fire({
                icon: 'error', // Icono de error
                title: 'Error', // Título del cuadro de diálogo
                text: 'No se pudo contactar con el servidor.', // Mensaje genérico de error
            });
        });
});