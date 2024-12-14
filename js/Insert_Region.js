// Obtiene el botón "Agregar" del DOM
const btnAgregar = document.getElementById("btn_Agregar");
// Obtiene la tabla de estados del DOM
const tablaEstados = document.querySelector(".table-responsive table tbody");
// Obtiene el campo de datos de la tabla del DOM
const datosTablaInput = document.getElementById("datosTabla");
// Obtiene el formulario del DOM
const formulario = document.querySelector("form");
// Inicializa el contador de filas en 1
let contadorFilas = 1;

// Función para actualizar los datos de la tabla
function actualizarDatosTabla() {
    // Obtiene todas las filas de la tabla de estados
    const filas = tablaEstados.querySelectorAll("tr");
    // Inicializa un array para almacenar los datos de las filas
    const datos = [];

    // Itera sobre cada fila de la tabla de estados
    filas.forEach(function(fila) {
        // Obtiene el ID del estado (almacenado en un atributo data-id)
        const idEstado = fila.querySelector("td:nth-child(2)").getAttribute('data-id');

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
        // Si falta seleccionar el estado, muestra una alerta y sale de la función
        alert("Por favor, seleccione un estado antes de agregar.");
        return;
    }

    // Declaramos en NULL
    let filaExistente = null;

    // Busca si ya existe una fila con el mismo estado en la tabla
    tablaEstados.querySelectorAll("tr").forEach(function(fila) {
        // Obtiene el ID del estado de la fila
        const filaIdEstado = fila.querySelector("td:nth-child(2)").getAttribute('data-id');

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
                <th scope="row">${contadorFilas}</th>
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
        // Incrementa el contador de filas
        contadorFilas++;
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

// Antes de enviar el formulario, verifica que al menos un estado haya sido agregado
formulario.addEventListener("submit", function(event) {
    // Llama a la función actualizarDatosTabla para asegurarse de que el campo oculto datosTablaInput, contiene los datos más recientes de la tabla de estados
    actualizarDatosTabla();
    // Verifica si el valor de datosTablaInput es un array vacío
    if (datosTablaInput.value === "[]") {
        // Muestra una alerta al usuario indicándole que debe agregar al menos un estado
        alert("Por favor, agregue al menos un estado antes de enviar el formulario.");
        // Evita que el formulario se envíe
        event.preventDefault();
    }
});