<!-- Modal de Registro de Usuario -->
<div class="modal fade" id="registroUsuarioModal" tabindex="-1" aria-labelledby="registroUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title" id="registroUsuarioModalLabel">
                    <i class="fas fa-user-plus me-2"></i>
                    Registrar Nuevo Usuario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form id="FormInsertUsuarioNuevo" class="needs-validation" action="../../../Controlador/Usuarios/INSERT/Funcion_Insert_Usuario.php" method="post" enctype="multipart/form-data" novalidate>
                    <!-- Barra de progreso -->
                    <div class="mb-4">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-turquoise" id="formProgress" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <small class="text-muted" id="stepIndicator">Paso 1 de 3: Datos Personales</small>
                        </div>
                    </div>

                    <!-- Sección 1: Datos Personales -->
                    <div id="step1" class="form-step">
                        <h5 class="text-navy mb-3">
                            <i class="fas fa-user-circle me-2 text-turquoise"></i>
                            Datos Personales
                        </h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="nombre" class="form-label text-navy">
                                    <i class="fas fa-user me-1 text-turquoise"></i> Nombre *
                                </label>
                                <input type="text" class="form-control border-navy" id="nombre" name="nombre" 
                                       placeholder="Ingresa el Nombre" 
                                       onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 32)" 
                                       required>
                                <div class="invalid-feedback">
                                    Por favor, ingresa tu Nombre.
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="apellido_paterno" class="form-label text-navy">
                                    <i class="fas fa-user-tag me-1 text-turquoise"></i> Apellido Paterno *
                                </label>
                                <input type="text" class="form-control border-navy" id="apellido_paterno" name="apellido_paterno" 
                                       placeholder="Ingresa el Apellido Paterno" 
                                       onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 32)" 
                                       required>
                                <div class="invalid-feedback">
                                    Por favor, ingresa tu Apellido Paterno.
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="apellido_materno" class="form-label text-navy">
                                    <i class="fas fa-user-tag me-1 text-turquoise"></i> Apellido Materno
                                </label>
                                <input type="text" class="form-control border-navy" id="apellido_materno" name="apellido_materno" 
                                       placeholder="Ingresa el Apellido Materno" 
                                       onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 32)">
                                <div class="invalid-feedback">
                                    Por favor, ingresa tu Apellido Materno.
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="num_tel" class="form-label text-navy">
                                    <i class="fas fa-phone me-1 text-turquoise"></i> Número de Teléfono *
                                </label>
                                <input type="tel" class="form-control border-navy" id="num_tel" name="num_tel" 
                                       placeholder="Ingresa el Número de Teléfono" 
                                       onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" 
                                       maxlength="10" required>
                                <div class="invalid-feedback">
                                    Por favor, ingresa tu Número de Teléfono (10 dígitos).
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="num_contacto_sos" class="form-label text-navy">
                                    <i class="fas fa-ambulance me-1 text-turquoise"></i> Número de Contacto SOS *
                                </label>
                                <input type="tel" class="form-control border-navy" id="num_contacto_sos" name="num_contacto_sos" 
                                       placeholder="Ingresa el Número de Contacto (Emergencia)" 
                                       onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" 
                                       maxlength="10" required>
                                <div class="invalid-feedback">
                                    Por favor, ingresa tu Número de Contacto SOS (10 dígitos).
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="correo_electronico" class="form-label text-navy">
                                    <i class="fas fa-envelope me-1 text-turquoise"></i> Correo Electrónico *
                                </label>
                                <input type="email" class="form-control border-navy" id="correo_electronico" name="correo_electronico" 
                                       placeholder="ejemplo@empresa.com" required>
                                <div class="invalid-feedback">
                                    Por favor, ingresa un Correo Electrónico válido.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 2: Seguridad -->
                    <div id="step2" class="form-step" style="display: none;">
                        <h5 class="text-navy mb-3">
                            <i class="fas fa-lock me-2 text-turquoise"></i>
                            Seguridad
                        </h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contrasena" class="form-label text-navy">
                                    <i class="fas fa-key me-1 text-turquoise"></i> Contraseña *
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control border-navy" id="contrasena" name="contrasena" 
                                           placeholder="Ingresa la contraseña" required>
                                    <button class="btn btn-outline-secondary border-navy" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor, ingresa una contraseña válida.
                                </div>
                                
                                <!-- Requisitos de contraseña -->
                                <div class="mt-2">
                                    <small class="text-muted">Requisitos de contraseña:</small>
                                    <ul class="requirements list-unstyled mt-1">
                                        <li id="length" class="text-muted"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> Mínimo 8 caracteres</li>
                                        <li id="uppercase" class="text-muted"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> Una letra mayúscula</li>
                                        <li id="lowercase" class="text-muted"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> Letras minúsculas</li>
                                        <li id="number" class="text-muted"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> Números</li>
                                        <li id="special" class="text-muted"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> Símbolos</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="valcontrasena" class="form-label text-navy">
                                    <i class="fas fa-check-circle me-1 text-turquoise"></i> Repetir Contraseña *
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control border-navy" id="valcontrasena" name="valcontrasena" 
                                           placeholder="Repite la contraseña" required>
                                    <button class="btn btn-outline-secondary border-navy" type="button" id="toggleConfirmPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback" id="passwordMatchError">
                                    Las contraseñas no coinciden.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 3: Rol y Cuentas -->
                    <div id="step3" class="form-step" style="display: none;">
                        <h5 class="text-navy mb-3">
                            <i class="fas fa-user-tag me-2 text-turquoise"></i>
                            Rol y Cuentas
                        </h5>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="ID_Tipo" class="form-label text-navy">
                                    <i class="fas fa-user-tag me-1 text-turquoise"></i> Tipo de Usuario *
                                </label>
                                <select class="form-select border-navy" id="ID_Tipo" name="ID_Tipo" required>
                                    <option value="" selected disabled>-- Seleccionar Tipo de Usuario --</option>
                                    <?php
                                    include('../../../Modelo/Conexion.php'); 
                                    $conexion = (new Conectar())->conexion();
                                    $sql = $conexion->query("SELECT ID, Tipo_Usuario FROM Tipo_Usuarios");
                                    while ($resultado = $sql->fetch_assoc()) {
                                        echo "<option value='" . $resultado['ID'] . "'>" . $resultado['Tipo_Usuario'] . "</option>";
                                    }
                                    $conexion->close();
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Por favor, selecciona un Tipo de Usuario.
                                </div>
                            </div>
                        </div>

                        <div id="cuenta-container" class="docente-fields user-fields" style="display: none;">
                            <div class="card border-navy mt-3">
                                <div class="card-header bg-light text-navy">
                                    <i class="fas fa-building me-2 text-turquoise"></i>
                                    Asignación de Cuentas
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8 mb-3">
                                            <label for="Seleccionar_ID_Cuenta" class="form-label text-navy">Seleccionar Cuenta</label>
                                            <select class="form-select border-navy" id="Seleccionar_ID_Cuenta">
                                                <option value="" selected disabled>-- Seleccionar Cuenta --</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3 d-flex align-items-end">
                                            <button class="btn btn-turquoise w-100" type="button" id="BtnAddCuenta">
                                                <i class="fas fa-plus me-1"></i> Agregar Cuenta
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="table-responsive mt-3">
                                        <table class="table table-hover" id="cuentaTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nombre de Cuenta</th>
                                                    <th width="100">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Las cuentas se agregarán aquí dinámicamente -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <input type="hidden" id="DatosTablaInsertCuentaUsuario" name="DatosTablaInsertCuentaUsuario">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-outline-navy" id="prevBtn" style="display: none;">
                    <i class="fas fa-arrow-left me-1"></i> Anterior
                </button>
                <button type="button" class="btn btn-navy" id="nextBtn">
                    Siguiente <i class="fas fa-arrow-right ms-1"></i>
                </button>
                <button type="button" class="btn btn-primary" id="submitBtn" style="display: none;">
                    <i class="fas fa-save me-1"></i> Guardar Usuario
                </button>
            </div>
        </div>
    </div>
