document.addEventListener('DOMContentLoaded', function() {
    // Obtener el elemento del selector de tipo de usuario
    const tipoSelect = document.getElementById('ID_Tipo');
    
    // Obtener el elemento del selector de cuenta
    const cuentaSelect = document.getElementById('Seleccionar_ID_Cuenta');
    
    // Obtener el botón para añadir cuentas
    const addCuentaButton = document.getElementById('BtnAddCuenta');
    
    // Obtener el cuerpo de la tabla donde se mostrarán las cuentas seleccionadas
    const cuentasTable = document.getElementById('cuentaTable').querySelector('tbody');
    
    // Obtener el input oculto donde se almacenarán los datos en formato JSON
    const datosTablaCuenta = document.getElementById('DatosTablaInsertCuentaUsuario');
    
    // Contenedor donde se muestran las cuentas seleccionadas
    const cuentaContainer = document.getElementById('cuenta-container');
    
    // Inicializar un array para almacenar las cuentas seleccionadas
    let cuentasSeleccionadas = [];

    // Lista de IDs de tipos de usuarios que no requieren la selección de una cuenta
    const noCuentaRequired = [1, 2, 5, 6]; // Ajusta estos valores según sea necesario

    // Evento cuando el usuario cambia el tipo de usuario en el select
    tipoSelect.addEventListener('change', async () => {
        // Obtener el valor seleccionado y convertirlo a un número
        const tipo = parseInt(tipoSelect.value);
    
        // Si el tipo de usuario no requiere cuenta (basado en los valores de noCuentaRequired)
        if (noCuentaRequired.includes(tipo)) {
            // Ocultar el contenedor de cuentas
            cuentaContainer.style.display = 'none';
            // El campo de cuenta ya no será requerido
            cuentaSelect.required = false;
        } else {
            // Mostrar el contenedor de cuentas
            cuentaContainer.style.display = 'block';
            // Hacer que el campo de cuenta sea obligatorio
            cuentaSelect.required = true;

            try {
                // Obtener el ID de la tipo de usuario seleccionado
                if (tipo === 3 || tipo === 4) { 
                    // Si el tipo de usuario es 3 o 4, obtener el ID de la cuenta seleccionada
                    let direccion =  '../../../Controlador/GET/getSelectCuenta.php';

                    // Realizar la petición al servidor para obtener las cuentas
                    const response = await fetch(direccion);
                    
                    // Si no responde
                    if (!response.ok) {
                        // Notificar
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    // Obtener la respuesta en formato texto
                    const text = await response.text();
                    try {
                        // Parsear la respuesta a JSON
                        const data = JSON.parse(text);
                        // Limpiar las opciones anteriores y añadir la opción por defecto
                        cuentaSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Cuenta --</option>';
                        // Iterar sobre las cuentas recibidas del servidor y añadirlas al select
                        data.forEach(cuenta => {
                            cuentaSelect.innerHTML += `<option value="${cuenta.ID}">${cuenta.NombreCuenta}</option>`;
                        });
                    } catch (e) {
                        // Si hay un error al parsear el JSON, mostrar el error en la consola
                        console.error('Error al parsear JSON:', e);
                        // También mostrar la respuesta original del servidor
                        console.error('Respuesta del servidor:', text);
                    }
                }
            } catch (error) {
                // Si hay un error en la petición, mostrarlo en la consola
                console.error('Error en la petición:', error);
            }
        }
    });

    // Evento cuando se hace clic en el botón de añadir cuenta
    addCuentaButton.addEventListener('click', function () {
        // Obtener la opción seleccionada en el select de cuenta
        const selectedCuenta = cuentaSelect.options[cuentaSelect.selectedIndex];
        // Verificar que se haya seleccionado una opción válida
        if (selectedCuenta && selectedCuenta.value !== "") {
            // Obtener el ID de la cuenta seleccionada
            const cuentaId = selectedCuenta.value;
            // Obtener el nombre de la cuenta seleccionada
            const cuentaNombre = selectedCuenta.text;
    
            // Verificar si la cuenta ya está en la lista de seleccionadas
            const cuentaExiste = cuentasSeleccionadas.some(cuenta => cuenta.cuentaId === cuentaId );
            if (!cuentaExiste) {
                // Si la cuenta no está en la lista, agregar una nueva fila a la tabla
                const newRow = cuentasTable.insertRow();
                newRow.innerHTML = `
                    <td>${cuentaId}</td>
                    <td>${cuentaNombre}</td>
                    <td><button type="button" class="btn btn-danger btn-sm removeCuenta">Eliminar</button></td>
                `;
    
                // Añadir la cuenta a la lista de cuentas seleccionadas
                cuentasSeleccionadas.push({ cuentaId: cuentaId, cuentaNombre: cuentaNombre });
    
                // Actualizar el input oculto con los datos actualizados de las cuentas seleccionadas
                actualizarDatosTablaCuenta();
    
                // Añadir el evento de eliminar cuenta a la fila recién creada
                newRow.querySelector('.removeCuenta').addEventListener('click', function () {
                    // Eliminar la fila de la tabla
                    newRow.remove();
                    // Remover la cuenta de la lista de seleccionadas
                    cuentasSeleccionadas = cuentasSeleccionadas.filter(cuenta => cuenta.cuentaId !== cuentaId);
                    // Actualizar nuevamente el input oculto
                    actualizarDatosTablaCuenta();
                });
            } else {
                console.log('La cuenta ya está en la lista de seleccionadas.');
            }
        } else {
            console.log('La ID o el nombre de la cuenta no son válidos.');
        }
    });
    
    // Función para actualizar el valor del input oculto con los datos de las cuentas seleccionadas
    function actualizarDatosTablaCuenta() {
        // Convertir la lista de cuentas seleccionadas a formato JSON y asignarlo al valor del input oculto
        datosTablaCuenta.value = JSON.stringify(cuentasSeleccionadas);
    }
});