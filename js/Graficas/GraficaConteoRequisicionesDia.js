// Graficar el conteo de requisiciones por día del mes actual
async function cargarDatos() {
    try {
        // Realiza una solicitud para obtener los datos de la gráfica
        const respuesta = await fetch('../../Controlador/GET/getGraficaRequisicionXDia.php');
        const datos = await respuesta.json(); // Convierte la respuesta a formato JSON

        // Obtiene los datos de la gráfica
        const labels = datos.map(d => d.label);
        const valores = datos.map(d => d.total);

        // Obtiene el contexto del canvas para la gráfica
        const ctx = document.getElementById('graficaRequisiciones').getContext('2d'); 
        new Chart(ctx, {
            type: 'line', // Tipo de gráfica: línea
            data: { // Configura los datos de la gráfica
                labels: labels, // Etiquetas para el eje X (días del mes)
                datasets: [{ // Conjunto de datos para la gráfica
                    label: 'Requisiciones por día', // Etiqueta del conjunto de datos
                    data: valores, // Datos para el eje Y (número de requisiciones)
                    fill: false, // No llenar el área bajo la línea
                    borderColor: 'rgba(54, 162, 235, 0.6)', // Color del borde de la línea
                    backgroundColor: 'rgba(54, 162, 235, 1)', // Color de fondo de los puntos
                    tension: 0.3, // Tensión de la curva de la línea
                    pointRadius: 5, // Radio de los puntos en la gráfica
                    pointHoverRadius: 7 // Radio de los puntos al pasar el cursor
                }]
            },
            options: { // Configura las opciones de la gráfica
                responsive: true, // Hacer la gráfica responsiva
                plugins: { // Configura los plugins de la gráfica
                    legend: { // Configura la leyenda de la gráfica
                        position: 'right' // Posición de la leyenda
                    },
                    title: { // Configura el título de la gráfica
                        display: true, // Mostrar el título
                        text: 'Total de Requisiciones del mes' // Texto del título
                    }
                },
                scales: { // Configura los ejes de la gráfica
                    y: { // Configura el eje Y
                        title: { // Configura el título del eje Y
                            display: true, // Mostrar el título
                            text: 'Número de Requisiciones' // Texto del título
                        },
                        beginAtZero: true, // Comenzar desde cero
                        ticks: { // Configura las marcas del eje Y
                            stepSize: 1, // Espacio entre marcas
                            callback: function(value) { // Formatea las marcas del eje Y
                                return Number.isInteger(value) ? value : ''; // Mostrar solo números enteros
                            }
                        }
                    },
                    x: { // Configura el eje X
                        title: { // Configura el título del eje X
                            display: true, // Mostrar el título
                        },
                        ticks: { // Configura las marcas del eje X
                            callback: function(value, index, ticks) { // Formatea las marcas del eje X
                                return this.getLabelForValue(value); // Mostrar las etiquetas de los días
                            },
                            autoSkip: false, // No saltar marcas automáticamente
                            precision: 0, // Precisión de las marcas
                            stepSize: 1 // Espacio entre marcas
                        }
                    }
                }
            }
        });
    } catch (error) { // Captura cualquier error durante la solicitud o procesamiento de datos
        // Maneja errores de la solicitud
        console.error('Error al cargar los datos:', error);
    }
}

// Llama a la función para cargar los datos al cargar la página
cargarDatos();