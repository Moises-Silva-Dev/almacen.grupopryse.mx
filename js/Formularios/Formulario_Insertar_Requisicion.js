// Importar diccionarios desde archivos externos
import { diccionarioTallas } from './DiccionarioTallasRestriccion.js';
// console.log(diccionarioTallas);
import { productosExcluidos } from './DiccionarioProductosBaja.js';
// console.log(productosExcluidos);

// ==================== MODAL DE REGISTRO DE REQUISICION - JS COMPLETO ====================

let RequisicionModal;
let formularioRequisicionModificado = false;
let formularioRequisicionEnviado = false;
let contadorProductosReq = 0;
let productosDataReq = [];
let currentStepReq = 1;
const totalStepsReq = 3;
// porque vienen de los archivos importados

// ==================== FUNCIÓN PARA ABRIR EL MODAL ====================
async function openRequisicionModal() {
    if (!RequisicionModal) {
        RequisicionModal = new bootstrap.Modal(document.getElementById('registrarRequisicionModal'));
    }
    
    const loadingDiv = document.getElementById('loadingRequisicionData');
    const formContainer = document.getElementById('RequisicionFormContainer');
    
    if (loadingDiv) loadingDiv.style.display = 'block';
    if (formContainer) formContainer.style.display = 'none';
    
    formularioRequisicionModificado = false;
    formularioRequisicionEnviado = false;
    currentStepReq = 1;
    
    RequisicionModal.show();
    
    try {
        // Cargar datos (sin los diccionarios porque ya están importados)
        await Promise.all([
            cargarCuentasReq(),
            cargarProductosReq()
        ]);
        
        // Resetear formulario
        const form = document.getElementById('FormInsertRequisicionNueva');
        if (form) {
            form.reset();
            document.querySelectorAll('#registrarRequisicionModal .is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
        }
        
        // Limpiar tabla de productos
        const tablaBody = document.getElementById('Req_tablaProductosBody');
        if (tablaBody) tablaBody.innerHTML = '';
        contadorProductosReq = 0;
        actualizarContadorProductosReq();
        
        // Limpiar campos de selección de producto
        const productoSelect = document.getElementById('Req_ID_Producto');
        const tallaSelect = document.getElementById('Req_ID_Talla');
        const cantidadInput = document.getElementById('Req_Cantidad');
        
        if (productoSelect) productoSelect.value = '';
        if (tallaSelect) {
            tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
            tallaSelect.disabled = true;
        }
        if (cantidadInput) cantidadInput.value = '';
        
        document.getElementById('Req_infoProductoCard').style.display = 'none';
        
        // Actualizar pasos
        updateStepsReq();
        
        // Ocultar loading y mostrar formulario
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
                <button class="btn btn-navy mt-3" onclick="openRequisicionModal()">
                    <i class="fas fa-redo me-1"></i> Reintentar
                </button>
                <button class="btn btn-secondary mt-3 ms-2" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cerrar
                </button>
            `;
        }
    }
}

// ==================== CARGAR TALLAS DEL PRODUCTO (usando diccionario importado) ====================
async function cargarTallasReq(productoId) {
    const tallaSelect = document.getElementById('Req_ID_Talla');
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
            // Filtrar tallas según diccionario importado
            let tallasFiltradas = data.data;
            const tallasPermitidas = diccionarioTallas[productoId];
            
            if (tallasPermitidas && tallasPermitidas.length > 0) {
                tallasFiltradas = tallasFiltradas.filter(talla => 
                    tallasPermitidas.includes(talla.Talla)
                );
            }
            
            if (tallasFiltradas.length > 0) {
                tallaSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Talla --</option>';
                tallasFiltradas.forEach(talla => {
                    tallaSelect.innerHTML += `<option value="${talla.IdCTallas}" data-nombre="${escapeHtmlReq(talla.Talla)}">${escapeHtmlReq(talla.Talla)}</option>`;
                });
                tallaSelect.disabled = false;
            } else {
                tallaSelect.innerHTML = '<option value="" selected disabled>-- No hay tallas disponibles para este producto --</option>';
                tallaSelect.disabled = true;
            }
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
function actualizarInfoProductoReq(productoId) {
    const producto = productosDataReq.find(p => p.IdCProducto == productoId);
    const infoCard = document.getElementById('Req_infoProductoCard');
    
    if (producto) {
        document.getElementById('Req_infoEmpresa').textContent = producto.Nombre_Empresa || '--';
        document.getElementById('Req_infoCategoria').textContent = producto.Descrp || '--';
        document.getElementById('Req_infoDescripcion').textContent = producto.Descripcion || '--';
        document.getElementById('Req_infoEspecificacion').textContent = producto.Especificacion || '--';
        
        const imagenElement = document.getElementById('Req_productoImagen');
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

// ==================== CONFIGURAR EVENTOS ====================
function setupEventosReq() {
    // Evento de cambio de cuenta
    const cuentaSelect = document.getElementById('Req_ID_Cuenta');
    if (cuentaSelect) {
        cuentaSelect.addEventListener('change', function() {
            formularioRequisicionModificado = true;
            const cuentaId = this.value;
            if (cuentaId) {
                cargarRegionesReq(cuentaId);
            } else {
                const regionSelect = document.getElementById('Req_Region');
                if (regionSelect) {
                    regionSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Región --</option>';
                    regionSelect.disabled = true;
                }
                const estadoSelect = document.getElementById('Req_Estado');
                if (estadoSelect) {
                    estadoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Estado --</option>';
                    estadoSelect.disabled = true;
                }
            }
        });
    }
    
    // Evento de cambio de región
    const regionSelect = document.getElementById('Req_Region');
    if (regionSelect) {
        regionSelect.addEventListener('change', function() {
            formularioRequisicionModificado = true;
            const regionId = this.value;
            if (regionId) {
                cargarEstadosReq(regionId);
            } else {
                const estadoSelect = document.getElementById('Req_Estado');
                if (estadoSelect) {
                    estadoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Estado --</option>';
                    estadoSelect.disabled = true;
                }
            }
        });
    }
    
    // Evento de cambio de producto
    const productoSelect = document.getElementById('Req_ID_Producto');
    if (productoSelect) {
        productoSelect.addEventListener('change', function() {
            formularioRequisicionModificado = true;
            const productoId = this.value;
            
            // Verificar si producto está excluido usando el diccionario importado
            if (productosExcluidos.includes(parseInt(productoId))) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Producto no disponible',
                    text: 'Este producto no está disponible actualmente.',
                    confirmButtonColor: '#001F3F'
                });
                this.value = '';
                document.getElementById('Req_infoProductoCard').style.display = 'none';
                const tallaSelect = document.getElementById('Req_ID_Talla');
                if (tallaSelect) {
                    tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
                    tallaSelect.disabled = true;
                }
                return;
            }
            
            if (productoId) {
                actualizarInfoProductoReq(productoId);
                cargarTallasReq(productoId);
            } else {
                document.getElementById('Req_infoProductoCard').style.display = 'none';
                const tallaSelect = document.getElementById('Req_ID_Talla');
                if (tallaSelect) {
                    tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
                    tallaSelect.disabled = true;
                }
            }
        });
    }
    
    // Evento de cantidad
    const cantidadInput = document.getElementById('Req_Cantidad');
    if (cantidadInput) {
        cantidadInput.addEventListener('input', function(e) {
            formularioRequisicionModificado = true;
            let valor = this.value.replace(/[^0-9]/g, '');
            if (valor.length > 1 && valor.startsWith('0')) {
                valor = valor.replace(/^0+/, '');
                if (valor === '') valor = '0';
            }
            this.value = valor;
        });
    }
    
    // Evento de opción de envío
    const opcionSelect = document.getElementById('Req_Opcion');
    const direccionDiv = document.getElementById('Req_DireccionDiv');
    if (opcionSelect) {
        opcionSelect.addEventListener('change', function() {
            formularioRequisicionModificado = true;
            direccionDiv.style.display = this.value === 'SI' ? 'block' : 'none';
        });
    }
}

// ==================== ELIMINAR PRODUCTO ====================
function eliminarProductoReq(fila) {
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
            contadorProductosReq--;
            reordenarNumerosReq();
            formularioRequisicionModificado = true;
            actualizarContadorProductosReq();
            actualizarDatosTablaReq();
            
            Swal.fire({ icon: 'success', title: 'Producto eliminado', timer: 800, showConfirmButton: false });
        }
    });
}

// ==================== AGREGAR PRODUCTO ====================
function agregarProductoReq() {
    const productoSelect = document.getElementById('Req_ID_Producto');
    const tallaSelect = document.getElementById('Req_ID_Talla');
    const cantidadInput = document.getElementById('Req_Cantidad');
    
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
    
    const producto = productosDataReq.find(p => p.IdCProducto == productoId);
    if (!producto) return;
    
    const tablaBody = document.getElementById('Req_tablaProductosBody');
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
        contadorProductosReq++;
        const nuevaFila = document.createElement('tr');
        nuevaFila.innerHTML = `
            <td class="text-center">${contadorProductosReq}</td>
            <td>${escapeHtmlReq(productoId)}</td>
            <td>${escapeHtmlReq(producto.Nombre_Empresa)}</td>
            <td>${escapeHtmlReq(producto.Descrp)}</td>
            <td>${escapeHtmlReq(producto.Descripcion)}</td>
            <td>${escapeHtmlReq(producto.Especificacion)}</td>
            <td data-id="${escapeHtmlReq(tallaId)}">${escapeHtmlReq(tallaNombre)}</td>
            <td class="text-center">${cantidad}</td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto-Req">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tablaBody.appendChild(nuevaFila);
        
        nuevaFila.querySelector('.btn-eliminar-producto-Req').addEventListener('click', function() {
            eliminarProductoReq(nuevaFila);
        });
        
        Swal.fire({ icon: 'success', title: 'Producto agregado', text: 'El producto ha sido agregado correctamente.', timer: 800, showConfirmButton: false });
    }
    
    productoSelect.value = '';
    tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
    tallaSelect.disabled = true;
    cantidadInput.value = '';
    document.getElementById('Req_infoProductoCard').style.display = 'none';
    
    formularioRequisicionModificado = true;
    actualizarContadorProductosReq();
    actualizarDatosTablaReq();
}

// ==================== REORDENAR NÚMEROS ====================
function reordenarNumerosReq() {
    const tablaBody = document.getElementById('Req_tablaProductosBody');
    const filas = tablaBody.querySelectorAll('tr');
    
    filas.forEach((fila, index) => {
        const numeroCelda = fila.querySelector('td:first-child');
        if (numeroCelda) {
            numeroCelda.textContent = index + 1;
        }
    });
    contadorProductosReq = filas.length;
}

// ==================== ACTUALIZAR CONTADOR DE PRODUCTOS ====================
function actualizarContadorProductosReq() {
    const contadorSpan = document.getElementById('Req_productosCount');
    const tablaBody = document.getElementById('Req_tablaProductosBody');
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
function actualizarDatosTablaReq() {
    const datosTabla = document.getElementById('datosTabla');
    const tablaBody = document.getElementById('Req_tablaProductosBody');
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

// ==================== FUNCIONES DE NAVEGACIÓN ====================
function updateStepIndicatorsReq() {
    const circles = [
        document.getElementById('Req_stepCircle1'),
        document.getElementById('Req_stepCircle2'),
        document.getElementById('Req_stepCircle3')
    ];
    
    const labels = [
        document.getElementById('Req_stepLabel1'),
        document.getElementById('Req_stepLabel2'),
        document.getElementById('Req_stepLabel3')
    ];
    
    const lines = [
        document.getElementById('Req_stepLine1-2'),
        document.getElementById('Req_stepLine2-3')
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
    
    for (let i = 0; i < currentStepReq - 1; i++) {
        if (circles[i]) circles[i].classList.add('completed');
        if (labels[i]) labels[i].classList.add('completed');
        if (i < lines.length && lines[i]) {
            lines[i].classList.add('completed');
        }
    }
    
    if (currentStepReq <= circles.length) {
        if (circles[currentStepReq - 1]) circles[currentStepReq - 1].classList.add('active');
        if (labels[currentStepReq - 1]) labels[currentStepReq - 1].classList.add('active');
        
        if (currentStepReq - 2 >= 0 && lines[currentStepReq - 2]) {
            lines[currentStepReq - 2].classList.add('active');
        }
    }
}

function updateStepsReq() {
    const step1 = document.getElementById('Req_step1');
    const step2 = document.getElementById('Req_step2');
    const step3 = document.getElementById('Req_step3');
    const prevBtn = document.getElementById('Req_prevBtn');
    const nextBtn = document.getElementById('Req_nextBtn');
    const submitBtn = document.getElementById('Req_submitBtn');
    
    if (step1) step1.style.display = 'none';
    if (step2) step2.style.display = 'none';
    if (step3) step3.style.display = 'none';
    
    if (currentStepReq === 1 && step1) step1.style.display = 'block';
    if (currentStepReq === 2 && step2) step2.style.display = 'block';
    if (currentStepReq === 3 && step3) step3.style.display = 'block';
    
    if (prevBtn) prevBtn.style.display = currentStepReq === 1 ? 'none' : 'inline-block';
    if (nextBtn) nextBtn.style.display = currentStepReq === totalStepsReq ? 'none' : 'inline-block';
    if (submitBtn) submitBtn.style.display = currentStepReq === totalStepsReq ? 'inline-block' : 'none';
    
    updateStepIndicatorsReq();
}

function goToNextStepReq() {
    if (validateCurrentStepReq()) {
        currentStepReq++;
        updateStepsReq();
        
        const modalBody = document.querySelector('#registrarRequisicionModal .modal-body');
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

function goToPrevStepReq() {
    currentStepReq--;
    updateStepsReq();
    
    const modalBody = document.querySelector('#registrarRequisicionModal .modal-body');
    if (modalBody) {
        modalBody.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function validateCurrentStepReq() {
    if (currentStepReq === 1) {
        return validateStep1Req();
    }
    if (currentStepReq === 2) {
        return true;
    }
    if (currentStepReq === 3) {
        return validateStep3Req();
    }
    return true;
}

function validateStep1Req() {
    const supervisor = document.getElementById('Req_Supervisor');
    const cuenta = document.getElementById('Req_ID_Cuenta');
    const region = document.getElementById('Req_Region');
    const nroElementos = document.getElementById('Req_NroElementos');
    const estado = document.getElementById('Req_Estado');
    const receptor = document.getElementById('Req_Receptor');
    const telefono = document.getElementById('Req_num_tel');
    const justificacion = document.getElementById('Req_Justificacion');
    const opcion = document.getElementById('Req_Opcion');
    
    let isValid = true;
    
    if (!supervisor.value.trim()) {
        supervisor.classList.add('is-invalid');
        isValid = false;
    } else {
        supervisor.classList.remove('is-invalid');
    }
    
    if (!cuenta.value) {
        cuenta.classList.add('is-invalid');
        isValid = false;
    } else {
        cuenta.classList.remove('is-invalid');
    }
    
    if (!region.value) {
        region.classList.add('is-invalid');
        isValid = false;
    } else {
        region.classList.remove('is-invalid');
    }
    
    if (!nroElementos.value.trim() || parseInt(nroElementos.value) <= 0) {
        nroElementos.classList.add('is-invalid');
        isValid = false;
    } else {
        nroElementos.classList.remove('is-invalid');
    }
    
    if (!estado.value) {
        estado.classList.add('is-invalid');
        isValid = false;
    } else {
        estado.classList.remove('is-invalid');
    }
    
    if (!receptor.value.trim()) {
        receptor.classList.add('is-invalid');
        isValid = false;
    } else {
        receptor.classList.remove('is-invalid');
    }
    
    if (!telefono.value.trim() || telefono.value.length !== 10) {
        telefono.classList.add('is-invalid');
        isValid = false;
    } else {
        telefono.classList.remove('is-invalid');
    }
    
    if (!justificacion.value.trim()) {
        justificacion.classList.add('is-invalid');
        isValid = false;
    } else {
        justificacion.classList.remove('is-invalid');
    }
    
    if (!opcion.value) {
        opcion.classList.add('is-invalid');
        isValid = false;
    } else {
        opcion.classList.remove('is-invalid');
    }
    
    return isValid;
}

function validateStep3Req() {
    const tablaBody = document.getElementById('Req_tablaProductosBody');
    const productos = tablaBody.querySelectorAll('tr');
    
    if (productos.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Sin productos',
            text: 'Debes agregar al menos un producto antes de guardar el Requisicion.',
            confirmButtonColor: '#001F3F'
        });
        return false;
    }
    return true;
}

// ==================== ENVÍO DEL FORMULARIO ====================
function submitRequisicionForm() {
    const form = document.getElementById('FormInsertRequisicionNueva');
    
    actualizarDatosTablaReq();
    
    if (!validateStep3Req()) {
        return;
    }
    
    const formData = new FormData(form);
    formularioRequisicionEnviado = true;
    
    Swal.fire({
        title: 'Guardando Requisicion...',
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
                    title: '¡Requisicion guardado!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if (RequisicionModal) RequisicionModal.hide();
                    location.reload();
                });
            } else {
                formularioRequisicionEnviado = false;
                Swal.fire({ icon: 'error', title: 'Error', text: data.message, confirmButtonColor: '#001F3F' });
            }
        } catch (err) {
            formularioRequisicionEnviado = false;
            Swal.fire({ icon: 'error', title: 'Error', text: 'Respuesta no válida del servidor.', confirmButtonColor: '#001F3F' });
        }
    })
    .catch(error => {
        formularioRequisicionEnviado = false;
        Swal.fire({ icon: 'error', title: 'Error de conexión', text: 'Hubo un problema al procesar la solicitud.', confirmButtonColor: '#001F3F' });
    });
}

// ==================== ESCAPE HTML ====================
function escapeHtmlReq(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== PREVENIR CIERRE ACCIDENTAL ====================
function setupPrevenirCierreReq() {
    const modalElement = document.getElementById('registrarRequisicionModal');
    const form = document.getElementById('FormInsertRequisicionNueva');
    
    if (!modalElement || !form) return;
    
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            if (input.id !== 'datosTabla') {
                formularioRequisicionModificado = true;
            }
        });
        input.addEventListener('input', () => {
            if (input.id !== 'datosTabla') {
                formularioRequisicionModificado = true;
            }
        });
    });
    
    modalElement.addEventListener('hide.bs.modal', function(e) {
        if (formularioRequisicionEnviado) return;
        
        if (formularioRequisicionModificado) {
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
                    formularioRequisicionModificado = false;
                    formularioRequisicionEnviado = false;
                    modalElement.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                }
            });
        }
    });
    
    modalElement.addEventListener('hidden.bs.modal', function() {
        formularioRequisicionModificado = false;
        formularioRequisicionEnviado = false;
        currentStepReq = 1;
        
        const loadingDiv = document.getElementById('loadingRequisicionData');
        const formContainer = document.getElementById('RequisicionFormContainer');
        
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
        
        const tablaBody = document.getElementById('Req_tablaProductosBody');
        if (tablaBody) tablaBody.innerHTML = '';
        contadorProductosReq = 0;
        actualizarContadorProductosReq();
    });
}

