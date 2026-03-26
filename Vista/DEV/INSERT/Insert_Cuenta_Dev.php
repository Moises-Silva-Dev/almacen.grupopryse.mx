<!-- CSS Personalizado -->
<link rel="stylesheet" href="../../css/formulario_registro_usuario.css">

<!-- Modal para Registrar Nueva Cuenta -->
<div class="modal fade" id="registrarCuentaModal" tabindex="-1" aria-labelledby="registrarCuentaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title" id="registrarCuentaModalLabel">
                    <i class="fas fa-building me-2"></i>
                    Registrar Nueva Cuenta
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form id="FormInsertCuentaNueva" action="../../../Controlador/Usuarios/INSERT/Funcion_Insert_Cuenta.php" method="post" novalidate>
                    <!-- Nombre de la Cuenta -->
                    <div class="mb-4">
                        <label for="NombreCuenta" class="form-label text-navy">
                            <i class="fas fa-building me-1 text-turquoise"></i>
                            Nombre de la Cuenta *
                        </label>
                        <input type="text" 
                            class="form-control border-navy" 
                            id="NombreCuenta" 
                            name="NombreCuenta" 
                            placeholder="Ej: Distribuidora del Norte, Almacén Central, etc."
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
                        <label for="NroElemetos" class="form-label text-navy">
                            <i class="fas fa-cubes me-1 text-turquoise"></i>
                            Número de Elementos *
                        </label>
                        <input type="number" 
                            class="form-control border-navy" 
                            id="NroElemetos" 
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
                    
                    <!-- Información Adicional (Opcional) -->
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>
                            La cuenta será registrada en el sistema y podrá ser asignada a usuarios.
                            Asegúrate de que el nombre sea descriptivo y único.
                        </small>
                    </div>
                    
                    <!-- Botones -->
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnGuardarCuenta">
                            <i class="fas fa-save me-1"></i> Guardar Cuenta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos específicos para el modal de cuenta */
#registrarCuentaModal .modal-dialog {
    max-width: 500px;
}

#registrarCuentaModal .form-control:focus {
    border-color: var(--color-turquoise);
    box-shadow: 0 0 0 0.2rem rgba(64, 224, 208, 0.25);
}

#registrarCuentaModal .alert-info {
    background-color: rgba(64, 224, 208, 0.1);
    border-color: var(--color-turquoise);
    color: var(--color-navy);
}

@media (max-width: 576px) {
    #registrarCuentaModal .modal-dialog {
        max-width: 95%;
        margin: 0.5rem auto;
    }
}
</style>

<!-- JS para validar el formulario -->
<script src="../../../js/Formularios/Formulario_Insertar_Cuenta.js"></script>