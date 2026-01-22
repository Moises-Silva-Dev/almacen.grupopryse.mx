// Función llamada por el botón al hacer clic
function Generar_PDF_Inventario(event) {
    event.preventDefault();

    var url = '../../Controlador/Reportes/Reporte_Inventario.php';

    fetch(url, {
        method: 'GET',
    })
    .then(response => {
        const contentType = response.headers.get('Content-Type');
        
        if (contentType && contentType.includes('application/json')) {
            return response.json().then(json => {
                if (json.error) {
                    document.getElementById('errorMessage').innerText = json.error;
                    
                    // Código nativo (igual que ya tenías aquí)
                    var myModalError = new bootstrap.Modal(document.getElementById('pdfModalERROR'));
                    myModalError.show();
                }
            });
        } else {
            return response.blob().then(blob => {
                var pdfUrl = URL.createObjectURL(blob);
                document.getElementById('pdfIframe').src = pdfUrl;

                var pdfModalElement = document.getElementById('pdfModal');
                var myModal = new bootstrap.Modal(pdfModalElement);
                myModal.show();
            });
        }
    })
    .catch(error => console.error('Error:', error));
}

document.addEventListener('DOMContentLoaded', function() {
    var pdfModal = document.getElementById('pdfModal');
    if (pdfModal) {
        pdfModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('pdfIframe').src = '';
        });
    }
});