$(document).ready(function() {
    // Cuando se seleccione una cuenta
    $('#ID_Cuenta').on('change', function() {
        // Obtener el ID de la cuenta seleccionada
        const cuentaId = $(this).val();
        
        //Si ya tiene un valor
        if (cuentaId) {
            // Realizar una solicitud AJAX para obtener las regiones asociadas a la cuenta seleccionada
            $.ajax({
                type: 'POST',
                //Dirección de la busqueda
                url: '../../../Controlador/GET/getSolicitud_ObtenerRegion.php',
                data: { ID_Cuenta: cuentaId },
                success: function(response) {
                    // Parsear la respuesta JSON del servidor
                    const regiones = JSON.parse(response);
                    // Actualizar el select de regiones con las opciones obtenidas
                    $('#Region').html('<option value="" selected disabled>-- Seleccionar Región --</option>');
                    regiones.forEach(function(region) {
                        $('#Region').append('<option value="' + region.ID_Region + '">' + region.Nombre_Region + '</option>');
                    });
                },
                error: function() {
                    // Mostrar una alerta en caso de error en la solicitud
                    alert('Error al cargar las regiones');
                }
            });
        } else {
            // Reiniciar el select de regiones y estados si no hay una cuenta seleccionada
            $('#Region').html('<option value="" selected disabled>-- Seleccionar Región --</option>');
            $('#Estado').html('<option value="" selected disabled>-- Seleccionar Estado --</option>');
        }
    });

    // Cuando se seleccione una región
    $('#Region').on('change', function() {
        // Obtener el ID de la región seleccionada
        const regionId = $(this).val();
        
        //Si ya tiene un valor
        if (regionId) {
            // Realizar una solicitud AJAX para obtener los estados asociados a la región seleccionada
            $.ajax({
                type: 'POST',
                //Dirección de la busqueda
                url: '../../../Controlador/GET/getSolicitud_ObtenerEstado.php',
                data: { ID_Region: regionId },
                success: function(response) {
                    // Parsear la respuesta JSON del servidor
                    const estados = JSON.parse(response);
                    // Actualizar el select de estados con las opciones obtenidas
                    $('#Estado').html('<option value="" selected disabled>-- Seleccionar Estado --</option>');
                    estados.forEach(function(estado) {
                        $('#Estado').append('<option value="' + estado.Id_Estado + '">' + estado.Nombre_estado + '</option>');
                    });
                },
                error: function() {
                    // Mostrar una alerta en caso de error en la solicitud
                    alert('Error al cargar los estados');
                }
            });
        } else {
            // Reiniciar el select de estados si no hay una región seleccionada
            $('#Estado').html('<option value="" selected disabled>-- Seleccionar Estado --</option>');
        }
    });
});