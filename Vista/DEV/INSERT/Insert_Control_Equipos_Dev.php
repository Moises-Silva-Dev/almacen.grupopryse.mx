<!-- Modal para Registrar Control de Equipos -->
<div class="modal fade" id="registrarEquipoModal" tabindex="-1" aria-labelledby="registrarEquipoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title" id="registrarEquipoModalLabel">
                    <i class="fas fa-desktop me-2"></i>
                    Registrar Control de Equipos
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
                    <form id="FormInsertEquipoNuevo" action="../../../Controlador/Usuarios/INSERT/Funcion_Insert_Equipo.php" method="post" novalidate>
                        <input type="hidden" id="datosTablaInsertEquipo" name="datosTablaInsertEquipo">
                        
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
                                    <span>Hardware Interno</span>
                                </div>
                                <div class="step-label" id="equipo_stepLabel3">
                                    <i class="fas fa-keyboard"></i>
                                    <span>Periféricos</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- PASO 1: Asignación e Información General -->
                        <div id="equipo_step1" class="form-step">
                            <div class="card border-navy mb-4">
                                <div class="card-header bg-light text-navy">
                                    <i class="fas fa-info-circle me-2 text-turquoise"></i>
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
                                                   placeholder="Ingresa el nombre completo" required>
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
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label text-navy">
                                                <i class="fas fa-laptop-code me-1 text-turquoise"></i>
                                                Especificaciones del Equipo
                                            </label>
                                            <hr class="mt-0">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="equipo_Tipo_PC" class="form-label text-navy">
                                                <i class="fas fa-desktop me-1 text-turquoise"></i>
                                                Tipo de PC *
                                            </label>
                                            <select class="form-select border-navy" id="equipo_Tipo_PC" name="Tipo_PC" required>
                                                <option value="" selected disabled>-- Seleccionar --</option>
                                                <option value="Laptop">Laptop</option>
                                                <option value="Desktop">Desktop</option>
                                                <option value="All-in-One">All-in-One</option>
                                                <option value="Tablet">Tablet</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona el tipo de PC.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="equipo_Marca_Equipo" class="form-label text-navy">
                                                <i class="fab fa-trademark me-1 text-turquoise"></i>
                                                Marca *
                                            </label>
                                            <input type="text" class="form-control border-navy" id="equipo_Marca_Equipo" name="Marca_Equipo" 
                                                   placeholder="Ej: Dell, HP, Lenovo, Apple" required>
                                            <div class="invalid-feedback">
                                                Por favor, ingresa la marca del equipo.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="equipo_Modelo_Equipo" class="form-label text-navy">
                                                <i class="fas fa-cube me-1 text-turquoise"></i>
                                                Modelo
                                            </label>
                                            <input type="text" class="form-control border-navy" id="equipo_Modelo_Equipo" name="Modelo_Equipo" 
                                                   placeholder="Ej: Latitude 5420, Pavilion 15">
                                            <div class="invalid-feedback">
                                                Por favor, ingresa el modelo del equipo.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="equipo_Numero_Serie" class="form-label text-navy">
                                                <i class="fas fa-barcode me-1 text-turquoise"></i>
                                                Número de Serie
                                            </label>
                                            <input type="text" class="form-control border-navy" id="equipo_Numero_Serie" name="Numero_Serie" 
                                                   placeholder="Número de serie único">
                                            <div class="invalid-feedback">
                                                El número de serie debe ser único.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="equipo_Sistema_Operativo" class="form-label text-navy">
                                                <i class="fab fa-windows me-1 text-turquoise"></i>
                                                Sistema Operativo *
                                            </label>
                                            <input type="text" class="form-control border-navy" id="equipo_Sistema_Operativo" name="Sistema_Operativo" 
                                                   placeholder="Ej: Windows 11 Pro, Ubuntu 22.04" required>
                                            <div class="invalid-feedback">
                                                Por favor, ingresa el sistema operativo.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="equipo_Estatus" class="form-label text-navy">
                                                <i class="fas fa-circle me-1 text-turquoise"></i>
                                                Estatus
                                            </label>
                                            <select class="form-select border-navy" id="equipo_Estatus" name="Estatus">
                                                <option value="Activo" selected>Activo</option>
                                                <option value="En Mantenimiento">En Mantenimiento</option>
                                                <option value="Dado de Baja">Dado de Baja</option>
                                                <option value="En Reparación">En Reparación</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona un estatus.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- PASO 2: Hardware Interno -->
                        <div id="equipo_step2" class="form-step" style="display: none;">
                            <div class="card border-navy mb-4">
                                <div class="card-header bg-light text-navy">
                                    <i class="fas fa-microchip me-2 text-turquoise"></i>
                                    Hardware Interno
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="equipo_Procesador" class="form-label text-navy">
                                                <i class="fas fa-microchip me-1 text-turquoise"></i>
                                                Procesador *
                                            </label>
                                            <input type="text" class="form-control border-navy" id="equipo_Procesador" name="Procesador" 
                                                   placeholder="Ej: Intel Core i7-1165G7, AMD Ryzen 5 5600" required>
                                            <div class="invalid-feedback">
                                                Por favor, ingresa el procesador.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="equipo_Tarjeta_Madre" class="form-label text-navy">
                                                <i class="fas fa-microchip me-1 text-turquoise"></i>
                                                Tarjeta Madre
                                            </label>
                                            <input type="text" class="form-control border-navy" id="equipo_Tarjeta_Madre" name="Tarjeta_Madre" 
                                                   placeholder="Modelo de la tarjeta madre">
                                            <div class="invalid-feedback">
                                                Por favor, ingresa la tarjeta madre.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="equipo_Tiene_Grafica_Dedicada" name="Tiene_Grafica_Dedicada" value="1">
                                                <label class="form-check-label text-navy" for="equipo_Tiene_Grafica_Dedicada">
                                                    <i class="fas fa-tachometer-alt me-1"></i> Tiene Tarjeta Gráfica Dedicada
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row" id="equipo_GraficaDiv" style="display: none;">
                                        <div class="col-md-12 mb-3">
                                            <label for="equipo_Datos_Tarjeta_Grafica" class="form-label text-navy">
                                                <i class="fas fa-tachometer-alt me-1 text-turquoise"></i>
                                                Datos de la Tarjeta Gráfica
                                            </label>
                                            <textarea class="form-control border-navy" id="equipo_Datos_Tarjeta_Grafica" name="Datos_Tarjeta_Grafica" 
                                                      rows="2" placeholder="Ej: NVIDIA GeForce RTX 3060, AMD Radeon RX 6600"></textarea>
                                            <div class="invalid-feedback">
                                                Por favor, ingresa los datos de la tarjeta gráfica.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label text-navy">
                                                <i class="fas fa-memory me-1 text-turquoise"></i>
                                                Memoria RAM
                                            </label>
                                            <hr class="mt-0">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="equipo_Tipo_RAM" class="form-label text-navy">
                                                Tipo RAM *
                                            </label>
                                            <select class="form-select border-navy" id="equipo_Tipo_RAM" name="Tipo_RAM" required>
                                                <option value="" selected disabled>-- Seleccionar --</option>
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
                                                Capacidad RAM *
                                            </label>
                                            <select class="form-select border-navy" id="equipo_Capacidad_RAM" name="Capacidad_RAM" required>
                                                <option value="" selected disabled>-- Seleccionar --</option>
                                                <option value="4GB">4GB</option>
                                                <option value="8GB">8GB</option>
                                                <option value="16GB">16GB</option>
                                                <option value="32GB">32GB</option>
                                                <option value="64GB">64GB</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona la capacidad de RAM.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="equipo_Marca_RAM" class="form-label text-navy">
                                                Marca RAM *
                                            </label>
                                            <input type="text" class="form-control border-navy" id="equipo_Marca_RAM" name="Marca_RAM" 
                                                   placeholder="Ej: Kingston, Corsair, Crucial" required>
                                            <div class="invalid-feedback">
                                                Por favor, ingresa la marca de la RAM.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label text-navy">
                                                <i class="fas fa-hdd me-1 text-turquoise"></i>
                                                Almacenamiento
                                            </label>
                                            <hr class="mt-0">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="equipo_Tipo_Disco" class="form-label text-navy">
                                                Tipo de Disco *
                                            </label>
                                            <select class="form-select border-navy" id="equipo_Tipo_Disco" name="Tipo_Disco" required>
                                                <option value="" selected disabled>-- Seleccionar --</option>
                                                <option value="HDD">HDD (Disco Duro)</option>
                                                <option value="SSD SATA">SSD SATA</option>
                                                <option value="SSD NVMe">SSD NVMe M.2</option>
                                                <option value="eMMC">eMMC</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona el tipo de disco.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="equipo_Capacidad_Disco" class="form-label text-navy">
                                                Capacidad del Disco *
                                            </label>
                                            <select class="form-select border-navy" id="equipo_Capacidad_Disco" name="Capacidad_Disco" required>
                                                <option value="" selected disabled>-- Seleccionar --</option>
                                                <option value="128GB">128GB</option>
                                                <option value="256GB">256GB</option>
                                                <option value="512GB">512GB</option>
                                                <option value="1TB">1TB</option>
                                                <option value="2TB">2TB</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecciona la capacidad del disco.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- PASO 3: Periféricos y Observaciones -->
                        <div id="equipo_step3" class="form-step" style="display: none;">
                            <div class="card border-navy mb-4">
                                <div class="card-header bg-light text-navy">
                                    <i class="fas fa-keyboard me-2 text-turquoise"></i>
                                    Periféricos y Observaciones
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="equipo_Teclado_Mouse" class="form-label text-navy">
                                                <i class="fas fa-keyboard me-1 text-turquoise"></i>
                                                Teclado/Mouse *
                                            </label>
                                            <input type="text" class="form-control border-navy" id="equipo_Teclado_Mouse" name="Teclado_Mouse" 
                                                   placeholder="Ej: Incluidos, Genéricos, Logitech" required>
                                            <div class="invalid-feedback">
                                                Por favor, ingresa información sobre teclado/mouse.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="equipo_Camara_Web" class="form-label text-navy">
                                                <i class="fas fa-camera me-1 text-turquoise"></i>
                                                Cámara Web
                                            </label>
                                            <input type="text" class="form-control border-navy" id="equipo_Camara_Web" name="Camara_Web" 
                                                   placeholder="Integrada/No tiene/Externa" value="Integrada">
                                            <div class="invalid-feedback">
                                                Por favor, ingresa información sobre la cámara.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="equipo_Otro_Periferico" class="form-label text-navy">
                                                <i class="fas fa-plug me-1 text-turquoise"></i>
                                                Otros Periféricos
                                            </label>
                                            <textarea class="form-control border-navy" id="equipo_Otro_Periferico" name="Otro_Periferico" 
                                                      rows="2" placeholder="Ej: Impresora, Escáner, Docking station, Lector de huellas"></textarea>
                                            <div class="invalid-feedback">
                                                Por favor, ingresa otros periféricos.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="equipo_Observaciones" class="form-label text-navy">
                                                <i class="fas fa-comment me-1 text-turquoise"></i>
                                                Observaciones
                                            </label>
                                            <textarea class="form-control border-navy" id="equipo_Observaciones" name="Observaciones" 
                                                      rows="3" placeholder="Notas adicionales sobre el equipo"></textarea>
                                            <div class="invalid-feedback">
                                                Por favor, ingresa las observaciones.
                                            </div>
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
    max-width: 600px;
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

.form-check-input:checked {
    background-color: var(--color-turquoise);
    border-color: var(--color-turquoise);
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