<!-- CSS Personalizado -->
<link rel="stylesheet" href="../../css/formulario_registro_usuario.css">

<!-- Modal para Modificar Cuenta -->
<div class="modal fade" id="modificarCuentaModal" tabindex="-1" aria-labelledby="modificarCuentaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title" id="modificarCuentaModalLabel">
                    <i class="fas fa-edit me-2"></i>
                    Modificar Cuenta
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div id="loadingCuentaData" class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando datos de la cuenta...</p>
                </div>
                
                <div id="editCuentaFormContainer" style="display: none;">
                    <form id="FormUpdateCuenta" action="../../../Controlador/Usuarios/UPDATE/Funcion_Update_Cuenta.php" method="post" novalidate>
                        <input type="hidden" id="edit_cuenta_id" name="ID_Cuenta">
                        
                        <!-- Nombre de la Cuenta -->
                        <div class="mb-4">
                            <label for="edit_nombre_cuenta" class="form-label text-navy">
                                <i class="fas fa-building me-1 text-turquoise"></i>
                                Nombre de la Cuenta <strong style="color: red;">*</strong>
                            </label>
                            <input type="text" 
                                class="form-control border-navy" 
                                id="edit_nombre_cuenta" 
                                name="NombreCuenta" 
                                placeholder="Ej: Distribuidora del Norte"
                                onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 32)" 
                                required>
                            <div class="invalid-feedback">
                                Por favor, ingresa el nombre de la cuenta.
                            </div>
                            <small class="text-muted mt-1 d-block">
                                <i class="fas fa-info-circle me-1"></i>
                                Solo letras y espacios
                            </small>
                        </div>
                        
                        <!-- Número de Elementos -->
                        <div class="mb-4">
                            <label for="edit_nro_elementos" class="form-label text-navy">
                                <i class="fas fa-cubes me-1 text-turquoise"></i>
                                Número de Elementos <strong style="color: red;">*</strong>
                            </label>
                            <input type="number" 
                                class="form-control border-navy" 
                                id="edit_nro_elementos" 
                                name="NroElemetos" 
                                placeholder="Ej: 100, 250, 500"
                                min="1"
                                required>
                            <div class="invalid-feedback">
                                Por favor, ingresa un número de elementos válido.
                            </div>
                            <small class="text-muted mt-1 d-block">
                                <i class="fas fa-info-circle me-1"></i>
                                Cantidad de elementos que manejará esta cuenta
                            </small>
                        </div>
                        
                        <!-- Botones -->
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary" id="btnGuardarEditarCuenta">
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
/* Estilos específicos para el modal de modificar cuenta */
#modificarCuentaModal .modal-dialog {
    max-width: 500px;
}

#modificarCuentaModal .form-control:focus {
    border-color: var(--color-turquoise);
    box-shadow: 0 0 0 0.2rem rgba(64, 224, 208, 0.25);
}

@media (max-width: 576px) {
    #modificarCuentaModal .modal-dialog {
        max-width: 95%;
        margin: 0.5rem auto;
    }
}
</style>

<script src="../../../js/Formularios/Formulario_Actualizar_Cuenta.js"></script>

<?php include('footer.php'); ?>