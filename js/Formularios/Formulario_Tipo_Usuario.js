// ==================== MODAL DE CAMBIO DE ROL - JS COMPLETO ====================

// Variables globales
let cuentasSeleccionadas = [];
let modalRol;

// ==================== FUNCIÓN PARA ABRIR EL MODAL ====================
async function openRolModal(userId) {
    if (!modalRol) {
        modalRol = new bootstrap.Modal(document.getElementById('cambiarRolModal'));
    }
    
    // Mostrar loading
    const loadingDiv = document.getElementById('loadingRolData');
    const formContainer = document.getElementById('rolFormContainer');
    
    if (loadingDiv) loadingDiv.style.display = 'block';
    if (formContainer) formContainer.style.display = 'none';
    
    modalRol.show();
    
    try {
        // Cargar datos del usuario y sus cuentas
        const response = await fetch(`../../../Controlador/GET/Formulario/getUsuarioRolData.php?id=${userId}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            // Llenar el formulario con los datos
            fillRolForm(data);
            
            // Ocultar loading y mostrar formulario
            if (loadingDiv) loadingDiv.style.display = 'none';
            if (formContainer) formContainer.style.display = 'block';
        } else {
            throw new Error(data.message || 'No se pudieron cargar los datos');
        }
        
    } catch (error) {
        console.error('Error al cargar datos:', error);
        if (loadingDiv) {
            loadingDiv.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar los datos: ${error.message}
                </div>
                <button class="btn btn-navy mt-3" onclick="openRolModal(${userId})">
                    <i class="fas fa-redo me-1"></i> Reintentar
                </button>
            `;
        }
    }
}

// ==================== FUNCIÓN PARA LLENAR EL FORMULARIO ====================
function fillRolForm(data) {
    // Datos básicos
    document.getElementById('rol_id_usuario').value = data.usuario.ID_Usuario;
    document.getElementById('rol_tipo_actual').value = data.usuario.ID_Tipo_Usuario;
    document.getElementById('rol_nombre_usuario').textContent = 
        `${data.usuario.Nombre} ${data.usuario.Apellido_Paterno} ${data.usuario.Apellido_Materno}`;
    document.getElementById('rol_tipo_actual_nombre').textContent = data.usuario.Tipo_Usuario;
    
    // Configurar select de tipos de usuario
    const tipoSelect = document.getElementById('rol_ID_Tipo');
    if (tipoSelect) {
        tipoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Nuevo Rol --</option>';
        
        data.tipos_usuario.forEach(tipo => {
            const option = document.createElement('option');
            option.value = tipo.ID;
            option.textContent = tipo.Tipo_Usuario;
            tipoSelect.appendChild(option);
        });
    }
    
    // Cargar cuentas asociadas
    cuentasSeleccionadas = [];
    const tbody = document.querySelector('#rol_tablaCuentas tbody');
    if (tbody) {
        tbody.innerHTML = '';
        
        data.cuentas.forEach(cuenta => {
            const tieneRequisiciones = cuenta.TotalRequisiciones > 0;
            cuentasSeleccionadas.push({
                id: cuenta.ID,
                nombre: cuenta.NombreCuenta,
                tieneRequisiciones: tieneRequisiciones,
                totalRequisiciones: cuenta.TotalRequisiciones
            });
            
            const row = tbody.insertRow();
            row.setAttribute('data-cuenta-id', cuenta.ID);
            row.innerHTML = `
                <td>${escapeHtml(cuenta.ID)}</td>
                <td>${escapeHtml(cuenta.NombreCuenta)}</td>
                <td>
                    ${tieneRequisiciones ? 
                        `<span class="badge bg-warning">${cuenta.TotalRequisiciones} pendientes</span>` : 
                        `<span class="badge bg-success">Ninguna</span>`}
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm btn-eliminar-cuenta" 
                        ${tieneRequisiciones ? 'disabled title="No se puede eliminar porque tiene requisiciones pendientes"' : ''}>
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </td>
            `;
            
            // Agregar evento de eliminación
            const eliminarBtn = row.querySelector('.btn-eliminar-cuenta');
            if (eliminarBtn && !tieneRequisiciones) {
                eliminarBtn.addEventListener('click', () => eliminarCuenta(cuenta.ID, cuenta.NombreCuenta));
            }
        });
    }
    
    // Cargar select de cuentas disponibles
    const cuentaSelect = document.getElementById('rol_ID_Cuenta');
    if (cuentaSelect && data.cuentas_disponibles) {
        cuentaSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Cuenta --</option>';
        
        data.cuentas_disponibles.forEach(cuenta => {
            const option = document.createElement('option');
            option.value = cuenta.ID;
            option.textContent = cuenta.NombreCuenta;
            cuentaSelect.appendChild(option);
        });
    }
    
    // Mostrar/ocultar sección según tipo actual
    const seccionCuentas = document.getElementById('rol_seccionCuentas');
    const seccionTipoUsuario = document.getElementById('rol_seccionTipoUsuario');
    const tipoActualNum = parseInt(data.usuario.ID_Tipo_Usuario);
    const tieneRequisiciones = data.tiene_requisiciones;
    const notificationDiv = document.getElementById('rol_notificationContainer');
    
    if (tieneRequisiciones && (tipoActualNum === 3 || tipoActualNum === 4)) {
        // Mostrar mensaje de advertencia
        notificationDiv.style.display = 'block';
        notificationDiv.innerHTML = `
            <div class="alert alert-warning mb-4">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>¡Atención!</strong> El usuario tiene requisiciones pendientes en algunas cuentas.
                No se puede cambiar el rol hasta que se completen, pero puede agregar más cuentas.
            </div>
        `;
        
        // Deshabilitar cambio de rol
        if (tipoSelect) tipoSelect.disabled = true;
        seccionTipoUsuario.style.opacity = '0.6';
    } else {
        notificationDiv.style.display = 'none';
        if (tipoSelect) tipoSelect.disabled = false;
        seccionTipoUsuario.style.opacity = '1';
    }
    
    // Mostrar sección de cuentas si el tipo actual es 3 o 4
    if (tipoActualNum === 3 || tipoActualNum === 4) {
        seccionCuentas.style.display = 'block';
    } else {
        seccionCuentas.style.display = 'none';
    }
    
    // Actualizar campo oculto con datos iniciales
    actualizarDatosRolTabla();
}

