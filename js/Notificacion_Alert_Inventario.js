// Función para mostrar un toast
function mostrarToast(mensaje) {
    // Obtener el contenedor de toasts (elemento HTML donde se agregarán las notificaciones flotantes)
    const toastContainer = document.getElementById('toastContainer');

    // Crear un nuevo elemento div para representar el toast
    const toast = document.createElement('div');

    // Estilo del toast: define fondo, color, espaciado, bordes y animaciones
    toast.style.background = '#ff6b6b'; // Fondo rojo para indicar alerta
    toast.style.color = '#fff'; // Texto blanco
    toast.style.padding = '10px 15px'; // Espaciado interno del contenido
    toast.style.marginBottom = '10px'; // Espacio entre toasts
    toast.style.borderRadius = '5px'; // Bordes redondeados
    toast.style.boxShadow = '0 2px 6px rgba(0,0,0,0.15)'; // Sombra para darle efecto flotante
    toast.style.transition = 'opacity 0.5s ease-in-out'; // Transición suave para ocultar el toast
    toast.style.opacity = '1'; // Opacidad inicial (completamente visible)
    toast.textContent = mensaje; // Asignar el texto del mensaje al toast

    // Agregar el toast al contenedor de toasts
    toastContainer.appendChild(toast);

    // Configurar un temporizador para desaparecer el toast después de 5 segundos
    setTimeout(() => {
        toast.style.opacity = '0'; // Reducir la opacidad a 0 (efecto de desaparición)
        setTimeout(() => {
            // Verificar si el toast aún existe en el contenedor antes de eliminarlo
            if (toastContainer.contains(toast)) {
                toastContainer.removeChild(toast); // Eliminar el toast del DOM
            }
        }, 500); // Esperar 0.5 segundos después de iniciar la transición para eliminarlo
    }, 5000); // Tiempo total antes de iniciar la transición (5 segundos)
}

// Función para mostrar las notificaciones
function mostrarNotificacion() {
    // Crear un objeto XMLHttpRequest para realizar una solicitud AJAX
    var xhttp = new XMLHttpRequest();

    // Definir la función que se ejecutará cuando cambie el estado de la solicitud
    xhttp.onreadystatechange = function() {
        // Verificar si la solicitud ha sido completada con éxito
        if (this.readyState == 4 && this.status == 200) {
            // Parsear la respuesta JSON recibida del servidor
            var respuesta = JSON.parse(this.responseText);

            // Si hay notificaciones, iterar sobre ellas
            if (respuesta.length > 0) {
                respuesta.forEach(function(producto) {
                    // Construir un mensaje de notificación para cada producto
                    var mensaje = `El Producto "${producto.NombreProducto}", de la Talla "${producto.Talla}" con el Identificador "${producto.Identificador}", tiene pocas existencias en el inventario!`;

                    // Mostrar el mensaje utilizando la función mostrarToast
                    mostrarToast(mensaje);
                });

                // Ocultar el punto de notificación indicando que ya se han leído las alertas
                document.getElementById('notificationDot').style.display = 'none';
            }
        }
    };

    // Configurar la solicitud AJAX para obtener las notificaciones desde el servidor
    xhttp.open("GET", "../../Controlador/GET/Veri.php", true);
    xhttp.send(); // Enviar la solicitud
}

// Función para cargar la notificación al iniciar la página
function cargarNotificacion() {
    // Crear un objeto XMLHttpRequest para realizar una solicitud AJAX
    var xhttp = new XMLHttpRequest();

    // Definir la función que se ejecutará cuando cambie el estado de la solicitud
    xhttp.onreadystatechange = function() {
        // Verificar si la solicitud ha sido completada con éxito
        if (this.readyState == 4 && this.status == 200) {
            // Parsear la respuesta JSON recibida del servidor
            var respuesta = JSON.parse(this.responseText);

            // Si hay notificaciones pendientes, mostrar el punto de notificación
            if (respuesta.length > 0) {
                document.getElementById('notificationDot').style.display = 'block';
            }
        }
    };

    // Configurar la solicitud AJAX para obtener las notificaciones desde el servidor
    xhttp.open("GET", "../../Controlador/GET/Veri.php", true);
    xhttp.send(); // Enviar la solicitud
}

// Cargar la notificación automáticamente al cargar la página
window.onload = function() {
    cargarNotificacion(); // Llamar a la función cargarNotificacion cuando la página se haya cargado
};