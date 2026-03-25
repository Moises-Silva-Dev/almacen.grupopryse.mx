<!-- CSS Personalizado -->
<link rel="stylesheet" href="../../css/formulario_registro_usuario.css">

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
                    <!-- Nuevo sistema de navegación por círculos -->
                    <div class="step-indicator-container">
                        <div class="step-indicator">
                            <div class="step-circle" id="stepCircle1">
                                <span class="step-number">1</span>
                                <i class="fas fa-check step-check"></i>
                            </div>
                            <div class="step-line" id="stepLine1-2"></div>
                            <div class="step-circle" id="stepCircle2">
                                <span class="step-number">2</span>
                                <i class="fas fa-check step-check"></i>
                            </div>
                            <div class="step-line" id="stepLine2-3"></div>
                            <div class="step-circle" id="stepCircle3">
                                <span class="step-number">3</span>
                                <i class="fas fa-check step-check"></i>
                            </div>
                        </div>
                        <div class="step-labels">
                            <div class="step-label" id="stepLabel1">
                                <i class="fas fa-user-circle"></i>
                                <span>Datos Personales</span>
                            </div>
                            <div class="step-label" id="stepLabel2">
                                <i class="fas fa-lock"></i>
                                <span>Seguridad</span>
                            </div>
                            <div class="step-label" id="stepLabel3">
                                <i class="fas fa-user-tag"></i>
                                <span>Rol y Cuentas</span>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 1: Datos Personales -->
                    <div id="step1" class="form-step">
                        <!-- Mantén el contenido original de step1 -->
                        <h5 class="text-navy mb-3">
                            <i class="fas fa-user-circle me-2 text-turquoise"></i>
                            Datos Personales
                        </h5>
                        <!-- ... resto del contenido ... -->
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
                        <!-- Mantén el contenido original de step2 -->
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
                        <!-- Mantén el contenido original de step3 -->
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
                                    <option value="" selected disabled>-- Cargando tipos de usuario... --</option>
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

<!-- JavaScript -->
<script src="../../../js/Formularios/Formulario_Insertar_Usuario.js"></script>