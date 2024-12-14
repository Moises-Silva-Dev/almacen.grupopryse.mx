// Espera a que el DOM esté completamente cargado antes de ejecutar el código.
$(document).ready(function() {
    // Función para validar la contraseña según los criterios especificados.
    function validatePassword() {
        var password = $("#contrasena").val(); // Obtiene el valor del campo de contraseña.
        // Validaciones individuales para los criterios de la contraseña.
        var length = password.length >= 8; // Verifica si tiene al menos 8 caracteres.
        var uppercase = /[A-Z]/.test(password); // Verifica si tiene al menos una letra mayúscula.
        var lowercase = /[a-z]/.test(password); // Verifica si tiene al menos una letra minúscula.
        var number = /\d/.test(password); // Verifica si tiene al menos un número.
        var special = /[!@#$%^&*(),.?":{}|<>-_]/.test(password); // Verifica si tiene al menos un carácter especial.

        // Cambia la clase del elemento según si el criterio se cumple o no.
        $("#length").toggleClass("valid", length); // Marca válido o no el criterio de longitud.
        $("#uppercase").toggleClass("valid", uppercase); // Marca válido o no el criterio de mayúscula.
        $("#lowercase").toggleClass("valid", lowercase); // Marca válido o no el criterio de minúscula.
        $("#number").toggleClass("valid", number); // Marca válido o no el criterio de número.
        $("#special").toggleClass("valid", special); // Marca válido o no el criterio de carácter especial.

        // Retorna `true` si todos los criterios se cumplen, de lo contrario `false`.
        return length && uppercase && lowercase && number && special;
    }

    // Función para verificar si las contraseñas coinciden.
    function checkPasswordsMatch() {
        var password = $("#contrasena").val(); // Obtiene el valor de la contraseña.
        var valPassword = $("#valcontrasena").val(); // Obtiene el valor de la confirmación de contraseña.
        var match = password === valPassword; // Compara si las contraseñas son iguales.

        // Cambia las clases del campo de confirmación según si coinciden o no.
        $("#valcontrasena").toggleClass("is-valid", match); // Aplica la clase `is-valid` si coinciden.
        $("#valcontrasena").toggleClass("is-invalid", !match); // Aplica la clase `is-invalid` si no coinciden.

        return match; // Retorna `true` si coinciden, de lo contrario `false`.
    }

    // Evento `keyup` para validar la contraseña y verificar coincidencia en tiempo real.
    $("#contrasena, #valcontrasena").on("keyup", function() {
        var validPassword = validatePassword(); // Valida la contraseña según los criterios.
        var passwordsMatch = checkPasswordsMatch(); // Verifica si las contraseñas coinciden.
        // Habilita o deshabilita el botón de enviar según ambas condiciones.
        $("#submitBtn").prop("disabled", !(validPassword && passwordsMatch));
    });

    // Evento para alternar la visibilidad de la contraseña principal.
    $("#togglePassword").on("click", function() {
        var passwordInput = $("#contrasena"); // Obtiene el campo de la contraseña principal.
        // Alterna el tipo de input entre `text` y `password`.
        var type = passwordInput.attr("type") === "password" ? "text" : "password";
        passwordInput.attr("type", type); // Actualiza el atributo del tipo de input.
        // Cambia el ícono del botón entre ojo abierto y cerrado.
        $(this).find("i").toggleClass("fa-eye fa-eye-slash");
    });

    // Evento para alternar la visibilidad del campo de confirmación de contraseña.
    $("#toggleValPassword").on("click", function() {
        var passwordInput = $("#valcontrasena"); // Obtiene el campo de confirmación de contraseña.
        // Alterna el tipo de input entre `text` y `password`.
        var type = passwordInput.attr("type") === "password" ? "text" : "password";
        passwordInput.attr("type", type); // Actualiza el atributo del tipo de input.
        // Cambia el ícono del botón entre ojo abierto y cerrado.
        $(this).find("i").toggleClass("fa-eye fa-eye-slash");
    });
});