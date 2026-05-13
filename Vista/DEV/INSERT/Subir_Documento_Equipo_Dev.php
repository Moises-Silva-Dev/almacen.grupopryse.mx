<!-- Modal para Subir Documento PDF -->
<div class="modal fade" id="subirDocumentoModal" tabindex="-1" aria-labelledby="subirDocumentoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title" id="subirDocumentoModalLabel">
                    <i class="fas fa-file-pdf me-2"></i>
                    Subir Documento PDF
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form id="FormSubirDocumento" action="../../../Controlador/GET/Subir_Documento_Equipo.php" method="post" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="Id_Equipo" id="documento_id_equipo">
                    
                    <div class="text-center mb-4">
                        <div class="pdf-icon-container">
                            <i class="fas fa-file-pdf fa-4x text-danger"></i>
                        </div>
                        <p class="text-muted mt-2">Selecciona un archivo PDF para adjuntar al equipo</p>
                    </div>
                    
                    <div class="mb-4">
                        <label for="documento_Nombre" class="form-label text-navy">
                            <i class="fas fa-tag me-1 text-turquoise"></i>
                            Nombre del Documento *
                        </label>
                        <input type="text" class="form-control border-navy" id="documento_Nombre" name="Nombre_Documento" 
                               placeholder="Ej: Factura de compra, Garantía, Manual del equipo, etc."
                               required>
                        <div class="invalid-feedback">
                            Por favor, ingresa un nombre para el documento.
                        </div>
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle me-1"></i>
                            Asigna un nombre descriptivo para identificar fácilmente el documento
                        </small>
                    </div>
                    
                    <div class="mb-4">
                        <label for="documento_Archivo" class="form-label text-navy">
                            <i class="fas fa-file-upload me-1 text-turquoise"></i>
                            Archivo PDF *
                        </label>
                        <div class="custom-file-upload">
                            <input type="file" class="form-control border-navy" id="documento_Archivo" name="documento_pdf" 
                                   accept=".pdf" required>
                            <div class="invalid-feedback">
                                Por favor, selecciona un archivo PDF válido.
                            </div>
                        </div>
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle me-1"></i>
                            Tamaño máximo: 10MB. Solo archivos PDF
                        </small>
                    </div>
                    
                    <div class="mb-4" id="documento_info_archivo" style="display: none;">
                        <div class="alert alert-info">
                            <i class="fas fa-file-pdf me-2"></i>
                            <strong>Archivo seleccionado:</strong> <span id="documento_nombre_archivo"></span>
                            <br>
                            <small id="documento_tamano_archivo"></small>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning mb-4">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Importante:</strong>
                        <ul class="mb-0 mt-2">
                            <li>El documento será almacenado de forma segura en el servidor</li>
                            <li>Podrás visualizar y descargar el documento posteriormente</li>
                            <li>Asegúrate de que el archivo no contenga información sensible no autorizada</li>
                        </ul>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnSubirDocumento">
                            <i class="fas fa-upload me-1"></i> Subir Documento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos específicos para el modal de documentos */
#subirDocumentoModal .modal-dialog {
    max-width: 550px;
}

#subirDocumentoModal .form-control:focus {
    border-color: var(--color-turquoise);
    box-shadow: 0 0 0 0.2rem rgba(64, 224, 208, 0.25);
}

#subirDocumentoModal .alert-info {
    background-color: rgba(64, 224, 208, 0.1);
    border-color: var(--color-turquoise);
    color: var(--color-navy);
}

#subirDocumentoModal .alert-warning {
    background-color: rgba(255, 193, 7, 0.1);
    border-color: #ffc107;
    color: #856404;
}

#subirDocumentoModal .alert-warning ul {
    padding-left: 1.2rem;
}

#subirDocumentoModal .alert-warning li {
    margin-bottom: 0.25rem;
}

.pdf-icon-container {
    background-color: rgba(220, 53, 69, 0.1);
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.custom-file-upload input[type="file"] {
    padding: 0.5rem;
    cursor: pointer;
}

.custom-file-upload input[type="file"]::file-selector-button {
    background-color: var(--color-turquoise);
    color: var(--color-navy);
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    margin-right: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.custom-file-upload input[type="file"]::file-selector-button:hover {
    background-color: #20c0b0;
}

@media (max-width: 576px) {
    #subirDocumentoModal .modal-dialog {
        max-width: 95%;
        margin: 0.5rem auto;
    }
    
    .custom-file-upload input[type="file"] {
        font-size: 0.85rem;
    }
    
    .custom-file-upload input[type="file"]::file-selector-button {
        padding: 0.35rem 0.7rem;
    }
}
</style>

<!-- JS -->
<script src="../../../js/Formularios/Formulario_Subir_Documento_Equipo.js"></script>