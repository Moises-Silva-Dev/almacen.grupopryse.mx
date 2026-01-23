<!DOCTYPE html>
<html lang="es">
<head>
    <title>Dashboard - Directivo</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chart.js y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <script src="https://cdn.jsdelivr.net/npm/date-fns"></script>
    <link rel="stylesheet" href="../../css/principal.css">
    <link rel="stylesheet" href="../../css/colores.css">
    <link rel="stylesheet" href="../../css/responsive.css">
    <link rel="shortcut icon" href="../../img/SUPERADMIN.png">
</head>
<body>
    <?php
    include('../../Modelo/Loguearse.php');
    if(isset($_GET['cerrar_sesion'])) {
        session_destroy();
        header("Location: ../../index.php");
        exit();
    }
    ?>
    
    <div class="dashboard-container">
        <!-- Navbar Superior -->
        <nav class="navbar-top">
            <div class="navbar-brand">
                <div class="logo-container">
                    <i class="fas fa-boxes logo-icon"></i>
                    <span class="logo-text">SICOIN</span>
                </div>
                <a href="index_SUPERADMIN.php" class="nav-home-link">
                    <i class="fas fa-home"></i> Inicio
                </a>
            </div>
            
            <div class="navbar-controls">                
                <!-- Botón Salir -->
                <a id="logout-btn" class="btn-logout" href="?cerrar_sesion=true">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="logout-text">Salir</span>
                </a>
                
                <!-- Botón Menú Móvil -->
                <button id="menu-toggle" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </nav>
        
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <!-- Perfil de Usuario -->
            <div class="user-profile-card">
                <?php            
                include('../../Modelo/Conexion.php');
                if (isset($_SESSION['usuario'])) {
                    $conexion = (new Conectar())->conexion();
                    $usuario = $_SESSION['usuario'];
                    
                    try {
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
                        
                        $stmt = $conexion->prepare($sql);
                        $stmt->bind_param("s", $usuario);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            
                            echo '<div class="profile-header">';
                            if ($row['Tipo_Usuario'] == 'Programador') {
                                echo '<img src="../../img/pro.png" alt="Usuario" class="profile-avatar">';
                            } else {
                                echo '<img src="../../img/SUPERADMIN.png" alt="Usuario" class="profile-avatar">';
                            }
                            echo '<div class="profile-info">';
                            echo '<h4 class="profile-name">'.htmlspecialchars(trim($row['Nombre'].' '.$row['Apellido_Paterno'].' '.$row['Apellido_Materno'])).'</h4>';
                            echo '<span class="profile-badge">'.htmlspecialchars($row['Tipo_Usuario']).'</span>';
                            echo '</div></div>';
                            
                            echo '<div class="profile-details">';
                            echo '<div class="profile-detail-item">';
                            echo '<i class="fas fa-envelope"></i>';
                            echo '<span>'.htmlspecialchars($row['Correo_Electronico']).'</span>';
                            echo '</div>';
                            
                            if (!empty($row['NombreCuenta']) && $row['NombreCuenta'] !== 'N/A') {
                                echo '<div class="profile-detail-item">';
                                echo '<i class="fas fa-building"></i>';
                                echo '<span>'.htmlspecialchars($row['NombreCuenta']).'</span>';
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                        $stmt->close();
                        $conexion->close();
                    } catch (Exception $e) {
                        echo '<div class="error-message">Error al cargar datos del perfil</div>';
                    }
                }
                ?>
            </div>

            <!-- Menú de Navegación -->
            <nav class="sidebar-menu">
                <ul>
                    <li>
                        <a href="Requisicion_SUPERADMIN.php" class="menu-item">
                            <i class="fas fa-plus menu-icon"></i>
                            <span class="menu-text">Crear Requisición</span>
                        </a>
                    </li>
                    <li>
                        <a href="Solicitud_SUPERADMIN.php" class="menu-item">
                            <i class="fas fa-clipboard-list menu-icon"></i>
                            <span class="menu-text">Requisiciones</span>
                        </a>
                    </li>
                    <li>
                        <a href="Prestamo_SUPERADMIN.php" class="menu-item">
                            <i class="fas fa-clipboard-list menu-icon"></i>
                            <span class="menu-text">Prestamos</span>
                        </a>
                    </li>
                    <li>
                        <a href="Ver_SUPERADMIN.php" class="menu-item">
                            <i class="fas fa-eye menu-icon"></i>
                            <span class="menu-text">Ver Requisicione</span>
                        </a>
                    </li>
                    <li>
                        <a href="Reportes_SUPERADMIN.php" class="menu-item">
                            <i class="fas fa-chart-bar menu-icon"></i>
                            <span class="menu-text">Reportes</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <!-- Contenido Principal -->
        <main class="main-content">