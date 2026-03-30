// ==================== MODAL DE REGISTRO DE ENTRADA - JS COMPLETO ====================

let entradaModal;
let formularioEntradaModificado = false;
let formularioEntradaEnviado = false;
let contadorProductos = 0;
let productosData = []; // Almacenar datos de productos para búsqueda

// ==================== FUNCIÓN PARA ABRIR EL MODAL ====================
async function openEntradaModal() {
    if (!entradaModal) {
        entradaModal = new bootstrap.Modal(document.getElementById('registrarEntradaModal'));
    }
    
    // Mostrar loading
    const loadingDiv = document.getElementById('loadingEntradaData');
    const formContainer = document.getElementById('entradaFormContainer');
    
    if (loadingDiv) loadingDiv.style.display = 'block';
    if (formContainer) formContainer.style.display = 'none';
    
    // Resetear flags
    formularioEntradaModificado = false;
    formularioEntradaEnviado = false;
    
    entradaModal.show();
    
    try {
        // Cargar productos
        await cargarProductos();
        
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
                <button class="btn btn-navy mt-3" onclick="openEntradaModal()">
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
async function cargarProductos() {
    const productoSelect = document.getElementById('ID_Producto');
    if (!productoSelect) return;
    
    try {
        const response = await fetch('../../../Controlador/GET/Formulario/getSelectProduct.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            productosData = data.data;
            productoSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Producto --</option>';
            data.data.forEach(producto => {
                productoSelect.innerHTML += `<option value="${producto.IdCProducto}" 
                                                   data-empresa="${escapeHtmlEntrada(producto.Nombre_Empresa)}"
                                                   data-categoria="${escapeHtmlEntrada(producto.Descrp)}"
                                                   data-descripcion="${escapeHtmlEntrada(producto.Descripcion)}"
                                                   data-especificacion="${escapeHtmlEntrada(producto.Especificacion)}"
                                                   data-imagen="${producto.IMG || ''}">
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
async function cargarTallas(productoId) {
    const tallaSelect = document.getElementById('ID_Talla');
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
                tallaSelect.innerHTML += `<option value="${talla.IdCTallas}" data-nombre="${escapeHtmlEntrada(talla.Talla)}">${escapeHtmlEntrada(talla.Talla)}</option>`;
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

// ==================== ACTUALIZAR INFORMACIÓN DEL PRODUCTO SELECCIONADO ====================
function actualizarInfoProducto(productoId) {
    const producto = productosData.find(p => p.IdCProducto == productoId);
    const infoCard = document.getElementById('infoProductoCard');
    
    if (producto) {
        document.getElementById('infoEmpresa').textContent = producto.Nombre_Empresa || '--';
        document.getElementById('infoCategoria').textContent = producto.Descrp || '--';
        document.getElementById('infoDescripcion').textContent = producto.Descripcion || '--';
        document.getElementById('infoEspecificacion').textContent = producto.Especificacion || '--';
        
        const imagenElement = document.getElementById('productoImagen');
        if (producto.IMG && producto.IMG !== '') {
            imagenElement.src = producto.IMG;
        } else {
            imagenElement.src = 'https://via.placeholder.com/150?text=Sin+Imagen';
        }
        
        infoCard.style.display = 'block';
    } else {
        infoCard.style.display = 'none';
    }
}

// ==================== CONFIGURAR EVENTOS DE PRODUCTO ====================
function setupProductoEvents() {
    const productoSelect = document.getElementById('ID_Producto');
    const tallaSelect = document.getElementById('ID_Talla');
    const cantidadInput = document.getElementById('Cantidad');
    
    if (productoSelect) {
        productoSelect.addEventListener('change', function() {
            formularioEntradaModificado = true;
            const productoId = this.value;
            
            if (productoId) {
                actualizarInfoProducto(productoId);
                cargarTallas(productoId);
            } else {
                document.getElementById('infoProductoCard').style.display = 'none';
                if (tallaSelect) {
                    tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
                    tallaSelect.disabled = true;
                }
            }
        });
    }
    
    if (cantidadInput) {
        cantidadInput.addEventListener('input', function(e) {
            formularioEntradaModificado = true;
            let valor = this.value.replace(/[^0-9]/g, '');
            if (valor.length > 1 && valor.startsWith('0')) {
                valor = valor.replace(/^0+/, '');
                if (valor === '') valor = '0';
            }
            this.value = valor;
        });
    }
}

// ==================== AGREGAR PRODUCTO A LA TABLA ====================
function agregarProducto() {
    const productoSelect = document.getElementById('ID_Producto');
    const tallaSelect = document.getElementById('ID_Talla');
    const cantidadInput = document.getElementById('Cantidad');
    
    const productoId = productoSelect.value;
    const productoNombre = productoSelect.options[productoSelect.selectedIndex]?.text;
    const tallaId = tallaSelect.value;
    const tallaNombre = tallaSelect.options[tallaSelect.selectedIndex]?.getAttribute('data-nombre');
    const cantidad = parseInt(cantidadInput.value) || 0;
    
    // Validaciones
    if (!productoId) {
        Swal.fire({
            icon: 'warning',
            title: 'Producto no seleccionado',
            text: 'Por favor, selecciona un producto.',
            confirmButtonColor: '#001F3F'
        });
        return;
    }
    
    if (!tallaId) {
        Swal.fire({
            icon: 'warning',
            title: 'Talla no seleccionada',
            text: 'Por favor, selecciona una talla.',
            confirmButtonColor: '#001F3F'
        });
        return;
    }
    
    if (cantidad <= 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Cantidad inválida',
            text: 'Por favor, ingresa una cantidad válida mayor a 0.',
            confirmButtonColor: '#001F3F'
        });
        return;
    }
    
    // Obtener información completa del producto
    const producto = productosData.find(p => p.IdCProducto == productoId);
    if (!producto) return;
    
    // Verificar si ya existe el mismo producto y talla
    const tablaBody = document.getElementById('tablaProductosBody');
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
        // Actualizar cantidad existente
        const cantidadActual = parseInt(filaExistente.querySelector('td:nth-child(8)').textContent) || 0;
        const nuevaCantidad = cantidadActual + cantidad;
        filaExistente.querySelector('td:nth-child(8)').textContent = nuevaCantidad;
        
        Swal.fire({
            icon: 'success',
            title: 'Producto actualizado',
            text: `Se ha actualizado la cantidad a ${nuevaCantidad} unidades.`,
            timer: 1500,
            showConfirmButton: false
        });
    } else {
        // Crear nueva fila
        contadorProductos++;
        const nuevaFila = document.createElement('tr');
        nuevaFila.innerHTML = `
            <td class="text-center">${contadorProductos}</td>
            <td>${escapeHtmlEntrada(productoId)}</td>
            <td>${escapeHtmlEntrada(producto.Nombre_Empresa)}</td>
            <td>${escapeHtmlEntrada(producto.Descrp)}</td>
            <td>${escapeHtmlEntrada(producto.Descripcion)}</td>
            <td>${escapeHtmlEntrada(producto.Especificacion)}</td>
            <td data-id="${escapeHtmlEntrada(tallaId)}">${escapeHtmlEntrada(tallaNombre)}</td>
            <td class="text-center">${cantidad}</td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tablaBody.appendChild(nuevaFila);
        
        // Agregar evento de eliminación
        nuevaFila.querySelector('.btn-eliminar-producto').addEventListener('click', function() {
            eliminarProducto(nuevaFila);
        });
        
        Swal.fire({
            icon: 'success',
            title: 'Producto agregado',
            text: 'El producto ha sido agregado correctamente.',
            timer: 1500,
            showConfirmButton: false
        });
    }
    
    // Limpiar campos
    productoSelect.value = '';
    tallaSelect.innerHTML = '<option value="" selected disabled>-- Selecciona una talla --</option>';
    tallaSelect.disabled = true;
    cantidadInput.value = '';
    document.getElementById('infoProductoCard').style.display = 'none';
    
    formularioEntradaModificado = true;
    actualizarContadorProductos();
    actualizarDatosTablaEntrada();
}

// ==================== ELIMINAR PRODUCTO ====================
function eliminarProducto(fila) {
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
            contadorProductos--;
            reordenarNumeros();
            formularioEntradaModificado = true;
            actualizarContadorProductos();
            actualizarDatosTablaEntrada();
            
            Swal.fire({
                icon: 'success',
                title: 'Producto eliminado',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}

// ==================== REORDENAR NÚMEROS ====================
function reordenarNumeros() {
    const tablaBody = document.getElementById('tablaProductosBody');
    const filas = tablaBody.querySelectorAll('tr');
    
    filas.forEach((fila, index) => {
        const numeroCelda = fila.querySelector('td:first-child');
        if (numeroCelda) {
            numeroCelda.textContent = index + 1;
        }
    });
    contadorProductos = filas.length;
}

// ==================== ACTUALIZAR CONTADOR DE PRODUCTOS ====================
function actualizarContadorProductos() {
    const contadorSpan = document.getElementById('productosCount');
    const tablaBody = document.getElementById('tablaProductosBody');
    const cantidad = tablaBody.querySelectorAll('tr').length;
    
    if (contadorSpan) {
        if (cantidad === 0) {
            contadorSpan.innerHTML = '<i class="fas fa-info-circle me-1"></i> No hay productos agregados';
            contadorSpan.classList.add('text-muted');
        } else {
            contadorSpan.innerHTML = `<i class="fas fa-check-circle me-1 text-success"></i> ${cantidad} producto(s) agregado(s)`;
            contadorSpan.classList.remove('text-muted');
            contadorSpan.classList.add('text-success');
        }
    }
}

// ==================== ACTUALIZAR CAMPO OCULTO ====================
function actualizarDatosTablaEntrada() {
    const datosTabla = document.getElementById('datosTablaInsertEntrada');
    const tablaBody = document.getElementById('tablaProductosBody');
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

// ==================== VALIDACIÓN DEL FORMULARIO ====================
function validarFormularioEntrada() {
    const proveedor = document.getElementById('Proveedor');
    const receptor = document.getElementById('Receptor');
    const comentarios = document.getElementById('Comentarios');
    const tablaBody = document.getElementById('tablaProductosBody');
    const productos = tablaBody.querySelectorAll('tr');
    
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
    
    if (productos.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Sin productos',
            text: 'Debes agregar al menos un producto.',
            confirmButtonColor: '#001F3F'
        });
        isValid = false;
    }
    
    return isValid;
}

// ==================== ENVÍO DEL FORMULARIO ====================
function submitEntradaForm() {
    const form = document.getElementById('FormInsertEntradaNuevo');
    
    actualizarDatosTablaEntrada();
    
    if (!validarFormularioEntrada()) {
        return;
    }
    
    const formData = new FormData(form);
    formularioEntradaEnviado = true;
    
    Swal.fire({
        title: 'Registrando entrada...',
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
                    title: '¡Entrada registrada!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if (entradaModal) entradaModal.hide();
                    location.reload();
                });
            } else {
                formularioEntradaEnviado = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message,
                    confirmButtonColor: '#001F3F'
                });
            }
        } catch (err) {
            formularioEntradaEnviado = false;
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Respuesta no válida del servidor.',
                confirmButtonColor: '#001F3F'
            });
        }
    })
    .catch(error => {
        formularioEntradaEnviado = false;
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'Hubo un problema al procesar la solicitud.',
            confirmButtonColor: '#001F3F'
        });
    });
}

