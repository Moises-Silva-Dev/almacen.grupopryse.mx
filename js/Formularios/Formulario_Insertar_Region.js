// ==================== MODAL DE REGISTRO DE REGIÓN - JS COMPLETO ====================

let regionModal;
let formularioRegionModificado = false;
let formularioRegionEnviado = false;
let contadorEstados = 0;

// ==================== FUNCIÓN PARA ABRIR EL MODAL ====================
async function openRegionModal() {
    if (!regionModal) {
        regionModal = new bootstrap.Modal(document.getElementById('registrarRegionModal'));
    }
    
    // Mostrar loading en los selects
    const cuentaSelect = document.getElementById('ID_Cuenta');
    const estadoSelect = document.getElementById('Nombre_Estado');
    
    if (cuentaSelect) {
        cuentaSelect.innerHTML = '<option value="" selected disabled>⏳ Cargando cuentas...</option>';
        cuentaSelect.disabled = true;
    }
    if (estadoSelect) {
        estadoSelect.innerHTML = '<option value="" selected disabled>⏳ Cargando estados...</option>';
        estadoSelect.disabled = true;
    }
    
    // Resetear formulario
    const form = document.getElementById('FormInsertRegionNueva');
    if (form) {
        form.reset();
        document.querySelectorAll('#registrarRegionModal .is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
    }
    
    // Limpiar tabla de estados
    const tablaBody = document.getElementById('tablaEstadosRegiones');
    if (tablaBody) {
        tablaBody.innerHTML = '';
    }
    contadorEstados = 0;
    actualizarContadorEstados();
    
    // Resetear flags
    formularioRegionModificado = false;
    formularioRegionEnviado = false;
    
    // Cargar datos
    await Promise.all([
        cargarCuentas(),
        cargarEstados()
    ]);
    
    // Habilitar selects después de cargar
    if (cuentaSelect) cuentaSelect.disabled = false;
    if (estadoSelect) estadoSelect.disabled = false;
    
    regionModal.show();
}

// ==================== CARGAR CUENTAS VÍA FETCH ====================
async function cargarCuentas() {
    const cuentaSelect = document.getElementById('ID_Cuenta');
    if (!cuentaSelect) return;
    
    try {
        const response = await fetch('../../../Controlador/GET/Formulario/getSelectCuenta.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data && data.length > 0) {
            cuentaSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Cuenta --</option>';
            data.forEach(cuenta => {
                cuentaSelect.innerHTML += `<option value="${cuenta.ID}">${escapeHtml(cuenta.NombreCuenta)}</option>`;
            });
        } else {
            cuentaSelect.innerHTML = '<option value="" selected disabled>-- No hay cuentas disponibles --</option>';
            cuentaSelect.disabled = true;
        }
        
    } catch (error) {
        console.error('Error al cargar cuentas:', error);
        cuentaSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar cuentas</option>';
        cuentaSelect.disabled = true;
        
        Swal.fire({
            icon: 'error',
            title: 'Error de carga',
            text: 'No se pudieron cargar las cuentas. Por favor, recarga la página.',
            confirmButtonColor: '#001F3F'
        });
    }
}

// ==================== CARGAR ESTADOS VÍA FETCH ====================
async function cargarEstados() {
    const estadoSelect = document.getElementById('Nombre_Estado');
    if (!estadoSelect) return;
    
    try {
        const response = await fetch('../../../Controlador/GET/Formulario/getSelectEstado.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            estadoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Estado --</option>';
            data.data.forEach(estado => {
                estadoSelect.innerHTML += `<option value="${estado.Id_Estado}">${escapeHtml(estado.Nombre_estado)}</option>`;
            });
        } else {
            estadoSelect.innerHTML = '<option value="" selected disabled>-- No hay estados disponibles --</option>';
            estadoSelect.disabled = true;
        }
        
    } catch (error) {
        console.error('Error al cargar estados:', error);
        estadoSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar estados</option>';
        estadoSelect.disabled = true;
        
        Swal.fire({
            icon: 'error',
            title: 'Error de carga',
            text: 'No se pudieron cargar los estados. Por favor, recarga la página.',
            confirmButtonColor: '#001F3F'
        });
    }
}

// ==================== AGREGAR ESTADO A LA TABLA ====================
function agregarEstado() {
    const estadoSelect = document.getElementById('Nombre_Estado');
    const idEstado = estadoSelect.value;
    const nombreEstado = estadoSelect.options[estadoSelect.selectedIndex]?.text;
    
    if (!idEstado) {
        Swal.fire({
            icon: 'warning',
            title: 'Estado no seleccionado',
            text: 'Por favor, selecciona un estado antes de agregar.',
            confirmButtonColor: '#001F3F'
        });
        return;
    }
    
    // Verificar si el estado ya está agregado
    const tablaBody = document.getElementById('tablaEstadosRegiones');
    const estadosExistentes = tablaBody.querySelectorAll('tr');
    let existe = false;
    
    estadosExistentes.forEach(fila => {
        const id = fila.querySelector('td:first-child')?.getAttribute('data-id');
        if (id === idEstado) {
            existe = true;
        }
    });
    
    if (existe) {
        Swal.fire({
            icon: 'warning',
            title: 'Estado duplicado',
            text: `El estado "${nombreEstado}" ya ha sido agregado.`,
            confirmButtonColor: '#001F3F'
        });
        return;
    }
    
    // Agregar nueva fila
    contadorEstados++;
    const nuevaFila = document.createElement('tr');
    nuevaFila.innerHTML = `
        <td width="50">${contadorEstados}</td>
        <td data-id="${idEstado}">${escapeHtml(nombreEstado)}</td>
        <td width="100">
            <button type="button" class="btn btn-danger btn-sm btn-eliminar-estado">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </td>
    `;
    
    tablaBody.appendChild(nuevaFila);
    
    // Agregar evento de eliminación
    nuevaFila.querySelector('.btn-eliminar-estado').addEventListener('click', function() {
        eliminarEstado(nuevaFila);
    });
    
    // Limpiar select
    estadoSelect.value = '';
    formularioRegionModificado = true;
    
    // Actualizar contador
    actualizarContadorEstados();
    
    // Actualizar campo oculto
    actualizarDatosTablaRegion();
}

// ==================== ELIMINAR ESTADO ====================
function eliminarEstado(fila) {
    const nombreEstado = fila.querySelector('td:nth-child(2)').textContent;
    
    Swal.fire({
        title: '¿Eliminar estado?',
        html: `¿Estás seguro de eliminar el estado <strong>${nombreEstado}</strong> de la región?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '<i class="fas fa-trash me-1"></i> Sí, eliminar',
        cancelButtonText: '<i class="fas fa-times me-1"></i> Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fila.remove();
            contadorEstados--;
            reordenarNumeros();
            formularioRegionModificado = true;
            actualizarContadorEstados();
            actualizarDatosTablaRegion();
            
            Swal.fire({
                icon: 'success',
                title: 'Estado eliminado',
                text: `El estado ${nombreEstado} ha sido eliminado.`,
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}

// ==================== REORDENAR NÚMEROS DE FILAS ====================
function reordenarNumeros() {
    const tablaBody = document.getElementById('tablaEstadosRegiones');
    const filas = tablaBody.querySelectorAll('tr');
    
    filas.forEach((fila, index) => {
        const numeroCelda = fila.querySelector('td:first-child');
        if (numeroCelda) {
            numeroCelda.textContent = index + 1;
        }
    });
    contadorEstados = filas.length;
}

// ==================== ACTUALIZAR CONTADOR DE ESTADOS ====================
function actualizarContadorEstados() {
    const contadorSpan = document.getElementById('estadosCount');
    const tablaBody = document.getElementById('tablaEstadosRegiones');
    const cantidad = tablaBody.querySelectorAll('tr').length;
    
    if (contadorSpan) {
        if (cantidad === 0) {
            contadorSpan.innerHTML = '<i class="fas fa-info-circle me-1"></i> No hay estados agregados';
            contadorSpan.classList.add('text-muted');
        } else {
            contadorSpan.innerHTML = `<i class="fas fa-check-circle me-1 text-success"></i> ${cantidad} estado(s) agregado(s)`;
            contadorSpan.classList.remove('text-muted');
            contadorSpan.classList.add('text-success');
        }
    }
}

// ==================== ACTUALIZAR CAMPO OCULTO ====================
function actualizarDatosTablaRegion() {
    const datosTabla = document.getElementById('datosTablaInsertRegion');
    const tablaBody = document.getElementById('tablaEstadosRegiones');
    const filas = tablaBody.querySelectorAll('tr');
    const datos = [];
    
    filas.forEach(fila => {
        const idEstado = fila.querySelector('td:nth-child(2)')?.getAttribute('data-id');
        if (idEstado) {
            datos.push({ idEstado: idEstado });
        }
    });
    
    if (datosTabla) {
        datosTabla.value = JSON.stringify(datos);
    }
}

// ==================== VALIDACIÓN DEL FORMULARIO ====================
function validarFormularioRegion() {
    const cuentaSelect = document.getElementById('ID_Cuenta');
    const nombreRegion = document.getElementById('Nombre_Region');
    const tablaBody = document.getElementById('tablaEstadosRegiones');
    const estados = tablaBody.querySelectorAll('tr');
    
    let isValid = true;
    
    // Validar cuenta
    if (!cuentaSelect.value) {
        cuentaSelect.classList.add('is-invalid');
        isValid = false;
    } else {
        cuentaSelect.classList.remove('is-invalid');
    }
    
    // Validar nombre de región
    if (!nombreRegion.value.trim()) {
        nombreRegion.classList.add('is-invalid');
        isValid = false;
    } else {
        const nombreRegex = /^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/;
        if (!nombreRegex.test(nombreRegion.value.trim())) {
            nombreRegion.classList.add('is-invalid');
            isValid = false;
        } else {
            nombreRegion.classList.remove('is-invalid');
        }
    }
    
    // Validar que tenga al menos un estado
    if (estados.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Estados requeridos',
            text: 'Debes agregar al menos un estado a la región.',
            confirmButtonColor: '#001F3F'
        });
        isValid = false;
    }
    
    return isValid;
}

// ==================== ENVÍO DEL FORMULARIO ====================
function submitRegionForm() {
    const form = document.getElementById('FormInsertRegionNueva');
    
    // Actualizar datos de la tabla antes de validar
    actualizarDatosTablaRegion();
    
    if (!validarFormularioRegion()) {
        return;
    }
    
    const formData = new FormData(form);
    
    Swal.fire({
        title: 'Guardando región...',
        text: 'Por favor, espera un momento.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(async response => {
        const text = await response.text();
        console.log('Respuesta del servidor:', text);
        
        try {
            const data = JSON.parse(text);
            if (data.success) {
                formularioRegionEnviado = true;
                formularioRegionModificado = false;
                
                Swal.fire({
                    icon: 'success',
                    title: '¡Región registrada!',
                    text: data.message || 'La región ha sido registrada exitosamente.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if (regionModal) regionModal.hide();
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Ocurrió un error al registrar la región.',
                    confirmButtonColor: '#001F3F'
                });
            }
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Respuesta no válida del servidor.',
                confirmButtonColor: '#001F3F'
            });
            console.error('JSON inválido:', text);
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'Hubo un problema al procesar la solicitud.',
            confirmButtonColor: '#001F3F'
        });
        console.error('Error:', error);
    });
}

// ==================== VALIDACIÓN EN TIEMPO REAL ====================
function addRealTimeValidationRegion() {
    const nombreInput = document.getElementById('Nombre_Region');
    const cuentaSelect = document.getElementById('ID_Cuenta');
    
    if (nombreInput) {
        nombreInput.addEventListener('input', function() {
            formularioRegionModificado = true;
            
            if (this.value.trim()) {
                const nombreRegex = /^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]*$/;
                if (nombreRegex.test(this.value)) {
                    this.classList.remove('is-invalid');
                } else {
                    this.classList.add('is-invalid');
                }
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }
    
    if (cuentaSelect) {
        cuentaSelect.addEventListener('change', function() {
            formularioRegionModificado = true;
            if (this.value) {
                this.classList.remove('is-invalid');
            }
        });
    }
}

// ==================== ESCAPE HTML ====================
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando modal de región...');
    
    // Evento para botón de agregar estado
    const btnAgregar = document.getElementById('btn_AgregarRegionConEstado');
    if (btnAgregar) {
        btnAgregar.addEventListener('click', agregarEstado);
    }
    
    // Evento para botón de guardar
    const btnGuardar = document.getElementById('btnGuardarRegion');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            submitRegionForm();
        });
    }
    
    // Validación en tiempo real
    addRealTimeValidationRegion();
    
    // Configurar el modal
    const modalElement = document.getElementById('registrarRegionModal');
    if (modalElement) {
        const form = document.getElementById('FormInsertRegionNueva');
        
        // Detectar cambios en el formulario
        if (form) {
            const inputs = form.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.addEventListener('change', () => { formularioRegionModificado = true; });
                input.addEventListener('input', () => { formularioRegionModificado = true; });
            });
        }
        
        // Prevenir cierre si hay cambios sin guardar
        modalElement.addEventListener('hide.bs.modal', function(e) {
            if (formularioRegionEnviado) return;
            
            if (formularioRegionModificado) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Descartar cambios?',
                    text: 'Tienes cambios sin guardar. ¿Estás seguro?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, descartar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        formularioRegionModificado = false;
                        formularioRegionEnviado = false;
                        modalElement.classList.remove('show');
                        document.body.classList.remove('modal-open');
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) backdrop.remove();
                    }
                });
            }
        });
        
        // Resetear cuando se cierra
        modalElement.addEventListener('hidden.bs.modal', function() {
            formularioRegionModificado = false;
            formularioRegionEnviado = false;
            
            const form = document.getElementById('FormInsertRegionNueva');
            if (form) {
                form.reset();
                document.querySelectorAll('#registrarRegionModal .is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
            }
            
            const tablaBody = document.getElementById('tablaEstadosRegiones');
            if (tablaBody) {
                tablaBody.innerHTML = '';
            }
            contadorEstados = 0;
            actualizarContadorEstados();
        });
    }
});

// Función global para abrir el modal
window.openRegionModal = openRegionModal;