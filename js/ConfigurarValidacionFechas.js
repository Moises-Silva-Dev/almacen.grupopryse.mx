// Configurar validación de fechas
function configurarValidacionFechas() {
    const forms = ['entradasFormFechas', 'salidasFormFechas', 'solicitudFormFechas', 'conteoSalidaSolicitudFormFechas'];
    
    forms.forEach(formId => {
        const form = document.getElementById(formId);
        if (form) {
            const fechaInicio = form.querySelector('input[type="date"][name="Fecha_Inicio"]');
            const fechaFin = form.querySelector('input[type="date"][name="Fecha_Fin"]');
            
            if (fechaInicio && fechaFin) {
                fechaInicio.addEventListener('change', function() {
                    if (this.value) {
                        fechaFin.min = this.value;
                    }
                });
                
                fechaFin.addEventListener('change', function() {
                    if (this.value) {
                        fechaInicio.max = this.value;
                    }
                });
            }
        }
    });
}

// Validación de formularios
function configurarValidaciones() {
    // Validación para campos numéricos
    const numericInputs = document.querySelectorAll('input[pattern="[0-9]+"]');
    numericInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            if (!/^\d*$/.test(e.target.value)) {
                e.target.value = e.target.value.replace(/[^\d]/g, '');
            }
        });
    });
    
    // Validación de formularios Bootstrap
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
}

// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    configurarValidacionFechas();
    configurarValidaciones();
    
    // Inicializar tooltips de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Función para mostrar modal de error (si mantienes tu modal)
function mostrarError(mensaje) {
    const modal = new bootstrap.Modal(document.getElementById('pdfModalERROR'));
    document.getElementById('errorMessage').textContent = mensaje;
    modal.show();
}