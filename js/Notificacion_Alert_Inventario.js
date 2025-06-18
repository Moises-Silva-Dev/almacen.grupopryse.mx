// Función para verificar y mostrar notificaciones de productos con pocas existencias
function verificarExistencias() {
    fetch("../../Controlador/GET/getNotificacionAlertaInventario.php", { // Cambia la URL según tu estructura de carpetas
        method: "GET", // Método GET para obtener los datos
        headers: { 
            "Content-Type": "application/json" // Asegura que el servidor entienda el tipo de contenido
        }
    })
    .then(response => { // Maneja la respuesta del servidor
        if (!response.ok) { // Si la respuesta no es exitosa, lanza un error
            throw new Error("Error en la respuesta del servidor"); // Puedes personalizar el mensaje de error
        }
        return response.json(); // Convierte la respuesta a JSON
    })
    .then(data => { // Maneja los datos obtenidos
        // Código para mostrar las notificaciones
        const toastContainer = document.getElementById('toastContainer'); // Obtiene el contenedor de notificaciones
        const notificationDot = document.getElementById('notificationDot'); // Obtiene el punto rojo de notificación
        toastContainer.innerHTML = ''; // Limpiar notificaciones anteriores
        
        if (data.length > 0) { // Si hay productos con pocas existencias
            notificationDot.style.display = 'block'; // Mostrar el punto rojo de notificación
            data.forEach(producto => { // Itera sobre cada producto con pocas existencias
                // Crea un mensaje de notificación
                const mensaje = `El Producto "${producto.NombreProducto}", de la Talla "${producto.Talla}" con el Identificador "${producto.Identificador}", tiene pocas existencias en el inventario!`;
                const toast = document.createElement('div'); // Crea un nuevo elemento de notificación
                toast.className = 'toast'; // Estilo de la notificación

                toast.innerHTML = `
                    <strong>¡Alerta de Inventario!</strong> <!-- Título de la notificación --> 
                    <p>${mensaje}</p> <!-- Agrega el mensaje de notificación -->
                `; // Crea el contenido de la notificación
                
                toastContainer.prepend(toast); // Agrega la notificación al inicio del contenedor
                // Eliminar después de 5 segundos
                setTimeout(() => {
                    toast.style.animation = 'fadeOut 0.5s'; // Aplica animación de desvanecimiento
                    setTimeout(() => {
                        toast.remove(); // Eliminar la not
                        if (toastContainer.children.length === 0) { // Si no hay más notificaciones
                            notificationDot.style.display = 'none'; // Ocultar el punto rojo de notificación
                        }
                    }, 500); // Eliminar la notificación después de 5 segundos
                }, 5000); // 5000 milisegundos = 5 segundos
            });
        } else {
            notificationDot.style.display = 'none'; // Ocultar punto rojo si no hay notificaciones
            const toast = document.createElement('div'); // Crea un nuevo elemento de notificación
            toast.className = 'toast info'; // Estilo de la notificación
            toast.innerHTML = `
                <strong>Sin notificaciones</strong> <!-- Título de la notificación -->
                <p>No hay productos con pocas existencias</p> <!-- Mensaje de no hay notificaciones -->
            `; // Crea el contenido de la notificación

            toastContainer.prepend(toast); // Agrega la notificación al inicio del contenedor
            setTimeout(() => { // Eliminar la notificación después de 5 segundos
                toast.remove(); // Mostrar mensaje de "No hay notificaciones"
            }, 5000); // 5000 milisegundos = 5 segundos
        }
    })
    .catch(error => { // Maneja errores de la solicitud
        console.error("Error al obtener notificaciones:", error); // Maneja errores de la solicitud
        // Mostrar notificación de error
        const toast = document.createElement('div'); // Crea un nuevo elemento de notificación
        toast.className = 'toast error';
        toast.innerHTML = `
            <strong>Error</strong> <!-- Título de la notificación -->
            <p>No se pudieron cargar las notificaciones</p> <!-- Mensaje de error -->
        `;

        document.getElementById('toastContainer').prepend(toast); // Agrega la notificación al inicio del contenedor
        setTimeout(() => { // Eliminar la notificación después de 5 segundos
            toast.remove(); // Mostrar mensaje de "No hay notificaciones"
        }, 5000); // 5000 milisegundos = 5 segundos
    });
}

// Llamar a la función al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('notificationDot').style.display = 'none'; // Ocultar el punto de notificación al inicio
    const menuToggle = document.getElementById('menu-toggle'); // Obtiene el botón de menú
    const navbarVertical = document.getElementById('navbar-vertical'); // Obtiene el menú vertical
    
    // Toggle del menú en móviles
    menuToggle.addEventListener('click', function() {
        // Alterna la clase 'active' para mostrar/ocultar el menú
        navbarVertical.classList.toggle('active');
    });
    
    // Cerrar menú al hacer clic en un enlace (en móviles)
    const navLinks = document.querySelectorAll('.navbar-vertical a');
    navLinks.forEach(link => {
        link.addEventListener('click', function() { // Verifica el ancho de la ventana al hacer clic en un enlace
            if (window.innerWidth <= 768) { // Verifica si el ancho de la ventana es menor o igual a 768px
                navbarVertical.classList.remove('active'); // Si el ancho de la ventana es menor o igual a 768px, cierra el menú
            }
        });
    });
});

// Función para el botón de notificaciones
function mostrarNotificacion() {
    verificarExistencias(); // Simplemente llama a la función de verificación
    document.getElementById('toastContainer').scrollIntoView({ // También puedes hacer scroll al contenedor de notificaciones
        behavior: 'smooth' // Desplazamiento suave al contenedor de notificaciones
    });
}