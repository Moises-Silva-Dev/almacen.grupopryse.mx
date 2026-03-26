<!-- CSS Personalizado -->
<link rel="stylesheet" href="../../css/formulario_registro_usuario.css">

<!-- Modal de Edición de Usuario -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title" id="editarUsuarioModalLabel">
                    <i class="fas fa-user-edit me-2"></i>
                    Editar Usuario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div id="loadingUserData" class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando datos del usuario...</p>
                </div>
                
                <div id="editFormContainer" style="display: none;">
                    <form id="FormUpdateUsuario" class="needs-validation" action="../../../Controlador/Usuarios/UPDATE/Funcion_Update_Usuario.php" method="post" enctype="multipart/form-data" novalidate>
                        <input type="hidden" name="id" id="edit_id">
                        
                        <!-- Información Básica -->
                        <div class="card border-navy mb-4">
                            <div class="card-header bg-light text-navy">
                                <h6 class="mb-0">
                                    <i class="fas fa-user-circle me-2 text-turquoise"></i>
                                    Información Personal
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="edit_nombre" class="form-label text-navy">
                                            <i class="fas fa-user me-1 text-turquoise"></i> Nombre <strong style="color: red;">*</strong>
                                        </label>
                                        <input type="text" class="form-control border-navy" id="edit_nombre" name="nombre" required>
                                        <div class="invalid-feedback">Por favor, ingresa el Nombre.</div>
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="edit_apellido_paterno" class="form-label text-navy">
                                            <i class="fas fa-user-tag me-1 text-turquoise"></i> Apellido Paterno <strong style="color: red;">*</strong>
                                        </label>
                                        <input type="text" class="form-control border-navy" id="edit_apellido_paterno" name="apellido_paterno" required>
                                        <div class="invalid-feedback">Por favor, ingresa el Apellido Paterno.</div>
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="edit_apellido_materno" class="form-label text-navy">
                                            <i class="fas fa-user-tag me-1 text-turquoise"></i> Apellido Materno 
                                        </label>
                                        <input type="text" class="form-control border-navy" id="edit_apellido_materno" name="apellido_materno">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="edit_num_tel" class="form-label text-navy">
                                            <i class="fas fa-phone me-1 text-turquoise"></i> Número de Teléfono <strong style="color: red;">*</strong>
                                        </label>
                                        <input type="tel" class="form-control border-navy" id="edit_num_tel" name="num_tel" 
                                               maxlength="10" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                                        <div class="invalid-feedback">Por favor, ingresa un número de teléfono válido (10 dígitos).</div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="edit_num_contacto_sos" class="form-label text-navy">
                                            <i class="fas fa-ambulance me-1 text-turquoise"></i> Número de Contacto SOS <strong style="color: red;">*</strong>
                                        </label>
                                        <input type="tel" class="form-control border-navy" id="edit_num_contacto_sos" name="num_contacto_sos" 
                                               maxlength="10" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                                        <div class="invalid-feedback">Por favor, ingresa un número de contacto válido (10 dígitos).</div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="edit_correo_electronico" class="form-label text-navy">
                                            <i class="fas fa-envelope me-1 text-turquoise"></i> Correo Electrónico <strong style="color: red;">*</strong>
                                        </label>
                                        <input type="email" class="form-control border-navy" id="edit_correo_electronico" name="correo_electronico" required>
                                        <div class="invalid-feedback">Por favor, ingresa un correo electrónico válido.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Cambio de Contraseña -->
                        <div class="card border-navy mb-4">
                            <div class="card-header bg-light text-navy">
                                <h6 class="mb-0">
                                    <i class="fas fa-lock me-2 text-turquoise"></i>
                                    Cambiar Contraseña
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="edit_opcion" class="form-label text-navy">
                                        <i class="fas fa-question-circle me-1 text-turquoise"></i> ¿Deseas cambiar la contraseña? <strong style="color: red;">*</strong>
                                    </label>
                                    <select class="form-select border-navy" id="edit_opcion" name="Opcion">
                                        <option value="" selected disabled>-- Seleccionar Opción --</option>
                                        <option value="NO">No, mantener contraseña actual</option>
                                        <option value="SI">Sí, cambiar contraseña</option>
                                    </select>
                                    <div class="invalid-feedback" id="edit_opcionError">Por favor, selecciona una opción.</div>
                                </div>
                                
                                <div id="edit_contrasenaContainer" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="edit_contrasena" class="form-label text-navy">
                                                <i class="fas fa-key me-1 text-turquoise"></i> Nueva Contraseña <strong style="color: red;">*</strong>
                                            </label>
                                            <div class="input-group">
                                                <input type="password" class="form-control border-navy" id="edit_contrasena" name="contrasena" placeholder="Ingresa la nueva contraseña">
                                                <button class="btn btn-outline-secondary border-navy" type="button" id="edit_togglePassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <ul class="requirements mt-2">
                                                <li id="edit_length">✓ Mínimo 8 caracteres</li>
                                                <li id="edit_uppercase">✓ Una letra mayúscula</li>
                                                <li id="edit_lowercase">✓ Letras minúsculas</li>
                                                <li id="edit_number">✓ Números</li>
                                                <li id="edit_special">✓ Símbolos</li>
                                            </ul>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="edit_valcontrasena" class="form-label text-navy">
                                                <i class="fas fa-check-circle me-1 text-turquoise"></i> Confirmar Nueva Contraseña <strong style="color: red;">*</strong>
                                            </label>
                                            <div class="input-group">
                                                <input type="password" class="form-control border-navy" id="edit_valcontrasena" name="valcontrasena" placeholder="Confirma la nueva contraseña">
                                                <button class="btn btn-outline-secondary border-navy" type="button" id="edit_toggleConfirmPassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <div class="invalid-feedback" id="edit_passwordMatchError">
                                                Las contraseñas no coinciden.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botones -->
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos para el modal de edición */
.card.border-navy {
    border: 1px solid var(--color-navy);
}

.requirements li {
    font-size: 0.8rem;
    color: #6c757d;
    list-style: none;
    margin-bottom: 0.25rem;
}

.requirements li.valid {
    color: #28a745;
}

.requirements li.invalid {
    color: #dc3545;
}

/* Spinner de carga */
.spinner-border.text-turquoise {
    color: var(--color-turquoise) !important;
}
</style>

<!-- Scripts -->
<script src="../../../js/Formularios/Formulario_Actualizar_Usuario.js"></script>