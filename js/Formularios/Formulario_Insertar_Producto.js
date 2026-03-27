// ==================== MODAL DE REGISTRO DE PRODUCTO - JS COMPLETO ====================

let productoModal;

// ==================== FUNCIÓN PARA ABRIR EL MODAL ====================
async function openProductoModal() {
    if (!productoModal) {
        productoModal = new bootstrap.Modal(document.getElementById('registrarProductoModal'));
    }
    
    // Mostrar loading en los selects
    const empresaSelect = document.getElementById('IdCEmpresa');
    const categoriaSelect = document.getElementById('IdCCate');
    const tipoTallaSelect = document.getElementById('IdCTipTall');
    
    if (empresaSelect) {
        empresaSelect.innerHTML = '<option value="" selected disabled>⏳ Cargando empresas...</option>';
        empresaSelect.disabled = true;
    }
    if (categoriaSelect) {
        categoriaSelect.innerHTML = '<option value="" selected disabled>⏳ Cargando categorías...</option>';
        categoriaSelect.disabled = true;
    }
    if (tipoTallaSelect) {
        tipoTallaSelect.innerHTML = '<option value="" selected disabled>⏳ Cargando tipos de talla...</option>';
        tipoTallaSelect.disabled = true;
    }
    
    // Resetear formulario
    const form = document.getElementById('FormInsertProductoNuevo');
    if (form) {
        form.reset();
        document.querySelectorAll('#registrarProductoModal .is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
    }
    
    // Ocultar div de nueva empresa
    const nuevoEmpresaDiv = document.getElementById('nuevoEmpresaDiv');
    if (nuevoEmpresaDiv) {
        nuevoEmpresaDiv.style.display = 'none';
    }
    
    // Ocultar vista previa de imagen
    const previewDiv = document.getElementById('previewImagen');
    if (previewDiv) {
        previewDiv.style.display = 'none';
    }
    
    // Cargar datos
    await Promise.all([
        cargarEmpresas(),
        cargarCategorias(),
        cargarTiposTalla()
    ]);
    
    // Habilitar selects después de cargar
    if (empresaSelect) empresaSelect.disabled = false;
    if (categoriaSelect) categoriaSelect.disabled = false;
    if (tipoTallaSelect) tipoTallaSelect.disabled = false;
    
    productoModal.show();
}

// ==================== CARGAR EMPRESAS VÍA FETCH ====================
async function cargarEmpresas() {
    const empresaSelect = document.getElementById('IdCEmpresa');
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
                empresaSelect.innerHTML += `<option value="${empresa.IdCEmpresa}">${escapeHtmlProducto(empresa.Nombre_Empresa)}</option>`;
            });
            empresaSelect.innerHTML += '<option value="nuevo_empresa">➕ Agregar Nueva Empresa</option>';
        } else {
            empresaSelect.innerHTML = '<option value="" selected disabled>-- No hay empresas disponibles --</option>';
            empresaSelect.innerHTML += '<option value="nuevo_empresa">➕ Agregar Nueva Empresa</option>';
        }
        
    } catch (error) {
        console.error('Error al cargar empresas:', error);
        empresaSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar empresas</option>';
        empresaSelect.innerHTML += '<option value="nuevo_empresa">➕ Agregar Nueva Empresa</option>';
        empresaSelect.disabled = false;
    }
}

// ==================== CARGAR CATEGORÍAS VÍA FETCH ====================
async function cargarCategorias() {
    const categoriaSelect = document.getElementById('IdCCate');
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
                categoriaSelect.innerHTML += `<option value="${categoria.IdCCate}">${escapeHtmlProducto(categoria.Descrp)}</option>`;
            });
        } else {
            categoriaSelect.innerHTML = '<option value="" selected disabled>-- No hay categorías disponibles --</option>';
        }
        
    } catch (error) {
        console.error('Error al cargar categorías:', error);
        categoriaSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar categorías</option>';
        categoriaSelect.disabled = false;
    }
}

// ==================== CARGAR TIPOS DE TALLA VÍA FETCH ====================
async function cargarTiposTalla() {
    const tipoTallaSelect = document.getElementById('IdCTipTall');
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
                tipoTallaSelect.innerHTML += `<option value="${tipo.IdCTipTall}">${escapeHtmlProducto(tipo.Descrip)}</option>`;
            });
        } else {
            tipoTallaSelect.innerHTML = '<option value="" selected disabled>-- No hay tipos de talla disponibles --</option>';
        }
        
    } catch (error) {
        console.error('Error al cargar tipos de talla:', error);
        tipoTallaSelect.innerHTML = '<option value="" selected disabled>❌ Error al cargar tipos de talla</option>';
        tipoTallaSelect.disabled = false;
    }
}

