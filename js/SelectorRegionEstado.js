document.getElementById('ID_Region').addEventListener('change', function() {
    // Obtener el valor seleccionado del elemento con ID 'ID_Region'
    const regionId = this.value;
    
    // Verificar si regionId tiene algún valor seleccionado
    if (regionId) {
        // Realizar una solicitud fetch para obtener datos de estados
        fetch('../../../Controlador/GET/getObtenerEstado.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            // Enviar el ID de región seleccionado como datos en el cuerpo de la solicitud
            body: 'ID_Region=' + regionId
        })
        // Procesar la respuesta como JSON
        .then(response => response.json())
        .then(data => {
            // Obtener el elemento select para los estados
            const estadoSelect = document.getElementById('ID_Estados');
            // Limpiar cualquier opción previamente seleccionada
            estadoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar un Estado --</option>';
            
            // Iterar sobre los datos recibidos
            data.forEach(estado => {
                // Crear una nueva opción para cada estado
                const option = document.createElement('option');
                option.value = estado.Id_Estado; // Asignar el valor del ID de estado
                option.textContent = estado.Nombre_estado; // Asignar el texto del nombre de estado
                // Agregar la opción al select de estados
                estadoSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching estados:', error)); // Manejar errores de la solicitud fetch
    }
});