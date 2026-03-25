// Se activa cuando haces clic en el boton, se envia el formulario
document.getElementById('FormInsertUsuarioNuevo').addEventListener('submit', function (e) {
    e.preventDefault(); // Evita el comportamiento predeterminado del formulario (recargar la página)

    // Validar último paso antes de enviar
    if (!validateCurrentStep()) {
        Swal.fire({
            icon: 'warning',
            title: 'Validación',
            text: 'Por favor, completa todos los campos correctamente.',
            confirmButtonColor: '#001F3F'
        });
        return;
    }

    const formData = new FormData(e.target); // Recoge los datos del formulario
    // Mostrar loading
    Swal.fire({
        title: 'Guardando usuario...',
        text: 'Por favor, espera un momento.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

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
                const modal = bootstrap.Modal.getInstance(document.getElementById('registroUsuarioModal'));
                modal.hide(); // Cerrar el modal
                window.location.href = data.redirect; // Recargar la página o redirigir
            });
        } else { // Si el inicio de sesión falla
            Swal.fire({
                icon: 'error', // Icono de error
                title: 'Error', // Título de la alerta
                text: data.message, // Mensaje enviado por el backend
                confirmButtonColor: '#001F3F'
            });
        }
    })
    .catch(error => { // Maneja los errores en caso de que la petición falle
        Swal.fire({
            icon: 'error', // Icono de error
            title: 'Error', // Título de la alerta
            text: 'Hubo un problema al procesar la solicitud.', // Mensaje genérico para el usuario
            confirmButtonColor: '#001F3F'            
        });
        console.error('Error en la solicitud:', error); // Muestra el error detallado en la consola para depuración
    });
});  