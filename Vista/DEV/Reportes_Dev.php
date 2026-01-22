<?php include('head.php'); ?>

<!-- CSS Personalizado -->
<link rel="stylesheet" href="../../css/diseno_tablas_general.css">
<link rel="stylesheet" href="../../css/reporte.css">

<div class="container-fluid py-4">
    <!-- Encabezado -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-navy">
                        <i class="fas fa-chart-bar me-2 text-turquoise"></i>
                        Sistema de Reportes
                    </h1>
                    <p class="text-muted mb-0">Genera reportes detallados de inventario, entradas y salidas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel principal de reportes -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-navy text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>
                            Generador de Reportes
                        </h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Acordeón de reportes -->
                    <div class="accordion accordion-flush" id="reportsAccordion">
                        
                        <!-- Reporte de Entradas de Productos -->
                        <div class="accordion-item border-navy mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-light-navy text-white" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#collapseEntradas">
                                    <div class="d-flex align-items-center w-100">
                                        <div class="report-icon me-3">
                                            <i class="fas fa-inbox fa-lg"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Reporte de Entradas de Productos</h6>
                                            <small class="text-white-50">Genera reportes de productos entrantes</small>
                                        </div>
                                        <span class="badge bg-turquoise text-navy">2 formatos</span>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseEntradas" class="accordion-collapse collapse" data-bs-parent="#reportsAccordion">
                                <div class="accordion-body pt-4">
                                    <div class="row g-4">
                                        <!-- Por Fechas -->
                                        <div class="col-lg-6">
                                            <div class="report-card">
                                                <div class="report-card-header bg-light-turquoise">
                                                    <i class="fas fa-calendar-alt me-2"></i>
                                                    <h6 class="mb-0">Reporte por Rango de Fechas</h6>
                                                </div>
                                                <div class="report-card-body">
                                                    <form id="entradasFormFechas" class="needs-validation" novalidate>
                                                        <div class="mb-3">
                                                            <label for="Fecha_Inicio_Entradas" class="form-label fw-semibold text-navy">
                                                                <i class="fas fa-calendar-day me-1"></i> Fecha de Inicio
                                                            </label>
                                                            <input class="form-control form-control-lg border-navy" type="date" id="Fecha_Inicio_Entradas" name="Fecha_Inicio" required>
                                                            <div class="invalid-feedback">
                                                                Por favor, selecciona una fecha de inicio
                                                            </div>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="Fecha_Fin_Entradas" class="form-label fw-semibold text-navy">
                                                                <i class="fas fa-calendar-week me-1"></i> Fecha de Fin
                                                            </label>
                                                            <input class="form-control form-control-lg border-navy" type="date" id="Fecha_Fin_Entradas" name="Fecha_Fin" required>
                                                            <div class="invalid-feedback">
                                                                Por favor, selecciona una fecha de fin
                                                            </div>
                                                        </div>
                                                        <div class="d-grid gap-2">
                                                            <button type="button" 
                                                                    class="btn btn-danger btn-lg d-flex align-items-center justify-content-center"
                                                                    onclick="Generar_PDF_Entradas_Fechas(event)">
                                                                <i class="fas fa-file-pdf me-2"></i>
                                                                <span>Generar PDF</span>
                                                            </button>
                                                            <button type="button" 
                                                                    class="btn btn-success btn-lg d-flex align-items-center justify-content-center"
                                                                    onclick="Generar_Excel_Entradas_Fechas(event)">
                                                                <i class="fas fa-file-excel me-2"></i>
                                                                <span>Generar Excel</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Por ID -->
                                        <div class="col-lg-6">
                                            <div class="report-card">
                                                <div class="report-card-header bg-light-navy">
                                                    <i class="fas fa-hashtag me-2"></i>
                                                    <h6 class="mb-0">Reporte por Número de Entrada</h6>
                                                </div>
                                                <div class="report-card-body">
                                                    <form id="entradaFormID" class="needs-validation" novalidate>
                                                        <div class="mb-4">
                                                            <label for="Id_Entrada" class="form-label fw-semibold text-navy">
                                                                <i class="fas fa-key me-1"></i> Número de Entrada
                                                            </label>
                                                            <input class="form-control form-control-lg border-navy" type="text" id="Id_Entrada" name="Id_Entrada" placeholder="Ej: 1001" pattern="[0-9]+" required>
                                                            <div class="invalid-feedback">
                                                                Por favor, ingresa un número de entrada válido
                                                            </div>
                                                        </div>
                                                        <div class="d-grid">
                                                            <button type="button" 
                                                                    class="btn btn-danger btn-lg d-flex align-items-center justify-content-center"
                                                                    onclick="Generar_PDF_Entrada_ID(event)">
                                                                <i class="fas fa-file-pdf me-2"></i>
                                                                <span>Generar PDF</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reporte de Salidas de Almacén -->
                        <div class="accordion-item border-navy mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-light-navy text-white" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#collapseSalidas">
                                    <div class="d-flex align-items-center w-100">
                                        <div class="report-icon me-3">
                                            <i class="fas fa-box fa-lg"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Reporte de Salidas de Almacén</h6>
                                            <small class="text-white-50">Genera reportes de productos salientes</small>
                                        </div>
                                        <span class="badge bg-turquoise text-navy">2 formatos</span>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseSalidas" class="accordion-collapse collapse" data-bs-parent="#reportsAccordion">
                                <div class="accordion-body pt-4">
                                    <div class="row g-4">
                                        <!-- Por Fechas -->
                                        <div class="col-lg-6">
                                            <div class="report-card">
                                                <div class="report-card-header bg-light-turquoise">
                                                    <i class="fas fa-calendar-alt me-2"></i>
                                                    <h6 class="mb-0">Reporte por Rango de Fechas</h6>
                                                </div>
                                                <div class="report-card-body">
                                                    <form id="salidasFormFechas" class="needs-validation" novalidate>
                                                        <div class="mb-3">
                                                            <label for="Fecha_Inicio_Salidas" class="form-label fw-semibold text-navy">
                                                                <i class="fas fa-calendar-day me-1"></i> Fecha de Inicio
                                                            </label>
                                                            <input class="form-control form-control-lg border-navy" type="date" id="Fecha_Inicio_Salidas" name="Fecha_Inicio" required>
                                                            <div class="invalid-feedback">
                                                                Por favor, selecciona una fecha de inicio
                                                            </div>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="Fecha_Fin_Salidas" class="form-label fw-semibold text-navy">
                                                                <i class="fas fa-calendar-week me-1"></i> Fecha de Fin
                                                            </label>
                                                            <input class="form-control form-control-lg border-navy" type="date" id="Fecha_Fin_Salidas" name="Fecha_Fin" required>
                                                            <div class="invalid-feedback">
                                                                Por favor, selecciona una fecha de fin
                                                            </div>
                                                        </div>
                                                        <div class="d-grid gap-2">
                                                            <button type="button" 
                                                                    class="btn btn-danger btn-lg d-flex align-items-center justify-content-center"
                                                                    onclick="Generar_PDF_Salidas_Fechas(event)">
                                                                <i class="fas fa-file-pdf me-2"></i>
                                                                <span>Generar PDF</span>
                                                            </button>
                                                            <button type="button" 
                                                                    class="btn btn-success btn-lg d-flex align-items-center justify-content-center"
                                                                    onclick="Generar_Excel_Salidas_Fechas(event)">
                                                                <i class="fas fa-file-excel me-2"></i>
                                                                <span>Generar Excel</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Por ID -->
                                        <div class="col-lg-6">
                                            <div class="report-card">
                                                <div class="report-card-header bg-light-navy">
                                                    <i class="fas fa-hashtag me-2"></i>
                                                    <h6 class="mb-0">Reporte por Número de Salida</h6>
                                                </div>
                                                <div class="report-card-body">
                                                    <form id="salidaFormID" class="needs-validation" novalidate>
                                                        <div class="mb-4">
                                                            <label for="Id_Salida" class="form-label fw-semibold text-navy">
                                                                <i class="fas fa-key me-1"></i> Número de Salida
                                                            </label>
                                                            <input class="form-control form-control-lg border-navy" type="text" id="Id_Salida" name="Id_Salida" placeholder="Ej: 2001" pattern="[0-9]+" required>
                                                            <div class="invalid-feedback">
                                                                Por favor, ingresa un número de salida válido
                                                            </div>
                                                        </div>
                                                        <div class="d-grid">
                                                            <button type="button" 
                                                                    class="btn btn-danger btn-lg d-flex align-items-center justify-content-center"
                                                                    onclick="Generar_PDF_Salida_ID(event)">
                                                                <i class="fas fa-file-pdf me-2"></i>
                                                                <span>Generar PDF</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reporte de Inventario -->
                        <div class="accordion-item border-navy mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-light-navy text-white" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#collapseInventario">
                                    <div class="d-flex align-items-center w-100">
                                        <div class="report-icon me-3">
                                            <i class="fas fa-boxes fa-lg"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Reporte de Inventario</h6>
                                            <small class="text-white-50">Estado actual del inventario</small>
                                        </div>
                                        <span class="badge bg-turquoise text-navy">2 formatos</span>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseInventario" class="accordion-collapse collapse" data-bs-parent="#reportsAccordion">
                                <div class="accordion-body pt-4">
                                    <div class="row g-4">
                                        <!-- Reporte General -->
                                        <div class="col-lg-4">
                                            <div class="report-card h-100">
                                                <div class="report-card-header bg-light-turquoise">
                                                    <i class="fas fa-clipboard-list me-2"></i>
                                                    <h6 class="mb-0">Inventario General</h6>
                                                </div>
                                                <div class="report-card-body d-flex flex-column">
                                                    <p class="text-muted mb-4">
                                                        Reporte completo del inventario actual con todos los productos y existencias.
                                                    </p>
                                                    <div class="mt-auto">
                                                        <div class="d-grid gap-2">
                                                            <button type="button" 
                                                                    class="btn btn-danger btn-lg d-flex align-items-center justify-content-center"
                                                                    onclick="Generar_PDF_Inventario(event)">
                                                                <i class="fas fa-file-pdf me-2"></i>
                                                                <span>Generar PDF</span>
                                                            </button>
                                                            <button type="button" 
                                                                    class="btn btn-success btn-lg d-flex align-items-center justify-content-center"
                                                                    onclick="Generar_Excel_Inventario(event)">
                                                                <i class="fas fa-file-excel me-2"></i>
                                                                <span>Generar Excel</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Reporte por Estado -->
                                        <div class="col-lg-4">
                                            <div class="report-card h-100">
                                                <div class="report-card-header bg-light-navy">
                                                    <i class="fas fa-chart-pie me-2"></i>
                                                    <h6 class="mb-0">Productos por Estado</h6>
                                                </div>
                                                <div class="report-card-body d-flex flex-column">
                                                    <p class="text-muted mb-4">
                                                        Reporte detallado de productos agrupados por estado y categoría.
                                                    </p>
                                                    <div class="mt-auto">
                                                        <div class="d-grid">
                                                            <button type="button" 
                                                                    class="btn btn-success btn-lg d-flex align-items-center justify-content-center"
                                                                    onclick="Generar_Excel_Producto_x_Estado(event)">
                                                                <i class="fas fa-file-excel me-2"></i>
                                                                <span>Generar Excel</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reporte de Requisiciones -->
                        <div class="accordion-item border-navy mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-light-navy text-white" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#collapseRequisiciones">
                                    <div class="d-flex align-items-center w-100">
                                        <div class="report-icon me-3">
                                            <i class="fas fa-file-contract fa-lg"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Reporte de Requisiciones</h6>
                                            <small class="text-white-50">Reportes detallados de requisiciones</small>
                                        </div>
                                        <span class="badge bg-turquoise text-navy">3 formatos</span>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseRequisiciones" class="accordion-collapse collapse" data-bs-parent="#reportsAccordion">
                                <div class="accordion-body pt-4">
                                    <div class="row g-4">
                                        <!-- Por Fechas -->
                                        <div class="col-lg-4">
                                            <div class="report-card">
                                                <div class="report-card-header bg-light-turquoise">
                                                    <i class="fas fa-calendar-alt me-2"></i>
                                                    <h6 class="mb-0">Por Rango de Fechas</h6>
                                                </div>
                                                <div class="report-card-body">
                                                    <form id="solicitudFormFechas" class="needs-validation" novalidate>
                                                        <div class="mb-3">
                                                            <label for="Fecha_Inicio_Solicitud" class="form-label fw-semibold text-navy">
                                                                Fecha de Inicio
                                                            </label>
                                                            <input class="form-control border-navy" type="date" id="Fecha_Inicio_Solicitud" name="Fecha_Inicio" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="Fecha_Fin_Solicitud" class="form-label fw-semibold text-navy">
                                                                Fecha de Fin
                                                            </label>
                                                            <input class="form-control border-navy" type="date" id="Fecha_Fin_Solicitud" name="Fecha_Fin" required>
                                                        </div>
                                                        <div class="d-grid gap-2">
                                                            <button type="button" 
                                                                    class="btn btn-danger d-flex align-items-center justify-content-center"
                                                                    onclick="Generar_PDF_Solicitud_Fechas(event)">
                                                                <i class="fas fa-file-pdf me-2"></i>
                                                                <span>PDF</span>
                                                            </button>
                                                            <button type="button" 
                                                                    class="btn btn-success d-flex align-items-center justify-content-center"
                                                                    onclick="Generar_Excel_Solicitud_Fechas(event)">
                                                                <i class="fas fa-file-excel me-2"></i>
                                                                <span>Excel</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Por ID -->
                                        <div class="col-lg-4">
                                            <div class="report-card">
                                                <div class="report-card-header bg-light-navy">
                                                    <i class="fas fa-hashtag me-2"></i>
                                                    <h6 class="mb-0">Por Número de Requisición</h6>
                                                </div>
                                                <div class="report-card-body">
                                                    <form id="solicitudFormID" class="needs-validation" novalidate>
                                                        <div class="mb-3">
                                                            <label for="Id_Solicitud" class="form-label fw-semibold text-navy">
                                                                Número de Requisición
                                                            </label>
                                                            <input class="form-control border-navy" type="text" id="Id_Solicitud" name="Id_Solicitud" placeholder="Ej: 1001" pattern="[0-9]+" required>
                                                        </div>
                                                        <div class="d-grid">
                                                            <button type="button" 
                                                                    class="btn btn-danger d-flex align-items-center justify-content-center"
                                                                    onclick="Generar_PDF_Solicitud_ID(event)">
                                                                <i class="fas fa-file-pdf me-2"></i>
                                                                <span>Generar PDF</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Por Usuario -->
                                        <div class="col-lg-4">
                                            <div class="report-card">
                                                <div class="report-card-header bg-light-turquoise">
                                                    <i class="fas fa-user me-2"></i>
                                                    <h6 class="mb-0">Por Usuario</h6>
                                                </div>
                                                <div class="report-card-body">
                                                    <form id="RequisicionUsuarioFormID" class="needs-validation" novalidate>
                                                        <div class="mb-3">
                                                            <label for="Id_Usuario" class="form-label fw-semibold text-navy">
                                                                ID del Usuario
                                                            </label>
                                                            <input class="form-control border-navy" type="text" id="Id_Usuario" name="Id_Usuario" placeholder="Ej: 1001" pattern="[0-9]+" required>
                                                        </div>
                                                        <div class="d-grid gap-2">
                                                            <button type="button" 
                                                                    class="btn btn-danger d-flex align-items-center justify-content-center"
                                                                    onclick="Generar_PDF_Requisicion_Usuario(event)">
                                                                <i class="fas fa-file-pdf me-2"></i>
                                                                <span>PDF</span>
                                                            </button>
                                                            <button type="button" 
                                                                    class="btn btn-success d-flex align-items-center justify-content-center"
                                                                    onclick="Generar_Excel_Requisicion_Usuario(event)">
                                                                <i class="fas fa-file-excel me-2"></i>
                                                                <span>Excel</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reporte de Conteo Salidas -->
                        <div class="accordion-item border-navy mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-light-navy text-white" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#collapseConteoSalidas">
                                    <div class="d-flex align-items-center w-100">
                                        <div class="report-icon me-3">
                                            <i class="fas fa-calculator fa-lg"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Conteo de Salidas por Requisición</h6>
                                            <small class="text-white-50">Estadísticas de salidas por requisición</small>
                                        </div>
                                        <span class="badge bg-turquoise text-navy">1 formato</span>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseConteoSalidas" class="accordion-collapse collapse" data-bs-parent="#reportsAccordion">
                                <div class="accordion-body pt-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="report-card">
                                                <div class="report-card-header bg-light-turquoise">
                                                    <i class="fas fa-chart-bar me-2"></i>
                                                    <h6 class="mb-0">Conteo por Fechas</h6>
                                                </div>
                                                <div class="report-card-body">
                                                    <form id="conteoSalidaSolicitudFormFechas" class="needs-validation" novalidate>
                                                        <div class="mb-3">
                                                            <label for="Fecha_Inicio_Conteo" class="form-label fw-semibold text-navy">
                                                                Fecha de Inicio
                                                            </label>
                                                            <input class="form-control border-navy" type="date" id="Fecha_Inicio_Conteo" name="Fecha_Inicio" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="Fecha_Fin_Conteo" class="form-label fw-semibold text-navy">
                                                                Fecha de Fin
                                                            </label>
                                                            <input class="form-control border-navy" type="date" id="Fecha_Fin_Conteo" name="Fecha_Fin" required>
                                                        </div>
                                                        <div class="d-grid gap-2">
                                                            <button type="button" 
                                                                    class="btn btn-danger d-flex align-items-center justify-content-center"
                                                                    onclick="Generar_PDF_Conteo_Salidas_Solicitud_Fechas(event)">
                                                                <i class="fas fa-file-pdf me-2"></i>
                                                                <span>PDF</span>
                                                            </button>
                                                            <button type="button" 
                                                                    class="btn btn-success d-flex align-items-center justify-content-center"
                                                                    onclick="Generar_Excel_Conteo_Salidas_Solicitud_Fechas(event)">
                                                                <i class="fas fa-file-excel me-2"></i>
                                                                <span>Excel</span>
                                                            </button>
                                                        </div>
                                                    </form>
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
        </div>
    </div>
