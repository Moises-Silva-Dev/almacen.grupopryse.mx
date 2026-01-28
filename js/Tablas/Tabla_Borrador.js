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

// Funciones para acciones de región
function editBorradorUser(id) {
    window.location.href = `Update/Update_Solicitud_ADMIN.php?id=${id}`;
}

// Esta función se utiliza cuando se elimina una cuenta mediante el identificador en la base de datos.
function eliminarRegistroBorradorRequisicion(id) { 
    // Confirmación de SweetAlert
    Swal.fire({
        title: '¿Estás seguro?', // título
        text: "Esta acción no se puede deshacer.", // mensaje
        icon: 'warning', // icono de advertencia
        showCancelButton: true, // mostrar botón de cancelar
        confirmButtonColor: '#d33', // color del botón de confirmación
        cancelButtonColor: '#3085d6', // color del botón de cancelar
        confirmButtonText: 'Sí, eliminar', // texto del botón de confirmación
        cancelButtonText: 'Cancelar' // texto del botón de cancelar
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, envía la solicitud al backend
            fetch(`../../Controlador/Usuarios/DELETE/Funcion_Delete_Borrador_Requision.php?id=${id}`, {
                method: 'GET' // método de solicitud
            })
            .then(response => response.json()) // Convierte la respuesta a JSON
            .then(data => { // Maneja la respuesta del servidor
                if (data.success) {
                    // Muestra mensaje de éxito
                    Swal.fire({
                        icon: 'success', // icono de éxito
                        title: '¡Eliminado!', // título
                        text: data.message, // mensaje
                        timer: 1500, // tiempo de duración
                        showConfirmButton: false , // no mostrar botón de confirmación
                    }).then(() => {
                        location.reload(); // Recargar la página para actualizar los datos
                    });
                } else {
                    // Muestra mensaje de error
                    Swal.fire({
                        icon: 'error', // icono de error
                        title: 'Error', // título
                        text: data.message , // mensaje
                    });
                }
            })
            .catch(error => {
                // Manejo de errores de red
                Swal.fire({
                    icon: 'error', // icono de error
                    title: 'Error', // título
                    text: 'Hubo un problema al procesar la solicitud.' , // mensaje
                });
                console.error(error); // Imprime el error en la consola
            });
        }
    });
}

// Función para abrir el modal y cargar la información del préstamo
function abrirModal(idRequisicion) {
    document.getElementById('modalRequisicion').style.display = 'block'; // Muestra el modal
    document.getElementById('contenidoRequisicion').innerHTML = 'Cargando datos...'; // Carga los datos en el contenido del modal

    fetch('../../Controlador/GET/getObtenerInfoBorradorRequisicion.php?id=' + idRequisicion) // Realiza la solicitud GET
    .then(response => response.text()) // Convierte la respuesta a texto
    .then(data => {
        document.getElementById('contenidoRequisicion').innerHTML = data; // Carga los datos en el contenido del modal
        document.getElementById('btnEnviar').setAttribute('data-id', idRequisicion); // Asigna el ID del préstamo al botón de autorizar
    })
    .catch(error => { // Manejo de errores en la solicitud 
        document.getElementById('contenidoRequisicion').innerHTML = 'Error al obtener los datos.'; // Manejo de errores
    });
}

// Función para cerrar el modal
function cerrarModal() {
    document.getElementById('modalRequisicion').style.display = 'none'; // Oculta el modal
}