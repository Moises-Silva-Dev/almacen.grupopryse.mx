<?php include('head.php'); ?>

<div class="container mt-5">
<center><h1>Registrar Región</h1></center>
    <form class="needs-validation" action="../../../Controlador/DEV/INSERT/Funcion_Insert_Region.php" method="post" enctype="multipart/form-data" novalidate>

    <input type="hidden" id="datosTabla" name="datosTabla">

    <div class="mb-3">
        <label for="ID_Cuenta" class="form-label">Cuenta:</label>
            <select class="form-select mb-3" id="ID_Cuenta" name="ID_Cuenta" required>
                <option value="" selected disabled>-- Seleccionar Cuenta --</option>
                    <?php
                        include('../../../Modelo/Conexion.php'); 
                        $conexion = (new Conectar())->conexion();
                        $sql = $conexion->query("SELECT * FROM Cuenta;");
                        while ($resultado = $sql->fetch_assoc()) {
                            echo "<option value='" . $resultado['ID'] . "'>" . $resultado['NombreCuenta'] . "</option>";
                        }
                    ?>
            </select>
        <div class="invalid-feedback">
            Por favor, selecciona una opción.
        </div>
    </div>

    <div class="mb-3">
        <label for="ID_Cuenta" class="form-label">Región:</label>
        <input type="text" class="form-control" id="Nombre_Region" name="Nombre_Region" placeholder="Ingresa el nombre de la region" required>
        <div class="invalid-feedback">
            Por favor, ingresa el Nombre de la region.
        </div>
    </div>

    <div class="mb-3">
        <label for="NombreEstado" class="form-label">Selecciona un estado:</label>
            <select class="form-select mb-3" id="Nombre_Estado" name="Nombre_Estado">
                <option value="" selected disabled>Selecciona un estado</option>
                    <?php
                        $sql1 = $conexion->query("SELECT * FROM Estados;");
                        while ($resultado1 = $sql1->fetch_assoc()) {
                            echo "<option value='" . $resultado1['Id_Estado'] . "'>" . $resultado1['Nombre_estado'] . "</option>";
                        }
                    ?>
            </select>
        <div class="invalid-feedback">
            Por favor, Selecciona un Opción.
        </div>
    </div>

    <!-- Botones -->
        <div class="mb-3">
            <button id="btn_Agregar" type="button" class="btn btn-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-text-wrap" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M4 6l16 0" />
                    <path d="M4 18l5 0" />
                    <path d="M4 12h13a3 3 0 0 1 0 6h-4l2 -2m0 4l-2 -2" />
                </svg>Agregar Estado</button>
                        
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                    <path d="M16 19h6" />
                    <path d="M19 16v6" />
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                </svg>Guardar</button>
            
            <a href="../Regiones_Dev.php" class="btn btn-danger">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M4 7l16 0" />
                    <path d="M10 11l0 6" />
                    <path d="M14 11l0 6" />
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                </svg>Cancelar</a>
        </div>
    </form>

<div class="table-responsive">
    <table class="table table-sm table-dark">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Estado</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
</div>

<?php include('footer.php'); ?>