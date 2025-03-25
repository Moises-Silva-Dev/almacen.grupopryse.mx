// Función que devuelve la requisición al usuario correspondiente
function SolicitarModificacionRequisicion(id) {
    Swal.fire({
        title: '¿Estás seguro?', // título
        text: "Esta acción no se puede deshacer.", // mensaje
        icon: 'warning', // icono: advertencia
        input: 'textarea', // campo de entrada para comentarios
        inputPlaceholder: 'Escribe un comentario...', // texto de ayuda
        showCancelButton: true, // mostrar botón de cancelar
        confirmButtonColor: '#d33', // color del botón de confirmación
        cancelButtonColor: '#3085d6', // color del botón de cancelar
        confirmButtonText: 'Sí, Solicitar Modificación', // texto del botón de confirmación
        cancelButtonText: 'Cancelar', // texto del botón de cancelar
        inputValidator: (value) => {
            if (!value.trim()) { // si no hay comentario
                return 'Debes ingresar un comentario para continuar.'; // si no hay comentario, mostrar mensaje
            }
        }
    }).then((result) => {
        if (result.isConfirmed) { // si se confirma
            const comentario = result.value; // obtener el comentario ingresado

            fetch(`../../Controlador/GET/Solicitar_Modificacion_Requisicion.php?id=${id}`, {
                method: 'POST', // cambiar a POST para enviar datos
                headers: {
                    'Content-Type': 'application/json' // tipo de contenido: JSON
                },
                body: JSON.stringify({ id, comentario }) // Enviar ID y comentario como JSON
            })
            .then(response => response.json()) // convertir la respuesta a JSON
            .then(data => {
                if (data.success) { // si la respuesta es exitosa
                    Swal.fire({
                        icon: 'success', // icono: éxito
                        title: '¡Modificación solicitada!', // título
                        text: data.message, // mostrar mensaje personalizado
                        timer: 1500, // tiempo en ms para cerrar la alerta
                        showConfirmButton: false, // mostrar botón de confirmación
                    }).then(() => {
                        window.location.href = data.redirect; // redireccionar si es necesario
                    });
                } else { // si hay un error
                    Swal.fire({
                        icon: 'error', // icono: error
                        title: 'Error', // título
                        text: data.message, // mostrar mensaje personalizado
                    });
                }
            })
            .catch(error => { // si hay un error en la solicitud
                console.error('Error en la solicitud:', error); // si hay un error, mostrar en consola
                Swal.fire({
                    icon: 'error', // icono: error
                    title: 'Error', // título
                    text: 'Hubo un problema al procesar la solicitud.', // mensaje
                });
            });
        }
    });
}