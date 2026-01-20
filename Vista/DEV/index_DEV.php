<?php include('head.php'); ?>

<!-- CSS Personalizado -->
<link rel="stylesheet" href="../../css/cards_informativas_dashboard.css">
<link rel="stylesheet" href="../../css/diseno_graficas.css">
<link rel="stylesheet" href="../../css/diseno_tabla_inventario.css">

<!-- Sección de Métricas -->
<section class="metrics-section">
    <h2 class="section-title">Dashboard de Actividad</h2>
    
    <div class="metrics-grid">
        <!-- Tarjeta 1: Productos Bajos -->
        <div class="metric-card">
            <div class="metric-icon metric-icon-warning">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="metric-content">
                <h3 class="metric-title">Requisiciones Pendientes</h3>
                <div class="metric-value" id="productosBajoStock">0</div>
                <p class="metric-description">Requisiciones pendientes por Autorizar</p>
            </div>
        </div>
        
        <!-- Tarjeta 2: Entradas Hoy -->
        <div class="metric-card">
            <div class="metric-icon metric-icon-info">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div class="metric-content">
                <h3 class="metric-title">Entradas Hoy</h3>
                <div class="metric-value" id="entradasHoy">0</div>
                <p class="metric-description">Productos ingresados hoy</p>
            </div>
        </div>
        
        <!-- Tarjeta 3: Salidas Hoy -->
        <div class="metric-card">
            <div class="metric-icon metric-icon-success">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div class="metric-content">
                <h3 class="metric-title">Salidas Hoy</h3>
                <div class="metric-value" id="salidasHoy">0</div>
                <p class="metric-description">Productos despachados hoy</p>
            </div>
        </div>
        
        <!-- Tarjeta 4: Usuarios Activos -->
        <div class="metric-card">
            <div class="metric-icon metric-icon-primary">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="metric-content">
                <h3 class="metric-title">Usuarios Activos</h3>
                <div class="metric-value" id="usuariosActivosHoy">0</div>
                <p class="metric-description">Usuarios que accedieron hoy</p>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Gráfica -->
<section class="chart-section">
    <div class="chart-header">
        <h2 class="section-title">Requisiciones del Mes</h2>
        <div class="chart-controls">
            <button class="btn-chart-control active" data-period="month">Este Mes</button>
            <button class="btn-chart-control" data-period="week">Esta Semana</button>
        </div>
    </div>
    <div class="chart-container">
        <canvas id="graficaRequisiciones"></canvas>
    </div>
</section>

<!-- Nueva Sección: Tabla de Alertas de Inventario -->
<section id="idTablaNotificacion" class="alerts-section">
    <div class="alerts-header">
        <h2 class="section-title">
            <i class="fas fa-exclamation-triangle warning-icon"></i>
            Alertas de Inventario Bajo
        </h2>
        <div class="header-actions">
            <div class="search-container">
                <input type="text" 
                    id="searchAlerts" 
                    placeholder="Buscar productos..." 
                    class="search-input">
                <i class="fas fa-search search-icon"></i>
            </div>
            <button class="btn-refresh" onclick="alertsTable.cargarAlertasInventario()">
                <i class="fas fa-sync-alt"></i> Actualizar
            </button>
        </div>
    </div>
    
    <div class="table-container">
        <table class="alerts-table" id="alertsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Especificación</th>
                    <th>Talla</th>
                    <th>Cantidad Actual</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <!-- Los datos se cargarán aquí dinámicamente -->
                <tr class="loading-row">
                    <td colspan="6">
                        <div class="loading-spinner">
                            <i class="fas fa-spinner fa-spin"></i>
                            Cargando alertas...
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div class="table-footer">
            <div class="pagination-info" id="paginationInfo">
                Mostrando <span id="startRow">0</span>-<span id="endRow">0</span> de 
                <span id="totalRows">0</span> productos
            </div>
            
            <div class="pagination-controls">
                <button class="pagination-btn first-page" onclick="alertsTable.goToFirstPage()" disabled>
                    <i class="fas fa-angle-double-left"></i>
                </button>
                <button class="pagination-btn prev-page" onclick="alertsTable.goToPrevPage()" disabled>
                    <i class="fas fa-angle-left"></i>
                </button>
                
                <div class="page-numbers" id="pageNumbers">
                    <!-- Números de página se generarán aquí -->
                </div>
                
                <button class="pagination-btn next-page" onclick="alertsTable.goToNextPage()" disabled>
                    <i class="fas fa-angle-right"></i>
                </button>
                <button class="pagination-btn last-page" onclick="alertsTable.goToLastPage()" disabled>
                    <i class="fas fa-angle-double-right"></i>
                </button>
            </div>
            
            <div class="table-actions">
                <select id="rowsPerPage" class="rows-select" onchange="alertsTable.changeRowsPerPage(this.value)">
                    <option value="5">5 filas</option>
                    <option value="10" selected>10 filas</option>
                    <option value="20">20 filas</option>
                    <option value="50">50 filas</option>
                </select>
                <button class="btn-export" onclick="alertsTable.exportarAlertas()">
                    <i class="fas fa-download"></i> Exportar
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Scripts -->
<script src="../../js/Cards_Informativas_Dashboard.js"></script>
<script src="../../js/Graficas/GraficaConteoRequisicionesDia.js"></script>
<script src="../../js/Notificacion_Alert_Inventario.js"></script>

<?php include('footer.php'); ?>