// ==================== FUNCIÓN PARA AGREGAR CUENTA ====================
function agregarCuentaRol() {
    const select = document.getElementById('rol_ID_Cuenta');
    const cuentaId = select.value;
    const cuentaNombre = select.options[select.selectedIndex]?.text;
    
    if (!cuentaId) {
        Swal.fire('Error', 'Por favor selecciona una cuenta', 'error');
        return;
    }
    
    // Verificar si la cuenta ya está agregada
    if (cuentasSeleccionadas.some(c => c.id === cuentaId)) {
        Swal.fire('Advertencia', 'Esta cuenta ya está agregada', 'warning');
        return;
    }
    
    // Agregar nueva cuenta
    const nuevaCuenta = {
        id: cuentaId,
        nombre: cuentaNombre,
        tieneRequisiciones: false,
        totalRequisiciones: 0
    };
    
    cuentasSeleccionadas.push(nuevaCuenta);
    renderizarTablaCuentasRol();
    select.value = '';
    
    Swal.fire({
        icon: 'success',
        title: 'Cuenta agregada',
        text: `La cuenta ${cuentaNombre} ha sido agregada exitosamente.`,
        timer: 800,
        showConfirmButton: false
    });
}

// ==================== FUNCIÓN PARA ELIMINAR CUENTA ====================
function eliminarCuenta(cuentaId, cuentaNombre) {
    const cuenta = cuentasSeleccionadas.find(c => c.id === cuentaId);
    
    if (cuenta && cuenta.tieneRequisiciones) {
        Swal.fire({
            icon: 'warning',
            title: 'No se puede eliminar',
            text: `La cuenta ${cuentaNombre} tiene requisiciones pendientes. No se puede eliminar.`,
            confirmButtonColor: '#001F3F'
        });
        return;
    }
    
    Swal.fire({
        title: '¿Eliminar cuenta?',
        html: `¿Estás seguro de eliminar la cuenta <strong>${escapeHtml(cuentaNombre)}</strong>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '<i class="fas fa-trash me-1"></i> Sí, eliminar',
        cancelButtonText: '<i class="fas fa-times me-1"></i> Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            cuentasSeleccionadas = cuentasSeleccionadas.filter(c => c.id !== cuentaId);
            renderizarTablaCuentasRol();
            actualizarDatosRolTabla();
            
            Swal.fire({
                icon: 'success',
                title: 'Cuenta eliminada',
                text: `La cuenta ${cuentaNombre} ha sido eliminada.`,
                timer: 800,
                showConfirmButton: false
            });
        }
    });
}

// ==================== FUNCIÓN PARA RENDERIZAR TABLA DE CUENTAS ====================
function renderizarTablaCuentasRol() {
    const tbody = document.querySelector('#rol_tablaCuentas tbody');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    cuentasSeleccionadas.forEach(cuenta => {
        const row = tbody.insertRow();
        row.setAttribute('data-cuenta-id', cuenta.id);
        row.innerHTML = `
            <td>${escapeHtml(cuenta.id)}</td>
            <td>${escapeHtml(cuenta.nombre)}</td>
            <td>
                ${cuenta.tieneRequisiciones ? 
                    `<span class="badge bg-warning">${cuenta.totalRequisiciones} pendientes</span>` : 
                    `<span class="badge bg-success">Ninguna</span>`}
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm btn-eliminar-cuenta" 
                    ${cuenta.tieneRequisiciones ? 'disabled title="No se puede eliminar porque tiene requisiciones pendientes"' : ''}>
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </td>
        `;
        
        const eliminarBtn = row.querySelector('.btn-eliminar-cuenta');
        if (eliminarBtn && !cuenta.tieneRequisiciones) {
            eliminarBtn.addEventListener('click', () => eliminarCuenta(cuenta.id, cuenta.nombre));
        }
    });
    
    actualizarDatosRolTabla();
}

// ==================== ACTUALIZAR CAMPO OCULTO ====================
function actualizarDatosRolTabla() {
    const datosTabla = document.getElementById('rol_DatosTablaCuenta');
    if (datosTabla) {
        datosTabla.value = JSON.stringify(
            cuentasSeleccionadas.map(c => ({ 
                id: c.id, 
                nombre: c.nombre,
                tieneRequisiciones: c.tieneRequisiciones 
            }))
        );
    }
}

// ==================== VALIDACIÓN DEL FORMULARIO ====================
function validarFormularioRol() {
    const tipoSelect = document.getElementById('rol_ID_Tipo');
    const nuevoTipo = parseInt(tipoSelect.value);
    const tipoActual = parseInt(document.getElementById('rol_tipo_actual').value);
    const notificationHtml = document.getElementById('rol_notificationContainer').innerHTML;
    const tieneRequisiciones = notificationHtml.includes('requisiciones pendientes');
    
    // Si hay requisiciones pendientes, no permitir cambiar rol
    if (tieneRequisiciones && (tipoActual === 3 || tipoActual === 4)) {
        Swal.fire({
            icon: 'warning',
            title: 'No se puede cambiar el rol',
            text: 'El usuario tiene requisiciones pendientes. Primero debe completarlas.',
            confirmButtonColor: '#001F3F'
        });
        return false;
    }
    
    // Validar que se haya seleccionado un tipo
    if (!nuevoTipo) {
        Swal.fire({
            icon: 'warning',
            title: 'Selecciona un rol',
            text: 'Por favor, selecciona un nuevo tipo de usuario.',
            confirmButtonColor: '#001F3F'
        });
        return false;
    }
    
    // Si el nuevo tipo es 3 o 4, validar que tenga al menos una cuenta
    if ((nuevoTipo === 3 || nuevoTipo === 4) && cuentasSeleccionadas.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Cuentas requeridas',
            text: 'Debes asignar al menos una cuenta para este tipo de usuario.',
            confirmButtonColor: '#001F3F'
        });
        return false;
    }
    
    return true;
}

// ==================== ENVÍO DEL FORMULARIO ====================
function submitRolForm() {
    const form = document.getElementById('FormUpdateRolUsuario');
    
    if (!validarFormularioRol()) {
        return;
    }
    
    const formData = new FormData(form);
    
    Swal.fire({
        title: 'Guardando cambios...',
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
                    title: '¡Cambios guardados!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if (modalRol) modalRol.hide();
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Ocurrió un error al guardar los cambios.',
                    confirmButtonColor: '#001F3F'
                });
            }
        } catch (err) {
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
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'Hubo un problema al procesar la solicitud.',
            confirmButtonColor: '#001F3F'
        });
        console.error('Error:', error);
    });
}

// ==================== FUNCIÓN DE ESCAPE HTML ====================
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    // Evento para cambio de tipo de usuario
    const tipoSelect = document.getElementById('rol_ID_Tipo');
    const seccionCuentas = document.getElementById('rol_seccionCuentas');
    
    if (tipoSelect) {
        tipoSelect.addEventListener('change', function() {
            const nuevoTipo = parseInt(this.value);
            if (seccionCuentas) {
                seccionCuentas.style.display = (nuevoTipo === 3 || nuevoTipo === 4) ? 'block' : 'none';
            }
        });
    }
    
    // Evento para botón de agregar cuenta
    const btnAgregar = document.getElementById('rol_btnAgregarCuenta');
    if (btnAgregar) {
        btnAgregar.addEventListener('click', agregarCuentaRol);
    }
    
    // Evento para botón de guardar
    const btnGuardar = document.getElementById('rol_btnGuardar');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', submitRolForm);
    }
    
    // Limpiar formulario al cerrar modal
    const modalElement = document.getElementById('cambiarRolModal');
    if (modalElement) {
        modalElement.addEventListener('hidden.bs.modal', function() {
            const loadingDiv = document.getElementById('loadingRolData');
            const formContainer = document.getElementById('rolFormContainer');
            
            if (loadingDiv) {
                loadingDiv.style.display = 'block';
                loadingDiv.innerHTML = `
                    <div class="text-center py-5">
                        <div class="spinner-border text-turquoise" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-3 text-muted">Cargando datos del usuario...</p>
                    </div>
                `;
            }
            if (formContainer) formContainer.style.display = 'none';
            
            cuentasSeleccionadas = [];
        });
    }
});

// Función global para abrir el modal (para usar desde la tabla)
window.openRolModal = openRolModal;