// Variables globales
let searchTimeout;

// Función para limpiar búsqueda
function clearSearch() {
    const url = new URL(window.location.href);
    url.searchParams.delete('search');
    window.location.href = url.toString();
}

// Función para limpiar filtros
function clearFilter() {
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
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function(e) {
            const checkboxes = document.querySelectorAll('.region-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
        });
    }
    
    // Configurar búsqueda con debounce
    const searchInput = document.getElementById('search');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (e.target.value.length === 0 || e.target.value.length >= 2) {
                    document.getElementById('filterForm').submit();
                }
            }, 600);
        });
        
        // Auto-focus si hay búsqueda
        if (searchInput.value) {
            searchInput.focus();
            searchInput.select();
        }
    }
    
    // Inicializar tooltips de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Funciones para acciones de región
function editRegion(id) {
    window.location.href = `Update/Update_Region_Dev.php?id=${id}`;
}

// Función para cambiar cuenta (auto-submit)
document.getElementById('cuenta')?.addEventListener('change', function() {
    // Si hay búsqueda, mantenerla
    const searchInput = document.getElementById('search');
    if (searchInput && searchInput.value) {
        // El formulario se enviará automáticamente
    } else {
        this.form.submit();
    }
});

// Esta función se utiliza cuando se elimina una cuenta mediante el identificador en la base de datos.
function eliminarRegistroRegion(id) { 
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
            fetch(`../../Controlador/Usuarios/DELETE/Funcion_Delete_Region.php?id=${id}`, {
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