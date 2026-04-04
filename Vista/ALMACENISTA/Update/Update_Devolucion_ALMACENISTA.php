<!-- CSS Personalizado -->
<link rel="stylesheet" href="../../css/formulario_registro_usuario.css">

<!-- Modal para Modificar Devolución -->
<div class="modal fade" id="modificarDevolucionModal" tabindex="-1" aria-labelledby="modificarDevolucionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title" id="modificarDevolucionModalLabel">
                    <i class="fas fa-edit me-2"></i>
                    Modificar Devolución
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div id="loadingModificarDevolucionData" class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando datos de la devolución...</p>
                </div>
                
                <div id="modificarDevolucionFormContainer" style="display: none;">
                    <form id="FormUpdateDevolucion" action="../../../Controlador/Usuarios/UPDATE/Funcion_Update_Devolucion.php" method="post" novalidate>
                        <input type="hidden" name="id" id="edit_dev_id">
                        <input type="hidden" id="datosTablaUpdateDevolucion" name="datosTablaUpdateDevolucion">
                        
                        <!-- Sistema de navegación por círculos -->
                        <div class="step-indicator-container">
                            <div class="step-indicator">
                                <div class="step-circle" id="edit_dev_stepCircle1">
                                    <span class="step-number">1</span>
                                    <i class="fas fa-check step-check"></i>
                                </div>
                                <div class="step-line" id="edit_dev_stepLine1-2"></div>
                                <div class="step-circle" id="edit_dev_stepCircle2">
                                    <span class="step-number">2</span>
                                    <i class="fas fa-check step-check"></i>
                                </div>
                                <div class="step-line" id="edit_dev_stepLine2-3"></div>
                                <div class="step-circle" id="edit_dev_stepCircle3">
                                    <span class="step-number">3</span>
                                    <i class="fas fa-check step-check"></i>
                                </div>
                            </div>
                            <div class="step-labels">
                                <div class="step-label" id="edit_dev_stepLabel1">
                                    <i class="fas fa-info-circle"></i>
                                    <span>Información General</span>
                                </div>
                                <div class="step-label" id="edit_dev_stepLabel2">
                                    <i class="fas fa-boxes"></i>
                                    <span>Seleccionar Producto</span>
                                </div>
                                <div class="step-label" id="edit_dev_stepLabel3">
                                    <i class="fas fa-list"></i>
                                    <span>Confirmar Productos</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- PASO 1: Información General -->
                        <div id="edit_dev_step1" class="form-step">
                            <div class="card border-navy mb-4">
                                <div class="card-header bg-light text-navy">
                                    <i class="fas fa-info-circle me-2 text-turquoise"></i>
                                    Datos de la Devolución
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="edit_dev_Tipo" class="form-label text-navy">
                                                <i class="fas fa-question-circle me-1 text-turquoise"></i>
                                                Tipo de Solicitud <strong style="color: red;">*</strong>
                                            </label>
                                            <select class="form-select border-navy" id="edit_dev_Tipo" name="Tipo" required>
                                                <option value="" selected disabled>-- Seleccionar Opción --</option>
                                                <option value="Requisicion">Requisición</option>
                                                <option value="Prestamo">Préstamo</option>
                                                <option value="NO">Ninguna</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona una opción.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3" id="edit_dev_SolicitudDiv" style="display: none;">
                                            <label for="edit_dev_IdReferencia" class="form-label text-navy">
                                                <i class="fas fa-hashtag me-1 text-turquoise"></i>
                                                ID de Requisición o Préstamo
                                            </label>
                                            <input type="text" class="form-control border-navy" id="edit_dev_IdReferencia" name="IdReferencia" 
                                                   placeholder="Ingresa el ID" onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;">
                                            <div class="invalid-feedback">
                                                Por favor, ingresa el ID de referencia.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="edit_dev_Nombre_Devuelve" class="form-label text-navy">
                                                <i class="fas fa-user me-1 text-turquoise"></i>
                                                Nombre de quien Devuelve <strong style="color: red;">*</strong>
                                            </label>
                                            <input type="text" class="form-control border-navy" id="edit_dev_Nombre_Devuelve" name="Nombre_Devuelve" 
                                                   placeholder="Ingresa el nombre de quien devuelve"
                                                   onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 32)" 
                                                   required>
                                            <div class="invalid-feedback">
                                                Por favor, ingresa el nombre de quien devuelve.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="edit_dev_Telefono_Devuelve" class="form-label text-navy">
                                                <i class="fas fa-phone me-1 text-turquoise"></i>
                                                Teléfono de quien Devuelve <strong style="color: red;">*</strong>
                                            </label>
                                            <input type="tel" class="form-control border-navy" id="edit_dev_Telefono_Devuelve" name="Telefono_Devuelve" 
                                                   placeholder="Ingresa el teléfono" maxlength="10"
                                                   onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" 
                                                   required>
                                            <div class="invalid-feedback">
                                                Por favor, ingresa un teléfono válido (10 dígitos).
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="edit_dev_Justificacion" class="form-label text-navy">
                                                <i class="fas fa-comment me-1 text-turquoise"></i>
                                                Justificación <strong style="color: red;">*</strong>
                                            </label>
                                            <textarea class="form-control border-navy" id="edit_dev_Justificacion" name="Justificacion" 
                                                      rows="3" placeholder="Ingresa la justificación de la devolución" required></textarea>
                                            <div class="invalid-feedback">
                                                Por favor, ingresa la justificación.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- PASO 2: Seleccionar Producto -->
                        <div id="edit_dev_step2" class="form-step" style="display: none;">
                            <div class="card border-navy mb-4">
                                <div class="card-header bg-light text-navy">
                                    <i class="fas fa-box-open me-2 text-turquoise"></i>
                                    Datos del Producto
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-5 mb-3">
                                            <label for="edit_dev_ID_Producto" class="form-label text-navy">
                                                <i class="fas fa-barcode me-1 text-turquoise"></i>
                                                Producto 
                                            </label>
                                            <select class="form-select border-navy" id="edit_dev_ID_Producto" name="ID_Producto[]">
                                                <option value="" selected disabled>-- Cargando productos... --</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona un producto.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3 mb-3">
                                            <label for="edit_dev_ID_Talla" class="form-label text-navy">
                                                <i class="fas fa-ruler me-1 text-turquoise"></i>
                                                Talla 
                                            </label>
                                            <select class="form-select border-navy" id="edit_dev_ID_Talla" name="ID_Talla[]" disabled>
                                                <option value="" selected disabled>-- Selecciona una talla --</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona una talla.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2 mb-3">
                                            <label for="edit_dev_Cantidad" class="form-label text-navy">
                                                <i class="fas fa-hashtag me-1 text-turquoise"></i>
                                                Cantidad 
                                            </label>
                                            <input type="text" class="form-control border-navy" id="edit_dev_Cantidad" name="Cantidad[]" 
                                                   placeholder="0" pattern="[0-9]*" inputmode="numeric">
                                            <div class="invalid-feedback">
                                                Por favor, ingresa una cantidad válida.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2 mb-3 d-flex align-items-end">
                                            <button type="button" class="btn btn-turquoise w-100" id="edit_dev_btn_AgregarProducto">
                                                <i class="fas fa-plus me-1"></i> Agregar
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Información del Producto Seleccionado -->
                                    <div id="edit_dev_infoProductoCard" class="mt-4" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-3 text-center">
                                                <div class="product-image-container">
                                                    <img id="edit_dev_productoImagen" src="../../../img/Armar_Requicision.png" 
                                                         alt="Imagen del producto" class="img-fluid rounded" style="max-width: 150px; max-height: 150px;">
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <label class="text-muted small">Empresa</label>
                                                        <p class="fw-bold text-navy" id="edit_dev_infoEmpresa">--</p>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label class="text-muted small">Categoría</label>
                                                        <p class="fw-bold text-navy" id="edit_dev_infoCategoria">--</p>
                                                    </div>
                                                    <div class="col-md-12 mb-2">
                                                        <label class="text-muted small">Descripción</label>
                                                        <p class="fw-bold text-navy" id="edit_dev_infoDescripcion">--</p>
                                                    </div>
                                                    <div class="col-md-12 mb-2">
                                                        <label class="text-muted small">Especificación</label>
                                                        <p class="fw-bold text-navy" id="edit_dev_infoEspecificacion">--</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- PASO 3: Confirmar Productos -->
                        <div id="edit_dev_step3" class="form-step" style="display: none;">
                            <div class="card border-navy mb-4">
                                <div class="card-header bg-light text-navy">
                                    <i class="fas fa-list me-2 text-turquoise"></i>
                                    Productos a Devolver
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="edit_dev_tablaProductos">
                                            <thead class="table-light">
                                                应用
                                                    <th width="50">#</th>
                                                    <th>Código</th>
                                                    <th>Empresa</th>
                                                    <th>Categoría</th>
                                                    <th>Descripción</th>
                                                    <th>Especificación</th>
                                                    <th>Talla</th>
                                                    <th>Cantidad</th>
                                                    <th width="80">Acción</th>
                                                 </tr>
                                            </thead>
                                            <tbody id="edit_dev_tablaProductosBody">
                                                <!-- Productos se cargarán dinámicamente -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center mt-3" id="edit_dev_productosCount">
                                        <i class="fas fa-info-circle me-1 text-muted"></i>
                                        <span class="text-muted">No hay productos agregados</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botones de navegación -->
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary" id="edit_dev_prevBtn" style="display: none;">
                                <i class="fas fa-arrow-left me-1"></i> Anterior
                            </button>
                            <div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i> Cancelar
                                </button>
                                <button type="button" class="btn btn-navy" id="edit_dev_nextBtn">
                                    Siguiente <i class="fas fa-arrow-right ms-1"></i>
                                </button>
                                <button type="button" class="btn btn-primary" id="edit_dev_submitBtn" style="display: none;">
                                    <i class="fas fa-save me-1"></i> Guardar Cambios
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos para el indicador de pasos */
.step-indicator-container {
    margin-bottom: 2rem;
    padding: 1rem 0;
}

