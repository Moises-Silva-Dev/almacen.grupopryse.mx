<!-- Modal para Registrar Control de Equipos -->
<div class="modal fade" id="registrarEquipoModal" tabindex="-1" aria-labelledby="registrarEquipoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title" id="registrarEquipoModalLabel">
                    <i class="fas fa-desktop me-2"></i>
                    Registrar Control de Equipo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div id="loadingEquipoData" class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando datos...</p>
                </div>
                
                <div id="equipoFormContainer" style="display: none;">
                    <form id="FormInsertControlEquipo" action="../../../Controlador/Usuarios/INSERT/Funcion_Insert_Control_Equipo.php" method="POST" novalidate>
                        <input type="hidden" id="datosTablaEquipo" name="datosTablaEquipo">
                        
                        <!-- Sistema de navegación por círculos -->
                        <div class="step-indicator-container">
                            <div class="step-indicator">
                                <div class="step-circle" id="equipo_stepCircle1">
                                    <span class="step-number">1</span>
                                    <i class="fas fa-check step-check"></i>
                                </div>
                                <div class="step-line" id="equipo_stepLine1-2"></div>
                                <div class="step-circle" id="equipo_stepCircle2">
                                    <span class="step-number">2</span>
                                    <i class="fas fa-check step-check"></i>
                                </div>
                                <div class="step-line" id="equipo_stepLine2-3"></div>
                                <div class="step-circle" id="equipo_stepCircle3">
                                    <span class="step-number">3</span>
                                    <i class="fas fa-check step-check"></i>
                                </div>
                            </div>
                            <div class="step-labels">
                                <div class="step-label" id="equipo_stepLabel1">
                                    <i class="fas fa-user"></i>
                                    <span>Asignación</span>
                                </div>
                                <div class="step-label" id="equipo_stepLabel2">
                                    <i class="fas fa-microchip"></i>
                                    <span>Especificaciones</span>
                                </div>
                                <div class="step-label" id="equipo_stepLabel3">
                                    <i class="fas fa-peripherals"></i>
                                    <span>Periféricos</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- PASO 1: Asignación -->
                        <div id="equipo_step1" class="form-step">
                            <div class="card border-navy mb-4">
                                <div class="card-header bg-light text-navy">
                                    <i class="fas fa-user-circle me-2 text-turquoise"></i>
                                    Información de Asignación
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="equipo_Nombre_Persona" class="form-label text-navy">
                                                <i class="fas fa-user me-1 text-turquoise"></i>
                                                Nombre de la Persona *
                                            </label>
                                            <input type="text" class="form-control border-navy" id="equipo_Nombre_Persona" name="Nombre_Persona" 
                                                   placeholder="Ingresa el nombre completo"
                                                   onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32)" 
                                                   required>
                                            <div class="invalid-feedback">
                                                Por favor, ingresa el nombre de la persona.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="equipo_ID_Departamento" class="form-label text-navy">
                                                <i class="fas fa-building me-1 text-turquoise"></i>
                                                Departamento *
                                            </label>
                                            <select class="form-select border-navy" id="equipo_ID_Departamento" name="ID_Departamento" required>
                                                <option value="" selected disabled>-- Cargando departamentos... --</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona un departamento.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- PASO 2: Especificaciones del Equipo -->
                        <div id="equipo_step2" class="form-step" style="display: none;">
                            <div class="card border-navy mb-4">
                                <div class="card-header bg-light text-navy">
                                    <i class="fas fa-microchip me-2 text-turquoise"></i>
                                    Especificaciones del Equipo
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="equipo_Tipo_PC" class="form-label text-navy">
                                                <i class="fas fa-laptop me-1 text-turquoise"></i>
                                                Tipo de PC *
                                            </label>
                                            <select class="form-select border-navy" id="equipo_Tipo_PC" name="Tipo_PC" required>
                                                <option value="" selected disabled>-- Seleccionar Tipo --</option>
                                                <option value="Laptop">Laptop</option>
                                                <option value="Desktop">Desktop</option>
                                                <option value="All-in-One">All-in-One</option>
                                                <option value="Tablet">Tablet</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona el tipo de PC.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="equipo_Marca_Equipo" class="form-label text-navy">
                                                <i class="fas fa-trademark me-1 text-turquoise"></i>
                                                Marca del Equipo *
                                            </label>
                                            <select class="form-select border-navy" id="equipo_Marca_Equipo" name="Marca_Equipo" required>
                                                <option value="" selected disabled>-- Cargando marcas... --</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona la marca del equipo.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="equipo_Modelo_Equipo" class="form-label text-navy">
                                                <i class="fas fa-tag me-1 text-turquoise"></i>
                                                Modelo del Equipo
                                            </label>
                                            <input type="text" class="form-control border-navy" id="equipo_Modelo_Equipo" name="Modelo_Equipo" 
                                                   placeholder="Ingresa el modelo">
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="equipo_Numero_Serie" class="form-label text-navy">
                                                <i class="fas fa-barcode me-1 text-turquoise"></i>
                                                Número de Serie
                                            </label>
                                            <input type="text" class="form-control border-navy" id="equipo_Numero_Serie" name="Numero_Serie" 
                                                   placeholder="Ingresa el número de serie">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="equipo_Sistema_Operativo" class="form-label text-navy">
                                                <i class="fab fa-windows me-1 text-turquoise"></i>
                                                Sistema Operativo *
                                            </label>
                                            <select class="form-select border-navy" id="equipo_Sistema_Operativo" name="Sistema_Operativo" required>
                                                <option value="" selected disabled>-- Seleccionar SO --</option>
                                                <option value="Windows 10">Windows 10</option>
                                                <option value="Windows 11">Windows 11</option>
                                                <option value="Windows Server">Windows Server</option>
                                                <option value="Linux Ubuntu">Linux Ubuntu</option>
                                                <option value="Linux CentOS">Linux CentOS</option>
                                                <option value="macOS">macOS</option>
                                                <option value="Otro">Otro</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona el sistema operativo.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="equipo_Procesador" class="form-label text-navy">
                                                <i class="fas fa-microchip me-1 text-turquoise"></i>
                                                Procesador *
                                            </label>
                                            <select class="form-select border-navy" id="equipo_Procesador" name="Procesador" required>
                                                <option value="" selected disabled>-- Cargando procesadores... --</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona el procesador.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="equipo_Tarjeta_Madre" class="form-label text-navy">
                                                <i class="fas fa-microchip me-1 text-turquoise"></i>
                                                Tarjeta Madre *
                                            </label>
                                            <select class="form-select border-navy" id="equipo_Tarjeta_Madre" name="Tarjeta_Madre" required>
                                                <option value="" selected disabled>-- Cargando tarjetas madre... --</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona la tarjeta madre.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="equipo_Tiene_Grafica_Dedicada" name="Tiene_Grafica_Dedicada" value="1">
                                                <label class="form-check-label text-navy" for="equipo_Tiene_Grafica_Dedicada">
                                                    <i class="fas fa-video me-1 text-turquoise"></i>
                                                    ¿Tiene tarjeta gráfica dedicada?
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row" id="equipo_Datos_Grafica_Div" style="display: none;">
                                        <div class="col-md-12 mb-3">
                                            <label for="equipo_Datos_Tarjeta_Grafica" class="form-label text-navy">
                                                <i class="fas fa-video me-1 text-turquoise"></i>
                                                Datos de la Tarjeta Gráfica
                                            </label>
                                            <input type="text" class="form-control border-navy" id="equipo_Datos_Tarjeta_Grafica" name="Datos_Tarjeta_Grafica" 
                                                   placeholder="Ej: NVIDIA GeForce RTX 3060, AMD Radeon RX 6800">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="equipo_Tipo_RAM" class="form-label text-navy">
                                                <i class="fas fa-memory me-1 text-turquoise"></i>
                                                Tipo de RAM *
                                            </label>
                                            <select class="form-select border-navy" id="equipo_Tipo_RAM" name="Tipo_RAM" required>
                                                <option value="" selected disabled>-- Seleccionar Tipo --</option>
                                                <option value="DDR3">DDR3</option>
                                                <option value="DDR4">DDR4</option>
                                                <option value="DDR5">DDR5</option>
                                                <option value="LPDDR4">LPDDR4</option>
                                                <option value="LPDDR5">LPDDR5</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona el tipo de RAM.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="equipo_Capacidad_RAM" class="form-label text-navy">
                                                <i class="fas fa-memory me-1 text-turquoise"></i>
                                                Capacidad RAM *
                                            </label>
                                            <select class="form-select border-navy" id="equipo_Capacidad_RAM" name="Capacidad_RAM" required>
                                                <option value="" selected disabled>-- Seleccionar Capacidad --</option>
                                                <option value="4GB">4 GB</option>
                                                <option value="8GB">8 GB</option>
                                                <option value="16GB">16 GB</option>
                                                <option value="32GB">32 GB</option>
                                                <option value="64GB">64 GB</option>
                                                <option value="128GB">128 GB</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona la capacidad de RAM.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="equipo_Marca_RAM" class="form-label text-navy">
                                                <i class="fas fa-trademark me-1 text-turquoise"></i>
                                                Marca de RAM *
                                            </label>
                                            <select class="form-select border-navy" id="equipo_Marca_RAM" name="Marca_RAM" required>
                                                <option value="" selected disabled>-- Cargando marcas de RAM... --</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona la marca de RAM.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="equipo_Tipo_Disco" class="form-label text-navy">
                                                <i class="fas fa-hdd me-1 text-turquoise"></i>
                                                Tipo de Disco *
                                            </label>
                                            <select class="form-select border-navy" id="equipo_Tipo_Disco" name="Tipo_Disco" required>
                                                <option value="" selected disabled>-- Seleccionar Tipo --</option>
                                                <option value="HDD">HDD (Disco Duro)</option>
                                                <option value="SSD">SSD (Estado Sólido)</option>
                                                <option value="NVMe">NVMe (M.2)</option>
                                                <option value="Híbrido">Híbrido (SSHD)</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona el tipo de disco.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="equipo_Capacidad_Disco" class="form-label text-navy">
                                                <i class="fas fa-hdd me-1 text-turquoise"></i>
                                                Capacidad de Disco *
                                            </label>
                                            <select class="form-select border-navy" id="equipo_Capacidad_Disco" name="Capacidad_Disco" required>
                                                <option value="" selected disabled>-- Seleccionar Capacidad --</option>
                                                <option value="128GB">128 GB</option>
                                                <option value="256GB">256 GB</option>
                                                <option value="512GB">512 GB</option>
                                                <option value="1TB">1 TB</option>
                                                <option value="2TB">2 TB</option>
                                                <option value="4TB">4 TB</option>
                                                <option value="8TB">8 TB</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona la capacidad de disco.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- PASO 3: Periféricos y Otros -->
                        <div id="equipo_step3" class="form-step" style="display: none;">
                            <div class="card border-navy mb-4">
                                <div class="card-header bg-light text-navy">
                                    <i class="fas fa-keyboard me-2 text-turquoise"></i>
                                    Periféricos y Otros
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="equipo_Teclado_Mouse" class="form-label text-navy">
                                                <i class="fas fa-keyboard me-1 text-turquoise"></i>
                                                Teclado y Mouse *
                                            </label>
                                            <select class="form-select border-navy" id="equipo_Teclado_Mouse" name="Teclado_Mouse" required>
                                                <option value="" selected disabled>-- Seleccionar Opción --</option>
                                                <option value="Teclado y Mouse USB">Teclado y Mouse USB</option>
                                                <option value="Teclado y Mouse Inalámbrico">Teclado y Mouse Inalámbrico</option>
                                                <option value="Teclado USB + Mouse USB">Teclado USB + Mouse USB</option>
                                                <option value="Teclado Inalámbrico + Mouse Inalámbrico">Teclado Inalámbrico + Mouse Inalámbrico</option>
                                                <option value="Integrado (Laptop)">Integrado (Laptop)</option>
                                                <option value="No incluye">No incluye</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona la opción de teclado y mouse.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="equipo_Camara_Web" class="form-label text-navy">
                                                <i class="fas fa-camera me-1 text-turquoise"></i>
                                                Cámara Web
                                            </label>
                                            <select class="form-select border-navy" id="equipo_Camara_Web" name="Camara_Web">
                                                <option value="Integrada">Integrada</option>
                                                <option value="Externa">Externa</option>
                                                <option value="No tiene">No tiene</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="equipo_Otro_Periferico" class="form-label text-navy">
                                                <i class="fas fa-usb me-1 text-turquoise"></i>
                                                Otros Periféricos
                                            </label>
                                            <textarea class="form-control border-navy" id="equipo_Otro_Periferico" name="Otro_Periferico" 
                                                      rows="2" placeholder="Ej: Escáner, Impresora, Lector de huellas, etc."></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="equipo_Observaciones_Equipo" class="form-label text-navy">
                                                <i class="fas fa-sticky-note me-1 text-turquoise"></i>
                                                Observaciones del Equipo
                                            </label>
                                            <textarea class="form-control border-navy" id="equipo_Observaciones_Equipo" name="Observaciones_Equipo" 
                                                      rows="3" placeholder="Notas adicionales sobre el equipo"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botones de navegación -->
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary" id="equipo_prevBtn" style="display: none;">
                                <i class="fas fa-arrow-left me-1"></i> Anterior
                            </button>
                            <div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i> Cancelar
                                </button>
                                <button type="button" class="btn btn-navy" id="equipo_nextBtn">
                                    Siguiente <i class="fas fa-arrow-right ms-1"></i>
                                </button>
                                <button type="button" class="btn btn-primary" id="equipo_submitBtn" style="display: none;">
                                    <i class="fas fa-save me-1"></i> Registrar Equipo
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

<!-- JS para validar el formulario -->
<script src="../../../js/Formularios/Formulario_Insertar_Control_Equipos.js"></script>