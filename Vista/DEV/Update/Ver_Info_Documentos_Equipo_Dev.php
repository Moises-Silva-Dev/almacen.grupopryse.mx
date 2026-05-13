<!-- Modal para Ver Información y Documentos del Equipo -->
<div class="modal fade" id="verEquipoModal" tabindex="-1" aria-labelledby="verEquipoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title" id="verEquipoModalLabel">
                    <i class="fas fa-desktop me-2"></i>
                    Información del Equipo y Documentos
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div id="loadingVerEquipoData" class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando información del equipo...</p>
                </div>
                
                <div id="verEquipoContent" style="display: none;">
                    <!-- Tabs de navegación -->
                    <ul class="nav nav-tabs border-navy" id="equipoTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#infoEquipo" type="button" role="tab">
                                <i class="fas fa-info-circle me-2"></i>Información del Equipo
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="docs-tab" data-bs-toggle="tab" data-bs-target="#documentosEquipo" type="button" role="tab">
                                <i class="fas fa-file-pdf me-2"></i>Documentos PDF
                                <span id="documentosCountBadge" class="badge bg-turquoise text-navy ms-2">0</span>
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content mt-4" id="equipoTabContent">
                        <!-- TAB 1: Información del Equipo -->
                        <div class="tab-pane fade show active" id="infoEquipo" role="tabpanel">
                            <div class="row">
                                <!-- Columna Izquierda -->
                                <div class="col-md-6">
                                    <div class="card border-navy mb-4">
                                        <div class="card-header bg-light text-navy">
                                            <i class="fas fa-user me-2 text-turquoise"></i>
                                            Información de Asignación
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <th width="40%"><i class="fas fa-user me-2 text-turquoise"></i>Nombre:</th>
                                                        <td id="ver_Nombre_Persona">--</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-building me-2 text-turquoise"></i>Departamento:</th>
                                                        <td id="ver_Departamento">--</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-calendar me-2 text-turquoise"></i>Fecha Registro:</th>
                                                        <td id="ver_Fecha_Registro">--</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-tag me-2 text-turquoise"></i>Estatus:</th>
                                                        <td><span id="ver_Estatus" class="badge bg-success">Activo</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-comment me-2 text-turquoise"></i>Observaciones:</th>
                                                        <td id="ver_Observaciones">--</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <div class="card border-navy mb-4">
                                        <div class="card-header bg-light text-navy">
                                            <i class="fas fa-laptop me-2 text-turquoise"></i>
                                            Especificaciones Básicas
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <th width="40%"><i class="fas fa-laptop me-2 text-turquoise"></i>Tipo de PC:</th>
                                                        <td id="ver_Tipo_PC">--</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-trademark me-2 text-turquoise"></i>Marca:</th>
                                                        <td id="ver_Marca_Equipo">--</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-tag me-2 text-turquoise"></i>Modelo:</th>
                                                        <td id="ver_Modelo_Equipo">--</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-barcode me-2 text-turquoise"></i>Número de Serie:</th>
                                                        <td id="ver_Numero_Serie">--</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fab fa-windows me-2 text-turquoise"></i>Sistema Operativo:</th>
                                                        <td id="ver_Sistema_Operativo">--</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Columna Derecha -->
                                <div class="col-md-6">
                                    <div class="card border-navy mb-4">
                                        <div class="card-header bg-light text-navy">
                                            <i class="fas fa-microchip me-2 text-turquoise"></i>
                                            Hardware Interno
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <th width="45%"><i class="fas fa-microchip me-2 text-turquoise"></i>Procesador:</th>
                                                        <td id="ver_Procesador">--</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-microchip me-2 text-turquoise"></i>Tarjeta Madre:</th>
                                                        <td id="ver_Tarjeta_Madre">--</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-video me-2 text-turquoise"></i>Gráfica Dedicada:</th>
                                                        <td id="ver_Tiene_Grafica">--</td>
                                                    </tr>
                                                    <tr id="ver_Datos_Grafica_Row" style="display: none;">
                                                        <th><i class="fas fa-video me-2 text-turquoise"></i>Datos Gráfica:</th>
                                                        <td id="ver_Datos_Tarjeta_Grafica">--</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-memory me-2 text-turquoise"></i>Tipo RAM:</th>
                                                        <td id="ver_Tipo_RAM">--</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-memory me-2 text-turquoise"></i>Capacidad RAM:</th>
                                                        <td id="ver_Capacidad_RAM">--</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-trademark me-2 text-turquoise"></i>Marca RAM:</th>
                                                        <td id="ver_Marca_RAM">--</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-hdd me-2 text-turquoise"></i>Tipo Disco:</th>
                                                        <td id="ver_Tipo_Disco">--</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-hdd me-2 text-turquoise"></i>Capacidad Disco:</th>
                                                        <td id="ver_Capacidad_Disco">--</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Periféricos -->
                            <div class="card border-navy mb-4">
                                <div class="card-header bg-light text-navy">
                                    <i class="fas fa-keyboard me-2 text-turquoise"></i>
                                    Periféricos
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong><i class="fas fa-keyboard me-2 text-turquoise"></i>Teclado/Mouse:</strong>
                                            <p id="ver_Teclado_Mouse" class="mt-2">--</p>
                                        </div>
                                        <div class="col-md-4">
                                            <strong><i class="fas fa-camera me-2 text-turquoise"></i>Cámara Web:</strong>
                                            <p id="ver_Camara_Web" class="mt-2">--</p>
                                        </div>
                                        <div class="col-md-4">
                                            <strong><i class="fas fa-usb me-2 text-turquoise"></i>Otros Periféricos:</strong>
                                            <p id="ver_Otro_Periferico" class="mt-2">--</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- TAB 2: Documentos PDF -->
                        <div class="tab-pane fade" id="documentosEquipo" role="tabpanel">
                            <div class="card border-navy">
                                <div class="card-header bg-light text-navy d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-file-pdf me-2 text-turquoise"></i>Documentos del Equipo</span>
                                    <button type="button" class="btn btn-sm btn-turquoise" id="ver_btnSubirDocumento" onclick="abrirSubirDocumentoDesdeModal()">
                                        <i class="fas fa-upload me-1"></i> Subir Documento
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="tablaDocumentosEquipo">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="50">#</th>
                                                    <th>Nombre del Documento</th>
                                                    <th>Fecha de Subida</th>
                                                    <th width="150">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tablaDocumentosBody">
                                                <tr>
                                                    <td colspan="4" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="fas fa-spinner fa-spin me-2"></i>
                                                            Cargando documentos...
                                                        </div>
                                                     </td>
                                                </tr>
                                            </tbody>
                                         </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos específicos para el modal de ver equipo */
