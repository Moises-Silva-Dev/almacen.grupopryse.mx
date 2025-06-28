// Se activa cuando haces clic en el botón, se envía el formulario
document.getElementById('FormUpdatePrestamo').addEventListener('submit', function (e) {
    actualizarDatosTabla(); // Actualiza los datos de la tabla antes de enviar el formulario

    if (datosTablaInput.value === "[]") { // Verifica si no se han agregado estados
        Swal.fire({
            icon: "error", // Icono de error
            title: "Sin estados agregados", // Título del mensaje
            text: "Por favor, agregue al menos un estado antes de enviar el formulario."
        });

        e.preventDefault(); // Detiene el envío del formulario
        return; // Finaliza la ejecución aquí
    }
    
    // Si se han agregado estados, procede a enviar el formulario
    e.preventDefault(); // Evita el comportamiento predeterminado del formulario (recargar la página)
    const formData = new FormData(e.target); // Recoge los datos del formulario

    // Realiza una petición al backend usando fetch
    fetch(e.target.action, { // La URL del formulario está en el atributo "action"
        method: e.target.method, // El método del formulario está en el atributo "method" (POST)
        body: formData // Los datos del formulario son enviados como "body"
    })
    .then(response => response.json()) // Convierte la respuesta del servidor a formato JSON
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
        Swal.fire({
            icon: 'error', // Icono de error
            title: 'Error', // Título de la alerta
            text: 'Hubo un problema al procesar la solicitud.' // Mensaje genérico para el usuario
        });
        console.error(error); // Muestra el error detallado en la consola para depuración
    });
});