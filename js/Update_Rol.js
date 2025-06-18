let cuentasSeleccionadas = []; // Array para almacenar las cuentas seleccionadas

// Función para actualizar los datos de la tabla
document.addEventListener('DOMContentLoaded', function () {
    // Inicializar cuentas existentes desde la tabla
    document.querySelectorAll('#tablaCuentas tbody tr').forEach(row => { // Asegúrate de que la tabla tenga el ID "tablaCuentas"
        const cuentaId = row.getAttribute('data-cuenta-id'); // Asegúrate de que cada fila tenga un atributo "data-cuenta-id" con el ID de la cuenta
        const cuentaNombre = row.cells[1].textContent; // Asegúrate de que la columna del nombre de la cuenta esté en la segunda celda (índice 1)
        const tieneReq = cuentasConRequisiciones.includes(parseInt(cuentaId)); // Asegúrate de que la variable "cuentasConRequisiciones" esté definida y contenga los IDs de las cuentas con requisiciones

        cuentasSeleccionadas.push({ id: cuentaId, nombre: cuentaNombre, tieneRequisiciones: tieneReq }); // Agrega la cuenta al array

        row.querySelector('.btnEliminarCuenta').addEventListener('click', function () { // Asegúrate de que el botón tenga la clase "btnEliminarCuenta"
            if (!this.disabled) { // Asegúrate de que el botón no esté deshabilitado
                Swal.fire({
                    title: '¿Eliminar cuenta?', // Título del modal
                    text: `¿Estás seguro de eliminar la cuenta ${cuentaNombre}`, // Texto del modal
                    icon: 'warning', // Icono del modal
                    showCancelButton: true, // Mostrar botón de cancelar
                    confirmButtonText: 'Sí, eliminar', // Texto del botón de confirmar
                    cancelButtonText: 'Cancelar' // Texto del botón de cancelar
                }).then(result => {  
                    if (result.isConfirmed) { // Si se confirma la eliminación
                        row.remove(); // Elimina la fila de la tabla
                        cuentasSeleccionadas = cuentasSeleccionadas.filter(c => c.id !== cuentaId); // Elimina la cuenta del array
                        actualizarDatosTabla(); // Actualiza el campo hidden con los datos de las cuentas
                    }
                });
            }
        });
    });

    // Evento para agregar cuenta
    document.getElementById('btnAgregarCuenta').addEventListener('click', function () { // Asegúrate de que el botón tenga el ID "btnAgregarCuenta"
        const select = document.getElementById('ID_Cuenta'); // Obtiene el select
        const cuentaId = select.value; // Obtiene el valor del select
        const cuentaNombre = select.options[select.selectedIndex].text; // Obtiene el texto del select

        if (!cuentaId) { // Si no se selecciona ninguna cuenta
            Swal.fire('Error', 'Por favor selecciona una cuenta', 'error'); // Mensaje de error
            return; // Salir de la función si no se selecciona una cuenta
        }

        if (cuentasSeleccionadas.some(c => c.id === cuentaId)) { // Si la cuenta ya está seleccionada
            Swal.fire('Advertencia', 'Esta cuenta ya está agregada', 'warning'); // Mensaje de advertencia
            return; // Salir de la función
        }

        const nuevaCuenta = { id: cuentaId, nombre: cuentaNombre, tieneRequisiciones: false }; // Crea un objeto con los datos de la nueva cuenta
        cuentasSeleccionadas.push(nuevaCuenta); // Agrega la nueva cuenta al array
        actualizarTablaCuentas(); // Actualiza la tabla de cuentas
        select.value = ''; // Limpiar el valor del select
    });

    // Evento para mostrar u ocultar sección de cuentas
    document.getElementById('ID_Tipo').addEventListener('change', function () { // Asegúrate de que el elemento tenga el ID "ID_Tipo"
        const nuevoTipo = parseInt(this.value); // Obtiene el valor del tipo seleccionado
        const seccionCuentas = document.getElementById('seccionCuentas'); // Crea un elemento div
        seccionCuentas.style.display = (nuevoTipo === 3 || nuevoTipo === 4) ? 'block' : 'none'; // Muestra la sección de cuentas si es 3 o 4, oculta si no
    });

    // Inicializar visibilidad por si el tipo actual ya es 3 o 4
    if (tipoActual === 3 || tipoActual === 4) { // Asegúrate de que "tipoActual" esté definido y tenga un valor adecuado
        document.getElementById('seccionCuentas').style.display = 'block'; // Muestra la sección de cuentas
    }
});

// Función para actualizar los datos de la tabla de cuentas
function actualizarDatosTabla() {
    document.getElementById('DatosTablaCuenta').value = JSON.stringify( // Convierte el array en un objeto JSON
        cuentasSeleccionadas.map(c => ({ id: c.id, nombre: c.nombre })) // Convierte el array en un objeto JSON
    );
}

// Función para renderizar la tabla de cuentas
function actualizarTablaCuentas() {
    const tbody = document.querySelector('#tablaCuentas tbody'); // Crea un elemento tbody
    tbody.innerHTML = ''; // Limpia la tabla antes de agregar las nuevas filas

    cuentasSeleccionadas.forEach(cuenta => {
        const tr = document.createElement('tr'); // Crea una nueva fila
        tr.setAttribute('data-cuenta-id', cuenta.id); // Agrega el atributo "data-cuenta-id" con el ID de la cuenta
        tr.innerHTML = `
            <td>${cuenta.id}</td>
            <td>${cuenta.nombre}</td>
            <td>${cuenta.tieneRequisiciones ? '<span class="badge bg-warning">Pendientes</span>' : '<span class="badge bg-success">Ninguna</span>'}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm btnEliminarCuenta" 
                    ${cuenta.tieneRequisiciones ? 'disabled title="No se puede eliminar porque tiene requisiciones pendientes"' : ''}>
                    <i class="fas fa-trash">Eliminar</i>
                </button>
            </td>
        `;

        tr.querySelector('.btnEliminarCuenta').addEventListener('click', function () { // Asegúrate de que el botón tenga la clase "btnEliminarCuenta"
            if (!this.disabled) { // Asegúrate de que el botón no esté deshabilitado
                Swal.fire({
                    title: '¿Eliminar cuenta?', // Título del modal
                    text: `¿Estás seguro de eliminar la cuenta ${cuenta.nombre}?`, // Texto del modal
                    icon: 'warning', // Icono del modal
                    showCancelButton: true, // Mostrar botón de cancelar
                    confirmButtonText: 'Sí, eliminar', // Texto del botón de confirmar
                    cancelButtonText: 'Cancelar' // Texto del botón de cancelar
                }).then(result => { 
                    if (result.isConfirmed) { // Si se confirma la eliminación
                        tr.remove(); // Elimina la fila de la tabla
                        cuentasSeleccionadas = cuentasSeleccionadas.filter(c => c.id !== cuenta.id); // Elimina la cuenta del array
                        actualizarDatosTabla(); // Actualiza el campo hidden con los datos de las cuentas
                    }
                });
            }
        });
        tbody.appendChild(tr); // Agrega la fila a la tabla
    });
    actualizarDatosTabla(); // Actualiza el campo hidden con los datos de las cuentas
}