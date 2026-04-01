<!-- CSS Personalizado -->
<link rel="stylesheet" href="../../css/formulario_registro_usuario.css">

<!-- Modal para Registrar Salida -->
<div class="modal fade" id="registrarSalidaModal" tabindex="-1" aria-labelledby="registrarSalidaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title" id="registrarSalidaModalLabel">
                    <i class="fas fa-box-open me-2"></i>
                    Registrar Salida de Almacén
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div id="loadingSalidaData" class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando información de la requisición...</p>
                </div>
                
                <div id="salidaFormContainer" style="display: none;">
                    <form id="FormInsertSalidaNueva" action="../../../Controlador/Usuarios/INSERT/Funcion_Insert_Salida.php" method="post" novalidate>
                        <input type="hidden" name="ID_RequisicionE" id="salida_id_requisicion">
                        <input type="hidden" id="datosTablaInsertSalida" name="datosTablaInsertSalida">
                        
                        <!-- Acordeón con información general -->
                        <div class="accordion mb-4" id="accordionSalida">
                            <div class="accordion-item border-navy">
                                <h2 class="accordion-header" id="headingSalida">
                                    <button class="accordion-button bg-light text-navy" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSalida" aria-expanded="true" aria-controls="collapseSalida">
                                        <i class="fas fa-info-circle me-2 text-turquoise"></i>
                                        Información General de la Requisición
                                    </button>
                                </h2>
                                <div id="collapseSalida" class="accordion-collapse collapse show" aria-labelledby="headingSalida" data-bs-parent="#accordionSalida">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-navy">
                                                    <i class="fas fa-building me-1 text-turquoise"></i> Cuenta
                                                </label>
                                                <input type="text" class="form-control bg-light" id="salida_cuenta" disabled>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-navy">
                                                    <i class="fas fa-user-tie me-1 text-turquoise"></i> Supervisor
                                                </label>
                                                <input type="text" class="form-control bg-light" id="salida_supervisor" disabled>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-navy">
                                                    <i class="fas fa-map-marker-alt me-1 text-turquoise"></i> Región
                                                </label>
                                                <input type="text" class="form-control bg-light" id="salida_region" disabled>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-navy">
                                                    <i class="fas fa-briefcase me-1 text-turquoise"></i> Centro de Trabajo
                                                </label>
                                                <input type="text" class="form-control bg-light" id="salida_centro_trabajo" disabled>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-navy">
                                                    <i class="fas fa-user-check me-1 text-turquoise"></i> Receptor
                                                </label>
                                                <input type="text" class="form-control bg-light" id="salida_receptor" disabled>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-navy">
                                                    <i class="fas fa-phone me-1 text-turquoise"></i> Teléfono Receptor
                                                </label>
                                                <input type="text" class="form-control bg-light" id="salida_telefono" disabled>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-navy">
                                                    <i class="fas fa-id-card me-1 text-turquoise"></i> RFC Receptor
                                                </label>
                                                <input type="text" class="form-control bg-light" id="salida_rfc" disabled>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-navy">
                                                    <i class="fas fa-map-pin me-1 text-turquoise"></i> Dirección
                                                </label>
                                                <input type="text" class="form-control bg-light" id="salida_direccion" disabled>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label text-navy">
                                                    <i class="fas fa-comment me-1 text-turquoise"></i> Justificación
                                                </label>
                                                <textarea class="form-control bg-light" id="salida_justificacion" rows="2" disabled></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tabla de productos -->
                        <div class="mb-4">
                            <label class="form-label text-navy">
                                <i class="fas fa-boxes me-1 text-turquoise"></i>
                                Productos a Entregar
                            </label>
                            <div class="table-responsive">
                                <table class="table table-hover" id="tablaProductosSalida">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" width="50">#</th>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Talla</th>
                                            <th class="text-center">Solicitado</th>
                                            <th class="text-center">Entregado</th>
                                            <th class="text-center">Faltante</th>
                                            <th class="text-center">Disponible</th>
                                            <th class="text-center">Cantidad a Entregar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablaProductosBody">
                                        <!-- Productos se cargarán dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Botones -->
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary" id="btnGuardarSalida">
                                <i class="fas fa-save me-1"></i> Registrar Salida
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos específicos para el modal de salida */
#registrarSalidaModal .modal-dialog {
    max-width: 1200px;
}

#registrarSalidaModal .accordion-button:not(.collapsed) {
    background-color: rgba(0, 31, 63, 0.05);
    color: var(--color-navy);
}

#registrarSalidaModal .accordion-button:focus {
    box-shadow: none;
    border-color: var(--color-turquoise);
}

#registrarSalidaModal .form-control:focus {
    border-color: var(--color-turquoise);
    box-shadow: 0 0 0 0.2rem rgba(64, 224, 208, 0.25);
}

#tablaProductosSalida th {
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

#tablaProductosSalida td {
    vertical-align: middle;
    text-align: center;
}

.cantidad-input {
    width: 100px;
    text-align: center;
}

.cantidad-disponible {
    font-weight: 600;
}

.disponible-bajo {
    color: #dc3545;
    font-weight: 600;
}

.disponible-normal {
    color: #28a745;
    font-weight: 600;
}

@media (max-width: 768px) {
    #registrarSalidaModal .modal-dialog {
        max-width: 95%;
        margin: 0.5rem auto;
    }
    
    .cantidad-input {
        width: 70px;
    }
}
</style>

<script src="../../../js/Formularios/Formulario_Insertar_Salida.js"></script>