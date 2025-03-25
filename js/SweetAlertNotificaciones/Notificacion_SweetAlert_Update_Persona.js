// Se activa cuando haces clic en el boton, se envia el formulario
document.getElementById('FormUpdatePersona').addEventListener('submit', function (e) {
    e.preventDefault(); // Evita el comportamiento predeterminado del formulario (recargar la página)
    const formData = new FormData(e.target); // Recoge los datos del formulario

    // Realiza una petición al backend usando fetch
    fetch(e.target.action, { // La URL del formulario está en el atributo "action"
        method: e.target.method, // El método del formulario está en el atributo "method" (POST)
        body: formData // Los datos del formulario son enviados como "body"
    })
    .then(response => {
        if (!response.ok) {
            // Si la respuesta no es 2xx, lanza un error.
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json(); // Convierte la respuesta a JSON
    })
    .then(data => { // Maneja la respuesta del servidor
        console.log('Respuesta del servidor:', data); // Debugging: Verifica el JSON recibido
        if (data.success) { // Si el servidor indica éxito
            Swal.fire({
                icon: 'success', // Icono de éxito
                title: '¡Modificación exitosa!', // Título de la alerta
                text: data.message, // Mensaje enviado por el backend
                timer: 1500, // Duración de la alerta en milisegundos
                showConfirmButton: false // No muestra un botón de confirmación
            }).then(() => {
                // Redirige automáticamente a la URL proporcionada después del temporizador
                window.location.href = data.redirect;
            });
        } else { // Si la respuesta indica un fallo
            Swal.fire({
                icon: 'error', // Icono de error
                title: 'Error', // Título de la alerta
                text: data.message // Mensaje enviado por el backend
            });
        }
    })
    .catch(error => { // Maneja errores de red o del servidor
        console.error('Error capturado:', error); // Registra el error en la consola
        Swal.fire({
            icon: 'error', // Icono de error
            title: 'Error', // Título de la alerta
            text: 'Hubo un problema al procesar la solicitud.' // Mensaje genérico para el usuario
        });
    });
});  