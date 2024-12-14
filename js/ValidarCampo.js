(() => {
    'use strict'; // Habilita el modo estricto para evitar errores silenciosos y mejorar la calidad del código.

    // Obtiene todos los formularios con la clase `needs-validation` en el DOM.
    const forms = document.querySelectorAll('.needs-validation');

    // Recorre todos los formularios encontrados para aplicarles el evento de validación.
    Array.from(forms).forEach((form) => {
        // Agrega un listener al evento `submit` del formulario.
        form.addEventListener('submit', (event) => {
            // Si el formulario no es válido, se previene el envío.
            if (!form.checkValidity()) {
                event.preventDefault(); // Evita que se envíe el formulario.
                event.stopPropagation(); // Detiene la propagación del evento.
            }

            // Agrega la clase `was-validated` al formulario para aplicar estilos de Bootstrap según la validación.
            form.classList.add('was-validated');
        }, false);
    });
})();