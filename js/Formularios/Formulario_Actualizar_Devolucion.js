// ==================== MODAL DE MODIFICAR DEVOLUCIÓN - JS COMPLETO ====================

let modificarDevolucionModal;
let formularioModificarDevolucionModificado = false;
let formularioModificarDevolucionEnviado = false;
let contadorProductosEditDev = 0;
let productosDataEditDev = [];
let currentStepEditDev = 1;
const totalStepsEditDev = 3;

// ==================== FUNCIONES DE NAVEGACIÓN POR CÍRCULOS ====================
function updateStepIndicatorsEditDev() {
    const circles = [
        document.getElementById('edit_dev_stepCircle1'),
        document.getElementById('edit_dev_stepCircle2'),
        document.getElementById('edit_dev_stepCircle3')
    ];
    
    const labels = [
        document.getElementById('edit_dev_stepLabel1'),
        document.getElementById('edit_dev_stepLabel2'),
        document.getElementById('edit_dev_stepLabel3')
    ];
    
    const lines = [
        document.getElementById('edit_dev_stepLine1-2'),
        document.getElementById('edit_dev_stepLine2-3')
    ];
    
    circles.forEach(circle => {
        if (circle) {
            circle.classList.remove('active', 'completed');
        }
    });
    labels.forEach(label => {
        if (label) {
            label.classList.remove('active', 'completed');
        }
    });
    lines.forEach(line => {
        if (line) {
            line.classList.remove('active', 'completed');
        }
    });
    
    for (let i = 0; i < currentStepEditDev - 1; i++) {
        if (circles[i]) circles[i].classList.add('completed');
        if (labels[i]) labels[i].classList.add('completed');
        if (i < lines.length && lines[i]) {
            lines[i].classList.add('completed');
        }
    }
    
    if (currentStepEditDev <= circles.length) {
        if (circles[currentStepEditDev - 1]) circles[currentStepEditDev - 1].classList.add('active');
        if (labels[currentStepEditDev - 1]) labels[currentStepEditDev - 1].classList.add('active');
        
        if (currentStepEditDev - 2 >= 0 && lines[currentStepEditDev - 2]) {
            lines[currentStepEditDev - 2].classList.add('active');
        }
    }
}

function updateStepsEditDev() {
    const step1 = document.getElementById('edit_dev_step1');
    const step2 = document.getElementById('edit_dev_step2');
    const step3 = document.getElementById('edit_dev_step3');
    const prevBtn = document.getElementById('edit_dev_prevBtn');
    const nextBtn = document.getElementById('edit_dev_nextBtn');
    const submitBtn = document.getElementById('edit_dev_submitBtn');
    
    if (step1) step1.style.display = 'none';
    if (step2) step2.style.display = 'none';
    if (step3) step3.style.display = 'none';
    
    if (currentStepEditDev === 1 && step1) step1.style.display = 'block';
    if (currentStepEditDev === 2 && step2) step2.style.display = 'block';
    if (currentStepEditDev === 3 && step3) step3.style.display = 'block';
    
    if (prevBtn) prevBtn.style.display = currentStepEditDev === 1 ? 'none' : 'inline-block';
    if (nextBtn) nextBtn.style.display = currentStepEditDev === totalStepsEditDev ? 'none' : 'inline-block';
    if (submitBtn) submitBtn.style.display = currentStepEditDev === totalStepsEditDev ? 'inline-block' : 'none';
    
    updateStepIndicatorsEditDev();
}

function goToNextStepEditDev() {
    if (validateCurrentStepEditDev()) {
        currentStepEditDev++;
        updateStepsEditDev();
        
        const modalBody = document.querySelector('#modificarDevolucionModal .modal-body');
        if (modalBody) {
            modalBody.scrollTo({ top: 0, behavior: 'smooth' });
        }
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Por favor, completa todos los campos requeridos antes de continuar.',
            confirmButtonColor: '#001F3F'
        });
    }
}

