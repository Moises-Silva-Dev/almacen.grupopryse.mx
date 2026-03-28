// ==================== MODAL DE REGISTRO DE SALIDA - JS COMPLETO ====================

let salidaModal;
let formularioSalidaModificado = false;
let formularioSalidaEnviado = false;

// ==================== FUNCIÓN PARA ABRIR EL MODAL ====================
async function openSalidaModal(requisicionId) {
    if (!salidaModal) {
        salidaModal = new bootstrap.Modal(document.getElementById('registrarSalidaModal'));
    }
    
    // Mostrar loading
    const loadingDiv = document.getElementById('loadingSalidaData');
    const formContainer = document.getElementById('salidaFormContainer');
    
    if (loadingDiv) loadingDiv.style.display = 'block';
    if (formContainer) formContainer.style.display = 'none';
    
    // Resetear flags
    formularioSalidaModificado = false;
    formularioSalidaEnviado = false;
    
    salidaModal.show();
    
    try {
        // Cargar datos de la requisición
        const requisicionData = await fetchRequisicionData(requisicionId);
        
        if (requisicionData) {
            // Llenar información general
            fillInformacionGeneral(requisicionData);
            
            // Llenar tabla de productos
            fillTablaProductos(requisicionData.productos);
            
            // Establecer ID de requisición
            document.getElementById('salida_id_requisicion').value = requisicionId;
            
            // Ocultar loading y mostrar formulario
            if (loadingDiv) loadingDiv.style.display = 'none';
            if (formContainer) formContainer.style.display = 'block';
        } else {
            throw new Error('No se pudieron cargar los datos de la requisición');
        }
        
    } catch (error) {
        console.error('Error al cargar requisición:', error);
        if (loadingDiv) {
            loadingDiv.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar los datos: ${error.message}
                </div>
                <button class="btn btn-navy mt-3" onclick="openSalidaModal(${requisicionId})">
                    <i class="fas fa-redo me-1"></i> Reintentar
                </button>
                <button class="btn btn-secondary mt-3 ms-2" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cerrar
                </button>
            `;
        }
    }
}

// ==================== FUNCIÓN PARA OBTENER DATOS DE LA REQUISICIÓN ====================
async function fetchRequisicionData(requisicionId) {
    try {
        const response = await fetch(`../../../Controlador/GET/Formulario/getObtenerInfoRequisicionSalida.php?id=${requisicionId}`);
        
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
        console.error('Error en fetchRequisicionData:', error);
        throw error;
    }
}

// ==================== LLENAR INFORMACIÓN GENERAL ====================
function fillInformacionGeneral(data) {
    document.getElementById('salida_cuenta').value = data.NombreCuenta || '';
    document.getElementById('salida_supervisor').value = data.Supervisor || '';
    document.getElementById('salida_region').value = data.Nombre_Region || '';
    document.getElementById('salida_centro_trabajo').value = data.CentroTrabajo || '';
    document.getElementById('salida_receptor').value = data.Receptor || '';
    document.getElementById('salida_telefono').value = data.TelReceptor || '';
    document.getElementById('salida_rfc').value = data.RfcReceptor || '';
    document.getElementById('salida_justificacion').value = data.Justificacion || '';
    
    // Construir dirección
    let direccion = '';
    if (data.Mpio) direccion += data.Mpio + ', ';
    if (data.Colonia) direccion += data.Colonia + ', ';
    if (data.Calle) direccion += data.Calle + ' ' + (data.Nro || '') + ', ';
    if (data.CP) direccion += data.CP + ', ';
    if (data.Nombre_estado) direccion += data.Nombre_estado;
    direccion = direccion.replace(/, $/, '');
    
    document.getElementById('salida_direccion').value = direccion || 'No disponible';
}

// ==================== LLENAR TABLA DE PRODUCTOS ====================
function fillTablaProductos(productos) {
    const tbody = document.getElementById('tablaProductosBody');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    if (!productos || productos.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="9" class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-navy">No hay productos en esta requisición</h5>
                    </div>
                  </td>
              </tr>
        `;
        return;
    }
    
    productos.forEach((producto, index) => {
        const solicitado = producto.Solicitado || 0;
        const entregado = producto.Entregado || 0;
        const faltante = solicitado - entregado;
        const disponible = producto.Cantidad_Disponible || 0;
        
        const fila = document.createElement('tr');
        fila.setAttribute('data-producto-id', producto.Identificador_Producto);
        fila.setAttribute('data-talla-id', producto.Identificador_Talla);
        
        // Determinar clase para el stock
        let claseDisponible = 'cantidad-disponible';
        if (disponible <= 0) {
            claseDisponible += ' disponible-bajo';
        } else if (disponible < faltante) {
            claseDisponible += ' disponible-bajo';
        } else {
            claseDisponible += ' disponible-normal';
        }
        
        fila.innerHTML = `
            <td class="text-center">${index + 1}</td>
            <td class="text-center">${escapeHtmlSalida(producto.Identificador_Producto)}</td>
            <td class="text-center">${escapeHtmlSalida(producto.Descripcion_Producto)}</td>
            <td class="text-center">${escapeHtmlSalida(producto.Talla_Requisicion)}</td>
            <td class="text-center">${solicitado}</td>
            <td class="text-center">${entregado}</td>
            <td class="text-center"><strong>${faltante}</strong></td>
            <td class="text-center"><span class="${claseDisponible}">${disponible}</span></td>
            <td class="text-center">
                <input type="text" 
                       class="form-control form-control-sm cantidad-input" 
                       name="Cant[]" 
                       data-faltante="${faltante}"
                       data-disponible="${disponible}"
                       pattern="[0-9]*"
                       inputmode="numeric"
                       maxlength="5"
                       ${faltante <= 0 || disponible <= 0 ? 'disabled' : ''}
                       placeholder="0">
                <input type="hidden" name="Id_Talla[]" value="${producto.Identificador_Talla}">
                <input type="hidden" name="Id_Producto[]" value="${producto.Identificador_Producto}">
            </td>
        `;
        
        tbody.appendChild(fila);
    });
    
    // Configurar eventos de detección de cambios
    configurarEventosCantidad();
    configurarDeteccionCambios();
}

// ==================== CONFIGURAR EVENTOS DE CANTIDAD ====================
function configurarEventosCantidad() {
    const inputsCantidad = document.querySelectorAll('#tablaProductosBody input[name="Cant[]"]');
    
    inputsCantidad.forEach(input => {
        // Solo permitir números
        input.addEventListener('input', function(e) {
            // Marcar que el formulario ha sido modificado
            formularioSalidaModificado = true;
            
            // Eliminar cualquier carácter que no sea número
            let valor = this.value.replace(/[^0-9]/g, '');
            
            // Eliminar ceros a la izquierda
            if (valor.length > 1 && valor.startsWith('0')) {
                valor = valor.replace(/^0+/, '');
                if (valor === '') valor = '0';
            }
            
            this.value = valor;
        });
        
        input.addEventListener('change', function() {
            // Marcar que el formulario ha sido modificado
            formularioSalidaModificado = true;
            
            let valor = parseInt(this.value) || 0;
            const faltante = parseInt(this.getAttribute('data-faltante')) || 0;
            const disponible = parseInt(this.getAttribute('data-disponible')) || 0;
            const maxPermitido = Math.min(faltante, disponible);
            
            if (valor < 0) {
                this.value = 0;
                Swal.fire({
                    icon: 'warning',
                    title: 'Cantidad inválida',
                    text: 'La cantidad no puede ser negativa.',
                    confirmButtonColor: '#001F3F',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }
            
            if (valor > maxPermitido && maxPermitido > 0) {
                this.value = maxPermitido;
                Swal.fire({
                    icon: 'warning',
                    title: 'Cantidad excedida',
                    text: `No puedes entregar más de ${maxPermitido} unidades.`,
                    confirmButtonColor: '#001F3F',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                this.value = valor;
            }
        });
        
        // Prevenir que Enter envíe el formulario
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                // Mover al siguiente input si existe
                const nextInput = getNextInput(this);
                if (nextInput) {
                    nextInput.focus();
                    nextInput.select();
                }
            }
        });
    });
}

// Función para obtener el siguiente input en la tabla
function getNextInput(currentInput) {
    const allInputs = Array.from(document.querySelectorAll('#tablaProductosBody input[name="Cant[]"]'));
    const currentIndex = allInputs.indexOf(currentInput);
    if (currentIndex !== -1 && currentIndex < allInputs.length - 1) {
        return allInputs[currentIndex + 1];
    }
    return null;
}

// ==================== CONFIGURAR DETECCIÓN DE CAMBIOS ====================
function configurarDeteccionCambios() {
    // Detectar cambios en inputs de cantidad
    const inputsCantidad = document.querySelectorAll('#tablaProductosBody input[name="Cant[]"]');
    inputsCantidad.forEach(input => {
        input.addEventListener('input', () => { formularioSalidaModificado = true; });
        input.addEventListener('change', () => { formularioSalidaModificado = true; });
    });
    
    // Detectar cambios en cualquier input del formulario
    const form = document.getElementById('FormInsertSalidaNueva');
    if (form) {
        const todosInputs = form.querySelectorAll('input, select, textarea');
        todosInputs.forEach(input => {
            input.addEventListener('input', () => { 
                if (input.id !== 'datosTablaInsertSalida') {
                    formularioSalidaModificado = true;
                }
            });
            input.addEventListener('change', () => { 
                if (input.id !== 'datosTablaInsertSalida') {
                    formularioSalidaModificado = true;
                }
            });
        });
    }
}

// ==================== GUARDAR DATOS DE LA TABLA ====================
function guardarDatosTablaSalida() {
    const filas = document.querySelectorAll('#tablaProductosBody tr');
    const datos = [];
    
    filas.forEach(fila => {
        const IdCProd = fila.querySelector('input[name="Id_Producto[]"]')?.value;
        const Cant = fila.querySelector('input[name="Cant[]"]')?.value;
        const Id_Talla = fila.querySelector('input[name="Id_Talla[]"]')?.value;
        
        if (IdCProd && Cant && parseInt(Cant) > 0 && Id_Talla) {
            datos.push({
                IdCProd: IdCProd,
                Cant: Cant,
                Id_Talla: Id_Talla
            });
        }
    });
    
    const datosJSON = JSON.stringify(datos);
    document.getElementById('datosTablaInsertSalida').value = datosJSON;
    
    return datos.length > 0;
}

// ==================== VALIDAR QUE HAYA PRODUCTOS PARA ENTREGAR ====================
function validarProductosParaEntregar() {
    const inputsCantidad = document.querySelectorAll('#tablaProductosBody input[name="Cant[]"]');
    let hayCantidades = false;
    
    inputsCantidad.forEach(input => {
        const valor = parseInt(input.value) || 0;
        if (valor > 0) {
            hayCantidades = true;
        }
    });
    
    if (!hayCantidades) {
        Swal.fire({
            icon: 'warning',
            title: 'Sin productos',
            text: 'Debes especificar al menos una cantidad a entregar.',
            confirmButtonColor: '#001F3F'
        });
        return false;
    }
    
    return true;
}

// ==================== ENVÍO DEL FORMULARIO ====================
function submitSalidaForm() {
    const form = document.getElementById('FormInsertSalidaNueva');
    
    // Guardar datos de la tabla
    if (!guardarDatosTablaSalida()) {
        Swal.fire({
            icon: 'warning',
            title: 'Sin productos',
            text: 'No hay productos válidos para registrar la salida.',
            confirmButtonColor: '#001F3F'
        });
        return;
    }
    
    if (!validarProductosParaEntregar()) {
        return;
    }
    
    const formData = new FormData(form);
    
    // Marcar que el formulario fue enviado
    formularioSalidaEnviado = true;
    
    Swal.fire({
        title: 'Registrando salida...',
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
        console.log('Respuesta del servidor:', text);
        
        try {
            const data = JSON.parse(text);
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Salida registrada!',
                    text: data.message || 'La salida ha sido registrada exitosamente.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if (salidaModal) salidaModal.hide();
                    location.reload();
                });
            } else {
                // Si hay error, resetear flag para que no cierre automáticamente
                formularioSalidaEnviado = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Ocurrió un error al registrar la salida.',
                    confirmButtonColor: '#001F3F'
                });
            }
        } catch (err) {
            formularioSalidaEnviado = false;
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
        formularioSalidaEnviado = false;
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'Hubo un problema al procesar la solicitud.',
            confirmButtonColor: '#001F3F'
        });
        console.error('Error:', error);
    });
}

