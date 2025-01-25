// Obtiene el botón "Agregar" del DOM
const btnAgregar = document.getElementById("btn_AgregarProductoEntrada");
// Obtiene la tabla de productos del DOM
const tablaProductos = document.querySelector(".table-responsive table tbody");
// Obtiene el campo de datos de la tabla del DOM
const datosTablaInput = document.getElementById("datosTablaUpdateEntrada");

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
        if (idProduct === "" || empre === "" || categor === "" || 
            descripc === "" || especificac === "" || idtall === "" || 
            isNaN(cant) || cant <= 0
        ) {
            // Si falta algún campo o la cantidad no es válida, muestra una alerta y sale de la función
            Swal.fire({
                icon: "error", // Icono de error
                title: "Falto un Campo", // Título del mensaje
                text: "Por favor, complete todos los campos correctamente antes de agregar el producto."
            });
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