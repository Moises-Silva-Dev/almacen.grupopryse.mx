<?php
// Incluir el archivo de Loguearse.php
include(__DIR__ . '/../../../Modelo/Loguearse2.php');

// Verificar si se solicita cerrar sesión
if(isset($_GET['cerrar_sesion'])) {
    // Destruir la sesión
    session_destroy(); 
    // Redirigir al usuario a la página de inicio de sesión
    header("Location: ../../index.php"); 
    exit();
}
?>

<?php
include('../../../Modelo/Conexion.php');

// Verifica si la variable $_GET['id'] está definida y no es nula
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $Id_producto = $_GET['id'];

    // Realiza la consulta para obtener la información del empleado
    $conexion = (new Conectar())->conexion();
    $consulta = $conexion->prepare("SELECT * FROM Producto P
    INNER JOIN CEmpresas CE on P.IdCEmp = CE.IdCEmpresa
    INNER JOIN CCategorias CC on P.IdCCat = CC.IdCCate
    INNER JOIN CTipoTallas CTT on P.IdCTipTal = CTT.IdCTipTall WHERE IdCProducto = ?");
    $consulta->bind_param("i", $Id_producto);
    $consulta->execute();
    $resultado = $consulta->get_result();

    // Verifica si se encontraron resultados
    if ($row = $resultado->fetch_assoc()) {
        // Ahora, $row contiene la información del empleado que puedes usar en el formulario
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
    <!-- Tu hoja de estilos personalizada -->
    <link href="#" rel="stylesheet">

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
            <a class="navbar-brand" href="../index_SUPERADMIN.php">Inicio
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

<div class="container mt-4">
    <div class="row">
        <!-- Card con la imagen -->
        <div class="col-md-6">
            <div class="card border-secondary">
                <img src="<?php echo $row['IMG']; ?>" class="card-img" alt="Imagen del Producto">
            </div>
        </div>

        <!-- Card con la información -->
        <div class="col-md-6">
            <div class="card border-info">
                <div class="card-body text-white bg-info mb-6" style="max-width: 300rem;">
                    <div class="card-header">
                        <h4 class="card-title">Empresa: <?php echo $row['Nombre_Empresa']; ?></h4>
                    </div>
                </div>
                <ul class="list-group list-group-flush ">
                    <li class="list-group-item"><p class="card-text">Descripción: <?php echo $row['Descripcion']; ?></p></li>
                    <li class="list-group-item"><p class="card-text">Especificación: <?php echo $row['Especificacion']; ?></p></li>
                    <li class="list-group-item"><p class="card-text">Nombre de la Empresa: <?php echo $row['Nombre_Empresa']; ?></p></li>
                    <li class="list-group-item"><p class="card-text">Categoría: <?php echo $row['Descrp']; ?></p></li>
                    <li class="list-group-item"><p class="card-text">Tipo de Talla: <?php echo $row['Descrip']; ?></p></li>
                </ul>
            </div>
        </div>
    </div>

    <br>

    <center>
        <a href="../Producto_SUPERADMIN.php" class="btn btn-danger">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-backspace" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z"/>
                <path d="M20 6a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-11l-5 -5a1.5 1.5 0 0 1 0 -2l5 -5z" />
                <path d="M12 10l4 4m0 -4l-4 4" />
            </svg>REGRESAR
        </a>
    </center>
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

</body>
</html>