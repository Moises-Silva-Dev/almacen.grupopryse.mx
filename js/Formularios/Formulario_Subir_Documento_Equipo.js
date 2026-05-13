// ==================== MODAL DE SUBIR DOCUMENTO PDF - JS COMPLETO ====================

let documentoModal;
let formularioDocumentoModificado = false;
let formularioDocumentoEnviado = false;

// ==================== FUNCIÓN PARA ABRIR EL MODAL ====================
function openDocumentoModal(equipoId) {
    if (!documentoModal) {
        documentoModal = new bootstrap.Modal(document.getElementById('subirDocumentoModal'));
    }
    
    // Resetear formulario
    const form = document.getElementById('FormSubirDocumento');
    if (form) {
        form.reset();
        document.querySelectorAll('#subirDocumentoModal .is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
    }
    
    // Ocultar info del archivo
    const infoDiv = document.getElementById('documento_info_archivo');
    if (infoDiv) infoDiv.style.display = 'none';
    
    // Establecer el ID del equipo
    document.getElementById('documento_id_equipo').value = equipoId;
    
    // Resetear flags
    formularioDocumentoModificado = false;
    formularioDocumentoEnviado = false;
    
    documentoModal.show();
}

// ==================== VALIDACIÓN DEL ARCHIVO ====================
function validarArchivoPDF(file) {
    // Validar que sea PDF
    if (file.type !== 'application/pdf') {
        Swal.fire({
            icon: 'warning',
            title: 'Formato no válido',
            text: 'Por favor, selecciona un archivo PDF válido.',
            confirmButtonColor: '#001F3F'
        });
        return false;
    }
    
    // Validar tamaño (10MB máximo)
    const maxSize = 10 * 1024 * 1024; // 10MB
    if (file.size > maxSize) {
        Swal.fire({
            icon: 'warning',
            title: 'Archivo muy grande',
            text: 'El archivo no debe exceder los 10MB.',
            confirmButtonColor: '#001F3F'
        });
        return false;
    }
    
    return true;
}

// ==================== VALIDACIÓN DEL FORMULARIO ====================
function validarFormularioDocumento() {
    const nombreDocumento = document.getElementById('documento_Nombre');
    const archivoInput = document.getElementById('documento_Archivo');
    
    let isValid = true;
    
    if (!nombreDocumento.value.trim()) {
        nombreDocumento.classList.add('is-invalid');
        isValid = false;
    } else {
        nombreDocumento.classList.remove('is-invalid');
    }
    
    if (!archivoInput.files || archivoInput.files.length === 0) {
        archivoInput.classList.add('is-invalid');
        isValid = false;
    } else {
        const file = archivoInput.files[0];
        if (!validarArchivoPDF(file)) {
            archivoInput.classList.add('is-invalid');
            isValid = false;
        } else {
            archivoInput.classList.remove('is-invalid');
        }
    }
    
    return isValid;
}

// ==================== MOSTRAR INFORMACIÓN DEL ARCHIVO ====================
function mostrarInfoArchivo() {
    const archivoInput = document.getElementById('documento_Archivo');
    const infoDiv = document.getElementById('documento_info_archivo');
    const nombreSpan = document.getElementById('documento_nombre_archivo');
    const tamanoSpan = document.getElementById('documento_tamano_archivo');
    
    if (archivoInput.files && archivoInput.files.length > 0) {
        const file = archivoInput.files[0];
        
        if (validarArchivoPDF(file)) {
            nombreSpan.textContent = file.name;
            
            // Formatear tamaño del archivo
            let tamano = file.size;
            if (tamano < 1024) {
                tamanoSpan.textContent = `Tamaño: ${tamano} bytes`;
            } else if (tamano < 1024 * 1024) {
                tamanoSpan.textContent = `Tamaño: ${(tamano / 1024).toFixed(2)} KB`;
            } else {
                tamanoSpan.textContent = `Tamaño: ${(tamano / (1024 * 1024)).toFixed(2)} MB`;
            }
            
            infoDiv.style.display = 'block';
            formularioDocumentoModificado = true;
        } else {
            infoDiv.style.display = 'none';
            archivoInput.value = '';
        }
    } else {
        infoDiv.style.display = 'none';
    }
}

// ==================== ENVÍO DEL FORMULARIO ====================
function submitDocumentoForm() {
    const form = document.getElementById('FormSubirDocumento');
    
    if (!validarFormularioDocumento()) {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Por favor, completa todos los campos requeridos.',
            confirmButtonColor: '#001F3F'
        });
        return;
    }
    
    const formData = new FormData(form);
    formularioDocumentoEnviado = true;
    
    Swal.fire({
        title: 'Subiendo documento...',
        text: 'Por favor, espera un momento.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(async response => {
        const text = await response.text();
        try {
            const data = JSON.parse(text);
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Documento subido!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if (documentoModal) documentoModal.hide();
                    location.reload();
                });
            } else {
                formularioDocumentoEnviado = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Ocurrió un error al subir el documento.',
                    confirmButtonColor: '#001F3F'
                });
            }
        } catch (err) {
            formularioDocumentoEnviado = false;
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Respuesta no válida del servidor.',
                confirmButtonColor: '#001F3F'
            });
            console.error('JSON inválido:', text);
        }
    })
    .catch(error => {
        formularioDocumentoEnviado = false;
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'Hubo un problema al procesar la solicitud.',
            confirmButtonColor: '#001F3F'
        });
        console.error('Error:', error);
    });
}

