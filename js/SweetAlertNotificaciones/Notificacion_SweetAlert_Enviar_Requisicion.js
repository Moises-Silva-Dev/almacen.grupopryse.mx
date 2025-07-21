// Se activa cuando haces clic en el boton, se envia el formulario
function requisicionEnviar() {
    const id = document.getElementById('btnEnviar').getAttribute('data-id'); // Obtener el ID del préstamo desde el botón
    const formData = new FormData(); // Crear un objeto FormData
    formData.append('Id', id); // Agregar el ID del préstamo al FormData

    // Mostrar pantalla de carga con opciones para conexiones lentas
    const loadingAlert = Swal.fire({ // Configurar alerta de carga
        title: 'Procesando solicitud...', // Título de la alerta
        html: 'Por favor espera mientras enviamos la requisición.<br><div class="progress-bar" style="margin-top:10px;width:100%;height:5px;background:#f1f1f1;"><div class="progress-bar-value" style="height:100%;width:0%;background:#3085d6;"></div></div>',
        icon: 'info', // Icono de información
        allowOutsideClick: false, // No permitir cerrar la alerta al hacer clic fuera de ella
        showConfirmButton: false, // No mostrar botón de confirmación
        didOpen: () => { // Al abrir la alerta
            Swal.showLoading(); // Mostrar carga en la alerta
            
            // Animación de barra de progreso para conexiones lentas
            const progressBar = document.querySelector('.progress-bar-value'); // Seleccionar la barra de progreso
            let width = 0; // Inicializar ancho de la barra de progreso en 0%
            const interval = setInterval(() => { // Configurar intervalo para actualizar la barra de progreso
                width += 1; // Incrementar el ancho de la barra de progreso
                progressBar.style.width = width + '%'; // Actualizar el ancho de la barra de progreso
                
                if (width >= 100) { // Si el ancho alcanza el 100%
                    clearInterval(interval); // Detener el intervalo
                }
            }, 50); // Actualizar cada 50 ms
        }
    });

    // Configurar timeout para conexiones lentas (30 segundos)
    const timeout = setTimeout(() => { // Si la alerta no se cierra en 30 segundos
        loadingAlert.then(() => { // Mostrar alerta de conexión lenta
            Swal.fire({
                icon: 'warning', // Tipo de icono
                title: 'Conexión lenta', // Título de la alerta
                text: 'La solicitud está tardando más de lo esperado. Por favor verifica tu conexión a internet.',
                confirmButtonText: 'Entendido' // Botón de confirmación
            });
        });
    }, 30000); // 30 segundos de timeout

    // Realiza una petición al backend usando fetch
    fetch('../../Controlador/Usuarios/INSERT/Funcion_Insert_Requisicion_Original.php', { // La URL del formulario está en el atributo "action"
        method: 'POST', // El método del formulario está en el atributo "method" (POST)
        body: formData // Los datos del formulario son enviados como "body"
    })
    .then(response => { // Procesar la respuesta del servidor
        clearTimeout(timeout); // Limpiar el timeout si la respuesta llega
        return response.json(); // Procesar la respuesta como JSON
    })
    .then(data => { // Manejar la respuesta del servidor
        Swal.close(); // Cerrar el loading alert

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
        clearTimeout(timeout); // Limpiar el timeout si hay error
        Swal.close(); // Cerrar el loading alert

        Swal.fire({
            icon: 'error', // Mostrar una ventana emergente con un icono de error
            title: 'Error de conexión', // Título de la ventana emergente
            text: 'Hubo un problema al procesar la solicitud. Por favor verifica tu conexión a internet e intenta nuevamente.',
            confirmButtonText: 'Reintentar', // Botón de reintentar
            showCancelButton: true, // Mostrar botón de cancelar
            cancelButtonText: 'Cancelar' // Texto del botón de cancelar
        }).then((result) => { // Manejar la respuesta del usuario
            if (result.isConfirmed) { // Si el usuario confirma reintentar
                autorizarRequisicion(); // Reintentar la función
            }
        });
        console.error('Error:', error); // Imprimir el error en la consola para depuración
    });
}