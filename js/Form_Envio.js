document.getElementById('Opcion').addEventListener('change', function() {
    // Obtener el valor seleccionado del elemento con ID 'Opcion'
    var seleccion = this.value;
    
    // Obtener el elemento con ID 'Envio'
    var nuevoEmpresaDiv2 = document.getElementById('Envio');
    
    // Mostrar u ocultar el elemento 'Envio' dependiendo de la selección
    nuevoEmpresaDiv2.style.display = seleccion === 'SI' ? 'block' : 'none';
});