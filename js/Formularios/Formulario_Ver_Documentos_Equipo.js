// ==================== MODAL DE VER INFORMACIÓN DEL EQUIPO - JS COMPLETO ====================

let verEquipoModal;
let currentEquipoId = null;

// ==================== FUNCIÓN PARA ABRIR EL MODAL ====================
async function openVerResponsivaModal(equipoId) {
    if (!verEquipoModal) {
        verEquipoModal = new bootstrap.Modal(document.getElementById('verEquipoModal'));
    }
    
    currentEquipoId = equipoId;
    
    // Mostrar loading
    const loadingDiv = document.getElementById('loadingVerEquipoData');
    const contentDiv = document.getElementById('verEquipoContent');
    
    if (loadingDiv) loadingDiv.style.display = 'block';
    if (contentDiv) contentDiv.style.display = 'none';
    
    verEquipoModal.show();
    
    try {
        // Cargar información del equipo
        const equipoData = await fetchEquipoInfo(equipoId);
        
        if (equipoData) {
            fillEquipoInfo(equipoData);
            
            // Cargar documentos del equipo
            await cargarDocumentosEquipo(equipoId);
            
            if (loadingDiv) loadingDiv.style.display = 'none';
            if (contentDiv) contentDiv.style.display = 'block';
        } else {
            throw new Error('No se pudieron cargar los datos del equipo');
        }
        
    } catch (error) {
        console.error('Error al cargar equipo:', error);
        if (loadingDiv) {
            loadingDiv.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar los datos: ${error.message}
                </div>
                <button class="btn btn-navy mt-3" onclick="openVerResponsivaModal(${equipoId})">
                    <i class="fas fa-redo me-1"></i> Reintentar
                </button>
            `;
        }
    }
}

// ==================== FUNCIÓN PARA OBTENER DATOS DEL EQUIPO ====================
async function fetchEquipoInfo(equipoId) {
    try {
        const response = await fetch(`../../../Controlador/GET/Formulario/getObtenerInfoEquipo.php?id=${equipoId}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            return data.data;
        } else {
            throw new Error(data.message || 'Error al obtener datos');
        }
        
    } catch (error) {
        console.error('Error en fetchEquipoInfo:', error);
        throw error;
    }
}