</div>

<!-- Modal de ERROR -->
    <div class="modal fade" id="pdfModalERROR" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lo siento</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <center><div class="modal-body">
                    <p id="errorMessage"></p>
                </div></center>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de inventario -->
    <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Reporte de Inventario</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframe" src="" style="width: 100%; height: 600px;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de entrada fechas -->
    <div class="modal fade" id="pdfModalEntradaFechas" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Reporte Entradas de Productos por Fechas</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfViewerEntradasFechas" style="width: 100%; height: 600px;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de salidas fechas -->
    <div class="modal fade" id="pdfModalSalidaFechas" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Reporte Salidas de Almacén por Fechas</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfViewerSalidasFechas" style="width: 100%; height: 600px;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de solicitud fechas -->
    <div class="modal fade" id="pdfModalSolicitudFechas" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Reporte Requisiciones por Fechas</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframeSolicitudFechas" width="100%" height="500px"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de conteo de salidas solicitud fechas -->
    <div class="modal fade" id="pdfModalConteoSalidasSolicitudFechas" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Reporte Conteo de Salidas de Requisiciones por Fechas</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframeConteoSalidasSolicitudFechas" width="100%" height="500px"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de solicitud ID -->
    <div class="modal fade" id="pdfModalSolicitudID" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Reporte Requisición por ID</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframeSolicitudID" width="100%" height="500px"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de Entrada ID -->
    <div class="modal fade" id="pdfModalEntradaID" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Reporte Entradas de Productos por ID</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframeEntradaID" width="100%" height="500px"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de Salida ID -->
    <div class="modal fade" id="pdfModalSalidaID" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Reporte Salidas de Almacén por ID</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframeSalidaID" width="100%" height="500px"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de requisicion usuario -->
    <div class="modal fade" id="pdfModalRequisicionUsuario" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Reporte Requisicion por Usuario</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframeRequisicionUsuario" width="100%" height="500px"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Mantener tus scripts existentes -->
