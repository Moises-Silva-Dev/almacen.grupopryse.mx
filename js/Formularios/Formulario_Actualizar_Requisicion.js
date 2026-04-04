// ==================== MODAL DE MODIFICAR REQUISICION - JS COMPLETO ====================

import { diccionarioTallas } from './DiccionarioTallasRestriccion.js';
import { productosExcluidos } from './DiccionarioProductosBaja.js';

let modificarRequisicionModal;
let formularioModificarRequisicionModificado = false;
let formularioModificarRequisicionEnviado = false;
let contadorProductosEditReq = 0;
let productosDataEditReq = [];
let currentStepEditReq = 1;
const totalStepsEditReq = 3;

// ==================== FUNCIÓN PARA ABRIR EL MODAL ====================
async function openModificarRequisicionModal(RequisicionId) {
    if (!modificarRequisicionModal) {
        modificarRequisicionModal = new bootstrap.Modal(document.getElementById('modificarRequisicionModal'));
    }
    
    const loadingDiv = document.getElementById('loadingModificarRequisicionData');
    const formContainer = document.getElementById('modificarRequisicionFormContainer');
    
    if (loadingDiv) loadingDiv.style.display = 'block';
    if (formContainer) formContainer.style.display = 'none';
    
    formularioModificarRequisicionModificado = false;
    formularioModificarRequisicionEnviado = false;
    currentStepEditReq = 1;
    
    modificarRequisicionModal.show();
    
    try {
        const RequisicionData = await fetchRequisicionData(RequisicionId);
        
        if (RequisicionData) {
            await Promise.all([
                console.log('RequisicionData:', RequisicionData),
                cargarCuentasEditReq(RequisicionData.IdCuenta),
                cargarProductosEditReq()
            ]);
            
            fillInformacionGeneralEditReq(RequisicionData);
            fillTablaProductosEditReq(RequisicionData.productos);
            
            document.getElementById('edit_requisicion_id').value = RequisicionData.IDRequisicionE || '';
            
            updateStepsEditReq();
            
            if (loadingDiv) loadingDiv.style.display = 'none';
            if (formContainer) formContainer.style.display = 'block';
        } else {
            throw new Error('No se pudieron cargar los datos de la requisición');
        }
        
    } catch (error) {
        console.error('Error al cargar Requisicion:', error);
        if (loadingDiv) {
            loadingDiv.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar los datos: ${error.message}
                </div>
                <button class="btn btn-navy mt-3" onclick="openModificarRequisicionModal(${RequisicionId})">
                    <i class="fas fa-redo me-1"></i> Reintentar
                </button>
                <button class="btn btn-secondary mt-3 ms-2" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cerrar
                </button>
            `;
        }
    }
}

// ==================== FUNCIÓN PARA OBTENER DATOS DEL Requisicion ====================
async function fetchRequisicionData(RequisicionId) {
    try {
        const response = await fetch(`../../../Controlador/GET/Formulario/getObtenerInfoRequisicion.php?id=${RequisicionId}`);
        
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

// ==================== CARGAR CUENTAS ====================
async function cargarCuentasEditReq(selectedId) {
    const cuentaSelect = document.getElementById('edit_Req_ID_Cuenta');
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
                const selected = selectedId == cuenta.ID ? 'selected' : '';
                cuentaSelect.innerHTML += `<option value="${cuenta.ID}" ${selected}>${escapeHtmlEditReq(cuenta.NombreCuenta)}</option>`;
            });
            cuentaSelect.disabled = false;
            
            // Cargar regiones después de seleccionar la cuenta
            if (selectedId) {
                await cargarRegionesEditReq(selectedId);
            }
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

// ==================== CARGAR REGIONES ====================
async function cargarRegionesEditReq(cuentaId, selectedId = null) {
    const regionSelect = document.getElementById('edit_Req_Region');
    if (!regionSelect) return;
    
    try {
        regionSelect.innerHTML = '<option value="" selected disabled>⏳ Cargando regiones...</option>';
        regionSelect.disabled = true;
        
        const response = await fetch(`../../../Controlador/GET/Formulario/getSelectCuentaRegionAdmin.php?id=${cuentaId}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            regionSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Región --</option>';
            data.data.forEach(region => {
                const selected = selectedId == region.ID_Region ? 'selected' : '';
                regionSelect.innerHTML += `<option value="${region.ID_Region}" ${selected}>${escapeHtmlEditReq(region.Nombre_Region)}</option>`;
            });
            regionSelect.disabled = false;
        } else if (Array.isArray(data) && data.length > 0) {
            regionSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Región --</option>';
            data.forEach(region => {
                const selected = selectedId == region.ID_Region ? 'selected' : '';
                regionSelect.innerHTML += `<option value="${region.ID_Region}" ${selected}>${escapeHtmlEditReq(region.Nombre_Region)}</option>`;
            });
            regionSelect.disabled = false;
        } else {
            regionSelect.innerHTML = '<option value="" selected disabled>-- No hay regiones disponibles --</option>';
            regionSelect.disabled = true;
        }
        
    } catch (error) {
        console.error('Error al cargar regiones:', error);
        regionSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar regiones</option>';
        regionSelect.disabled = true;
    }
}

