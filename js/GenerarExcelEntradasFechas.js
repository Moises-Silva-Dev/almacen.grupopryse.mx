// Función para generar y descargar un archivo Excel basado en las fechas seleccionadas en el formulario
function Generar_Excel_Entradas_Fechas(event) {
    // Previene el comportamiento por defecto del formulario (evita el envío de formulario y recarga de la página)
    event.preventDefault();
        
    // Obtener el formulario de entradas por su ID
    var form = document.getElementById('entradasFormFechas');
        
    // Verificar si el formulario es válido
    if (!form.checkValidity()) {
        // Agregar una clase CSS al formulario para mostrar mensajes de validación visuales
        form.classList.add('was-validated');
        return; // Salir de la función si el formulario no es válido
    }

    // Obtener las fechas seleccionadas del formulario como un objeto FormData
    var formData = new FormData(form);
        
    // Especificar la URL del script PHP que genera el archivo Excel
    var url = '../../Controlador/EXCEL/Excel_Entrada_Almacen_Por_Fechas.php';

    // Usar fetch para enviar los datos del formulario al servidor con el método POST
    fetch(url, {
        method: 'POST', // Indica que los datos se enviarán con POST
        body: formData  // Carga los datos del formulario como cuerpo de la solicitud
    })
    // Convertir la respuesta a un objeto Blob (representación binaria del archivo generado)
    .then(response => response.blob()) 
    .then(blob => {
        // Crear una URL temporal para el Blob generado
        var url = URL.createObjectURL(blob);
            
        // Crear un elemento <a> para descargar el archivo Excel
        var a = document.createElement('a');
        a.href = url; // Asignar la URL del archivo al atributo href del elemento
        a.download = 'Entradas_Almacen_' + 
            new Date().toISOString().slice(0, 19) // Obtener la fecha y hora actual en formato ISO
            .replace(/[-T]/g, '_') // Reemplazar caracteres no válidos en nombres de archivo
            .replace(/:/g, '-') + 
            '.xlsx'; // Agregar extensión .xlsx al archivo
        
        // Agregar el elemento <a> al DOM, simular un clic para iniciar la descarga, y luego eliminarlo
        document.body.appendChild(a); // Agregar el elemento temporalmente al DOM
        a.click(); // Simular un clic para iniciar la descarga
        document.body.removeChild(a); // Eliminar el elemento <a> después de la descarga
            
        // Revocar la URL temporal para liberar memoria
        URL.revokeObjectURL(url);
    })
    // Manejar errores si ocurren durante la solicitud fetch
    .catch(error => console.error('Error:', error)); 
}