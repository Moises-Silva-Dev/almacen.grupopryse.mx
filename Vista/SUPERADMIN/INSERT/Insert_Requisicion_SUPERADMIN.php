<?php include('head.php'); ?>

<div class="container mt-5">
    <center><h2>Registrar Nuevo Borrador Requisición</h2></center>
    <!-- Formulario -->
    <form id="FormInsertRequisionNueva" class="needs-validation" action="../../../Controlador/Usuarios/INSERT/Funcion_Insert_Requisicion.php" method="POST" enctype="multipart/form-data" novalidate>
    <input type="hidden" id="datosTabla" name="datosTabla">

    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header " id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Información General
            </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="mb-3">
                        <label for="Supervisor" class="form-label"><span style="color: red;">*</span> Supervisor:</label>
                        <input type="text" class="form-control" id="Supervisor" name="Supervisor" placeholder="Ingresa el Nombre del Supervisor" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32)" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el nombre del Supervisor.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="ID_Cuenta" class="form-label"><span style="color: red;">*</span> Cuenta:</label>
                        <select class="form-select mb-3" id="ID_Cuenta" name="ID_Cuenta" required>
                            <option value="" selected disabled>-- Seleccionar Cuenta --</option>
                                <?php
                                    include('../../../Modelo/Conexion.php'); 
                                    $conexion = (new Conectar())->conexion();
                        
                                    // Llamo el correo del usuario
                                    $usuario = $_SESSION['usuario'];

                                    // Preparar la consulta
                                    $stmt = $conexion->prepare("SELECT C.ID, C.NombreCuenta 
                                                FROM 
                                                    Usuario U
                                                INNER JOIN 
                                                    Usuario_Cuenta UC ON U.ID_Usuario = UC.ID_Usuarios
                                                INNER JOIN
                                                    Cuenta C ON UC.ID_Cuenta = C.ID
                                                WHERE 
                                                    U.Correo_Electronico = ?");
                            
                                    // Vincular parámetros
                                    $stmt->bind_param("s", $usuario);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($resultado1 = $result->fetch_assoc()) {
                                        echo "<option value='" . htmlspecialchars($resultado1['ID']) . "'>" . htmlspecialchars($resultado1['NombreCuenta']) . "</option>";
                                    }

                                    // Cerrar la declaración
                                    $stmt->close();
                                ?>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, selecciona una opción.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="Region" class="form-label"><span style="color: red;">*</span> Región:</label>
                        <select class="form-select mb-3" id="Region" name="Region" required>
                            <option value="" selected disabled>-- Seleccionar Región --</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, selecciona una opción.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="CentroTrabajo" class="form-label">Centro de Trabajo:</label>
                        <input type="text" class="form-control" id="CentroTrabajo" name="CentroTrabajo" placeholder="Ingresa el Nombre del Centro de Trabajo">
                        <div class="invalid-feedback">
                            Por favor, ingresa el nombre del Centro de Trabajo.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="NroElementos" class="form-label"><span style="color: red;">*</span> Numero de Elementos:</label>
                        <input type="text" class="form-control" id="NroElementos" name="NroElementos" placeholder="Ingresa el Numero de Elementos" onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el numero de Elementos.
                        </div>
                    </div>
                    <div class="mb-3">
                    <label for="Estado" class="form-label"><span style="color: red;">*</span> Estado:</label>
                        <select class="form-select mb-3" id="Estado" name="Estado" required>
                            <option value="" selected disabled>-- Seleccionar Estado --</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, selecciona una opción.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="Receptor" class="form-label"><span style="color: red;">*</span> Nombre del Receptor:</label>
                        <input type="text" class="form-control" id="Receptor" name="Receptor" placeholder="Ingresa el Nombre del Receptor" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32)" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el Nombre del Receptor.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="num_tel" class="form-label"><span style="color: red;">*</span> Número de Teléfono del Receptor:</label>
                        <input type="tel" class="form-control" id="num_tel" name="num_tel" placeholder="Ingresa el Numero de Telefono del Receptor" onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa tu Numero de Telefono.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="RFC" class="form-label">RFC del Receptor:</label>
                        <input type="text" class="form-control" id="RFC" name="RFC" placeholder="Ingresa el RFC del Receptor" maxlength="13">
                        <div class="invalid-feedback">
                            Por favor, ingresa tu RFC.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="Justificacion" class="form-label"><span style="color: red;">*</span> Justificación:</label>
                        <textarea name="Justificacion" id="Justificacion" class="form-control" placeholder="Ingresa la Justificación" required></textarea>
                        <div class="invalid-feedback">
                            Por favor, ingresa la Justificación.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="Opcion" class="form-label"><span style="color: red;">*</span> ¿Enviar a Domicilio?</label>
                        <select class="form-select mb-3" id="Opcion" name="Opcion" required>
                            <option value="" selected disabled>-- Seleccionar Opción --</option>
                            <option value="SI">Si</option>
                            <option value="NO">No</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, selecciona una opción.
                        </div>
                    </div>

                    <div id="Envio" class="mb-3" style="display: none;">
                        <label for="Mpio" class="form-label">Municipio:</label>
                        <input type="text" class="form-control" id="Mpio" name="Mpio" placeholder="Ingresa el Municipio">
                        <div class="invalid-feedback">
                            Por favor, ingresa el Municipio.
                        </div>
                    <br>
                        <label for="Colonia" class="form-label">Colonia:</label>
                        <input type="text" class="form-control" id="Colonia" name="Colonia" placeholder="Ingresa la Colonia">
                        <div class="invalid-feedback">
                            Por favor, ingresa la colonia.
                        </div>
                    <br>
                        <label for="Calle" class="form-label">Calle:</label>
                        <input type="text" class="form-control" id="Calle" name="Calle" placeholder="Ingresa el Nombre de la Calle">
                        <div class="invalid-feedback">
                            Por favor, ingresa el nombre de la calle.
                        </div>
                    <br>            
                        <label for="Nro" class="form-label">Numero de Casa:</label>
                        <input type="text" class="form-control" id="Nro" name="Nro" placeholder="Ingresa el Numero de Casa">
                        <div class="invalid-feedback">
                            Por favor, ingresa el numero de casa.
                        </div>
                    <br>
                        <label for="CP" class="form-label">Codigo Postal:</label>
                        <input type="text" class="form-control" id="CP" name="CP" placeholder="Ingresa el Codigo Postal" maxlength="5" onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;">
                        <div class="invalid-feedback">
                            Por favor, ingresa el codigo postal.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Productos
            </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <center>
                    <div class="mb-2">
                        <button type="button" class="btn btn-info" id="BtnMostrarTablaProductos">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="44" height="44" stroke-width="1.5"> 
                                <path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path> 
                                <path d="M18.5 18.5l2.5 2.5"></path> 
                                <path d="M4 6h16"></path> 
                                <path d="M4 12h4"></path> 
                                <path d="M4 18h4"></path> 
                            </svg>Catalogo</button>
                    </div>
                    </center>
                    <table class="table table-responsive bg-info" id="tabla">
                        <tbody>
                            <tr class="fila-fija" data-id="1">
                                <td>
                                    <div class="mb-2">
                                        <label for="ID_Producto" class="form-label">Codigo:</label>
                                        <select class="form-select mb-3" id="ID_Producto" name="ID_Producto[]">
                                            <option value="" selected disabled>-- Seleccionar ID de Producto --</option>
                                            <?php
                                                $sql = $conexion->query("SELECT * FROM Producto;");
                                                while ($resultado = $sql->fetch_assoc()) {
                                                    echo "<option value='" . $resultado['IdCProducto'] . "'>" . $resultado['IdCProducto'] . "</option>";
                                                }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Por favor, selecciona una opción.
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2">                        
                                    <div class="mb-2">
                                        <label for="ID_Talla" class="form-label">Talla:</label>
                                            <select class="form-select mb-3" id="ID_Talla" name="ID_Talla[]">
                                                <option value="" selected disabled>-- Seleccionar una Talla --</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, Selecciona una Opción.
                                            </div>
                                    </div>
                                </td>
                                <td colspan="2">                        
                                    <div class="mb-2">
                                        <label for="Cantidad" class="form-label">Cantidad:</label>
                                        <input type="text" class="form-control" id="Cantidad" name="Cantidad[]" onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" placeholder="Ingresa la Cantidad">
                                    </div>
                                </td>
                                <td rowspan="2">
                                    <div class="mb-2">
                                        <img src="../../../img/Armar_Requicision.png" alt="Imagen del Producto" id="IMG" width="250" height="350">
                                    </div>
                                </td>
                            </tr>
                            <tr class="fila-fija2" data-id="1">
                                <td>
                                    <div class="mb-2">
                                        <label for="Empresa" class="form-label">Empresa:</label>
                                        <input type="text" class="form-control" id="Empresa" name="Empresa[]" placeholder="Ingresa la Empresa" disabled>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-2">
                                        <label for="Categoria" class="form-label">Categoría:</label>
                                        <input type="text" class="form-control" id="Categoria" name="Categoria[]" placeholder="Ingresa la Categoría" disabled>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-2">
                                        <label for="Descripcion" class="form-label">Descripción:</label>
                                        <input type="text" class="form-control" id="Descripcion" name="Descripcion[]" placeholder="Ingresa la Descripción" disabled>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="mb-2">
                                        <label for="Especificacion" class="form-label">Especificación:</label>
                                        <input type="text" class="form-control" id="Especificacion" name="Especificacion[]" placeholder="Ingresa la Especificación" disabled>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>   
    <!-- Botones -->
    <div class="mb-3">
        <button id="btn_Agregar" type="button" class="btn btn-success">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-text-wrap" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M4 6l16 0" />
                <path d="M4 18l5 0" />
                <path d="M4 12h13a3 3 0 0 1 0 6h-4l2 -2m0 4l-2 -2" />
            </svg>Agregar Producto
        </button>  
        <button type="submit" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                <path d="M16 19h6" />
                <path d="M19 16v6" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
            </svg>Guardar
        </button>
        <a href="../Requisicion_SUPERADMIN.php" class="btn btn-danger">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M4 7l16 0" />
                <path d="M10 11l0 6" />
                <path d="M14 11l0 6" />
                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
            </svg>Cancelar
        </a>
    </div>
    </form>

    <div class="table-responsive">
        <table class="table table-sm table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Codigo</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Especificación</th>
                    <th scope="col">Talla</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Cancelar</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tablaModal" tabindex="-1" aria-labelledby="tablaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tablaModalLabel">Lista de Productos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Buscador -->
                    <input type="text" id="buscador" class="form-control mb-3" placeholder="Buscar producto...">
                    
                    <!-- Tabla -->
                    <table class="table table-responsive table-hover table-striped">
                        <thead>
                            <tr class="table-primary">
                                <th scope="col">Identificador</th>
                                <th scope="col">Nombre de Empresa</th>
                                <th scope="col">Categoría</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Especificación</th>
                            </tr>
                        </thead>
                        <tbody id="tablaCuerpo">
                            <!-- Datos generados dinámicamente -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../../../js/Form_Envio.js"></script>
<script src="../../../js/Solicitud_Carga_CueRegEst.js" defer></script>
<script type="module" src="../../../js/Busqueda_Requision_Productos.js" defer></script>
<script src="../../../js/Insert_Producto_datosTabla.js"></script>
<script src="../../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Insertar_Requisicion.js"></script>
<script src="../../../js/VistaTablaProductos.js"></script>

<?php include('footer.php'); ?>