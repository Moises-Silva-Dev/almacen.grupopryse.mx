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