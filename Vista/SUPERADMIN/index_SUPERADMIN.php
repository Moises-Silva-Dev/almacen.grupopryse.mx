<?php
include('../../Modelo/Loguearse.php'); // Incluir el archivo de Loguearse.php
if(isset($_GET['cerrar_sesion'])) { // Verificar si se solicita cerrar sesión
    session_destroy(); // Destruir la sesión
    header("Location: ../../index.php"); // Redirigir al usuario a la página de inicio de sesión
    exit(); // Finalizar la ejecución del script
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Usuario Programador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Chart.js adapter for Luxon -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Luxon date library -->
    <script src="https://cdn.jsdelivr.net/npm/luxon@3/build/global/luxon.min.js"></script>
    <link href="../../css/principal.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../img/2.png">
</head>
<body>
    <div class="container">
        <!-- Navbar Horizontal -->
        <nav class="navbar-horizontal">
            <div class="logo">
                <p><a style="color: white" href="index_SUPERADMIN.php">Inicio</a></p>
            </div>
            <div class="user-section">
                <button id="notificationButton" onclick="mostrarNotificacion()"> 
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path fill="currentColor" d="M20 17h2v2H2v-2h2v-7a8 8 0 1 1 16 0v7zm-2 0v-7a6 6 0 1 0-12 0v7h12zm-9 4h6v2H9v-2z"></path>
                    </svg>
                    <div class="dot" id="notificationDot"></div>
                </button>
                <a id="logout-btn" class="btn-logout" href="?cerrar_sesion=true">
                    <i class="fas fa-sign-out-alt"></i>Salir
                </a>
                <button id="menu-toggle" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </nav>
        <!-- Navbar Vertical -->
        <nav class="navbar-vertical" id="navbar-vertical">
            <div class="user-profile">
                <?php            
                    include('../../Modelo/Conexion.php'); // Incluir la conexión
                    if (isset($_SESSION['usuario'])) { // Verificar si hay una sesión activa
                        $conexion = (new Conectar())->conexion(); // Crear una instancia de la conexión
                        $usuario = $_SESSION['usuario']; // Obtener el usuario de la sesión
                        
                        try {
                            // Consulta SQL para obtener los datos del usuario
                            $sql = "SELECT 
                                        U.Nombre, U.Apellido_Paterno, U.Apellido_Materno,
                                        U.Correo_Electronico, TU.Tipo_Usuario,
                                        COALESCE(C.NombreCuenta, 'N/A') AS NombreCuenta
                                    FROM 
                                        Usuario U
                                    INNER JOIN 
                                        Tipo_Usuarios TU ON U.ID_Tipo_Usuario = TU.ID
                                    LEFT JOIN
                                        Usuario_Cuenta UC ON U.ID_Usuario = UC.ID_Usuarios
                                    LEFT JOIN
                                        Cuenta C ON UC.ID_Cuenta = C.ID
                                    WHERE 
                                        U.Correo_Electronico = ?";
                            
                            $stmt = $conexion->prepare($sql); // Preparar la consulta SQL
                            
                            if (!$stmt) {
                                throw new Exception("Error al preparar la consulta.");
                            }
                            
                            $stmt->bind_param("s", $usuario); // Vincular el parámetro de la consulta
                            
                            if (!$stmt->execute()) { // Ejecutar la consulta
                                throw new Exception("Error al ejecutar la consulta.");
                            }
                            
                            $result = $stmt->get_result(); // Obtener el resultado de la consulta
                            
                            if ($result->num_rows > 0) { // Verificar si se encontraron resultados
                                $row = $result->fetch_assoc(); // Obtener los datos del usuario

                                if ($row['Tipo_Usuario'] == 'Programador') {
                                    echo '<img src="../../img/pro.png" alt="Usuario" class="profile-img">';
                                } else {
                                    echo '<img src="../../img/SUPERADMIN.png" alt="Usuario" class="profile-img">';
                                }
                                
                                // Nombre completo
                                $nombreCompleto = trim($row['Nombre'].' '.$row['Apellido_Paterno'].' '.$row['Apellido_Materno']);
                                echo '<p class="profile-name"><strong>'.htmlspecialchars($nombreCompleto).'</strong></p>';
                                
                                // Tipo de usuario
                                echo '<p class="profile-role"><i class="fas fa-user-tag"></i> '.htmlspecialchars($row['Tipo_Usuario']).'</p>';
                                
                                // Cuenta asociada (si existe)
                                if (!empty($row['NombreCuenta']) && $row['NombreCuenta'] !== 'N/A') {
                                    echo '<p class="profile-account"><i class="fas fa-building"></i> '.htmlspecialchars($row['NombreCuenta']).'</p>';
                                }
                            } else {
                                echo '<p class="profile-message">No se encontraron datos del usuario.</p>';
                            }                        
                        } catch (Exception $e) {
                            echo '<p class="profile-error"><i class="fas fa-exclamation-circle"></i> Error al cargar los datos del perfil.</p>';
                            // Opcional: registrar el error en un log
                            // error_log('Error en perfil de usuario: ' . $e->getMessage());
                        } finally {
                            $stmt->close(); // Cerrar la consulta preparada
                            $conexion->close(); // Cerrar la conexión a la base de datos
                        }
                    } else {
                        echo '<p class="profile-message"><i class="fas fa-exclamation-triangle"></i> No se ha iniciado sesión.</p>';
                    }
                ?>
            </div>
            <ul>
                <li><a href="Requisicion_SUPERADMIN.php"><i class="fas fa-plus"></i>Crear Requisición</a></li>
                <li><a href="Solicitud_SUPERADMIN.php"><i class="fas fa-clipboard-list"></i>Requisiciones</a></li>
                <li><a href="Ver_SUPERADMIN.php"><i class="fas fa-eye"></i>Ver Requisiciones</a></li>
                <li><a href="Reportes_SUPERADMIN.php"><i class="fas fa-chart-bar"></i>Reportes</a></li>
            </ul>
        </nav>
        <main class="main-content">
            <canvas style="background: white;" id="graficaRequisicionesAutorizadas" width="800" height="600"></canvas>
        </main>
    </div>
    <script src="../../js/Notificacion_Alert_Inventario.js"></script>
    <script src="../../js/Graficas/GraficaConteoRequisicionesAutorizadas.js"></script>
</body>
</html>
