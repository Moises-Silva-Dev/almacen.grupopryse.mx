// ==================== REGISTRO DE USUARIO - MODAL COMPLETO ====================
document.addEventListener('DOMContentLoaded', function() {
    
    // ==================== VARIABLES GLOBALES ====================
    let currentStep = 1;
    const totalSteps = 3;
    
    // Elementos de los pasos
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const step3 = document.getElementById('step3');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    
    // Elementos para la gestión de cuentas
    const tipoSelect = document.getElementById('ID_Tipo');
    const cuentaSelect = document.getElementById('Seleccionar_ID_Cuenta');
    const addCuentaButton = document.getElementById('BtnAddCuenta');
    const cuentasTable = document.getElementById('cuentaTable').querySelector('tbody');
    const datosTablaCuenta = document.getElementById('DatosTablaInsertCuentaUsuario');
    const cuentaContainer = document.getElementById('cuenta-container');
    
    // Array para almacenar cuentas seleccionadas
    let cuentasSeleccionadas = [];
    
    // Tipos de usuario que NO requieren cuenta (ajusta según tus necesidades)
    const noCuentaRequired = [1, 2, 5, 6];
    
    // ==================== CARGAR TIPOS DE USUARIO VÍA FETCH ====================
    async function cargarTiposUsuario() {
        if (!tipoSelect) return;
        
        try {
            // Mostrar loading en el select
            tipoSelect.innerHTML = '<option value="" selected disabled>⏳ Cargando tipos de usuario...</option>';
            tipoSelect.disabled = true;
            
            const response = await fetch('../../../Controlador/GET/Formulario/getTiposUsuario.php');
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            
            if (data.success && data.data && data.data.length > 0) {
                // Limpiar select y agregar opciones
                tipoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Tipo de Usuario --</option>';
                
                data.data.forEach(tipo => {
                    tipoSelect.innerHTML += `<option value="${tipo.id}">${escapeHtml(tipo.nombre)}</option>`;
                });
                
                tipoSelect.disabled = false;
            } else {
                tipoSelect.innerHTML = '<option value="" selected disabled>-- No hay tipos de usuario disponibles --</option>';
                tipoSelect.disabled = true;
                console.warn('No se encontraron tipos de usuario');
            }
            
        } catch (error) {
            console.error('Error al cargar tipos de usuario:', error);
            tipoSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar tipos de usuario</option>';
            tipoSelect.disabled = true;
            
            // Mostrar notificación de error
            Swal.fire({
                icon: 'error',
                title: 'Error de carga',
                text: 'No se pudieron cargar los tipos de usuario. Por favor, recarga la página.',
                confirmButtonColor: '#001F3F'
            });
        }
    }
    
    // ==================== CARGAR CUENTAS VÍA FETCH ====================
    async function cargarCuentas() {
        if (!cuentaSelect) return;
        
        try {
            // Mostrar loading en el select
            cuentaSelect.innerHTML = '<option value="" selected disabled>⏳ Cargando cuentas...</option>';
            cuentaSelect.disabled = true;
            
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
                
                cuentaSelect.disabled = false;
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
    
    // ==================== FUNCIONES DE NAVEGACIÓN POR CÍRCULOS ====================
    function updateStepIndicators() {
        // Elementos de los círculos
        const circles = [
            document.getElementById('stepCircle1'),
            document.getElementById('stepCircle2'),
            document.getElementById('stepCircle3')
        ];
        
        const labels = [
            document.getElementById('stepLabel1'),
            document.getElementById('stepLabel2'),
            document.getElementById('stepLabel3')
        ];
        
        const lines = [
            document.getElementById('stepLine1-2'),
            document.getElementById('stepLine2-3')
        ];
        
        // Resetear todos los estados
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
        
        // Marcar círculos completados (anteriores al actual)
        for (let i = 0; i < currentStep - 1; i++) {
            if (circles[i]) circles[i].classList.add('completed');
            if (labels[i]) labels[i].classList.add('completed');
            if (i < lines.length && lines[i]) {
                lines[i].classList.add('completed');
            }
        }
        
        // Marcar círculo actual como activo
        if (currentStep <= circles.length) {
            if (circles[currentStep - 1]) circles[currentStep - 1].classList.add('active');
            if (labels[currentStep - 1]) labels[currentStep - 1].classList.add('active');
            
            // Activar la línea anterior si existe
            if (currentStep - 2 >= 0 && lines[currentStep - 2]) {
                lines[currentStep - 2].classList.add('active');
            }
        }
    }
    
    function updateSteps() {
        // Ocultar todos los pasos
        if (step1) step1.style.display = 'none';
        if (step2) step2.style.display = 'none';
        if (step3) step3.style.display = 'none';
        
        // Mostrar el paso actual
        if (currentStep === 1 && step1) step1.style.display = 'block';
        if (currentStep === 2 && step2) step2.style.display = 'block';
        if (currentStep === 3 && step3) step3.style.display = 'block';
        
        // Actualizar botones
        if (prevBtn) prevBtn.style.display = currentStep === 1 ? 'none' : 'inline-block';
        if (nextBtn) nextBtn.style.display = currentStep === totalSteps ? 'none' : 'inline-block';
        if (submitBtn) submitBtn.style.display = currentStep === totalSteps ? 'inline-block' : 'none';
        
        // Actualizar indicadores de pasos (círculos)
        updateStepIndicators();
    }
    
    function goToNextStep() {
        if (validateCurrentStep()) {
            currentStep++;
            updateSteps();
            
            // Scroll suave al inicio del modal
            const modalBody = document.querySelector('#registroUsuarioModal .modal-body');
            if (modalBody) {
                modalBody.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
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
    
    function goToPrevStep() {
        currentStep--;
        updateSteps();
        
        // Scroll suave al inicio del modal
        const modalBody = document.querySelector('#registroUsuarioModal .modal-body');
        if (modalBody) {
            modalBody.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    }
    
    // ==================== VALIDACIONES ====================
    function validateCurrentStep() {
        if (currentStep === 1) {
            return validateStep1();
        }
        
        if (currentStep === 2) {
            return validateStep2();
        }
        
        if (currentStep === 3) {
            return validateStep3();
        }
        
        return true;
    }
    
    function validateStep1() {
        const nombre = document.getElementById('nombre');
        const apellidoPaterno = document.getElementById('apellido_paterno');
        const numTel = document.getElementById('num_tel');
        const numSOS = document.getElementById('num_contacto_sos');
        const email = document.getElementById('correo_electronico');
        
        let isValid = true;
        
        if (!nombre || !nombre.value.trim()) {
            if (nombre) nombre.classList.add('is-invalid');
            isValid = false;
        } else {
            if (nombre) nombre.classList.remove('is-invalid');
        }
        
        if (!apellidoPaterno || !apellidoPaterno.value.trim()) {
            if (apellidoPaterno) apellidoPaterno.classList.add('is-invalid');
            isValid = false;
        } else {
            if (apellidoPaterno) apellidoPaterno.classList.remove('is-invalid');
        }
        
        if (!numTel || !numTel.value.trim() || numTel.value.length !== 10) {
            if (numTel) numTel.classList.add('is-invalid');
            isValid = false;
        } else {
            if (numTel) numTel.classList.remove('is-invalid');
        }
        
        if (!numSOS || !numSOS.value.trim() || numSOS.value.length !== 10) {
            if (numSOS) numSOS.classList.add('is-invalid');
            isValid = false;
        } else {
            if (numSOS) numSOS.classList.remove('is-invalid');
        }
        
        if (!email || !email.value.trim() || !email.value.includes('@')) {
            if (email) email.classList.add('is-invalid');
            isValid = false;
        } else {
            if (email) email.classList.remove('is-invalid');
        }
        
        return isValid;
    }
    
    function validateStep2() {
        const password = document.getElementById('contrasena');
        const confirmPassword = document.getElementById('valcontrasena');
        const errorDiv = document.getElementById('passwordMatchError');
        
        let isValid = true;
        
        if (!password) return false;
        
        // Validar contraseña
        const hasLength = password.value.length >= 8;
        const hasUppercase = /[A-Z]/.test(password.value);
        const hasLowercase = /[a-z]/.test(password.value);
        const hasNumber = /[0-9]/.test(password.value);
        const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password.value);
        
        if (!hasLength || !hasUppercase || !hasLowercase || !hasNumber || !hasSpecial) {
            password.classList.add('is-invalid');
            isValid = false;
        } else {
            password.classList.remove('is-invalid');
        }
        
        // Validar que las contraseñas coincidan
        if (confirmPassword && password.value !== confirmPassword.value) {
            confirmPassword.classList.add('is-invalid');
            if (errorDiv) errorDiv.style.display = 'block';
            isValid = false;
        } else {
            if (confirmPassword) confirmPassword.classList.remove('is-invalid');
            if (errorDiv) errorDiv.style.display = 'none';
        }
        
        return isValid;
    }
    
    function validateStep3() {
        const tipoUsuario = document.getElementById('ID_Tipo');
        let isValid = true;
        
        if (!tipoUsuario || !tipoUsuario.value) {
            if (tipoUsuario) tipoUsuario.classList.add('is-invalid');
            isValid = false;
        } else {
            if (tipoUsuario) tipoUsuario.classList.remove('is-invalid');
        }
        
        // Validar cuentas si el tipo de usuario requiere
        if (tipoUsuario && tipoUsuario.value) {
            const tipo = parseInt(tipoUsuario.value);
            if (!noCuentaRequired.includes(tipo) && cuentasSeleccionadas.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cuentas requeridas',
                    text: 'Por favor, selecciona al menos una cuenta para este usuario.',
                    confirmButtonColor: '#001F3F'
                });
                isValid = false;
            }
        }
        
        return isValid;
    }
    
    // ==================== VALIDACIÓN DE CONTRASEÑA EN TIEMPO REAL ====================
    const passwordInput = document.getElementById('contrasena');
    const requirements = {
        length: document.getElementById('length'),
        uppercase: document.getElementById('uppercase'),
        lowercase: document.getElementById('lowercase'),
        number: document.getElementById('number'),
        special: document.getElementById('special')
    };
    
    function validatePassword() {
        if (!passwordInput) return;
        
        const password = passwordInput.value;
        
        const hasLength = password.length >= 8;
        const hasUppercase = /[A-Z]/.test(password);
        const hasLowercase = /[a-z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
        
        updateRequirement(requirements.length, hasLength);
        updateRequirement(requirements.uppercase, hasUppercase);
        updateRequirement(requirements.lowercase, hasLowercase);
        updateRequirement(requirements.number, hasNumber);
        updateRequirement(requirements.special, hasSpecial);
        
        return hasLength && hasUppercase && hasLowercase && hasNumber && hasSpecial;
    }
    
    function updateRequirement(element, isValid) {
        if (!element) return;
        
        if (isValid) {
            element.classList.add('valid');
            element.classList.remove('invalid', 'text-muted');
            element.innerHTML = '<i class="fas fa-check-circle me-1" style="font-size: 0.8rem;"></i> ' + element.textContent.trim();
        } else {
            element.classList.add('invalid', 'text-muted');
            element.classList.remove('valid');
            element.innerHTML = '<i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> ' + element.textContent.trim();
        }
    }
    
    if (passwordInput) {
        passwordInput.addEventListener('input', validatePassword);
    }
    
    // ==================== TOGGLE CONTRASEÑA ====================
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const password = document.getElementById('contrasena');
            if (password) {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            }
        });
    }
    
    if (toggleConfirmPassword) {
        toggleConfirmPassword.addEventListener('click', function() {
            const password = document.getElementById('valcontrasena');
            if (password) {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            }
        });
    }
    
    // ==================== GESTIÓN DE CUENTAS ====================
    function actualizarDatosTablaCuenta() {
        if (datosTablaCuenta) {
            datosTablaCuenta.value = JSON.stringify(cuentasSeleccionadas);
        }
    }
    
    // Evento cuando cambia el tipo de usuario
    if (tipoSelect) {
        tipoSelect.addEventListener('change', async () => {
            const tipo = parseInt(tipoSelect.value);
        
            if (noCuentaRequired.includes(tipo)) {
                if (cuentaContainer) cuentaContainer.style.display = 'none';
                if (cuentaSelect) cuentaSelect.required = false;
            } else {
                if (cuentaContainer) cuentaContainer.style.display = 'block';
                if (cuentaSelect) cuentaSelect.required = true;
                
                // Cargar cuentas si es necesario (tipo 3 o 4)
                if (tipo === 3 || tipo === 4) {
                    await cargarCuentas();
                }
            }
        });
    }
    
    // Evento para agregar cuenta
    if (addCuentaButton) {
        addCuentaButton.addEventListener('click', function () {
            if (!cuentaSelect) return;
            
            const selectedCuenta = cuentaSelect.options[cuentaSelect.selectedIndex];
            
            if (selectedCuenta && selectedCuenta.value !== "") {
                const cuentaId = selectedCuenta.value;
                const cuentaNombre = selectedCuenta.text;
        
                const cuentaExiste = cuentasSeleccionadas.some(cuenta => cuenta.cuentaId === cuentaId);
                
                if (!cuentaExiste) {
                    if (cuentasTable) {
                        const newRow = cuentasTable.insertRow();
                        newRow.innerHTML = `
                            <td>${cuentaId}</td>
                            <td>${escapeHtml(cuentaNombre)}</td>
                            <td><button type="button" class="btn btn-danger btn-sm removeCuenta">Eliminar</button></td>
                        `;
        
                        cuentasSeleccionadas.push({ cuentaId: cuentaId, cuentaNombre: cuentaNombre });
                        actualizarDatosTablaCuenta();
        
                        newRow.querySelector('.removeCuenta').addEventListener('click', function () {
                            newRow.remove();
                            cuentasSeleccionadas = cuentasSeleccionadas.filter(cuenta => cuenta.cuentaId !== cuentaId);
                            actualizarDatosTablaCuenta();
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cuenta duplicada',
                        text: 'Esta cuenta ya ha sido agregada.',
                        confirmButtonColor: '#001F3F'
                    });
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Selecciona una cuenta',
                    text: 'Por favor, selecciona una cuenta antes de agregar.',
                    confirmButtonColor: '#001F3F'
                });
            }
        });
    }
    
    // ==================== VALIDACIÓN EN TIEMPO REAL DE CAMPOS ====================
    function addRealTimeValidation() {
        const fields = document.querySelectorAll('#step1 input, #step2 input, #step3 select, #step3 input');
        
        fields.forEach(field => {
            field.addEventListener('change', function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });
            
            field.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });
        });
        
        // Validación específica para confirmar contraseña en tiempo real
        const confirmPassword = document.getElementById('valcontrasena');
        const password = document.getElementById('contrasena');
        
        if (confirmPassword && password) {
            confirmPassword.addEventListener('input', function() {
                if (this.value === password.value) {
                    this.classList.remove('is-invalid');
                    const errorDiv = document.getElementById('passwordMatchError');
                    if (errorDiv) errorDiv.style.display = 'none';
                } else {
                    this.classList.add('is-invalid');
                    const errorDiv = document.getElementById('passwordMatchError');
                    if (errorDiv) errorDiv.style.display = 'block';
                }
            });
        }
    }
    
    // ==================== ENVÍO DEL FORMULARIO ====================
    const form = document.getElementById('FormInsertUsuarioNuevo');
    
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            
            // Validar último paso antes de enviar
            if (!validateStep3()) {
                // Si el paso 3 no es válido, mostrar el paso 3
                if (currentStep !== 3) {
                    currentStep = 3;
                    updateSteps();
                }
                return;
            }
            
            const formData = new FormData(e.target);
            
            // Mostrar loading
            Swal.fire({
                title: 'Guardando usuario...',
                text: 'Por favor, espera un momento.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            fetch(e.target.action, {
                method: e.target.method,
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Registro exitoso!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // Cerrar el modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('registroUsuarioModal'));
                        if (modal) modal.hide();
                        
                        // Recargar la página o redirigir
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            window.location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Ocurrió un error al registrar el usuario.',
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
    
    // ==================== FUNCIÓN DE ESCAPE HTML ====================
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // ==================== EVENTOS DE LOS BOTONES ====================
    if (nextBtn) {
        nextBtn.addEventListener('click', goToNextStep);
    }
    
    if (prevBtn) {
        prevBtn.addEventListener('click', goToPrevStep);
    }
    
    if (submitBtn) {
        submitBtn.addEventListener('click', function() {
            if (validateStep3()) {
                if (form) form.dispatchEvent(new Event('submit'));
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: 'Por favor, revisa todos los campos del formulario.',
                    confirmButtonColor: '#001F3F'
                });
            }
        });
    }
    
    // ==================== LIMPIAR FORMULARIO AL CERRAR MODAL ====================
    const modal = document.getElementById('registroUsuarioModal');
    
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            if (form) form.reset();
            cuentasSeleccionadas = [];
            if (cuentasTable) cuentasTable.innerHTML = '';
            actualizarDatosTablaCuenta();
            currentStep = 1;
            updateSteps();
            
            // Limpiar validaciones
            document.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
            
            // Resetear requisitos de contraseña
            if (passwordInput) {
                passwordInput.value = '';
                validatePassword();
            }
            
            const confirmPassword = document.getElementById('valcontrasena');
            if (confirmPassword) confirmPassword.value = '';
            
            // Recargar tipos de usuario al abrir el modal (opcional)
            // cargarTiposUsuario();
        });
        
        // Cargar tipos de usuario cuando se abre el modal
        modal.addEventListener('shown.bs.modal', function() {
            cargarTiposUsuario();
        });
    }
    
    // ==================== INICIALIZACIÓN ====================
    function init() {
        updateSteps();
        if (passwordInput) validatePassword();
        addRealTimeValidation();
        
        // Cargar tipos de usuario al inicio
        cargarTiposUsuario();
    }
    
    init();
});