// ==================== MODAL DE REGISTRO DE CUENTA - JS COMPLETO ====================

// Variable global para el modal
let cuentaModal;
// Variable global para detectar cambios en el formulario
let formularioModificado = false;
// Variable para saber si el formulario ya fue enviado
let formularioEnviado = false;

// ==================== FUNCIÓN PARA ABRIR EL MODAL ====================
function openCuentaModal() {
    if (!cuentaModal) {
        cuentaModal = new bootstrap.Modal(document.getElementById('registrarCuentaModal'));
    }
    
    // Resetear formulario
    const form = document.getElementById('FormInsertCuentaNueva');
    if (form) {
        form.reset();
        // Limpiar validaciones
        document.querySelectorAll('#registrarCuentaModal .is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
    }
    
    // Resetear flags
    formularioModificado = false;
    formularioEnviado = false;
    
    cuentaModal.show();
}

// ==================== VALIDACIÓN DEL FORMULARIO ====================
function validarFormularioCuenta() {
    const nombreCuenta = document.getElementById('NombreCuenta');
    const nroElementos = document.getElementById('NroElemetos');
    let isValid = true;
    
    // Validar nombre de cuenta
    if (!nombreCuenta.value.trim()) {
        nombreCuenta.classList.add('is-invalid');
        isValid = false;
    } else {
        // Validar que solo contenga letras y espacios
        const nombreRegex = /^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/;
        if (!nombreRegex.test(nombreCuenta.value.trim())) {
            nombreCuenta.classList.add('is-invalid');
            const feedbackDiv = nombreCuenta.nextElementSibling;
            if (feedbackDiv && feedbackDiv.classList.contains('invalid-feedback')) {
                feedbackDiv.textContent = 'El nombre solo puede contener letras y espacios';
            }
            isValid = false;
        } else {
            nombreCuenta.classList.remove('is-invalid');
        }
    }
    
    // Validar número de elementos
    if (!nroElementos.value.trim()) {
        nroElementos.classList.add('is-invalid');
        isValid = false;
    } else {
        const valor = parseInt(nroElementos.value);
        if (isNaN(valor) || valor < 1) {
            nroElementos.classList.add('is-invalid');
            const feedbackDiv = nroElementos.nextElementSibling;
            if (feedbackDiv && feedbackDiv.classList.contains('invalid-feedback')) {
                feedbackDiv.textContent = 'Por favor, ingresa un número válido mayor a 0';
            }
            isValid = false;
        } else {
            nroElementos.classList.remove('is-invalid');
        }
    }
    
    return isValid;
}

// ==================== ENVÍO DEL FORMULARIO ====================
function submitCuentaForm() {
    const form = document.getElementById('FormInsertCuentaNueva');
    
    if (!validarFormularioCuenta()) {
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
        title: 'Guardando cuenta...',
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
                // Marcar que el formulario fue enviado exitosamente
                formularioEnviado = true;
                formularioModificado = false;
                
                Swal.fire({
                    icon: 'success',
                    title: '¡Cuenta registrada!',
                    text: data.message || 'La cuenta ha sido registrada exitosamente.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if (cuentaModal) cuentaModal.hide();
                    // Recargar la página para mostrar la nueva cuenta
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Ocurrió un error al registrar la cuenta.',
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
            text: 'Hubo un problema al procesar la solicitud: ' + error.message,
            confirmButtonColor: '#001F3F'
        });
        console.error('Error:', error);
    });
}

// ==================== VALIDACIÓN EN TIEMPO REAL ====================
function addRealTimeValidationCuenta() {
    const nombreInput = document.getElementById('NombreCuenta');
    const nroInput = document.getElementById('NroElemetos');
    
    if (nombreInput) {
        nombreInput.addEventListener('input', function() {
            // Marcar que el formulario ha sido modificado
            formularioModificado = true;
            
            if (this.value.trim()) {
                const nombreRegex = /^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]*$/;
                if (nombreRegex.test(this.value)) {
                    this.classList.remove('is-invalid');
                } else {
                    this.classList.add('is-invalid');
                    const feedbackDiv = this.nextElementSibling;
                    if (feedbackDiv && feedbackDiv.classList.contains('invalid-feedback')) {
                        feedbackDiv.textContent = 'El nombre solo puede contener letras y espacios';
                    }
                }
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }
    
    if (nroInput) {
        nroInput.addEventListener('input', function() {
            // Marcar que el formulario ha sido modificado
            formularioModificado = true;
            
            if (this.value.trim()) {
                const valor = parseInt(this.value);
                if (!isNaN(valor) && valor >= 1) {
                    this.classList.remove('is-invalid');
                } else {
                    this.classList.add('is-invalid');
                    const feedbackDiv = this.nextElementSibling;
                    if (feedbackDiv && feedbackDiv.classList.contains('invalid-feedback')) {
                        feedbackDiv.textContent = 'Ingresa un número válido mayor a 0';
                    }
                }
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }
}

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando modal de cuenta...');
    
    // Configurar evento del botón de guardar
    const btnGuardar = document.getElementById('btnGuardarCuenta');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            submitCuentaForm();
        });
    }
    
    // Validación en tiempo real
    addRealTimeValidationCuenta();
    
    // Configurar el modal
    const modalElement = document.getElementById('registrarCuentaModal');
    if (modalElement) {
        // Detectar cambios en el formulario
        const form = document.getElementById('FormInsertCuentaNueva');
        if (form) {
            // Escuchar todos los inputs del formulario
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('change', function() {
                    formularioModificado = true;
                });
                input.addEventListener('input', function() {
                    formularioModificado = true;
                });
            });
        }
        
        // Prevenir cierre si hay cambios sin guardar
        modalElement.addEventListener('hide.bs.modal', function(e) {
            // Si el formulario ya fue enviado exitosamente, cerrar sin confirmación
            if (formularioEnviado) {
                return;
            }
            
            // Si hay cambios sin guardar, mostrar confirmación
            if (formularioModificado) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Descartar cambios?',
                    text: 'Tienes cambios sin guardar. ¿Estás seguro de que quieres cerrar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, descartar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        formularioModificado = false;
                        formularioEnviado = false;
                        modalElement.classList.remove('show');
                        document.body.classList.remove('modal-open');
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) backdrop.remove();
                        
                        // Resetear el formulario
                        if (form) {
                            form.reset();
                            document.querySelectorAll('#registrarCuentaModal .is-invalid').forEach(el => {
                                el.classList.remove('is-invalid');
                            });
                        }
                    }
                });
            }
        });
        
        // Resetear flags cuando el modal se cierra correctamente
        modalElement.addEventListener('hidden.bs.modal', function() {
            formularioModificado = false;
            formularioEnviado = false;
            
            // Resetear el formulario
            if (form) {
                form.reset();
                document.querySelectorAll('#registrarCuentaModal .is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
            }
        });
    }
});

// Función global para abrir el modal
window.openCuentaModal = openCuentaModal;