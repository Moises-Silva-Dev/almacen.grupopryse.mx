// js/Graficas/GraficaConteoRequisicionesDia.js
let chartInstance = null;

async function cargarDatosMes(usuario) {
    try {
        const respuesta = await fetch('../../Controlador/GET/Graficas/getGraficaRequisicionXDia.php?idUsuario=' + usuario);
        const datos = await respuesta.json();
        
        actualizarGrafica(datos, 'Mes Actual');
    } catch (error) {
        console.error('Error al cargar datos del mes:', error);
        mostrarErrorEnGrafica('Error al cargar datos del mes');
    }
}

async function cargarDatosSemana(usuario) {
    try {
        const respuesta = await fetch('../../Controlador/GET/Graficas/getGraficaRequisicionXSemana.php?idUsuario=' + usuario);
        const datos = await respuesta.json();
        
        // Extraer solo los datos de la gráfica
        const datosGrafica = datos.datos || datos;
        actualizarGrafica(datosGrafica, 'Esta Semana');
        
        // Actualizar información adicional si existe
        if (datos.info_semana) {
            actualizarInfoSemana(datos.info_semana);
        }
    } catch (error) {
        console.error('Error al cargar datos de la semana:', error);
        mostrarErrorEnGrafica('Error al cargar datos de la semana');
    }
}

function actualizarGrafica(datos, titulo) {
    const ctx = document.getElementById('graficaRequisiciones').getContext('2d');
    
    // Destruir gráfica anterior si existe
    if (chartInstance) {
        chartInstance.destroy();
    }
    
    // Preparar datos para la gráfica
    const labels = datos.map(d => d.label);
    const valores = datos.map(d => d.total);
    
    // Determinar color según período
    const colorBorde = titulo.includes('Semana') ? '#40E0D0' : '#001F3F';
    const colorFondo = titulo.includes('Semana') ? 'rgba(64, 224, 208, 0.1)' : 'rgba(0, 31, 63, 0.1)';
    
    chartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Requisiciones',
                data: valores,
                fill: true,
                backgroundColor: colorFondo,
                borderColor: colorBorde,
                borderWidth: 3,
                tension: 0.4,
                pointBackgroundColor: '#FFFFFF',
                pointBorderColor: colorBorde,
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: '#001F3F',
                        font: {
                            size: 14,
                            weight: '600'
                        }
                    }
                },
                title: {
                    display: true,
                    text: titulo,
                    color: '#001F3F',
                    font: {
                        size: 16,
                        weight: '700'
                    },
                    padding: {
                        bottom: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 31, 63, 0.9)',
                    titleColor: '#FFFFFF',
                    bodyColor: '#FFFFFF',
                    borderColor: '#40E0D0',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return `Requisiciones: ${context.raw}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        color: '#495057',
                        font: {
                            size: 12
                        },
                        stepSize: 1,
                        precision: 0
                    },
                    title: {
                        display: true,
                        text: 'Número de Requisiciones',
                        color: '#001F3F',
                        font: {
                            size: 14,
                            weight: '600'
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        color: '#495057',
                        font: {
                            size: 12
                        },
                        maxRotation: 45
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animations: {
                tension: {
                    duration: 1000,
                    easing: 'linear'
                }
            }
        }
    });
}

function actualizarInfoSemana(info) {
    // Crear o actualizar elemento de información
    let infoElement = document.getElementById('info-semana');
    if (!infoElement) {
        infoElement = document.createElement('div');
        infoElement.id = 'info-semana';
        infoElement.className = 'chart-info';
        document.querySelector('.chart-container').appendChild(infoElement);
    }
    
    infoElement.innerHTML = `
        <div class="info-item">
            <span class="info-label">Semana:</span>
            <span class="info-value">${info.semana_del} - ${info.semana_al}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Total semana:</span>
            <span class="info-value highlight">${info.total_semana} requisiciones</span>
        </div>
    `;
}

function mostrarErrorEnGrafica(mensaje) {
    const ctx = document.getElementById('graficaRequisiciones').getContext('2d');
    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
    
    ctx.font = '16px Arial';
    ctx.fillStyle = '#DC3545';
    ctx.textAlign = 'center';
    ctx.fillText(mensaje, ctx.canvas.width/2, ctx.canvas.height/2);
}

// Cargar datos al inicio
document.addEventListener('DOMContentLoaded', function() {
    // Cargar gráfica del mes por defecto
    cargarDatosMes(usuario);
    
    // Controlar período de la gráfica
    document.querySelectorAll('.btn-chart-control').forEach(button => {
        button.addEventListener('click', function() {
            const periodo = this.getAttribute('data-period');
            
            // Actualizar botones activos
            document.querySelectorAll('.btn-chart-control').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            
            // Cargar datos según período
            if (periodo === 'week') {
                cargarDatosSemana(usuario);
            } else {
                cargarDatosMes(usuario);
            }
            
            // Limpiar información de semana si existe
            const infoElement = document.getElementById('info-semana');
            if (infoElement && periodo === 'month') {
                infoElement.remove();
            }
        });
    });
});

// Añade este CSS para la información de la semana
const style = document.createElement('style');
style.textContent = `
    .chart-info {
        background: rgba(0, 31, 63, 0.05);
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1.5rem;
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .info-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.3rem;
    }
    
    .info-label {
        font-size: 0.85rem;
        color: #495057;
        font-weight: 500;
    }
    
    .info-value {
        font-size: 1.1rem;
        color: #001F3F;
        font-weight: 600;
    }
    
    .info-value.highlight {
        color: #40E0D0;
        font-size: 1.2rem;
    }
    
    @media (max-width: 768px) {
        .chart-info {
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }
    }
`;

document.head.appendChild(style);