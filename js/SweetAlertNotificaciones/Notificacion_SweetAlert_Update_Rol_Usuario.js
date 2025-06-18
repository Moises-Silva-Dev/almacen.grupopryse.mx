// Envío del formulario
document.getElementById('FormUpdateRolUsuario').addEventListener('submit', function(e) { // Agrega un evento de escucha al formulario
    actualizarDatosTabla(); // Inicializar datos

    const nuevoTipo = parseInt(document.getElementById('ID_Tipo').value); // Obtiene el nuevo tipo de usuario seleccionado
    if ((nuevoTipo === 3 || nuevoTipo === 4) && cuentasSeleccionadas.length === 0) { // Si el nuevo tipo es 3 o 4 y no hay cuentas seleccionadas
        Swal.fire('Error', 'Debes asignar al menos una cuenta para este tipo de usuario', 'error'); // Muestra una alerta de error
        e.preventDefault(); // Detiene el envío del formulario
        return;
    }
    
    e.preventDefault(); // Evita que se envíe el formulario por defecto
    const formData = new FormData(this); // Crea un objeto FormData con los datos del formulario
    
    fetch(this.action, {
        method: 'POST', // Método HTTP POST
        body: formData // Envía los datos del formulario al servidor
    })
    .then(async response => {
        const text = await response.text(); // Recibe la respuesta del servidor como texto
        console.log('Respuesta cruda:', text); // Imprime la respuesta cruda en la consola
        try {
            const data = JSON.parse(text); // Intenta parsear la respuesta como JSON
            if (data.success) { // Si la respuesta es exitosa
                Swal.fire({ 
                    icon: 'success', // Icono de éxito
                    title: '¡Cambios guardados!', // Mensaje de éxito
                    text: data.message, // Mensaje de éxito
                    timer: 1500, // Tiempo de duración del mensaje
                    showConfirmButton: false // No muestra el botón de confirmación
                }).then(() => {
                    window.location.href = data.redirect; // Redirige a la página de inicio
                });
            } else {
                Swal.fire({
                    icon: 'error', // Icono de error
                    title: 'Error', // titulo de error
                    text: data.message // Mensaje de error
                });
            }
        } catch (err) {
            Swal.fire('Error', 'Respuesta no válida del servidor. Detalle: ' + err.message, 'error'); // Muestra una alerta de error
            console.error('JSON inválido:', text); // Imprime el error en la consola
        }
    })
    .catch(error => {
        Swal.fire('Error', 'Error de conexión: ' + error.message, 'error'); // Muestra una alerta de error
        console.error(error); // Imprime el error en la consola
    });
});