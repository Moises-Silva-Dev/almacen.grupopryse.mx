<!-- CSS Personalizado -->
<link rel="stylesheet" href="../../css/formulario_registro_usuario.css">

<!-- Modal para Cambiar Rol de Usuario -->
<div class="modal fade" id="cambiarRolModal" tabindex="-1" aria-labelledby="cambiarRolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title" id="cambiarRolModalLabel">
                    <i class="fas fa-user-tag me-2"></i>
                    Cambiar Rol de Usuario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <!-- Loading -->
                <div id="loadingRolData" class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando datos del usuario...</p>
                </div>
                
                <!-- Contenedor del Formulario -->
                <div id="rolFormContainer" style="display: none;">
                    <form id="FormUpdateRolUsuario" action="../../../Controlador/Usuarios/UPDATE/Funcion_Update_Rol_Usuario.php" method="post">
                        <input type="hidden" name="id" id="rol_id_usuario">
                        <input type="hidden" name="idTipoActual" id="rol_tipo_actual">
                        <input type="hidden" id="rol_DatosTablaCuenta" name="DatosTablaCuenta">
                        
                        <!-- Información del Usuario -->
                        <div class="card border-navy mb-4">
                            <div class="card-header bg-light text-navy">
                                <h6 class="mb-0">
                                    <i class="fas fa-user-circle me-2 text-turquoise"></i>
                                    Información del Usuario
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label text-navy">
                                            <i class="fas fa-user me-1 text-turquoise"></i> Usuario
                                        </label>
                                        <p class="form-control-static bg-light p-2 rounded" id="rol_nombre_usuario">--</p>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label text-navy">
                                            <i class="fas fa-tag me-1 text-turquoise"></i> Rol Actual
                                        </label>
                                        <p class="form-control-static bg-light p-2 rounded">
                                            <span id="rol_tipo_actual_nombre">--</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contenedor de Notificaciones -->
                        <div id="rol_notificationContainer" style="display: none;"></div>
                        
                        <!-- Sección para cambiar tipo de usuario -->
                        <div class="card border-navy mb-4" id="rol_seccionTipoUsuario">
                            <div class="card-header bg-light text-navy">
                                <h6 class="mb-0">
                                    <i class="fas fa-exchange-alt me-2 text-turquoise"></i>
                                    Cambiar Rol
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="rol_ID_Tipo" class="form-label text-navy">
                                        <i class="fas fa-user-tag me-1 text-turquoise"></i> Nuevo Tipo de Usuario
                                    </label>
                                    <select class="form-select border-navy" id="rol_ID_Tipo" name="ID_Tipo">
                                        <option value="" selected disabled>-- Cargando tipos de usuario... --</option>
                                    </select>
                                    <small class="text-muted mt-1 d-block">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Selecciona el nuevo rol para este usuario
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sección de cuentas (solo para tipos 3 y 4) -->
                        <div class="card border-navy mb-4" id="rol_seccionCuentas" style="display: none;">
                            <div class="card-header bg-light text-navy">
                                <h6 class="mb-0">
                                    <i class="fas fa-building me-2 text-turquoise"></i>
                                    Gestión de Cuentas
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="rol_ID_Cuenta" class="form-label text-navy">
                                        <i class="fas fa-plus-circle me-1 text-turquoise"></i> Agregar Cuenta
                                    </label>
                                    <div class="input-group">
                                        <select class="form-select border-navy" id="rol_ID_Cuenta">
                                            <option value="" selected disabled>-- Seleccionar Cuenta --</option>
                                        </select>
                                        <button class="btn btn-turquoise" type="button" id="rol_btnAgregarCuenta">
                                            <i class="fas fa-plus me-1"></i> Agregar
                                        </button>
                                    </div>
                                    <small class="text-muted mt-1 d-block">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Las cuentas que no tengan requisiciones pendientes pueden ser eliminadas
                                    </small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label text-navy">
                                        <i class="fas fa-list me-1 text-turquoise"></i> Cuentas Asociadas
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="rol_tablaCuentas">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="80">ID</th>
                                                    <th>Nombre de Cuenta</th>
                                                    <th width="120">Requisiciones</th>
                                                    <th width="100">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Las cuentas se cargarán dinámicamente -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="rol_btnCancelar">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </button>
                            <button type="button" class="btn btn-primary" id="rol_btnGuardar">
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
/* Estilos específicos para el modal de cambio de rol */
.card.border-navy {
    border: 1px solid var(--color-navy);
}

.form-control-static {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
    margin-bottom: 0;
}

.badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
}

.badge.bg-warning {
    background-color: #ffc107 !important;
    color: #000 !important;
}

.badge.bg-success {
    background-color: #28a745 !important;
}

/* Animación de carga */
.spinner-border.text-turquoise {
    color: var(--color-turquoise) !important;
}

/* Responsive */
@media (max-width: 768px) {
    .modal-lg {
        max-width: 95%;
        margin: 0.5rem auto;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
}
</style>

<!-- Scripts -->
<script src="../../../js/Formularios/Formulario_Tipo_Usuario.js"></script>