// ==================== ESCAPE HTML ====================
function escapeHtmlEntrada(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== CONFIGURAR PREVENCIÓN DE CIERRE ACCIDENTAL ====================
function setupPrevenirCierreEntrada() {
    const modalElement = document.getElementById('registrarEntradaModal');
    const form = document.getElementById('FormInsertEntradaNuevo');
    
    if (!modalElement || !form) return;
    
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            if (input.id !== 'datosTablaInsertEntrada') {
                formularioEntradaModificado = true;
            }
        });
        input.addEventListener('input', () => {
            if (input.id !== 'datosTablaInsertEntrada') {
                formularioEntradaModificado = true;
            }
        });
    });
    
    modalElement.addEventListener('hide.bs.modal', function(e) {
        if (formularioEntradaEnviado) return;
        
        if (formularioEntradaModificado) {
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
                    formularioEntradaModificado = false;
                    formularioEntradaEnviado = false;
                    modalElement.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                }
            });
        }
    });
    
    modalElement.addEventListener('hidden.bs.modal', function() {
        formularioEntradaModificado = false;
        formularioEntradaEnviado = false;
        
        const loadingDiv = document.getElementById('loadingEntradaData');
        const formContainer = document.getElementById('entradaFormContainer');
        
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
        
        const tablaBody = document.getElementById('tablaProductosBody');
        if (tablaBody) tablaBody.innerHTML = '';
        contadorProductos = 0;
        actualizarContadorProductos();
    });
}

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando modal de entrada...');
    
    const btnAgregar = document.getElementById('btn_AgregarProductoEntrada');
    if (btnAgregar) {
        btnAgregar.addEventListener('click', agregarProducto);
    }
    
    const btnGuardar = document.getElementById('btnGuardarEntrada');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            submitEntradaForm();
        });
    }
    
    setupProductoEvents();
    setupPrevenirCierreEntrada();
});

window.openEntradaModal = openEntradaModal;