// Función para mostrar las fotos en el modal
function mostrarFotos(idPersona) {
    // Hacer una solicitud al backend para obtener las fotos
    fetch(`../../Controlador/GET/getObtenerFotosPersona.php?id=${idPersona}`)
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => {
            if (data.success) {
                // Mostrar las fotos en el modal
                document.getElementById('fotoFrente').src = "../../" + data.fotos.frente;
                document.getElementById('fotoIzquierda').src = "../../" + data.fotos.izquierda;
                document.getElementById('fotoDerecha').src = "../../" + data.fotos.derecha;

                // Mostrar el modal
                const fotosModal = new bootstrap.Modal(document.getElementById('fotosModal'));
                fotosModal.show(); // Mostrar el modal
            } else {
                // Mostrar error con SweetAlert2
                Swal.fire({
                    icon: 'error', // icono de error
                    title: 'Error', // título
                    text: 'Error al cargar las fotos: ' + data.message, // mensaje
                });
            }
        })
        // Manejo de errores de red
        .catch(error => {
            console.error('Error:', error);
            // Mostrar error con SweetAlert2
            Swal.fire({
                icon: 'error', // icono de error
                title: 'Error', // título
                text: 'Hubo un problema al cargar las fotos.', // mensaje
            });
        });
}