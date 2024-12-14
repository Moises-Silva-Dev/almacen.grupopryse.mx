// Espera a que el DOM esté completamente cargado antes de ejecutar el código.
$(document).ready(function() {
    // Añade un listener al botón con la clase 'btnVisualizarImagen' que ejecuta una función al hacer clic.
    $('.btnVisualizarImagen').click(function() {
        // Obtiene los valores de los atributos `data-*` del botón que se clickeó.
        var empresa = $(this).data('empresa'); // Recupera el nombre de la empresa.
        var descripcion = $(this).data('descripcion'); // Recupera la descripción del producto.
        var especificacion = $(this).data('especificacion'); // Recupera la especificación del producto.
        var categoria = $(this).data('categoria'); // Recupera la categoría del producto.
        var talla = $(this).data('talla'); // Recupera la talla del producto.
        var cantidad = $(this).data('cantidad'); // Recupera la cantidad solicitada.
        var salida = $(this).data('salida'); // Recupera la cantidad entregada.
        var img = $(this).data('img'); // Recupera la URL de la imagen.

        // Construye el contenido HTML que se mostrará en el modal.
        var modalBody = '<ul>';
        modalBody += '<li><strong>Empresa:</strong> ' + empresa + '</li>'; // Muestra la empresa.
        modalBody += '<li><strong>Descripción:</strong> ' + descripcion + '</li>'; // Muestra la descripción.
        modalBody += '<li><strong>Especificación:</strong> ' + especificacion + '</li>'; // Muestra la especificación.
        modalBody += '<li><strong>Categoría:</strong> ' + categoria + '</li>'; // Muestra la categoría.
        modalBody += '<li><strong>Talla:</strong> ' + talla + '</li>'; // Muestra la talla.
        modalBody += '<li><strong>Cantidad Solicitada:</strong> ' + cantidad + '</li>'; // Muestra la cantidad solicitada.
        modalBody += '<li><strong>Cantidad Entregada:</strong> ' + salida + '</li>'; // Muestra la cantidad entregada.
        modalBody += '<center><img src="' + img + '" alt="Imagen" width="250" height="300"></center>'; // Muestra la imagen con un tamaño fijo.
        modalBody += '</ul>';

        // Inserta el contenido HTML generado en el cuerpo del modal (dentro del elemento con la clase 'modal-body').
        $('#infoModal .modal-body').html(modalBody);
    });
});