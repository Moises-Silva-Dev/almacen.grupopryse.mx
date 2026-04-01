<!-- CSS Personalizado -->
<link rel="stylesheet" href="../../../css/formulario_registro_usuario.css">

<!-- Modal para Modificar Producto -->
<div class="modal fade" id="modificarProductoModal" tabindex="-1" aria-labelledby="modificarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title" id="modificarProductoModalLabel">
                    <i class="fas fa-edit me-2"></i>
                    Modificar Producto
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div id="loadingProductoData" class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando datos del producto...</p>
                </div>
                
                <div id="editProductoFormContainer" style="display: none;">
                    <form id="FormUpdateProducto" action="../../../Controlador/Usuarios/UPDATE/Funcion_Update_Producto.php" method="post" enctype="multipart/form-data" novalidate>
                        <input type="hidden" name="id" id="edit_producto_id">
                        
                        <!-- Empresa -->
                        <div class="mb-4">
                            <label for="edit_ID_Empresas" class="form-label text-navy">
                                <i class="fas fa-building me-1 text-turquoise"></i>
                                Empresa <strong style="color: red;">*</strong>
                            </label>
                            <select class="form-select border-navy" id="edit_ID_Empresas" name="ID_Empresas" required>
                                <option value="" selected disabled>-- Cargando empresas... --</option>
                            </select>
                            <div class="invalid-feedback">
                                Por favor, selecciona una empresa.
                            </div>
                        </div>
                        
                        <!-- Categoría -->
                        <div class="mb-4">
                            <label for="edit_Id_cate" class="form-label text-navy">
                                <i class="fas fa-tags me-1 text-turquoise"></i>
                                Categoría <strong style="color: red;">*</strong>
                            </label>
                            <select class="form-select border-navy" id="edit_Id_cate" name="Id_cate" required>
                                <option value="" selected disabled>-- Cargando categorías... --</option>
                            </select>
                            <div class="invalid-feedback">
                                Por favor, selecciona una categoría.
                            </div>
                        </div>
                        
                        <!-- Tipo de Talla -->
                        <div class="mb-4">
                            <label for="edit_Id_TipTall" class="form-label text-navy">
                                <i class="fas fa-ruler-combined me-1 text-turquoise"></i>
                                Tipo de Talla <strong style="color: red;">*</strong>
                            </label>
                            <select class="form-select border-navy" id="edit_Id_TipTall" name="Id_TipTall" required>
                                <option value="" selected disabled>-- Cargando tipos de talla... --</option>
                            </select>
                            <div class="invalid-feedback">
                                Por favor, selecciona un tipo de talla.
                            </div>
                        </div>
                        
                        <!-- Descripción -->
                        <div class="mb-4">
                            <label for="edit_Descripcion" class="form-label text-navy">
                                <i class="fas fa-align-left me-1 text-turquoise"></i>
                                Descripción <strong style="color: red;">*</strong>
                            </label>
                            <textarea class="form-control border-navy" id="edit_Descripcion" name="Descripcion" 
                                      rows="3" placeholder="Ingresa la descripción del producto" required></textarea>
                            <div class="invalid-feedback">
                                Por favor, ingresa la descripción.
                            </div>
                        </div>
                        
                        <!-- Especificación -->
                        <div class="mb-4">
                            <label for="edit_Especificacion" class="form-label text-navy">
                                <i class="fas fa-info-circle me-1 text-turquoise"></i>
                                Especificación <strong style="color: red;">*</strong>
                            </label>
                            <textarea class="form-control border-navy" id="edit_Especificacion" name="Especificacion" 
                                      rows="3" placeholder="Ingresa la especificación del producto" required></textarea>
                            <div class="invalid-feedback">
                                Por favor, ingresa la especificación.
                            </div>
                        </div>
                        
                        <!-- Imagen Actual -->
                        <div class="mb-4">
                            <label class="form-label text-navy">
                                <i class="fas fa-image me-1 text-turquoise"></i>
                                Imagen Actual
                            </label>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="d-flex align-items-center gap-3">
                                        <img id="edit_imagen_actual" src="" alt="Imagen actual" style="max-width: 80px; max-height: 80px; border-radius: 8px;">
                                        <div>
                                            <p class="mb-1 text-navy" id="edit_nombre_imagen">--</p>
                                            <small class="text-muted">Archivo actual</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Opción cambiar imagen -->
                        <div class="mb-4">
                            <label for="edit_opcion" class="form-label text-navy">
                                <i class="fas fa-upload me-1 text-turquoise"></i>
                                ¿Subir nueva imagen?
                            </label>
                            <select class="form-select border-navy" id="edit_opcion" name="opcion">
                                <option value="" selected disabled>-- Selecciona una Opción --</option>
                                <option value="NO">No, mantener imagen actual</option>
                                <option value="SI">Sí, cambiar imagen</option>
                            </select>
                            <div class="invalid-feedback" id="edit_opcionError">
                                Por favor, selecciona una opción.
                            </div>
                        </div>
                        
                        <!-- Campo para nueva imagen (oculto inicialmente) -->
                        <div id="edit_campoImagen" class="mb-4" style="display: none;">
                            <label for="edit_Imagen" class="form-label text-navy">
                                <i class="fas fa-file-image me-1 text-turquoise"></i>
                                Nueva Imagen
                            </label>
                            <input type="file" class="form-control border-navy" id="edit_Imagen" name="Imagen" accept="image/*">
                            <div class="invalid-feedback">
                                Por favor, selecciona un archivo válido.
                            </div>
                            <small class="text-muted mt-1 d-block">
                                <i class="fas fa-info-circle me-1"></i>
                                Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 5MB
                            </small>
                        </div>
                        
                        <!-- Vista previa de nueva imagen -->
                        <div id="edit_previewImagen" class="text-center mb-4" style="display: none;">
                            <label class="form-label text-navy">Vista previa nueva imagen</label>
                            <div>
                                <img id="edit_imagenPreview" src="#" alt="Vista previa" style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                            </div>
                        </div>
                        
                        <!-- Botones -->
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary" id="btnGuardarEditarProducto">
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
/* Estilos específicos para el modal de modificar producto */
#modificarProductoModal .modal-dialog {
    max-width: 800px;
}

#modificarProductoModal .form-control:focus,
#modificarProductoModal .form-select:focus {
    border-color: var(--color-turquoise);
    box-shadow: 0 0 0 0.2rem rgba(64, 224, 208, 0.25);
}

.card.bg-light {
    background-color: #f8f9fa;
}

@media (max-width: 768px) {
    #modificarProductoModal .modal-dialog {
        max-width: 95%;
        margin: 0.5rem auto;
    }
}
</style>

<script src="../../../js/Formularios/Formulario_Actualizar_Producto.js"></script>