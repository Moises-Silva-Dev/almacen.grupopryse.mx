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

                // Limpia el select de tallas
                $('#ID_Talla').empty();
                
                // Itera sobre cada talla en la respuesta y agrega una opción al select de tallas
                $.each(response.tallas, function(index, talla) {
                    $('#ID_Talla').append('<option value="' + talla.id + '" data-nombre="' + talla.nombre + '">' + talla.nombre + '</option>');
                });
            }
        });
    });

    // Manejar el clic en el botón para mostrar la imagen (incluso para las filas nuevas)
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

        // Evento de clic para el botón de cierre del modal de imagen
        $('#modalImagen .close').on('click', function() {
            // Oculta el modal de imagen
            $('#modalImagen').modal('hide');
        });
    });

    // Obtiene el botón "Agregar" del DOM
    const btnAgregar = document.getElementById("btn_Agregar");
    // Obtiene la tabla de productos del DOM
    const tablaProductos = document.querySelector(".table-responsive table tbody");
    // Obtiene el campo de datos de la tabla del DOM
    const datosTablaInput = document.getElementById("datosTabla");

    // Función para actualizar los datos de la tabla oculta
    function actualizarDatosTabla() {
        // Obtiene todas las filas de la tabla de productos
        const filas = tablaProductos.querySelectorAll("tr");
        // Inicializa un array para almacenar los datos de las filas
        const datos = [];

        // Itera sobre cada fila de la tabla de productos
        filas.forEach(function(fila) {
            // Obtiene los datos de la columna correspondiente en la fila
            const idProduct = fila.querySelector("td:nth-child(1)").textContent;
            const idtall = fila.querySelector("td:nth-child(6)").dataset.id;
            const cant = fila.querySelector("td:nth-child(7)").textContent;

            // Agrega los datos de la fila al array de datos
            datos.push({ idProduct: idProduct, idtall: idtall, cant: cant });
        });

        // Convierte el array de datos a formato JSON y lo asigna al campo de datos de la tabla
        datosTablaInput.value = JSON.stringify(datos);
    }
    
    //Funcion que se activa cuando das clic en Agregar producto
    btnAgregar.addEventListener("click", function() {
        // Obtiene los valores de los campos del formulario
        const idProduct = document.getElementById("ID_Producto").value;
        const empre = document.getElementById("Empresa").value;
        const categor = document.getElementById("Categoria").value;
        const descripc = document.getElementById("Descripcion").value;
        const especificac = document.getElementById("Especificacion").value;
        const tallaSelect = document.getElementById("ID_Talla");
        const idtall = tallaSelect.value;
        const tallaNombre = tallaSelect.options[tallaSelect.selectedIndex].getAttribute('data-nombre');
        const cant = parseInt(document.getElementById("Cantidad").value, 10);

        // Verifica que todos los campos estén completos y que la cantidad sea un número válido
        if (idProduct === "" || empre === "" || categor === "" || descripc === "" || especificac === "" || idtall === "" || isNaN(cant) || cant <= 0
        ) {
            // Si falta algún campo o la cantidad no es válida, muestra una alerta y sale de la función
            alert("Por favor, complete todos los campos correctamente antes de agregar el producto.");
            return;
        }
        
        //declaramos en NULL
        let filaExistente = null;

        // Busca si ya existe una fila con el mismo producto y talla en la tabla
        tablaProductos.querySelectorAll("tr").forEach(function(fila) {
            // Obtiene los valores de la fila
            const filaIdProduct = fila.querySelector("td:nth-child(1)").textContent;
            const filaIdTalla = fila.querySelector("td:nth-child(6)").dataset.id;

            // Verifica si el ID del producto y el ID de la talla coinciden con los valores actuales
            if (filaIdProduct === idProduct && filaIdTalla === idtall) {
                // Si coincide, asigna la fila existente a la variable filaExistente
                filaExistente = fila;
            }
        });
        
        // Si la fila ya existe, actualiza la cantidad; de lo contrario, crea una nueva fila con los datos del producto
        if (filaExistente) {
            // Obtiene la cantidad actual de la fila
            const cantidadActual = parseInt(filaExistente.querySelector("td:nth-child(7)").textContent, 10);
            // Calcula la nueva cantidad sumando la cantidad actual y la cantidad nueva
            const nuevaCantidad = cantidadActual + cant;
            // Actualiza la cantidad en la fila existente
            filaExistente.querySelector("td:nth-child(7)").textContent = nuevaCantidad;
        } else {
            // Si la fila no existe, crea una nueva fila con los datos del producto
            const nuevaFila = `
                <tr>
                    <td>${idProduct}</td>
                    <td>${empre}</td>
                    <td>${categor}</td>
                    <td>${descripc}</td>
                    <td>${especificac}</td>
                    <td data-id="${idtall}">${tallaNombre}</td>
                    <td>${cant}</td>
                    <td>
                        <button type="button" class="btn btn-warning btn-anular">
                            Eliminar
                        </button> 
                    </td>
                </tr>
            `;
            
            // Agrega la nueva fila al final de la tabla
            tablaProductos.insertAdjacentHTML("beforeend", nuevaFila);
        }

        // Limpiar los campos de entrada después de agregar el producto
        document.getElementById("ID_Producto").value = "";
        document.getElementById("Empresa").value = "";
        document.getElementById("Categoria").value = "";
        document.getElementById("Descripcion").value = "";
        document.getElementById("Especificacion").value = "";
        document.getElementById("ID_Talla").value = "";
        document.getElementById("Cantidad").value = "";
        
        // Actualiza los datos de la tabla después de realizar cambios
        actualizarDatosTabla();
    });

    //Funcion para eliminar información del Arreglo
    tablaProductos.addEventListener("click", function(event) {
        // Verifica si el elemento clicado tiene la clase "btn-anular"
        if (event.target.classList.contains("btn-anular")) {
            // Si el clic fue en un botón "Eliminar", obtiene la fila correspondiente
            const fila = event.target.closest("tr");
            // Remueve la fila de la tabla
            fila.remove();
            // Después de eliminar la fila, actualiza los datos de la tabla para reflejar los cambios en el campo oculto datosTablaInput
            actualizarDatosTabla();
        }
    });

    // Agrega un evento de escucha para el evento "submit" del formulario con ID "formGuardar"
    document.getElementById("formGuardar").addEventListener("submit", function(event) {
        // Llama a la función actualizarDatosTabla antes de que el formulario sea enviado
        actualizarDatosTabla();
    });
});