.step-indicator {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}

.step-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: #e9ecef;
    border: 3px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    transition: all 0.3s ease;
    z-index: 1;
}

.step-circle.active {
    border-color: var(--color-turquoise);
    background-color: var(--color-turquoise);
    box-shadow: 0 0 0 5px rgba(64, 224, 208, 0.2);
}

.step-circle.completed {
    border-color: #28a745;
    background-color: #28a745;
}

.step-number {
    font-size: 1.2rem;
    font-weight: bold;
    color: #6c757d;
    transition: all 0.3s ease;
}

.step-circle.active .step-number {
    color: var(--color-navy);
}

.step-circle.completed .step-number {
    display: none;
}

.step-check {
    font-size: 1.2rem;
    color: white;
    display: none;
}

.step-circle.completed .step-check {
    display: block;
}

.step-line {
    flex: 1;
    height: 3px;
    background-color: #dee2e6;
    margin: 0 0.5rem;
    transition: all 0.3s ease;
}

.step-line.active {
    background-color: var(--color-turquoise);
}

.step-line.completed {
    background-color: #28a745;
}

.step-labels {
    display: flex;
    justify-content: space-between;
    max-width: 500px;
    margin: 0 auto;
}

.step-label {
    text-align: center;
    flex: 1;
    font-size: 0.85rem;
    color: #6c757d;
    transition: all 0.3s ease;
}

