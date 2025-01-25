// Declara una función llamada "confirmarRestauracion" que toma como parámetro un archivo
function confirmarRestauracion(archivo) {
    // Llama a la biblioteca SweetAlert2 para mostrar un cuadro de diálogo de confirmación
    Swal.fire({
        title: '¿Estás seguro?', // Título del cuadro de diálogo
        text: "Esto restaurará la base de datos desde el archivo seleccionado.", // Texto informativo sobre la acción
        icon: 'warning', // Icono de advertencia para resaltar la importancia
        showCancelButton: true, // Muestra un botón para cancelar la acción
        confirmButtonColor: '#28a745', // Color del botón de confirmación (verde)
        cancelButtonColor: '#d33', // Color del botón de cancelación (rojo)
        confirmButtonText: 'Sí, restaurar', // Texto del botón de confirmación
        cancelButtonText: 'Cancelar', // Texto del botón de cancelación
    }).then((result) => { // Ejecuta este bloque cuando el usuario responde al cuadro de diálogo
        // Verifica si el usuario confirmó la acción
        if (result.isConfirmed) {
            // Realiza una solicitud HTTP GET al servidor para restaurar la base de datos
            fetch(`../../Modelo/Restauracion_Base_De_Datos.php?archivo=${archivo}`, {
                method: 'GET', // Especifica el método HTTP como GET
            })
                // Convierte la respuesta a formato JSON
                .then((response) => response.json())
                .then((data) => {
                    // Verifica si la restauración fue exitosa
                    if (data.success) {
                        // Muestra un cuadro de diálogo de éxito con un mensaje del servidor
                        Swal.fire({
                            icon: 'success', // Icono de éxito
                            title: '¡Restaurado!', // Título del cuadro de diálogo
                            text: data.message, // Mensaje devuelto por el servidor
                        }).then(() => {
                            // Recarga la página para reflejar los cambios
                            location.reload();
                        });
                    } else {
                        // Muestra un cuadro de diálogo de error si hubo un problema
                        Swal.fire({
                            icon: 'error', // Icono de error
                            title: 'Error', // Título del cuadro de diálogo
                            text: data.message, // Mensaje de error devuelto por el servidor
                        });
                    }
                })
                .catch((error) => {
                    // Maneja errores de la solicitud HTTP y muestra un mensaje de error
                    Swal.fire({
                        icon: 'error', // Icono de error
                        title: 'Error', // Título del cuadro de diálogo
                        text: 'Hubo un problema con la solicitud.', // Mensaje genérico de error
                    });
                });
        }
    });
}