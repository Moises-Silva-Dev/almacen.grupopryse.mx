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

// Funciones para acciones de usuario
function editProductoDev(id) {
    window.location.href = `Update/Update_Producto_Dev.php?id=${id}`;
}

function editProductoAlmacenista(id) {
    window.location.href = `Update/Update_Producto_ALMACENISTA.php?id=${id}`;
}

// Esta función se utiliza cuando se elimina una cuenta mediante el identificador en la base de datos.
function eliminarRegistroProducto(id) { 
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
            fetch(`../../Controlador/Usuarios/DELETE/Funcion_Delete_Producto.php?id=${id}`, {
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

// Versión alternativa usando JavaScript puro
function mostrarProducto(idProducto) {
    fetch(`../../Controlador/GET/getObtenerFotoProductoInfo.php?id=${idProducto}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar contenido
                document.getElementById("productoIMG").src = data.producto.IMG;
                document.getElementById("productoDescripcion").textContent = data.producto.Descripcion;
                document.getElementById("productoEspecificacion").textContent = data.producto.Especificacion;
                document.getElementById("productoEmpresa").textContent = data.producto.Nombre_Empresa;
                document.getElementById("productoCategoria").textContent = data.producto.Descrp;
                document.getElementById("productoTipoTalla").textContent = data.producto.Descrip;
                
                // Mostrar modal manualmente (si Bootstrap falla)
                const modal = document.getElementById('productoModal');
                modal.style.display = 'block';
                modal.classList.add('show');
                document.body.classList.add('modal-open');
                
                // Agregar backdrop manualmente
                const backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                document.body.appendChild(backdrop);
                
                // Manejar cierre
                const closeButtons = modal.querySelectorAll('[data-bs-dismiss="modal"], .btn-secondary');
                closeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        modal.style.display = 'none';
                        modal.classList.remove('show');
                        document.body.classList.remove('modal-open');
                        if (backdrop.parentNode) {
                            backdrop.parentNode.removeChild(backdrop);
                        }
                    });
                });
                
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar los datos');
        });
}