function goToPrevStepEditDev() {
    currentStepEditDev--;
    updateStepsEditDev();
    
    const modalBody = document.querySelector('#modificarDevolucionModal .modal-body');
    if (modalBody) {
        modalBody.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function validateCurrentStepEditDev() {
    if (currentStepEditDev === 1) {
        return validateStep1EditDev();
    }
    if (currentStepEditDev === 2) {
        return true;
    }
    if (currentStepEditDev === 3) {
        return validateStep3EditDev();
    }
    return true;
}

function validateStep1EditDev() {
    const tipo = document.getElementById('edit_dev_Tipo');
    const nombreDevuelve = document.getElementById('edit_dev_Nombre_Devuelve');
    const telefonoDevuelve = document.getElementById('edit_dev_Telefono_Devuelve');
    const justificacion = document.getElementById('edit_dev_Justificacion');
    const estatus = document.getElementById('edit_dev_Estatus');
    const idReferencia = document.getElementById('edit_dev_IdReferencia');
    
    let isValid = true;
    
    if (!tipo.value) {
        tipo.classList.add('is-invalid');
        isValid = false;
    } else {
        tipo.classList.remove('is-invalid');
    }
    
    if (tipo.value === 'Requisicion' || tipo.value === 'Prestamo') {
        if (!idReferencia.value.trim()) {
            idReferencia.classList.add('is-invalid');
            isValid = false;
        } else {
            idReferencia.classList.remove('is-invalid');
        }
    }
    
    if (!nombreDevuelve.value.trim()) {
        nombreDevuelve.classList.add('is-invalid');
        isValid = false;
    } else {
        nombreDevuelve.classList.remove('is-invalid');
    }
    
    if (!telefonoDevuelve.value.trim() || telefonoDevuelve.value.length !== 10) {
        telefonoDevuelve.classList.add('is-invalid');
        isValid = false;
    } else {
        telefonoDevuelve.classList.remove('is-invalid');
    }
    
    if (!justificacion.value.trim()) {
        justificacion.classList.add('is-invalid');
        isValid = false;
    } else {
        justificacion.classList.remove('is-invalid');
    }
    
    return isValid;
}

function validateStep3EditDev() {
    const tablaBody = document.getElementById('edit_dev_tablaProductosBody');
    const productos = tablaBody.querySelectorAll('tr');
    
    if (productos.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Sin productos',
            text: 'Debes agregar al menos un producto antes de guardar.',
            confirmButtonColor: '#001F3F'
        });
        return false;
    }
    return true;
}

