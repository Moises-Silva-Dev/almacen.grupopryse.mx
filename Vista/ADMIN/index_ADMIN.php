<?php include('head.php'); ?>

<!-- CSS Personalizado -->
<link rel="stylesheet" href="../../css/cards_informativas_dashboard.css">
<link rel="stylesheet" href="../../css/diseno_graficas.css">
<link rel="stylesheet" href="../../css/diseno_tabla_inventario.css">

<!-- Sección de Métricas -->
<section class="metrics-section">
    <h2 class="section-title">Dashboard de Actividad</h2>
    
    <div class="metrics-grid">
        <!-- Tarjeta 1: Requisiciones Pendientes -->
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

        <!-- Tarjeta 5: Requisiciones Autorizadas -->
        <div class="metric-card">
            <div class="metric-icon metric-icon-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="metric-content">
                <h3 class="metric-title">Requisiciones Autorizadas</h3>
                <div class="metric-value" id="requisicionesAutorizadasHoy">0</div>
                <p class="metric-description">Requisiciones autorizadas</p>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Gráfica -->
<section class="chart-section">
    <div class="chart-header">
        <h2 class="section-title">Requisiciones del Mes que existe</h2>
        <div class="chart-controls">
            <button class="btn-chart-control active" data-period="month">Este Mes</button>
            <button class="btn-chart-control" data-period="week">Esta Semana</button>
        </div>
    </div>
    <div class="chart-container">
        <canvas id="graficaRequisiciones"></canvas>
    </div>
</section>

<!-- Scripts -->
<script>
    var usuario = '<?php echo $usuario; ?>';
</script>
<script src="../../js/Cards_Informativas_Dashboard.js"></script>
<script src="../../js/Graficas/GraficaConteoRequisicionesXusuario.js"></script>

<?php include('footer.php'); ?>