// Función que se ejecuta cuando el documento está listo
$(document).ready(function() {
    // Evento de cambio para el campo con ID 'ID_Producto'
    $('#ID_Producto').change(function() {
        // Obtiene el valor seleccionado en el campo 'ID_Producto'
        var producto_id = $(this).val();

        // Realiza una petición AJAX para obtener la información del producto
        $.ajax({
            // URL del controlador para obtener la información del producto
            url: '../../../Controlador/GET/getProductInfo.php',
            // Método de la petición
            method: 'POST',
            // Datos enviados al servidor (el ID del producto)
            data: { ID_Producto: producto_id },
            // Tipo de datos esperados en la respuesta (JSON)
            dataType: 'json',
            // Función que se ejecuta si la petición es exitosa
            success: function(response) {
                // Establece los valores de los campos con la información del producto obtenida de la respuesta
                $('#Empresa').val(response.empresa);
                $('#Categoria').val(response.categoria);
                $('#Descripcion').val(response.descripcion);
                $('#Especificacion').val(response.especificacion);

                // Vacía el select de tallas y agrega una opción por defecto
                $('#ID_Talla').empty();

                // Itera sobre cada talla en la respuesta y agrega una opción al select de tallas
                $.each(response.tallas, function(index, talla) {
                    $('#ID_Talla').append('<option value="' + talla.id + '" data-nombre="' + talla.nombre + '">' + talla.nombre + '</option>');
                });
            }
        });
    });

    // Evento de clic para el botón con ID 'btnMostrarImagen' usando delegación de eventos
    $(document).on('click', '#btnMostrarImagen', function() {
        // Encuentra el elemento padre más cercano con clase 'fila-fija'
        var fila = $(this).closest('.fila-fija');
        // Obtiene el identificador común
        var id_comun = fila.data('id'); 
        // Encuentra la fila relacionada con el mismo data-id
        var fila2 = $('.fila-fija2[data-id="' + id_comun + '"]');
        // Obtiene el valor del campo de ID_Producto dentro de la fila
        var producto_id = fila.find('#ID_Producto').val();
        // Obtiene el valor del campo de Descripcion dentro de la fila
        var descripcion = fila2.find('#Descripcion').val();
        // Obtiene el valor del campo de Especificacion dentro de la fila
        var especificacion = fila2.find('#Especificacion').val();

        // Realiza una petición AJAX para obtener la imagen del producto
        $.ajax({
            // URL del controlador para obtener la imagen del producto
            url: '../../../Controlador/GET/getProductImage.php',
            // Método de la petición
            method: 'POST',
            // Datos enviados al servidor (el ID del producto)
            data: { ID_Producto: producto_id },
            // Tipo de datos esperados en la respuesta (JSON)
            dataType: 'json',
            // Función que se ejecuta si la petición es exitosa
            success: function(response) {
                // Establece la URL de la imagen obtenida en el elemento con ID 'imagenProducto'
                $('#imagenProducto').attr('src', response.url);
                $('#descripcionProducto').text(descripcion);
                $('#especificacionProducto').text(especificacion);
                $('#modalImagen').modal('show');
            }
        });
    });
    
    // Evento de clic para el botón de cierre del modal de imagen
    $('#modalImagen .close').on('click', function() {
        // Oculta el modal de imagen
        $('#modalImagen').modal('hide');
    });
});