// ==================== FUNCIÓN PARA ABRIR EL MODAL ====================
async function openModificarDevolucionModal(devolucionId) {
    if (!modificarDevolucionModal) {
        modificarDevolucionModal = new bootstrap.Modal(document.getElementById('modificarDevolucionModal'));
    }
    
    const loadingDiv = document.getElementById('loadingModificarDevolucionData');
    const formContainer = document.getElementById('modificarDevolucionFormContainer');
    
    if (loadingDiv) loadingDiv.style.display = 'block';
    if (formContainer) formContainer.style.display = 'none';
    
    formularioModificarDevolucionModificado = false;
    formularioModificarDevolucionEnviado = false;
    currentStepEditDev = 1;
    
    modificarDevolucionModal.show();
    
    try {
        const devolucionData = await fetchDevolucionData(devolucionId);
        
        if (devolucionData) {
            await cargarProductosEditDev();
            fillInformacionGeneralEditDev(devolucionData);
            fillTablaProductosEditDev(devolucionData.productos);
            
            document.getElementById('edit_dev_id').value = devolucionData.IdDevolucionE || '';
            
            updateStepsEditDev();
            
            if (loadingDiv) loadingDiv.style.display = 'none';
            if (formContainer) formContainer.style.display = 'block';
        } else {
            throw new Error('No se pudieron cargar los datos');
        }
        
    } catch (error) {
        console.error('Error al cargar devolución:', error);
        if (loadingDiv) {
            loadingDiv.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar los datos: ${error.message}
                </div>
                <button class="btn btn-navy mt-3" onclick="openModificarDevolucionModal(${devolucionId})">
                    <i class="fas fa-redo me-1"></i> Reintentar
                </button>
                <button class="btn btn-secondary mt-3 ms-2" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cerrar
                </button>
            `;
        }
    }
}

// ==================== FUNCIÓN PARA OBTENER DATOS DE LA DEVOLUCIÓN ====================
async function fetchDevolucionData(devolucionId) {
    try {
        const response = await fetch(`../../../Controlador/GET/Formulario/getObtenerInfoDevolucion.php?id=${devolucionId}`);
        
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
        console.error('Error en fetchDevolucionData:', error);
        throw error;
    }
}

// ==================== CARGAR PRODUCTOS VÍA FETCH ====================
async function cargarProductosEditDev() {
    const productoSelect = document.getElementById('edit_dev_ID_Producto');
    if (!productoSelect) return;
    
    try {
        const response = await fetch('../../../Controlador/GET/Formulario/getSelectProduct.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            productosDataEditDev = data.data;
            productoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Producto --</option>';
            data.data.forEach(producto => {
                productoSelect.innerHTML += `<option value="${producto.IdCProducto}" 
                                                data-empresa="${escapeHtmlEditDev(producto.Nombre_Empresa)}"
                                                data-categoria="${escapeHtmlEditDev(producto.Descrp)}"
                                                data-descripcion="${escapeHtmlEditDev(producto.Descripcion)}"
                                                data-especificacion="${escapeHtmlEditDev(producto.Especificacion)}"
                                                data-imagen="${producto.IMG || '../../../img/Armar_Requicision.png'}">
                                                ${producto.IdCProducto} - ${producto.Descripcion}, ${producto.Especificacion}...
                                            </option>`;
            });
            productoSelect.disabled = false;
        } else {
            productoSelect.innerHTML = '<option value="" selected disabled>-- No hay productos disponibles --</option>';
            productoSelect.disabled = true;
        }
        
    } catch (error) {
        console.error('Error al cargar productos:', error);
        productoSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar productos</option>';
        productoSelect.disabled = true;
    }
}

// ==================== CARGAR TALLAS DEL PRODUCTO ====================
async function cargarTallasEditDev(productoId) {
    const tallaSelect = document.getElementById('edit_dev_ID_Talla');
    if (!tallaSelect) return;
    
    try {
        tallaSelect.innerHTML = '<option value="" selected disabled>⏳ Cargando tallas...</option>';
        tallaSelect.disabled = true;
        
        const response = await fetch(`../../../Controlador/GET/Formulario/getObtenerInfoTallasProduct.php?id=${productoId}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            tallaSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Talla --</option>';
            data.data.forEach(talla => {
                tallaSelect.innerHTML += `<option value="${talla.IdCTallas}" data-nombre="${escapeHtmlEditDev(talla.Talla)}">${escapeHtmlEditDev(talla.Talla)}</option>`;
            });
            tallaSelect.disabled = false;
        } else {
            tallaSelect.innerHTML = '<option value="" selected disabled>-- No hay tallas disponibles --</option>';
            tallaSelect.disabled = true;
        }
        
    } catch (error) {
        console.error('Error al cargar tallas:', error);
        tallaSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar tallas</option>';
        tallaSelect.disabled = true;
    }
}

// ==================== ACTUALIZAR INFORMACIÓN DEL PRODUCTO ====================
function actualizarInfoProductoEditDev(productoId) {
    const producto = productosDataEditDev.find(p => p.IdCProducto == productoId);
    const infoCard = document.getElementById('edit_dev_infoProductoCard');
    
    if (producto) {
        document.getElementById('edit_dev_infoEmpresa').textContent = producto.Nombre_Empresa || '--';
        document.getElementById('edit_dev_infoCategoria').textContent = producto.Descrp || '--';
        document.getElementById('edit_dev_infoDescripcion').textContent = producto.Descripcion || '--';
        document.getElementById('edit_dev_infoEspecificacion').textContent = producto.Especificacion || '--';
        
        const imagenElement = document.getElementById('edit_dev_productoImagen');
        if (producto.IMG && producto.IMG !== '') {
            imagenElement.src = producto.IMG;
        } else {
            imagenElement.src = '../../../img/Armar_Requicision.png';
        }
        
        infoCard.style.display = 'block';
    } else {
        infoCard.style.display = 'none';
    }
}

