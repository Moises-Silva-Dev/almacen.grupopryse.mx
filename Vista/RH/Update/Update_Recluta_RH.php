<?php include('head.php'); ?>

<?php
// Verifica si la variable $_GET['id'] está definida y no es nula
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $ID_Recluta = $_GET['id'];

    // Realiza la consulta para obtener la información de la región
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();
    $consulta = $conexion->prepare("SELECT * FROM Recluta WHERE ID_Recluta = ?");
    $consulta->bind_param("i", $ID_Recluta);
    $consulta->execute();
    $resultado = $consulta->get_result();

    // Verifica si se encontraron resultados
    if ($row = $resultado->fetch_assoc()) {
        // Ahora, $row contiene la información de la región que puedes usar en el formulario
    } else {
        // No se encontró ninguna región con la ID proporcionada, puedes manejar esto según tus necesidades
        echo "No se encontró ninguna región con la ID proporcionada.";
        exit; // Puedes salir del script o redirigir a otra página
    }
} else {
    // La variable $_GET['id'] no está definida o es nula, puedes manejar esto según tus necesidades
    echo "ID de región no proporcionada.";
    exit; // Puedes salir del script o redirigir a otra página
}
?>

<center><div class="container mt-5"></center>
    <h2>Modificar información Recluta</h2>

    <!-- Formulario -->
    <form id="FormUpdateRecluta" class="needs-validation" action="../../../Controlador/Usuarios/UPDATE/Funcion_Update_Recluta.php" method="post" enctype="multipart/form-data" novalidate>
        <!-- ID (para edición) -->
        <input type="hidden" id="ID_Recluta" name="ID_Recluta" value="<?php echo $ID_Recluta; ?>">

        <div class="mb-3">
            <label class="form-label" for="nombre">Nombre:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $row['Nombre']; ?>" placeholder="Ingresa el Nombre del Recluta" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Nombre del Recluta.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="ap_paterno">Apellido Paterno:</label>
            <input type="text" class="form-control" name="ap_paterno" id="ap_paterno" value="<?php echo $row['AP_Paterno']; ?>" placeholder="Ingresa el apellido del Recluta" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Apellido Paterno del Recluta.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="ap_materno">Apellido Materno:</label>
            <input type="text" class="form-control" name="ap_materno" id="ap_materno" value="<?php echo $row['AP_Materno']; ?>" placeholder="Ingresa el apellido del Recluta" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Apellido Materno del Recluta.
            </div>
        </div>
        
        <div class="mb-3">
            <label class="form-label" for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" max="2005-12-31" value="<?php echo $row['Fecha_Nacimiento']; ?>" required>
            <div class="invalid-feedback">
                Por favor, ingresa la Fecha de Nacimiento.
            </div>
        </div>

        <div class="mb-3">    
            <label class="form-label" for="origen_vacante">Origen Vacante:</label>
            <select class="form-select" name="origen_vacante" id="origen_vacante" required>
                <option value="Facebook" <?php echo ($row['Origen_Vacante'] == 'Facebook') ? 'selected' : ''; ?>>Facebook</option>
                <option value="Computrabajo" <?php echo ($row['Origen_Vacante'] == 'Computrabajo') ? 'selected' : ''; ?>>Computrabajo</option>
                <option value="LinkedIn" <?php echo ($row['Origen_Vacante'] == 'LinkedIn') ? 'selected' : ''; ?>>LinkedIn</option>
                <option value="Indeed" <?php echo ($row['Origen_Vacante'] == 'Indeed') ? 'selected' : ''; ?>>Indeed</option>
                <option value="Portal de la empresa" <?php echo ($row['Origen_Vacante'] == 'Portal de la empresa') ? 'selected' : ''; ?>>Portal de la empresa</option>
                <option value="Recomendación" <?php echo ($row['Origen_Vacante'] == 'Recomendación') ? 'selected' : ''; ?>>Recomendación</option>
                <option value="Otros" <?php echo ($row['Origen_Vacante'] == 'Otros') ? 'selected' : ''; ?>>Otros</option>
            </select>
            <div class="invalid-feedback">
                Por favor, selecciona una opción.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="fecha_envio">Fecha de Envío:</label>
            <input type="date" class="form-control" name="fecha_envio" id="fecha_envio" value="<?php echo $row['Fecha_Envio']; ?>" required>
            <div class="invalid-feedback">
                Por favor, ingresa la Fecha de Envío.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="transferido">Transferido:</label>
            <input type="text" class="form-control" name="transferido" id="transferido" value="<?php echo $row['Transferido']; ?>" placeholder="Ingresa el Transferido" required>
            <div class="invalid-feedback">
                Por favor, ingresa de Quien se ha Transferido.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="estado">Estado:</label>
            <input type="text" class="form-control" name="estado" id="estado" value="<?php echo $row['Estado']; ?>" placeholder="Ingresa el Estado" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Estado.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="municipio">Municipio:</label>
            <input type="text" class="form-control" name="municipio" id="municipio" value="<?php echo $row['Municipio']; ?>" placeholder="Ingresa el Municipio" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Municipio.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="centro_trabajo">Centro de Trabajo:</label>
            <input type="text" class="form-control" name="centro_trabajo" id="centro_trabajo" value="<?php echo $row['Centro_Trabajo']; ?>" placeholder="Ingresa el Centro de Trabajo" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Centro de Trabajo.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="telefono">Teléfono:</label>
            <input type="text" class="form-control" name="telefono" id="telefono" value="<?php echo $row['Telefono']; ?>" pattern="\d{10}" placeholder="Ingresa el Numero Telefonico" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Numero Telefonico
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="servicio">Servicio:</label>
            <input type="text" class="form-control" name="servicio" id="servicio" value="<?php echo $row['Servicio']; ?>" placeholder="Ingresa el Servicioa" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Nombre del Servicio.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="escolaridad">Escolaridad:</label>
            <select class="form-select" name="escolaridad" id="escolaridad" required>
                <option value="" disabled>Selecciona una opción</option>
                <option value="Primaria" <?php echo ($row['Escolaridad'] == 'Primaria') ? 'selected' : ''; ?>>Primaria</option>
                <option value="Secundaria" <?php echo ($row['Escolaridad'] == 'Secundaria') ? 'selected' : ''; ?>>Secundaria</option>
                <option value="Preparatoria" <?php echo ($row['Escolaridad'] == 'Preparatoria') ? 'selected' : ''; ?>>Preparatoria</option>
                <option value="Licenciatura" <?php echo ($row['Escolaridad'] == 'Licenciatura') ? 'selected' : ''; ?>>Licenciatura</option>
                <option value="Maestría" <?php echo ($row['Escolaridad'] == 'Maestría') ? 'selected' : ''; ?>>Maestría</option>
                <option value="Doctorado" <?php echo ($row['Escolaridad'] == 'Doctorado') ? 'selected' : ''; ?>>Doctorado</option>
                <option value="Otro" <?php echo ($row['Escolaridad'] == 'Otro') ? 'selected' : ''; ?>>Otro</option>
            </select>
            <div class="invalid-feedback">
                Por favor, selecciona una opción.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="edad">Edad:</label>
            <input type="number" class="form-control" name="edad" id="edad" value="<?php echo $row['Edad']; ?>" min="18" max="100" required>
            <div class="invalid-feedback">
                Por favor, ingresa la Edad.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="transferido_a">Transferido A:</label>
            <input type="text" class="form-control" name="transferido_a" id="transferido_a" value="<?php echo $row['Transferido_A']; ?>" placeholder="Ingresa de donde se Transferido" required>
            <div class="invalid-feedback">
                Por favor, ingresa de donde se ha transferido.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="estatus">Estatus:</label>
            <select class="form-select" name="estatus" id="estatus" required>
                <option value="" disabled>Selecciona una opción</option>
                <option value="Seleccionado" <?php echo ($row['Estatus'] == 'Seleccionado') ? 'selected' : ''; ?>>Seleccionado</option>
                <option value="Pendiente" <?php echo ($row['Estatus'] == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                <option value="En entrevista" <?php echo ($row['Estatus'] == 'En entrevista') ? 'selected' : ''; ?>>En entrevista</option>
                <option value="Aceptado" <?php echo ($row['Estatus'] == 'Aceptado') ? 'selected' : ''; ?>>Aceptado</option>
                <option value="Otro" <?php echo ($row['Estatus'] == 'Otro') ? 'selected' : ''; ?>>Otro</option>
            </select>
            <div class="invalid-feedback">
                Por favor, selecciona una opción.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="observaciones">Observaciones:</label>
            <textarea class="form-control" name="observaciones" id="observaciones" placeholder="Ingresa la Observaciones" required><?php echo $row['Observaciones']; ?></textarea>
            <div class="invalid-feedback">
                Por favor, ingresa la Observación.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="Reclutador">Reclutador:</label>
            <input type="text" class="form-control" name="reclutador" id="reclutador"  value="<?php echo $row['Reclutador']; ?>" placeholder="Ingresa el Reclutador" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Nombre del Reclutador.
            </div>
        </div>

        <!-- Botones -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                    <path d="M16 19h6" />
                    <path d="M19 16v6" />
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                </svg>Guardar
            </button>
            <a href="../Reclutas_RH.php" class="btn btn-danger">
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
</div>

<script src="../../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Update_Recluta.js"></script>

<?php include('footer.php'); ?>