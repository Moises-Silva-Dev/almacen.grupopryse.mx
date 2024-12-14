// Funcion para mostrar o ocultar
function mostrarOcultarInput() {
    // Obtener el valor seleccionado del elemento con ID 'opcion' usando jQuery
    var seleccion = $("#opcion").val();
    
    // Verificar si la opción seleccionada es "SI"
    if (seleccion === "SI") {
        // Mostrar el campo de imagen usando jQuery
        $("#campoImagen").show();
    } else {
        // Ocultar el campo de imagen si la opción seleccionada no es "SI"
        $("#campoImagen").hide();
    }
}