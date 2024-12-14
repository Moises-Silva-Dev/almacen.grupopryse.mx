<?php
// Incluir el archivo de Loguearse.php
include(__DIR__ . '/../../../Modelo/Loguearse2.php');

// Verificar si se solicita cerrar sesión
if(isset($_GET['cerrar_sesion'])) {
    // Destruir la sesión
    session_destroy(); 
    // Redirigir al usuario a la página de inicio de sesión
    header("Location: ../../../index.php"); 
    exit();
}
?>

<?php
include('../../../Modelo/Conexion.php');

// Verifica si la variable $_GET['id'] está definida y no es nula
if (isset($_GET['id']) && !empty($_GET['id'])) {  
    $Id = $_GET['id'];

    // Realiza la consulta para obtener la información del empleado
    $conexion = (new Conectar())->conexion();
    $consulta = $conexion->prepare("SELECT * FROM RequisicionE RE 
        INNER JOIN Usuario U on RE.IdUsuario = U.ID_Usuario
        INNER JOIN Cuenta C on RE.IdCuenta = C.ID
        INNER JOIN Regiones R on RE.IdRegion = R.ID_Region
        INNER JOIN Estados E on RE.IdEstado = E.Id_Estado
    WHERE RE.IDRequisicionE = ?;");
        
    $consulta->bind_param("i", $Id);
    $consulta->execute();
    $resultado = $consulta->get_result();

    // Verifica si se encontraron resultados
    if ($row = $resultado->fetch_assoc()) {
        // Ahora, $row contiene la información del empleado que puedes usar en el formulario
        $query = "SELECT 
                    P.IdCProducto AS Producto_ID,
                    P.IMG AS Imagen_Producto,
                    CE.Nombre_Empresa AS Empresa,
                    P.Descripcion AS Descripcion_Producto,
                    P.Especificacion AS Especificacion_Producto,
                    CC.Descrp AS Categoria,
                    CT.Talla AS Talla,
                    RD.Cantidad AS Cantidad_Solicitada,
                    IFNULL(SUM(SD.Cantidad), 0) AS Cantidad_Salida
                FROM 
                    RequisicionE RE
                INNER JOIN 
                    RequisicionD RD ON RD.IdReqE = RE.IDRequisicionE
                LEFT JOIN 
                    Salida_E SE ON RE.IDRequisicionE = SE.ID_ReqE
                LEFT JOIN 
                    Salida_D SD ON SE.Id_SalE = SD.Id AND SD.IdCProd = RD.IdCProd AND SD.IdTallas = RD.IdTalla
                INNER JOIN 
                    Producto P ON RD.IdCProd = P.IdCProducto
                INNER JOIN 
                    CTallas CT ON RD.IdTalla = CT.IdCTallas
                INNER JOIN 
                    CCategorias CC ON P.IdCCat = CC.IdCCate
                INNER JOIN 
                    CTipoTallas CTT ON CT.IdCTipTal = CTT.IdCTipTall
                INNER JOIN 
                    CEmpresas CE ON P.IdCEmp = CE.IdCEmpresa
                WHERE 
                    RE.IDRequisicionE = ?
                GROUP BY 
                    RE.IDRequisicionE, P.IdCProducto, P.IMG, CE.Nombre_Empresa, 
                    P.Descripcion, P.Especificacion, CC.Descrp, CT.Talla, RD.Cantidad;";
        
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $Id);
        $stmt->execute();

        $resultadoConsulta = $stmt->get_result();

    } else {
        // No se encontró ningún empleado con la ID proporcionada, puedes manejar esto según tus necesidades
        echo "No se encontró ningún registro con la ID proporcionada.";
        exit; // Puedes salir del script o redirigir a otra página
    }
} else {
    // La variable $_GET['id'] no está definida o es nula, puedes manejar esto según tus necesidades
    echo "ID de producto no proporcionada.";
    exit; // Puedes salir del script o redirigir a otra página
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invertario</title>
    <!-- Enlace a la hoja de estilos de Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background: #bae0f5;
    }
</style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../index_USER.php">Inicio
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-assembly" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M19.875 6.27a2.225 2.225 0 0 1 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" />
                    <path d="M15.5 9.422c.312 .18 .503 .515 .5 .876v3.277c0 .364 -.197 .7 -.515 .877l-3 1.922a1 1 0 0 1 -.97 0l-3 -1.922a1 1 0 0 1 -.515 -.876v-3.278c0 -.364 .197 -.7 .514 -.877l3 -1.79c.311 -.174 .69 -.174 1 0l3 1.79h-.014z" />
                </svg></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="?cerrar_sesion=true">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                <path d="M9 12h12l-3 -3" />
                                <path d="M18 15l3 -3" />
                            </svg>Cerrar Sesion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
    <center><h2>Solicitud</h2></center>
    <!-- Formulario -->
