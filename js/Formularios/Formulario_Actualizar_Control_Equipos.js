// ==================== MODAL DE MODIFICAR CONTROL DE EQUIPOS - JS COMPLETO ====================

let modificarEquipoModal;
let formularioModificarEquipoModificado = false;
let formularioModificarEquipoEnviado = false;
let currentStepEditEquipo = 1;
const totalStepsEditEquipo = 3;

// ==================== FUNCIONES DE NAVEGACIÓN ====================
function updateStepIndicatorsEditEquipo() {
    const circles = [
        document.getElementById('edit_equipo_stepCircle1'),
        document.getElementById('edit_equipo_stepCircle2'),
        document.getElementById('edit_equipo_stepCircle3')
    ];
    
    const labels = [
        document.getElementById('edit_equipo_stepLabel1'),
        document.getElementById('edit_equipo_stepLabel2'),
        document.getElementById('edit_equipo_stepLabel3')
    ];
    
    const lines = [
        document.getElementById('edit_equipo_stepLine1-2'),
        document.getElementById('edit_equipo_stepLine2-3')
    ];
    
    circles.forEach(circle => {
        if (circle) {
            circle.classList.remove('active', 'completed');
        }
    });
    labels.forEach(label => {
        if (label) {
            label.classList.remove('active', 'completed');
        }
    });
    lines.forEach(line => {
        if (line) {
            line.classList.remove('active', 'completed');
        }
    });
    
    for (let i = 0; i < currentStepEditEquipo - 1; i++) {
        if (circles[i]) circles[i].classList.add('completed');
        if (labels[i]) labels[i].classList.add('completed');
        if (i < lines.length && lines[i]) {
            lines[i].classList.add('completed');
        }
    }
    
    if (currentStepEditEquipo <= circles.length) {
        if (circles[currentStepEditEquipo - 1]) circles[currentStepEditEquipo - 1].classList.add('active');
        if (labels[currentStepEditEquipo - 1]) labels[currentStepEditEquipo - 1].classList.add('active');
        
        if (currentStepEditEquipo - 2 >= 0 && lines[currentStepEditEquipo - 2]) {
            lines[currentStepEditEquipo - 2].classList.add('active');
        }
    }
}

function updateStepsEditEquipo() {
    const step1 = document.getElementById('edit_equipo_step1');
    const step2 = document.getElementById('edit_equipo_step2');
    const step3 = document.getElementById('edit_equipo_step3');
    const prevBtn = document.getElementById('edit_equipo_prevBtn');
    const nextBtn = document.getElementById('edit_equipo_nextBtn');
    const submitBtn = document.getElementById('edit_equipo_submitBtn');
    
    if (step1) step1.style.display = 'none';
    if (step2) step2.style.display = 'none';
    if (step3) step3.style.display = 'none';
    
    if (currentStepEditEquipo === 1 && step1) step1.style.display = 'block';
    if (currentStepEditEquipo === 2 && step2) step2.style.display = 'block';
    if (currentStepEditEquipo === 3 && step3) step3.style.display = 'block';
    
    if (prevBtn) prevBtn.style.display = currentStepEditEquipo === 1 ? 'none' : 'inline-block';
    if (nextBtn) nextBtn.style.display = currentStepEditEquipo === totalStepsEditEquipo ? 'none' : 'inline-block';
    if (submitBtn) submitBtn.style.display = currentStepEditEquipo === totalStepsEditEquipo ? 'inline-block' : 'none';
    
    updateStepIndicatorsEditEquipo();
}

function goToNextStepEditEquipo() {
    if (validateCurrentStepEditEquipo()) {
        currentStepEditEquipo++;
        updateStepsEditEquipo();
        
        const modalBody = document.querySelector('#modificarEquipoModal .modal-body');
        if (modalBody) {
            modalBody.scrollTo({ top: 0, behavior: 'smooth' });
        }
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Por favor, completa todos los campos requeridos antes de continuar.',
            confirmButtonColor: '#001F3F'
        });
    }
}

