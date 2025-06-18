<?php
include('../../Modelo/Loguearse.php'); // Incluir el archivo de Loguearse.php
if(isset($_GET['cerrar_sesion'])) { // Verificar si se solicita cerrar sesión
    session_destroy(); // Destruir la sesión
    header("Location: ../../index.php"); // Redirigir al usuario a la página de inicio de sesión
    exit();// Finalizar la ejecución del script
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Programador</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="../../css/principal.css" rel="stylesheet">
    <link href="../../css/reporte.css" rel="stylesheet">
    <link href="../../css/boton.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../img/2.png">
</head>
<body>
    <div class="container">
        <!-- Navbar Horizontal -->
        <nav class="navbar-horizontal">
            <div class="logo">
                <p><a style="color: white" href="index_DEV.php">Inicio</a></p>
            </div>
            <div class="user-section">
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
                    if (isset($_SESSION['usuario'])) { // Verificar si el usuario ha iniciado sesión
                        $conexion = (new Conectar())->conexion(); // Crear una instancia de la clase Conectar y obtener la conexión
                        $usuario = $_SESSION['usuario']; // Obtener el correo electrónico del usuario desde la sesión
                        
                        try {
                            // Preparar la consulta SQL para obtener los datos del usuario
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
                <li><a href="Registro_Usuario_Dev.php"><i class="fas fa-users"></i>Usuarios</a></li>
                <li><a href="Producto_Dev.php"><i class="fas fa-clipboard-list"></i>Productos</a></li>
                <li><a href="Salidas_Dev.php"><i class="fas fa-box-open"></i>Salida de Almacén</a></li>
                <li><a href="Almacen_Dev.php"><i class="fas fa-boxes"></i>Entrada de Productos</a></li>
                <li><a href="Cuenta_Dev.php"><i class="fas fa-wallet"></i>Cuenta</a></li>
                <li><a href="Regiones_Dev.php"><i class="fas fa-map-marked-alt"></i>Regiones</a></li>
                <li><a href="Reportes_Dev.php"><i class="fas fa-chart-bar"></i>Reportes</a></li>
                <li><a href="Restauracion_SQL_Dev.php"><i class="fas fa-database"></i>Respaldos BD</a></li>
            </ul>
        </nav>
        <main class="main-content">