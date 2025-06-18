// Función para mostrar las fotos en el modal
function mostrarProducto(idPersona) {
    // Hacer una solicitud al backend para obtener las fotos
    fetch(`../../Controlador/GET/getObtenerFotoProductoInfo.php?id=${idPersona}`)
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => {
            if (data.success) {
                // Llenar los campos del modal con los datos obtenidos
                document.getElementById("productoIMG").src = data.producto.IMG;
                document.getElementById("productoDescripcion").innerText = data.producto.Descripcion;
                document.getElementById("productoEspecificacion").innerText = data.producto.Especificacion;
                document.getElementById("productoEmpresa").innerText = data.producto.Nombre_Empresa;
                document.getElementById("productoCategoria").innerText = data.producto.Descrp; 
                document.getElementById("productoTipoTalla").innerText = data.producto.Descrip;

                // Mostrar el modal
                var productoModal = new bootstrap.Modal(document.getElementById('productoModal'));
                productoModal.show();
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