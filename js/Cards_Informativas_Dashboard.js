// Script para el Dashboard
document.addEventListener('DOMContentLoaded', function() {
    // Cargar datos de métricas
    cargarMetricas();
});

async function cargarMetricas() {
    try {
        // Cargar productos bajos en stock
        const response1 = await fetch('../../Controlador/GET/Dashboard/getProductosBajoStock.php');
        const data1 = await response1.json();
        // console.log(data1);
        document.getElementById('productosBajoStock').textContent = data1.total;
        
        // Cargar entradas de hoy
        const response2 = await fetch('../../Controlador/GET/Dashboard/getEntradasProductosHoy.php');
        const data2 = await response2.json();
        // console.log(data2);
        document.getElementById('entradasHoy').textContent = data2.total;
        
        // Cargar salidas de hoy
        const response3 = await fetch('../../Controlador/GET/Dashboard/getSalidasRequisicionesHoy.php');
        const data3 = await response3.json();
        // console.log(data3);
        document.getElementById('salidasHoy').textContent = data3.total;
        
        // Cargar usuarios activos hoy
        const response4 = await fetch('../../Controlador/GET/Dashboard/getUsuariosActivos.php');
        const data4 = await response4.json();
        // console.log(data4);
        document.getElementById('usuariosActivosHoy').textContent = data4.total;
        
    } catch (error) {
        console.error('Error al cargar las métricas:', error);
    }
}