// ==================== CARGAR ESTADOS ====================
async function cargarEstadosEditReq(regionId, selectedId = null) {
    const estadoSelect = document.getElementById('edit_Req_Estado');
    if (!estadoSelect) return;
    
    try {
        estadoSelect.innerHTML = '<option value="" selected disabled>⏳ Cargando estados...</option>';
        estadoSelect.disabled = true;
        
        const response = await fetch(`../../../Controlador/GET/Formulario/getSelectRegionEstadoAdmin.php?id=${regionId}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            estadoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Estado --</option>';
            data.data.forEach(estado => {
                const selected = selectedId == estado.Id_Estado ? 'selected' : '';
                estadoSelect.innerHTML += `<option value="${estado.Id_Estado}" ${selected}>${escapeHtmlEditReq(estado.Nombre_estado)}</option>`;
            });
            estadoSelect.disabled = false;
        } else if (Array.isArray(data) && data.length > 0) {
            estadoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Estado --</option>';
            data.forEach(estado => {
                const selected = selectedId == estado.Id_Estado ? 'selected' : '';
                estadoSelect.innerHTML += `<option value="${estado.Id_Estado}" ${selected}>${escapeHtmlEditReq(estado.Nombre_estado)}</option>`;
            });
            estadoSelect.disabled = false;
        } else {
            estadoSelect.innerHTML = '<option value="" selected disabled>-- No hay estados disponibles --</option>';
            estadoSelect.disabled = true;
        }
        
    } catch (error) {
        console.error('Error al cargar estados:', error);
        estadoSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar estados</option>';
        estadoSelect.disabled = true;
    }
}

// ==================== CARGAR PRODUCTOS ====================
async function cargarProductosEditReq() {
    const productoSelect = document.getElementById('edit_Req_ID_Producto');
    if (!productoSelect) return;
    
    try {
        const response = await fetch('../../../Controlador/GET/Formulario/getSelectProduct.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            productosDataEditReq = data.data;
            productoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Producto --</option>';
            data.data.forEach(producto => {
                productoSelect.innerHTML += `<option value="${producto.IdCProducto}" 
                                                data-empresa="${escapeHtmlEditReq(producto.Nombre_Empresa)}"
                                                data-categoria="${escapeHtmlEditReq(producto.Descrp)}"
                                                data-descripcion="${escapeHtmlEditReq(producto.Descripcion)}"
                                                data-especificacion="${escapeHtmlEditReq(producto.Especificacion)}"
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
async function cargarTallasEditReq(productoId) {
    const tallaSelect = document.getElementById('edit_Req_ID_Talla');
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
                    tallaSelect.innerHTML += `<option value="${talla.IdCTallas}" data-nombre="${escapeHtmlEditReq(talla.Talla)}">${escapeHtmlEditReq(talla.Talla)}</option>`;
                });
                tallaSelect.disabled = false;
            } else {
                tallaSelect.innerHTML = '<option value="" selected disabled>-- No hay tallas disponibles --</option>';
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
function actualizarInfoProductoEditReq(productoId) {
    const producto = productosDataEditReq.find(p => p.IdCProducto == productoId);
    const infoCard = document.getElementById('edit_Req_infoProductoCard');
    
    if (producto) {
        document.getElementById('edit_Req_infoEmpresa').textContent = producto.Nombre_Empresa || '--';
        document.getElementById('edit_Req_infoCategoria').textContent = producto.Descrp || '--';
        document.getElementById('edit_Req_infoDescripcion').textContent = producto.Descripcion || '--';
        document.getElementById('edit_Req_infoEspecificacion').textContent = producto.Especificacion || '--';
        
        const imagenElement = document.getElementById('edit_Req_productoImagen');
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
function fillInformacionGeneralEditReq(data) {
    document.getElementById('edit_Req_Supervisor').value = data.Supervisor || '';
    document.getElementById('edit_Req_CentroTrabajo').value = data.CentroTrabajo || '';
    document.getElementById('edit_Req_NroElementos').value = data.NroElementos || '';
    document.getElementById('edit_Req_Receptor').value = data.Receptor || '';
    document.getElementById('edit_Req_num_tel').value = data.TelReceptor || '';
    document.getElementById('edit_Req_RFC').value = data.RfcReceptor || '';
    document.getElementById('edit_Req_Justificacion').value = data.Justificacion || '';
    
    // Configurar opción de envío
    const opcionSelect = document.getElementById('edit_Req_Opcion');
    const direccionDiv = document.getElementById('edit_Req_DireccionDiv');
    
    const tieneDireccion = data.Mpio || data.Colonia || data.Calle || data.Nro || data.CP;
    const opcionValue = tieneDireccion ? 'SI' : 'NO';
    
    opcionSelect.value = opcionValue;
    direccionDiv.style.display = opcionValue === 'SI' ? 'block' : 'none';
    
    if (tieneDireccion) {
        document.getElementById('edit_Req_Mpio').value = data.Mpio || '';
        document.getElementById('edit_Req_Colonia').value = data.Colonia || '';
        document.getElementById('edit_Req_Calle').value = data.Calle || '';
        document.getElementById('edit_Req_Nro').value = data.Nro || '';
        document.getElementById('edit_Req_CP').value = data.CP || '';
    }
    
    // Cargar regiones y estados después de tener los datos
    if (data.IdCuenta) {
        cargarRegionesEditReq(data.IdCuenta, data.IdRegion);
        if (data.IdRegion) {
            cargarEstadosEditReq(data.IdRegion, data.IdEstado);
        }
    }
}

// ==================== LLENAR TABLA DE PRODUCTOS ====================
function fillTablaProductosEditReq(productos) {
    const tablaBody = document.getElementById('edit_Req_tablaProductosBody');
    if (!tablaBody) return;
    
    tablaBody.innerHTML = '';
    contadorProductosEditReq = 0;
    
    if (productos && productos.length > 0) {
        productos.forEach(producto => {
            contadorProductosEditReq++;
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td class="text-center">${contadorProductosEditReq}<\/td>
                <td>${escapeHtmlEditReq(producto.IdCProd)}<\/td>
                <td>${escapeHtmlEditReq(producto.Nombre_Empresa)}<\/td>
                <td>${escapeHtmlEditReq(producto.Descrp)}<\/td>
                <td>${escapeHtmlEditReq(producto.Descripcion)}<\/td>
                <td>${escapeHtmlEditReq(producto.Especificacion)}<\/td>
                <td data-id="${escapeHtmlEditReq(producto.IdTalla)}">${escapeHtmlEditReq(producto.Talla)}<\/td>
                <td class="text-center">${producto.Cantidad}<\/td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto-edit-Req">
                        <i class="fas fa-trash"></i>
                    </button>
                <\/td>
            `;
            
            tablaBody.appendChild(fila);
            
            fila.querySelector('.btn-eliminar-producto-edit-Req').addEventListener('click', function() {
                eliminarProductoEditReq(fila);
            });
        });
    }
    
    actualizarContadorProductosEditReq();
    actualizarDatosTablaEditReq();
}

// ==================== AGREGAR PRODUCTO ====================
function agregarProductoEditReq() {
    const productoSelect = document.getElementById('edit_Req_ID_Producto');
    const tallaSelect = document.getElementById('edit_Req_ID_Talla');
    const cantidadInput = document.getElementById('edit_Req_Cantidad');
    
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
    
    const producto = productosDataEditReq.find(p => p.IdCProducto == productoId);
    if (!producto) return;
    
    const tablaBody = document.getElementById('edit_Req_tablaProductosBody');
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
        contadorProductosEditReq++;
        const nuevaFila = document.createElement('tr');
        nuevaFila.innerHTML = `
            <td class="text-center">${contadorProductosEditReq}<\/td>
            <td>${escapeHtmlEditReq(productoId)}<\/td>
            <td>${escapeHtmlEditReq(producto.Nombre_Empresa)}<\/td>
            <td>${escapeHtmlEditReq(producto.Descrp)}<\/td>
            <td>${escapeHtmlEditReq(producto.Descripcion)}<\/td>
            <td>${escapeHtmlEditReq(producto.Especificacion)}<\/td>
            <td data-id="${escapeHtmlEditReq(tallaId)}">${escapeHtmlEditReq(tallaNombre)}<\/td>
            <td class="text-center">${cantidad}<\/td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto-edit-Req">
                    <i class="fas fa-trash"></i>
                </button>
            <\/td>
        `;
        
        tablaBody.appendChild(nuevaFila);
        
        nuevaFila.querySelector('.btn-eliminar-producto-edit-Req').addEventListener('click', function() {
            eliminarProductoEditReq(nuevaFila);
        });
        
        Swal.fire({ icon: 'success', title: 'Producto agregado', text: 'El producto ha sido agregado correctamente.', timer: 800, showConfirmButton: false });
    }
    
    productoSelect.value = '';
    tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
    tallaSelect.disabled = true;
    cantidadInput.value = '';
    document.getElementById('edit_Req_infoProductoCard').style.display = 'none';
    
    formularioModificarRequisicionModificado = true;
    actualizarContadorProductosEditReq();
    actualizarDatosTablaEditReq();
}

// ==================== ELIMINAR PRODUCTO ====================
function eliminarProductoEditReq(fila) {
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
            contadorProductosEditReq--;
            reordenarNumerosEditReq();
            formularioModificarRequisicionModificado = true;
            actualizarContadorProductosEditReq();
            actualizarDatosTablaEditReq();
            
            Swal.fire({ icon: 'success', title: 'Producto eliminado', timer: 800, showConfirmButton: false });
        }
    });
}

// ==================== REORDENAR NÚMEROS ====================
function reordenarNumerosEditReq() {
    const tablaBody = document.getElementById('edit_Req_tablaProductosBody');
    const filas = tablaBody.querySelectorAll('tr');
    
    filas.forEach((fila, index) => {
        const numeroCelda = fila.querySelector('td:first-child');
        if (numeroCelda) {
            numeroCelda.textContent = index + 1;
        }
    });
    contadorProductosEditReq = filas.length;
}

// ==================== ACTUALIZAR CONTADOR DE PRODUCTOS ====================
function actualizarContadorProductosEditReq() {
    const contadorSpan = document.getElementById('edit_Req_productosCount');
    const tablaBody = document.getElementById('edit_Req_tablaProductosBody');
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
function actualizarDatosTablaEditReq() {
    const datosTabla = document.getElementById('datosTablaUpdateRequisicion');
    const tablaBody = document.getElementById('edit_Req_tablaProductosBody');
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
function updateStepIndicatorsEditReq() {
    const circles = [
        document.getElementById('edit_Req_stepCircle1'),
        document.getElementById('edit_Req_stepCircle2'),
        document.getElementById('edit_Req_stepCircle3')
    ];
    
    const labels = [
        document.getElementById('edit_Req_stepLabel1'),
        document.getElementById('edit_Req_stepLabel2'),
        document.getElementById('edit_Req_stepLabel3')
    ];
    
    const lines = [
        document.getElementById('edit_Req_stepLine1-2'),
        document.getElementById('edit_Req_stepLine2-3')
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
    
    for (let i = 0; i < currentStepEditReq - 1; i++) {
        if (circles[i]) circles[i].classList.add('completed');
        if (labels[i]) labels[i].classList.add('completed');
        if (i < lines.length && lines[i]) {
            lines[i].classList.add('completed');
        }
    }
    
    if (currentStepEditReq <= circles.length) {
        if (circles[currentStepEditReq - 1]) circles[currentStepEditReq - 1].classList.add('active');
        if (labels[currentStepEditReq - 1]) labels[currentStepEditReq - 1].classList.add('active');
        
        if (currentStepEditReq - 2 >= 0 && lines[currentStepEditReq - 2]) {
            lines[currentStepEditReq - 2].classList.add('active');
        }
    }
}

function updateStepsEditReq() {
    const step1 = document.getElementById('edit_Req_step1');
    const step2 = document.getElementById('edit_Req_step2');
    const step3 = document.getElementById('edit_Req_step3');
    const prevBtn = document.getElementById('edit_Req_prevBtn');
    const nextBtn = document.getElementById('edit_Req_nextBtn');
    const submitBtn = document.getElementById('edit_Req_submitBtn');
    
    if (step1) step1.style.display = 'none';
    if (step2) step2.style.display = 'none';
    if (step3) step3.style.display = 'none';
    
    if (currentStepEditReq === 1 && step1) step1.style.display = 'block';
    if (currentStepEditReq === 2 && step2) step2.style.display = 'block';
    if (currentStepEditReq === 3 && step3) step3.style.display = 'block';
    
    if (prevBtn) prevBtn.style.display = currentStepEditReq === 1 ? 'none' : 'inline-block';
    if (nextBtn) nextBtn.style.display = currentStepEditReq === totalStepsEditReq ? 'none' : 'inline-block';
    if (submitBtn) submitBtn.style.display = currentStepEditReq === totalStepsEditReq ? 'inline-block' : 'none';
    
    updateStepIndicatorsEditReq();
}

function goToNextStepEditReq() {
    if (validateCurrentStepEditReq()) {
        currentStepEditReq++;
        updateStepsEditReq();
        
        const modalBody = document.querySelector('#modificarRequisicionModal .modal-body');
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

function goToPrevStepEditReq() {
    currentStepEditReq--;
    updateStepsEditReq();
    
    const modalBody = document.querySelector('#modificarRequisicionModal .modal-body');
    if (modalBody) {
        modalBody.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function validateCurrentStepEditReq() {
    if (currentStepEditReq === 1) {
        return validateStep1EditReq();
    }
    if (currentStepEditReq === 2) {
        return true;
    }
    if (currentStepEditReq === 3) {
        return validateStep3EditReq();
    }
    return true;
}

function validateStep1EditReq() {
    const supervisor = document.getElementById('edit_Req_Supervisor');
    const cuenta = document.getElementById('edit_Req_ID_Cuenta');
    const region = document.getElementById('edit_Req_Region');
    const nroElementos = document.getElementById('edit_Req_NroElementos');
    const estado = document.getElementById('edit_Req_Estado');
    const receptor = document.getElementById('edit_Req_Receptor');
    const telefono = document.getElementById('edit_Req_num_tel');
    const justificacion = document.getElementById('edit_Req_Justificacion');
    const opcion = document.getElementById('edit_Req_Opcion');
    
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

function validateStep3EditReq() {
    const tablaBody = document.getElementById('edit_Req_tablaProductosBody');
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

// ==================== ENVÍO DEL FORMULARIO ====================
function submitModificarRequisicionForm() {
    const form = document.getElementById('FormUpdateRequisicion');
    
    actualizarDatosTablaEditReq();
    
    if (!validateStep3EditReq()) {
        return;
    }
    
    const formData = new FormData(form);
    formularioModificarRequisicionEnviado = true;
    
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
                    title: '¡Requisicion actualizado!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if (modificarRequisicionModal) modificarRequisicionModal.hide();
                    location.reload();
                });
            } else {
                formularioModificarRequisicionEnviado = false;
                Swal.fire({ icon: 'error', title: 'Error', text: data.message, confirmButtonColor: '#001F3F' });
            }
        } catch (err) {
            formularioModificarRequisicionEnviado = false;
            Swal.fire({ icon: 'error', title: 'Error', text: 'Respuesta no válida del servidor.', confirmButtonColor: '#001F3F' });
        }
    })
    .catch(error => {
        formularioModificarRequisicionEnviado = false;
        Swal.fire({ icon: 'error', title: 'Error de conexión', text: 'Hubo un problema al procesar la solicitud.', confirmButtonColor: '#001F3F' });
    });
}

// ==================== ESCAPE HTML ====================
function escapeHtmlEditReq(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== CONFIGURAR EVENTOS ====================
function setupEventosEditReq() {
    // Evento de cambio de cuenta
    const cuentaSelect = document.getElementById('edit_Req_ID_Cuenta');
    if (cuentaSelect) {
        cuentaSelect.addEventListener('change', function() {
            formularioModificarRequisicionModificado = true;
            const cuentaId = this.value;
            if (cuentaId) {
                cargarRegionesEditReq(cuentaId);
            } else {
                const regionSelect = document.getElementById('edit_Req_Region');
                if (regionSelect) {
                    regionSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Región --</option>';
                    regionSelect.disabled = true;
                }
                const estadoSelect = document.getElementById('edit_Req_Estado');
                if (estadoSelect) {
                    estadoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Estado --</option>';
                    estadoSelect.disabled = true;
                }
            }
        });
    }
    
    // Evento de cambio de región
    const regionSelect = document.getElementById('edit_Req_Region');
    if (regionSelect) {
        regionSelect.addEventListener('change', function() {
            formularioModificarRequisicionModificado = true;
            const regionId = this.value;
            if (regionId) {
                cargarEstadosEditReq(regionId);
            } else {
                const estadoSelect = document.getElementById('edit_Req_Estado');
                if (estadoSelect) {
                    estadoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Estado --</option>';
                    estadoSelect.disabled = true;
                }
            }
        });
    }
    
    // Evento de cambio de producto
    const productoSelect = document.getElementById('edit_Req_ID_Producto');
    if (productoSelect) {
        productoSelect.addEventListener('change', function() {
            formularioModificarRequisicionModificado = true;
            const productoId = this.value;
            
            if (productosExcluidos.includes(parseInt(productoId))) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Producto no disponible',
                    text: 'Este producto no está disponible actualmente.',
                    confirmButtonColor: '#001F3F'
                });
                this.value = '';
                document.getElementById('edit_Req_infoProductoCard').style.display = 'none';
                const tallaSelect = document.getElementById('edit_Req_ID_Talla');
                if (tallaSelect) {
                    tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
                    tallaSelect.disabled = true;
                }
                return;
            }
            
            if (productoId) {
                actualizarInfoProductoEditReq(productoId);
                cargarTallasEditReq(productoId);
            } else {
                document.getElementById('edit_Req_infoProductoCard').style.display = 'none';
                const tallaSelect = document.getElementById('edit_Req_ID_Talla');
                if (tallaSelect) {
                    tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
                    tallaSelect.disabled = true;
                }
            }
        });
    }
    
    // Evento de cantidad
    const cantidadInput = document.getElementById('edit_Req_Cantidad');
    if (cantidadInput) {
        cantidadInput.addEventListener('input', function(e) {
            formularioModificarRequisicionModificado = true;
            let valor = this.value.replace(/[^0-9]/g, '');
            if (valor.length > 1 && valor.startsWith('0')) {
                valor = valor.replace(/^0+/, '');
                if (valor === '') valor = '0';
            }
            this.value = valor;
        });
    }
    
    // Evento de opción de envío
    const opcionSelect = document.getElementById('edit_Req_Opcion');
    const direccionDiv = document.getElementById('edit_Req_DireccionDiv');
    if (opcionSelect) {
        opcionSelect.addEventListener('change', function() {
            formularioModificarRequisicionModificado = true;
            direccionDiv.style.display = this.value === 'SI' ? 'block' : 'none';
        });
    }
}

// ==================== PREVENIR CIERRE ACCIDENTAL ====================
function setupPrevenirCierreEditReq() {
    const modalElement = document.getElementById('modificarRequisicionModal');
    const form = document.getElementById('FormUpdateRequisicion');
    
    if (!modalElement || !form) return;
    
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            if (input.id !== 'datosTablaUpdateRequisicion') {
                formularioModificarRequisicionModificado = true;
            }
        });
        input.addEventListener('input', () => {
            if (input.id !== 'datosTablaUpdateRequisicion') {
                formularioModificarRequisicionModificado = true;
            }
        });
    });
    
    modalElement.addEventListener('hide.bs.modal', function(e) {
        if (formularioModificarRequisicionEnviado) return;
        
        if (formularioModificarRequisicionModificado) {
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
                    formularioModificarRequisicionModificado = false;
                    formularioModificarRequisicionEnviado = false;
                    modalElement.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                }
            });
        }
    });
    
    modalElement.addEventListener('hidden.bs.modal', function() {
        formularioModificarRequisicionModificado = false;
        formularioModificarRequisicionEnviado = false;
        currentStepEditReq = 1;
        
        const loadingDiv = document.getElementById('loadingModificarRequisicionData');
        const formContainer = document.getElementById('modificarRequisicionFormContainer');
        
        if (loadingDiv) {
            loadingDiv.style.display = 'block';
            loadingDiv.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando datos del Requisicion...</p>
                </div>
            `;
        }
        if (formContainer) formContainer.style.display = 'none';
        
        const tablaBody = document.getElementById('edit_Req_tablaProductosBody');
        if (tablaBody) tablaBody.innerHTML = '';
        contadorProductosEditReq = 0;
        actualizarContadorProductosEditReq();
    });
}

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando modal de modificar Requisicion...');
    
    const btnAgregar = document.getElementById('edit_Req_btn_AgregarProducto');
    if (btnAgregar) {
        btnAgregar.addEventListener('click', agregarProductoEditReq);
    }
    
    const btnGuardar = document.getElementById('edit_Req_submitBtn');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            submitModificarRequisicionForm();
        });
    }
    
    const nextBtn = document.getElementById('edit_Req_nextBtn');
    const prevBtn = document.getElementById('edit_Req_prevBtn');
    
    if (nextBtn) nextBtn.addEventListener('click', goToNextStepEditReq);
    if (prevBtn) prevBtn.addEventListener('click', goToPrevStepEditReq);
    
    setupEventosEditReq();
    setupPrevenirCierreEditReq();
});

window.openModificarRequisicionModal = openModificarRequisicionModal;