// ==================== LLENAR INFORMACIÓN GENERAL ====================
function fillInformacionGeneralEditDev(data) {
    document.getElementById('edit_dev_Tipo').value = data.Tipo || '';
    document.getElementById('edit_dev_Nombre_Devuelve').value = data.Nombre_Devuelve || '';
    document.getElementById('edit_dev_Telefono_Devuelve').value = data.Telefono_Devuelve || '';
    document.getElementById('edit_dev_Justificacion').value = data.Justificacion || '';
    
    // Mostrar/ocultar campo de identificación según tipo
    const solicitudDiv = document.getElementById('edit_dev_SolicitudDiv');
    const idReferencia = document.getElementById('edit_dev_IdReferencia');
    
    if (data.Tipo === 'Requisicion' || data.Tipo === 'Prestamo') {
        solicitudDiv.style.display = 'block';
        idReferencia.value = data.IdReferencia || '';
        idReferencia.required = true;
    } else {
        solicitudDiv.style.display = 'none';
        idReferencia.value = '';
        idReferencia.required = false;
    }
}

// ==================== LLENAR TABLA DE PRODUCTOS ====================
function fillTablaProductosEditDev(productos) {
    const tablaBody = document.getElementById('edit_dev_tablaProductosBody');
    if (!tablaBody) return;
    
    tablaBody.innerHTML = '';
    contadorProductosEditDev = 0;
    
    if (productos && productos.length > 0) {
        productos.forEach(producto => {
            contadorProductosEditDev++;
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td class="text-center">${contadorProductosEditDev}<\/td>
                <td>${escapeHtmlEditDev(producto.IdCProd)}<\/td>
                <td>${escapeHtmlEditDev(producto.Nombre_Empresa || '--')}<\/td>
                <td>${escapeHtmlEditDev(producto.Categoria || '--')}<\/td>
                <td>${escapeHtmlEditDev(producto.Descripcion || '--')}<\/td>
                <td>${escapeHtmlEditDev(producto.Especificacion || '--')}<\/td>
                <td data-id="${escapeHtmlEditDev(producto.IdTalla)}">${escapeHtmlEditDev(producto.Talla || '--')}<\/td>
                <td class="text-center">${producto.Cantidad}<\/td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto-edit-dev">
                        <i class="fas fa-trash"></i>
                    </button>
                <\/td>
            `;
            
            tablaBody.appendChild(fila);
            
            fila.querySelector('.btn-eliminar-producto-edit-dev').addEventListener('click', function() {
                eliminarProductoEditDev(fila);
            });
        });
    }
    
    actualizarContadorProductosEditDev();
    actualizarDatosTablaEditDev();
}

// ==================== AGREGAR PRODUCTO ====================
function agregarProductoEditDev() {
    const productoSelect = document.getElementById('edit_dev_ID_Producto');
    const tallaSelect = document.getElementById('edit_dev_ID_Talla');
    const cantidadInput = document.getElementById('edit_dev_Cantidad');
    
    const productoId = productoSelect.value;
    const tallaId = tallaSelect.value;
    const tallaNombre = tallaSelect.options[tallaSelect.selectedIndex]?.getAttribute('data-nombre');
    const cantidad = parseInt(cantidadInput.value) || 0;
    
    if (!productoId) {
        Swal.fire({ icon: 'warning', title: 'Producto no seleccionado', text: 'Por favor, selecciona un producto.', confirmButtonColor: '#001F3F' });
        return;
    }
    
    if (!tallaId) {
        Swal.fire({ icon: 'warning', title: 'Talla no seleccionada', text: 'Por favor, selecciona una talla.', confirmButtonColor: '#001F3F' });
        return;
    }
    
    if (cantidad <= 0) {
        Swal.fire({ icon: 'warning', title: 'Cantidad inválida', text: 'Por favor, ingresa una cantidad válida mayor a 0.', confirmButtonColor: '#001F3F' });
        return;
    }
    
    const producto = productosDataEditDev.find(p => p.IdCProducto == productoId);
    if (!producto) return;
    
    const tablaBody = document.getElementById('edit_dev_tablaProductosBody');
    const filasExistentes = tablaBody.querySelectorAll('tr');
    let filaExistente = null;
    
    filasExistentes.forEach(fila => {
        const codigo = fila.querySelector('td:nth-child(2)')?.textContent;
        const talla = fila.querySelector('td:nth-child(7)')?.getAttribute('data-id');
        if (codigo === productoId && talla === tallaId) {
            filaExistente = fila;
        }
    });
    
    if (filaExistente) {
        const cantidadActual = parseInt(filaExistente.querySelector('td:nth-child(8)').textContent) || 0;
        const nuevaCantidad = cantidadActual + cantidad;
        filaExistente.querySelector('td:nth-child(8)').textContent = nuevaCantidad;
        
        Swal.fire({ icon: 'success', title: 'Producto actualizado', text: `Se ha actualizado la cantidad a ${nuevaCantidad} unidades.`, timer: 800, showConfirmButton: false });
    } else {
        contadorProductosEditDev++;
        const nuevaFila = document.createElement('tr');
        nuevaFila.innerHTML = `
            <td class="text-center">${contadorProductosEditDev}<\/td>
            <td>${escapeHtmlEditDev(productoId)}<\/td>
            <td>${escapeHtmlEditDev(producto.Nombre_Empresa)}<\/td>
            <td>${escapeHtmlEditDev(producto.Descrp)}<\/td>
            <td>${escapeHtmlEditDev(producto.Descripcion)}<\/td>
            <td>${escapeHtmlEditDev(producto.Especificacion)}<\/td>
            <td data-id="${escapeHtmlEditDev(tallaId)}">${escapeHtmlEditDev(tallaNombre)}<\/td>
            <td class="text-center">${cantidad}<\/td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto-edit-dev">
                    <i class="fas fa-trash"></i>
                </button>
            <\/td>
        `;
        
        tablaBody.appendChild(nuevaFila);
        
        nuevaFila.querySelector('.btn-eliminar-producto-edit-dev').addEventListener('click', function() {
            eliminarProductoEditDev(nuevaFila);
        });
        
        Swal.fire({ icon: 'success', title: 'Producto agregado', text: 'El producto ha sido agregado correctamente.', timer: 800, showConfirmButton: false });
    }
    
    productoSelect.value = '';
    tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
    tallaSelect.disabled = true;
    cantidadInput.value = '';
    document.getElementById('edit_dev_infoProductoCard').style.display = 'none';
    
    formularioModificarDevolucionModificado = true;
    actualizarContadorProductosEditDev();
    actualizarDatosTablaEditDev();
}

// ==================== ELIMINAR PRODUCTO ====================
function eliminarProductoEditDev(fila) {
    const productoNombre = fila.querySelector('td:nth-child(5)')?.textContent;
    
    Swal.fire({
        title: '¿Eliminar producto?',
        html: `¿Estás seguro de eliminar <strong>${productoNombre}</strong> de la lista?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fila.remove();
            contadorProductosEditDev--;
            reordenarNumerosEditDev();
            formularioModificarDevolucionModificado = true;
            actualizarContadorProductosEditDev();
            actualizarDatosTablaEditDev();
            
            Swal.fire({ icon: 'success', title: 'Producto eliminado', timer: 800, showConfirmButton: false });
        }
    });
}

