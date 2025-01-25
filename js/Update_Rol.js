// Función para alternar la visibilidad del contenedor para agregar un nuevo tipo de usuario
function CambiarTipoRol() {
    // Obtener el contenedor del tipo de usuario
    var tipoUsuarioContainer = document.getElementById('tipoUsuarioContainer');
    
    // Alternar la visibilidad del contenedor (mostrar/ocultar)
    tipoUsuarioContainer.style.display = (tipoUsuarioContainer.style.display === 'none' || tipoUsuarioContainer.style.display === '') ? 'block' : 'none';
}

// Función para verificar el tipo de usuario y configurar la visibilidad del botón de cambio de rol
function verificarYConfigurarBoton() {
    // Obtener el ID del tipo de usuario y convertirlo a entero
    var idTipo = parseInt(document.getElementById('idTipo').value);
    
    // Log del valor del ID tipo
    console.log('Valor de idTipo:', idTipo);

    // Verificar si el ID tipo no es 3 ni 4
    if (idTipo !== 3 && idTipo !== 4) {
        // Ocultar y deshabilitar el botón
        document.getElementById('btn_CambiarRol').style.display = 'none';
        document.getElementById('btn_CambiarRol').disabled = true;
        console.log('Botón oculto');
    } else {
        // Mostrar y habilitar el botón
        document.getElementById('btn_CambiarRol').style.display = 'block';
        document.getElementById('btn_CambiarRol').disabled = false;
        console.log('Botón visible');
    }
}

