// js/alerts-table.js - Versión con paginación
class AlertsTable {
    constructor() {
        this.table = document.getElementById('alertsTable');
        this.tbody = this.table.querySelector('tbody');
        this.pageNumbersContainer = document.getElementById('pageNumbers');
        
        // Elementos de paginación
        this.totalRowsElement = document.getElementById('totalRows');
        this.startRowElement = document.getElementById('startRow');
        this.endRowElement = document.getElementById('endRow');
        
        // Botones de paginación
        this.prevBtn = document.querySelector('.prev-page');
        this.nextBtn = document.querySelector('.next-page');
        this.firstBtn = document.querySelector('.first-page');
        this.lastBtn = document.querySelector('.last-page');
        
        // Variables de estado
        this.currentData = [];
        this.filteredData = [];
        this.currentPage = 1;
        this.rowsPerPage = 10;
        this.totalPages = 1;
        this.searchTerm = '';
        
        this.init();
    }
    
    init() {
        // Cargar datos iniciales
        this.cargarAlertasInventario();
        
        // Configurar búsqueda en tiempo real
        const searchInput = document.getElementById('searchAlerts');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.searchTerm = e.target.value.toLowerCase();
                this.filterData();
                this.renderTable();
            });
        }
        
        // Configurar cambio de filas por página
        const rowsSelect = document.getElementById('rowsPerPage');
        if (rowsSelect) {
            rowsSelect.value = this.rowsPerPage.toString();
        }
        
        // Auto-refresh cada 5 minutos
        setInterval(() => {
            this.cargarAlertasInventario();
        }, 5 * 60 * 1000);
    }
    
    async cargarAlertasInventario() {
        try {
            this.mostrarCargando();
            
            const respuesta = await fetch('../../Controlador/GET/getNotificacionAlertaInventario.php');
            this.currentData = await respuesta.json();
            
            // Filtrar datos si hay término de búsqueda
            this.filterData();
            
            // Renderizar tabla
            this.renderTable();
            
            // Mostrar notificación si hay alertas
            if (this.currentData.length > 0) {
                this.mostrarNotificacionBanner(this.currentData.length);
            }
            
        } catch (error) {
            console.error('Error al cargar alertas:', error);
            this.mostrarError('Error al cargar las alertas de inventario');
        }
    }
    
    filterData() {
        if (!this.searchTerm) {
            this.filteredData = [...this.currentData];
        } else {
            this.filteredData = this.currentData.filter(alerta => {
                return Object.values(alerta).some(value => 
                    value && value.toString().toLowerCase().includes(this.searchTerm)
                );
            });
        }
        
        // Resetear a página 1 cuando se filtra
        this.currentPage = 1;
        this.calculatePagination();
    }
    
    calculatePagination() {
        this.totalPages = Math.ceil(this.filteredData.length / this.rowsPerPage);
        
        // Asegurar que currentPage sea válido
        if (this.currentPage > this.totalPages && this.totalPages > 0) {
            this.currentPage = this.totalPages;
        }
        
        // Calcular índices
        const startIndex = (this.currentPage - 1) * this.rowsPerPage;
        const endIndex = Math.min(startIndex + this.rowsPerPage, this.filteredData.length);
        
        // Actualizar información de paginación
        this.updatePaginationInfo(startIndex, endIndex);
        this.updatePaginationControls();
    }
    
    updatePaginationInfo(startIndex, endIndex) {
        this.totalRowsElement.textContent = this.filteredData.length;
        this.startRowElement.textContent = this.filteredData.length > 0 ? startIndex + 1 : 0;
        this.endRowElement.textContent = endIndex;
    }
    
    updatePaginationControls() {
        // Actualizar estado de botones
        this.firstBtn.disabled = this.currentPage === 1;
        this.prevBtn.disabled = this.currentPage === 1;
        this.nextBtn.disabled = this.currentPage === this.totalPages || this.totalPages === 0;
        this.lastBtn.disabled = this.currentPage === this.totalPages || this.totalPages === 0;
        
        // Generar números de página
        this.generatePageNumbers();
    }
    
    generatePageNumbers() {
        this.pageNumbersContainer.innerHTML = '';
        
        if (this.totalPages <= 1) return;
        
        const maxVisiblePages = 5;
        let startPage = Math.max(1, this.currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(this.totalPages, startPage + maxVisiblePages - 1);
        
        // Ajustar si estamos cerca del inicio
        if (endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }
        
        // Agregar primera página si no está visible
        if (startPage > 1) {
            this.addPageNumber(1);
            if (startPage > 2) {
                this.addEllipsis();
            }
        }
        
        // Agregar páginas visibles
        for (let i = startPage; i <= endPage; i++) {
            this.addPageNumber(i);
        }
        
        // Agregar última página si no está visible
        if (endPage < this.totalPages) {
            if (endPage < this.totalPages - 1) {
                this.addEllipsis();
            }
            this.addPageNumber(this.totalPages);
        }
    }
    
    addPageNumber(pageNumber) {
        const pageBtn = document.createElement('button');
        pageBtn.className = `page-number ${pageNumber === this.currentPage ? 'active' : ''}`;
        pageBtn.textContent = pageNumber;
        pageBtn.onclick = () => this.goToPage(pageNumber);
        
        this.pageNumbersContainer.appendChild(pageBtn);
    }
    
    addEllipsis() {
        const ellipsis = document.createElement('span');
        ellipsis.className = 'page-number ellipsis';
        ellipsis.textContent = '...';
        this.pageNumbersContainer.appendChild(ellipsis);
    }
    
    renderTable() {
        // Limpiar tabla
        this.tbody.innerHTML = '';
        
        if (this.filteredData.length === 0) {
            this.mostrarMensajeVacio();
            return;
        }
        
        // Calcular paginación
        this.calculatePagination();
        
        // Obtener datos para la página actual
        const startIndex = (this.currentPage - 1) * this.rowsPerPage;
        const endIndex = Math.min(startIndex + this.rowsPerPage, this.filteredData.length);
        const pageData = this.filteredData.slice(startIndex, endIndex);
        
        // Agregar filas
        pageData.forEach(alerta => {
            const fila = this.crearFila(alerta);
            this.tbody.appendChild(fila);
        });
    }
    
    crearFila(alerta) {
        const fila = document.createElement('tr');
        
        // Determinar estado según cantidad
        let estado = '';
        let claseEstado = '';
        
        if (alerta.Cantidad <= 2) {
            estado = 'CRÍTICO';
            claseEstado = 'status-critical';
        } else if (alerta.Cantidad <= 3) {
            estado = 'ALTO';
            claseEstado = 'status-warning';
        } else {
            estado = 'BAJO';
            claseEstado = 'status-low';
        }
        
        fila.innerHTML = `
            <td data-label="ID">${alerta.Identificador}</td>
            <td data-label="Descripción">${this.escapeHtml(alerta.Descripcion || 'N/A')}</td>
            <td data-label="Especificación">${this.escapeHtml(alerta.Especificacion || 'N/A')}</td>
            <td data-label="Talla">${this.escapeHtml(alerta.Talla || 'N/A')}</td>
            <td data-label="Cantidad">
                <span class="quantity-display ${claseEstado}">
                    ${alerta.Cantidad}
                </span>
            </td>
            <td data-label="Estado">
                <span class="status-badge ${claseEstado}">
                    ${estado}
                </span>
            </td>
        `;
        
        return fila;
    }
    
    // Métodos de navegación de paginación
    goToPage(page) {
        if (page < 1 || page > this.totalPages || page === this.currentPage) return;
        
        this.currentPage = page;
        this.renderTable();
        
        // Hacer scroll suave a la tabla
        document.querySelector('.alerts-section').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
    
    goToNextPage() {
        if (this.currentPage < this.totalPages) {
            this.goToPage(this.currentPage + 1);
        }
    }
    
    goToPrevPage() {
        if (this.currentPage > 1) {
            this.goToPage(this.currentPage - 1);
        }
    }
    
    goToFirstPage() {
        this.goToPage(1);
    }
    
    goToLastPage() {
        this.goToPage(this.totalPages);
    }
    
    changeRowsPerPage(value) {
        const newRowsPerPage = parseInt(value);
        
        if (newRowsPerPage !== this.rowsPerPage) {
            this.rowsPerPage = newRowsPerPage;
            
            // Recalcular página actual para mantener la posición relativa
            const startIndex = (this.currentPage - 1) * this.rowsPerPage;
            this.currentPage = Math.floor(startIndex / newRowsPerPage) + 1;
            
            this.renderTable();
        }
    }
    
    mostrarCargando() {
        this.tbody.innerHTML = `
            <tr class="loading-row">
                <td colspan="6">
                    <div class="loading-spinner">
                        <i class="fas fa-spinner fa-spin"></i>
                        Cargando alertas...
                    </div>
                </td>
            </tr>
        `;
        
        // Resetear controles de paginación
        this.totalRowsElement.textContent = '0';
        this.startRowElement.textContent = '0';
        this.endRowElement.textContent = '0';
        this.updatePaginationControls();
    }
    
    mostrarMensajeVacio() {
        const message = this.searchTerm ? 
            'No se encontraron productos con stock bajo que coincidan con la búsqueda.' :
            '¡Todo en orden! No hay productos con stock bajo en este momento.';
        
        this.tbody.innerHTML = `
            <tr class="empty-row">
                <td colspan="6">
                    <div class="empty-message">
                        <i class="fas ${this.searchTerm ? 'fa-search' : 'fa-check-circle'}"></i>
                        <h4>${this.searchTerm ? 'Sin resultados' : 'Todo en orden'}</h4>
                        <p>${message}</p>
                    </div>
                </td>
            </tr>
        `;
        
        // Actualizar información de paginación
        this.totalRowsElement.textContent = '0';
        this.startRowElement.textContent = '0';
        this.endRowElement.textContent = '0';
        this.updatePaginationControls();
    }
    
    mostrarError(mensaje) {
        this.tbody.innerHTML = `
            <tr class="error-row">
                <td colspan="6">
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <h4>Error</h4>
                        <p>${mensaje}</p>
                        <button onclick="alertsTable.cargarAlertasInventario()" 
                                class="btn-refresh">
                            <i class="fas fa-redo"></i> Reintentar
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }
    
    mostrarNotificacionBanner(cantidad) {
        const banner = document.createElement('div');
        banner.className = 'alert-banner';
        banner.innerHTML = `
            <div class="banner-content">
                <i class="fas fa-exclamation-triangle"></i>
                <span>${cantidad} producto(s) con stock bajo.     <a class="fas fa-arrow-down" href="#idTablaNotificacion">Ver</a></span>
                <button class="banner-close" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        banner.style.cssText = `
            position: fixed;
            top: 70px;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, var(--warning-color), #ff9800);
            color: white;
            padding: 1rem;
            z-index: 9999;
            animation: slideDown 0.3s ease;
        `;
        
        const bannerContent = banner.querySelector('.banner-content');
        bannerContent.style.cssText = `
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            max-width: 1200px;
            margin: 0 auto;
        `;
        
        const closeBtn = banner.querySelector('.banner-close');
        closeBtn.style.cssText = `
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            margin-left: auto;
        `;
        
        document.body.appendChild(banner);
        
        setTimeout(() => {
            if (banner.parentNode) {
                banner.style.animation = 'slideUp 0.3s ease';
                setTimeout(() => banner.remove(), 300);
            }
        }, 5000);
    }
    
    exportarAlertas() {
        const dataToExport = this.searchTerm ? this.filteredData : this.currentData;
        
        if (dataToExport.length === 0) {
            this.mostrarToast('No hay datos para exportar', 'warning');
            return;
        }
        
        // Preparar datos
        const excelData = dataToExport.map(alerta => {
            let estado = '';
            if (alerta.Cantidad <= 2) estado = 'CRÍTICO';
            else if (alerta.Cantidad <= 3) estado = 'ALTO';
            else estado = 'BAJO';
            
            return {
                "ID": alerta.Identificador,
                "Descripción": alerta.Descripcion || 'N/A',
                "Especificación": alerta.Especificacion || 'N/A',
                "Talla": alerta.Talla || 'N/A',
                "Cantidad": alerta.Cantidad,
                "Estado": estado
            };
        });
        
        // Crear libro de Excel
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.json_to_sheet(excelData);
        
        // Agregar información de encabezado
        const fechaExportacion = new Date().toLocaleString();
        const totalProductos = dataToExport.length;
        
        XLSX.utils.sheet_add_aoa(ws, [
            ["REPORTE DE ALERTAS DE INVENTARIO BAJO"],
            ["Fecha de exportación:", fechaExportacion],
            ["Total de productos:", totalProductos],
            [] // Línea en blanco
        ], { origin: "H1" });
        
        // Agregar hoja al libro
        XLSX.utils.book_append_sheet(wb, ws, "Alertas");
        
        // Nombre del archivo
        const fecha = new Date().toISOString().split('T')[0];
        const nombreArchivo = this.searchTerm ? 
            `alertas_filtradas_${fecha}.xlsx` : 
            `alertas_completas_${fecha}.xlsx`;
        
        // Exportar
        XLSX.writeFile(wb, nombreArchivo);
        
        this.mostrarToast('Archivo Excel generado exitosamente', 'success');
    }
    
    escapeCSV(text) {
        if (!text) return '';
        return text.toString().replace(/"/g, '""').replace(/\n/g, ' ');
    }
    
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    mostrarToast(mensaje, tipo = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${tipo}`;
        toast.textContent = mensaje;
        
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--secondary-white);
            color: var(--secondary-black);
            padding: 1rem 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            z-index: 10000;
            animation: slideInRight 0.3s ease;
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
}

// Instanciar cuando el DOM esté listo
let alertsTable;
document.addEventListener('DOMContentLoaded', () => {
    alertsTable = new AlertsTable();
});

// Funciones globales para acceso desde HTML
function cargarAlertasInventario() {
    if (alertsTable) {
        alertsTable.cargarAlertasInventario();
    }
}

function exportarAlertas() {
    if (alertsTable) {
        alertsTable.exportarAlertas();
    }
}