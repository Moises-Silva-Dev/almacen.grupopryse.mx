// ==================== MODAL DE MODIFICAR PRODUCTO - JS COMPLETO ====================

let modificarProductoModal;

// ==================== FUNCIÓN PARA ABRIR EL MODAL ====================
async function openModificarProductoModal(productoId) {
    if (!modificarProductoModal) {
        modificarProductoModal = new bootstrap.Modal(document.getElementById('modificarProductoModal'));
    }
    
    // Mostrar loading
    const loadingDiv = document.getElementById('loadingProductoData');
    const formContainer = document.getElementById('editProductoFormContainer');
    
    if (loadingDiv) loadingDiv.style.display = 'block';
    if (formContainer) formContainer.style.display = 'none';
    
    modificarProductoModal.show();
    
    try {
        // Cargar datos del producto
        const productoData = await fetchProductoData(productoId);
        
        if (productoData) {
            // Cargar los selects
            await Promise.all([
                cargarEmpresasEdit(productoData.IdCEmp),
                cargarCategoriasEdit(productoData.IdCCat),
                cargarTiposTallaEdit(productoData.IdCTipTal)
            ]);
            
            // Llenar el formulario
            fillEditProductoForm(productoData);
            
            // Ocultar loading y mostrar formulario
            if (loadingDiv) loadingDiv.style.display = 'none';
            if (formContainer) formContainer.style.display = 'block';
        } else {
            throw new Error('No se pudieron cargar los datos del producto');
        }
        
    } catch (error) {
        console.error('Error al cargar producto:', error);
        if (loadingDiv) {
            loadingDiv.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar los datos: ${error.message}
                </div>
                <button class="btn btn-navy mt-3" onclick="openModificarProductoModal(${productoId})">
                    <i class="fas fa-redo me-1"></i> Reintentar
                </button>
                <button class="btn btn-secondary mt-3 ms-2" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cerrar
                </button>
            `;
        }
    }
}

// ==================== FUNCIÓN PARA OBTENER DATOS DEL PRODUCTO ====================
async function fetchProductoData(productoId) {
    try {
        const response = await fetch(`../../../Controlador/GET/Formulario/getObtenerInfoProducto.php?id=${productoId}`);
        
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
        console.error('Error en fetchProductoData:', error);
        throw error;
    }
}

// ==================== CARGAR EMPRESAS VÍA FETCH ====================
async function cargarEmpresasEdit(selectedId = null) {
    const empresaSelect = document.getElementById('edit_ID_Empresas');
    if (!empresaSelect) return;
    
    try {
        const response = await fetch('../../../Controlador/GET/Formulario/getSelectEmpresa.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            empresaSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Empresa --</option>';
            data.data.forEach(empresa => {
                const selected = selectedId == empresa.IdCEmpresa ? 'selected' : '';
                empresaSelect.innerHTML += `<option value="${empresa.IdCEmpresa}" ${selected}>${escapeHtmlProductoEdit(empresa.Nombre_Empresa)}</option>`;
            });
        } else {
            empresaSelect.innerHTML = '<option value="" selected disabled>-- No hay empresas disponibles --</option>';
        }
        
    } catch (error) {
        console.error('Error al cargar empresas:', error);
        empresaSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar empresas</option>';
    }
}

// ==================== CARGAR CATEGORÍAS VÍA FETCH ====================
async function cargarCategoriasEdit(selectedId = null) {
    const categoriaSelect = document.getElementById('edit_Id_cate');
    if (!categoriaSelect) return;
    
    try {
        const response = await fetch('../../../Controlador/GET/Formulario/getSelectCategoria.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            categoriaSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Categoría --</option>';
            data.data.forEach(categoria => {
                const selected = selectedId == categoria.IdCCate ? 'selected' : '';
                categoriaSelect.innerHTML += `<option value="${categoria.IdCCate}" ${selected}>${escapeHtmlProductoEdit(categoria.Descrp)}</option>`;
            });
        } else {
            categoriaSelect.innerHTML = '<option value="" selected disabled>-- No hay categorías disponibles --</option>';
        }
        
    } catch (error) {
        console.error('Error al cargar categorías:', error);
        categoriaSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar categorías</option>';
    }
}

// ==================== CARGAR TIPOS DE TALLA VÍA FETCH ====================
async function cargarTiposTallaEdit(selectedId = null) {
    const tipoTallaSelect = document.getElementById('edit_Id_TipTall');
    if (!tipoTallaSelect) return;
    
    try {
        const response = await fetch('../../../Controlador/GET/Formulario/getSelectTiposTalla.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            tipoTallaSelect.innerHTML = '<option value="" selected disabled>-- Seleccionar Tipo de Talla --</option>';
            data.data.forEach(tipo => {
                const selected = selectedId == tipo.IdCTipTall ? 'selected' : '';
                tipoTallaSelect.innerHTML += `<option value="${tipo.IdCTipTall}" ${selected}>${escapeHtmlProductoEdit(tipo.Descrip)}</option>`;
            });
        } else {
            tipoTallaSelect.innerHTML = '<option value="" selected disabled>-- No hay tipos de talla disponibles --</option>';
        }
        
    } catch (error) {
        console.error('Error al cargar tipos de talla:', error);
        tipoTallaSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar tipos de talla</option>';
    }
}

// ==================== FUNCIÓN PARA LLENAR EL FORMULARIO ====================
function fillEditProductoForm(productoData) {
    document.getElementById('edit_producto_id').value = productoData.IdCProducto || '';
    document.getElementById('edit_Descripcion').value = productoData.Descripcion || '';
    document.getElementById('edit_Especificacion').value = productoData.Especificacion || '';
    
    // Mostrar imagen actual
    const imagenActual = document.getElementById('edit_imagen_actual');
    const nombreImagen = document.getElementById('edit_nombre_imagen');
    
    if (productoData.IMG) {
        const nombreArchivo = productoData.IMG.split('/').pop();
        imagenActual.src = productoData.IMG;
        nombreImagen.textContent = nombreArchivo;
    } else {
        imagenActual.src = 'https://via.placeholder.com/80?text=Sin+imagen';
        nombreImagen.textContent = 'Sin imagen';
    }
    
    // Resetear opciones de imagen
    const opcionSelect = document.getElementById('edit_opcion');
    if (opcionSelect) {
        opcionSelect.value = '';
        opcionSelect.classList.remove('is-invalid');
    }
    
    const campoImagen = document.getElementById('edit_campoImagen');
    const previewDiv = document.getElementById('edit_previewImagen');
    
    if (campoImagen) campoImagen.style.display = 'none';
    if (previewDiv) previewDiv.style.display = 'none';
}

// ==================== MOSTRAR/OCULTAR CAMPO DE IMAGEN ====================
function setupOpcionImagen() {
    const opcionSelect = document.getElementById('edit_opcion');
    const campoImagen = document.getElementById('edit_campoImagen');
    const previewDiv = document.getElementById('edit_previewImagen');
    const imagenInput = document.getElementById('edit_Imagen');
    
    if (!opcionSelect || !campoImagen) return;
    
    opcionSelect.addEventListener('change', function() {
        if (this.value === 'SI') {
            campoImagen.style.display = 'block';
            imagenInput.required = true;
        } else {
            campoImagen.style.display = 'none';
            previewDiv.style.display = 'none';
            imagenInput.required = false;
            imagenInput.value = '';
        }
    });
}

// ==================== VISTA PREVIA DE IMAGEN ====================
function setupImagenPreviewEdit() {
    const imagenInput = document.getElementById('edit_Imagen');
    const previewDiv = document.getElementById('edit_previewImagen');
    const previewImg = document.getElementById('edit_imagenPreview');
    
    if (!imagenInput) return;
    
    imagenInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
            if (!validTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Formato no válido',
                    text: 'Por favor, selecciona una imagen en formato JPG, PNG o GIF.',
                    confirmButtonColor: '#001F3F'
                });
                this.value = '';
                previewDiv.style.display = 'none';
                return;
            }
            
            if (file.size > 5 * 1024 * 1024) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Archivo muy grande',
                    text: 'La imagen no debe exceder los 5MB.',
                    confirmButtonColor: '#001F3F'
                });
                this.value = '';
                previewDiv.style.display = 'none';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewDiv.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewDiv.style.display = 'none';
            previewImg.src = '#';
        }
    });
}

// ==================== VALIDACIÓN DEL FORMULARIO ====================
function validarFormularioEditProducto() {
    const empresaSelect = document.getElementById('edit_ID_Empresas');
    const categoriaSelect = document.getElementById('edit_Id_cate');
    const tipoTallaSelect = document.getElementById('edit_Id_TipTall');
    const descripcion = document.getElementById('edit_Descripcion');
    const especificacion = document.getElementById('edit_Especificacion');
    const opcionSelect = document.getElementById('edit_opcion');
    
    let isValid = true;
    
    if (!empresaSelect.value) {
        empresaSelect.classList.add('is-invalid');
        isValid = false;
    } else {
        empresaSelect.classList.remove('is-invalid');
    }
    
    if (!categoriaSelect.value) {
        categoriaSelect.classList.add('is-invalid');
        isValid = false;
    } else {
        categoriaSelect.classList.remove('is-invalid');
    }
    
    if (!tipoTallaSelect.value) {
        tipoTallaSelect.classList.add('is-invalid');
        isValid = false;
    } else {
        tipoTallaSelect.classList.remove('is-invalid');
    }
    
    if (!descripcion.value.trim()) {
        descripcion.classList.add('is-invalid');
        isValid = false;
    } else {
        descripcion.classList.remove('is-invalid');
    }
    
    if (!especificacion.value.trim()) {
        especificacion.classList.add('is-invalid');
        isValid = false;
    } else {
        especificacion.classList.remove('is-invalid');
    }
    
    if (!opcionSelect.value) {
        opcionSelect.classList.add('is-invalid');
        document.getElementById('edit_opcionError').style.display = 'block';
        isValid = false;
    } else {
        opcionSelect.classList.remove('is-invalid');
        document.getElementById('edit_opcionError').style.display = 'none';
    }
    
    if (opcionSelect.value === 'SI') {
        const imagenInput = document.getElementById('edit_Imagen');
        if (!imagenInput.files || imagenInput.files.length === 0) {
            imagenInput.classList.add('is-invalid');
            isValid = false;
        } else {
            imagenInput.classList.remove('is-invalid');
        }
    }
    
    return isValid;
}

// ==================== ENVÍO DEL FORMULARIO ====================
function submitEditProductoForm() {
    const form = document.getElementById('FormUpdateProducto');
    
    if (!validarFormularioEditProducto()) {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Por favor, completa todos los campos requeridos correctamente.',
            confirmButtonColor: '#001F3F'
        });
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
        console.log('Respuesta del servidor:', text);
        
        try {
            const data = JSON.parse(text);
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Producto actualizado!',
                    text: data.message || 'El producto ha sido actualizado exitosamente.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if (modificarProductoModal) modificarProductoModal.hide();
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Ocurrió un error al actualizar el producto.',
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

// ==================== VALIDACIÓN EN TIEMPO REAL ====================
function addRealTimeValidationEditProducto() {
    const inputs = document.querySelectorAll('#modificarProductoModal input, #modificarProductoModal select, #modificarProductoModal textarea');
    
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('is-invalid');
            }
        });
        input.addEventListener('change', function() {
            if (this.value) {
                this.classList.remove('is-invalid');
            }
        });
    });
}

// ==================== ESCAPE HTML ====================
function escapeHtmlProductoEdit(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando modal de modificar producto...');
    
    // Configurar evento del botón de guardar
    const btnGuardar = document.getElementById('btnGuardarEditarProducto');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            submitEditProductoForm();
        });
    }
    
    // Configurar opción de imagen
    setupOpcionImagen();
    
    // Configurar vista previa de imagen
    setupImagenPreviewEdit();
    
    // Validación en tiempo real
    addRealTimeValidationEditProducto();
    
    // Limpiar formulario al cerrar modal
    const modalElement = document.getElementById('modificarProductoModal');
    if (modalElement) {
        modalElement.addEventListener('hidden.bs.modal', function() {
            const loadingDiv = document.getElementById('loadingProductoData');
            const formContainer = document.getElementById('editProductoFormContainer');
            
            if (loadingDiv) {
                loadingDiv.style.display = 'block';
                loadingDiv.innerHTML = `
                    <div class="text-center py-5">
                        <div class="spinner-border text-turquoise" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-3 text-muted">Cargando datos del producto...</p>
                    </div>
                `;
            }
            if (formContainer) formContainer.style.display = 'none';
        });
    }
});

// Función global para abrir el modal
window.openModificarProductoModal = openModificarProductoModal;