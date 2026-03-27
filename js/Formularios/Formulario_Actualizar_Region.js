// ==================== MODAL DE MODIFICAR REGIÓN - JS COMPLETO ====================

let modificarRegionModal;
let formularioUpdateRegionModificado = false;
let formularioUpdateRegionEnviado = false;
let contadorEstadosUpdate = 0;

// ==================== FUNCIÓN PARA ABRIR EL MODAL ====================
async function openModificarRegionModal(regionId) {
    if (!modificarRegionModal) {
        modificarRegionModal = new bootstrap.Modal(document.getElementById('modificarRegionModal'));
    }
    
    const loadingDiv = document.getElementById('loadingRegionData');
    const formContainer = document.getElementById('editRegionFormContainer');
    
    if (loadingDiv) loadingDiv.style.display = 'block';
    if (formContainer) formContainer.style.display = 'none';
    
    formularioUpdateRegionModificado = false;
    formularioUpdateRegionEnviado = false;
    
    modificarRegionModal.show();
    
    try {
        const regionData = await fetchRegionData(regionId);
        
        if (regionData) {
            await fillEditRegionForm(regionData);
            
            if (loadingDiv) loadingDiv.style.display = 'none';
            if (formContainer) formContainer.style.display = 'block';
        } else {
            throw new Error('No se pudieron cargar los datos de la región');
        }
        
    } catch (error) {
        console.error('Error al cargar región:', error);
        if (loadingDiv) {
            loadingDiv.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar los datos: ${error.message}
                </div>
                <button class="btn btn-navy mt-3" onclick="openModificarRegionModal(${regionId})">
                    <i class="fas fa-redo me-1"></i> Reintentar
                </button>
                <button class="btn btn-secondary mt-3 ms-2" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cerrar
                </button>
            `;
        }
    }
}

// ==================== FUNCIÓN PARA OBTENER DATOS DE LA REGIÓN ====================
async function fetchRegionData(regionId) {
    try {
        const response = await fetch(`../../../Controlador/GET/Formulario/getObtenerInfoRegion.php?id=${regionId}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            return data.data;
        } else {
            throw new Error(data.message || 'Error al obtener datos');
        }
        
    } catch (error) {
        console.error('Error en fetchRegionData:', error);
        throw error;
    }
}

// ==================== CARGAR CUENTAS VÍA FETCH ====================
async function cargarCuentasUpdate(selectedId = null) {
    const cuentaSelect = document.getElementById('edit_ID_Cuenta');
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
                const selected = selectedId == cuenta.ID ? 'selected' : '';
                cuentaSelect.innerHTML += `<option value="${cuenta.ID}" ${selected}>${escapeHtmlUpdate(cuenta.NombreCuenta)}</option>`;
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
async function cargarEstadosUpdate() {
    const estadoSelect = document.getElementById('edit_Nombre_Estado');
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
                estadoSelect.innerHTML += `<option value="${estado.Id_Estado}">${escapeHtmlUpdate(estado.Nombre_estado)}</option>`;
            });
            estadoSelect.disabled = false;
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

// ==================== FUNCIÓN PARA LLENAR EL FORMULARIO ====================
async function fillEditRegionForm(regionData) {
    document.getElementById('edit_region_id').value = regionData.ID_Region || '';
    document.getElementById('edit_Nombre_Region').value = regionData.Nombre_Region || '';
    
    await cargarCuentasUpdate(regionData.ID_Cuentas);
    await cargarEstadosUpdate();
    
    cargarEstadosUpdateRegion(regionData.estados);
}

