// Este se activa cuando se selecciona una opción del filtro de reclutas
document.addEventListener("DOMContentLoaded", function () {
    // Esta función se ejecuta cuando se selecciona una opción del filtro de reclutas
    function mostrarCampo() {
        // Obtenemos el elemento del selector de filtro de reclutas
        let filtro = document.getElementById("filtrar").value;
        
        // Obtenemos el elemento del campo a mostrar
        document.getElementById("campo-nombres").style.display = "none";
        document.getElementById("campo-estatus").style.display = "none";
        document.getElementById("campo-reclutador").style.display = "none";
        
        if (filtro === "CNombre") { // Si se selecciona la opción "Nombre"
            // Mostramos el campo de nombres
            document.getElementById("campo-nombres").style.display = "block";
        } else if (filtro === "CEstatus") { // Si se selecciona la opción "Estatus"
            // Mostramos el campo de estatus
            document.getElementById("campo-estatus").style.display = "block";
        } else if (filtro === "CReclutador") { // Si se selecciona la opción "Reclutador"
            // Mostramos el campo de reclutador
            document.getElementById("campo-reclutador").style.display = "block";
        }
    }
    
    // Agregamos un evento de cambio al selector de filtro de reclutas
    function resetFilters() {
        // Obtenemos el elemento del selector de filtro de reclutas
        document.getElementById("filtrar").value = "CNombre";
        // Mostramos el campo de nombres
        document.getElementById("campo-nombres").style.display = "block";
        // Ocultamos los campos de estatus y reclutador
        document.getElementById("campo-estatus").style.display = "none";
        document.getElementById("campo-reclutador").style.display = "none";
        // Llamamos a la función para mostrar el campo seleccionado
        document.getElementById("nombre").value = "";
        document.getElementById("estatus").value = "";
        document.getElementById("reclutador").value = "";
    }
    
    // Agregamos un evento de cambio al selector de filtro de reclutas  
    document.getElementById("filtrar").addEventListener("change", mostrarCampo);
    // Agregamos un evento de cambio al selector de filtro de reclutas
    document.querySelector("button[onclick='resetFilters()']").addEventListener("click", resetFilters);
    
    mostrarCampo(); // Ejecutar una vez para establecer el estado inicial
});