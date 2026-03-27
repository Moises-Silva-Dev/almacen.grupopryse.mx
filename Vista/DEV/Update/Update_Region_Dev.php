<!-- CSS Personalizado -->
<link rel="stylesheet" href="../../../css/formulario_registro_usuario.css">

<!-- Modal para Modificar Región -->
<div class="modal fade" id="modificarRegionModal" tabindex="-1" aria-labelledby="modificarRegionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title" id="modificarRegionModalLabel">
                    <i class="fas fa-edit me-2"></i>
                    Modificar Región
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div id="loadingRegionData" class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando datos de la región...</p>
                </div>
                
                <div id="editRegionFormContainer" style="display: none;">
                    <form id="FormUpdateRegion" action="../../../Controlador/Usuarios/UPDATE/Funcion_Update_Region.php" method="post" novalidate>
                        <input type="hidden" id="edit_region_id" name="ID_region">
                        <input type="hidden" id="datosTablaUpdateRegion" name="datosTablaUpdateRegion">
                        
                        <!-- Selección de Cuenta -->
                        <div class="mb-4">
                            <label for="edit_ID_Cuenta" class="form-label text-navy">
                                <i class="fas fa-building me-1 text-turquoise"></i>
                                Cuenta <strong style="color: red;">*</strong>
                            </label>
                            <select class="form-select border-navy" id="edit_ID_Cuenta" name="ID_Cuenta" required>
                                <option value="" selected disabled>-- Cargando cuentas... --</option>
                            </select>
                            <div class="invalid-feedback">
                                Por favor, selecciona una cuenta.
                            </div>
                        </div>
                        
                        <!-- Nombre de la Región -->
                        <div class="mb-4">
                            <label for="edit_Nombre_Region" class="form-label text-navy">
                                <i class="fas fa-map-marker-alt me-1 text-turquoise"></i>
                                Nombre de la Región <strong style="color: red;">*</strong>
                            </label>
                            <input type="text" 
                                   class="form-control border-navy" 
                                   id="edit_Nombre_Region" 
                                   name="Nombre_Region" 
                                   placeholder="Ej: Zona Norte, Región Centro"
                                   onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 32)" 
                                   required>
                            <div class="invalid-feedback">
                                Por favor, ingresa el nombre de la región.
                            </div>
                            <small class="text-muted mt-1 d-block">
                                <i class="fas fa-info-circle me-1"></i>
                                Solo letras y espacios
                            </small>
                        </div>
                        
                        <!-- Selección de Estado y Botón Agregar -->
                        <div class="mb-4">
                            <label class="form-label text-navy">
                                <i class="fas fa-city me-1 text-turquoise"></i>
                                Estados de la Región <strong style="color: red;">*</strong>
                            </label>
                            <div class="input-group">
                                <select class="form-select border-navy" id="edit_Nombre_Estado">
                                    <option value="" selected disabled>-- Cargando estados... --</option>
                                </select>
                                <button class="btn btn-turquoise" type="button" id="btn_ModificarRegionConEstado">
                                    <i class="fas fa-plus me-1"></i> Agregar Estado
                                </button>
                            </div>
                            <small class="text-muted mt-1 d-block">
                                <i class="fas fa-info-circle me-1"></i>
                                Selecciona los estados que componen esta región
                            </small>
                        </div>
                        
                        <!-- Tabla de Estados Agregados -->
                        <div class="mb-4">
                            <label class="form-label text-navy">
                                <i class="fas fa-list me-1 text-turquoise"></i>
                                Estados Agregados
                            </label>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Estado</th>
                                            <th width="100">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="edit_tablaEstadosRegiones">
                                        <!-- Los estados se cargarán dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted mt-1 d-block" id="edit_estadosCount">
                                <i class="fas fa-info-circle me-1"></i>
                                Cargando estados...
                            </small>
                        </div>
                        
                        <!-- Botones -->
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary" id="btnGuardarEditarRegion">
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
/* Estilos específicos para el modal de modificar región */
#modificarRegionModal .modal-dialog {
    max-width: 700px;
}

#modificarRegionModal .form-control:focus,
#modificarRegionModal .form-select:focus {
    border-color: var(--color-turquoise);
    box-shadow: 0 0 0 0.2rem rgba(64, 224, 208, 0.25);
}

#edit_tablaEstadosRegiones tr {
    transition: all 0.2s ease;
}

#edit_tablaEstadosRegiones tr:hover {
    background-color: rgba(0, 31, 63, 0.05);
}

@media (max-width: 768px) {
    #modificarRegionModal .modal-dialog {
        max-width: 95%;
        margin: 0.5rem auto;
    }
    
    .input-group {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .input-group select,
    .input-group button {
        width: 100%;
        border-radius: 0.375rem !important;
    }
}
</style>

<!-- Scripts -->
<script src="../../../js/Formularios/Formulario_Actualizar_Region.js"></script>