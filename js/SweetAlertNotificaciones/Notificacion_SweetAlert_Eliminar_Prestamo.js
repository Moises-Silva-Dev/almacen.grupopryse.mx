// Esta función se utiliza cuando se elimina una cuenta mediante el identificador en la base de datos.
function eliminarRegistroPrestamo(id) { 
    // Confirmación de SweetAlert
    Swal.fire({
        title: '¿Estás seguro?', // título
        text: "Esta acción no se puede deshacer.", // mensaje
        icon: 'warning', // icono de advertencia
        showCancelButton: true, // mostrar botón de cancelar
        confirmButtonColor: '#d33', // color del botón de confirmación
        cancelButtonColor: '#3085d6', // color del botón de cancelar
        confirmButtonText: 'Sí, eliminar', // texto del botón de confirmación
        cancelButtonText: 'Cancelar' // texto del botón de cancelar
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, envía la solicitud al backend
            fetch(`../../Controlador/Usuarios/DELETE/Funcion_Delete_Prestamo.php?id=${id}`, {
                method: 'GET' // método de solicitud
            })
            .then(response => response.json()) // Convierte la respuesta a JSON
            .then(data => { // Maneja la respuesta del servidor
                if (data.success) {
                    // Muestra mensaje de éxito
                    Swal.fire({
                        icon: 'success', // icono de éxito
                        title: '¡Eliminado!', // título
                        text: data.message, // mensaje
                        timer: 1500, // tiempo de duración
                        showConfirmButton: false , // no mostrar botón de confirmación
                    }).then(() => {
                        location.reload(); // Recargar la página para actualizar los datos
                    });
                } else {
                    // Muestra mensaje de error
                    Swal.fire({
                        icon: 'error', // icono de error
                        title: 'Error', // título
                        text: data.message , // mensaje
                    });
                }
            })
            .catch(error => {
                // Manejo de errores de red
                Swal.fire({
                    icon: 'error', // icono de error
                    title: 'Error', // título
                    text: 'Hubo un problema al procesar la solicitud.' , // mensaje
                });
                console.error(error); // Imprime el error en la consola
            });
        }
    });
}