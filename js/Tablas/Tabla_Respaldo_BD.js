// Función para formatear tamaño de archivo
function formatSizeUnits(bytes) {
    if (bytes >= 1073741824) {
        return (bytes / 1073741824).toFixed(2) + ' GB';
    } else if (bytes >= 1048576) {
        return (bytes / 1048576).toFixed(2) + ' MB';
    } else if (bytes >= 1024) {
        return (bytes / 1024).toFixed(2) + ' KB';
    } else if (bytes > 1) {
        return bytes + ' bytes';
    } else if (bytes == 1) {
        return bytes + ' byte';
    } else {
        return '0 bytes';
    }
}

// Seleccionar todos los checkboxes
document.addEventListener('DOMContentLoaded', function() {
    const selectAllHeader = document.getElementById('selectAllBackups');
    const selectAllFooter = document.getElementById('selectAllBackupsFooter');
    
    if (selectAllHeader) {
        selectAllHeader.addEventListener('change', function(e) {
            const checkboxes = document.querySelectorAll('.backup-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
            if (selectAllFooter) {
                selectAllFooter.checked = e.target.checked;
            }
        });
    }
    
    if (selectAllFooter) {
        selectAllFooter.addEventListener('change', function(e) {
            const checkboxes = document.querySelectorAll('.backup-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
            if (selectAllHeader) {
                selectAllHeader.checked = e.target.checked;
            }
        });
    }
});