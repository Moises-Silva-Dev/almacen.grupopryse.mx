// Agrega un evento al botón con el ID 'BtnMostrarTablaProductos' para que realice una acción al hacer clic.
document.getElementById('BtnMostrarTablaProductos').addEventListener('click', function () {
    // Crea una instancia del modal de Bootstrap asociada al elemento con el ID 'tablaModal'.
    const modal = new bootstrap.Modal(document.getElementById('tablaModal'));
    // Muestra el modal de manera manual.
    modal.show();

    // Realiza una solicitud para cargar los datos de la tabla.
    // Hace una solicitud GET al archivo PHP para obtener los datos.
    fetch('../../../Controlador/GET/getVistaTablaProductos.php') 
        // Convierte la respuesta en texto (HTML).
        .then(response => response.text()) 
        .then(data => {
            // Inserta los datos obtenidos dentro del cuerpo de la tabla con el ID 'tablaCuerpo'.
            document.getElementById('tablaCuerpo').innerHTML = data;
        })
        // Maneja errores en la solicitud y los muestra en la consola.
        .catch(error => console.error('Error al cargar los datos:', error)); 
});

// Agrega un evento al campo de entrada con el ID 'buscador' para filtrar productos en tiempo real.
document.getElementById('buscador').addEventListener('input', function () {
    // Convierte el valor ingresado en el buscador a minúsculas para comparaciones no sensibles a mayúsculas/minúsculas.
    const searchValue = this.value.toLowerCase();

    // Selecciona todas las filas dentro del cuerpo de la tabla con el ID 'tablaCuerpo'.
    const rows = document.querySelectorAll('#tablaCuerpo tr');

    // Itera sobre cada fila de la tabla.
    rows.forEach(row => {
        // Obtiene el contenido de texto de cada fila y lo convierte a minúsculas.
        const text = row.textContent.toLowerCase();

        // Compara si el texto de la fila incluye el valor buscado.
        // Si incluye el texto, muestra la fila, de lo contrario, ocúltala.
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});