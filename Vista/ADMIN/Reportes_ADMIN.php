<?php include('head.php'); ?>

<h2 class="text-center">REPORTES</h2> 
    <!-- Formulario de Entradas de Productos -->
    <details class="accordion">
    <summary class="accordion-btn">Reporte de Entradas de Productos</summary>
        <div class="accordion-content">
            <div class="row">
                <div class="col-md-6">
                    <div class="formulario-panel formulario-izquierdo">
                        <form id="entradasFormFechas" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="Fecha_Inicio" class="form-label">Fecha de Inicio: </label>
                                <input class="form-control" type="date" id="Fecha_Inicio" name="Fecha_Inicio" required>
                                <div class="invalid-feedback">Por favor, selecciona una opción.</div>
                            </div>
                            <div class="mb-3">
                                <label for="Fecha_Fin" class="form-label">Fecha de Fin: </label>
                                <input class="form-control" type="date" id="Fecha_Fin" name="Fecha_Fin" required>
                                <div class="invalid-feedback">Por favor, selecciona una opción.</div>
                            </div>
                            <center>
                                <button type="button" id="btnGenerarPDF" class="btn-custom" onclick="Generar_PDF_Entradas_Fechas(event)">
                                    <span class="bgContainer"><span>Generar PDF</span></span>
                                    <span class="arrowContainer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-pdf" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                            <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                            <path d="M17 18h2" />
                                            <path d="M20 15h-3v6" />
                                            <path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" />
                                        </svg>
                                    </span>
                                </button>
                                <button type="button" id="btnGenerarExcel" class="btn-custom" onclick="Generar_Excel_Entradas_Fechas(event)">
                                    <span class="bgContainer"><span>Generar Excel</span></span>
                                    <span class="arrowContainer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-xls" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                            <path d="M4 15l4 6" />
                                            <path d="M4 21l4 -6" />
                                            <path d="M17 20.25c0 .414 .336 .75 .75 .75h1.25a1 1 0 0 0 1 -1v-1a1 1 0 0 0 -1 -1h-1a1 1 0 0 1 -1 -1v-1a1 1 0 0 1 1 -1h1.25a.75 .75 0 0 1 .75 .75" />
                                            <path d="M11 15v6h3" />
                                        </svg>
                                    </span>
                                </button>
                            </center>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="formulario-panel formulario-derecho">
                        <form id="entradaFormID" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="Id_Entrada" class="form-label">Ingresa el Numero de la Entrada:</label>
                                <input class="form-control" type="text" id="Id_Entrada" name="Id_Entrada" onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" required>
                                <div class="invalid-feedback">Por favor, ingresa el numero de entrada.</div>
                            </div>
                            <button type="button" id="btnGenerarPDF" class="btn-custom" onclick="Generar_PDF_Entrada_ID(event)">
                                <span class="bgContainer"><span>Generar PDF</span></span>
                                <span class="arrowContainer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-pdf" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                        <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                        <path d="M17 18h2" />
                                        <path d="M20 15h-3v6" />
                                        <path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" />
                                    </svg>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </details>

    <!-- Formulario de Salidas de Almacén -->
    <details class="accordion">
    <summary class="accordion-btn">Reporte de Salidas de Almacén</summary>
        <div class="accordion-content">
            <div class="row">
                <div class="col-md-6">
                    <div class="formulario-panel formulario-izquierdo">
                        <form id="salidasFormFechas" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="Fecha_Inicio" class="form-label">Fecha de Inicio:</label>
                                <input class="form-control" type="date" id="Fecha_Inicio" name="Fecha_Inicio" required>
                                <div class="invalid-feedback">Por favor, selecciona una opción.</div>
                            </div>
                            <div class="mb-3">
                                <label for="Fecha_Fin" class="form-label">Fecha de Fin:</label>
                                <input class="form-control" type="date" id="Fecha_Fin" name="Fecha_Fin" required>
                                <div class="invalid-feedback">Por favor, selecciona una opción.</div>
                            </div>
                            <center>
                                <button type="button" id="btnGenerarPDF" class="btn-custom" onclick="Generar_PDF_Salidas_Fechas(event)">
                                    <span class="bgContainer"><span>Generar PDF</span></span>
                                    <span class="arrowContainer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-pdf" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                            <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                            <path d="M17 18h2" />
                                            <path d="M20 15h-3v6" />
                                            <path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" />
                                        </svg>
                                    </span>
                                </button>
                                <button type="button" id="btnGenerarExcel" class="btn-custom" onclick="Generar_Excel_Salidas_Fechas(event)">
                                    <span class="bgContainer"><span>Generar Excel</span></span>
                                    <span class="arrowContainer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-xls" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                            <path d="M4 15l4 6" />
                                            <path d="M4 21l4 -6" />
                                            <path d="M17 20.25c0 .414 .336 .75 .75 .75h1.25a1 1 0 0 0 1 -1v-1a1 1 0 0 0 -1 -1h-1a1 1 0 0 1 -1 -1v-1a1 1 0 0 1 1 -1h1.25a.75 .75 0 0 1 .75 .75" />
                                            <path d="M11 15v6h3" />
                                        </svg>
                                    </span>
                                </button>
                            </center>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="formulario-panel formulario-derecho">
                        <form id="salidaFormID" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="Id_Salida" class="form-label">Ingresa el Numero de la Salida :</label>
                                <input class="form-control" type="text" id="Id_Salida" name="Id_Salida" onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" required>
                                <div class="invalid-feedback">Por favor, ingresa el numero de salida.</div>
                            </div>
                            <button type="button" id="btnGenerarPDF" class="btn-custom" onclick="Generar_PDF_Salida_ID(event)">
                                <span class="bgContainer"><span>Generar PDF</span></span>
                                <span class="arrowContainer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-pdf" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                        <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                        <path d="M17 18h2" />
                                        <path d="M20 15h-3v6" />
                                        <path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" />
                                    </svg>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </details>

    <!-- Formulario de Inventarios -->
    <details class="accordion">
        <summary class="accordion-btn">Reporte de Inventario</summary>
        <div class="accordion-content">
            <div class="mb-3">
                <center>
                    <br>
                    <button type="button" id="btnGenerarPDF" class="btn-custom" onclick="Generar_PDF_Inventario(event)">
                        <span class="bgContainer"><span>Generar PDF</span></span>
                        <span class="arrowContainer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-pdf" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                <path d="M17 18h2" />
                                <path d="M20 15h-3v6" />
                                <path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" />
                            </svg>
                        </span>
                    </button>
                    <button type="button" id="btnGenerarExcel" class="btn-custom" onclick="Generar_Excel_Inventario(event)">
                        <span class="bgContainer"><span>Generar Excel</span></span>
                        <span class="arrowContainer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-xls" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                <path d="M4 15l4 6" />
                                <path d="M4 21l4 -6" />
                                <path d="M17 20.25c0 .414 .336 .75 .75 .75h1.25a1 1 0 0 0 1 -1v-1a1 1 0 0 0 -1 -1h-1a1 1 0 0 1 -1 -1v-1a1 1 0 0 1 1 -1h1.25a.75 .75 0 0 1 .75 .75" />
                                <path d="M11 15v6h3" />
                            </svg>
                        </span>
                    </button>
                </center>
            </div>
        </div>
    </details>

    <!-- Formulario de Solicitud -->
    <details class="accordion">
        <summary class="accordion-btn">Reporte Solicitud</summary>
        <div class="accordion-content">
            <div class="row">
                <div class="col-md-6">
                    <div class="formulario-panel formulario-izquierdo">
                        <form id="solicitudFormFechas" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="Fecha_Inicio" class="form-label">Fecha de Inicio:</label>
                                <input class="form-control" type="date" id="Fecha_Inicio" name="Fecha_Inicio" required>
                                <div class="invalid-feedback">Por favor, selecciona una opción.</div>
                            </div>
                            <div class="mb-3">
                                <label for="Fecha_Fin" class="form-label">Fecha de Fin:</label>
                                <input class="form-control" type="date" id="Fecha_Fin" name="Fecha_Fin" required>
                                <div class="invalid-feedback">Por favor, selecciona una opción.</div>
                            </div>
                            <center>
                                <button type="button" id="btnGenerarPDF" class="btn-custom" onclick="Generar_PDF_Solicitud_Fechas(event)">
                                    <span class="bgContainer"><span>Generar PDF</span></span>
                                    <span class="arrowContainer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-pdf" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                            <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                            <path d="M17 18h2" />
                                            <path d="M20 15h-3v6" />
                                            <path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" />
                                        </svg>
                                    </span>
                                </button>
                                <button type="button" id="btnGenerarExcel" class="btn-custom" onclick="Generar_Excel_Solicitud_Fechas(event)">
                                    <span class="bgContainer"><span>Generar Excel</span></span>
                                    <span class="arrowContainer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-xls" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                            <path d="M4 15l4 6" />
                                            <path d="M4 21l4 -6" />
                                            <path d="M17 20.25c0 .414 .336 .75 .75 .75h1.25a1 1 0 0 0 1 -1v-1a1 1 0 0 0 -1 -1h-1a1 1 0 0 1 -1 -1v-1a1 1 0 0 1 1 -1h1.25a.75 .75 0 0 1 .75 .75" />
                                            <path d="M11 15v6h3" />
                                        </svg>
                                    </span>
                                </button>
                            </center>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="formulario-panel formulario-derecho">
                        <form id="solicitudFormID" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="Id_Solicitud" class="form-label">Ingresa el Numero de la Solicitud:</label>
                                <input class="form-control" type="text" id="Id_Solicitud" name="Id_Solicitud" onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" required>
                                <div class="invalid-feedback">Por favor, ingresa el numero de solicitud.</div>
                            </div>
                            <button type="button" id="btnGenerarPDF" class="btn-custom" onclick="Generar_PDF_Solicitud_ID(event)">
                                <span class="bgContainer"><span>Generar PDF</span></span>
                                <span class="arrowContainer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-pdf" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                        <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                        <path d="M17 18h2" />
                                        <path d="M20 15h-3v6" />
                                        <path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" />
                                    </svg>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </details>

    <!-- Modal de ERROR -->
    <div class="modal fade" id="pdfModalERROR" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lo siento</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <center><div class="modal-body">
                    <p id="errorMessage"></p>
                </div></center>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de inventario -->
    <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Reporte de Inventario</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframe" src="" style="width: 100%; height: 600px;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de entrada fechas -->
    <div class="modal fade" id="pdfModalEntradaFechas" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Reporte Entradas de Productos por Fechas</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfViewerEntradasFechas" style="width: 100%; height: 600px;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de salidas fechas -->
    <div class="modal fade" id="pdfModalSalidaFechas" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Reporte Salidas de Almacén por Fechas</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfViewerSalidasFechas" style="width: 100%; height: 600px;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de solicitud fechas -->
    <div class="modal fade" id="pdfModalSolicitudFechas" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Reporte Solicitudes por Fechas</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframeSolicitudFechas" width="100%" height="500px"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de solicitud ID -->
    <div class="modal fade" id="pdfModalSolicitudID" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Reporte Solicitudes por ID</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframeSolicitudID" width="100%" height="500px"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
        <!-- Modal de Entrada ID -->
    <div class="modal fade" id="pdfModalEntradaID" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Reporte Entradas de Productos por ID</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframeEntradaID" width="100%" height="500px"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
        <!-- Modal de Salida ID -->
    <div class="modal fade" id="pdfModalSalidaID" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Reporte Salidas de Almacén por ID</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframeSalidaID" width="100%" height="500px"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

<?php include('footer.php'); ?>