// ==================== CARGAR ESTADOS DE LA REGIÓN ====================
function cargarEstadosUpdateRegion(estados) {
    const tablaBody = document.getElementById('edit_tablaEstadosRegiones');
    if (!tablaBody) return;
    
    tablaBody.innerHTML = '';
    contadorEstadosUpdate = 0;
    
    if (estados && estados.length > 0) {
        estados.forEach(estado => {
            contadorEstadosUpdate++;
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td width="50">${contadorEstadosUpdate}</td>
                <td data-id="${estado.Id_Estado}">${escapeHtmlUpdate(estado.Nombre_estado)}</td>
                <td width="100">
                    <button type="button" class="btn btn-danger btn-sm btn-eliminar-estado-update">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </td>
            `;
            
            tablaBody.appendChild(fila);
            
            fila.querySelector('.btn-eliminar-estado-update').addEventListener('click', function() {
                eliminarEstadoUpdate(fila);
            });
        });
    }
    
    actualizarContadorEstadosUpdate();
    actualizarDatosTablaUpdate();
}

// ==================== AGREGAR ESTADO A LA TABLA ====================
function agregarEstadoUpdate() {
    const estadoSelect = document.getElementById('edit_Nombre_Estado');
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
    
    const tablaBody = document.getElementById('edit_tablaEstadosRegiones');
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
    
    contadorEstadosUpdate++;
    const nuevaFila = document.createElement('tr');
    nuevaFila.innerHTML = `
        <td width="50">${contadorEstadosUpdate}</td>
        <td data-id="${idEstado}">${escapeHtmlUpdate(nombreEstado)}</td>
        <td width="100">
            <button type="button" class="btn btn-danger btn-sm btn-eliminar-estado-update">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </td>
    `;
    
    tablaBody.appendChild(nuevaFila);
    
    nuevaFila.querySelector('.btn-eliminar-estado-update').addEventListener('click', function() {
        eliminarEstadoUpdate(nuevaFila);
    });
    
    estadoSelect.value = '';
    formularioUpdateRegionModificado = true;
    
    actualizarContadorEstadosUpdate();
    actualizarDatosTablaUpdate();
}

// ==================== ELIMINAR ESTADO ====================
function eliminarEstadoUpdate(fila) {
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
            contadorEstadosUpdate--;
            reordenarNumerosUpdate();
            formularioUpdateRegionModificado = true;
            actualizarContadorEstadosUpdate();
            actualizarDatosTablaUpdate();
            
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
function reordenarNumerosUpdate() {
    const tablaBody = document.getElementById('edit_tablaEstadosRegiones');
    const filas = tablaBody.querySelectorAll('tr');
    
    filas.forEach((fila, index) => {
        const numeroCelda = fila.querySelector('td:first-child');
        if (numeroCelda) {
            numeroCelda.textContent = index + 1;
        }
    });
    contadorEstadosUpdate = filas.length;
}

// ==================== ACTUALIZAR CONTADOR DE ESTADOS ====================
function actualizarContadorEstadosUpdate() {
    const contadorSpan = document.getElementById('edit_estadosCount');
    const tablaBody = document.getElementById('edit_tablaEstadosRegiones');
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
function actualizarDatosTablaUpdate() {
    const datosTabla = document.getElementById('datosTablaUpdateRegion');
    const tablaBody = document.getElementById('edit_tablaEstadosRegiones');
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
function validarFormularioUpdateRegion() {
    const cuentaSelect = document.getElementById('edit_ID_Cuenta');
    const nombreRegion = document.getElementById('edit_Nombre_Region');
    const tablaBody = document.getElementById('edit_tablaEstadosRegiones');
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
function submitUpdateRegionForm() {
    const form = document.getElementById('FormUpdateRegion');
    
    actualizarDatosTablaUpdate();
    
    if (!validarFormularioUpdateRegion()) {
        return;
    }
    
    const formData = new FormData(form);
    
    Swal.fire({
        title: 'Guardando cambios...',
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
                formularioUpdateRegionEnviado = true;
                formularioUpdateRegionModificado = false;
                
                Swal.fire({
                    icon: 'success',
                    title: '¡Región actualizada!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if (modificarRegionModal) modificarRegionModal.hide();
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Ocurrió un error al actualizar la región.',
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
function addRealTimeValidationUpdateRegion() {
    const nombreInput = document.getElementById('edit_Nombre_Region');
    const cuentaSelect = document.getElementById('edit_ID_Cuenta');
    
    if (nombreInput) {
        nombreInput.addEventListener('input', function() {
            formularioUpdateRegionModificado = true;
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
            formularioUpdateRegionModificado = true;
            if (this.value) {
                this.classList.remove('is-invalid');
            }
        });
    }
}

// ==================== ESCAPE HTML ====================
function escapeHtmlUpdate(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando modal de modificar región...');
    
    const btnAgregar = document.getElementById('btn_ModificarRegionConEstado');
    if (btnAgregar) {
        btnAgregar.addEventListener('click', agregarEstadoUpdate);
    }
    
    const btnGuardar = document.getElementById('btnGuardarEditarRegion');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            submitUpdateRegionForm();
        });
    }
    
    addRealTimeValidationUpdateRegion();
    
    const modalElement = document.getElementById('modificarRegionModal');
    if (modalElement) {
        const form = document.getElementById('FormUpdateRegion');
        
        if (form) {
            const inputs = form.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.addEventListener('change', () => { formularioUpdateRegionModificado = true; });
                input.addEventListener('input', () => { formularioUpdateRegionModificado = true; });
            });
        }
        
        modalElement.addEventListener('hide.bs.modal', function(e) {
            if (formularioUpdateRegionEnviado) return;
            
            if (formularioUpdateRegionModificado) {
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
                        formularioUpdateRegionModificado = false;
                        formularioUpdateRegionEnviado = false;
                        modalElement.classList.remove('show');
                        document.body.classList.remove('modal-open');
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) backdrop.remove();
                    }
                });
            }
        });
        
        modalElement.addEventListener('hidden.bs.modal', function() {
            formularioUpdateRegionModificado = false;
            formularioUpdateRegionEnviado = false;
            
            const loadingDiv = document.getElementById('loadingRegionData');
            const formContainer = document.getElementById('editRegionFormContainer');
            
            if (loadingDiv) {
                loadingDiv.style.display = 'block';
                loadingDiv.innerHTML = `
                    <div class="text-center py-5">
                        <div class="spinner-border text-turquoise" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-3 text-muted">Cargando datos de la región...</p>
                    </div>
                `;
            }
            if (formContainer) formContainer.style.display = 'none';
        });
    }
});

window.openModificarRegionModal = openModificarRegionModal;