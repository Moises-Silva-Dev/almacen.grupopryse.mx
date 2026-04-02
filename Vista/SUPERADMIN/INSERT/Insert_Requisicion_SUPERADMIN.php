<!-- CSS Personalizado -->
<link rel="stylesheet" href="../../css/formulario_registro_usuario.css">

<!-- Modal para Registrar Requisición -->
<div class="modal fade" id="registrarRequisicionModal" tabindex="-1" aria-labelledby="registrarRequisicionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title" id="registrarRequisicionModalLabel">
                    <i class="fas fa-pen-alt me-2"></i>
                    Registrar Requisición
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div id="loadingRequisicionData" class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando datos...</p>
                </div>
                
                <div id="RequisicionFormContainer" style="display: none;">
                    <form id="FormInsertRequisicionNueva" action="../../../Controlador/Usuarios/INSERT/Funcion_Insert_Requisicion.php" method="POST" novalidate>
                        <input type="hidden" id="datosTabla" name="datosTabla">
                        
                        <!-- Sistema de navegación por círculos -->
                        <div class="step-indicator-container">
                            <div class="step-indicator">
                                <div class="step-circle" id="Req_stepCircle1">
                                    <span class="step-number">1</span>
                                    <i class="fas fa-check step-check"></i>
                                </div>
                                <div class="step-line" id="Req_stepLine1-2"></div>
                                <div class="step-circle" id="Req_stepCircle2">
                                    <span class="step-number">2</span>
                                    <i class="fas fa-check step-check"></i>
                                </div>
                                <div class="step-line" id="Req_stepLine2-3"></div>
                                <div class="step-circle" id="Req_stepCircle3">
                                    <span class="step-number">3</span>
                                    <i class="fas fa-check step-check"></i>
                                </div>
                            </div>
                            <div class="step-labels">
                                <div class="step-label" id="Req_stepLabel1">
                                    <i class="fas fa-info-circle"></i>
                                    <span>Información General</span>
                                </div>
                                <div class="step-label" id="Req_stepLabel2">
                                    <i class="fas fa-boxes"></i>
                                    <span>Seleccionar Producto</span>
                                </div>
                                <div class="step-label" id="Req_stepLabel3">
                                    <i class="fas fa-list"></i>
                                    <span>Confirmar Productos</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- PASO 1: Información General -->
                        <div id="Req_step1" class="form-step">
                            <div class="card border-navy mb-4">
                                <div class="card-header bg-light text-navy">
                                    <i class="fas fa-info-circle me-2 text-turquoise"></i>
                                    Datos de la Requisición
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="Req_Supervisor" class="form-label text-navy">
                                                <i class="fas fa-user-tie me-1 text-turquoise"></i>
                                                Supervisor *
                                            </label>
                                            <input type="text" class="form-control border-navy" id="Req_Supervisor" name="Supervisor" 
                                                   placeholder="Ingresa el nombre del supervisor"
                                                   onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32)" 
                                                   required>
                                            <div class="invalid-feedback">
                                                Por favor, ingresa el nombre del supervisor.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="Req_ID_Cuenta" class="form-label text-navy">
                                                <i class="fas fa-building me-1 text-turquoise"></i>
                                                Cuenta *
                                            </label>
                                            <select class="form-select border-navy" id="Req_ID_Cuenta" name="ID_Cuenta" required>
                                                <option value="" selected disabled>-- Cargando cuentas... --</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona una cuenta.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="Req_Region" class="form-label text-navy">
                                                <i class="fas fa-map-marker-alt me-1 text-turquoise"></i>
                                                Región *
                                            </label>
                                            <select class="form-select border-navy" id="Req_Region" name="Region" required>
                                                <option value="" selected disabled>-- Seleccionar Región --</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona una región.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="Req_CentroTrabajo" class="form-label text-navy">
                                                <i class="fas fa-briefcase me-1 text-turquoise"></i>
                                                Centro de Trabajo
                                            </label>
                                            <input type="text" class="form-control border-navy" id="Req_CentroTrabajo" name="CentroTrabajo" 
                                                   placeholder="Ingresa el centro de trabajo">
                                            <div class="invalid-feedback">
                                                Por favor, ingresa el centro de trabajo.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="Req_NroElementos" class="form-label text-navy">
                                                <i class="fas fa-hashtag me-1 text-turquoise"></i>
                                                Número de Elementos *
                                            </label>
                                            <input type="text" class="form-control border-navy" id="Req_NroElementos" name="NroElementos" 
                                                   placeholder="Ingresa el número de elementos" 
                                                   onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" 
                                                   required>
                                            <div class="invalid-feedback">
                                                Por favor, ingresa el número de elementos.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="Req_Estado" class="form-label text-navy">
                                                <i class="fas fa-city me-1 text-turquoise"></i>
                                                Estado *
                                            </label>
                                            <select class="form-select border-navy" id="Req_Estado" name="Estado" required>
                                                <option value="" selected disabled>-- Seleccionar Estado --</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona un estado.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="Req_Receptor" class="form-label text-navy">
                                                <i class="fas fa-user-check me-1 text-turquoise"></i>
                                                Nombre del Receptor *
                                            </label>
                                            <input type="text" class="form-control border-navy" id="Req_Receptor" name="Receptor" 
                                                   placeholder="Ingresa el nombre del receptor"
                                                   onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32)" 
                                                   required>
                                            <div class="invalid-feedback">
                                                Por favor, ingresa el nombre del receptor.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="Req_num_tel" class="form-label text-navy">
                                                <i class="fas fa-phone me-1 text-turquoise"></i>
                                                Teléfono del Receptor *
                                            </label>
                                            <input type="tel" class="form-control border-navy" id="Req_num_tel" name="num_tel" 
                                                   placeholder="Ingresa el teléfono" maxlength="10"
                                                   onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" 
                                                   required>
                                            <div class="invalid-feedback">
                                                Por favor, ingresa un teléfono válido (10 dígitos).
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="Req_RFC" class="form-label text-navy">
                                                <i class="fas fa-id-card me-1 text-turquoise"></i>
                                                RFC del Receptor
                                            </label>
                                            <input type="text" class="form-control border-navy" id="Req_RFC" name="RFC" 
                                                   placeholder="Ingresa el RFC" maxlength="13">
                                            <div class="invalid-feedback">
                                                Por favor, ingresa el RFC.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="Req_Opcion" class="form-label text-navy">
                                                <i class="fas fa-truck me-1 text-turquoise"></i>
                                                ¿Enviar a Domicilio? *
                                            </label>
                                            <select class="form-select border-navy" id="Req_Opcion" name="Opcion" required>
                                                <option value="" selected disabled>-- Seleccionar Opción --</option>
                                                <option value="SI">Sí</option>
                                                <option value="NO">No</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona una opción.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row" id="Req_DireccionDiv" style="display: none;">
                                        <div class="col-md-12">
                                            <div class="card border-navy">
                                                <div class="card-header bg-light text-navy">
                                                    <i class="fas fa-location-dot me-2 text-turquoise"></i>
                                                    Dirección de Envío
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="Req_Mpio" class="form-label text-navy">Municipio</label>
                                                            <input type="text" class="form-control border-navy" id="Req_Mpio" name="Mpio" placeholder="Ingresa el municipio">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="Req_Colonia" class="form-label text-navy">Colonia</label>
                                                            <input type="text" class="form-control border-navy" id="Req_Colonia" name="Colonia" placeholder="Ingresa la colonia">
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="Req_Calle" class="form-label text-navy">Calle</label>
                                                            <input type="text" class="form-control border-navy" id="Req_Calle" name="Calle" placeholder="Ingresa la calle">
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="Req_Nro" class="form-label text-navy">Número</label>
                                                            <input type="text" class="form-control border-navy" id="Req_Nro" name="Nro" placeholder="Ingresa el número">
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="Req_CP" class="form-label text-navy">Código Postal</label>
                                                            <input type="text" class="form-control border-navy" id="Req_CP" name="CP" placeholder="Código postal" maxlength="5">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="Req_Justificacion" class="form-label text-navy">
                                                <i class="fas fa-comment me-1 text-turquoise"></i>
                                                Justificación *
                                            </label>
                                            <textarea class="form-control border-navy" id="Req_Justificacion" name="Justificacion" 
                                                      rows="3" placeholder="Ingresa la justificación de la requisición" required></textarea>
                                            <div class="invalid-feedback">
                                                Por favor, ingresa la justificación.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- PASO 2: Seleccionar Producto -->
                        <div id="Req_step2" class="form-step" style="display: none;">
                            <div class="card border-navy mb-4">
                                <div class="card-header bg-light text-navy">
                                    <i class="fas fa-box-open me-2 text-turquoise"></i>
                                    Datos del Producto
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-5 mb-3">
                                            <label for="Req_ID_Producto" class="form-label text-navy">
                                                <i class="fas fa-barcode me-1 text-turquoise"></i>
                                                Producto *
                                            </label>
                                            <select class="form-select border-navy" id="Req_ID_Producto" name="ID_Producto[]">
                                                <option value="" selected disabled>-- Cargando productos... --</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona un producto.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3 mb-3">
                                            <label for="Req_ID_Talla" class="form-label text-navy">
                                                <i class="fas fa-ruler me-1 text-turquoise"></i>
                                                Talla *
                                            </label>
                                            <select class="form-select border-navy" id="Req_ID_Talla" name="ID_Talla[]" disabled>
                                                <option value="" selected disabled>-- Selecciona una talla --</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona una talla.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2 mb-3">
                                            <label for="Req_Cantidad" class="form-label text-navy">
                                                <i class="fas fa-hashtag me-1 text-turquoise"></i>
                                                Cantidad *
                                            </label>
                                            <input type="text" class="form-control border-navy" id="Req_Cantidad" name="Cantidad[]" 
                                                   placeholder="0" pattern="[0-9]*" inputmode="numeric">
                                            <div class="invalid-feedback">
                                                Por favor, ingresa una cantidad válida.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2 mb-3 d-flex align-items-end">
                                            <button type="button" class="btn btn-turquoise w-100" id="Req_btn_AgregarProducto">
                                                <i class="fas fa-plus me-1"></i> Agregar
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Información del Producto Seleccionado -->
                                    <div id="Req_infoProductoCard" class="mt-4" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-3 text-center">
                                                <div class="product-image-container">
                                                    <img id="Req_productoImagen" src="../../../img/Armar_Requicision.png" 
                                                         alt="Imagen del producto" class="img-fluid rounded" style="max-width: 150px; max-height: 150px;">
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <label class="text-muted small">Empresa</label>
                                                        <p class="fw-bold text-navy" id="Req_infoEmpresa">--</p>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label class="text-muted small">Categoría</label>
                                                        <p class="fw-bold text-navy" id="Req_infoCategoria">--</p>
                                                    </div>
                                                    <div class="col-md-12 mb-2">
                                                        <label class="text-muted small">Descripción</label>
                                                        <p class="fw-bold text-navy" id="Req_infoDescripcion">--</p>
                                                    </div>
                                                    <div class="col-md-12 mb-2">
                                                        <label class="text-muted small">Especificación</label>
                                                        <p class="fw-bold text-navy" id="Req_infoEspecificacion">--</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- PASO 3: Confirmar Productos -->
                        <div id="Req_step3" class="form-step" style="display: none;">
                            <div class="card border-navy mb-4">
                                <div class="card-header bg-light text-navy">
                                    <i class="fas fa-list me-2 text-turquoise"></i>
                                    Productos a Solicitar
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="Req_tablaProductos">
                                            <thead class="table-light">
                                                <tr>
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
                                            <tbody id="Req_tablaProductosBody">
                                                <!-- Productos se agregarán aquí dinámicamente -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center mt-3" id="Req_productosCount">
                                        <i class="fas fa-info-circle me-1 text-muted"></i>
                                        <span class="text-muted">No hay productos agregados</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botones de navegación -->
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary" id="Req_prevBtn" style="display: none;">
                                <i class="fas fa-arrow-left me-1"></i> Anterior
                            </button>
                            <div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i> Cancelar
                                </button>
                                <button type="button" class="btn btn-navy" id="Req_nextBtn">
                                    Siguiente <i class="fas fa-arrow-right ms-1"></i>
                                </button>
                                <button type="button" class="btn btn-primary" id="Req_submitBtn" style="display: none;">
                                    <i class="fas fa-save me-1"></i> Guardar Requisicion
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

<script type="module" src="../../../js/Formularios/Formulario_Insertar_Requisicion.js" defer></script>