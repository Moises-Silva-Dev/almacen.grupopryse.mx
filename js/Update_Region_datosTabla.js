// Obtiene el botón "Agregar" del DOM
const btnAgregar = document.getElementById("btn_ModificarRegionConEstado");
// Obtiene la tabla de estados del DOM
const tablaEstados = document.querySelector(".table-responsive table tbody");
// Obtiene el campo de datos de la tabla del DOM
const datosTablaInput = document.getElementById("datosTablaUpdateRegion");

// Función para actualizar los datos de la tabla
function actualizarDatosTabla() {
    // Obtiene todas las filas de la tabla de estados
    const filas = tablaEstados.querySelectorAll("tr");
    // Inicializa un array para almacenar los datos de las filas
    const datos = [];

    // Itera sobre cada fila de la tabla de estados
    filas.forEach(function(fila) {
        // Obtiene el ID del estado (almacenado en un atributo data-id)
        const idEstado = fila.querySelector("td:nth-child(1)").getAttribute('data-id');

        // Agrega el ID del estado al array de datos
        datos.push({ idEstado: idEstado });
    });

    // Convierte el array de datos a formato JSON y lo asigna al campo de datos de la tabla
    datosTablaInput.value = JSON.stringify(datos);
}

// Función que se activa cuando das clic en "Agregar"
btnAgregar.addEventListener("click", function() {
    // Obtiene los valores de los campos del formulario
    const estadoSelect = document.getElementById("Nombre_Estado");
    const idEstado = estadoSelect.value;
    const nombreEstado = estadoSelect.options[estadoSelect.selectedIndex].textContent;

    // Verifica que el estado esté seleccionado
    if (idEstado === "") {
        // Usamos SweetAlert para mostrar un mensaje de advertencia
        Swal.fire({
            icon: "warning", // Icono de advertencia
            title: "Estado no seleccionado", // Título del mensaje
            text: "Por favor, seleccione un estado antes de agregar.",
        });
        return; // Salimos de la función
    }

    // Busca si ya existe una fila con el mismo estado en la tabla
    let filaExistente = null;
    tablaEstados.querySelectorAll("tr").forEach(function(fila) {
        // Obtiene el ID del estado de la fila
        const filaIdEstado = fila.querySelector("td:nth-child(1)").getAttribute('data-id');

        // Verifica si el ID del estado coincide con el valor actual
        if (filaIdEstado === idEstado) {
            filaExistente = fila; // Si coincide, asigna la fila existente a la variable filaExistente
        }
    });

    // Si la fila no existe, crea una nueva fila con los datos del estado
    if (!filaExistente) {
        // Si la fila no existe, crea una nueva fila con los datos del estado
        const nuevaFila = `
            <tr>
                <td data-id="${idEstado}">${nombreEstado}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-anular">
                        Eliminar
                    </button>
                </td>
            </tr>
        `;
        
        // Agrega la nueva fila al final de la tabla
        tablaEstados.insertAdjacentHTML("beforeend", nuevaFila);
    }

    // Limpia la selección del estado después de agregarlo
    estadoSelect.value = "";

    // Actualiza los datos de la tabla después de realizar cambios
    actualizarDatosTabla();
});

// Función para eliminar información del Arreglo 
tablaEstados.addEventListener("click", function(event) {
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