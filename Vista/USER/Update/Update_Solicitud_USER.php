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
                    Borrador_RequisicionE RE 
                INNER JOIN 
                    Usuario U on RE.BIdUsuario = U.ID_Usuario
                INNER JOIN 
                    Cuenta C on RE.BIdCuenta = C.ID
                INNER JOIN
                    Regiones R on RE.BIdRegion = R.ID_Region
                INNER JOIN 
                    Estados E on RE.BIdEstado = E.Id_Estado
                WHERE 
                    RE.BIDRequisicionE = ?");

    //Parametros
    $consulta->bind_param("i", $ID_Solicitud);
    $consulta->execute();
    $resultado = $consulta->get_result();

    // Verifica si se encontraron resultados
    if ($row = $resultado->fetch_assoc()) {
        // Ahora, $row contiene la información del empleado que puedes usar en el formulario
        $query = "SELECT RE.BIDRequisicionE, RD.BIdCProd, RD.BIdTalla, RD.BCantidad, P.Descripcion,
                    P.Especificacion, P.IMG, CE.Nombre_Empresa, CT.Talla, CC.Descrp
                    FROM Borrador_RequisicionD RD
                    INNER JOIN Borrador_RequisicionE RE on RD.BIdReqE = RE.BIDRequisicionE
                    INNER JOIN Producto P on RD.BIdCProd = P.IdCProducto
                    INNER JOIN CTallas CT on RD.BIdTalla = CT.IdCTallas
                    INNER JOIN CCategorias CC on P.IdCCat = CC.IdCCate
                    INNER JOIN CTipoTallas CTT on CT.IdCTipTal = CTT.IdCTipTall
                    INNER JOIN CEmpresas CE on P.IdCEmp = CE.IdCEmpresa
                    WHERE RE.BIDRequisicionE = ?";
                    
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
    <center><h2>Modificacón Solicitud</h2></center>
    <!-- Formulario -->
    <form id="FormUpdateRequisicion" class="needs-validation" action="../../../Controlador/Usuarios/UPDATE/Funcion_Update_Borrador_Requision.php" method="POST" enctype="multipart/form-data" novalidate>

    <input type="hidden" name="ID_RequisicionE" id="ID_RequisicionE" value="<?php echo $row['BIDRequisicionE']; ?>">
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
                            <label for="Supervisor" class="form-label">Supervisor:</label>
                            <input type="text" class="form-control" id="Supervisor" name="Supervisor" value="<?php echo $row['BSupervisor']  ?>" placeholder="Ingresa el Nombre del Supervisor" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 32)" required>
                            <div class="invalid-feedback">
                                Por favor, ingresa el nombre del Supervisor.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="ID_Cuenta" class="form-label">Cuenta:</label>
                            <select class="form-select mb-3" id="ID_Cuenta" name="ID_Cuenta" required>
                                <option value="" selected disabled>-- Seleccionar Cuenta --</option>
                                    <?php
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
                
                                        while ($resultado = $result->fetch_assoc()) {
                                            $selected = ($row['BIdCuenta'] == $resultado['ID']) ? 'selected' : '';
                                            echo "<option value='" . htmlspecialchars($resultado['ID']) . "' $selected>" . htmlspecialchars($resultado['NombreCuenta']) . "</option>";
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
                            <label for="Region" class="form-label">Región:</label>
                            <select class="form-select mb-3" id="Region" name="Region" required>
                                <option value="" selected disabled>-- Seleccionar Región --</option>
                                    <?php
                                        // Preparar la consulta
                                        $stmt1 = $conexion->prepare("SELECT R.ID_Region, R.Nombre_Region 
                                                    FROM 
                                                        Usuario U
                                                    INNER JOIN 
                                                        Usuario_Cuenta UC ON U.ID_Usuario = UC.ID_Usuarios
                                                    INNER JOIN
                                                        Cuenta C ON UC.ID_Cuenta = C.ID
                                                    INNER JOIN 
                                                        Cuenta_Region CR ON C.ID = CR.ID_Cuentas
                                                    INNER JOIN 
                                                        Regiones R ON CR.ID_Regiones = R.ID_Region
                                                    WHERE 
                                                        U.Correo_Electronico = ?");
                                                        
                                        // Vincular parámetros
                                        $stmt1->bind_param("s", $usuario);
                                        $stmt1->execute();
                                        $result1 = $stmt1->get_result();

                                        while ($resultado1 = $result1->fetch_assoc()) {
                                            $selected1 = ($row['BIdRegion'] == $resultado1['ID_Region']) ? 'selected' : '';
                                            echo "<option value='" . htmlspecialchars($resultado1['ID_Region']) . "' $selected1>" . htmlspecialchars($resultado1['Nombre_Region']) . "</option>";
                                        }

                                        // Cerrar la declaración
                                        $stmt1->close();
                                    ?>
                            </select>
                            <div class="invalid-feedback">
                                Por favor, selecciona una opción.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="CentroTrabajo" class="form-label">Centro de Trabajo:</label>
                            <input type="text" class="form-control" id="CentroTrabajo" name="CentroTrabajo" value="<?php echo $row['BCentroTrabajo']  ?>" placeholder="Ingresa el Nombre del Centro de Trabajo">
                            <div class="invalid-feedback">
                                Por favor, ingresa el nombre del Centro de Trabajo.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="NroElementos" class="form-label">Numero de Elementos:</label>
                            <input type="text" class="form-control" id="NroElementos" name="NroElementos" value="<?php echo $row['BNroElementos']  ?>" placeholder="Ingresa el Numero de Elementos" onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" required>
                            <div class="invalid-feedback">
                                Por favor, ingresa el numero de Elementos.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Estado" class="form-label">Estado:</label>
                            <select class="form-select mb-3" id="Estado" name="Estado" required>
                                <option value="" selected disabled>-- Seleccionar Estado --</option>
                                    <?php
                                        // Preparar la consulta
                                        $stmt2 = $conexion->prepare("SELECT E.Id_Estado, E.Nombre_estado 
                                                    FROM 
                                                        Usuario U
                                                    INNER JOIN 
                                                        Usuario_Cuenta UC ON U.ID_Usuario = UC.ID_Usuarios
                                                    INNER JOIN
                                                        Cuenta C ON UC.ID_Cuenta = C.ID
                                                    INNER JOIN 
                                                        Cuenta_Region CR ON C.ID = CR.ID_Cuentas
                                                    INNER JOIN 
                                                        Regiones R ON CR.ID_Regiones = R.ID_Region
                                                    INNER JOIN 
                                                        Estado_Region ER ON R.ID_Region = ER.ID_Regiones
                                                    INNER JOIN 
                                                        Estados E ON ER.ID_Estados = E.Id_Estado
                                                    WHERE
                                                        U.Correo_Electronico = ?");
                                                        
                                        // Vincular parámetros
                                        $stmt2->bind_param("s", $usuario);
                                        $stmt2->execute();
                                        $result2 = $stmt2->get_result();

                                        while ($resultado2 = $result2->fetch_assoc()) {
                                            $selected2 = ($row['BIdEstado'] == $resultado2['Id_Estado']) ? 'selected' : '';
                                            echo "<option value='" . htmlspecialchars($resultado2['Id_Estado']) . "' $selected2>" . htmlspecialchars($resultado2['Nombre_estado']) . "</option>";
                                        }

                                        // Cerrar la declaración
                                        $stmt2->close();
                                    ?>
                            </select>
                            <div class="invalid-feedback">
                                Por favor, selecciona una opción.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Receptor" class="form-label">Nombre del Receptor:</label>
                            <input type="text" class="form-control" id="Receptor" name="Receptor" value="<?php echo $row['BReceptor']  ?>" placeholder="Ingresa el Nombre del Receptor" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 32)" required>
                            <div class="invalid-feedback">
                                Por favor, ingresa el Nombre del Receptor.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="num_tel" class="form-label">Número de Teléfono del Receptor:</label>
                            <input type="tel" class="form-control" id="num_tel" name="TelReceptor" value="<?php echo $row['BTelReceptor']  ?>" placeholder="Ingresa el Numero de Telefono del Receptor" onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" required>
                            <div class="invalid-feedback">
                                Por favor, ingresa tu Numero de Telefono.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="RFC" class="form-label">RFC del Receptor:</label>
                            <input type="text" class="form-control" id="RFC" name="RfcReceptor" value="<?php echo $row['BRfcReceptor']  ?>" maxlength="13" placeholder="Ingresa el RFC del Receptor">
                            <div class="invalid-feedback">
                                Por favor, ingresa tu RFC.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Justificacion" class="form-label">Justificación:</label>
                            <textarea name="Justificacion" id="Justificacion" class="form-control" placeholder="Ingresa la Justificación" required><?php echo $row['BJustificacion'];  ?></textarea>
                            <div class="invalid-feedback">
                                Por favor, ingresa la Justificación.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Opcion" class="form-label">¿Enviar a Domicilio?</label>
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
                            <input type="text" class="form-control" id="Mpio" name="Mpio" value="<?php echo $row['BMpio']  ?>" placeholder="Ingresa el Municipio">
                            <div class="invalid-feedback">
                                Por favor, ingresa el Municipio.
                            </div>
                        <br>
                            <label for="Colonia" class="form-label">Colonia:</label>
                            <input type="text" class="form-control" id="Colonia" name="Colonia" value="<?php echo $row['BColonia']  ?>" placeholder="Ingresa la Colonia">
                            <div class="invalid-feedback">
                                Por favor, ingresa la colonia.
                            </div>
                        <br>
                            <label for="Calle" class="form-label">Calle:</label>
                            <input type="text" class="form-control" id="Calle" name="Calle" value="<?php echo $row['BCalle']  ?>" placeholder="Ingresa el Nombre de la Calle">
                            <div class="invalid-feedback">
                                Por favor, ingresa el nombre de la calle.
                            </div>
                        <br>            
                            <label for="Nro" class="form-label">Numero de Casa:</label>
                            <input type="text" class="form-control" id="Nro" name="Nro" value="<?php echo $row['BNro']  ?>" placeholder="Ingresa el Numero de Casa">
                            <div class="invalid-feedback">
                                Por favor, ingresa el numero de casa.
                            </div>
                        <br>
                            <label for="CP" class="form-label">Codigo Postal:</label>
                            <input type="text" class="form-control" id="CP" name="CP" value="<?php echo $row['BCP']  ?>" placeholder="Ingresa el Codigo Postal" maxlength="5" onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;">
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
                                    <div class="mb-3">
                                        <label for="ID_Talla" class="form-label">Talla:</label>
                                            <select class="form-select mb-3" id="ID_Talla" name="ID_Talla[]">
                                                <option value="" selected disabled>-- Seleccionar una Talla --</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, Selecciona una Opción.
                                            </div>
                                    </div>
                                </td>
                                <td>                        
                                    <div class="mb-2">
                                        <label for="Cantidad" class="form-label">Cantidad:</label>
                                        <input type="text" class="form-control" id="Cantidad" name="Cantidad[]" onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" placeholder="Ingresa la Cantidad">
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-2">
                                        <button type="button" class="btn btn-info" id="btnMostrarImagen">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-check" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                <path d="M11.102 17.957c-3.204 -.307 -5.904 -2.294 -8.102 -5.957c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6a19.5 19.5 0 0 1 -.663 1.032" />
                                                <path d="M15 19l2 2l4 -4" />
                                            </svg>Mostrar Imagen
                                        </button>
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
        <a href="../Solicitud_USER.php" class="btn btn-danger">
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
    <div class="modal" tabindex="-1" role="dialog" id="modalImagen">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Imagen del Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <center><img src="" alt="Imagen del Producto" id="imagenProducto" style="max-width: 100%;"></center>
                    </div>
                    <br>
                    <div>
                        <h6>Descripción:</h6>
                        <p id="descripcionProducto"></p>
                    </div>
                    <div>
                        <h6>Especificación:</h6>
                        <p id="especificacionProducto"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                            <td><?php echo $row1['BIdCProd']; ?></td>
                            <td><?php echo $row1['Nombre_Empresa']; ?></td>
                            <td><?php echo $row1['Descrp']; ?></td>
                            <td><?php echo $row1['Descripcion']; ?></td>
                            <td><?php echo $row1['Especificacion']; ?></td>
                            <td data-id="<?php echo $row1['BIdTalla']; ?>"><?php echo $row1['Talla']; ?></td>
                            <td><?php echo $row1['BCantidad']; ?></td>
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

<script src="../../../js/Form_Envio.js"></script>
<script src="../../../js/Solicitud_Carga_CueRegEst.js" defer></script>
<script type="module" src="../../../js/Busqueda_Requision_Productos.js" defer></script>
<script src="../../../js/Update_Producto_datosTabla.js"></script>
<script src="../../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Update_Requisicion.js"></script>
<script src="../../../js/VistaTablaProductos.js"></script>

<?php include('footer.php'); ?>