document.addEventListener('DOMContentLoaded', function() {
    cargarMetricas();
});

async function cargarMetricas() {
    try {
        // --- Cargar productos bajos en stock ---
        const res1 = await fetch('../../Controlador/GET/Dashboard/getProductosBajoStock.php'); // Hacemos el fetch primero
        const data1 = await res1.json();
        const cardBajoStock = document.getElementById('productosBajoStock'); 
        if (cardBajoStock) { // Verificamos si el elemento existe en este HTML antes de usarlo
            cardBajoStock.textContent = data1.total;
        }

        // --- Cargar entradas de hoy ---
        const res2 = await fetch('../../Controlador/GET/Dashboard/getEntradasProductosHoy.php');
        const data2 = await res2.json();
        const cardEntradas = document.getElementById('entradasHoy');
        if (cardEntradas) {
            cardEntradas.textContent = data2.total;
        }

        // --- Cargar salidas de hoy ---
        const res3 = await fetch('../../Controlador/GET/Dashboard/getSalidasRequisicionesHoy.php');
        const data3 = await res3.json();
        const cardSalidas = document.getElementById('salidasHoy');
        if (cardSalidas) {
            cardSalidas.textContent = data3.total;
        }

        // --- Cargar usuarios activos hoy ---
        // Probablemente esta sea la card que falta en "Almacén"
        const res4 = await fetch('../../Controlador/GET/Dashboard/getUsuariosActivos.php');
        const data4 = await res4.json();
        const cardUsuarios = document.getElementById('usuariosActivosHoy');
        if (cardUsuarios) {
            cardUsuarios.textContent = data4.total;
        }

        // --- Cargar requisiciones autorizadas hoy ---
        const res5 = await fetch('../../Controlador/GET/Dashboard/getRequisicionesAutorizadasHoy.php');
        const data5 = await res5.json();
        const cardRequisiciones = document.getElementById('requisicionesAutorizadasHoy');
        if (cardRequisiciones) {
            cardRequisiciones.textContent = data5.total;
        }

    } catch (error) {
        console.error('Error al cargar las métricas:', error);
    }
}