<script src="../../js/ConfigurarValidacionFechas.js"></script>
<script src="../../js/PDF/GenerarPDFEntradasFechas.js"></script>
<script src="../../js/PDF/GenerarPDFEntradasID.js"></script>
<script src="../../js/PDF/GenerarPDFSalidasFechas.js"></script>
<script src="../../js/PDF/GenerarPDFSalidasID.js"></script>
<script src="../../js/PDF/GenerarPDFInventario.js"></script>
<script src="../../js/PDF/GenerarPDFSolicitudID.js"></script>
<script src="../../js/PDF/GenerarPDFSolicitudFechas.js"></script>
<script src="../../js/PDF/GenerarPDFConteoSalidasSolicitudFechas.js"></script>
<script src="../../js/PDF/GenerarPDFRequisicionUsuario.js"></script>
<script src="../../js/EXCEL/GenerarExcelEntradasFechas.js"></script>
<script src="../../js/EXCEL/GenerarExcelSalidasFechas.js"></script>
<script src="../../js/EXCEL/GenerarExcelSolicitudFechas.js"></script>
<script src="../../js/EXCEL/GenerarExcelInventario.js"></script>
<script src="../../js/EXCEL/GenerarExcelConteoSalidasSolicitudFechas.js"></script>
<script src="../../js/EXCEL/GenerarExcelRequisicionUsuario.js"></script>
<script src="../../js/EXCEL/GenerarExcelProductoxEstado.js"></script>

<?php include('footer.php'); ?>