// ==================== VALIDACIÓN EN TIEMPO REAL ====================
function addRealTimeValidationDocumento() {
    const nombreInput = document.getElementById('documento_Nombre');
    const archivoInput = document.getElementById('documento_Archivo');
    
    if (nombreInput) {
        nombreInput.addEventListener('input', function() {
            formularioDocumentoModificado = true;
            if (this.value.trim()) {
                this.classList.remove('is-invalid');
            }
        });
    }
    
    if (archivoInput) {
        archivoInput.addEventListener('change', function() {
            mostrarInfoArchivo();
        });
    }
}

// ==================== PREVENIR CIERRE ACCIDENTAL ====================
function setupPrevenirCierreDocumento() {
    const modalElement = document.getElementById('subirDocumentoModal');
    const form = document.getElementById('FormSubirDocumento');
    
    if (!modalElement || !form) return;
    
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            formularioDocumentoModificado = true;
        });
        input.addEventListener('input', () => {
            formularioDocumentoModificado = true;
        });
    });
    
    modalElement.addEventListener('hide.bs.modal', function(e) {
        if (formularioDocumentoEnviado) return;
        
        if (formularioDocumentoModificado) {
            e.preventDefault();
            Swal.fire({
                title: '¿Descartar cambios?',
                text: 'Tienes cambios sin guardar. ¿Estás seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, descartar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    formularioDocumentoModificado = false;
                    formularioDocumentoEnviado = false;
                    modalElement.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                }
            });
        }
    });
    
    modalElement.addEventListener('hidden.bs.modal', function() {
        formularioDocumentoModificado = false;
        formularioDocumentoEnviado = false;
        
        const form = document.getElementById('FormSubirDocumento');
        if (form) {
            form.reset();
            document.querySelectorAll('#subirDocumentoModal .is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
        }
        
        const infoDiv = document.getElementById('documento_info_archivo');
        if (infoDiv) infoDiv.style.display = 'none';
    });
}

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando modal de documentos...');
    
    const btnGuardar = document.getElementById('btnSubirDocumento');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            submitDocumentoForm();
        });
    }
    
    addRealTimeValidationDocumento();
    setupPrevenirCierreDocumento();
});

// Función global para abrir el modal
window.openDocumentoModal = openDocumentoModal;