#verEquipoModal .modal-dialog {
    max-width: 1200px;
}

#verEquipoModal .nav-tabs {
    border-bottom: 2px solid var(--color-navy);
}

#verEquipoModal .nav-tabs .nav-link {
    color: var(--color-navy);
    font-weight: 500;
    border: none;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
}

#verEquipoModal .nav-tabs .nav-link:hover {
    color: var(--color-turquoise);
    background-color: rgba(64, 224, 208, 0.05);
}

#verEquipoModal .nav-tabs .nav-link.active {
    color: var(--color-turquoise);
    background-color: transparent;
    border-bottom: 3px solid var(--color-turquoise);
}

#verEquipoModal .table-borderless td,
#verEquipoModal .table-borderless th {
    padding: 0.5rem 0.25rem;
    vertical-align: top;
}

#verEquipoModal .badge {
    font-size: 0.85rem;
    padding: 0.35rem 0.75rem;
}

#verEquipoModal .card-header {
    font-weight: 600;
}

/* Estilos para la tabla de documentos */
#tablaDocumentosEquipo tbody tr {
    transition: all 0.2s ease;
}

#tablaDocumentosEquipo tbody tr:hover {
    background-color: rgba(0, 31, 63, 0.03);
}

/* Animación de carga */
.spinner-border.text-turquoise {
    color: var(--color-turquoise) !important;
}

@media (max-width: 768px) {
    #verEquipoModal .modal-dialog {
        max-width: 95%;
        margin: 0.5rem auto;
    }
    
    #verEquipoModal .nav-tabs .nav-link {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }
    
    #verEquipoModal .table-borderless th,
    #verEquipoModal .table-borderless td {
        font-size: 0.85rem;
    }
}
</style>

<!-- JS -->
<script src="../../../js/Formularios/Formulario_Ver_Documentos_Equipo.js"></script>