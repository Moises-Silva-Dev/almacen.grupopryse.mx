<!-- CSS Personalizado -->
<link rel="stylesheet" href="../../../css/formulario_registro_usuario.css">

<!-- Modal para Registrar Producto -->
<div class="modal fade" id="registrarProductoModal" tabindex="-1" aria-labelledby="registrarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title" id="registrarProductoModalLabel">
                    <i class="fas fa-box-open me-2"></i>
                    Registrar Nuevo Producto
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form id="FormInsertProductoNuevo" action="../../../Controlador/Usuarios/INSERT/Funcion_Insert_Producto.php" method="post" enctype="multipart/form-data" novalidate>
                    <!-- Empresa -->
                    <div class="mb-4">
                        <label for="IdCEmpresa" class="form-label text-navy">
                            <i class="fas fa-building me-1 text-turquoise"></i>
                            Empresa <strong style="color: red;">*</strong>
                        </label>
                        <select class="form-select border-navy" id="IdCEmpresa" name="IdCEmpresa" required>
                            <option value="" selected disabled>-- Cargando empresas... --</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, selecciona una empresa.
                        </div>
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle me-1"></i>
                            Selecciona una empresa existente o agrega una nueva
                        </small>
                    </div>
                    
                    <!-- Div para nueva empresa (oculto inicialmente) -->
                    <div id="nuevoEmpresaDiv" class="card border-navy mb-4" style="display: none;">
                        <div class="card-header bg-light text-navy">
                            <i class="fas fa-plus-circle me-2 text-turquoise"></i>
                            Nueva Empresa
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="Nombre_Empresa" class="form-label text-navy">
                                        <i class="fas fa-building me-1 text-turquoise"></i>
                                        Nombre de la Empresa *
                                    </label>
                                    <input type="text" class="form-control border-navy" id="Nombre_Empresa" name="Nombre_Empresa" 
                                        placeholder="Ej: Distribuidora del Norte"
                                        onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 32)">
                                    <div class="invalid-feedback">
                                        Por favor, ingresa el nombre de la empresa.
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="RazonSocial" class="form-label text-navy">
                                        <i class="fas fa-file-signature me-1 text-turquoise"></i>
                                        Razón Social
                                    </label>
                                    <input type="text" class="form-control border-navy" id="RazonSocial" name="RazonSocial" 
                                        placeholder="Ej: Distribuidora del Norte S.A. de C.V.">
                                    <div class="invalid-feedback">
                                        Por favor, ingresa la razón social.
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="RFC" class="form-label text-navy">
                                            <i class="fas fa-id-card me-1 text-turquoise"></i>
                                            RFC
                                        </label>
                                        <input type="text" class="form-control border-navy" id="RFC" name="RFC" 
                                            placeholder="Ej: ABC123456DEF">
                                        <div class="invalid-feedback">
                                            Por favor, ingresa el RFC.
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="RegistroPatronal" class="form-label text-navy">
                                            <i class="fas fa-registered me-1 text-turquoise"></i>
                                            Registro Patronal
                                        </label>
                                        <input type="text" class="form-control border-navy" id="RegistroPatronal" name="RegistroPatronal" 
                                            placeholder="Ej: 1234567890">
                                        <div class="invalid-feedback">
                                            Por favor, ingresa el registro patronal.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="Especif" class="form-label text-navy">
                                        <i class="fas fa-info-circle me-1 text-turquoise"></i>
                                        Especificación
                                    </label>
                                    <textarea class="form-control border-navy" id="Especif" name="Especif" 
                                            rows="2" placeholder="Información adicional de la empresa"></textarea>
                                    <div class="invalid-feedback">
                                        Por favor, ingresa la especificación.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Categoría -->
                    <div class="mb-4">
                        <label for="IdCCate" class="form-label text-navy">
                            <i class="fas fa-tags me-1 text-turquoise"></i>
                            Categoría <strong style="color: red;">*</strong>
                        </label>
                        <select class="form-select border-navy" id="IdCCate" name="IdCCate" required>
                            <option value="" selected disabled>-- Cargando categorías... --</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, selecciona una categoría.
                        </div>
                    </div>
                    
                    <!-- Descripción del Producto -->
                    <div class="mb-4">
                        <label for="Descripcion" class="form-label text-navy">
                            <i class="fas fa-align-left me-1 text-turquoise"></i>
                            Descripción del Producto <strong style="color: red;">*</strong>
                        </label>
                        <textarea class="form-control border-navy" id="Descripcion" name="Descripcion" 
                                  rows="3" placeholder="Ingresa la descripción del producto" required></textarea>
                        <div class="invalid-feedback">
                            Por favor, ingresa la descripción del producto.
                        </div>
                    </div>
                    
                    <!-- Especificación del Producto -->
                    <div class="mb-4">
                        <label for="Especificacion" class="form-label text-navy">
                            <i class="fas fa-info-circle me-1 text-turquoise"></i>
                            Especificación del Producto <strong style="color: red;">*</strong>
                        </label>
                        <textarea class="form-control border-navy" id="Especificacion" name="Especificacion" 
                                  rows="3" placeholder="Ingresa la especificación del producto" required></textarea>
                        <div class="invalid-feedback">
                            Por favor, ingresa la especificación del producto.
                        </div>
                    </div>
                    
                    <!-- Tipo de Talla -->
                    <div class="mb-4">
                        <label for="IdCTipTall" class="form-label text-navy">
                            <i class="fas fa-ruler-combined me-1 text-turquoise"></i>
                            Tipo de Talla <strong style="color: red;">*</strong>
                        </label>
                        <select class="form-select border-navy" id="IdCTipTall" name="IdCTipTall" required>
                            <option value="" selected disabled>-- Cargando tipos de talla... --</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, selecciona un tipo de talla.
                        </div>
                    </div>
                    
                    <!-- Imagen -->
                    <div class="mb-4">
                        <label for="Imagen" class="form-label text-navy">
                            <i class="fas fa-image me-1 text-turquoise"></i>
                            Imagen del Producto <strong style="color: red;">*</strong>
                        </label>
                        <input type="file" class="form-control border-navy" id="Imagen" name="Imagen" 
                               accept="image/*" required>
                        <div class="invalid-feedback">
                            Por favor, selecciona una imagen.
                        </div>
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle me-1"></i>
                            Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 5MB
                        </small>
                    </div>
                    
                    <!-- Vista previa de imagen -->
                    <div id="previewImagen" class="text-center mb-4" style="display: none;">
                        <img id="imagenPreview" src="#" alt="Vista previa" style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                    </div>
                    
                    <!-- Botones -->
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnGuardarProducto">
                            <i class="fas fa-save me-1"></i> Guardar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos específicos para el modal de producto */
#registrarProductoModal .modal-dialog {
    max-width: 800px;
}

#registrarProductoModal .form-control:focus,
#registrarProductoModal .form-select:focus {
    border-color: var(--color-turquoise);
    box-shadow: 0 0 0 0.2rem rgba(64, 224, 208, 0.25);
}

.card.border-navy {
    border: 1px solid var(--color-navy);
}

@media (max-width: 768px) {
    #registrarProductoModal .modal-dialog {
        max-width: 95%;
        margin: 0.5rem auto;
    }
}
</style>

<script src="../../../js/Formularios/Formulario_Insertar_Producto.js"></script>