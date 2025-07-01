
// Función para abrir el modal y cargar la información del préstamo
function abrirModal(idPrestamo) {
    document.getElementById('modalPrestamo').style.display = 'block'; // Muestra el modal
    document.getElementById('contenidoPrestamo').innerHTML = 'Cargando datos...'; // Carga los datos en el contenido del modal

    fetch('../../Controlador/GET/getObtenerInfoPrestamo.php?id=' + idPrestamo) // Realiza la solicitud GET
    .then(response => response.text()) // Convierte la respuesta a texto
    .then(data => {
        document.getElementById('contenidoPrestamo').innerHTML = data; // Carga los datos en el contenido del modal
        document.getElementById('btnAutorizar').setAttribute('data-id', idPrestamo); // Asigna el ID del préstamo al botón de autorizar
    })
    .catch(error => { // Manejo de errores en la solicitud 
        document.getElementById('contenidoPrestamo').innerHTML = 'Error al obtener los datos.'; // Manejo de errores
    });
}

// Función para cerrar el modal
function cerrarModal() {
    document.getElementById('modalPrestamo').style.display = 'none'; // Oculta el modal
}