// Esta función se utiliza para limpiar la variables del formulario de reclutas
function resetFormFiltro() {
    // Obtiene el identificador del formulario
    var form = document.getElementById('reclutasFormFiltro');
    form.reset(); // Reinicia los valores del formulario

    // Ocultar los campos dinámicos
    document.getElementById('campo-nombres').style.display = 'none';
    document.getElementById('campo-estatus').style.display = 'none';
    document.getElementById('campo-reclutador').style.display = 'none';
}