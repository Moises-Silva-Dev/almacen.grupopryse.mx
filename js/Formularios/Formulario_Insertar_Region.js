// ==================== MODAL DE REGISTRO DE REGIÓN - JS COMPLETO ====================

let regionModal;
let formularioInsertRegionModificado = false;
let formularioInsertRegionEnviado = false;
let contadorEstadosInsert = 0;

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
    contadorEstadosInsert = 0;
    actualizarContadorEstadosInsert();
    
    // Resetear flags
    formularioInsertRegionModificado = false;
    formularioInsertRegionEnviado = false;
    
    // Cargar datos
    await Promise.all([
        cargarCuentasInsert(),
        cargarEstadosInsert()
    ]);
    
    // Habilitar selects después de cargar
    if (cuentaSelect) cuentaSelect.disabled = false;
    if (estadoSelect) estadoSelect.disabled = false;
    
    regionModal.show();
}

// ==================== CARGAR CUENTAS VÍA FETCH ====================
async function cargarCuentasInsert() {
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
    }
}

// ==================== CARGAR ESTADOS VÍA FETCH ====================
async function cargarEstadosInsert() {
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
    }
}

// ==================== AGREGAR ESTADO A LA TABLA ====================
function agregarEstadoInsert() {
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
        const id = fila.querySelector('td:nth-child(2)')?.getAttribute('data-id');
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
    contadorEstadosInsert++;
    const nuevaFila = document.createElement('tr');
    nuevaFila.innerHTML = `
        <td width="50">${contadorEstadosInsert}</td>
        <td data-id="${idEstado}">${escapeHtml(nombreEstado)}</td>
        <td width="100">
            <button type="button" class="btn btn-danger btn-sm btn-eliminar-estado-insert">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </td>
    `;
    
    tablaBody.appendChild(nuevaFila);
    
    // Agregar evento de eliminación
    nuevaFila.querySelector('.btn-eliminar-estado-insert').addEventListener('click', function() {
        eliminarEstadoInsert(nuevaFila);
    });
    
    // Limpiar select
    estadoSelect.value = '';
    formularioInsertRegionModificado = true;
    
    // Actualizar contador
    actualizarContadorEstadosInsert();
    actualizarDatosTablaInsert();
}

// ==================== ELIMINAR ESTADO ====================
function eliminarEstadoInsert(fila) {
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
            contadorEstadosInsert--;
            reordenarNumerosInsert();
            formularioInsertRegionModificado = true;
            actualizarContadorEstadosInsert();
            actualizarDatosTablaInsert();
            
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
function reordenarNumerosInsert() {
    const tablaBody = document.getElementById('tablaEstadosRegiones');
    const filas = tablaBody.querySelectorAll('tr');
    
    filas.forEach((fila, index) => {
        const numeroCelda = fila.querySelector('td:first-child');
        if (numeroCelda) {
            numeroCelda.textContent = index + 1;
        }
    });
    contadorEstadosInsert = filas.length;
}

// ==================== ACTUALIZAR CONTADOR DE ESTADOS ====================
function actualizarContadorEstadosInsert() {
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
function actualizarDatosTablaInsert() {
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
function validarFormularioInsertRegion() {
    const cuentaSelect = document.getElementById('ID_Cuenta');
    const nombreRegion = document.getElementById('Nombre_Region');
    const tablaBody = document.getElementById('tablaEstadosRegiones');
    const estados = tablaBody.querySelectorAll('tr');
    
    let isValid = true;
    
    if (!cuentaSelect.value) {
        cuentaSelect.classList.add('is-invalid');
        isValid = false;
    } else {
        cuentaSelect.classList.remove('is-invalid');
    }
    
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
function submitInsertRegionForm() {
    const form = document.getElementById('FormInsertRegionNueva');
    
    actualizarDatosTablaInsert();
    
    if (!validarFormularioInsertRegion()) {
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
        try {
            const data = JSON.parse(text);
            if (data.success) {
                formularioInsertRegionEnviado = true;
                formularioInsertRegionModificado = false;
                
                Swal.fire({
                    icon: 'success',
                    title: '¡Región registrada!',
                    text: data.message,
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
function addRealTimeValidationInsertRegion() {
    const nombreInput = document.getElementById('Nombre_Region');
    const cuentaSelect = document.getElementById('ID_Cuenta');
    
    if (nombreInput) {
        nombreInput.addEventListener('input', function() {
            formularioInsertRegionModificado = true;
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
            formularioInsertRegionModificado = true;
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
    
    const btnAgregar = document.getElementById('btn_AgregarRegionConEstado');
    if (btnAgregar) {
        btnAgregar.addEventListener('click', agregarEstadoInsert);
    }
    
    const btnGuardar = document.getElementById('btnGuardarRegion');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            submitInsertRegionForm();
        });
    }
    
    addRealTimeValidationInsertRegion();
    
    const modalElement = document.getElementById('registrarRegionModal');
    if (modalElement) {
        const form = document.getElementById('FormInsertRegionNueva');
        
        if (form) {
            const inputs = form.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.addEventListener('change', () => { formularioInsertRegionModificado = true; });
                input.addEventListener('input', () => { formularioInsertRegionModificado = true; });
            });
        }
        
        modalElement.addEventListener('hide.bs.modal', function(e) {
            if (formularioInsertRegionEnviado) return;
            
            if (formularioInsertRegionModificado) {
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
                        formularioInsertRegionModificado = false;
                        formularioInsertRegionEnviado = false;
                        modalElement.classList.remove('show');
                        document.body.classList.remove('modal-open');
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) backdrop.remove();
                    }
                });
            }
        });
        
        modalElement.addEventListener('hidden.bs.modal', function() {
            formularioInsertRegionModificado = false;
            formularioInsertRegionEnviado = false;
            
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
            contadorEstadosInsert = 0;
            actualizarContadorEstadosInsert();
        });
    }
});

window.openRegionModal = openRegionModal;