function goToPrevStepEditEquipo() {
    currentStepEditEquipo--;
    updateStepsEditEquipo();
    
    const modalBody = document.querySelector('#modificarEquipoModal .modal-body');
    if (modalBody) {
        modalBody.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function validateCurrentStepEditEquipo() {
    if (currentStepEditEquipo === 1) {
        return validateStep1EditEquipo();
    }
    if (currentStepEditEquipo === 2) {
        return validateStep2EditEquipo();
    }
    if (currentStepEditEquipo === 3) {
        return true;
    }
    return true;
}

function validateStep1EditEquipo() {
    const nombrePersona = document.getElementById('edit_equipo_Nombre_Persona');
    const departamento = document.getElementById('edit_equipo_ID_Departamento');
    const estatus = document.getElementById('edit_equipo_Estatus');
    
    let isValid = true;
    
    if (!nombrePersona.value.trim()) {
        nombrePersona.classList.add('is-invalid');
        isValid = false;
    } else {
        nombrePersona.classList.remove('is-invalid');
    }
    
    if (!departamento.value) {
        departamento.classList.add('is-invalid');
        isValid = false;
    } else {
        departamento.classList.remove('is-invalid');
    }
    
    if (!estatus.value) {
        estatus.classList.add('is-invalid');
        isValid = false;
    } else {
        estatus.classList.remove('is-invalid');
    }
    
    return isValid;
}

function validateStep2EditEquipo() {
    const tipoPC = document.getElementById('edit_equipo_Tipo_PC');
    const marcaEquipo = document.getElementById('edit_equipo_Marca_Equipo');
    const sistemaOperativo = document.getElementById('edit_equipo_Sistema_Operativo');
    const procesador = document.getElementById('edit_equipo_Procesador');
    const tarjetaMadre = document.getElementById('edit_equipo_Tarjeta_Madre');
    const tipoRAM = document.getElementById('edit_equipo_Tipo_RAM');
    const capacidadRAM = document.getElementById('edit_equipo_Capacidad_RAM');
    const marcaRAM = document.getElementById('edit_equipo_Marca_RAM');
    const tipoDisco = document.getElementById('edit_equipo_Tipo_Disco');
    const capacidadDisco = document.getElementById('edit_equipo_Capacidad_Disco');
    
    let isValid = true;
    
    if (!tipoPC.value) {
        tipoPC.classList.add('is-invalid');
        isValid = false;
    } else {
        tipoPC.classList.remove('is-invalid');
    }
    
    if (!marcaEquipo.value) {
        marcaEquipo.classList.add('is-invalid');
        isValid = false;
    } else {
        marcaEquipo.classList.remove('is-invalid');
    }
    
    if (!sistemaOperativo.value) {
        sistemaOperativo.classList.add('is-invalid');
        isValid = false;
    } else {
        sistemaOperativo.classList.remove('is-invalid');
    }
    
    if (!procesador.value) {
        procesador.classList.add('is-invalid');
        isValid = false;
    } else {
        procesador.classList.remove('is-invalid');
    }
    
    if (!tarjetaMadre.value) {
        tarjetaMadre.classList.add('is-invalid');
        isValid = false;
    } else {
        tarjetaMadre.classList.remove('is-invalid');
    }
    
    if (!tipoRAM.value) {
        tipoRAM.classList.add('is-invalid');
        isValid = false;
    } else {
        tipoRAM.classList.remove('is-invalid');
    }
    
    if (!capacidadRAM.value) {
        capacidadRAM.classList.add('is-invalid');
        isValid = false;
    } else {
        capacidadRAM.classList.remove('is-invalid');
    }
    
    if (!marcaRAM.value) {
        marcaRAM.classList.add('is-invalid');
        isValid = false;
    } else {
        marcaRAM.classList.remove('is-invalid');
    }
    
    if (!tipoDisco.value) {
        tipoDisco.classList.add('is-invalid');
        isValid = false;
    } else {
        tipoDisco.classList.remove('is-invalid');
    }
    
    if (!capacidadDisco.value) {
        capacidadDisco.classList.add('is-invalid');
        isValid = false;
    } else {
        capacidadDisco.classList.remove('is-invalid');
    }
    
    return isValid;
}

// ==================== FUNCIÓN PARA ABRIR EL MODAL ====================
async function openModificarEquipoModal(equipoId) {
    if (!modificarEquipoModal) {
        modificarEquipoModal = new bootstrap.Modal(document.getElementById('modificarEquipoModal'));
    }
    
    const loadingDiv = document.getElementById('loadingModificarEquipoData');
    const formContainer = document.getElementById('modificarEquipoFormContainer');
    
    if (loadingDiv) loadingDiv.style.display = 'block';
    if (formContainer) formContainer.style.display = 'none';
    
    formularioModificarEquipoModificado = false;
    formularioModificarEquipoEnviado = false;
    currentStepEditEquipo = 1;
    
    modificarEquipoModal.show();
    
    try {
        const equipoData = await fetchEquipoData(equipoId);
        
        if (equipoData) {
            await Promise.all([
                cargarDepartamentosEdit(equipoData.ID_Departamento),
                cargarMarcasEquipoEdit(equipoData.Marca_Equipo),
                cargarProcesadoresEdit(equipoData.Procesador),
                cargarTarjetasMadreEdit(equipoData.Tarjeta_Madre),
                cargarMarcasRAMEdit(equipoData.Marca_RAM)
            ]);
            
            fillEditEquipoForm(equipoData);
            
            updateStepsEditEquipo();
            
            if (loadingDiv) loadingDiv.style.display = 'none';
            if (formContainer) formContainer.style.display = 'block';
        } else {
            throw new Error('No se pudieron cargar los datos del equipo');
        }
        
    } catch (error) {
        console.error('Error al cargar equipo:', error);
        if (loadingDiv) {
            loadingDiv.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar los datos: ${error.message}
                </div>
                <button class="btn btn-navy mt-3" onclick="openModificarEquipoModal(${equipoId})">
                    <i class="fas fa-redo me-1"></i> Reintentar
                </button>
                <button class="btn btn-secondary mt-3 ms-2" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cerrar
                </button>
            `;
        }
    }
}

// ==================== FUNCIÓN PARA OBTENER DATOS DEL EQUIPO ====================
async function fetchEquipoData(equipoId) {
    try {
        const response = await fetch(`../../../Controlador/GET/Formulario/getObtenerInfoEquipo.php?id=${equipoId}`);
        
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
        console.error('Error en fetchEquipoData:', error);
        throw error;
    }
}

// ==================== FUNCIONES DE CARGA DE DATOS ====================
async function cargarDepartamentosEdit(selectedId = null) {
    const deptoSelect = document.getElementById('edit_equipo_ID_Departamento');
    if (!deptoSelect) return;
    
    try {
        const response = await fetch('../../../Controlador/GET/Formulario/getDepartamentos.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            deptoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Departamento --</option>';
            data.data.forEach(depto => {
                const selected = selectedId == depto.Id ? 'selected' : '';
                deptoSelect.innerHTML += `<option value="${depto.Id}" ${selected}>${escapeHtmlEditEquipo(depto.Nombre_Departamento)}</option>`;
            });
            deptoSelect.disabled = false;
        } else {
            deptoSelect.innerHTML = '<option value="" selected disabled>-- No hay departamentos disponibles --</option>';
            deptoSelect.disabled = true;
        }
        
    } catch (error) {
        console.error('Error al cargar departamentos:', error);
        deptoSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar departamentos</option>';
        deptoSelect.disabled = true;
    }
}

async function cargarMarcasEquipoEdit(selectedValue = null) {
    const marcaSelect = document.getElementById('edit_equipo_Marca_Equipo');
    if (!marcaSelect) return;
    
    try {
        const response = await fetch('../../../Controlador/GET/Formulario/getMarcasEquipo.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            marcaSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Marca --</option>';
            data.data.forEach(marca => {
                const selected = selectedValue === marca ? 'selected' : '';
                marcaSelect.innerHTML += `<option value="${escapeHtmlEditEquipo(marca)}" ${selected}>${escapeHtmlEditEquipo(marca)}</option>`;
            });
            marcaSelect.disabled = false;
        } else {
            marcaSelect.innerHTML = '<option value="" selected disabled>-- No hay marcas disponibles --</option>';
            marcaSelect.disabled = true;
        }
        
    } catch (error) {
        console.error('Error al cargar marcas:', error);
        marcaSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar marcas</option>';
        marcaSelect.disabled = true;
    }
}

async function cargarProcesadoresEdit(selectedValue = null) {
    const procSelect = document.getElementById('edit_equipo_Procesador');
    if (!procSelect) return;
    
    try {
        const response = await fetch('../../../Controlador/GET/Formulario/getProcesadores.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            procSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Procesador --</option>';
            data.data.forEach(procesador => {
                const selected = selectedValue === procesador ? 'selected' : '';
                procSelect.innerHTML += `<option value="${escapeHtmlEditEquipo(procesador)}" ${selected}>${escapeHtmlEditEquipo(procesador)}</option>`;
            });
            procSelect.disabled = false;
        } else {
            procSelect.innerHTML = '<option value="" selected disabled>-- No hay procesadores disponibles --</option>';
            procSelect.disabled = true;
        }
        
    } catch (error) {
        console.error('Error al cargar procesadores:', error);
        procSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar procesadores</option>';
        procSelect.disabled = true;
    }
}

async function cargarTarjetasMadreEdit(selectedValue = null) {
    const tmSelect = document.getElementById('edit_equipo_Tarjeta_Madre');
    if (!tmSelect) return;
    
    try {
        const response = await fetch('../../../Controlador/GET/Formulario/getTarjetasMadre.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            tmSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Tarjeta Madre --</option>';
            data.data.forEach(tarjeta => {
                const selected = selectedValue === tarjeta ? 'selected' : '';
                tmSelect.innerHTML += `<option value="${escapeHtmlEditEquipo(tarjeta)}" ${selected}>${escapeHtmlEditEquipo(tarjeta)}</option>`;
            });
            tmSelect.disabled = false;
        } else {
            tmSelect.innerHTML = '<option value="" selected disabled>-- No hay tarjetas madre disponibles --</option>';
            tmSelect.disabled = true;
        }
        
    } catch (error) {
        console.error('Error al cargar tarjetas madre:', error);
        tmSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar tarjetas madre</option>';
        tmSelect.disabled = true;
    }
}

async function cargarMarcasRAMEdit(selectedValue = null) {
    const ramSelect = document.getElementById('edit_equipo_Marca_RAM');
    if (!ramSelect) return;
    
    try {
        const response = await fetch('../../../Controlador/GET/Formulario/getMarcasRAM.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            ramSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Marca de RAM --</option>';
            data.data.forEach(marca => {
                const selected = selectedValue === marca ? 'selected' : '';
                ramSelect.innerHTML += `<option value="${escapeHtmlEditEquipo(marca)}" ${selected}>${escapeHtmlEditEquipo(marca)}</option>`;
            });
            ramSelect.disabled = false;
        } else {
            ramSelect.innerHTML = '<option value="" selected disabled>-- No hay marcas de RAM disponibles --</option>';
            ramSelect.disabled = true;
        }
        
    } catch (error) {
        console.error('Error al cargar marcas de RAM:', error);
        ramSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar marcas de RAM</option>';
        ramSelect.disabled = true;
    }
}

// ==================== LLENAR FORMULARIO ====================
function fillEditEquipoForm(data) {
    // Paso 1
    document.getElementById('edit_equipo_id').value = data.Id || '';
    document.getElementById('edit_equipo_Nombre_Persona').value = data.Nombre_Persona || '';
    document.getElementById('edit_equipo_Observaciones').value = data.Observaciones || '';
    document.getElementById('edit_equipo_Estatus').value = data.Estatus || 'Activo';
    
    // Paso 2
    document.getElementById('edit_equipo_Tipo_PC').value = data.Tipo_PC || '';
    document.getElementById('edit_equipo_Modelo_Equipo').value = data.Modelo_Equipo || '';
    document.getElementById('edit_equipo_Numero_Serie').value = data.Numero_Serie || '';
    document.getElementById('edit_equipo_Sistema_Operativo').value = data.Sistema_Operativo || '';
    document.getElementById('edit_equipo_Tipo_RAM').value = data.Tipo_RAM || '';
    document.getElementById('edit_equipo_Capacidad_RAM').value = data.Capacidad_RAM || '';
    document.getElementById('edit_equipo_Tipo_Disco').value = data.Tipo_Disco || '';
    document.getElementById('edit_equipo_Capacidad_Disco').value = data.Capacidad_Disco || '';
    
    // Tarjeta gráfica
    const tieneGrafica = data.Tiene_Grafica_Dedicada == 1;
    const graficaCheckbox = document.getElementById('edit_equipo_Tiene_Grafica_Dedicada');
    const graficaDiv = document.getElementById('edit_equipo_Datos_Grafica_Div');
    
    if (graficaCheckbox) {
        graficaCheckbox.checked = tieneGrafica;
        graficaDiv.style.display = tieneGrafica ? 'block' : 'none';
        if (tieneGrafica) {
            document.getElementById('edit_equipo_Datos_Tarjeta_Grafica').value = data.Datos_Tarjeta_Grafica || '';
        }
    }
    
    // Paso 3
    document.getElementById('edit_equipo_Teclado_Mouse').value = data.Teclado_Mouse || '';
    document.getElementById('edit_equipo_Camara_Web').value = data.Camara_Web || 'Integrada';
    document.getElementById('edit_equipo_Otro_Periferico').value = data.Otro_Periferico || '';
}

// ==================== CONFIGURAR EVENTOS ESPECIALES ====================
function setupEventosEditEquipo() {
    // Mostrar/ocultar campo de tarjeta gráfica
    const chkGrafica = document.getElementById('edit_equipo_Tiene_Grafica_Dedicada');
    const graficaDiv = document.getElementById('edit_equipo_Datos_Grafica_Div');
    
    if (chkGrafica) {
        chkGrafica.addEventListener('change', function() {
            formularioModificarEquipoModificado = true;
            graficaDiv.style.display = this.checked ? 'block' : 'none';
            const graficaInput = document.getElementById('edit_equipo_Datos_Tarjeta_Grafica');
            if (!this.checked && graficaInput) {
                graficaInput.value = '';
            }
        });
    }
    
    // Detectar cambios en todos los campos
    const form = document.getElementById('FormUpdateControlEquipo');
    if (form) {
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('change', () => { formularioModificarEquipoModificado = true; });
            input.addEventListener('input', () => { formularioModificarEquipoModificado = true; });
        });
    }
}

// ==================== ENVÍO DEL FORMULARIO ====================
function submitEditEquipoForm() {
    const form = document.getElementById('FormUpdateControlEquipo');
    
    if (!validateStep2EditEquipo()) {
        if (currentStepEditEquipo !== 2) {
            currentStepEditEquipo = 2;
            updateStepsEditEquipo();
        }
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Por favor, completa todos los campos requeridos del equipo.',
            confirmButtonColor: '#001F3F'
        });
        return;
    }
    
    const formData = new FormData(form);
    formularioModificarEquipoEnviado = true;
    
    Swal.fire({
        title: 'Guardando cambios...',
        text: 'Por favor, espera un momento.',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
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
                Swal.fire({
                    icon: 'success',
                    title: '¡Equipo actualizado!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if (modificarEquipoModal) modificarEquipoModal.hide();
                    location.reload();
                });
            } else {
                formularioModificarEquipoEnviado = false;
                Swal.fire({ icon: 'error', title: 'Error', text: data.message, confirmButtonColor: '#001F3F' });
            }
        } catch (err) {
            formularioModificarEquipoEnviado = false;
            Swal.fire({ icon: 'error', title: 'Error', text: 'Respuesta no válida del servidor.', confirmButtonColor: '#001F3F' });
        }
    })
    .catch(error => {
        formularioModificarEquipoEnviado = false;
        Swal.fire({ icon: 'error', title: 'Error de conexión', text: 'Hubo un problema al procesar la solicitud.', confirmButtonColor: '#001F3F' });
    });
}

// ==================== ESCAPE HTML ====================
function escapeHtmlEditEquipo(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== PREVENIR CIERRE ACCIDENTAL ====================
function setupPrevenirCierreEditEquipo() {
    const modalElement = document.getElementById('modificarEquipoModal');
    const form = document.getElementById('FormUpdateControlEquipo');
    
    if (!modalElement || !form) return;
    
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            formularioModificarEquipoModificado = true;
        });
        input.addEventListener('input', () => {
            formularioModificarEquipoModificado = true;
        });
    });
    
    modalElement.addEventListener('hide.bs.modal', function(e) {
        if (formularioModificarEquipoEnviado) return;
        
        if (formularioModificarEquipoModificado) {
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
                    formularioModificarEquipoModificado = false;
                    formularioModificarEquipoEnviado = false;
                    modalElement.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                }
            });
        }
    });
    
    modalElement.addEventListener('hidden.bs.modal', function() {
        formularioModificarEquipoModificado = false;
        formularioModificarEquipoEnviado = false;
        currentStepEditEquipo = 1;
        
        const loadingDiv = document.getElementById('loadingModificarEquipoData');
        const formContainer = document.getElementById('modificarEquipoFormContainer');
        
        if (loadingDiv) {
            loadingDiv.style.display = 'block';
            loadingDiv.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando datos del equipo...</p>
                </div>
            `;
        }
        if (formContainer) formContainer.style.display = 'none';
    });
}

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando modal de modificar equipo...');
    
    const btnGuardar = document.getElementById('edit_equipo_submitBtn');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            submitEditEquipoForm();
        });
    }
    
    const nextBtn = document.getElementById('edit_equipo_nextBtn');
    const prevBtn = document.getElementById('edit_equipo_prevBtn');
    
    if (nextBtn) nextBtn.addEventListener('click', goToNextStepEditEquipo);
    if (prevBtn) prevBtn.addEventListener('click', goToPrevStepEditEquipo);
    
    setupEventosEditEquipo();
    setupPrevenirCierreEditEquipo();
});

window.openModificarEquipoModal = openModificarEquipoModal;