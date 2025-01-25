// Se activa cuando haces clic en el boton, se envia el formulario
document.getElementById('FormInsertProductoNuevo').addEventListener('submit', function (e) {
    e.preventDefault(); // Evita el comportamiento predeterminado del formulario (recargar la página)
    const formData = new FormData(e.target); // Recoge los datos del formulario
  
    // Realiza una petición al backend usando fetch
    fetch(e.target.action, { // La URL del formulario está en el atributo "action"
        method: e.target.method, // El método del formulario está en el atributo "method" (POST)
        body: formData // Los datos del formulario son enviados como "body"
    })
        .then(response => response.json()) // Convierte la respuesta del servidor a formato JSON
        .then(data => { // Maneja la respuesta del servidor
            if (data.success) { // Si el servidor indica que el inicio de sesión fue exitoso
                Swal.fire({
                    icon: 'success', // Icono de éxito
                    title: '¡Registro exitoso!', // Título de la alerta
                    text: data.message, // Mensaje enviado por el backend
                    timer: 1500, // Tiempo de duración de la alerta (en milisegundos)
                    showConfirmButton: false // No muestra un botón de confirmación
                }).then(() => {
                    // Redirige automáticamente a la URL proporcionada por el backend después del temporizador
                    window.location.href = data.redirect;
                });
            } else { // Si el inicio de sesión falla
                Swal.fire({
                    icon: 'error', // Icono de error
                    title: 'Error', // Título de la alerta
                    text: data.message // Mensaje enviado por el backend
                });
            }
        })
        .catch(error => { // Maneja los errores en caso de que la petición falle
            Swal.fire({
                icon: 'error', // Icono de error
                title: 'Error', // Título de la alerta
                text: 'Hubo un problema al procesar la solicitud.' // Mensaje genérico para el usuario
            });
            console.error('Error en la solicitud:', error); // Muestra el error detallado en la consola para depuración
        });
});  