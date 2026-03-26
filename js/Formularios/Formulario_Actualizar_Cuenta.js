// ==================== MODAL DE MODIFICAR CUENTA - JS COMPLETO ====================

let modificarCuentaModal;
let formularioCuentaModificado = false;
let formularioCuentaEnviado = false;

// ==================== FUNCIÓN PARA ABRIR EL MODAL ====================
async function openModificarCuentaModal(cuentaId) {
    if (!modificarCuentaModal) {
        modificarCuentaModal = new bootstrap.Modal(document.getElementById('modificarCuentaModal'));
    }
    
    const loadingDiv = document.getElementById('loadingCuentaData');
    const formContainer = document.getElementById('editCuentaFormContainer');
    
    if (loadingDiv) loadingDiv.style.display = 'block';
    if (formContainer) formContainer.style.display = 'none';
    
    formularioCuentaModificado = false;
    formularioCuentaEnviado = false;
    
    modificarCuentaModal.show();
    
    try {
        const response = await fetch(`../../../Controlador/GET/Formulario/getObtenerInfoCuenta.php?id=${cuentaId}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            document.getElementById('edit_cuenta_id').value = data.data.ID || '';
            document.getElementById('edit_nombre_cuenta').value = data.data.NombreCuenta || '';
            document.getElementById('edit_nro_elementos').value = data.data.NroElemetos || '';
            
            if (loadingDiv) loadingDiv.style.display = 'none';
            if (formContainer) formContainer.style.display = 'block';
        } else {
            throw new Error(data.message || 'No se pudieron cargar los datos');
        }
        
    } catch (error) {
        console.error('Error al cargar cuenta:', error);
        if (loadingDiv) {
            loadingDiv.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar los datos: ${error.message}
                </div>
                <button class="btn btn-navy mt-3" onclick="openModificarCuentaModal(${cuentaId})">
                    <i class="fas fa-redo me-1"></i> Reintentar
                </button>
            `;
        }
    }
}

// ==================== VALIDACIÓN DEL FORMULARIO ====================
function validarFormularioEditarCuenta() {
    const nombreCuenta = document.getElementById('edit_nombre_cuenta');
    const nroElementos = document.getElementById('edit_nro_elementos');
    let isValid = true;
    
    if (!nombreCuenta.value.trim()) {
        nombreCuenta.classList.add('is-invalid');
        isValid = false;
    } else {
        const nombreRegex = /^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/;
        if (!nombreRegex.test(nombreCuenta.value.trim())) {
            nombreCuenta.classList.add('is-invalid');
            isValid = false;
        } else {
            nombreCuenta.classList.remove('is-invalid');
        }
    }
    
    if (!nroElementos.value.trim()) {
        nroElementos.classList.add('is-invalid');
        isValid = false;
    } else {
        const valor = parseInt(nroElementos.value);
        if (isNaN(valor) || valor < 1) {
            nroElementos.classList.add('is-invalid');
            isValid = false;
        } else {
            nroElementos.classList.remove('is-invalid');
        }
    }
    
    return isValid;
}

// ==================== ENVÍO DEL FORMULARIO ====================
function submitEditarCuentaForm() {
    const form = document.getElementById('FormUpdateCuenta');
    
    if (!validarFormularioEditarCuenta()) {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Por favor, completa todos los campos requeridos correctamente.',
            confirmButtonColor: '#001F3F'
        });
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
                formularioCuentaEnviado = true;
                formularioCuentaModificado = false;
                
                Swal.fire({
                    icon: 'success',
                    title: '¡Cuenta actualizada!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if (modificarCuentaModal) modificarCuentaModal.hide();
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Ocurrió un error al actualizar.',
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
function addRealTimeValidationEditarCuenta() {
    const nombreInput = document.getElementById('edit_nombre_cuenta');
    const nroInput = document.getElementById('edit_nro_elementos');
    
    if (nombreInput) {
        nombreInput.addEventListener('input', function() {
            formularioCuentaModificado = true;
            
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
    
    if (nroInput) {
        nroInput.addEventListener('input', function() {
            formularioCuentaModificado = true;
            
            if (this.value.trim()) {
                const valor = parseInt(this.value);
                if (!isNaN(valor) && valor >= 1) {
                    this.classList.remove('is-invalid');
                } else {
                    this.classList.add('is-invalid');
                }
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }
}

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    const btnGuardar = document.getElementById('btnGuardarEditarCuenta');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            submitEditarCuentaForm();
        });
    }
    
    addRealTimeValidationEditarCuenta();
    
    const modalElement = document.getElementById('modificarCuentaModal');
    if (modalElement) {
        const form = document.getElementById('FormUpdateCuenta');
        if (form) {
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('change', () => { formularioCuentaModificado = true; });
                input.addEventListener('input', () => { formularioCuentaModificado = true; });
            });
        }
        
        modalElement.addEventListener('hide.bs.modal', function(e) {
            if (formularioCuentaEnviado) return;
            
            if (formularioCuentaModificado) {
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
                        formularioCuentaModificado = false;
                        formularioCuentaEnviado = false;
                        modalElement.classList.remove('show');
                        document.body.classList.remove('modal-open');
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) backdrop.remove();
                    }
                });
            }
        });
        
        modalElement.addEventListener('hidden.bs.modal', function() {
            formularioCuentaModificado = false;
            formularioCuentaEnviado = false;
            
            const loadingDiv = document.getElementById('loadingCuentaData');
            const formContainer = document.getElementById('editCuentaFormContainer');
            
            if (loadingDiv) {
                loadingDiv.style.display = 'block';
                loadingDiv.innerHTML = `
                    <div class="text-center py-5">
                        <div class="spinner-border text-turquoise" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-3 text-muted">Cargando datos de la cuenta...</p>
                    </div>
                `;
            }
            if (formContainer) formContainer.style.display = 'none';
        });
    }
});

// Hacer la función accesible desde el HTML (SOLO ESTA LÍNEA)
window.openModificarCuentaModal = openModificarCuentaModal;