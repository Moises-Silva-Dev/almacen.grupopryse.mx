document.addEventListener("DOMContentLoaded", function () {
    // Selecciona el elemento de la tabla con el ID "tablaSolicitudes"
    const table = document.getElementById("tablaSolicitudes");
    
    // Verifica si el elemento de la tabla existe
    if (table) {
        // Selecciona todas las filas dentro del tbody de la tabla
        const rows = table.querySelectorAll("tbody tr");

        // Itera sobre cada fila
        rows.forEach(row => {
            // Obtiene el contenido de texto de la cuarta celda (índice 3) en la fila actual y elimina cualquier espacio en blanco alrededor
            const status = row.children[3].innerText.trim();

            // Verifica si el estado es "Parcial" o "Surtido"
            if (["Parcial", "Surtido"].includes(status)) {
                // Selecciona todos los elementos anchor (enlaces) con la clase "btn" dentro de la fila actual
                const buttons = row.querySelectorAll("a.btn");

                // Itera sobre cada botón
                buttons.forEach(button => {
                    // Agrega la clase "disabled" al botón
                    button.classList.add("disabled");
                    // Establece el atributo "aria-disabled" en "true" para propósitos de accesibilidad
                    button.setAttribute("aria-disabled", "true");
                    // Elimina el atributo "href" del botón para deshabilitarlo como enlace
                    button.removeAttribute("href");
                });
            }
        });
    }
});