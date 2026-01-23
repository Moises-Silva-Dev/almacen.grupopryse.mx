// Función para limpiar búsqueda
function clearSearch() {
    window.location.href = window.location.pathname;
}

// Función para refrescar página
function refreshPage() {
    window.location.reload();
}

// Función para ir a página específica
function goToPage(page) {
    const url = new URL(window.location.href);
    url.searchParams.set('page', page);
    window.location.href = url.toString();
}

// Función para seleccionar todos los checkboxes
document.getElementById('selectAll').addEventListener('change', function(e) {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = e.target.checked;
    });
});

// Función para abrir el modal y cargar la información del préstamo
function abrirModal(idRequisicion) {
    document.getElementById('modalRequisicion').style.display = 'block'; // Muestra el modal
    document.getElementById('contenidoRequisicion').innerHTML = 'Cargando datos...'; // Carga los datos en el contenido del modal

    fetch('../../Controlador/GET/getObtenerInfoRequisicion.php?id=' + idRequisicion) // Realiza la solicitud GET
    .then(response => response.text()) // Convierte la respuesta a texto
    .then(data => {
        document.getElementById('contenidoRequisicion').innerHTML = data; // Carga los datos en el contenido del modal
        document.getElementById('btnAutorizar').setAttribute('data-id', idRequisicion); // Asigna el ID del préstamo al botón de autorizar
    })
    .catch(error => { // Manejo de errores en la solicitud 
        document.getElementById('contenidoRequisicion').innerHTML = 'Error al obtener los datos.'; // Manejo de errores
    });
}

// Función para cerrar el modal
function cerrarModal() {
    document.getElementById('modalRequisicion').style.display = 'none'; // Oculta el modal
}