<?php include('head.php'); ?>

<?php
include('../../../Modelo/Conexion.php'); // Conectar a la base de datos

// Verifica si la variable $_GET['id'] está definida y no es nula
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $ID_Solicitud = $_GET['id'];

    // Realiza la consulta para obtener la información del empleado
    $conexion = (new Conectar())->conexion();

    //Setencia SQL
    $consulta = $conexion->prepare("SELECT * 
                FROM 
                    RequisicionE RE 
                INNER JOIN 
                    Usuario U on RE.IdUsuario = U.ID_Usuario
                INNER JOIN 
                    Cuenta C on RE.IdCuenta = C.ID
                INNER JOIN
                    Regiones R on RE.IdRegion = R.ID_Region
                INNER JOIN 
                    Estados E on RE.IdEstado = E.Id_Estado
                WHERE 
                    RE.IDRequisicionE = ?");

    //Parametros
    $consulta->bind_param("i", $ID_Solicitud);
    $consulta->execute();
    $resultado = $consulta->get_result();

    // Verifica si se encontraron resultados
    if ($row = $resultado->fetch_assoc()) {
        // Ahora, $row contiene la información del empleado que puedes usar en el formulario
        $query = "SELECT RE.IDRequisicionE, RD.IdCProd, RD.IdTalla, RD.Cantidad, P.Descripcion,
                    P.Especificacion, P.IMG, CE.Nombre_Empresa, CT.Talla, CC.Descrp
                    FROM RequisicionD RD
                    INNER JOIN RequisicionE RE on RD.IdReqE = RE.IDRequisicionE
                    INNER JOIN Producto P on RD.IdCProd = P.IdCProducto
                    INNER JOIN CTallas CT on RD.IdTalla = CT.IdCTallas
                    INNER JOIN CCategorias CC on P.IdCCat = CC.IdCCate
                    INNER JOIN CTipoTallas CTT on CT.IdCTipTal = CTT.IdCTipTall
                    INNER JOIN CEmpresas CE on P.IdCEmp = CE.IdCEmpresa
                    WHERE RE.IDRequisicionE = ?";
                    
                    $stmt = $conexion->prepare($query);
                    $stmt->bind_param("i", $ID_Solicitud);
                    $stmt->execute();
            
                    $resultadoConsulta = $stmt->get_result();
    } else {
        // No se encontró ningún empleado con la ID proporcionada, puedes manejar esto según tus necesidades
        echo "No se encontró ningún registro con la ID proporcionada.";
        exit; // Puedes salir del script o redirigir a otra página
    }
} else {
    // La variable $_GET['id'] no está definida o es nula, puedes manejar esto según tus necesidades
    echo "ID de empleado no proporcionada.";
    exit; // Puedes salir del script o redirigir a otra página
}
?>

<div class="container mt-5">
    <center><h2>Modificación Productos de Requisición</h2></center>
    <!-- Formulario -->
    <form id="FormUpdateProductosRequisicion" class="needs-validation" action="../../../Controlador/Usuarios/UPDATE/Funcion_Update_Productos_Requision.php" method="POST" enctype="multipart/form-data" novalidate>

    <input type="hidden" name="ID_RequisicionE" id="ID_RequisicionE" value="<?php echo $row['IDRequisicionE']; ?>">
    <input type="hidden" id="datosTabla" name="datosTabla">

    <div class="accordion" id="accordionExample">
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
                                                    while ($resultado4 = $sql->fetch_assoc()) {
                                                        echo "<option value='" . $resultado4['IdCProducto'] . "'>" . $resultado4['IdCProducto'] . "</option>";
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
        <a href="../Requisicion_ADMIN.php" class="btn btn-danger">
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

    <div class="container mt-5">
        <div class="table-responsive">
            <table class="table table-sm table-dark">
                <thead>
                    <tr>
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
                    <?php
                        // Comprobar si hay resultados antes de continuar
                        if ($resultadoConsulta->num_rows > 0) {
                            // Iterar sobre cada fila de resultados
                            while ($row1 = $resultadoConsulta->fetch_assoc()) {
                    ?>
                        <tr>
                            <!-- Llamamos información de la consulta -->
                            <td><?php echo $row1['IdCProd']; ?></td>
                            <td><?php echo $row1['Nombre_Empresa']; ?></td>
                            <td><?php echo $row1['Descrp']; ?></td>
                            <td><?php echo $row1['Descripcion']; ?></td>
                            <td><?php echo $row1['Especificacion']; ?></td>
                            <td data-id="<?php echo $row1['IdTalla']; ?>"><?php echo $row1['Talla']; ?></td>
                            <td>
                                <input type="text" class="form-control" id="Cantidad" name="Cantidad" value="<?php echo $row1['Cantidad']; ?>" onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" placeholder="Ingresa la Cantidad">
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning btn-anular">
                                Eliminar
                                </button> 
                            </td>
                        </tr>
                    <?php
                            }
                        } else {
                            // Mostrar un mensaje si no hay resultados
                            echo "<tr><td colspan='8'>No se encontraron productos.</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
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

<script src="../../../js/Solicitud_Carga_CueRegEst.js" defer></script>
<script type="module" src="../../../js/Busqueda_Requision_Productos.js" defer></script>
<script src="../../../js/Update_Productos_Requisicion_datosTabla.js"></script>
<script src="../../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Update_Productos_Requisicion.js"></script>
<script src="../../../js/VistaTablaProductos.js"></script>

<?php include('footer.php'); ?>