// ==================== REORDENAR NÚMEROS ====================
function reordenarNumerosEditDev() {
    const tablaBody = document.getElementById('edit_dev_tablaProductosBody');
    const filas = tablaBody.querySelectorAll('tr');
    
    filas.forEach((fila, index) => {
        const numeroCelda = fila.querySelector('td:first-child');
        if (numeroCelda) {
            numeroCelda.textContent = index + 1;
        }
    });
    contadorProductosEditDev = filas.length;
}

// ==================== ACTUALIZAR CONTADOR DE PRODUCTOS ====================
function actualizarContadorProductosEditDev() {
    const contadorSpan = document.getElementById('edit_dev_productosCount');
    const tablaBody = document.getElementById('edit_dev_tablaProductosBody');
    const cantidad = tablaBody.querySelectorAll('tr').length;
    
    if (contadorSpan) {
        if (cantidad === 0) {
            contadorSpan.innerHTML = '<i class="fas fa-info-circle me-1 text-muted"></i> <span class="text-muted">No hay productos agregados</span>';
        } else {
            contadorSpan.innerHTML = `<i class="fas fa-check-circle me-1 text-success"></i> <span class="text-success">${cantidad} producto(s) agregado(s)</span>`;
        }
    }
}

// ==================== ACTUALIZAR CAMPO OCULTO ====================
function actualizarDatosTablaEditDev() {
    const datosTabla = document.getElementById('datosTablaUpdateDevolucion');
    const tablaBody = document.getElementById('edit_dev_tablaProductosBody');
    const filas = tablaBody.querySelectorAll('tr');
    const datos = [];
    
    filas.forEach(fila => {
        const idProduct = fila.querySelector('td:nth-child(2)')?.textContent;
        const idtall = fila.querySelector('td:nth-child(7)')?.getAttribute('data-id');
        const cant = fila.querySelector('td:nth-child(8)')?.textContent;
        
        if (idProduct && idtall && cant && parseInt(cant) > 0) {
            datos.push({ idProduct: idProduct, idtall: idtall, cant: cant });
        }
    });
    
    if (datosTabla) {
        datosTabla.value = JSON.stringify(datos);
    }
}