// Evento que se dispara cuando se carga el contenido del documento
document.addEventListener('DOMContentLoaded', function() {
    // Llamar a la función para verificar y configurar el botón al cargar la página
    verificarYConfigurarBoton();
    
    // Obtener el ID del empleado y convertirlo a entero
    var idEmpleado = parseInt(document.getElementById('id').value); // Convertir a entero
    
    // Hacer una solicitud AJAX para verificar las requisiciones del empleado
    fetch(`../../../Controlador/GET/ObtenerRequisicionesPendientes.php?id=${idEmpleado}`)
        .then(response => {
            // Verificar si la respuesta es correcta
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`); // Lanzar error si hay un problema
            }
            return response.json(); // Convertir la respuesta a JSON
        })
        .then(data => {
            // Verificar si hay requisiciones pendientes
            if (data.totalRequisiciones > 0) {
                // Crear un elemento de notificación si hay requisiciones pendientes
                const notificationDiv = document.createElement('div');
                notificationDiv.classList.add('alert', 'alert-warning');
                notificationDiv.innerText = `Lo siento, Al parecer tienes ${data.totalRequisiciones} documentos o requisiciones pendientes o autorizadas, debes finalizarlas para poder cambiar de ROL.`;
                document.getElementById('notificationContainer').appendChild(notificationDiv);
                document.getElementById('btn_CambiarRol').style.display = 'none';
                document.getElementById('btn_CambiarRol').disabled = true;
            } else {
                // Si no hay requisiciones, configurar el botón
                verificarYConfigurarBoton();
            }
        })
        .catch(error => {
            // Manejar errores durante la solicitud
            console.error('Error al realizar la solicitud:', error);
            const errorDiv = document.createElement('div');
            errorDiv.classList.add('alert', 'alert-danger');
            errorDiv.innerText = `Error al obtener requisiciones: ${error.message}`;
            document.getElementById('notificationContainer').appendChild(errorDiv); // Añadir mensaje de error al contenedor
        });
    
    // Selectores comunes
    const tipoSelect = document.getElementById('ID_Tipo'); // Selector para el tipo de usuario
    const cuentaSelectUpdate = document.getElementById('ID_Cuenta_Update'); // Selector para cuentas en actualización
    const cuentaSelect = document.getElementById('ID_Cuenta'); // Selector para cuentas en adición
    
    // Botones para añadir cuentas
    const addCuentaUpdateButton = document.getElementById('addCuentaUpdateButton'); // Botón para añadir cuentas a la tabla de actualización
    const addCuentaButton = document.getElementById('addCuentaButton'); // Botón para añadir cuentas a la tabla principal
    
    // Tablas donde se mostrarán las cuentas seleccionadas
    const cuentaUpdateTable = document.getElementById('cuentaUpdateTable') 
        ? document.getElementById('cuentaUpdateTable').querySelector('tbody') 
        : null; // Tabla de cuentas en actualización, puede ser null si no existe
        
    const cuentasTable = document.getElementById('cuentaTable').querySelector('tbody'); // Tabla de cuentas principales
    
    // Inputs ocultos para almacenar los datos en formato JSON
    const datosTablaCuentaUpdate = document.getElementById('DatosTablaCuentaUpdate'); // Input oculto para datos de cuentas en actualización
    const datosTablaCuenta = document.getElementById('DatosTablaCuenta'); // Input oculto para datos de cuentas principales
    
    // Contenedor de cuentas para mostrar u ocultar según el tipo de usuario
    const cuentaContainer = document.getElementById('cuenta-container'); // Contenedor que muestra u oculta el selector de cuentas
    
    // Arrays para almacenar las cuentas seleccionadas
    let cuentasSeleccionadasUpdate = []; // Lista de cuentas seleccionadas en la tabla de actualización
    let cuentasSeleccionadas = []; // Lista de cuentas seleccionadas en la tabla principal
    
    // Lista de IDs de tipos de usuarios que no requieren la selección de una cuenta
    const noCuentaRequired = [1, 2, 5]; // Ajusta estos valores según sea necesario


    // Función para actualizar los datos en formato JSON en los inputs ocultos
    function actualizarDatosTablaCuenta() {
        // Convertir la lista de cuentas seleccionadas a formato JSON y asignarlo al valor del input oculto
        datosTablaCuenta.value = JSON.stringify(cuentasSeleccionadas);
    }
    
    // Función para actualizar los datos en formato JSON en los inputs ocultos para actualización
    function actualizarDatosTablaCuentaUpdate() {
        // Convertir la lista de cuentas seleccionadas en actualización a formato JSON y asignarlo al valor del input oculto
        datosTablaCuentaUpdate.value = JSON.stringify(cuentasSeleccionadasUpdate);
    }

    // Manejar eliminación de filas para cuentas actualizadas
    function manejarEliminacionFila(fila, cuentaId) {
        // Eliminar la fila de la tabla
        fila.remove();
            
        // Remover la cuenta de la lista de cuentas seleccionadas para actualización
        cuentasSeleccionadasUpdate = cuentasSeleccionadasUpdate.filter(cuenta => cuenta.cuentaId !== cuentaId);
            
        // Actualizar el input oculto con los datos actualizados
        actualizarDatosTablaCuentaUpdate();
    }

    // Inicializar cuentas preexistentes en la tabla de actualización
    if (cuentaUpdateTable) {
        document.querySelectorAll('#cuentaUpdateTable tbody tr').forEach(row => {
            // Obtener el ID de la cuenta desde la primera celda de la fila
            const cuentaId = row.querySelector('td:nth-child(1)').textContent;

            // Obtener el nombre de la cuenta desde la segunda celda de la fila
            const cuentaNombre = row.querySelector('td:nth-child(2)').textContent;

            // Añadir la cuenta a la lista de cuentas seleccionadas para actualización
            cuentasSeleccionadasUpdate.push({ cuentaId, cuentaNombre });

            // Añadir el evento para eliminar la cuenta al botón de eliminar en la fila
            row.querySelector('.removeCuentaUpdate').addEventListener('click', function () {
                // Manejar la eliminación de la fila y actualizar la lista de cuentas
                manejarEliminacionFila(row, cuentaId);
            });
        });

        // Actualizar el input oculto con los datos iniciales de las cuentas en actualización
        actualizarDatosTablaCuentaUpdate();
    }

    // Evento cuando se cambia el tipo de usuario en el select "tipoSelect"
    tipoSelect.addEventListener('change', async () => {
        // Convertir el valor seleccionado en un número
        const tipo = parseInt(tipoSelect.value);
            
        // Verificar si el tipo de usuario seleccionado no requiere cuenta
        if (noCuentaRequired.includes(tipo)) {
            // Ocultar el contenedor de cuentas si el tipo de usuario no requiere una
            cuentaContainer.style.display = 'none';
                
            // El campo de selección de cuenta ya no es obligatorio
            cuentaSelect.required = false;
        } else {
            // Mostrar el contenedor de cuentas si se requiere una cuenta
            cuentaContainer.style.display = 'block';
                
            // Hacer que el campo de cuenta sea obligatorio
            cuentaSelect.required = true;
        
            // Intentar realizar una solicitud para obtener las cuentas
            try {
                // Obtener el ID de la tipo de usuario seleccionado
                if (tipo === 3 || tipo ===4) { 
                    // Si el tipo de usuario es 3 o 4, obtener el ID de la cuenta seleccionada
                    let direccion =  '../../../Controlador/GET/getSelectCuenta.php';
                    
                    // Realizar una solicitud fetch para obtener las cuentas
                    const response = await fetch(direccion);
                        
                    // Verificar si la respuesta es válida
                    if (!response.ok) {
                        // Si no es válida, lanzar un error con el estado HTTP
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                        
                    // Obtener la respuesta como texto
                    const text = await response.text();
                        
                    // Intentar convertir el texto de la respuesta a JSON
                    try {
                        // Parsear el texto a JSON
                        const data = JSON.parse(text);
                        // Reiniciar las opciones del select de cuentas con una opción por defecto
                        cuentaSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Cuenta --</option>';
                            
                        // Iterar sobre los datos de cuentas y añadir cada cuenta como una opción al select
                        data.forEach(cuenta => {
                            cuentaSelect.innerHTML += `<option value="${cuenta.ID}">${cuenta.NombreCuenta}</option>`;
                        });
                    } catch (e) {
                        // Si hay un error al parsear el JSON, mostrar el error en la consola
                        console.error('Error al parsear JSON:', e);
                            
                        // Mostrar también el texto original del servidor para más contexto
                        console.error('Respuesta del servidor:', text);
                    }
                }
            } catch (error) {
                // Si hay un error en la solicitud fetch, mostrarlo en la consola
                console.error('Error en la petición:', error);
            }
        }
    });

    // Añadir cuentas a la tabla de actualización cuando se hace clic en "addCuentaUpdateButton"
    if (cuentaUpdateTable) {
        addCuentaUpdateButton.addEventListener('click', function () {
            // Obtener la cuenta seleccionada del selector de cuentas de actualización
            const selectedCuenta = cuentaSelectUpdate.options[cuentaSelectUpdate.selectedIndex];
            
            // Verificar que se haya seleccionado una opción válida
            if (selectedCuenta && selectedCuenta.value !== "") {
                // Obtener el ID de la cuenta seleccionada
                const cuentaId = selectedCuenta.value;
                // Obtener el nombre de la cuenta seleccionada
                const cuentaNombre = selectedCuenta.text;
                
                // Verificar si la cuenta ya está en la lista de cuentas seleccionadas para actualizar
                const cuentaExiste = cuentasSeleccionadasUpdate.some(cuenta => cuenta.cuentaId === cuentaId);
                
                // Si la cuenta no existe en la lista de seleccionadas, añadirla
                if (!cuentaExiste) {
                    // Crear una nueva fila en la tabla de actualización
                    const newRow = cuentaUpdateTable.insertRow();
                    
                    // Insertar la nueva fila con el ID, nombre de la cuenta y el botón de eliminar
                    newRow.innerHTML = `
                        <td>${cuentaId}</td>
                        <td>${cuentaNombre}</td>
                        <td><button type="button" class="btn btn-danger btn-sm removeCuentaUpdate">Eliminar</button></td>
                    `;
                    
                    // Añadir la cuenta a la lista de cuentas seleccionadas para la actualización
                    cuentasSeleccionadasUpdate.push({ cuentaId, cuentaNombre });
                    
                    // Actualizar el input oculto con los datos actualizados en formato JSON
                    actualizarDatosTablaCuentaUpdate();
            
                    // Añadir el evento de eliminar a la nueva fila para poder eliminarla posteriormente
                    newRow.querySelector('.removeCuentaUpdate').addEventListener('click', function () {
                        // Manejar la eliminación de la fila y actualizar la lista de cuentas
                        manejarEliminacionFila(newRow, cuentaId);
                    });
                } else {
                    // Si la cuenta ya existe en la lista, mostrar un mensaje en la consola
                    console.log('La cuenta ya está en la lista de seleccionadas.');
                }
            } else {
                // Si no se selecciona una cuenta válida, mostrar un mensaje en la consola
                console.log('Por favor, selecciona una cuenta válida.');
            }
        });
    }
    
    // Añadir cuentas a la tabla principal cuando se hace clic en "addCuentaButton"
    addCuentaButton.addEventListener('click', function () {
        // Obtener la cuenta seleccionada del selector de cuentas principales
        const selectedCuenta = cuentaSelect.options[cuentaSelect.selectedIndex];
        
        // Verificar que se haya seleccionado una opción válida
        if (selectedCuenta && selectedCuenta.value !== "") {
            // Obtener el ID de la cuenta seleccionada
            const cuentaId = selectedCuenta.value;
            // Obtener el nombre de la cuenta seleccionada
            const cuentaNombre = selectedCuenta.text;
            
            // Verificar si la cuenta ya está en la lista de cuentas seleccionadas
            const cuentaExiste = cuentasSeleccionadas.some(cuenta => cuenta.cuentaId === cuentaId);
            
            // Si la cuenta no existe en la lista, añadirla
            if (!cuentaExiste) {
                // Crear una nueva fila en la tabla principal
                const newRow = cuentasTable.insertRow();
                
                // Insertar la nueva fila con el ID, nombre de la cuenta y el botón de eliminar
                newRow.innerHTML = `
                    <td>${cuentaId}</td>
                    <td>${cuentaNombre}</td>
                    <td><button type="button" class="btn btn-danger btn-sm removeCuenta">Eliminar</button></td>
                `;
                
                // Añadir la cuenta a la lista de cuentas seleccionadas
                cuentasSeleccionadas.push({ cuentaId, cuentaNombre });
                
                // Actualizar el input oculto con los datos actualizados en formato JSON
                actualizarDatosTablaCuenta();
        
                // Añadir el evento de eliminar a la nueva fila para poder eliminarla posteriormente
                newRow.querySelector('.removeCuenta').addEventListener('click', function () {
                    // Eliminar la fila de la tabla principal
                    newRow.remove();
                    // Remover la cuenta de la lista de cuentas seleccionadas
                    cuentasSeleccionadas = cuentasSeleccionadas.filter(cuenta => cuenta.cuentaId !== cuentaId);
                    // Actualizar el input oculto con los datos actualizados en formato JSON
                    actualizarDatosTablaCuenta();
                });
            } else {
                // Si la cuenta ya está en la lista, mostrar un mensaje en la consola
                console.log('La cuenta ya está en la lista de seleccionadas.');
            }
        } else {
            // Si no se selecciona una cuenta válida, mostrar un mensaje en la consola
            console.log('Por favor, selecciona una cuenta válida.');
        }
    });
});