// ==================== MOSTRAR/OCULTAR DIV DE NUEVA EMPRESA ====================
function setupEmpresaSelect() {
    const empresaSelect = document.getElementById('IdCEmpresa');
    const nuevoEmpresaDiv = document.getElementById('nuevoEmpresaDiv');
    
    if (!empresaSelect || !nuevoEmpresaDiv) return;
    
    empresaSelect.addEventListener('change', function() {
        if (this.value === 'nuevo_empresa') {
            nuevoEmpresaDiv.style.display = 'block';
            // Hacer requeridos los campos de nueva empresa
            document.getElementById('Nombre_Empresa').required = true;
            document.getElementById('RazonSocial').required = true;
            document.getElementById('RFC').required = true;
            document.getElementById('RegistroPatronal').required = true;
            document.getElementById('Especif').required = true;
        } else {
            nuevoEmpresaDiv.style.display = 'none';
            // Quitar requeridos
            document.getElementById('Nombre_Empresa').required = false;
            document.getElementById('RazonSocial').required = false;
            document.getElementById('RFC').required = false;
            document.getElementById('RegistroPatronal').required = false;
            document.getElementById('Especif').required = false;
            
            // Limpiar campos
            document.getElementById('Nombre_Empresa').value = '';
            document.getElementById('RazonSocial').value = '';
            document.getElementById('RFC').value = '';
            document.getElementById('RegistroPatronal').value = '';
            document.getElementById('Especif').value = '';
        }
    });
}

