// Se activa cuando haces clic en el boton, se envia el formulario
document.getElementById('FormInsertRegionNueva').addEventListener("submit", function(e) {
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
    e.preventDefault(); // Evita el envío estándar del formulario
    const formData = new FormData(e.target); // Recoge los datos del formulario

    // Realiza una petición al backend usando fetch
    fetch(e.target.action, { // La URL del formulario está en el atributo "action"
        method: e.target.method, // El método del formulario está en el atributo "method" (POST)
        body: formData // Los datos del formulario son enviados como "body"
    })
        .then(response => response.json()) // Convierte la respuesta del servidor a formato JSON
        .then(data => { // Maneja la respuesta del servidor
            if (data.success) { // Si el servidor indica éxito
                Swal.fire({
                    icon: 'success', // Icono de éxito
                    title: '¡Registro exitoso!', // Título de la alerta
                    text: data.message, // Mensaje enviado por el backend
                    timer: 1500, // Duración de la alerta (ms)
                    showConfirmButton: false // No muestra botón de confirmación
                }).then(() => {
                    // Redirige a la URL proporcionada por el backend
                    window.location.href = data.redirect;
                });
            } else { // Si el servidor indica un error
                Swal.fire({
                    icon: 'error', // Icono de error
                    title: 'Error', // Título de la alerta
                    text: data.message // Mensaje enviado por el backend
                });
            }
        })
        .catch(error => { // Maneja errores en la petición
            Swal.fire({
                icon: 'error', // Icono de error
                title: 'Error', // Título de la alerta
                text: 'Hubo un problema al procesar la solicitud.' // Mensaje genérico
            });
            console.error(error); // Muestra el error en la consola
        });
});