//Este codigo oculta la fila si su estatus es Surtido
document.addEventListener('DOMContentLoaded', function () {
    // Selecciona la tabla
    var table = document.getElementById('requisicionesTable');
    // Selecciona el cuerpo de la tabla
    var tbody = table.querySelector('tbody');

    // Obtiene todas las filas del cuerpo de la tabla
    var rows = tbody.getElementsByTagName('tr');

    // Recorre las filas en orden inverso para poder eliminar sin problemas
    for (var i = rows.length - 1; i >= 0; i--) {
        //Representa la fila de la tabla
        var row = rows[i];
        // La columna del estatus es la primera (índice 1)
        var estatusCell = row.cells[1]; 

        // Si el estatus es 'Surtido'
        if (estatusCell.textContent.trim() === 'Surtido') {
            // Elimina la fila del Row para mostrar en la tabla
            tbody.removeChild(row);
        }
    }
});