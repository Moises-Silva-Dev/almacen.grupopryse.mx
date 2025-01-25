<?php include('head.php'); ?>

<?php
// Verifica si la variable $_GET['id'] está definida y no es nula
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_cuent = $_GET['id'];

    // Realiza la consulta para obtener la información de la región
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();
    $consulta = $conexion->prepare("SELECT * FROM Cuenta WHERE ID = ?");
    $consulta->bind_param("i", $id_cuent);
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
    <h2>Modificar Cuenta</h2>

    <!-- Formulario -->
    <form id="FormUpdateCuenta" action="../../../Controlador/Usuarios/UPDATE/Funcion_Update_Cuenta.php" method="post" class="needs-validation" novalidate>
        <!-- ID (para edición) -->
        <input type="hidden" id="ID_Cuenta" name="ID_Cuenta" value="<?php echo $row['ID']; ?>">
        <div class="mb-3">
            <label for="NombreCuenta" class="form-label">Nombre de la Cuenta:</label>
            <input type="text" class="form-control" id="NombreCuenta" name="NombreCuenta" value="<?php echo $row['NombreCuenta'] ?>" onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122)" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Nombre de la cuenta.
            </div>
        </div>

        <div class="mb-3">
            <label for="NroElemetos" class="form-label">Numero de Elementos:</label>
            <input type="number" class="form-control" id="NroElemetos" name="NroElemetos" value="<?php echo $row['NroElemetos'] ?>" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Numero de elementos.
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
            <a href="../Cuenta_Dev.php" class="btn btn-danger">
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

<script src="../../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Update_Cuenta.js"></script>

<?php include('footer.php'); ?>