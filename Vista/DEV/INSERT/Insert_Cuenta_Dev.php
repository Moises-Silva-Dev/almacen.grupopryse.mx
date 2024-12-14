<?php include('head.php'); ?>

<div class="container mt-5">
<center><h1>Registrar Cuenta</h1></center>

    <form class="needs-validation" action="../../../Controlador/DEV/INSERT/Funcion_Insert_Cuenta.php" method="post" novalidate>

    <div class="mb-3">
        <label for="NombreCuenta" class="form-label">Nombre de Cuenta:</label>
        <input type="text" class="form-control" id="NombreCuenta" name="NombreCuenta" placeholder="Ingresa el nombre de la cuenta" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 32)" required>
        <div class="invalid-feedback">
            Por favor, ingresa el Nombre de la Cuenta.
        </div>
    </div>

    <div class="mb-3">
        <label for="NroElemetos" class="form-label">Numero de Elementos:</label>
        <input type="number" class="form-control" id="NroElemetos" name="NroElemetos" placeholder="Ingresa el Numero de Elementos" required>
        <div class="invalid-feedback">
            Por favor, ingresa el Numero de Elementos.
        </div>
    </div>

    <div class="mb-3">
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                    <path d="M16 19h6" />
                    <path d="M19 16v6" />
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                </svg>Guardar</button>
            <a href="../Cuenta_Dev.php" class="btn btn-danger">
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
</div>

<?php include('footer.php'); ?>