// Función para mostrar u ocultar el campo de contraseña según la opción seleccionada
function toggleContrasena() {
    // Obtener el valor de la opción seleccionada en el elemento con ID 'Opcion'
    var opcion = document.getElementById('Opcion').value;
    
    // Obtener el contenedor de la contraseña con el ID 'contrasenaContainer'
    var contrasenaContainer = document.getElementById('contrasenaContainer');

    // Verificar si la opción seleccionada es 'SI'
    if (opcion === 'SI') {
        // Mostrar el contenedor de la contraseña si la opción es 'SI'
        contrasenaContainer.style.display = 'block';
    } else {
        // Ocultar el contenedor de la contraseña si la opción no es 'SI'
        contrasenaContainer.style.display = 'none';
    }
}