// ==================== VISTA PREVIA DE IMAGEN ====================
function setupImagenPreview() {
    const imagenInput = document.getElementById('Imagen');
    const previewDiv = document.getElementById('previewImagen');
    const previewImg = document.getElementById('imagenPreview');
    
    if (!imagenInput) return;
    
    imagenInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Validar tipo de archivo
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
            
            // Validar tamaño (5MB máximo)
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
function validarFormularioProducto() {
    const empresaSelect = document.getElementById('IdCEmpresa');
    const categoriaSelect = document.getElementById('IdCCate');
    const tipoTallaSelect = document.getElementById('IdCTipTall');
    const descripcion = document.getElementById('Descripcion');
    const especificacion = document.getElementById('Especificacion');
    const imagen = document.getElementById('Imagen');
    
    let isValid = true;
    
    // Validar empresa
    if (!empresaSelect.value) {
        empresaSelect.classList.add('is-invalid');
        isValid = false;
    } else {
        empresaSelect.classList.remove('is-invalid');
    }
    
    // Si seleccionó nueva empresa, validar campos
    if (empresaSelect.value === 'nuevo_empresa') {
        const nombreEmpresa = document.getElementById('Nombre_Empresa');
        const razonSocial = document.getElementById('RazonSocial');
        const rfc = document.getElementById('RFC');
        const registroPatronal = document.getElementById('RegistroPatronal');
        const especif = document.getElementById('Especif');
        
        if (!nombreEmpresa.value.trim()) {
            nombreEmpresa.classList.add('is-invalid');
            isValid = false;
        } else {
            nombreEmpresa.classList.remove('is-invalid');
        }
        
        if (!razonSocial.value.trim()) {
            razonSocial.classList.add('is-invalid');
            isValid = false;
        } else {
            razonSocial.classList.remove('is-invalid');
        }
        
        if (!rfc.value.trim()) {
            rfc.classList.add('is-invalid');
            isValid = false;
        } else {
            rfc.classList.remove('is-invalid');
        }
        
        if (!registroPatronal.value.trim()) {
            registroPatronal.classList.add('is-invalid');
            isValid = false;
        } else {
            registroPatronal.classList.remove('is-invalid');
        }
        
        if (!especif.value.trim()) {
            especif.classList.add('is-invalid');
            isValid = false;
        } else {
            especif.classList.remove('is-invalid');
        }
    }
    
    // Validar categoría
    if (!categoriaSelect.value) {
        categoriaSelect.classList.add('is-invalid');
        isValid = false;
    } else {
        categoriaSelect.classList.remove('is-invalid');
    }
    
    // Validar tipo de talla
    if (!tipoTallaSelect.value) {
        tipoTallaSelect.classList.add('is-invalid');
        isValid = false;
    } else {
        tipoTallaSelect.classList.remove('is-invalid');
    }
    
    // Validar descripción
    if (!descripcion.value.trim()) {
        descripcion.classList.add('is-invalid');
        isValid = false;
    } else {
        descripcion.classList.remove('is-invalid');
    }
    
    // Validar especificación
    if (!especificacion.value.trim()) {
        especificacion.classList.add('is-invalid');
        isValid = false;
    } else {
        especificacion.classList.remove('is-invalid');
    }
    
    // Validar imagen
    if (!imagen.files || imagen.files.length === 0) {
        imagen.classList.add('is-invalid');
        isValid = false;
    } else {
        imagen.classList.remove('is-invalid');
    }
    
    return isValid;
}

// ==================== PREPARAR DATOS PARA ENVÍO ====================
function prepararDatosFormulario(form) {
    const formData = new FormData(form);
    
    // Si se seleccionó nueva empresa, enviar los campos adicionales
    const empresaSelect = document.getElementById('IdCEmpresa');
    if (empresaSelect.value === 'nuevo_empresa') {
        // Los campos ya están en el FormData porque están dentro del formulario
        // Solo asegurar que se envíen correctamente
        const nombreEmpresa = document.getElementById('Nombre_Empresa').value;
        const razonSocial = document.getElementById('RazonSocial').value;
        const rfc = document.getElementById('RFC').value;
        const registroPatronal = document.getElementById('RegistroPatronal').value;
        const especif = document.getElementById('Especif').value;
        
        // Agregar un flag para indicar que es nueva empresa
        formData.append('es_nueva_empresa', '1');
        
        // Asegurar que los campos no estén vacíos
        if (nombreEmpresa) formData.set('Nombre_Empresa', nombreEmpresa);
        if (razonSocial) formData.set('RazonSocial', razonSocial);
        if (rfc) formData.set('RFC', rfc);
        if (registroPatronal) formData.set('RegistroPatronal', registroPatronal);
        if (especif) formData.set('Especif', especif);
    }
    
    return formData;
}

// ==================== ENVÍO DEL FORMULARIO ====================
function submitProductoForm() {
    const form = document.getElementById('FormInsertProductoNuevo');
    
    if (!validarFormularioProducto()) {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Por favor, completa todos los campos requeridos correctamente.',
            confirmButtonColor: '#001F3F'
        });
        return;
    }
    
    const formData = prepararDatosFormulario(form);
    
    Swal.fire({
        title: 'Guardando producto...',
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
                    title: '¡Producto registrado!',
                    text: data.message || 'El producto ha sido registrado exitosamente.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    if (productoModal) productoModal.hide();
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Ocurrió un error al registrar el producto.',
                    confirmButtonColor: '#001F3F'
                });
            }
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Error de servidor',
                text: 'Error al procesar la respuesta del servidor. Verifica los logs.',
                confirmButtonColor: '#001F3F'
            });
            console.error('Error al parsear JSON:', err);
            console.error('Respuesta cruda:', text);
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
function addRealTimeValidationProducto() {
    const inputs = document.querySelectorAll('#registrarProductoModal input, #registrarProductoModal select, #registrarProductoModal textarea');
    
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
function escapeHtmlProducto(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== EVENTOS ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando modal de producto...');
    
    // Configurar evento del botón de guardar
    const btnGuardar = document.getElementById('btnGuardarProducto');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            submitProductoForm();
        });
    }
    
    // Configurar select de empresa
    setupEmpresaSelect();
    
    // Configurar vista previa de imagen
    setupImagenPreview();
    
    // Validación en tiempo real
    addRealTimeValidationProducto();
    
    // Limpiar formulario al cerrar modal
    const modalElement = document.getElementById('registrarProductoModal');
    if (modalElement) {
        modalElement.addEventListener('hidden.bs.modal', function() {
            const form = document.getElementById('FormInsertProductoNuevo');
            if (form) {
                form.reset();
                document.querySelectorAll('#registrarProductoModal .is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
            }
            
            const previewDiv = document.getElementById('previewImagen');
            if (previewDiv) {
                previewDiv.style.display = 'none';
            }
            
            const nuevoEmpresaDiv = document.getElementById('nuevoEmpresaDiv');
            if (nuevoEmpresaDiv) {
                nuevoEmpresaDiv.style.display = 'none';
            }
        });
    }
});

// Función global para abrir el modal
window.openProductoModal = openProductoModal;