// ==================== FUNCIÓN PARA OBTENER DOCUMENTOS DEL EQUIPO ====================
async function fetchDocumentosEquipo(equipoId) {
    try {
        const response = await fetch(`../../../Controlador/GET/Formulario/getDocumentosEquipo.php?id=${equipoId}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            return data.data;
        } else {
            throw new Error(data.message || 'Error al obtener documentos');
        }
        
    } catch (error) {
        console.error('Error en fetchDocumentosEquipo:', error);
        throw error;
    }
}

// ==================== LLENAR INFORMACIÓN DEL EQUIPO ====================
function fillEquipoInfo(data) {
    // Información de Asignación
    document.getElementById('ver_Nombre_Persona').textContent = data.Nombre_Persona || '--';
    document.getElementById('ver_Departamento').textContent = data.Nombre_Departamento || '--';
    
    // Formatear fecha
    if (data.Fecha_Registro) {
        const fecha = new Date(data.Fecha_Registro);
        document.getElementById('ver_Fecha_Registro').textContent = fecha.toLocaleDateString('es-MX', {
            year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
        });
    }
    
    // Estatus con color
    const estatusSpan = document.getElementById('ver_Estatus');
    const estatus = data.Estatus || 'Activo';
    estatusSpan.textContent = estatus;
    
    switch(estatus) {
        case 'Activo':
            estatusSpan.className = 'badge bg-success';
            break;
        case 'Inactivo':
            estatusSpan.className = 'badge bg-secondary';
            break;
        case 'En Mantenimiento':
            estatusSpan.className = 'badge bg-warning text-dark';
            break;
        case 'Dado de Baja':
            estatusSpan.className = 'badge bg-danger';
            break;
        case 'Asignado':
            estatusSpan.className = 'badge bg-info text-dark';
            break;
        default:
            estatusSpan.className = 'badge bg-primary';
    }
    
    document.getElementById('ver_Observaciones').textContent = data.Observaciones || 'Sin observaciones';
    
    // Especificaciones Básicas
    document.getElementById('ver_Tipo_PC').textContent = data.Tipo_PC || '--';
    document.getElementById('ver_Marca_Equipo').textContent = data.Marca_Equipo || '--';
    document.getElementById('ver_Modelo_Equipo').textContent = data.Modelo_Equipo || '--';
    document.getElementById('ver_Numero_Serie').textContent = data.Numero_Serie || '--';
    document.getElementById('ver_Sistema_Operativo').textContent = data.Sistema_Operativo || '--';
    
    // Hardware Interno
    document.getElementById('ver_Procesador').textContent = data.Procesador || '--';
    document.getElementById('ver_Tarjeta_Madre').textContent = data.Tarjeta_Madre || '--';
    
    // Gráfica Dedicada
    const tieneGrafica = data.Tiene_Grafica_Dedicada == 1;
    document.getElementById('ver_Tiene_Grafica').textContent = tieneGrafica ? 'Sí' : 'No';
    
    const graficaRow = document.getElementById('ver_Datos_Grafica_Row');
    const graficaDatos = document.getElementById('ver_Datos_Tarjeta_Grafica');
    if (tieneGrafica && data.Datos_Tarjeta_Grafica) {
        graficaRow.style.display = 'table-row';
        graficaDatos.textContent = data.Datos_Tarjeta_Grafica;
    } else {
        graficaRow.style.display = 'none';
    }
    
    document.getElementById('ver_Tipo_RAM').textContent = data.Tipo_RAM || '--';
    document.getElementById('ver_Capacidad_RAM').textContent = data.Capacidad_RAM || '--';
    document.getElementById('ver_Marca_RAM').textContent = data.Marca_RAM || '--';
    document.getElementById('ver_Tipo_Disco').textContent = data.Tipo_Disco || '--';
    document.getElementById('ver_Capacidad_Disco').textContent = data.Capacidad_Disco || '--';
    
    // Periféricos
    document.getElementById('ver_Teclado_Mouse').textContent = data.Teclado_Mouse || '--';
    document.getElementById('ver_Camara_Web').textContent = data.Camara_Web || '--';
    document.getElementById('ver_Otro_Periferico').textContent = data.Otro_Periferico || '--';
}

// ==================== CARGAR DOCUMENTOS DEL EQUIPO ====================
async function cargarDocumentosEquipo(equipoId) {
    const tbody = document.getElementById('tablaDocumentosBody');
    if (!tbody) return;
    
    try {
        const documentos = await fetchDocumentosEquipo(equipoId);
        
        // Actualizar badge de contador
        const badge = document.getElementById('documentosCountBadge');
        if (badge) badge.textContent = documentos.length;
        
        if (!documentos || documentos.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-4">
                        <div class="text-muted">
                            <i class="fas fa-file-pdf fa-2x mb-2 d-block"></i>
                            No hay documentos PDF asociados a este equipo
                        </div>
                        <button class="btn btn-sm btn-turquoise mt-2" onclick="abrirSubirDocumentoDesdeModal()">
                            <i class="fas fa-upload me-1"></i> Subir primer documento
                        </button>
                    </td>
                </tr>
            `;
            return;
        }
        
        tbody.innerHTML = '';
        documentos.forEach((doc, index) => {
            const fecha = new Date(doc.Fecha_Registro);
            const fechaFormateada = fecha.toLocaleDateString('es-MX', {
                year: 'numeric', month: 'long', day: 'numeric'
            });
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="text-center">${index + 1}</td>
                <td>
                    <i class="fas fa-file-pdf text-danger me-2"></i>
                    ${escapeHtmlVerEquipo(doc.Nombre_Documento)}
                </td>
                <td>${fechaFormateada}</td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-outline-info" onclick="verDocumentoPDF('${doc.Ubicacion}')" title="Ver PDF">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-outline-success" onclick="descargarDocumentoPDF('${doc.Ubicacion}', '${escapeHtmlVerEquipo(doc.Nombre_Documento)}')" title="Descargar">
                            <i class="fas fa-download"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="eliminarDocumentoPDF(${doc.Id}, '${doc.Ubicacion}', '${escapeHtmlVerEquipo(doc.Nombre_Documento)}')" title="Eliminar">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
        
    } catch (error) {
        console.error('Error al cargar documentos:', error);
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center py-4 text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar los documentos
                </td>
            </tr>
        `;
    }
}

// ==================== FUNCIONES PARA GESTIONAR DOCUMENTOS ====================
function verDocumentoPDF(ubicacion) {
    const url = `../../../uploads/documentos_equipos/${ubicacion}`;
    window.open(url, '_blank');
}

function descargarDocumentoPDF(ubicacion, nombreDocumento) {
    const url = `../../../uploads/documentos_equipos/${ubicacion}`;
    const link = document.createElement('a');
    link.href = url;
    link.download = `${nombreDocumento}.pdf`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

async function eliminarDocumentoPDF(documentoId, ubicacion, nombreDocumento) {
    Swal.fire({
        title: '¿Eliminar documento?',
        html: `¿Estás seguro de eliminar el documento <strong>${nombreDocumento}</strong>?<br><small class="text-muted">Esta acción no se puede deshacer.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '<i class="fas fa-trash me-1"></i> Sí, eliminar',
        cancelButtonText: '<i class="fas fa-times me-1"></i> Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Eliminando...',
                text: 'Por favor, espera un momento.',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
            
            try {
                const response = await fetch('../../../Controlador/GET/Eliminar_Documento_Equipo.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: documentoId, ubicacion: ubicacion })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Documento eliminado',
                        text: data.message,
                        timer: 700,
                        showConfirmButton: false
                    }).then(() => {
                        // Recargar documentos
                        if (currentEquipoId) {
                            cargarDocumentosEquipo(currentEquipoId);
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'No se pudo eliminar el documento.',
                        confirmButtonColor: '#001F3F'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'Hubo un problema al eliminar el documento.',
                    confirmButtonColor: '#001F3F'
                });
                console.error('Error:', error);
            }
        }
    });
}

function abrirSubirDocumentoDesdeModal() {
    // Cerrar el modal actual
    if (verEquipoModal) verEquipoModal.hide();
    
    // Abrir el modal de subir documento
    if (currentEquipoId && typeof openDocumentoModal === 'function') {
        openDocumentoModal(currentEquipoId);
    }
}

// ==================== ESCAPE HTML ====================
function escapeHtmlVerEquipo(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando modal de ver equipo...');
    
    // Configurar botones adicionales si es necesario
    const btnSubirDocumento = document.getElementById('ver_btnSubirDocumento');
    if (btnSubirDocumento) {
        btnSubirDocumento.addEventListener('click', abrirSubirDocumentoDesdeModal);
    }
});

// Función global para abrir el modal
window.openVerResponsivaModal = openVerResponsivaModal;
window.verDocumentoPDF = verDocumentoPDF;
window.descargarDocumentoPDF = descargarDocumentoPDF;
window.eliminarDocumentoPDF = eliminarDocumentoPDF;
window.abrirSubirDocumentoDesdeModal = abrirSubirDocumentoDesdeModal;