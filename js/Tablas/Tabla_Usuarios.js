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
function editUser(id) {
    window.location.href = `Update/Update_Usuario_Dev.php?id=${id}`;
}

function changeRole(id) {
    window.location.href = `Update/Update_Rol_Usuario_Dev.php?id=${id}`;
}

// Función para búsqueda con debounce
let searchTimeout;
document.querySelector('input[name="search"]').addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        if (e.target.value.length === 0 || e.target.value.length >= 3) {
            e.target.form.submit();
        }
    }, 500);
});