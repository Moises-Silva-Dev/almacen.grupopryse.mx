// ==================== MODAL DE REGISTRO DE CONTROL DE EQUIPOS - JS COMPLETO ====================

let equipoModal;
let formularioEquipoModificado = false;
let formularioEquipoEnviado = false;
let currentStepEquipo = 1;
const totalStepsEquipo = 3;

// ==================== FUNCIONES DE NAVEGACIÓN ====================
function updateStepIndicatorsEquipo() {
    const circles = [
        document.getElementById('equipo_stepCircle1'),
        document.getElementById('equipo_stepCircle2'),
        document.getElementById('equipo_stepCircle3')
    ];
    
    const labels = [
        document.getElementById('equipo_stepLabel1'),
        document.getElementById('equipo_stepLabel2'),
        document.getElementById('equipo_stepLabel3')
    ];
    
    const lines = [
        document.getElementById('equipo_stepLine1-2'),
        document.getElementById('equipo_stepLine2-3')
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
    
    for (let i = 0; i < currentStepEquipo - 1; i++) {
        if (circles[i]) circles[i].classList.add('completed');
        if (labels[i]) labels[i].classList.add('completed');
        if (i < lines.length && lines[i]) {
            lines[i].classList.add('completed');
        }
    }
    
    if (currentStepEquipo <= circles.length) {
        if (circles[currentStepEquipo - 1]) circles[currentStepEquipo - 1].classList.add('active');
        if (labels[currentStepEquipo - 1]) labels[currentStepEquipo - 1].classList.add('active');
        
        if (currentStepEquipo - 2 >= 0 && lines[currentStepEquipo - 2]) {
            lines[currentStepEquipo - 2].classList.add('active');
        }
    }
}

function updateStepsEquipo() {
    const step1 = document.getElementById('equipo_step1');
    const step2 = document.getElementById('equipo_step2');
    const step3 = document.getElementById('equipo_step3');
    const prevBtn = document.getElementById('equipo_prevBtn');
    const nextBtn = document.getElementById('equipo_nextBtn');
    const submitBtn = document.getElementById('equipo_submitBtn');
    
    if (step1) step1.style.display = 'none';
    if (step2) step2.style.display = 'none';
    if (step3) step3.style.display = 'none';
    
    if (currentStepEquipo === 1 && step1) step1.style.display = 'block';
    if (currentStepEquipo === 2 && step2) step2.style.display = 'block';
    if (currentStepEquipo === 3 && step3) step3.style.display = 'block';
    
    if (prevBtn) prevBtn.style.display = currentStepEquipo === 1 ? 'none' : 'inline-block';
    if (nextBtn) nextBtn.style.display = currentStepEquipo === totalStepsEquipo ? 'none' : 'inline-block';
    if (submitBtn) submitBtn.style.display = currentStepEquipo === totalStepsEquipo ? 'inline-block' : 'none';
    
    updateStepIndicatorsEquipo();
}

function goToNextStepEquipo() {
    if (validateCurrentStepEquipo()) {
        currentStepEquipo++;
        updateStepsEquipo();
        
        const modalBody = document.querySelector('#registrarEquipoModal .modal-body');
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

function goToPrevStepEquipo() {
    currentStepEquipo--;
    updateStepsEquipo();
    
    const modalBody = document.querySelector('#registrarEquipoModal .modal-body');
    if (modalBody) {
        modalBody.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function validateCurrentStepEquipo() {
    if (currentStepEquipo === 1) {
        return validateStep1Equipo();
    }
    if (currentStepEquipo === 2) {
        return validateStep2Equipo();
    }
    if (currentStepEquipo === 3) {
        return true;
    }
    return true;
}

function validateStep1Equipo() {
    const nombrePersona = document.getElementById('equipo_Nombre_Persona');
    const departamento = document.getElementById('equipo_ID_Departamento');
    
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
    
    return isValid;
}

function validateStep2Equipo() {
    const tipoPC = document.getElementById('equipo_Tipo_PC');
    const marcaEquipo = document.getElementById('equipo_Marca_Equipo');
    const sistemaOperativo = document.getElementById('equipo_Sistema_Operativo');
    const procesador = document.getElementById('equipo_Procesador');
    const tarjetaMadre = document.getElementById('equipo_Tarjeta_Madre');
    const tipoRAM = document.getElementById('equipo_Tipo_RAM');
    const capacidadRAM = document.getElementById('equipo_Capacidad_RAM');
    const marcaRAM = document.getElementById('equipo_Marca_RAM');
    const tipoDisco = document.getElementById('equipo_Tipo_Disco');
    const capacidadDisco = document.getElementById('equipo_Capacidad_Disco');
    
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
async function openEquipoModal() {
    if (!equipoModal) {
        equipoModal = new bootstrap.Modal(document.getElementById('registrarEquipoModal'));
    }
    
    const loadingDiv = document.getElementById('loadingEquipoData');
    const formContainer = document.getElementById('equipoFormContainer');
    
    if (loadingDiv) loadingDiv.style.display = 'block';
    if (formContainer) formContainer.style.display = 'none';
    
    formularioEquipoModificado = false;
    formularioEquipoEnviado = false;
    currentStepEquipo = 1;
    
    equipoModal.show();
    
    try {
        await Promise.all([
            cargarDepartamentos(),
            cargarMarcasEquipo(),
            cargarTarjetasMadre(),
            cargarMarcasRAM()
        ]);
        
        const form = document.getElementById('FormInsertControlEquipo');
        if (form) {
            form.reset();
            document.querySelectorAll('#registrarEquipoModal .is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
        }
        
        updateStepsEquipo();
        
        if (loadingDiv) loadingDiv.style.display = 'none';
        if (formContainer) formContainer.style.display = 'block';
        
    } catch (error) {
        console.error('Error al cargar datos:', error);
        if (loadingDiv) {
            loadingDiv.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar los datos: ${error.message}
                </div>
                <button class="btn btn-navy mt-3" onclick="openEquipoModal()">
                    <i class="fas fa-redo me-1"></i> Reintentar
                </button>
                <button class="btn btn-secondary mt-3 ms-2" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cerrar
                </button>
            `;
        }
    }
}

// ==================== CARGAR DEPARTAMENTOS ====================
async function cargarDepartamentos() {
    const deptoSelect = document.getElementById('equipo_ID_Departamento');
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
                deptoSelect.innerHTML += `<option value="${depto.Id}">${escapeHtmlEquipo(depto.Nombre_Departamento)}</option>`;
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

// ==================== CARGAR MARCAS DE EQUIPO ====================
async function cargarMarcasEquipo() {
    const marcaSelect = document.getElementById('equipo_Marca_Equipo');
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
                marcaSelect.innerHTML += `<option value="${escapeHtmlEquipo(marca)}">${escapeHtmlEquipo(marca)}</option>`;
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

// ==================== CARGAR TARJETAS MADRE ====================
async function cargarTarjetasMadre() {
    const tmSelect = document.getElementById('equipo_Tarjeta_Madre');
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
                tmSelect.innerHTML += `<option value="${escapeHtmlEquipo(tarjeta)}">${escapeHtmlEquipo(tarjeta)}</option>`;
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

// ==================== CARGAR MARCAS DE RAM ====================
async function cargarMarcasRAM() {
    const ramSelect = document.getElementById('equipo_Marca_RAM');
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
                ramSelect.innerHTML += `<option value="${escapeHtmlEquipo(marca)}">${escapeHtmlEquipo(marca)}</option>`;
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

// ==================== CONFIGURAR EVENTOS ESPECIALES ====================
function setupEventosEquipo() {
    // Mostrar/ocultar campo de tarjeta gráfica
    const chkGrafica = document.getElementById('equipo_Tiene_Grafica_Dedicada');
    const graficaDiv = document.getElementById('equipo_Datos_Grafica_Div');
    
    if (chkGrafica) {
        chkGrafica.addEventListener('change', function() {
            formularioEquipoModificado = true;
            graficaDiv.style.display = this.checked ? 'block' : 'none';
            const graficaInput = document.getElementById('equipo_Datos_Tarjeta_Grafica');
            if (!this.checked && graficaInput) {
                graficaInput.value = '';
            }
        });
    }
    
    // Detectar cambios en todos los campos
    const form = document.getElementById('FormInsertControlEquipo');
    if (form) {
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('change', () => { formularioEquipoModificado = true; });
            input.addEventListener('input', () => { formularioEquipoModificado = true; });
        });
    }
}

// ==================== ENVÍO DEL FORMULARIO ====================
function submitEquipoForm() {
    const form = document.getElementById('FormInsertControlEquipo');
    
    if (!validateStep2Equipo()) {
        if (currentStepEquipo !== 2) {
            currentStepEquipo = 2;
            updateStepsEquipo();
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
    formularioEquipoEnviado = true;
    
    Swal.fire({
        title: 'Registrando equipo...',
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
                    title: '¡Equipo registrado!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if (equipoModal) equipoModal.hide();
                    location.reload();
                });
            } else {
                formularioEquipoEnviado = false;
                Swal.fire({ icon: 'error', title: 'Error', text: data.message, confirmButtonColor: '#001F3F' });
            }
        } catch (err) {
            formularioEquipoEnviado = false;
            Swal.fire({ icon: 'error', title: 'Error', text: 'Respuesta no válida del servidor.', confirmButtonColor: '#001F3F' });
        }
    })
    .catch(error => {
        formularioEquipoEnviado = false;
        Swal.fire({ icon: 'error', title: 'Error de conexión', text: 'Hubo un problema al procesar la solicitud.', confirmButtonColor: '#001F3F' });
    });
}

// ==================== ESCAPE HTML ====================
function escapeHtmlEquipo(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== PREVENIR CIERRE ACCIDENTAL ====================
function setupPrevenirCierreEquipo() {
    const modalElement = document.getElementById('registrarEquipoModal');
    const form = document.getElementById('FormInsertControlEquipo');
    
    if (!modalElement || !form) return;
    
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            if (input.id !== 'datosTablaEquipo') {
                formularioEquipoModificado = true;
            }
        });
        input.addEventListener('input', () => {
            if (input.id !== 'datosTablaEquipo') {
                formularioEquipoModificado = true;
            }
        });
    });
    
    modalElement.addEventListener('hide.bs.modal', function(e) {
        if (formularioEquipoEnviado) return;
        
        if (formularioEquipoModificado) {
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
                    formularioEquipoModificado = false;
                    formularioEquipoEnviado = false;
                    modalElement.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                }
            });
        }
    });
    
    modalElement.addEventListener('hidden.bs.modal', function() {
        formularioEquipoModificado = false;
        formularioEquipoEnviado = false;
        currentStepEquipo = 1;
        
        const loadingDiv = document.getElementById('loadingEquipoData');
        const formContainer = document.getElementById('equipoFormContainer');
        
        if (loadingDiv) {
            loadingDiv.style.display = 'block';
            loadingDiv.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando datos...</p>
                </div>
            `;
        }
        if (formContainer) formContainer.style.display = 'none';
    });
}

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando modal de control de equipos...');
    
    const btnGuardar = document.getElementById('equipo_submitBtn');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            submitEquipoForm();
        });
    }
    
    const nextBtn = document.getElementById('equipo_nextBtn');
    const prevBtn = document.getElementById('equipo_prevBtn');
    
    if (nextBtn) nextBtn.addEventListener('click', goToNextStepEquipo);
    if (prevBtn) prevBtn.addEventListener('click', goToPrevStepEquipo);
    
    setupEventosEquipo();
    setupPrevenirCierreEquipo();
});

window.openEquipoModal = openEquipoModal;