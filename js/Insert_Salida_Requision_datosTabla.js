// Función para mostrar una imagen ampliada en un modal.
function mostrarImagen(src) {
    // Obtiene el elemento del modal por su ID.
    var modal = document.getElementById("infoModal");
    
    // Obtiene el cuerpo del modal donde se insertará la imagen.
    var modalBody = document.getElementById("imagenAmpliada");
    
    // Inserta la imagen en el cuerpo del modal con formato centrado y responsivo.
    modalBody.innerHTML = '<center><img src="' + src + '" class="img-fluid">';
    
    // Muestra el modal utilizando jQuery.
    $(modal).modal('show'); 

    // Añade un evento para cerrar el modal cuando se hace clic en el botón de cerrar.
    document.getElementById("cerrarModalBtn").addEventListener("click", function() {
        // Oculta el modal utilizando jQuery.
        $(modal).modal('hide'); 
    });
}

function guardarDatosTabla() {
    // Seleccionamos la tabla
    const tabla = document.querySelector('.table-responsive .table tbody');

    // Inicializamos un arreglo para almacenar los datos
    const datos = [];

    // Recorremos las filas de la tabla
    tabla.querySelectorAll('tr').forEach((fila) => {
        // Obtenemos el ID del producto (primer columna)
        const IdCProd = fila.children[0]?.textContent.trim();
        
        // Obtenemos el valor de Cant (input de cantidad a entregar)
        const CantInput = fila.querySelector('input[name="Cant[]"]');
        const Cant = CantInput ? CantInput.value.trim() : '';

        // Obtenemos el valor de Id_Talla (input hidden)
        const IdTallaInput = fila.querySelector('input[name="Id_Talla[]"]');
        const Id_Talla = IdTallaInput ? IdTallaInput.value.trim() : '';

        // Validamos que los datos sean válidos
        if (IdCProd && Cant && Id_Talla) {
            datos.push({
                IdCProd: IdCProd,
                Cant: Cant,
                Id_Talla: Id_Talla
            });
        }
    });

    // Convertimos los datos a formato JSON
    const datosJSON = JSON.stringify(datos);

    // Verificamos si el arreglo está vacío antes de guardar
    if (datos.length === 0) {
        Swal.fire({
            icon: "error",
            title: "Lo siento",
            text: "No hay datos válidos en la tabla para guardar."
        });
        return false; // No continuar
    }

    // Guardamos el JSON en el input oculto
    document.getElementById('datosTablaInsertSalida').value = datosJSON;

    console.log('Datos guardados:', datosJSON); // Debug: Mostrar los datos en la consola
    return true; // Indica que los datos se han guardado correctamente
}

// Función para verificar y bloquear inputs si Faltante o Disponible son menores o iguales a 0
function bloquearInputs() {
    // Selecciona todos los inputs con el nombre "Cant[]"
    var inputsCantidadEntregar = document.querySelectorAll('input[name="Cant[]"]'); 
    // Selecciona todas las celdas de la columna 6 (Faltante)
    var faltantes = document.querySelectorAll('td:nth-child(6)'); 
    // Selecciona todas las celdas de la columna 7 (Disponible)
    var disponibles = document.querySelectorAll('td:nth-child(7)'); 
    // Selecciona el botón de guardar por su id
    var botonGuardar = document.getElementById('botonGuardar'); 

    // Inicializa una bandera para verificar si todos los faltantes son cero
    var todosFaltantesCero = true;
    // Inicializa una bandera para verificar si todos los disponibles son cero
    var todosDisponiblesCero = true; 

    // Itera a través de todas las celdas de faltantes
    for (var i = 0; i < faltantes.length; i++) { 
        // Si el valor de faltante es mayor que 0
        if (parseInt(faltantes[i].textContent) > 0) { 
            // Establece la bandera de faltantes a falso
            todosFaltantesCero = false; 
        }
        // Si el valor de disponible es mayor que 0
        if (parseInt(disponibles[i].textContent) > 0) { 
            // Establece la bandera de disponibles a falso
            todosDisponiblesCero = false; 
        }
    }

    // Si todos los faltantes o todos los disponibles son cero
    if (todosFaltantesCero || todosDisponiblesCero) { 
        // Deshabilita el botón de guardar
        botonGuardar.disabled = true; 
    } else {
        // Habilita el botón de guardar
        botonGuardar.disabled = false; 
    }
    
    // Itera a través de todos los inputs de cantidad a entregar
    for (var i = 0; i < inputsCantidadEntregar.length; i++) { 
        // Si el faltante o el disponible es menor o igual a 0
        if (parseInt(faltantes[i].textContent) <= 0 || parseInt(disponibles[i].textContent) <= 0) { 
            // Deshabilita el input correspondiente
            inputsCantidadEntregar[i].disabled = true; 
        } else {
            // Habilita el input correspondiente
            inputsCantidadEntregar[i].disabled = false; 
        }
    }
}

// Función para validar que la cantidad a entregar no sea mayor a la cantidad solicitada
function validarCantidad() {
    // Selecciona todos los inputs con el nombre "Cant[]"
    var inputsCantidadEntregar = document.querySelectorAll('input[name="Cant[]"]'); 
    // Selecciona todas las celdas de la columna 6 (Solicitado)
    var solicitados = document.querySelectorAll('td:nth-child(6)'); 

    // Itera a través de todos los inputs de cantidad a entregar
    for (var i = 0; i < inputsCantidadEntregar.length; i++) { 
        // Obtiene el valor del input y lo convierte a entero
        var cantidadEntregar = parseInt(inputsCantidadEntregar[i].value); 
        // Obtiene el valor de la celda de solicitado y lo convierte a entero
        var solicitado = parseInt(solicitados[i].textContent); 
        
        // Si la cantidad a entregar es mayor que la solicitada
        if (cantidadEntregar > solicitado) { 
            // Muestra una alerta
            alert("No puedes entregar una cantidad mayor a la solicitada."); 
            // Limpia el valor del input
            inputsCantidadEntregar[i].value = ""; 
            // Devuelve falso para detener la validación
            return false; 
        }
    }
    return true; // Devuelve verdadero si todas las cantidades son válidas
}

// Llamar a las funciones cuando se cargue la página
window.onload = function() {
    // Llama a la función bloquearInputs
    bloquearInputs(); 

    // Selecciona todos los inputs con el nombre "Cant[]"
    var inputsCantidadEntregar = document.querySelectorAll('input[name="Cant[]"]'); 
    // Itera a través de todos los inputs de cantidad a entregar
    for (var i = 0; i < inputsCantidadEntregar.length; i++) { 
        // Añade un evento 'change' a cada input para validar la cantidad al cambiar
        inputsCantidadEntregar[i].addEventListener('change', validarCantidad); 
    }
};
