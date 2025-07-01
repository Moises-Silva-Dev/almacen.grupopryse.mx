// Mostrar información del préstamo y autorizarlo
function autorizarPrestamo() {
    const id = document.getElementById('btnAutorizar').getAttribute('data-id'); // Obtener el ID del préstamo desde el botón
    const formData = new FormData(); // Crear un objeto FormData
    formData.append('Id', id); // Agregar el ID del préstamo al FormData

    fetch('../../Controlador/GET/Autorizar_Prestamo.php', { // Enviar la solicitud al servidor
        method: 'POST', // Método POST para enviar datos 
        body: formData // Enviar el FormData con el ID del préstamo
    })
    .then(response => response.json()) // Procesar la respuesta del servidor como JSON
    .then(data => { // Manejar la respuesta del servidor
        if (data.success) { // Si la respuesta indica éxito
            Swal.fire({
                icon: 'success', // Mostrar una ventana emergente con un icono de éxito
                title: '¡Autorizado!', // Título de la ventana emergente
                text: data.message, // Mensaje de éxito
                timer: 1500, // Duración de la ventana emergente en milisegundos
                showConfirmButton: false // No mostrar botón de confirmación
            }).then(() => { // Después de que se cierre la ventana emergente
                window.location.href = data.redirect; // Redirigir al usuario a la URL proporcionada en la respuesta
            });
        } else {
            Swal.fire({ // Si la respuesta indica error
                icon: 'error', // Mostrar una ventana emergente con un icono de error
                title: 'Error', // Título de la ventana emergente
                text: data.message // Mensaje de error
            });
        }
    })
    .catch(error => { // Manejar errores de la solicitud
        Swal.fire({
            icon: 'error', // Mostrar una ventana emergente con un icono de error
            title: 'Error', // Título de la ventana emergente
            text: 'Hubo un problema al procesar la solicitud.' // Mensaje de error genérico
        });
        console.error(error); // Imprimir el error en la consola para depuración
    });
}