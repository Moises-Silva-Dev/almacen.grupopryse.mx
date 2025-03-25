<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN</title>
  <!-- Enlace a Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Enlace a tu archivo CSS personalizado -->
  <link rel="shortcut icon" href="img/2.png">
  <link rel="stylesheet" href="css/login.css">
  <style>
    body {
      background-color: #bae0f5; /* Puedes cambiar el código de color según tu preferencia */
    }
    
    h1 {
      font-style: italic;
    }
  </style>
</head>
<body>

  <?php 
    if (isset($_GET['auth']) && $_GET['auth'] == 'failed'):  // Si el usuario ha fallado en la autenticación
  ?>
  <script>
    Swal.fire({ // Muestra un mensaje de error
      icon: 'warning', // Icono de advertencia
      title: 'Acceso denegado', // Título del mensaje
      text: 'Debes iniciar sesión para acceder.', // Texto del mensaje
      confirmButtonText: 'OK' // Botón de confirmación
    }).then(() => {
      window.location = "index.php"; // Redirige a la página de inicio
    });
  </script>
  <?php 
    endif; // Fin de la condición
  ?>

<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
      <div class="col-md-8 col-lg-7 col-xl-6">
        <img src="img/1.png"
          class="img-fluid" alt="Phone image">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
        <h1>Bienvenido</h1>
        <form id="loginForm" method="POST" action="Controlador/Login/Login_V.php" class="needs-validation" novalidate>
          <br>
          <div class="form-group">
            <label for="validationCustom01" class="form-label">Correo Electrónico: </label>
            <input type="email" name="correo" class="form-control" id="validationCustom01" placeholder="Ingresa tu Correo Electrónico" required>
            <div class="invalid-feedback">
              Por favor, ingresa un correo electrónico válido.
            </div>
          </div>

          <br>
          <div class="form-group">
            <label for="validationCustom02" class="form-label">Contraseña: </label>
            <input type="password" name="contrasena" class="form-control" id="validationCustom02" placeholder="Ingresa tu Contraseña" required>
            <div class="invalid-feedback">
              Por favor, ingresa tu contraseña.
            </div>
          </div>
          <center><br><button type="submit" class="btn btn-primary">Iniciar sesión</button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- Enlace a Bootstrap JS y Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom Bootstrap validation script -->
<script src="js/ValidarCampo.js"></script>
<script src="js/SweetAlertNotificaciones/Notificacion_SweetAlert_Login.js"></script>
</body>
</html>