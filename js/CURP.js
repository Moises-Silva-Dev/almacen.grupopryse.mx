// Funcion que se encarga de validar el CURP
function handleCurpInput() { 
    // Obtiene el elemento de entrada del DOM con el ID 'CURP'
    var curpInput = document.getElementById('CURP');
    
    // Convierte el valor actual del campo a mayúsculas
    var curpValue = curpInput.value.toUpperCase();

    // Verifica si el valor tiene una longitud de 4 caracteres o menos
    if (curpValue.length <= 4) {
        // Permite solo letras (A-Z) para los primeros 4 caracteres
        if (!/^[A-Z]+$/.test(curpValue)) {
            // Si no cumple, recorta el valor a los primeros 4 caracteres válidos
            curpInput.value = curpValue.substring(0, 4);
        }
    } 
    // Verifica si el valor tiene una longitud entre 5 y 10 caracteres
    else if (curpValue.length <= 10) {
        // Obtiene la parte numérica del CURP después de los primeros 4 caracteres
        var numericPart = curpValue.substring(4);
        
        // Permite solo números (0-9) en esta sección
        if (!/^\d+$/.test(numericPart)) {
            // Si no cumple, recorta el valor hasta los primeros 4 caracteres
            curpInput.value = curpValue.substring(0, 4);
        }
    } 
    // Verifica si el valor tiene una longitud entre 11 y 16 caracteres
    else if (curpValue.length <= 16) {
        // Obtiene la parte de letras después de los primeros 10 caracteres
        var letterPart = curpValue.substring(10);
        
        // Permite solo letras (A-Z) en esta sección
        if (!/^[A-Z]+$/.test(letterPart)) {
            // Si no cumple, recorta el valor hasta los primeros 10 caracteres
            curpInput.value = curpValue.substring(0, 10);
        }
    } 
    // Verifica si el valor tiene una longitud entre 17 y 18 caracteres
    else if (curpValue.length <= 18) {
        // Obtiene la parte de los últimos 2 caracteres
        var lastPart = curpValue.substring(16);
        
        // Permite letras (A-Z) o números (0-9) en esta sección
        if (!/^[A-Z0-9]+$/.test(lastPart)) {
            // Si no cumple, recorta el valor hasta los primeros 16 caracteres
            curpInput.value = curpValue.substring(0, 16);
        }
    }
}

// Vincula la función handleCurpInput al evento 'input' del campo CURP
var curpInput = document.getElementById('CURP'); 
if (curpInput) { 
    // Solo se agrega el evento si el campo CURP existe en el DOM
    curpInput.addEventListener('input', handleCurpInput);
}