// ==================== CARGAR CUENTAS DEL USUARIO ====================
async function cargarCuentasReq() {
    const cuentaSelect = document.getElementById('Req_ID_Cuenta');
    if (!cuentaSelect) return;
    
    try {
        cuentaSelect.innerHTML = '<option value="" selected disabled>⏳ Cargando cuentas...</option>';
        cuentaSelect.disabled = true;
        
        const response = await fetch(`../../../Controlador/GET/Formulario/getSelectCuentaAdmin.php?correo_electronico=${usuarioCorreo}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (Array.isArray(data) && data.length > 0) {
            cuentaSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Cuenta --</option>';
            data.forEach(cuenta => {
                cuentaSelect.innerHTML += `<option value="${cuenta.ID}">${escapeHtmlReq(cuenta.NombreCuenta)}</option>`;
            });
            cuentaSelect.disabled = false;
        } else if (data.success === false) {
            throw new Error(data.message || 'Error al cargar cuentas');
        } else {
            cuentaSelect.innerHTML = '<option value="" selected disabled>-- No hay cuentas disponibles --</option>';
            cuentaSelect.disabled = true;
        }
        
    } catch (error) {
        console.error('Error al cargar cuentas:', error);
        cuentaSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar cuentas</option>';
        cuentaSelect.disabled = true;
    }
}

// ==================== CARGAR REGIONES POR CUENTA ====================
async function cargarRegionesReq(cuentaId) {
    const regionSelect = document.getElementById('Req_Region');
    if (!regionSelect) return;
    
    try {
        regionSelect.innerHTML = '<option value="" selected disabled>⏳ Cargando regiones...</option>';
        regionSelect.disabled = true;
        
        const response = await fetch(`../../../Controlador/GET/Formulario/getSelectCuentaRegionAdmin.php?id=${cuentaId}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        // Verificar la estructura de la respuesta
        if (data.success && data.data && data.data.length > 0) {
            regionSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Región --</option>';
            data.data.forEach(region => {
                regionSelect.innerHTML += `<option value="${region.ID_Region}">${escapeHtmlReq(region.Nombre_Region)}</option>`;
            });
            regionSelect.disabled = false;
        } else if (data.success && (!data.data || data.data.length === 0)) {
            regionSelect.innerHTML = '<option value="" selected disabled>-- No hay regiones disponibles --</option>';
            regionSelect.disabled = true;
        } else {
            throw new Error(data.message || 'Error al cargar regiones');
        }
        
    } catch (error) {
        console.error('Error al cargar regiones:', error);
        regionSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar regiones</option>';
        regionSelect.disabled = true;
        
        Swal.fire({
            icon: 'error',
            title: 'Error de carga',
            text: 'No se pudieron cargar las regiones. Por favor, intenta nuevamente.',
            confirmButtonColor: '#001F3F'
        });
    }
}

// ==================== CARGAR ESTADOS POR REGIÓN ====================
async function cargarEstadosReq(regionId) {
    const estadoSelect = document.getElementById('Req_Estado');
    if (!estadoSelect) return;
    
    try {
        estadoSelect.innerHTML = '<option value="" selected disabled>⏳ Cargando estados...</option>';
        estadoSelect.disabled = true;
        
        const response = await fetch(`../../../Controlador/GET/Formulario/getSelectRegionEstadoAdmin.php?id=${regionId}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        // Verificar la estructura de la respuesta
        if (data.success && data.data && data.data.length > 0) {
            estadoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Estado --</option>';
            data.data.forEach(estado => {
                estadoSelect.innerHTML += `<option value="${estado.Id_Estado}">${escapeHtmlReq(estado.Nombre_estado)}</option>`;
            });
            estadoSelect.disabled = false;
        } else if (data.success && (!data.data || data.data.length === 0)) {
            estadoSelect.innerHTML = '<option value="" selected disabled>-- No hay estados disponibles --</option>';
            estadoSelect.disabled = true;
        } else {
            throw new Error(data.message || 'Error al cargar estados');
        }
        
    } catch (error) {
        console.error('Error al cargar estados:', error);
        estadoSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar estados</option>';
        estadoSelect.disabled = true;
        
        Swal.fire({
            icon: 'error',
            title: 'Error de carga',
            text: 'No se pudieron cargar los estados. Por favor, intenta nuevamente.',
            confirmButtonColor: '#001F3F'
        });
    }
}

// ==================== CARGAR PRODUCTOS ====================
async function cargarProductosReq() {
    const productoSelect = document.getElementById('Req_ID_Producto');
    if (!productoSelect) return;
    
    try {
        const response = await fetch('../../../Controlador/GET/Formulario/getSelectProduct.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            productosDataReq = data.data;
            productoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Producto --</option>';
            data.data.forEach(producto => {
                productoSelect.innerHTML += `<option value="${producto.IdCProducto}" 
                                                data-empresa="${escapeHtmlReq(producto.Nombre_Empresa)}"
                                                data-categoria="${escapeHtmlReq(producto.Descrp)}"
                                                data-descripcion="${escapeHtmlReq(producto.Descripcion)}"
                                                data-especificacion="${escapeHtmlReq(producto.Especificacion)}"
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

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando modal de Requisicion...');
    
    const btnAgregar = document.getElementById('Req_btn_AgregarProducto');
    if (btnAgregar) {
        btnAgregar.addEventListener('click', agregarProductoReq);
    }
    
    const btnGuardar = document.getElementById('Req_submitBtn');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            submitRequisicionForm();
        });
    }
    
    const nextBtn = document.getElementById('Req_nextBtn');
    const prevBtn = document.getElementById('Req_prevBtn');
    
    if (nextBtn) nextBtn.addEventListener('click', goToNextStepReq);
    if (prevBtn) prevBtn.addEventListener('click', goToPrevStepReq);
    
    setupEventosReq();
    setupPrevenirCierreReq();
});

// Función global para abrir el modal
window.openRequisicionModal = openRequisicionModal;