// ==================== CONFIGURAR EVENTOS ====================
function setupProductoEventsEditDev() {
    const productoSelect = document.getElementById('edit_dev_ID_Producto');
    const tallaSelect = document.getElementById('edit_dev_ID_Talla');
    const cantidadInput = document.getElementById('edit_dev_Cantidad');
    
    if (productoSelect) {
        productoSelect.addEventListener('change', function() {
            formularioModificarDevolucionModificado = true;
            const productoId = this.value;
            
            if (productoId) {
                actualizarInfoProductoEditDev(productoId);
                cargarTallasEditDev(productoId);
            } else {
                document.getElementById('edit_dev_infoProductoCard').style.display = 'none';
                if (tallaSelect) {
                    tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
                    tallaSelect.disabled = true;
                }
            }
        });
    }
    
    if (cantidadInput) {
        cantidadInput.addEventListener('input', function(e) {
            formularioModificarDevolucionModificado = true;
            let valor = this.value.replace(/[^0-9]/g, '');
            if (valor.length > 1 && valor.startsWith('0')) {
                valor = valor.replace(/^0+/, '');
                if (valor === '') valor = '0';
            }
            this.value = valor;
        });
    }
}

// ==================== CONFIGURAR EVENTO DE OPCIÓN ====================
function setupOpcionEventEditDev() {
    const tipoSelect = document.getElementById('edit_dev_Tipo');
    const solicitudDiv = document.getElementById('edit_dev_SolicitudDiv');
    
    if (tipoSelect) {
        tipoSelect.addEventListener('change', function() {
            formularioModificarDevolucionModificado = true;
            const seleccion = this.value;
            solicitudDiv.style.display = (seleccion === 'Requisicion' || seleccion === 'Prestamo') ? 'block' : 'none';
            
            const idReferencia = document.getElementById('edit_dev_IdReferencia');
            if (seleccion === 'Requisicion' || seleccion === 'Prestamo') {
                idReferencia.required = true;
            } else {
                idReferencia.required = false;
                idReferencia.value = '';
            }
        });
    }
}

