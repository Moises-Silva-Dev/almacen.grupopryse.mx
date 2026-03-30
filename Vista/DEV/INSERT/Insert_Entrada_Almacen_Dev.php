<!-- CSS Personalizado -->
<link rel="stylesheet" href="../../css/formulario_registro_usuario.css">

<!-- Modal para Registrar Entrada de Almacén -->
<div class="modal fade" id="registrarEntradaModal" tabindex="-1" aria-labelledby="registrarEntradaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title" id="registrarEntradaModalLabel">
                    <i class="fas fa-arrow-down me-2"></i>
                    Registrar Entrada de Almacén
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div id="loadingEntradaData" class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando datos...</p>
                </div>
                
                <div id="entradaFormContainer" style="display: none;">
                    <form id="FormInsertEntradaNuevo" action="../../../Controlador/Usuarios/INSERT/Funcion_Insert_Entrada_Almacen.php" method="post" enctype="multipart/form-data" novalidate>
                        <input type="hidden" id="datosTablaInsertEntrada" name="datosTablaInsertEntrada">
                        
                        <!-- Acordeón con información general -->
                        <div class="accordion mb-4" id="accordionEntrada">
                            <div class="accordion-item border-navy">
                                <h2 class="accordion-header" id="headingGeneral">
                                    <button class="accordion-button bg-light text-navy" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneral" aria-expanded="true" aria-controls="collapseGeneral">
                                        <i class="fas fa-info-circle me-2 text-turquoise"></i>
                                        Información General
                                    </button>
                                </h2>
                                <div id="collapseGeneral" class="accordion-collapse collapse show" aria-labelledby="headingGeneral" data-bs-parent="#accordionEntrada">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="Proveedor" class="form-label text-navy">
                                                    <i class="fas fa-truck me-1 text-turquoise"></i>
                                                    Nombre del Proveedor *
                                                </label>
                                                <input type="text" class="form-control border-navy" id="Proveedor" name="Proveedor" 
                                                       placeholder="Ingresa el nombre del proveedor"
                                                       onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 32)" 
                                                       required>
                                                <div class="invalid-feedback">
                                                    Por favor, ingresa el nombre del proveedor.
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="Receptor" class="form-label text-navy">
                                                    <i class="fas fa-user-check me-1 text-turquoise"></i>
                                                    Nombre del Receptor *
                                                </label>
                                                <input type="text" class="form-control border-navy" id="Receptor" name="Receptor" 
                                                       placeholder="Ingresa el nombre del receptor"
                                                       onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 32)" 
                                                       required>
                                                <div class="invalid-feedback">
                                                    Por favor, ingresa el nombre del receptor.
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12 mb-3">
                                                <label for="Comentarios" class="form-label text-navy">
                                                    <i class="fas fa-comment me-1 text-turquoise"></i>
                                                    Comentarios *
                                                </label>
                                                <textarea class="form-control border-navy" id="Comentarios" name="Comentarios" 
                                                          rows="3" placeholder="Ingresa los comentarios de la entrada" required></textarea>
                                                <div class="invalid-feedback">
                                                    Por favor, ingresa los comentarios.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-navy">
                                <h2 class="accordion-header" id="headingProductos">
                                    <button class="accordion-button collapsed bg-light text-navy" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProductos" aria-expanded="false" aria-controls="collapseProductos">
                                        <i class="fas fa-boxes me-2 text-turquoise"></i>
                                        Productos
                                    </button>
                                </h2>
                                <div id="collapseProductos" class="accordion-collapse collapse" aria-labelledby="headingProductos" data-bs-parent="#accordionEntrada">
                                    <div class="accordion-body">
                                        <!-- Selección de Producto -->
                                        <div class="card border-navy mb-4">
                                            <div class="card-header bg-light text-navy">
                                                <i class="fas fa-plus-circle me-2 text-turquoise"></i>
                                                Agregar Producto
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-5 mb-3">
                                                        <label for="ID_Producto" class="form-label text-navy">
                                                            <i class="fas fa-barcode me-1 text-turquoise"></i>
                                                            Producto *
                                                        </label>
                                                        <select class="form-select border-navy" id="ID_Producto" name="ID_Producto[]">
                                                            <option value="" selected disabled>-- Cargando productos... --</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Por favor, selecciona un producto.
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-3">
                                                        <label for="ID_Talla" class="form-label text-navy">
                                                            <i class="fas fa-ruler me-1 text-turquoise"></i>
                                                            Talla *
                                                        </label>
                                                        <select class="form-select border-navy" id="ID_Talla" name="ID_Talla[]" disabled>
                                                            <option value="" selected disabled>-- Selecciona una talla --</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Por favor, selecciona una talla.
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-2 mb-3">
                                                        <label for="Cantidad" class="form-label text-navy">
                                                            <i class="fas fa-hashtag me-1 text-turquoise"></i>
                                                            Cantidad *
                                                        </label>
                                                        <input type="text" class="form-control border-navy" id="Cantidad" name="Cantidad[]" 
                                                               placeholder="0" pattern="[0-9]*" inputmode="numeric">
                                                        <div class="invalid-feedback">
                                                            Por favor, ingresa una cantidad válida.
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-2 mb-3 d-flex align-items-end">
                                                        <button type="button" class="btn btn-turquoise w-100" id="btn_AgregarProductoEntrada">
                                                            <i class="fas fa-plus me-1"></i> Agregar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Información del Producto Seleccionado -->
                                        <div class="card border-navy mb-4" id="infoProductoCard" style="display: none;">
                                            <div class="card-header bg-light text-navy">
                                                <i class="fas fa-info-circle me-2 text-turquoise"></i>
                                                Información del Producto
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3 text-center">
                                                        <div class="product-image-container">
                                                            <img id="productoImagen" src="https://via.placeholder.com/150?text=Sin+Imagen" 
                                                                 alt="Imagen del producto" class="img-fluid rounded" style="max-width: 150px; max-height: 150px;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-2">
                                                                <label class="text-muted small">Empresa</label>
                                                                <p class="fw-bold text-navy" id="infoEmpresa">--</p>
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label class="text-muted small">Categoría</label>
                                                                <p class="fw-bold text-navy" id="infoCategoria">--</p>
                                                            </div>
                                                            <div class="col-md-12 mb-2">
                                                                <label class="text-muted small">Descripción</label>
                                                                <p class="fw-bold text-navy" id="infoDescripcion">--</p>
                                                            </div>
                                                            <div class="col-md-12 mb-2">
                                                                <label class="text-muted small">Especificación</label>
                                                                <p class="fw-bold text-navy" id="infoEspecificacion">--</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tabla de Productos Agregados -->
                        <div class="mb-4">
                            <label class="form-label text-navy">
                                <i class="fas fa-list me-1 text-turquoise"></i>
                                Productos a Registrar
                            </label>
                            <div class="table-responsive">
                                <table class="table table-hover" id="tablaProductosEntrada">
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
                                    <tbody id="tablaProductosBody">
                                        <!-- Productos se agregarán aquí dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted mt-1 d-block" id="productosCount">
                                <i class="fas fa-info-circle me-1"></i>
                                No hay productos agregados
                            </small>
                        </div>
                        
                        <!-- Botones -->
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary" id="btnGuardarEntrada">
                                <i class="fas fa-save me-1"></i> Registrar Entrada
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="tablaModal" tabindex="-1" aria-labelledby="tablaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tablaModalLabel">Lista de Productos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Buscador -->
                    <input type="text" id="buscador" class="form-control mb-3" placeholder="Buscar producto...">
                    
                    <!-- Tabla -->
                    <table class="table table-responsive table-hover table-striped">
                        <thead>
                            <tr class="table-primary">
                                <th scope="col">Identificador</th>
                                <th scope="col">Nombre de Empresa</th>
                                <th scope="col">Categoría</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Especificación</th>
                            </tr>
                        </thead>
                        <tbody id="tablaCuerpo">
                            <!-- Datos generados dinámicamente -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos específicos para el modal de entrada */
#registrarEntradaModal .modal-dialog {
    max-width: 1200px;
}

#registrarEntradaModal .accordion-button:not(.collapsed) {
    background-color: rgba(0, 31, 63, 0.05);
    color: var(--color-navy);
}

#registrarEntradaModal .accordion-button:focus {
    box-shadow: none;
    border-color: var(--color-turquoise);
}

#registrarEntradaModal .form-control:focus,
#registrarEntradaModal .form-select:focus {
    border-color: var(--color-turquoise);
    box-shadow: 0 0 0 0.2rem rgba(64, 224, 208, 0.25);
}

.product-image-container {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 10px;
    display: inline-block;
}

#productoImagen {
    transition: all 0.3s ease;
}

#productoImagen:hover {
    transform: scale(1.05);
}

#tablaProductosEntrada th {
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

#tablaProductosEntrada td {
    vertical-align: middle;
}

@media (max-width: 768px) {
    #registrarEntradaModal .modal-dialog {
        max-width: 95%;
        margin: 0.5rem auto;
    }
}
</style>

<script src="../../../js/Formularios/Formulario_Insertar_Entrada.js"></script>
<script src="../../../js/VistaTablaProductos.js"></script>