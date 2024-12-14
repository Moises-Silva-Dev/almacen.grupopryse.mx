//Codigo Javascript para actualizar los atributos 'min' y 'max' de las fechas en los formularios de entrada y salidas de almacen
    function configurarValidacionFechas() {
        // Obtener referencias al nombre del formulario
        const entradasForm = document.getElementById('entradasFormFechas');
        const salidasForm = document.getElementById('salidasFormFechas');
        const solicitudForm = document.getElementById('solicitudFormFechas');

        // Obtener referencias a los campos de fecha de ambos formularios
        const fechaInicioEntradas = entradasForm.querySelector('#Fecha_Inicio');
        const fechaFinEntradas = entradasForm.querySelector('#Fecha_Fin');
        const fechaInicioSalidas = salidasForm.querySelector('#Fecha_Inicio');
        const fechaFinSalidas = salidasForm.querySelector('#Fecha_Fin');
        const fechaInicioSolicitud = solicitudForm.querySelector('#Fecha_Inicio');
        const fechaFinSolicitud = solicitudForm.querySelector('#Fecha_Fin');

        // Función para actualizar los atributos 'min' y 'max' de las fechas
        function actualizarAtributosFecha(fechaInicio, fechaFin) {
            fechaFin.min = fechaInicio.value; // Establecer el mínimo de Fecha_Fin como Fecha_Inicio seleccionada
            fechaInicio.max = fechaFin.value; // Establecer el máximo de Fecha_Inicio como Fecha_Fin seleccionada
        }

        // Evento para actualizar los atributos de Fecha_Fin en el formulario de Entradas
        fechaInicioEntradas.addEventListener('change', function() {
            actualizarAtributosFecha(fechaInicioEntradas, fechaFinEntradas);
        });

        // Evento para actualizar los atributos de Fecha_Inicio en el formulario de Entradas
        fechaFinEntradas.addEventListener('change', function() {
            actualizarAtributosFecha(fechaInicioEntradas, fechaFinEntradas);
        });

        // Evento para actualizar los atributos de Fecha_Fin en el formulario de Salidas
        fechaInicioSalidas.addEventListener('change', function() {
            actualizarAtributosFecha(fechaInicioSalidas, fechaFinSalidas);
        });

        // Evento para actualizar los atributos de Fecha_Inicio en el formulario de Salidas
        fechaFinSalidas.addEventListener('change', function() {
            actualizarAtributosFecha(fechaInicioSalidas, fechaFinSalidas);
        });
        
        // Evento para actualizar los atributos de Fecha_Fin en el formulario de solicitud
        fechaInicioSolicitud.addEventListener('change', function() {
            actualizarAtributosFecha(fechaInicioSolicitud, fechaFinSolicitud);
        });

        // Evento para actualizar los atributos de Fecha_Inicio en el formulario de solicitud
        fechaFinSolicitud.addEventListener('change', function() {
            actualizarAtributosFecha(fechaInicioSolicitud, fechaFinSolicitud);
        });
    }

    // Llamar a la función al cargar la página para configurar la validación de fechas
    document.addEventListener('DOMContentLoaded', function() {
        configurarValidacionFechas();
    });