// ==================== ENVÍO DEL FORMULARIO ====================
function submitModificarDevolucionForm() {
    const form = document.getElementById('FormUpdateDevolucion');
    
    actualizarDatosTablaEditDev();
    
    if (!validateStep3EditDev()) {
        return;
    }
    
    const formData = new FormData(form);
    formularioModificarDevolucionEnviado = true;
    
    Swal.fire({
        title: 'Guardando cambios...',
        text: 'Por favor, espera un momento.',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
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
                    title: '¡Devolución actualizada!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if (modificarDevolucionModal) modificarDevolucionModal.hide();
                    location.reload();
                });
            } else {
                formularioModificarDevolucionEnviado = false;
                Swal.fire({ icon: 'error', title: 'Error', text: data.message, confirmButtonColor: '#001F3F' });
            }
        } catch (err) {
            formularioModificarDevolucionEnviado = false;
            Swal.fire({ icon: 'error', title: 'Error', text: 'Respuesta no válida del servidor.', confirmButtonColor: '#001F3F' });
        }
    })
    .catch(error => {
        formularioModificarDevolucionEnviado = false;
        Swal.fire({ icon: 'error', title: 'Error de conexión', text: 'Hubo un problema al procesar la solicitud.', confirmButtonColor: '#001F3F' });
    });
}

// ==================== ESCAPE HTML ====================
function escapeHtmlEditDev(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== PREVENIR CIERRE ACCIDENTAL ====================
function setupPrevenirCierreEditDev() {
    const modalElement = document.getElementById('modificarDevolucionModal');
    const form = document.getElementById('FormUpdateDevolucion');
    
    if (!modalElement || !form) return;
    
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            if (input.id !== 'datosTablaUpdateDevolucion') {
                formularioModificarDevolucionModificado = true;
            }
        });
        input.addEventListener('input', () => {
            if (input.id !== 'datosTablaUpdateDevolucion') {
                formularioModificarDevolucionModificado = true;
            }
        });
    });
    
    modalElement.addEventListener('hide.bs.modal', function(e) {
        if (formularioModificarDevolucionEnviado) return;
        
        if (formularioModificarDevolucionModificado) {
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
                    formularioModificarDevolucionModificado = false;
                    formularioModificarDevolucionEnviado = false;
                    modalElement.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                }
            });
        }
    });
    
    modalElement.addEventListener('hidden.bs.modal', function() {
        formularioModificarDevolucionModificado = false;
        formularioModificarDevolucionEnviado = false;
        currentStepEditDev = 1;
        
        const loadingDiv = document.getElementById('loadingModificarDevolucionData');
        const formContainer = document.getElementById('modificarDevolucionFormContainer');
        
        if (loadingDiv) {
            loadingDiv.style.display = 'block';
            loadingDiv.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando datos de la devolución...</p>
                </div>
            `;
        }
        if (formContainer) formContainer.style.display = 'none';
        
        const tablaBody = document.getElementById('edit_dev_tablaProductosBody');
        if (tablaBody) tablaBody.innerHTML = '';
        contadorProductosEditDev = 0;
        actualizarContadorProductosEditDev();
    });
}

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando modal de modificar devolución...');
    
    const btnAgregar = document.getElementById('edit_dev_btn_AgregarProducto');
    if (btnAgregar) {
        btnAgregar.addEventListener('click', agregarProductoEditDev);
    }
    
    const btnGuardar = document.getElementById('edit_dev_submitBtn');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            submitModificarDevolucionForm();
        });
    }
    
    const nextBtn = document.getElementById('edit_dev_nextBtn');
    const prevBtn = document.getElementById('edit_dev_prevBtn');
    
    if (nextBtn) nextBtn.addEventListener('click', goToNextStepEditDev);
    if (prevBtn) prevBtn.addEventListener('click', goToPrevStepEditDev);
    
    setupProductoEventsEditDev();
    setupOpcionEventEditDev();
    setupPrevenirCierreEditDev();
});

window.openModificarDevolucionModal = openModificarDevolucionModal;