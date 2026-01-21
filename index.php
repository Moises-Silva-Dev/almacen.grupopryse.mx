<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <!-- Bootstrap y SweetAlert -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="img/SUPERADMIN.png">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <!-- Loader -->
    <div id="loader">
        <div class="glow-wrapper">
            <img src="img/SUPERADMIN.png" alt="Logo Grupo PRYSE" class="img-fluid mx-auto d-block" style="max-width: 250px; width: 100%; height: auto;">
        </div>
    </div>
    <!-- Contenido Principal -->
    <div id="main-content">
        <?php 
            if (isset($_GET['auth'])): // Verifica si se ha pasado el parámetro 'auth' en la URL
                $message = ''; // Inicializa la variable de mensaje a vacío

                if ($_GET['auth'] == 'failed') { // Verifica si el valor de 'auth' es 'failed'
                    $message = 'Debes iniciar sesión para acceder.'; // Asigna el mensaje de error
                } elseif ($_GET['auth'] == 'timeout') { // Verifica si el valor de 'auth' es 'timeout'
                    // Asigna un mensaje de advertencia si la sesión ha expirado
                    // Esto puede ocurrir si el usuario intenta acceder a una página protegida sin haber iniciado sesión
                    $message = 'Tu sesión ha expirado. Por favor, inicia sesión nuevamente.'; 
                }

                if ($message): // Verifica si hay un mensaje para mostrar
        ?>
        <script>
            Swal.fire({
                icon: 'warning', // Cambia el icono a 'warning' para un mensaje de advertencia
                title: 'Acceso denegado', // Título del mensaje
                text: '<?= $message ?>', // Mensaje de advertencia
                confirmButtonText: 'OK' // Texto del botón de confirmación
            }).then(() => {
                window.location = "index.php"; // Redirige al usuario a la página de inicio de sesión
            });
        </script>
        <?php 
            endif; 
                endif; 
        ?>
        <div class="login-container">
            <div class="left-side">
                <div style="width: 100%; max-width: 350px;">
                    <h2 class="text-center mb-4">Iniciar sesión</h2>
                    <form id="loginForm" method="POST" action="Controlador/Login/Login_V.php" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo electrónico</label>
                            <input type="email" name="correo" class="form-control" id="validationCustom01" placeholder="Ingresa tu correo" required>
                            <div class="invalid-feedback">Por favor, ingresa un correo válido.</div>
                        </div>
                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" name="contrasena" class="form-control" id="validationCustom02" placeholder="Ingresa tu Contraseña" required>
                            <div class="invalid-feedback">Por favor, ingresa tu contraseña.</div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
                    </form>
                </div>
            </div>
            <div class="right-side">
                <img src="img/Logo_Inventario.png" alt="Logo Grupo PRYSE" class="img-fluid mx-auto d-block" style="max-width: 350px; width: 100%; height: auto;">
            </div>
        </div>
        <footer>
            © <?= date("Y") ?> Grupo PRYSE. Todos los derechos reservados.
        </footer>
    </div>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/ValidarCampo.js"></script>
    <script src="js/SweetAlertNotificaciones/Notificacion_SweetAlert_Login.js"></script>
    <script src="js/Vista_Animacion_Inicio.js"></script>
</body>
</html>