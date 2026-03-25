// ==================== MODAL DE EDICIÓN DE USUARIO - JS COMPLETO ====================

// Variable global para almacenar la instancia del modal
let editModal;

// ==================== FUNCIÓN PARA ABRIR EL MODAL ====================
async function openEditModal(userId) {
    if (!editModal) {
        editModal = new bootstrap.Modal(document.getElementById('editarUsuarioModal'));
    }
    
    // Mostrar loading
    const loadingDiv = document.getElementById('loadingUserData');
    const formContainer = document.getElementById('editFormContainer');
    
    if (loadingDiv) loadingDiv.style.display = 'block';
    if (formContainer) formContainer.style.display = 'none';
    
    editModal.show();
    
    try {
        // Cargar datos del usuario
        const userData = await fetchUserData(userId);
        
        if (userData) {
            // Llenar el formulario con los datos
            fillEditForm(userData);
            
            // Ocultar loading y mostrar formulario
            if (loadingDiv) loadingDiv.style.display = 'none';
            if (formContainer) formContainer.style.display = 'block';
        } else {
            throw new Error('No se pudieron cargar los datos del usuario');
        }
        
    } catch (error) {
        console.error('Error al cargar usuario:', error);
        if (loadingDiv) {
            loadingDiv.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar los datos del usuario. Por favor, intenta nuevamente.
                </div>
                <button class="btn btn-navy mt-3" onclick="openEditModal(${userId})">
                    <i class="fas fa-redo me-1"></i> Reintentar
                </button>
            `;
        }
    }
}

// ==================== FUNCIÓN PARA OBTENER DATOS DEL USUARIO ====================
async function fetchUserData(userId) {
    try {
        const response = await fetch(`../../../Controlador/GET/Formulario/getObtenerInfoUsuario.php?id=${userId}`);
        
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
        console.error('Error en fetchUserData:', error);
        throw error;
    }
}

// ==================== FUNCIÓN PARA LLENAR EL FORMULARIO ====================
function fillEditForm(userData) {
    document.getElementById('edit_id').value = userData.ID_Usuario || '';
    document.getElementById('edit_nombre').value = userData.Nombre || '';
    document.getElementById('edit_apellido_paterno').value = userData.Apellido_Paterno || '';
    document.getElementById('edit_apellido_materno').value = userData.Apellido_Materno || '';
    document.getElementById('edit_num_tel').value = userData.NumTel || '';
    document.getElementById('edit_num_contacto_sos').value = userData.NumContactoSOS || '';
    document.getElementById('edit_correo_electronico').value = userData.Correo_Electronico || '';
    
    // Resetear opciones de contraseña
    const opcionSelect = document.getElementById('edit_opcion');
    if (opcionSelect) {
        opcionSelect.value = '';
        opcionSelect.classList.remove('is-invalid');
    }
    
    const contrasenaContainer = document.getElementById('edit_contrasenaContainer');
    if (contrasenaContainer) contrasenaContainer.style.display = 'none';
    
    const passwordInput = document.getElementById('edit_contrasena');
    const confirmInput = document.getElementById('edit_valcontrasena');
    
    if (passwordInput) passwordInput.value = '';
    if (confirmInput) confirmInput.value = '';
    
    // Limpiar validaciones
    const errorDiv = document.getElementById('edit_opcionError');
    if (errorDiv) errorDiv.style.display = 'none';
    
    const passwordMatchError = document.getElementById('edit_passwordMatchError');
    if (passwordMatchError) passwordMatchError.style.display = 'none';
    
    // Resetear requisitos de contraseña
    resetPasswordRequirements();
}

// ==================== RESETEAR REQUISITOS DE CONTRASEÑA ====================
function resetPasswordRequirements() {
    const requirements = ['length', 'uppercase', 'lowercase', 'number', 'special'];
    requirements.forEach(req => {
        const element = document.getElementById(`edit_${req}`);
        if (element) {
            element.classList.remove('valid', 'invalid');
            const originalText = element.textContent.replace(/[✓✗]/g, '').replace(/^[✓✗]\s*/, '').trim();
            element.innerHTML = originalText;
        }
    });
}

// ==================== VALIDACIÓN DE CONTRASEÑA EN TIEMPO REAL ====================
const editPassword = document.getElementById('edit_contrasena');
const editRequirements = {
    length: document.getElementById('edit_length'),
    uppercase: document.getElementById('edit_uppercase'),
    lowercase: document.getElementById('edit_lowercase'),
    number: document.getElementById('edit_number'),
    special: document.getElementById('edit_special')
};

function validateEditPassword() {
    if (!editPassword) return true;
    
    const password = editPassword.value;
    
    const hasLength = password.length >= 8;
    const hasUppercase = /[A-Z]/.test(password);
    const hasLowercase = /[a-z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
    
    updateEditRequirement(editRequirements.length, hasLength);
    updateEditRequirement(editRequirements.uppercase, hasUppercase);
    updateEditRequirement(editRequirements.lowercase, hasLowercase);
    updateEditRequirement(editRequirements.number, hasNumber);
    updateEditRequirement(editRequirements.special, hasSpecial);
    
    // Limpiar validación si la contraseña es válida
    if (hasLength && hasUppercase && hasLowercase && hasNumber && hasSpecial) {
        editPassword.classList.remove('is-invalid');
    } else {
        // Solo marcar como inválido si hay texto y no cumple
        if (password.length > 0) {
            editPassword.classList.add('is-invalid');
        } else {
            editPassword.classList.remove('is-invalid');
        }
    }
    
    return hasLength && hasUppercase && hasLowercase && hasNumber && hasSpecial;
}

function updateEditRequirement(element, isValid) {
    if (!element) return;
    
    const originalText = element.textContent.replace(/[✓✗]/g, '').replace(/^[✓✗]\s*/, '').trim();
    
    if (isValid) {
        element.classList.add('valid');
        element.classList.remove('invalid');
        element.innerHTML = `<i class="fas fa-check-circle me-1" style="font-size: 0.8rem; color: #28a745;"></i> ${originalText}`;
    } else {
        element.classList.add('invalid');
        element.classList.remove('valid');
        element.innerHTML = `<i class="fas fa-times-circle me-1" style="font-size: 0.8rem; color: #dc3545;"></i> ${originalText}`;
    }
}

if (editPassword) {
    editPassword.addEventListener('input', validateEditPassword);
}

// ==================== CONFIRMAR CONTRASEÑA ====================
const editConfirmPassword = document.getElementById('edit_valcontrasena');
const editPasswordMatchError = document.getElementById('edit_passwordMatchError');

function validateEditPasswordMatch() {
    if (!editPassword || !editConfirmPassword) return true;
    
    const opcion = document.getElementById('edit_opcion').value;
    
    if (opcion === 'SI') {
        if (editPassword.value !== editConfirmPassword.value) {
            editConfirmPassword.classList.add('is-invalid');
            if (editPasswordMatchError) editPasswordMatchError.style.display = 'block';
            return false;
        } else {
            editConfirmPassword.classList.remove('is-invalid');
            if (editPasswordMatchError) editPasswordMatchError.style.display = 'none';
            return true;
        }
    } else {
        editConfirmPassword.classList.remove('is-invalid');
        if (editPasswordMatchError) editPasswordMatchError.style.display = 'none';
        return true;
    }
}

if (editConfirmPassword) {
    editConfirmPassword.addEventListener('input', validateEditPasswordMatch);
}

// ==================== TOGGLE CONTRASEÑA ====================
const editTogglePassword = document.getElementById('edit_togglePassword');
const editToggleConfirmPassword = document.getElementById('edit_toggleConfirmPassword');

if (editTogglePassword) {
    editTogglePassword.addEventListener('click', function() {
        const password = document.getElementById('edit_contrasena');
        if (password) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        }
    });
}

if (editToggleConfirmPassword) {
    editToggleConfirmPassword.addEventListener('click', function() {
        const password = document.getElementById('edit_valcontrasena');
        if (password) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        }
    });
}

// ==================== CAMBIO DE OPCIÓN DE CONTRASEÑA ====================
const editOpcion = document.getElementById('edit_opcion');

if (editOpcion) {
    editOpcion.addEventListener('change', function() {
        const container = document.getElementById('edit_contrasenaContainer');
        const passwordInput = document.getElementById('edit_contrasena');
        const confirmInput = document.getElementById('edit_valcontrasena');
        const opcionError = document.getElementById('edit_opcionError');
        
        // Limpiar validación del select
        this.classList.remove('is-invalid');
        if (opcionError) opcionError.style.display = 'none';
        
        if (this.value === 'SI') {
            // Mostrar campos de contraseña
            if (container) container.style.display = 'block';
            if (passwordInput) passwordInput.required = true;
            if (confirmInput) confirmInput.required = true;
            
            // Limpiar validaciones previas
            if (passwordInput) passwordInput.classList.remove('is-invalid');
            if (confirmInput) confirmInput.classList.remove('is-invalid');
            if (editPasswordMatchError) editPasswordMatchError.style.display = 'none';
            
            // Resetear requisitos de contraseña
            resetPasswordRequirements();
            
        } else if (this.value === 'NO') {
            // Ocultar campos de contraseña
            if (container) container.style.display = 'none';
            if (passwordInput) passwordInput.required = false;
            if (confirmInput) confirmInput.required = false;
            
            // Limpiar campos y validaciones
            if (passwordInput) passwordInput.value = '';
            if (confirmInput) confirmInput.value = '';
            if (passwordInput) passwordInput.classList.remove('is-invalid');
            if (confirmInput) confirmInput.classList.remove('is-invalid');
            if (editPasswordMatchError) editPasswordMatchError.style.display = 'none';
            
            // Resetear requisitos de contraseña
            resetPasswordRequirements();
        }
    });
}

// ==================== VALIDACIÓN DEL FORMULARIO COMPLETO ====================
const editForm = document.getElementById('FormUpdateUsuario');

if (editForm) {
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Obtener elementos del formulario
        const nombre = document.getElementById('edit_nombre');
        const apellido = document.getElementById('edit_apellido_paterno');
        const telefono = document.getElementById('edit_num_tel');
        const sos = document.getElementById('edit_num_contacto_sos');
        const email = document.getElementById('edit_correo_electronico');
        const opcion = document.getElementById('edit_opcion');
        
        let isValid = true;
        let errorMessage = '';
        
        // Validar nombre
        if (!nombre.value.trim()) {
            nombre.classList.add('is-invalid');
            isValid = false;
            errorMessage = 'Por favor, completa el nombre.';
        } else {
            nombre.classList.remove('is-invalid');
        }
        
        // Validar apellido paterno
        if (!apellido.value.trim()) {
            apellido.classList.add('is-invalid');
            isValid = false;
            errorMessage = 'Por favor, completa el apellido paterno.';
        } else {
            apellido.classList.remove('is-invalid');
        }
        
        // Validar teléfono
        if (!telefono.value.trim() || telefono.value.length !== 10 || !/^\d+$/.test(telefono.value)) {
            telefono.classList.add('is-invalid');
            isValid = false;
            errorMessage = 'Por favor, ingresa un número de teléfono válido (10 dígitos).';
        } else {
            telefono.classList.remove('is-invalid');
        }
        
        // Validar contacto SOS
        if (!sos.value.trim() || sos.value.length !== 10 || !/^\d+$/.test(sos.value)) {
            sos.classList.add('is-invalid');
            isValid = false;
            errorMessage = 'Por favor, ingresa un número de contacto SOS válido (10 dígitos).';
        } else {
            sos.classList.remove('is-invalid');
        }
        
        // Validar email
        if (!email.value.trim() || !email.value.includes('@') || !email.value.includes('.')) {
            email.classList.add('is-invalid');
            isValid = false;
            errorMessage = 'Por favor, ingresa un correo electrónico válido.';
        } else {
            email.classList.remove('is-invalid');
        }
        
        // Validar opción de contraseña
        if (!opcion.value) {
            opcion.classList.add('is-invalid');
            const opcionError = document.getElementById('edit_opcionError');
            if (opcionError) opcionError.style.display = 'block';
            isValid = false;
            errorMessage = 'Por favor, selecciona si deseas cambiar la contraseña.';
        } else {
            opcion.classList.remove('is-invalid');
            const opcionError = document.getElementById('edit_opcionError');
            if (opcionError) opcionError.style.display = 'none';
        }
        
        // Si la opción es "SI", validar contraseña
        if (opcion.value === 'SI') {
            const password = document.getElementById('edit_contrasena');
            const confirmPassword = document.getElementById('edit_valcontrasena');
            
            // Validar que la contraseña no esté vacía
            if (!password.value.trim()) {
                password.classList.add('is-invalid');
                isValid = false;
                errorMessage = 'Por favor, ingresa una nueva contraseña.';
            } else {
                // Validar requisitos de contraseña
                const hasLength = password.value.length >= 8;
                const hasUppercase = /[A-Z]/.test(password.value);
                const hasLowercase = /[a-z]/.test(password.value);
                const hasNumber = /[0-9]/.test(password.value);
                const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password.value);
                
                if (!hasLength || !hasUppercase || !hasLowercase || !hasNumber || !hasSpecial) {
                    password.classList.add('is-invalid');
                    isValid = false;
                    errorMessage = 'La contraseña no cumple con todos los requisitos.';
                } else {
                    password.classList.remove('is-invalid');
                }
            }
            
            // Validar que las contraseñas coincidan
            if (confirmPassword.value.trim() && password.value !== confirmPassword.value) {
                confirmPassword.classList.add('is-invalid');
                const matchError = document.getElementById('edit_passwordMatchError');
                if (matchError) matchError.style.display = 'block';
                isValid = false;
                errorMessage = 'Las contraseñas no coinciden.';
            } else if (confirmPassword.value.trim()) {
                confirmPassword.classList.remove('is-invalid');
                const matchError = document.getElementById('edit_passwordMatchError');
                if (matchError) matchError.style.display = 'none';
            } else if (opcion.value === 'SI') {
                confirmPassword.classList.add('is-invalid');
                isValid = false;
                errorMessage = 'Por favor, confirma la nueva contraseña.';
            }
        }
        
        // Si hay errores, mostrar mensaje
        if (!isValid) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: errorMessage || 'Por favor, completa todos los campos requeridos correctamente.',
                confirmButtonColor: '#001F3F'
            });
            return;
        }
        
        // Si todo está válido, enviar formulario
        const formData = new FormData(this);
        
        Swal.fire({
            title: 'Guardando cambios...',
            text: 'Por favor, espera un momento.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        fetch(this.action, {
            method: this.method,
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Actualización exitosa!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    // Cerrar el modal
                    if (editModal) editModal.hide();
                    // Recargar la página para mostrar los cambios
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Ocurrió un error al actualizar el usuario.',
                    confirmButtonColor: '#001F3F'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al procesar la solicitud.',
                confirmButtonColor: '#001F3F'
            });
            console.error('Error en la solicitud:', error);
        });
    });
}

// ==================== LIMPIAR FORMULARIO AL CERRAR MODAL ====================
const editModalElement = document.getElementById('editarUsuarioModal');

if (editModalElement) {
    editModalElement.addEventListener('hidden.bs.modal', function() {
        // Resetear loading
        const loadingDiv = document.getElementById('loadingUserData');
        const formContainer = document.getElementById('editFormContainer');
        
        if (loadingDiv) {
            loadingDiv.style.display = 'block';
            loadingDiv.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando datos del usuario...</p>
                </div>
            `;
        }
        if (formContainer) formContainer.style.display = 'none';
        
        // Resetear select de contraseña
        const opcionSelect = document.getElementById('edit_opcion');
        if (opcionSelect) {
            opcionSelect.value = '';
            opcionSelect.classList.remove('is-invalid');
        }
        
        const opcionError = document.getElementById('edit_opcionError');
        if (opcionError) opcionError.style.display = 'none';
        
        // Ocultar contenedor de contraseña
        const contrasenaContainer = document.getElementById('edit_contrasenaContainer');
        if (contrasenaContainer) contrasenaContainer.style.display = 'none';
        
        // Limpiar campos de contraseña
        const password = document.getElementById('edit_contrasena');
        const confirmPassword = document.getElementById('edit_valcontrasena');
        if (password) password.value = '';
        if (confirmPassword) confirmPassword.value = '';
        
        // Limpiar validaciones
        const fields = ['edit_nombre', 'edit_apellido_paterno', 'edit_num_tel', 
                        'edit_num_contacto_sos', 'edit_correo_electronico'];
        
        fields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) field.classList.remove('is-invalid');
        });
        
        // Limpiar mensajes de error de contraseña
        const passwordMatchError = document.getElementById('edit_passwordMatchError');
        if (passwordMatchError) passwordMatchError.style.display = 'none';
        
        // Resetear requisitos de contraseña
        resetPasswordRequirements();
    });
}

// ==================== VALIDACIÓN EN TIEMPO REAL DE CAMPOS ====================
function addRealTimeValidation() {
    const fields = [
        'edit_nombre', 'edit_apellido_paterno', 'edit_apellido_materno',
        'edit_num_tel', 'edit_num_contacto_sos', 'edit_correo_electronico'
    ];
    
    fields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });
            
            field.addEventListener('change', function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });
        }
    });
    
    // Validación específica para teléfonos
    const telefono = document.getElementById('edit_num_tel');
    if (telefono) {
        telefono.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
        });
    }
    
    const sos = document.getElementById('edit_num_contacto_sos');
    if (sos) {
        sos.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
        });
    }
}

// Inicializar validaciones en tiempo real cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    addRealTimeValidation();
});