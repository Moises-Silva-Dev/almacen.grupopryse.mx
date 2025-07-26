// Se activa cuando haces clic en el boton, se envia el formulario
document.getElementById('FormInsertCuentaNueva').addEventListener('submit', function (e) {
    e.preventDefault(); // Evita el comportamiento predeterminado del formulario (recargar la página)
    
    const form = e.target; // Obtiene el formulario que se está enviando
    const formData = new FormData(form); // Crea un objeto FormData a partir del formulario
    const submitButton = form.querySelector('button[type="submit"]'); // Obtiene el botón de envío del formulario
    const originalButtonText = submitButton.innerHTML; // Guarda el texto original del botón de envío

    submitButton.disabled = true; // Deshabilita el botón de envío para evitar múltiples envíos
    // Cambia el texto del botón de envío a "Procesando..."
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...';
    
    // Mostrar notificación de carga
    const loadingAlert = Swal.fire({
        title: 'Registrando cuenta...', // Título de la notificación
        html: `
            <div class="progress-container" style="width:100%;margin-top:15px;">
                <div class="progress-bar" style="height:5px;background:#f1f1f1;border-radius:5px;">
                    <div class="progress" style="height:100%;width:0%;background:#3085d6;border-radius:5px;transition:width 0.5s;"></div>
                </div>
                <p style="text-align:center;margin-top:10px;font-size:14px;color:#666;">Por favor espera, esto puede tomar unos momentos...</p>
            </div>
        `, // Contenido de la notificación
        allowOutsideClick: false, // Ocultar el botón de confirmación
        showConfirmButton: false, // Ocultar el botón de confirmación
        
        didOpen: () => { // Función que se ejecuta cuando la notificación se abre
            const progressBar = document.querySelector('.progress'); // Animación de barra de progreso
            let width = 0; // Variable para controlar el ancho de la barra de progreso

            const interval = setInterval(() => { // Función que se ejecuta cada 50ms
                width += 1; // Aumenta la variable de progreso
                if(width <= 90) { // No llega al 100% para que no parezca completado
                    progressBar.style.width = width + '%'; // Aumenta la barra de progreso
                }
            }, 50); // 50ms para que la barra se vea fluida
            
            progressBar.dataset.interval = interval; // Guardar referencia para limpiar luego
        }
    });
    
    const timeout = setTimeout(() => { // Configurar timeout para conexiones lentas (30 segundos)
        loadingAlert.then(() => { // Si el timeout pasa, cierra la notificación y muestra un mensaje de advertencia
            Swal.fire({
                icon: 'warning', // Icono de advertencia de SweetAlert2
                title: 'Conexión lenta', // Título de la advertencia
                text: 'El registro está tardando más de lo esperado. Por favor verifica tu conexión a internet.', // Mensaje de advertencia
                confirmButtonText: 'Entendido', // Texto del botón de confirmación
                confirmButtonColor: '#3085d6' // Color del botón de confirmación
            });
        });
    }, 30000); // 30 segundos

    // Realiza una petición al backend usando fetch
    fetch(form.action, { // La URL del formulario está en el atributo "action"
        method: form.method, // El método del formulario está en el atributo "method" (POST)
        body: formData // Los datos del formulario son enviados como "body"
    })
    .then(response => {
        clearTimeout(timeout); // Limpiar timeout si hay respuesta
        const progressBar = document.querySelector('.progress'); // Obtener la barra de progreso

        if(progressBar) { // Si la barra de progreso existe
            clearInterval(progressBar.dataset.interval); // Detener animación de barra de progreso
            progressBar.style.width = '100%'; // Completar barra
        }
        return response.json(); // Convierte la respuesta en formato JSON
    })
    .then(data => { // Maneja la respuesta del servidor
        Swal.close(); // Cerrar alerta de carga

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
            
            submitButton.disabled = false; // Restaurar botón de envío
            submitButton.innerHTML = originalButtonText; // Restaurar texto original del botón
        }
    })
    .catch(error => { // Maneja los errores en caso de que la petición falle
        clearTimeout(timeout); // Limpiar timeout
        Swal.close(); // Cerrar alerta de carga
    
        Swal.fire({
            icon: 'error', // Icono de error
            title: 'Error de conexión', // Título de la alerta
            text: 'No se pudo completar el registro. Por favor verifica tu conexión a internet e intenta nuevamente.',
            confirmButtonText: 'Reintentar', // Texto del botón de reintentar
            showCancelButton: true, // Muestra un botón de cancelar
            cancelButtonText: 'Cancelar' // Texto del botón de cancelar
        }).then((result) => { // Maneja el evento de cancelar
            if(result.isConfirmed) { // Si el usuario confirma el reintentar
                form.dispatchEvent(new Event('submit')); // Reenvía el formulario
            } else {
                submitButton.disabled = false; // Restaurar botón
                submitButton.innerHTML = originalButtonText; // Restaurar texto original del botón
            }
        });
        
        console.error('Error:', error); // Mostrar mensaje de error en la consola
    });
});  