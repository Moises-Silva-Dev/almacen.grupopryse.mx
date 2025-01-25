// Función que devuelve la requisicion al usuario correspondiente
function SolicitarModificacionRequisicion(id) { 
    Swal.fire({
        title: '¿Estás seguro?', // título
        text: "Esta acción no se puede deshacer.", // mensaje
        icon: 'warning', // icono: advertencia
        showCancelButton: true, // mostrar botón de cancelar
        confirmButtonColor: '#d33', // color del botón de confirmación
        cancelButtonColor: '#3085d6', // color del botón de cancelar
        confirmButtonText: 'Sí, Solicitar Modificación', // texto del botón de confirmación
        cancelButtonText: 'Cancelar' // texto del botón de cancelar
    }).then((result) => {
        if (result.isConfirmed) { // si se confirma
            fetch(`../../Controlador/GET/Solicitar_Modificacion_Requisicion.php?id=${id}`, { // enviar solicitud GET
                method: 'GET', // método de la solicitud
            })
                .then(response => {
                    console.log("Estado HTTP:", response.status); // estado HTTP de la respuesta
                    return response.json(); // convertir la respuesta a JSON
                })
                .then(data => {
                    console.log("Respuesta del servidor:", data); // respuesta del servidor
                    if (data.success) { // si la respuesta es exitosa
                        Swal.fire({
                            icon: 'success', // icono: éxito
                            title: '¡Modificación exitosa!', // título
                            text: data.message, // mensaje
                            timer: 1500, // tiempo de duración de la ventana
                            showConfirmButton: false , // no mostrar botón de confirmación
                        }).then(() => {
                            window.location.href = data.redirect; // redireccionar a la URL indicada
                        });
                    } else {
                        Swal.fire({
                            icon: 'error', // icono: error
                            title: 'Error', // título
                            text: data.message , // mensaje
                        });
                    }
                })
                .catch(error => {
                    console.error('Error en la solicitud:', error); // error en la solicitud
                    Swal.fire({ 
                        icon: 'error', // icono: error
                        title: 'Error', // título
                        text: 'Hubo un problema al procesar la solicitud.' , // mensaje
                    });
                });            
        }
    });
}