.step-label i {
    display: block;
    font-size: 1.2rem;
    margin-bottom: 0.3rem;
}

.step-label.active {
    color: var(--color-turquoise);
    font-weight: 600;
}

.step-label.completed {
    color: #28a745;
}

@keyframes pulse {
    0% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(64, 224, 208, 0.4);
    }
    70% {
        transform: scale(1.05);
        box-shadow: 0 0 0 10px rgba(64, 224, 208, 0);
    }
    100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(64, 224, 208, 0);
    }
}

.step-circle.active {
    animation: pulse 1.5s infinite;
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

.product-image-container {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 10px;
    display: inline-block;
}

@media (max-width: 768px) {
    .step-circle {
        width: 40px;
        height: 40px;
    }
    
    .step-number, .step-check {
        font-size: 1rem;
    }
    
    .step-label {
        font-size: 0.7rem;
    }
    
    .step-label i {
        font-size: 1rem;
    }
    
    .step-line {
        margin: 0 0.25rem;
    }
}

@media (max-width: 576px) {
    .step-label span {
        display: none;
    }
    
    .step-label i {
        font-size: 1.2rem;
        margin-bottom: 0;
    }
}
</style>

<!-- JS -->
<script src="../../../js/Formularios/Formulario_Actualizar_Devolucion.js"></script>