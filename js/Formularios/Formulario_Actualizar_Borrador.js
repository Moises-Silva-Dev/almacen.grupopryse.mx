// ==================== MODAL DE MODIFICAR BORRADOR - JS COMPLETO ====================

import { diccionarioTallas } from './DiccionarioTallasRestriccion.js';
import { productosExcluidos } from './DiccionarioProductosBaja.js';

let modificarBorradorModal;
let formularioModificarBorradorModificado = false;
let formularioModificarBorradorEnviado = false;
let contadorProductosEditBorr = 0;
let productosDataEditBorr = [];
let currentStepEditBorr = 1;
const totalStepsEditBorr = 3;

// ==================== FUNCIÓN PARA ABRIR EL MODAL ====================
async function openModificarBorradorModal(borradorId) {
    if (!modificarBorradorModal) {
        modificarBorradorModal = new bootstrap.Modal(document.getElementById('modificarBorradorModal'));
    }
    
    const loadingDiv = document.getElementById('loadingModificarBorradorData');
    const formContainer = document.getElementById('modificarBorradorFormContainer');
    
    if (loadingDiv) loadingDiv.style.display = 'block';
    if (formContainer) formContainer.style.display = 'none';
    
    formularioModificarBorradorModificado = false;
    formularioModificarBorradorEnviado = false;
    currentStepEditBorr = 1;
    
    modificarBorradorModal.show();
    
    try {
        const borradorData = await fetchBorradorData(borradorId);
        
        if (borradorData) {
            await Promise.all([
                console.log('borradorData:', borradorData),
                cargarCuentasEditBorr(borradorData.BIdCuenta),
                cargarProductosEditBorr()
            ]);
            
            fillInformacionGeneralEditBorr(borradorData);
            fillTablaProductosEditBorr(borradorData.productos);
            
            document.getElementById('edit_borrador_id').value = borradorData.BIDRequisicionE || '';
            
            updateStepsEditBorr();
            
            if (loadingDiv) loadingDiv.style.display = 'none';
            if (formContainer) formContainer.style.display = 'block';
        } else {
            throw new Error('No se pudieron cargar los datos del borrador');
        }
        
    } catch (error) {
        console.error('Error al cargar borrador:', error);
        if (loadingDiv) {
            loadingDiv.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar los datos: ${error.message}
                </div>
                <button class="btn btn-navy mt-3" onclick="openModificarBorradorModal(${borradorId})">
                    <i class="fas fa-redo me-1"></i> Reintentar
                </button>
                <button class="btn btn-secondary mt-3 ms-2" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cerrar
                </button>
            `;
        }
    }
}

// ==================== FUNCIÓN PARA OBTENER DATOS DEL BORRADOR ====================
async function fetchBorradorData(borradorId) {
    try {
        const response = await fetch(`../../../Controlador/GET/Formulario/getObtenerInfoBorrador.php?id=${borradorId}`);
        
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
        console.error('Error en fetchBorradorData:', error);
        throw error;
    }
}

// ==================== CARGAR CUENTAS ====================
async function cargarCuentasEditBorr(selectedId) {
    const cuentaSelect = document.getElementById('edit_borr_ID_Cuenta');
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
                cuentaSelect.innerHTML += `<option value="${cuenta.ID}" ${selected}>${escapeHtmlEditBorr(cuenta.NombreCuenta)}</option>`;
            });
            cuentaSelect.disabled = false;
            
            // Cargar regiones después de seleccionar la cuenta
            if (selectedId) {
                await cargarRegionesEditBorr(selectedId);
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
async function cargarRegionesEditBorr(cuentaId, selectedId = null) {
    const regionSelect = document.getElementById('edit_borr_Region');
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
                regionSelect.innerHTML += `<option value="${region.ID_Region}" ${selected}>${escapeHtmlEditBorr(region.Nombre_Region)}</option>`;
            });
            regionSelect.disabled = false;
        } else if (Array.isArray(data) && data.length > 0) {
            regionSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Región --</option>';
            data.forEach(region => {
                const selected = selectedId == region.ID_Region ? 'selected' : '';
                regionSelect.innerHTML += `<option value="${region.ID_Region}" ${selected}>${escapeHtmlEditBorr(region.Nombre_Region)}</option>`;
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
async function cargarEstadosEditBorr(regionId, selectedId = null) {
    const estadoSelect = document.getElementById('edit_borr_Estado');
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
                estadoSelect.innerHTML += `<option value="${estado.Id_Estado}" ${selected}>${escapeHtmlEditBorr(estado.Nombre_estado)}</option>`;
            });
            estadoSelect.disabled = false;
        } else if (Array.isArray(data) && data.length > 0) {
            estadoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Estado --</option>';
            data.forEach(estado => {
                const selected = selectedId == estado.Id_Estado ? 'selected' : '';
                estadoSelect.innerHTML += `<option value="${estado.Id_Estado}" ${selected}>${escapeHtmlEditBorr(estado.Nombre_estado)}</option>`;
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
async function cargarProductosEditBorr() {
    const productoSelect = document.getElementById('edit_borr_ID_Producto');
    if (!productoSelect) return;
    
    try {
        const response = await fetch('../../../Controlador/GET/Formulario/getSelectProduct.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            productosDataEditBorr = data.data;
            productoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Producto --</option>';
            data.data.forEach(producto => {
                productoSelect.innerHTML += `<option value="${producto.IdCProducto}" 
                                                data-empresa="${escapeHtmlEditBorr(producto.Nombre_Empresa)}"
                                                data-categoria="${escapeHtmlEditBorr(producto.Descrp)}"
                                                data-descripcion="${escapeHtmlEditBorr(producto.Descripcion)}"
                                                data-especificacion="${escapeHtmlEditBorr(producto.Especificacion)}"
                                                data-imagen="${producto.IMG || '../../../img/Armar_Requicision.png'}">
                                                ${producto.IdCProducto} - ${producto.Descripcion.substring(0, 50)}...
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
async function cargarTallasEditBorr(productoId) {
    const tallaSelect = document.getElementById('edit_borr_ID_Talla');
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
                    tallaSelect.innerHTML += `<option value="${talla.IdCTallas}" data-nombre="${escapeHtmlEditBorr(talla.Talla)}">${escapeHtmlEditBorr(talla.Talla)}</option>`;
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
function actualizarInfoProductoEditBorr(productoId) {
    const producto = productosDataEditBorr.find(p => p.IdCProducto == productoId);
    const infoCard = document.getElementById('edit_borr_infoProductoCard');
    
    if (producto) {
        document.getElementById('edit_borr_infoEmpresa').textContent = producto.Nombre_Empresa || '--';
        document.getElementById('edit_borr_infoCategoria').textContent = producto.Descrp || '--';
        document.getElementById('edit_borr_infoDescripcion').textContent = producto.Descripcion || '--';
        document.getElementById('edit_borr_infoEspecificacion').textContent = producto.Especificacion || '--';
        
        const imagenElement = document.getElementById('edit_borr_productoImagen');
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
function fillInformacionGeneralEditBorr(data) {
    document.getElementById('edit_borr_Supervisor').value = data.BSupervisor || '';
    document.getElementById('edit_borr_CentroTrabajo').value = data.BCentroTrabajo || '';
    document.getElementById('edit_borr_NroElementos').value = data.BNroElementos || '';
    document.getElementById('edit_borr_Receptor').value = data.BReceptor || '';
    document.getElementById('edit_borr_num_tel').value = data.BTelReceptor || '';
    document.getElementById('edit_borr_RFC').value = data.BRfcReceptor || '';
    document.getElementById('edit_borr_Justificacion').value = data.BJustificacion || '';
    
    // Configurar opción de envío
    const opcionSelect = document.getElementById('edit_borr_Opcion');
    const direccionDiv = document.getElementById('edit_borr_DireccionDiv');
    
    const tieneDireccion = data.BMpio || data.BColonia || data.BCalle || data.BNro || data.BCP;
    const opcionValue = tieneDireccion ? 'SI' : 'NO';
    
    opcionSelect.value = opcionValue;
    direccionDiv.style.display = opcionValue === 'SI' ? 'block' : 'none';
    
    if (tieneDireccion) {
        document.getElementById('edit_borr_Mpio').value = data.BMpio || '';
        document.getElementById('edit_borr_Colonia').value = data.BColonia || '';
        document.getElementById('edit_borr_Calle').value = data.BCalle || '';
        document.getElementById('edit_borr_Nro').value = data.BNro || '';
        document.getElementById('edit_borr_CP').value = data.BCP || '';
    }
    
    // Cargar regiones y estados después de tener los datos
    if (data.BIdCuenta) {
        cargarRegionesEditBorr(data.BIdCuenta, data.BIdRegion);
        if (data.BIdRegion) {
            cargarEstadosEditBorr(data.BIdRegion, data.BIdEstado);
        }
    }
}

// ==================== LLENAR TABLA DE PRODUCTOS ====================
function fillTablaProductosEditBorr(productos) {
    const tablaBody = document.getElementById('edit_borr_tablaProductosBody');
    if (!tablaBody) return;
    
    tablaBody.innerHTML = '';
    contadorProductosEditBorr = 0;
    
    if (productos && productos.length > 0) {
        productos.forEach(producto => {
            contadorProductosEditBorr++;
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td class="text-center">${contadorProductosEditBorr}<\/td>
                <td>${escapeHtmlEditBorr(producto.BIdCProd)}<\/td>
                <td>${escapeHtmlEditBorr(producto.Nombre_Empresa)}<\/td>
                <td>${escapeHtmlEditBorr(producto.Descrp)}<\/td>
                <td>${escapeHtmlEditBorr(producto.Descripcion)}<\/td>
                <td>${escapeHtmlEditBorr(producto.Especificacion)}<\/td>
                <td data-id="${escapeHtmlEditBorr(producto.BIdTalla)}">${escapeHtmlEditBorr(producto.Talla)}<\/td>
                <td class="text-center">${producto.BCantidad}<\/td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto-edit-borr">
                        <i class="fas fa-trash"></i>
                    </button>
                <\/td>
            `;
            
            tablaBody.appendChild(fila);
            
            fila.querySelector('.btn-eliminar-producto-edit-borr').addEventListener('click', function() {
                eliminarProductoEditBorr(fila);
            });
        });
    }
    
    actualizarContadorProductosEditBorr();
    actualizarDatosTablaEditBorr();
}

// ==================== AGREGAR PRODUCTO ====================
function agregarProductoEditBorr() {
    const productoSelect = document.getElementById('edit_borr_ID_Producto');
    const tallaSelect = document.getElementById('edit_borr_ID_Talla');
    const cantidadInput = document.getElementById('edit_borr_Cantidad');
    
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
    
    const producto = productosDataEditBorr.find(p => p.IdCProducto == productoId);
    if (!producto) return;
    
    const tablaBody = document.getElementById('edit_borr_tablaProductosBody');
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
        contadorProductosEditBorr++;
        const nuevaFila = document.createElement('tr');
        nuevaFila.innerHTML = `
            <td class="text-center">${contadorProductosEditBorr}<\/td>
            <td>${escapeHtmlEditBorr(productoId)}<\/td>
            <td>${escapeHtmlEditBorr(producto.Nombre_Empresa)}<\/td>
            <td>${escapeHtmlEditBorr(producto.Descrp)}<\/td>
            <td>${escapeHtmlEditBorr(producto.Descripcion)}<\/td>
            <td>${escapeHtmlEditBorr(producto.Especificacion)}<\/td>
            <td data-id="${escapeHtmlEditBorr(tallaId)}">${escapeHtmlEditBorr(tallaNombre)}<\/td>
            <td class="text-center">${cantidad}<\/td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto-edit-borr">
                    <i class="fas fa-trash"></i>
                </button>
            <\/td>
        `;
        
        tablaBody.appendChild(nuevaFila);
        
        nuevaFila.querySelector('.btn-eliminar-producto-edit-borr').addEventListener('click', function() {
            eliminarProductoEditBorr(nuevaFila);
        });
        
        Swal.fire({ icon: 'success', title: 'Producto agregado', text: 'El producto ha sido agregado correctamente.', timer: 800, showConfirmButton: false });
    }
    
    productoSelect.value = '';
    tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
    tallaSelect.disabled = true;
    cantidadInput.value = '';
    document.getElementById('edit_borr_infoProductoCard').style.display = 'none';
    
    formularioModificarBorradorModificado = true;
    actualizarContadorProductosEditBorr();
    actualizarDatosTablaEditBorr();
}

// ==================== ELIMINAR PRODUCTO ====================
function eliminarProductoEditBorr(fila) {
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
            contadorProductosEditBorr--;
            reordenarNumerosEditBorr();
            formularioModificarBorradorModificado = true;
            actualizarContadorProductosEditBorr();
            actualizarDatosTablaEditBorr();
            
            Swal.fire({ icon: 'success', title: 'Producto eliminado', timer: 800, showConfirmButton: false });
        }
    });
}

// ==================== REORDENAR NÚMEROS ====================
function reordenarNumerosEditBorr() {
    const tablaBody = document.getElementById('edit_borr_tablaProductosBody');
    const filas = tablaBody.querySelectorAll('tr');
    
    filas.forEach((fila, index) => {
        const numeroCelda = fila.querySelector('td:first-child');
        if (numeroCelda) {
            numeroCelda.textContent = index + 1;
        }
    });
    contadorProductosEditBorr = filas.length;
}

// ==================== ACTUALIZAR CONTADOR DE PRODUCTOS ====================
function actualizarContadorProductosEditBorr() {
    const contadorSpan = document.getElementById('edit_borr_productosCount');
    const tablaBody = document.getElementById('edit_borr_tablaProductosBody');
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
function actualizarDatosTablaEditBorr() {
    const datosTabla = document.getElementById('datosTablaUpdateBorrador');
    const tablaBody = document.getElementById('edit_borr_tablaProductosBody');
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
function updateStepIndicatorsEditBorr() {
    const circles = [
        document.getElementById('edit_borr_stepCircle1'),
        document.getElementById('edit_borr_stepCircle2'),
        document.getElementById('edit_borr_stepCircle3')
    ];
    
    const labels = [
        document.getElementById('edit_borr_stepLabel1'),
        document.getElementById('edit_borr_stepLabel2'),
        document.getElementById('edit_borr_stepLabel3')
    ];
    
    const lines = [
        document.getElementById('edit_borr_stepLine1-2'),
        document.getElementById('edit_borr_stepLine2-3')
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
    
    for (let i = 0; i < currentStepEditBorr - 1; i++) {
        if (circles[i]) circles[i].classList.add('completed');
        if (labels[i]) labels[i].classList.add('completed');
        if (i < lines.length && lines[i]) {
            lines[i].classList.add('completed');
        }
    }
    
    if (currentStepEditBorr <= circles.length) {
        if (circles[currentStepEditBorr - 1]) circles[currentStepEditBorr - 1].classList.add('active');
        if (labels[currentStepEditBorr - 1]) labels[currentStepEditBorr - 1].classList.add('active');
        
        if (currentStepEditBorr - 2 >= 0 && lines[currentStepEditBorr - 2]) {
            lines[currentStepEditBorr - 2].classList.add('active');
        }
    }
}

function updateStepsEditBorr() {
    const step1 = document.getElementById('edit_borr_step1');
    const step2 = document.getElementById('edit_borr_step2');
    const step3 = document.getElementById('edit_borr_step3');
    const prevBtn = document.getElementById('edit_borr_prevBtn');
    const nextBtn = document.getElementById('edit_borr_nextBtn');
    const submitBtn = document.getElementById('edit_borr_submitBtn');
    
    if (step1) step1.style.display = 'none';
    if (step2) step2.style.display = 'none';
    if (step3) step3.style.display = 'none';
    
    if (currentStepEditBorr === 1 && step1) step1.style.display = 'block';
    if (currentStepEditBorr === 2 && step2) step2.style.display = 'block';
    if (currentStepEditBorr === 3 && step3) step3.style.display = 'block';
    
    if (prevBtn) prevBtn.style.display = currentStepEditBorr === 1 ? 'none' : 'inline-block';
    if (nextBtn) nextBtn.style.display = currentStepEditBorr === totalStepsEditBorr ? 'none' : 'inline-block';
    if (submitBtn) submitBtn.style.display = currentStepEditBorr === totalStepsEditBorr ? 'inline-block' : 'none';
    
    updateStepIndicatorsEditBorr();
}

function goToNextStepEditBorr() {
    if (validateCurrentStepEditBorr()) {
        currentStepEditBorr++;
        updateStepsEditBorr();
        
        const modalBody = document.querySelector('#modificarBorradorModal .modal-body');
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

function goToPrevStepEditBorr() {
    currentStepEditBorr--;
    updateStepsEditBorr();
    
    const modalBody = document.querySelector('#modificarBorradorModal .modal-body');
    if (modalBody) {
        modalBody.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function validateCurrentStepEditBorr() {
    if (currentStepEditBorr === 1) {
        return validateStep1EditBorr();
    }
    if (currentStepEditBorr === 2) {
        return true;
    }
    if (currentStepEditBorr === 3) {
        return validateStep3EditBorr();
    }
    return true;
}

function validateStep1EditBorr() {
    const supervisor = document.getElementById('edit_borr_Supervisor');
    const cuenta = document.getElementById('edit_borr_ID_Cuenta');
    const region = document.getElementById('edit_borr_Region');
    const nroElementos = document.getElementById('edit_borr_NroElementos');
    const estado = document.getElementById('edit_borr_Estado');
    const receptor = document.getElementById('edit_borr_Receptor');
    const telefono = document.getElementById('edit_borr_num_tel');
    const justificacion = document.getElementById('edit_borr_Justificacion');
    const opcion = document.getElementById('edit_borr_Opcion');
    
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

function validateStep3EditBorr() {
    const tablaBody = document.getElementById('edit_borr_tablaProductosBody');
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
function submitModificarBorradorForm() {
    const form = document.getElementById('FormUpdateBorradorRequisicion');
    
    actualizarDatosTablaEditBorr();
    
    if (!validateStep3EditBorr()) {
        return;
    }
    
    const formData = new FormData(form);
    formularioModificarBorradorEnviado = true;
    
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
                    title: '¡Borrador actualizado!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if (modificarBorradorModal) modificarBorradorModal.hide();
                    location.reload();
                });
            } else {
                formularioModificarBorradorEnviado = false;
                Swal.fire({ icon: 'error', title: 'Error', text: data.message, confirmButtonColor: '#001F3F' });
            }
        } catch (err) {
            formularioModificarBorradorEnviado = false;
            Swal.fire({ icon: 'error', title: 'Error', text: 'Respuesta no válida del servidor.', confirmButtonColor: '#001F3F' });
        }
    })
    .catch(error => {
        formularioModificarBorradorEnviado = false;
        Swal.fire({ icon: 'error', title: 'Error de conexión', text: 'Hubo un problema al procesar la solicitud.', confirmButtonColor: '#001F3F' });
    });
}

// ==================== ESCAPE HTML ====================
function escapeHtmlEditBorr(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== CONFIGURAR EVENTOS ====================
function setupEventosEditBorr() {
    // Evento de cambio de cuenta
    const cuentaSelect = document.getElementById('edit_borr_ID_Cuenta');
    if (cuentaSelect) {
        cuentaSelect.addEventListener('change', function() {
            formularioModificarBorradorModificado = true;
            const cuentaId = this.value;
            if (cuentaId) {
                cargarRegionesEditBorr(cuentaId);
            } else {
                const regionSelect = document.getElementById('edit_borr_Region');
                if (regionSelect) {
                    regionSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Región --</option>';
                    regionSelect.disabled = true;
                }
                const estadoSelect = document.getElementById('edit_borr_Estado');
                if (estadoSelect) {
                    estadoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Estado --</option>';
                    estadoSelect.disabled = true;
                }
            }
        });
    }
    
    // Evento de cambio de región
    const regionSelect = document.getElementById('edit_borr_Region');
    if (regionSelect) {
        regionSelect.addEventListener('change', function() {
            formularioModificarBorradorModificado = true;
            const regionId = this.value;
            if (regionId) {
                cargarEstadosEditBorr(regionId);
            } else {
                const estadoSelect = document.getElementById('edit_borr_Estado');
                if (estadoSelect) {
                    estadoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Estado --</option>';
                    estadoSelect.disabled = true;
                }
            }
        });
    }
    
    // Evento de cambio de producto
    const productoSelect = document.getElementById('edit_borr_ID_Producto');
    if (productoSelect) {
        productoSelect.addEventListener('change', function() {
            formularioModificarBorradorModificado = true;
            const productoId = this.value;
            
            if (productosExcluidos.includes(parseInt(productoId))) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Producto no disponible',
                    text: 'Este producto no está disponible actualmente.',
                    confirmButtonColor: '#001F3F'
                });
                this.value = '';
                document.getElementById('edit_borr_infoProductoCard').style.display = 'none';
                const tallaSelect = document.getElementById('edit_borr_ID_Talla');
                if (tallaSelect) {
                    tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
                    tallaSelect.disabled = true;
                }
                return;
            }
            
            if (productoId) {
                actualizarInfoProductoEditBorr(productoId);
                cargarTallasEditBorr(productoId);
            } else {
                document.getElementById('edit_borr_infoProductoCard').style.display = 'none';
                const tallaSelect = document.getElementById('edit_borr_ID_Talla');
                if (tallaSelect) {
                    tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
                    tallaSelect.disabled = true;
                }
            }
        });
    }
    
    // Evento de cantidad
    const cantidadInput = document.getElementById('edit_borr_Cantidad');
    if (cantidadInput) {
        cantidadInput.addEventListener('input', function(e) {
            formularioModificarBorradorModificado = true;
            let valor = this.value.replace(/[^0-9]/g, '');
            if (valor.length > 1 && valor.startsWith('0')) {
                valor = valor.replace(/^0+/, '');
                if (valor === '') valor = '0';
            }
            this.value = valor;
        });
    }
    
    // Evento de opción de envío
    const opcionSelect = document.getElementById('edit_borr_Opcion');
    const direccionDiv = document.getElementById('edit_borr_DireccionDiv');
    if (opcionSelect) {
        opcionSelect.addEventListener('change', function() {
            formularioModificarBorradorModificado = true;
            direccionDiv.style.display = this.value === 'SI' ? 'block' : 'none';
        });
    }
}

// ==================== PREVENIR CIERRE ACCIDENTAL ====================
function setupPrevenirCierreEditBorr() {
    const modalElement = document.getElementById('modificarBorradorModal');
    const form = document.getElementById('FormUpdateBorradorRequisicion');
    
    if (!modalElement || !form) return;
    
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            if (input.id !== 'datosTablaUpdateBorrador') {
                formularioModificarBorradorModificado = true;
            }
        });
        input.addEventListener('input', () => {
            if (input.id !== 'datosTablaUpdateBorrador') {
                formularioModificarBorradorModificado = true;
            }
        });
    });
    
    modalElement.addEventListener('hide.bs.modal', function(e) {
        if (formularioModificarBorradorEnviado) return;
        
        if (formularioModificarBorradorModificado) {
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
                    formularioModificarBorradorModificado = false;
                    formularioModificarBorradorEnviado = false;
                    modalElement.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                }
            });
        }
    });
    
    modalElement.addEventListener('hidden.bs.modal', function() {
        formularioModificarBorradorModificado = false;
        formularioModificarBorradorEnviado = false;
        currentStepEditBorr = 1;
        
        const loadingDiv = document.getElementById('loadingModificarBorradorData');
        const formContainer = document.getElementById('modificarBorradorFormContainer');
        
        if (loadingDiv) {
            loadingDiv.style.display = 'block';
            loadingDiv.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-turquoise" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando datos del borrador...</p>
                </div>
            `;
        }
        if (formContainer) formContainer.style.display = 'none';
        
        const tablaBody = document.getElementById('edit_borr_tablaProductosBody');
        if (tablaBody) tablaBody.innerHTML = '';
        contadorProductosEditBorr = 0;
        actualizarContadorProductosEditBorr();
    });
}

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando modal de modificar borrador...');
    
    const btnAgregar = document.getElementById('edit_borr_btn_AgregarProducto');
    if (btnAgregar) {
        btnAgregar.addEventListener('click', agregarProductoEditBorr);
    }
    
    const btnGuardar = document.getElementById('edit_borr_submitBtn');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            submitModificarBorradorForm();
        });
    }
    
    const nextBtn = document.getElementById('edit_borr_nextBtn');
    const prevBtn = document.getElementById('edit_borr_prevBtn');
    
    if (nextBtn) nextBtn.addEventListener('click', goToNextStepEditBorr);
    if (prevBtn) prevBtn.addEventListener('click', goToPrevStepEditBorr);
    
    setupEventosEditBorr();
    setupPrevenirCierreEditBorr();
});

window.openModificarBorradorModal = openModificarBorradorModal;