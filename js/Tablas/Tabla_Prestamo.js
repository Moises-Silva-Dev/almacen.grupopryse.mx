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

function insertPrestamoAlmacenista(id) {
    window.location.href = `INSERT/Insert_Prestamo_ALMACENISTA.php?id=${id}`;
}

// Función para seleccionar todos los checkboxes
document.getElementById('selectAll').addEventListener('change', function(e) {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = e.target.checked;
    });
});