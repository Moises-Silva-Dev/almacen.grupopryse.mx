<?php include('head.php'); ?>

<div class="container mt-5">
<center><h2>Registrar Nuevo Recluta</h2></center>
    <form id="FormInsertReclutaNuevo" class="needs-validation" action="../../../Controlador/Usuarios/INSERT/Funcion_Insert_Recluta.php" method="POST" enctype="multipart/form-data" novalidate>
        <!-- Aquí van los campos del formulario -->
        <div class="mb-3">
            <label class="form-label" for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa el Nombre del Recluta" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Nombre del Recluta.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="ap_paterno">Apellido Paterno:</label>
            <input type="text" class="form-control" id="ap_paterno" name="ap_paterno" placeholder="Ingresa el apellido del Recluta" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Apellido Paterno del Recluta.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="ap_materno">Apellido Materno:</label>
            <input type="text" class="form-control" id="ap_materno" name="ap_materno" placeholder="Ingresa el apellido del Recluta" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Apellido Materno del Recluta.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" max="2005-12-31" required>
            <div class="invalid-feedback">
                Por favor, ingresa la Fecha de Nacimiento.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="origen_vacante">Origen Vacante:</label>
            <select class="form-select" id="origen_vacante" name="origen_vacante" required>
                <option value="" disabled selected>Selecciona una opción</option>
                <option value="Facebook">Facebook</option>
                <option value="Computrabajo">Computrabajo</option>
                <option value="LinkedIn">LinkedIn</option>
                <option value="Indeed">Indeed</option>
                <option value="Portal de la empresa">Portal de la empresa</option>
                <option value="Recomendación">Recomendación</option>
                <option value="Otros">Otros</option>
            </select>
            <div class="invalid-feedback">
                Por favor, selecciona una opción.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="fecha_envio">Fecha de Envío:</label>
            <input type="date" class="form-control" id="fecha_envio" name="fecha_envio" required>
            <div class="invalid-feedback">
                Por favor, ingresa la Fecha de Envío.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="transferido">Transferido:</label>
            <input type="text" class="form-control" id="transferido" name="transferido" placeholder="Ingresa el Transferido" required>
            <div class="invalid-feedback">
                Por favor, ingresa de Quien se ha Transferido.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="estado">Estado:</label>
            <input type="text" class="form-control" id="estado" name="estado" placeholder="Ingresa el Estado" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Estado.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="municipio">Municipio:</label>
            <input type="text" class="form-control" id="municipio" name="municipio" placeholder="Ingresa el Municipio" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Municipio.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="centro_trabajo">Centro de Trabajo:</label>
            <input type="text" class="form-control" id="centro_trabajo" name="centro_trabajo" placeholder="Ingresa el Centro de Trabajo" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Centro de Trabajo.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="telefono">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" pattern="\d{10}" placeholder="Ingresa el Numero Telefonico" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Numero Telefonico
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="servicio">Servicio:</label>
            <input type="text" class="form-control" id="servicio" name="servicio" placeholder="Ingresa el Servicioa" required>
            <div class="invalid-feedback">
            Por favor, ingresa el Nombre del Servicio.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="escolaridad">Escolaridad:</label>
            <select class="form-select" id="escolaridad" name="escolaridad" required>
                <option value="" disabled selected>Selecciona una opción</option>
                <option value="Primaria">Primaria</option>
                <option value="Secundaria">Secundaria</option>
                <option value="Preparatoria">Preparatoria</option>
                <option value="Licenciatura">Licenciatura</option>
                <option value="Maestría">Maestría</option>
                <option value="Doctorado">Doctorado</option>
                <option value="Otro">Otro</option>
            </select>
            <div class="invalid-feedback">
                Por favor, selecciona una opción.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="edad">Edad:</label>
            <input type="number" class="form-control" id="edad" name="edad" min="18" max="100" required>
            <div class="invalid-feedback">
                Por favor, ingresa la Edad.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="transferido_a">Transferido A:</label>
            <input type="text" class="form-control" id="transferido_a" name="transferido_a" placeholder="Ingresa de donde se Transferido" required>
            <div class="invalid-feedback">
                Por favor, ingresa de donde se ha transferido.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="estatus">Estatus:</label>
            <select class="form-select" id="estatus" name="estatus" required>
                <option value="" disabled selected>Selecciona una opción</option>
                <option value="Seleccionado">Seleccionado</option>
                <option value="Pendiente">Pendiente</option>
                <option value="En entrevista">En entrevista</option>
                <option value="Aceptado">Aceptado</option>
                <option value="Otro">Otro</option>
            </select>
            <div class="invalid-feedback">
                Por favor, selecciona una opción.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="observaciones">Observaciones:</label>
            <textarea class="form-control" id="observaciones" name="observaciones" placeholder="Ingresa la Observaciones" required></textarea>
            <div class="invalid-feedback">
                Por favor, ingresa la Observación.
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="Reclutador">Reclutador:</label>
            <input type="text" class="form-control" id="reclutador" name="reclutador" placeholder="Ingresa el Reclutador" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Nombre del Reclutador.
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                <path d="M16 19h6" />
                <path d="M19 16v6" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
            </svg>Guardar
        </button>
        <button type="button" class="btn btn-danger" onclick="window.location.href='../Reclutas_RH.php'">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M4 7l16 0" />
                <path d="M10 11l0 6" />
                <path d="M14 11l0 6" />
                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
            </svg>Cancelar
        </button>
    </form>
</div>

<script src="../../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Insertar_Recluta.js"></script>

<?php include('footer.php'); ?>