<input type="hidden" id="Id" name="Id" value="<?php echo $row['IDRequisicionE'] ?>">

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
                <input type="text" class="form-control" value="<?php echo $row['Supervisor'] ?>" disabled>
            </div>
            
            <div class="mb-3">
                <label for="Supervisor" class="form-label">Cuenta:</label>
                <input type="text" class="form-control" value="<?php echo $row['NombreCuenta'] ?>" disabled>
            </div>
            
            <div class="mb-3">
                <label for="Region" class="form-label">Región:</label>
                <input type="text" class="form-control" value="<?php echo $row['Nombre_Region'] ?>" disabled>
            </div>

            <div class="mb-3">
                <label for="CentroTrabajo" class="form-label">Centro de Trabajo:</label>
                <input type="text" class="form-control" value="<?php echo $row['CentroTrabajo'] ?>" disabled>
            </div>
            
            <div class="mb-3">
                <label for="NroElementos" class="form-label">Numero de Elementos:</label>
                <input type="text" class="form-control" value="<?php echo $row['NroElementos']  ?>" disabled>
            </div>

            <div class="mb-3">
                <label for="Receptor" class="form-label">Nombre del Receptor:</label>
                <input type="text" class="form-control" value="<?php echo $row['Receptor'] ?>" disabled>
            </div>

            <div class="mb-3">
                <label for="num_tel" class="form-label">Número de Teléfono del Receptor:</label>
                <input type="tel" class="form-control" value="<?php echo $row['TelReceptor'] ?>" disabled>
            </div>

            <div class="mb-3">
                <label for="RFC" class="form-label">RFC del Receptor:</label>
                <input type="text" class="form-control" value="<?php echo $row['RfcReceptor'] ?>" disabled>
            </div>

            <div class="mb-3">
                <label for="RFC" class="form-label">Justificación:</label>
                <input type="text" class="form-control" value="<?php echo $row['Justificacion'] ?>" disabled>
            </div>
            
            <div class="mb-3">
                <label for="RFC" class="form-label">Dirección:</label>
                <?php
                $direccion = "";
                
                // Concatenar los valores si están definidos y no están vacíos
                if (!empty(trim($row['Mpio']))) {
                    $direccion .= "{$row['Mpio']}, ";
                }
                if (!empty(trim($row['Colonia']))) {
                    $direccion .= "{$row['Colonia']}, ";
                }
                if (!empty(trim($row['Calle']))) {
                    $direccion .= "{$row['Calle']} {$row['Nro']}, ";
                }
                if (!empty(trim($row['CP']))) {
                    $direccion .= "{$row['CP']}, ";
                }
                if (!empty(trim($row['Nombre_estado']))) {
                    $direccion .= "{$row['Nombre_estado']}";
                }
                
                // Eliminar la última coma y espacios si están presentes
                $direccion = rtrim($direccion, ', ');
            
                // Mostrar la dirección si hay información
                if (!empty(trim($direccion))) {
                    echo '<input type="text" class="form-control" value="' . htmlspecialchars($direccion) . '" disabled>';
                } else {
                    echo '<input type="text" class="form-control" value="No disponible" disabled>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="table-responsive">
        <table class="table table-sm table-dark">
            <thead>
                <tr>
                    <th scope="col">Empresa</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Especificación</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Talla</th>
                    <th scope="col">Cantidad Solicitada</th>
                    <th scope="col">Cantidad Entregada</th>
                    <th scope="col">IMG</th>
                    <th></th>
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
                        <td><?php echo $row1['Empresa']; ?></td>
                        <td><?php echo $row1['Descripcion_Producto']; ?></td>
                        <td><?php echo $row1['Especificacion_Producto']; ?></td>
                        <td><?php echo $row1['Categoria']; ?></td>
                        <td><?php echo $row1['Talla']; ?></td>
                        <td><?php echo $row1['Cantidad_Solicitada']; ?></td>
                        <td><?php echo $row1['Cantidad_Salida']; ?></td>
                        <td><img src="<?php echo $row1['Imagen_Producto']; ?>" alt="Imagen" width="20" height="20"></td>
                        <td>
                            <button type="button" class="btn btn-info btnVisualizarImagen" data-toggle="modal" data-target="#infoModal" 
                                    data-empresa="<?php echo $row1['Empresa']; ?>" 
                                    data-descripcion="<?php echo $row1['Descripcion_Producto']; ?>" 
                                    data-especificacion="<?php echo $row1['Especificacion_Producto']; ?>" 
                                    data-categoria="<?php echo $row1['Categoria']; ?>" 
                                    data-talla="<?php echo $row1['Talla']; ?>" 
                                    data-cantidad="<?php echo $row1['Cantidad_Solicitada']; ?>" 
                                    data-salida="<?php echo $row1['Cantidad_Salida']; ?>" 
                                    data-img="<?php echo $row1['Imagen_Producto']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M11.102 17.957c-3.204 -.307 -5.904 -2.294 -8.102 -5.957c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6a19.5 19.5 0 0 1 -.663 1.032" />
                                    <path d="M15 19l2 2l4 -4" />
                                </svg>
                                Visualizar
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

            <!-- Botones -->
                <center><div class="mb-3">                
                <a href="../Ver_USER.php" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-receipt-refund" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                      <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2" />
                      <path d="M15 14v-2a2 2 0 0 0 -2 -2h-4l2 -2m0 4l-2 -2" />
                    </svg>Regresar
                </a>
            </div></center>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Información de la Fila</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí se mostrará la información de la fila -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

    <!-- Pie de página -->
    <footer class="bg-dark text-white text-center p-3 mt-4">
        <p>&copy; 2023 Tu Sitio. Todos los derechos reservados.</p>
    </footer>

    <!-- Scripts de Bootstrap (Requiere Popper.js y jQuery) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../../../js/Vista_Previa_Producto.js"></script>
</body>
</html>