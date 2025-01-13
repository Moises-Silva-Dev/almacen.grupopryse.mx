// Espera a que el DOM est�� completamente cargado antes de ejecutar el c��digo.
$(document).ready(function() {
    // A�0�9ade un listener al bot��n con la clase 'btnVisualizarImagen' que ejecuta una funci��n al hacer clic.
    $('.btnVisualizarImagen').click(function() {
        // Obtiene los valores de los atributos `data-*` del bot��n que se clicke��.
        var empresa = $(this).data('empresa'); // Recupera el nombre de la empresa.
        var descripcion = $(this).data('descripcion'); // Recupera la descripci��n del producto.
        var especificacion = $(this).data('especificacion'); // Recupera la especificaci��n del producto.
        var categoria = $(this).data('categoria'); // Recupera la categor��a del producto.
        var talla = $(this).data('talla'); // Recupera la talla del producto.
        var cantidad = $(this).data('cantidad'); // Recupera la cantidad solicitada.
        var salida = $(this).data('salida'); // Recupera la cantidad entregada.
        var img = $(this).data('img'); // Recupera la URL de la imagen.

        // Construye el contenido HTML que se mostrar�� en el modal.
        var modalBody = '<ul>';
        modalBody += '<li><strong>Empresa:</strong> ' + empresa + '</li>'; // Muestra la empresa.
        modalBody += '<li><strong>Descripción:</strong> ' + descripcion + '</li>'; // Muestra la descripci��n.
        modalBody += '<li><strong>Especificación:</strong> ' + especificacion + '</li>'; // Muestra la especificaci��n.
        modalBody += '<li><strong>Categoría:</strong> ' + categoria + '</li>'; // Muestra la categor��a.
        modalBody += '<li><strong>Talla:</strong> ' + talla + '</li>'; // Muestra la talla.
        modalBody += '<li><strong>Cantidad Solicitada:</strong> ' + cantidad + '</li>'; // Muestra la cantidad solicitada.
        modalBody += '<li><strong>Cantidad Entregada:</strong> ' + salida + '</li>'; // Muestra la cantidad entregada.
        modalBody += '<center><img src="' + img + '" alt="Imagen" width="250" height="300"></center>'; // Muestra la imagen con un tama�0�9o fijo.
        modalBody += '</ul>';

        // Inserta el contenido HTML generado en el cuerpo del modal (dentro del elemento con la clase 'modal-body').
        $('#infoModal .modal-body').html(modalBody);
    });
});