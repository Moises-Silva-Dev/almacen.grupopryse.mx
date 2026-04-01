// ==================== MODAL DE REGISTRO DE DEVOLUCIÓN - JS COMPLETO ====================

let devolucionModal;
let formularioDevolucionModificado = false;
let formularioDevolucionEnviado = false;
let contadorProductosDev = 0;
let productosDataDev = [];
let currentStepDev = 1;
const totalStepsDev = 3;

// ==================== FUNCIONES DE NAVEGACIÓN POR CÍRCULOS ====================
function updateStepIndicatorsDev() {
    const circles = [
        document.getElementById('dev_stepCircle1'),
        document.getElementById('dev_stepCircle2'),
        document.getElementById('dev_stepCircle3')
    ];
    
    const labels = [
        document.getElementById('dev_stepLabel1'),
        document.getElementById('dev_stepLabel2'),
        document.getElementById('dev_stepLabel3')
    ];
    
    const lines = [
        document.getElementById('dev_stepLine1-2'),
        document.getElementById('dev_stepLine2-3')
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
    
    for (let i = 0; i < currentStepDev - 1; i++) {
        if (circles[i]) circles[i].classList.add('completed');
        if (labels[i]) labels[i].classList.add('completed');
        if (i < lines.length && lines[i]) {
            lines[i].classList.add('completed');
        }
    }
    
    if (currentStepDev <= circles.length) {
        if (circles[currentStepDev - 1]) circles[currentStepDev - 1].classList.add('active');
        if (labels[currentStepDev - 1]) labels[currentStepDev - 1].classList.add('active');
        
        if (currentStepDev - 2 >= 0 && lines[currentStepDev - 2]) {
            lines[currentStepDev - 2].classList.add('active');
        }
    }
}

function updateStepsDev() {
    const step1 = document.getElementById('dev_step1');
    const step2 = document.getElementById('dev_step2');
    const step3 = document.getElementById('dev_step3');
    const prevBtn = document.getElementById('dev_prevBtn');
    const nextBtn = document.getElementById('dev_nextBtn');
    const submitBtn = document.getElementById('dev_submitBtn');
    
    if (step1) step1.style.display = 'none';
    if (step2) step2.style.display = 'none';
    if (step3) step3.style.display = 'none';
    
    if (currentStepDev === 1 && step1) step1.style.display = 'block';
    if (currentStepDev === 2 && step2) step2.style.display = 'block';
    if (currentStepDev === 3 && step3) step3.style.display = 'block';
    
    if (prevBtn) prevBtn.style.display = currentStepDev === 1 ? 'none' : 'inline-block';
    if (nextBtn) nextBtn.style.display = currentStepDev === totalStepsDev ? 'none' : 'inline-block';
    if (submitBtn) submitBtn.style.display = currentStepDev === totalStepsDev ? 'inline-block' : 'none';
    
    updateStepIndicatorsDev();
}

function goToNextStepDev() {
    if (validateCurrentStepDev()) {
        currentStepDev++;
        updateStepsDev();
        
        const modalBody = document.querySelector('#registrarDevolucionModal .modal-body');
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

function goToPrevStepDev() {
    currentStepDev--;
    updateStepsDev();
    
    const modalBody = document.querySelector('#registrarDevolucionModal .modal-body');
    if (modalBody) {
        modalBody.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function validateCurrentStepDev() {
    if (currentStepDev === 1) {
        return validateStep1Dev();
    }
    if (currentStepDev === 2) {
        return true;
    }
    if (currentStepDev === 3) {
        return validateStep3Dev();
    }
    return true;
}

function validateStep1Dev() {
    const opcion = document.getElementById('dev_Opcion');
    const nombreDevuelve = document.getElementById('dev_Nombre_Devuelve');
    const telefonoDevuelve = document.getElementById('dev_Telefono_Devuelve');
    const comentarios = document.getElementById('dev_Comentarios');
    const identificador = document.getElementById('dev_Identificador');
    
    let isValid = true;
    
    if (!opcion.value) {
        opcion.classList.add('is-invalid');
        isValid = false;
    } else {
        opcion.classList.remove('is-invalid');
    }
    
    if (opcion.value === 'Requisicion' || opcion.value === 'Prestamo') {
        if (!identificador.value.trim()) {
            identificador.classList.add('is-invalid');
            isValid = false;
        } else {
            identificador.classList.remove('is-invalid');
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
    
    if (!comentarios.value.trim()) {
        comentarios.classList.add('is-invalid');
        isValid = false;
    } else {
        comentarios.classList.remove('is-invalid');
    }
    
    return isValid;
}

function validateStep3Dev() {
    const tablaBody = document.getElementById('dev_tablaProductosBody');
    const productos = tablaBody.querySelectorAll('tr');
    
    if (productos.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Sin productos',
            text: 'Debes agregar al menos un producto antes de registrar la devolución.',
            confirmButtonColor: '#001F3F'
        });
        return false;
    }
    return true;
}

// ==================== FUNCIÓN PARA ABRIR EL MODAL ====================
async function openDevolucionModal() {
    if (!devolucionModal) {
        devolucionModal = new bootstrap.Modal(document.getElementById('registrarDevolucionModal'));
    }
    
    const loadingDiv = document.getElementById('loadingDevolucionData');
    const formContainer = document.getElementById('devolucionFormContainer');
    
    if (loadingDiv) loadingDiv.style.display = 'block';
    if (formContainer) formContainer.style.display = 'none';
    
    formularioDevolucionModificado = false;
    formularioDevolucionEnviado = false;
    currentStepDev = 1;
    
    devolucionModal.show();
    
    try {
        await cargarProductosDev();
        
        const form = document.getElementById('FormInsertDevolucionNueva');
        if (form) {
            form.reset();
            document.querySelectorAll('#registrarDevolucionModal .is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
        }
        
        const tablaBody = document.getElementById('dev_tablaProductosBody');
        if (tablaBody) tablaBody.innerHTML = '';
        contadorProductosDev = 0;
        actualizarContadorProductosDev();
        
        const productoSelect = document.getElementById('dev_ID_Producto');
        const tallaSelect = document.getElementById('dev_ID_Talla');
        const cantidadInput = document.getElementById('dev_Cantidad');
        if (productoSelect) productoSelect.value = '';
        if (tallaSelect) {
            tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
            tallaSelect.disabled = true;
        }
        if (cantidadInput) cantidadInput.value = '';
        document.getElementById('dev_infoProductoCard').style.display = 'none';
        
        updateStepsDev();
        
        if (loadingDiv) loadingDiv.style.display = 'none';
        if (formContainer) formContainer.style.display = 'block';
        
    } catch (error) {
        console.error('Error al cargar datos:', error);
        if (loadingDiv) {
            loadingDiv.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar los datos: ${error.message}
                </div>
                <button class="btn btn-navy mt-3" onclick="openDevolucionModal()">
                    <i class="fas fa-redo me-1"></i> Reintentar
                </button>
                <button class="btn btn-secondary mt-3 ms-2" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cerrar
                </button>
            `;
        }
    }
}

// ==================== CARGAR PRODUCTOS VÍA FETCH ====================
async function cargarProductosDev() {
    const productoSelect = document.getElementById('dev_ID_Producto');
    if (!productoSelect) return;
    
    try {
        const response = await fetch('../../../Controlador/GET/Formulario/getSelectProduct.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            productosDataDev = data.data;
            productoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Producto --</option>';
            data.data.forEach(producto => {
                productoSelect.innerHTML += `<option value="${producto.IdCProducto}" 
                                                data-empresa="${escapeHtmlDev(producto.Nombre_Empresa)}"
                                                data-categoria="${escapeHtmlDev(producto.Descrp)}"
                                                data-descripcion="${escapeHtmlDev(producto.Descripcion)}"
                                                data-especificacion="${escapeHtmlDev(producto.Especificacion)}"
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
async function cargarTallasDev(productoId) {
    const tallaSelect = document.getElementById('dev_ID_Talla');
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
                tallaSelect.innerHTML += `<option value="${talla.IdCTallas}" data-nombre="${escapeHtmlDev(talla.Talla)}">${escapeHtmlDev(talla.Talla)}</option>`;
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
function actualizarInfoProductoDev(productoId) {
    const producto = productosDataDev.find(p => p.IdCProducto == productoId);
    const infoCard = document.getElementById('dev_infoProductoCard');
    
    if (producto) {
        document.getElementById('dev_infoEmpresa').textContent = producto.Nombre_Empresa || '--';
        document.getElementById('dev_infoCategoria').textContent = producto.Descrp || '--';
        document.getElementById('dev_infoDescripcion').textContent = producto.Descripcion || '--';
        document.getElementById('dev_infoEspecificacion').textContent = producto.Especificacion || '--';
        
        const imagenElement = document.getElementById('dev_productoImagen');
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

// ==================== CONFIGURAR EVENTOS DE PRODUCTO ====================
function setupProductoEventsDev() {
    const productoSelect = document.getElementById('dev_ID_Producto');
    const tallaSelect = document.getElementById('dev_ID_Talla');
    const cantidadInput = document.getElementById('dev_Cantidad');
    
    if (productoSelect) {
        productoSelect.addEventListener('change', function() {
            formularioDevolucionModificado = true;
            const productoId = this.value;
            
            if (productoId) {
                actualizarInfoProductoDev(productoId);
                cargarTallasDev(productoId);
            } else {
                document.getElementById('dev_infoProductoCard').style.display = 'none';
                if (tallaSelect) {
                    tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
                    tallaSelect.disabled = true;
                }
            }
        });
    }
    
    if (cantidadInput) {
        cantidadInput.addEventListener('input', function(e) {
            formularioDevolucionModificado = true;
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
function setupOpcionEventDev() {
    const opcionSelect = document.getElementById('dev_Opcion');
    const solicitudDiv = document.getElementById('dev_SolicitudDiv');
    
    if (opcionSelect) {
        opcionSelect.addEventListener('change', function() {
            formularioDevolucionModificado = true;
            const seleccion = this.value;
            solicitudDiv.style.display = (seleccion === 'Requisicion' || seleccion === 'Prestamo') ? 'block' : 'none';
            
            const identificador = document.getElementById('dev_Identificador');
            if (seleccion === 'Requisicion' || seleccion === 'Prestamo') {
                identificador.required = true;
            } else {
                identificador.required = false;
                identificador.value = '';
            }
        });
    }
}

// ==================== AGREGAR PRODUCTO ====================
function agregarProductoDev() {
    const productoSelect = document.getElementById('dev_ID_Producto');
    const tallaSelect = document.getElementById('dev_ID_Talla');
    const cantidadInput = document.getElementById('dev_Cantidad');
    
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
    
    const producto = productosDataDev.find(p => p.IdCProducto == productoId);
    if (!producto) return;
    
    const tablaBody = document.getElementById('dev_tablaProductosBody');
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
        contadorProductosDev++;
        const nuevaFila = document.createElement('tr');
        nuevaFila.innerHTML = `
            <td class="text-center">${contadorProductosDev}</td>
            <td>${escapeHtmlDev(productoId)}</td>
            <td>${escapeHtmlDev(producto.Nombre_Empresa)}</td>
            <td>${escapeHtmlDev(producto.Descrp)}</td>
            <td>${escapeHtmlDev(producto.Descripcion)}</td>
            <td>${escapeHtmlDev(producto.Especificacion)}</td>
            <td data-id="${escapeHtmlDev(tallaId)}">${escapeHtmlDev(tallaNombre)}</td>
            <td class="text-center">${cantidad}</td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto-dev">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tablaBody.appendChild(nuevaFila);
        
        nuevaFila.querySelector('.btn-eliminar-producto-dev').addEventListener('click', function() {
            eliminarProductoDev(nuevaFila);
        });
        
        Swal.fire({ icon: 'success', title: 'Producto agregado', text: 'El producto ha sido agregado correctamente.', timer: 800, showConfirmButton: false });
    }
    
    productoSelect.value = '';
    tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
    tallaSelect.disabled = true;
    cantidadInput.value = '';
    document.getElementById('dev_infoProductoCard').style.display = 'none';
    
    formularioDevolucionModificado = true;
    actualizarContadorProductosDev();
    actualizarDatosTablaDev();
}

// ==================== ELIMINAR PRODUCTO ====================
function eliminarProductoDev(fila) {
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
            contadorProductosDev--;
            reordenarNumerosDev();
            formularioDevolucionModificado = true;
            actualizarContadorProductosDev();
            actualizarDatosTablaDev();
            
            Swal.fire({ icon: 'success', title: 'Producto eliminado', timer: 800, showConfirmButton: false });
        }
    });
}

// ==================== REORDENAR NÚMEROS ====================
function reordenarNumerosDev() {
    const tablaBody = document.getElementById('dev_tablaProductosBody');
    const filas = tablaBody.querySelectorAll('tr');
    
    filas.forEach((fila, index) => {
        const numeroCelda = fila.querySelector('td:first-child');
        if (numeroCelda) {
            numeroCelda.textContent = index + 1;
        }
    });
    contadorProductosDev = filas.length;
}

// ==================== ACTUALIZAR CONTADOR DE PRODUCTOS ====================
function actualizarContadorProductosDev() {
    const contadorSpan = document.getElementById('dev_productosCount');
    const tablaBody = document.getElementById('dev_tablaProductosBody');
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
function actualizarDatosTablaDev() {
    const datosTabla = document.getElementById('datosTablaInsertDevolucion');
    const tablaBody = document.getElementById('dev_tablaProductosBody');
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

// ==================== ENVÍO DEL FORMULARIO ====================
function submitDevolucionForm() {
    const form = document.getElementById('FormInsertDevolucionNueva');
    
    actualizarDatosTablaDev();
    
    if (!validateStep3Dev()) {
        return;
    }
    
    const formData = new FormData(form);
    formularioDevolucionEnviado = true;
    
    Swal.fire({
        title: 'Registrando devolución...',
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
                    title: '¡Devolución registrada!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if (devolucionModal) devolucionModal.hide();
                    location.reload();
                });
            } else {
                formularioDevolucionEnviado = false;
                Swal.fire({ icon: 'error', title: 'Error', text: data.message, confirmButtonColor: '#001F3F' });
            }
        } catch (err) {
            formularioDevolucionEnviado = false;
            Swal.fire({ icon: 'error', title: 'Error', text: 'Respuesta no válida del servidor.', confirmButtonColor: '#001F3F' });
        }
    })
    .catch(error => {
        formularioDevolucionEnviado = false;
        Swal.fire({ icon: 'error', title: 'Error de conexión', text: 'Hubo un problema al procesar la solicitud.', confirmButtonColor: '#001F3F' });
    });
}

// ==================== ESCAPE HTML ====================
function escapeHtmlDev(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== PREVENIR CIERRE ACCIDENTAL ====================
function setupPrevenirCierreDev() {
    const modalElement = document.getElementById('registrarDevolucionModal');
    const form = document.getElementById('FormInsertDevolucionNueva');
    
    if (!modalElement || !form) return;
    
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            if (input.id !== 'datosTablaInsertDevolucion') {
                formularioDevolucionModificado = true;
            }
        });
        input.addEventListener('input', () => {
            if (input.id !== 'datosTablaInsertDevolucion') {
                formularioDevolucionModificado = true;
            }
        });
    });
    
    modalElement.addEventListener('hide.bs.modal', function(e) {
        if (formularioDevolucionEnviado) return;
        
        if (formularioDevolucionModificado) {
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
                    formularioDevolucionModificado = false;
                    formularioDevolucionEnviado = false;
                    modalElement.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                }
            });
        }
    });
    
    modalElement.addEventListener('hidden.bs.modal', function() {
        formularioDevolucionModificado = false;
        formularioDevolucionEnviado = false;
        currentStepDev = 1;
        
        const loadingDiv = document.getElementById('loadingDevolucionData');
        const formContainer = document.getElementById('devolucionFormContainer');
        
        if (loadingDiv) {
            loadingDiv.style.display = 'block';
            loadingDiv.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando datos...</p>
                </div>
            `;
        }
        if (formContainer) formContainer.style.display = 'none';
        
        const tablaBody = document.getElementById('dev_tablaProductosBody');
        if (tablaBody) tablaBody.innerHTML = '';
        contadorProductosDev = 0;
        actualizarContadorProductosDev();
    });
}

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando modal de devolución...');
    
    const btnAgregar = document.getElementById('dev_btn_AgregarProducto');
    if (btnAgregar) {
        btnAgregar.addEventListener('click', agregarProductoDev);
    }
    
    const btnGuardar = document.getElementById('dev_submitBtn');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            submitDevolucionForm();
        });
    }
    
    const nextBtn = document.getElementById('dev_nextBtn');
    const prevBtn = document.getElementById('dev_prevBtn');
    
    if (nextBtn) nextBtn.addEventListener('click', goToNextStepDev);
    if (prevBtn) prevBtn.addEventListener('click', goToPrevStepDev);
    
    setupProductoEventsDev();
    setupOpcionEventDev();
    setupPrevenirCierreDev();
});

window.openDevolucionModal = openDevolucionModal;