</div>

<!-- CSS Adicional para el Modal -->
<style>
.modal-xl {
    max-width: 900px;
}

.form-step {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Requisitos de contraseña */
.requirements li {
    font-size: 0.8rem;
    transition: all 0.3s ease;
}

.requirements li.valid {
    color: #28a745;
}

.requirements li.valid i {
    color: #28a745;
}

.requirements li.invalid {
    color: #dc3545;
}

/* Validación de campos */
.form-control:focus, .form-select:focus {
    border-color: var(--color-turquoise);
    box-shadow: 0 0 0 0.2rem rgba(64, 224, 208, 0.25);
}

.was-validated .form-control:invalid, 
.form-control.is-invalid {
    border-color: #dc3545;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.progress-bar.bg-turquoise {
    background-color: var(--color-turquoise) !important;
}

@media (max-width: 768px) {
    .modal-xl {
        max-width: 95%;
        margin: 0.5rem auto;
    }
    
    .modal-body {
        padding: 1rem;
    }
}
</style>

<!-- JavaScript para el Modal (Integrado con tu código existente) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ==================== VARIABLES GLOBALES ====================
    let currentStep = 1;
    const totalSteps = 3;
    
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const step3 = document.getElementById('step3');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    const progressBar = document.getElementById('formProgress');
    const stepIndicator = document.getElementById('stepIndicator');
    
    // Elementos para la gestión de cuentas
    const tipoSelect = document.getElementById('ID_Tipo');
    const cuentaSelect = document.getElementById('Seleccionar_ID_Cuenta');
    const addCuentaButton = document.getElementById('BtnAddCuenta');
    const cuentasTable = document.getElementById('cuentaTable').querySelector('tbody');
    const datosTablaCuenta = document.getElementById('DatosTablaInsertCuentaUsuario');
    const cuentaContainer = document.getElementById('cuenta-container');
    
    // Array para almacenar cuentas seleccionadas
    let cuentasSeleccionadas = [];
    
    // Tipos de usuario que NO requieren cuenta
    const noCuentaRequired = [1, 2, 5, 6]; // Ajusta según tus necesidades
    
    // ==================== FUNCIONES DEL FORMULARIO POR PASOS ====================
    function updateSteps() {
        // Ocultar todos los pasos
        step1.style.display = 'none';
        step2.style.display = 'none';
        step3.style.display = 'none';
        
        // Mostrar el paso actual
        if (currentStep === 1) step1.style.display = 'block';
        if (currentStep === 2) step2.style.display = 'block';
        if (currentStep === 3) step3.style.display = 'block';
        
        // Actualizar botones
        prevBtn.style.display = currentStep === 1 ? 'none' : 'inline-block';
        nextBtn.style.display = currentStep === totalSteps ? 'none' : 'inline-block';
        submitBtn.style.display = currentStep === totalSteps ? 'inline-block' : 'none';
        
        // Actualizar barra de progreso
        const progress = (currentStep / totalSteps) * 100;
        progressBar.style.width = progress + '%';
        
        // Actualizar indicador de paso
        const stepNames = ['Datos Personales', 'Seguridad', 'Rol y Cuentas'];
        stepIndicator.textContent = `Paso ${currentStep} de ${totalSteps}: ${stepNames[currentStep - 1]}`;
    }
    
    function validateCurrentStep() {
        if (currentStep === 1) {
            const nombre = document.getElementById('nombre');
            const apellidoPaterno = document.getElementById('apellido_paterno');
            const numTel = document.getElementById('num_tel');
            const numSOS = document.getElementById('num_contacto_sos');
            const email = document.getElementById('correo_electronico');
            
            let isValid = true;
            
            if (!nombre.value.trim()) {
                nombre.classList.add('is-invalid');
                isValid = false;
            } else {
                nombre.classList.remove('is-invalid');
            }
            
            if (!apellidoPaterno.value.trim()) {
                apellidoPaterno.classList.add('is-invalid');
                isValid = false;
            } else {
                apellidoPaterno.classList.remove('is-invalid');
            }
            
            if (!numTel.value.trim() || numTel.value.length !== 10) {
                numTel.classList.add('is-invalid');
                isValid = false;
            } else {
                numTel.classList.remove('is-invalid');
            }
            
            if (!numSOS.value.trim() || numSOS.value.length !== 10) {
                numSOS.classList.add('is-invalid');
                isValid = false;
            } else {
                numSOS.classList.remove('is-invalid');
            }
            
            if (!email.value.trim() || !email.value.includes('@')) {
                email.classList.add('is-invalid');
                isValid = false;
            } else {
                email.classList.remove('is-invalid');
            }
            
            return isValid;
        }
        
        if (currentStep === 2) {
            const password = document.getElementById('contrasena');
            const confirmPassword = document.getElementById('valcontrasena');
            const errorDiv = document.getElementById('passwordMatchError');
            
            let isValid = true;
            
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
            if (password.value !== confirmPassword.value) {
                confirmPassword.classList.add('is-invalid');
                errorDiv.style.display = 'block';
                isValid = false;
            } else {
                confirmPassword.classList.remove('is-invalid');
                errorDiv.style.display = 'none';
            }
            
            return isValid;
        }
        
        if (currentStep === 3) {
            const tipoUsuario = document.getElementById('ID_Tipo');
            let isValid = true;
            
            if (!tipoUsuario.value) {
                tipoUsuario.classList.add('is-invalid');
                isValid = false;
            } else {
                tipoUsuario.classList.remove('is-invalid');
            }
            
            // Validar cuentas si el tipo de usuario requiere
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
            
            return isValid;
        }
        
        return true;
    }
    
    // ==================== GESTIÓN DE CUENTAS (TU CÓDIGO EXISTENTE) ====================
    function actualizarDatosTablaCuenta() {
        datosTablaCuenta.value = JSON.stringify(cuentasSeleccionadas);
    }
    
    // Evento cuando cambia el tipo de usuario
    tipoSelect.addEventListener('change', async () => {
        const tipo = parseInt(tipoSelect.value);
    
        if (noCuentaRequired.includes(tipo)) {
            cuentaContainer.style.display = 'none';
            cuentaSelect.required = false;
        } else {
            cuentaContainer.style.display = 'block';
            cuentaSelect.required = true;

            try {
                if (tipo === 3 || tipo === 4) { 
                    let direccion = '../../../Controlador/GET/getSelectCuenta.php';
                    const response = await fetch(direccion);
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const text = await response.text();
                    try {
                        const data = JSON.parse(text);
                        cuentaSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Cuenta --</option>';
                        data.forEach(cuenta => {
                            cuentaSelect.innerHTML += `<option value="${cuenta.ID}">${cuenta.NombreCuenta}</option>`;
                        });
                    } catch (e) {
                        console.error('Error al parsear JSON:', e);
                        console.error('Respuesta del servidor:', text);
                    }
                }
            } catch (error) {
                console.error('Error en la petición:', error);
            }
        }
    });
    
    // Evento para agregar cuenta
    addCuentaButton.addEventListener('click', function () {
        const selectedCuenta = cuentaSelect.options[cuentaSelect.selectedIndex];
        
        if (selectedCuenta && selectedCuenta.value !== "") {
            const cuentaId = selectedCuenta.value;
            const cuentaNombre = selectedCuenta.text;
    
            const cuentaExiste = cuentasSeleccionadas.some(cuenta => cuenta.cuentaId === cuentaId);
            
            if (!cuentaExiste) {
                const newRow = cuentasTable.insertRow();
                newRow.innerHTML = `
                    <td>${cuentaId}</td>
                    <td>${cuentaNombre}</td>
                    <td><button type="button" class="btn btn-danger btn-sm removeCuenta">Eliminar</button></td>
                `;
    
                cuentasSeleccionadas.push({ cuentaId: cuentaId, cuentaNombre: cuentaNombre });
                actualizarDatosTablaCuenta();
    
                newRow.querySelector('.removeCuenta').addEventListener('click', function () {
                    newRow.remove();
                    cuentasSeleccionadas = cuentasSeleccionadas.filter(cuenta => cuenta.cuentaId !== cuentaId);
                    actualizarDatosTablaCuenta();
                });
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
    
    // ==================== VALIDACIÓN DE CONTRASEÑA ====================
    const passwordInput = document.getElementById('contrasena');
    const requirements = {
        length: document.getElementById('length'),
        uppercase: document.getElementById('uppercase'),
        lowercase: document.getElementById('lowercase'),
        number: document.getElementById('number'),
        special: document.getElementById('special')
    };
    
    function validatePassword() {
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
    
    passwordInput.addEventListener('input', validatePassword);
    
    // ==================== TOGGLE CONTRASEÑA ====================
    document.getElementById('togglePassword').addEventListener('click', function() {
        const password = document.getElementById('contrasena');
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
    
    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const password = document.getElementById('valcontrasena');
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
    
    // ==================== BOTONES DE NAVEGACIÓN ====================
    nextBtn.addEventListener('click', function() {
        if (validateCurrentStep()) {
            currentStep++;
            updateSteps();
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Por favor, completa todos los campos requeridos antes de continuar.',
                confirmButtonColor: '#001F3F'
            });
        }
    });
    
    prevBtn.addEventListener('click', function() {
        currentStep--;
        updateSteps();
    });
    
    // ==================== ENVÍO DEL FORMULARIO (TU CÓDIGO EXISTENTE) ====================
    document.getElementById('FormInsertUsuarioNuevo').addEventListener('submit', function (e) {
        e.preventDefault();
        
        // Validar último paso antes de enviar
        if (!validateCurrentStep()) {
            Swal.fire({
                icon: 'warning',
                title: 'Validación',
                text: 'Por favor, completa todos los campos correctamente.',
                confirmButtonColor: '#001F3F'
            });
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
                    modal.hide();
                    
                    // Recargar la página o redirigir
                    window.location.href = data.redirect;
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message,
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
    
    // ==================== INICIALIZACIÓN ====================
    submitBtn.addEventListener('click', function() {
        if (validateCurrentStep()) {
            document.getElementById('FormInsertUsuarioNuevo').dispatchEvent(new Event('submit'));
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                text: 'Por favor, revisa todos los campos del formulario.',
                confirmButtonColor: '#001F3F'
            });
        }
    });
    
    // Inicializar el paso 1
    updateSteps();
    validatePassword();
    
    // Limpiar formulario al cerrar el modal
    document.getElementById('registroUsuarioModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('FormInsertUsuarioNuevo').reset();
        cuentasSeleccionadas = [];
        cuentasTable.innerHTML = '';
        actualizarDatosTablaCuenta();
        currentStep = 1;
        updateSteps();
        // Limpiar validaciones
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
    });
});
</script>