// ==================== ESCAPE HTML ====================
function escapeHtmlSalida(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== CONFIGURAR PREVENCIÓN DE CIERRE ACCIDENTAL ====================
function setupPrevenirCierreAccidental() {
    const modalElement = document.getElementById('registrarSalidaModal');
    const form = document.getElementById('FormInsertSalidaNueva');
    
    if (!modalElement || !form) return;
    
    // Detectar cambios en el formulario
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            if (input.id !== 'datosTablaInsertSalida') {
                formularioSalidaModificado = true;
            }
        });
        input.addEventListener('input', () => {
            if (input.id !== 'datosTablaInsertSalida') {
                formularioSalidaModificado = true;
            }
        });
    });
    
    // Prevenir cierre si hay cambios sin guardar
    modalElement.addEventListener('hide.bs.modal', function(e) {
        // Si el formulario ya fue enviado exitosamente, cerrar sin confirmación
        if (formularioSalidaEnviado) {
            return;
        }
        
        // Si hay cambios sin guardar, mostrar confirmación
        if (formularioSalidaModificado) {
            e.preventDefault();
            Swal.fire({
                title: '¿Descartar cambios?',
                text: 'Tienes cambios sin guardar. ¿Estás seguro de que quieres cerrar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, descartar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    formularioSalidaModificado = false;
                    formularioSalidaEnviado = false;
                    modalElement.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                }
            });
        }
    });
    
    // Resetear flags cuando el modal se cierra correctamente
    modalElement.addEventListener('hidden.bs.modal', function() {
        formularioSalidaModificado = false;
        formularioSalidaEnviado = false;
        
        const loadingDiv = document.getElementById('loadingSalidaData');
        const formContainer = document.getElementById('salidaFormContainer');
        
        if (loadingDiv) {
            loadingDiv.style.display = 'block';
            loadingDiv.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando información de la requisición...</p>
                </div>
            `;
        }
        if (formContainer) formContainer.style.display = 'none';
    });
}

// ==================== PREVENIR ENVÍO CON ENTER ====================
function prevenirEnvioConEnter() {
    const form = document.getElementById('FormInsertSalidaNueva');
    if (form) {
        form.addEventListener('keypress', function(e) {
            // Prevenir que Enter envíe el formulario
            if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
                e.preventDefault();
                return false;
            }
        });
    }
}

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando modal de salida...');
    
    // Configurar evento del botón de guardar
    const btnGuardar = document.getElementById('btnGuardarSalida');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            submitSalidaForm();
        });
    }
    
    // Configurar prevención de envío con Enter
    prevenirEnvioConEnter();
    
    // Configurar prevención de cierre accidental
    setupPrevenirCierreAccidental();
});

// Función global para abrir el modal
window.openSalidaModal = openSalidaModal;