function DarAltaInventarioEntrada(id) {
    Swal.fire({
        title: '¿Confirmar entrada?',
        text: "Se actualizará el stock del inventario.",
        icon: 'warning', // 'warning' suele ser más estándar para acciones irreversibles
        showCancelButton: true,
        confirmButtonColor: '#28a745', // Verde para "Dar de alta"
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, registrar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true, // Muestra un spinner mientras carga
        preConfirm: () => {
            // Retornamos el fetch para que SweetAlert gestione el estado de carga
            return fetch(`../../Controlador/GET/Dar_Alta_Entrada_Producto_Inventario.php?id=${id}`, {
                method: 'GET'
            })
            .then(response => {
                if (!response.ok) throw new Error('Error en la respuesta del servidor');
                return response.json();
            })
            .catch(error => {
                Swal.showValidationMessage(`Solicitud fallida: ${error}`);
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed && result.value.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Logrado!',
                text: result.value.message,
                timer: 1500,
                showConfirmButton: false
            }).then(() => location.reload());
        } else if (result.isConfirmed && !result.value.success) {
            Swal.fire('Error', result.value.message, 'error');
        }
    });
}