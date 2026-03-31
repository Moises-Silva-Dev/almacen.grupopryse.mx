// ==================== MODAL DE MODIFICAR ENTRADA - JS COMPLETO ====================

let modificarEntradaModal;
let formularioModificarEntradaModificado = false;
let formularioModificarEntradaEnviado = false;
let contadorProductosEdit = 0;
let productosDataEdit = [];
let currentStepEdit = 1;
const totalStepsEdit = 3;

// ==================== FUNCIONES DE NAVEGACIÓN POR CÍRCULOS ====================
function updateStepIndicatorsEdit() {
    const circles = [
        document.getElementById('edit_stepCircle1'),
        document.getElementById('edit_stepCircle2'),
        document.getElementById('edit_stepCircle3')
    ];
    
    const labels = [
        document.getElementById('edit_stepLabel1'),
        document.getElementById('edit_stepLabel2'),
        document.getElementById('edit_stepLabel3')
    ];
    
    const lines = [
        document.getElementById('edit_stepLine1-2'),
        document.getElementById('edit_stepLine2-3')
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
    
    for (let i = 0; i < currentStepEdit - 1; i++) {
        if (circles[i]) circles[i].classList.add('completed');
        if (labels[i]) labels[i].classList.add('completed');
        if (i < lines.length && lines[i]) {
            lines[i].classList.add('completed');
        }
    }
    
    if (currentStepEdit <= circles.length) {
        if (circles[currentStepEdit - 1]) circles[currentStepEdit - 1].classList.add('active');
        if (labels[currentStepEdit - 1]) labels[currentStepEdit - 1].classList.add('active');
        
        if (currentStepEdit - 2 >= 0 && lines[currentStepEdit - 2]) {
            lines[currentStepEdit - 2].classList.add('active');
        }
    }
}

function updateStepsEdit() {
    const step1 = document.getElementById('edit_step1');
    const step2 = document.getElementById('edit_step2');
    const step3 = document.getElementById('edit_step3');
    const prevBtn = document.getElementById('edit_prevBtn');
    const nextBtn = document.getElementById('edit_nextBtn');
    const submitBtn = document.getElementById('edit_submitBtn');
    
    if (step1) step1.style.display = 'none';
    if (step2) step2.style.display = 'none';
    if (step3) step3.style.display = 'none';
    
    if (currentStepEdit === 1 && step1) step1.style.display = 'block';
    if (currentStepEdit === 2 && step2) step2.style.display = 'block';
    if (currentStepEdit === 3 && step3) step3.style.display = 'block';
    
    if (prevBtn) prevBtn.style.display = currentStepEdit === 1 ? 'none' : 'inline-block';
    if (nextBtn) nextBtn.style.display = currentStepEdit === totalStepsEdit ? 'none' : 'inline-block';
    if (submitBtn) submitBtn.style.display = currentStepEdit === totalStepsEdit ? 'inline-block' : 'none';
    
    updateStepIndicatorsEdit();
}

function goToNextStepEdit() {
    if (validateCurrentStepEdit()) {
        currentStepEdit++;
        updateStepsEdit();
        
        const modalBody = document.querySelector('#modificarEntradaModal .modal-body');
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

function goToPrevStepEdit() {
    currentStepEdit--;
    updateStepsEdit();
    
    const modalBody = document.querySelector('#modificarEntradaModal .modal-body');
    if (modalBody) {
        modalBody.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function validateCurrentStepEdit() {
    if (currentStepEdit === 1) {
        return validateStep1Edit();
    }
    if (currentStepEdit === 2) {
        return true;
    }
    if (currentStepEdit === 3) {
        return validateStep3Edit();
    }
    return true;
}

function validateStep1Edit() {
    const proveedor = document.getElementById('edit_Proveedor');
    const receptor = document.getElementById('edit_Receptor');
    const comentarios = document.getElementById('edit_Comentarios');
    
    let isValid = true;
    
    if (!proveedor.value.trim()) {
        proveedor.classList.add('is-invalid');
        isValid = false;
    } else {
        proveedor.classList.remove('is-invalid');
    }
    
    if (!receptor.value.trim()) {
        receptor.classList.add('is-invalid');
        isValid = false;
    } else {
        receptor.classList.remove('is-invalid');
    }
    
    if (!comentarios.value.trim()) {
        comentarios.classList.add('is-invalid');
        isValid = false;
    } else {
        comentarios.classList.remove('is-invalid');
    }
    
    return isValid;
}

function validateStep3Edit() {
    const tablaBody = document.getElementById('edit_tablaProductosBody');
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
async function openModificarEntradaModal(entradaId) {
    if (!modificarEntradaModal) {
        modificarEntradaModal = new bootstrap.Modal(document.getElementById('modificarEntradaModal'));
    }
    
    const loadingDiv = document.getElementById('loadingModificarEntradaData');
    const formContainer = document.getElementById('modificarEntradaFormContainer');
    
    if (loadingDiv) loadingDiv.style.display = 'block';
    if (formContainer) formContainer.style.display = 'none';
    
    formularioModificarEntradaModificado = false;
    formularioModificarEntradaEnviado = false;
    currentStepEdit = 1;
    
    modificarEntradaModal.show();
    
    try {
        const entradaData = await fetchEntradaData(entradaId);
        
        if (entradaData) {
            await cargarProductosEdit();
            fillInformacionGeneralEdit(entradaData);
            fillTablaProductosEdit(entradaData.productos);
            
            document.getElementById('edit_entrada_id').value = entradaData.IdEntD || '';
            document.getElementById('edit_IdEntE').value = entradaData.IdEntE || '';
            document.getElementById('edit_Nro_Modif').value = entradaData.Nro_Modif || '';
            
            updateStepsEdit();
            
            if (loadingDiv) loadingDiv.style.display = 'none';
            if (formContainer) formContainer.style.display = 'block';
        } else {
            throw new Error('No se pudieron cargar los datos');
        }
        
    } catch (error) {
        console.error('Error al cargar entrada:', error);
        if (loadingDiv) {
            loadingDiv.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar los datos: ${error.message}
                </div>
                <button class="btn btn-navy mt-3" onclick="openModificarEntradaModal(${entradaId})">
                    <i class="fas fa-redo me-1"></i> Reintentar
                </button>
                <button class="btn btn-secondary mt-3 ms-2" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cerrar
                </button>
            `;
        }
    }
}

// ==================== FUNCIÓN PARA OBTENER DATOS DE LA ENTRADA ====================
async function fetchEntradaData(entradaId) {
    try {
        const response = await fetch(`../../../Controlador/GET/Formulario/getObtenerInfoEntradaAlmacen.php?id=${entradaId}`);
        
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
        console.error('Error en fetchEntradaData:', error);
        throw error;
    }
}

// ==================== CARGAR PRODUCTOS VÍA FETCH ====================
async function cargarProductosEdit() {
    const productoSelect = document.getElementById('edit_ID_Producto');
    if (!productoSelect) return;
    
    try {
        const response = await fetch('../../../Controlador/GET/Formulario/getSelectProduct.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            productosDataEdit = data.data;
            productoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Producto --</option>';
            data.data.forEach(producto => {
                productoSelect.innerHTML += `<option value="${producto.IdCProducto}" 
                                                data-empresa="${escapeHtmlEntradaEdit(producto.Nombre_Empresa)}"
                                                data-categoria="${escapeHtmlEntradaEdit(producto.Descrp)}"
                                                data-descripcion="${escapeHtmlEntradaEdit(producto.Descripcion)}"
                                                data-especificacion="${escapeHtmlEntradaEdit(producto.Especificacion)}"
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
async function cargarTallasEdit(productoId) {
    const tallaSelect = document.getElementById('edit_ID_Talla');
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
                tallaSelect.innerHTML += `<option value="${talla.IdCTallas}" data-nombre="${escapeHtmlEntradaEdit(talla.Talla)}">${escapeHtmlEntradaEdit(talla.Talla)}</option>`;
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
function actualizarInfoProductoEdit(productoId) {
    const producto = productosDataEdit.find(p => p.IdCProducto == productoId);
    const infoCard = document.getElementById('edit_infoProductoCard');
    
    if (producto) {
        document.getElementById('edit_infoEmpresa').textContent = producto.Nombre_Empresa || '--';
        document.getElementById('edit_infoCategoria').textContent = producto.Descrp || '--';
        document.getElementById('edit_infoDescripcion').textContent = producto.Descripcion || '--';
        document.getElementById('edit_infoEspecificacion').textContent = producto.Especificacion || '--';
        
        const imagenElement = document.getElementById('edit_productoImagen');
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
function fillInformacionGeneralEdit(data) {
    document.getElementById('edit_Proveedor').value = data.Proveedor || '';
    document.getElementById('edit_Receptor').value = data.Receptor || '';
    document.getElementById('edit_Comentarios').value = data.Comentarios || '';
}

// ==================== LLENAR TABLA DE PRODUCTOS ====================
function fillTablaProductosEdit(productos) {
    const tablaBody = document.getElementById('edit_tablaProductosBody');
    if (!tablaBody) return;
    
    tablaBody.innerHTML = '';
    contadorProductosEdit = 0;
    
    if (productos && productos.length > 0) {
        productos.forEach(producto => {
            contadorProductosEdit++;
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td class="text-center">${contadorProductosEdit}</td>
                <td>${escapeHtmlEntradaEdit(producto.IdProd)}</td>
                <td>${escapeHtmlEntradaEdit(producto.Nombre_Empresa)}</td>
                <td>${escapeHtmlEntradaEdit(producto.Descrp)}</td>
                <td>${escapeHtmlEntradaEdit(producto.Descripcion)}</td>
                <td>${escapeHtmlEntradaEdit(producto.Especificacion)}</td>
                <td data-id="${escapeHtmlEntradaEdit(producto.IdTalla)}">${escapeHtmlEntradaEdit(producto.Talla)}</td>
                <td class="text-center">${producto.Cantidad}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto-edit">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            
            tablaBody.appendChild(fila);
            
            fila.querySelector('.btn-eliminar-producto-edit').addEventListener('click', function() {
                eliminarProductoEdit(fila);
            });
        });
    }
    
    actualizarContadorProductosEdit();
    actualizarDatosTablaEdit();
}

// ==================== AGREGAR PRODUCTO ====================
function agregarProductoEdit() {
    const productoSelect = document.getElementById('edit_ID_Producto');
    const tallaSelect = document.getElementById('edit_ID_Talla');
    const cantidadInput = document.getElementById('edit_Cantidad');
    
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
    
    const producto = productosDataEdit.find(p => p.IdCProducto == productoId);
    if (!producto) return;
    
    const tablaBody = document.getElementById('edit_tablaProductosBody');
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
        contadorProductosEdit++;
        const nuevaFila = document.createElement('tr');
        nuevaFila.innerHTML = `
            <td class="text-center">${contadorProductosEdit}</td>
            <td>${escapeHtmlEntradaEdit(productoId)}</td>
            <td>${escapeHtmlEntradaEdit(producto.Nombre_Empresa)}</td>
            <td>${escapeHtmlEntradaEdit(producto.Descrp)}</td>
            <td>${escapeHtmlEntradaEdit(producto.Descripcion)}</td>
            <td>${escapeHtmlEntradaEdit(producto.Especificacion)}</td>
            <td data-id="${escapeHtmlEntradaEdit(tallaId)}">${escapeHtmlEntradaEdit(tallaNombre)}</td>
            <td class="text-center">${cantidad}</td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto-edit">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tablaBody.appendChild(nuevaFila);
        
        nuevaFila.querySelector('.btn-eliminar-producto-edit').addEventListener('click', function() {
            eliminarProductoEdit(nuevaFila);
        });
        
        Swal.fire({ icon: 'success', title: 'Producto agregado', text: 'El producto ha sido agregado correctamente.', timer: 800, showConfirmButton: false });
    }
    
    productoSelect.value = '';
    tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
    tallaSelect.disabled = true;
    cantidadInput.value = '';
    document.getElementById('edit_infoProductoCard').style.display = 'none';
    
    formularioModificarEntradaModificado = true;
    actualizarContadorProductosEdit();
    actualizarDatosTablaEdit();
}

// ==================== ELIMINAR PRODUCTO ====================
function eliminarProductoEdit(fila) {
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
            contadorProductosEdit--;
            reordenarNumerosEdit();
            formularioModificarEntradaModificado = true;
            actualizarContadorProductosEdit();
            actualizarDatosTablaEdit();
            
            Swal.fire({ icon: 'success', title: 'Producto eliminado', timer: 800, showConfirmButton: false });
        }
    });
}

// ==================== REORDENAR NÚMEROS ====================
function reordenarNumerosEdit() {
    const tablaBody = document.getElementById('edit_tablaProductosBody');
    const filas = tablaBody.querySelectorAll('tr');
    
    filas.forEach((fila, index) => {
        const numeroCelda = fila.querySelector('td:first-child');
        if (numeroCelda) {
            numeroCelda.textContent = index + 1;
        }
    });
    contadorProductosEdit = filas.length;
}

// ==================== ACTUALIZAR CONTADOR DE PRODUCTOS ====================
function actualizarContadorProductosEdit() {
    const contadorSpan = document.getElementById('edit_productosCount');
    const tablaBody = document.getElementById('edit_tablaProductosBody');
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
function actualizarDatosTablaEdit() {
    const datosTabla = document.getElementById('datosTablaUpdateEntrada');
    const tablaBody = document.getElementById('edit_tablaProductosBody');
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
function submitModificarEntradaForm() {
    const form = document.getElementById('FormUpdateEntrada');
    
    actualizarDatosTablaEdit();
    
    if (!validateStep3Edit()) {
        return;
    }
    
    const formData = new FormData(form);
    formularioModificarEntradaEnviado = true;
    
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
                    title: '¡Entrada actualizada!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if (modificarEntradaModal) modificarEntradaModal.hide();
                    location.reload();
                });
            } else {
                formularioModificarEntradaEnviado = false;
                Swal.fire({ icon: 'error', title: 'Error', text: data.message, confirmButtonColor: '#001F3F' });
            }
        } catch (err) {
            formularioModificarEntradaEnviado = false;
            Swal.fire({ icon: 'error', title: 'Error', text: 'Respuesta no válida del servidor.', confirmButtonColor: '#001F3F' });
        }
    })
    .catch(error => {
        formularioModificarEntradaEnviado = false;
        Swal.fire({ icon: 'error', title: 'Error de conexión', text: 'Hubo un problema al procesar la solicitud.', confirmButtonColor: '#001F3F' });
    });
}

// ==================== ESCAPE HTML ====================
function escapeHtmlEntradaEdit(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== CONFIGURAR EVENTOS ====================
function setupProductoEventsEdit() {
    const productoSelect = document.getElementById('edit_ID_Producto');
    const tallaSelect = document.getElementById('edit_ID_Talla');
    const cantidadInput = document.getElementById('edit_Cantidad');
    
    if (productoSelect) {
        productoSelect.addEventListener('change', function() {
            formularioModificarEntradaModificado = true;
            const productoId = this.value;
            
            if (productoId) {
                actualizarInfoProductoEdit(productoId);
                cargarTallasEdit(productoId);
            } else {
                document.getElementById('edit_infoProductoCard').style.display = 'none';
                if (tallaSelect) {
                    tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
                    tallaSelect.disabled = true;
                }
            }
        });
    }
    
    if (cantidadInput) {
        cantidadInput.addEventListener('input', function(e) {
            formularioModificarEntradaModificado = true;
            let valor = this.value.replace(/[^0-9]/g, '');
            if (valor.length > 1 && valor.startsWith('0')) {
                valor = valor.replace(/^0+/, '');
                if (valor === '') valor = '0';
            }
            this.value = valor;
        });
    }
}

// ==================== PREVENIR CIERRE ACCIDENTAL ====================
function setupPrevenirCierreEdit() {
    const modalElement = document.getElementById('modificarEntradaModal');
    const form = document.getElementById('FormUpdateEntrada');
    
    if (!modalElement || !form) return;
    
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            if (input.id !== 'datosTablaUpdateEntrada') {
                formularioModificarEntradaModificado = true;
            }
        });
        input.addEventListener('input', () => {
            if (input.id !== 'datosTablaUpdateEntrada') {
                formularioModificarEntradaModificado = true;
            }
        });
    });
    
    modalElement.addEventListener('hide.bs.modal', function(e) {
        if (formularioModificarEntradaEnviado) return;
        
        if (formularioModificarEntradaModificado) {
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
                    formularioModificarEntradaModificado = false;
                    formularioModificarEntradaEnviado = false;
                    modalElement.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                }
            });
        }
    });
    
    modalElement.addEventListener('hidden.bs.modal', function() {
        formularioModificarEntradaModificado = false;
        formularioModificarEntradaEnviado = false;
        currentStepEdit = 1;
        
        const loadingDiv = document.getElementById('loadingModificarEntradaData');
        const formContainer = document.getElementById('modificarEntradaFormContainer');
        
        if (loadingDiv) {
            loadingDiv.style.display = 'block';
            loadingDiv.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando datos de la entrada...</p>
                </div>
            `;
        }
        if (formContainer) formContainer.style.display = 'none';
    });
}

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando modal de modificar entrada...');
    
    const btnAgregar = document.getElementById('edit_btn_AgregarProductoEntrada');
    if (btnAgregar) {
        btnAgregar.addEventListener('click', agregarProductoEdit);
    }
    
    const btnGuardar = document.getElementById('edit_submitBtn');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            submitModificarEntradaForm();
        });
    }
    
    const nextBtn = document.getElementById('edit_nextBtn');
    const prevBtn = document.getElementById('edit_prevBtn');
    
    if (nextBtn) nextBtn.addEventListener('click', goToNextStepEdit);
    if (prevBtn) prevBtn.addEventListener('click', goToPrevStepEdit);
    
    setupProductoEventsEdit();
    setupPrevenirCierreEdit();
});

window.openModificarEntradaModal = openModificarEntradaModal;