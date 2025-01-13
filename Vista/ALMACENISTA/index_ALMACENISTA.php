<?php
// Incluir el archivo de Loguearse.php
include('../../Modelo/Loguearse.php');

// Verificar si se solicita cerrar sesión
if(isset($_GET['cerrar_sesion'])) {
    // Destruir la sesión
    session_destroy(); 
    // Redirigir al usuario a la página de inicio de sesión
    header("Location: ../../index.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Usuario Almacenista</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../../css/Index_DEV.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../img/2.png">
</head>
<body>
<!-- Contenedor de las alertas -->
<div id="toastContainer" style="position: fixed; top: 20px; right: 20px; z-index: 1050; max-height: 600px; overflow-y: auto; width: 800px;"></div>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index_ALMACENISTA.php">Inicio
                <img src="../../img/ALMACENISTA.png" alt="Perfil" class="rounded-circle me-2" style="width: 40px; height: 40px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-pentagon" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M13.163 2.168l8.021 5.828c.694 .504 .984 1.397 .719 2.212l-3.064 9.43a1.978 1.978 0 0 1 -1.881 1.367h-9.916a1.978 1.978 0 0 1 -1.881 -1.367l-3.064 -9.43a1.978 1.978 0 0 1 .719 -2.212l8.021 -5.828a1.978 1.978 0 0 1 2.326 0z" />
                            <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" />
                            <path d="M6 20.703v-.703a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.707" />
                        </svg></a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <?php
                                include('../../Modelo/Conexion.php');
                                $conexion = (new Conectar())->conexion();
                        
                                if (isset($_SESSION['usuario'])) {
                                    $usuario = $_SESSION['usuario'];
                                    $sql = "SELECT 
                                                U.Nombre, U.Apellido_Paterno, U.Apellido_Materno,
                                                U.Correo_Electronico, TU.Tipo_Usuario,
                                                COALESCE(C.NombreCuenta, 'N/A') AS NombreCuenta
                                            FROM 
                                                Usuario U
                                            INNER JOIN 
                                                Tipo_Usuarios TU ON U.ID_Tipo_Usuario = TU.ID
                                            INNER JOIN 
                                                Usuario_Cuenta UC ON U.ID_Usuario = UC.ID_Usuarios
                                            LEFT JOIN
                                                Cuenta C ON UC.ID_Cuenta = C.ID
                                            WHERE 
                                                U.Correo_Electronico = ?;";
                                                
                                    $stmt = $conexion->prepare($sql);
                                    $stmt->bind_param("s", $usuario);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                        
                                    if ($row = $result->fetch_assoc()) {
                                        echo '<p class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-walk" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M13 4m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                    <path d="M7 21l3 -4" />
                                                    <path d="M16 21l-2 -4l-3 -3l1 -6" />
                                                    <path d="M6 12l2 -3l4 -1l3 3l3 1" />
                                                </svg><strong>Nombre: </strong><br>' . $row['Nombre'] . ' ' . $row['Apellido_Paterno'] . ' ' . $row['Apellido_Materno'] . ' </p>';
                                        echo '<p class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-circle" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                    <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                    <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                                </svg><strong>Rol: </strong><br>' . $row['Tipo_Usuario'] . '</strong></p>';
                                            if (!empty($row['NombreCuenta']) && $row['NombreCuenta'] !== 'N/A') {
                                                echo '<p class="dropdown-item">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                                    </svg><strong>Cuenta: <br>' . $row['NombreCuenta'] . '</strong></p>';
                                            }
                                        } else {
                                            echo '<p>No se encontraron datos del usuario.</p>';
                                        }
                                        $stmt->close();
                                    } else {
                                        echo '<p>No se ha iniciado sesión.</p>';
                                    }
                                ?>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <button id="notificationButton" onclick="mostrarNotificacion()">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <path fill="currentColor" d="M20 17h2v2H2v-2h2v-7a8 8 0 1 1 16 0v7zm-2 0v-7a6 6 0 1 0-12 0v7h12zm-9 4h6v2H9v-2z"></path>
                            </svg>
                            <div class="dot" id="notificationDot" style="display: none; width: 10px; height: 10px; background: red; border-radius: 50%; position: absolute; top: 5px; right: 5px;"></div>
                        </button>
                    </li>
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
        <div class="card-container">
            <!-- Tus tarjetas aquí -->
            <div class="card">
                <figure>
                    <img src="../../img/img5.png">
                </figure>
            
                <div class="contenido2">
                    <h3 class="titulo">Gestión de Entradas de Artículos</h3>
                </div>
                    
                <a class="boton" href="Almacen_ALMACENISTA.php">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-arrow-right-filled" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 2l.324 .005a10 10 0 1 1 -.648 0l.324 -.005zm.613 5.21a1 1 0 0 0 -1.32 1.497l2.291 2.293h-5.584l-.117 .007a1 1 0 0 0 .117 1.993h5.584l-2.291 2.293l-.083 .094a1 1 0 0 0 1.497 1.32l4 -4l.073 -.082l.064 -.089l.062 -.113l.044 -.11l.03 -.112l.017 -.126l.003 -.075l-.007 -.118l-.029 -.148l-.035 -.105l-.054 -.113l-.071 -.111a1.008 1.008 0 0 0 -.097 -.112l-4 -4z" stroke-width="0" fill="currentColor" />
                    </svg>Comenzar</a>
            </div>
                
            <!-- Card numero 2 -->
            <div class="card">
                <figure>
                    <img src="../../img/img2.png">
                </figure>
                
                <div class="contenido2">
                    <h3 class="titulo">Gestión de Productos</h3>
                </div>
                
                <a class="boton" href="Producto_ALMACENISTA.php">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-arrow-right-filled" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 2l.324 .005a10 10 0 1 1 -.648 0l.324 -.005zm.613 5.21a1 1 0 0 0 -1.32 1.497l2.291 2.293h-5.584l-.117 .007a1 1 0 0 0 .117 1.993h5.584l-2.291 2.293l-.083 .094a1 1 0 0 0 1.497 1.32l4 -4l.073 -.082l.064 -.089l.062 -.113l.044 -.11l.03 -.112l.017 -.126l.003 -.075l-.007 -.118l-.029 -.148l-.035 -.105l-.054 -.113l-.071 -.111a1.008 1.008 0 0 0 -.097 -.112l-4 -4z" stroke-width="0" fill="currentColor" />
                    </svg>Comenzar</a>
            </div>
                
            <!-- Card numero 3 -->
            <div class="card">
                <figure>
                    <img src="../../img/img4.png">
                </figure>
                        
                <div class="contenido2">
                    <h3 class="titulo">Gestión de Salidas de Almacén</h3>
                </div>
                        
                <a class="boton" href="Salidas_ALMACENISTA.php">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-arrow-right-filled" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 2l.324 .005a10 10 0 1 1 -.648 0l.324 -.005zm.613 5.21a1 1 0 0 0 -1.32 1.497l2.291 2.293h-5.584l-.117 .007a1 1 0 0 0 .117 1.993h5.584l-2.291 2.293l-.083 .094a1 1 0 0 0 1.497 1.32l4 -4l.073 -.082l.064 -.089l.062 -.113l.044 -.11l.03 -.112l.017 -.126l.003 -.075l-.007 -.118l-.029 -.148l-.035 -.105l-.054 -.113l-.071 -.111a1.008 1.008 0 0 0 -.097 -.112l-4 -4z" stroke-width="0" fill="currentColor" />
                    </svg>Comenzar</a>
            </div>
                
            <!-- Card numero 4 -->
            <div class="card">
                <figure>
                    <img src="../../img/img11.png">
                </figure>
                        
                <div class="contenido2">
                    <h3 class="titulo">Reportes Graficos</h3>
                </div>
                
                <a class="boton" href="Reportes_ALMACENISTA.php">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-arrow-right-filled" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 2l.324 .005a10 10 0 1 1 -.648 0l.324 -.005zm.613 5.21a1 1 0 0 0 -1.32 1.497l2.291 2.293h-5.584l-.117 .007a1 1 0 0 0 .117 1.993h5.584l-2.291 2.293l-.083 .094a1 1 0 0 0 1.497 1.32l4 -4l.073 -.082l.064 -.089l.062 -.113l.044 -.11l.03 -.112l.017 -.126l.003 -.075l-.007 -.118l-.029 -.148l-.035 -.105l-.054 -.113l-.071 -.111a1.008 1.008 0 0 0 -.097 -.112l-4 -4z" stroke-width="0" fill="currentColor" />
                    </svg>Comenzar</a>
            </div>
        </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <script src="../../js/Notificacion_Alert_Inventario.js"></script>
  </script>
</body>
</html>