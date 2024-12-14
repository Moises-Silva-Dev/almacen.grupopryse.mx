// Función para mostrar u ocultar el campo de nuevo nombre de empresa según la selección
document.getElementById('IdCEmpresa').addEventListener('change', function() {
    // Obtener el div que contiene el campo de nuevo nombre de empresa
    var nuevoEmpresaDiv = document.getElementById('nuevoEmpresaDiv');
    // Mostrar el div si se selecciona 'nuevo_empresa', de lo contrario ocultarlo
    nuevoEmpresaDiv.style.display = this.value === 'nuevo_empresa' ? 'block' : 'none';
});      

// Función para mostrar u ocultar el campo de nueva categoría según la selección
document.getElementById('IdCCate').addEventListener('change', function() {
    // Obtener el div que contiene el campo de nueva categoría
    var nuevaCateDiv = document.getElementById('nuevaCateDiv');
    // Mostrar el div si se selecciona 'nueva_Cate', de lo contrario ocultarlo
    nuevaCateDiv.style.display = this.value === 'nueva_Cate' ? 'block' : 'none';
}); 

// Función para mostrar u ocultar el campo de nuevo tipo de taller según la selección
document.getElementById('IdCTipTall').addEventListener('change', function() {
    // Obtener el div que contiene el campo de nuevo tipo de taller
    var nuevaTipTallDiv = document.getElementById('nuevaTipTalls');
    // Mostrar el div si se selecciona 'nueva_TipTall', de lo contrario ocultarlo
    nuevaTipTallDiv.style.display = this.value === 'nueva_TipTall' ? 'block' : 'none';
}); 