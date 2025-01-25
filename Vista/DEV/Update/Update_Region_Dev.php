<?php include('head.php'); ?>

<?php
// Verifica si la variable $_GET['id'] está definida y no es nula
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_region = $_GET['id'];

    // Realiza la consulta para obtener la información de la región
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();
    $consulta = $conexion->prepare("SELECT R.ID_Region, CR.ID_Cuentas, C.NombreCuenta, R.Nombre_Region FROM Cuenta C
                                        INNER JOIN 
                                            Cuenta_Region CR ON C.ID = CR.ID_Cuentas
                                        INNER JOIN 
                                            Regiones R ON CR.ID_Regiones = R.ID_Region
                                        INNER JOIN 
                                            Estado_Region ER ON R.ID_Region = ER.ID_Regiones
                                        INNER JOIN 
                                            Estados E ON ER.ID_Estados = E.Id_Estado
                                    WHERE R.ID_Region = ?;");
    $consulta->bind_param("i", $id_region);
    $consulta->execute();
    $resultado = $consulta->get_result();

    // Verifica si se encontraron resultados
    if ($row = $resultado->fetch_assoc()) {
        $query = "SELECT Id_Estado, Nombre_estado FROM Cuenta C
                    INNER JOIN 
                        Cuenta_Region CR ON C.ID = CR.ID_Cuentas
                    INNER JOIN 
                        Regiones R ON CR.ID_Regiones = R.ID_Region
                    INNER JOIN 
                        Estado_Region ER ON R.ID_Region = ER.ID_Regiones
                    INNER JOIN 
                        Estados E ON ER.ID_Estados = E.Id_Estado
                WHERE R.ID_Region = ?;";
                    
                    $stmt = $conexion->prepare($query);
                    $stmt->bind_param("i", $id_region);
                    $stmt->execute();
            
                    $resultadoConsulta = $stmt->get_result();
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

<div class="container mt-5">
    <center><h1>Modificar Region</h1></center>
    <form id="FormUpdateRegion" class="needs-validation" action="../../../Controlador/Usuarios/UPDATE/Funcion_Update_Region.php" method="post" enctype="multipart/form-data" novalidate>
        <input type="hidden" id="ID_region" name="ID_region" value="<?php echo $row['ID_Region']; ?>">
        <input type="hidden" id="datosTablaUpdateRegion" name="datosTablaUpdateRegion">

        <div class="mb-3">
            <label for="ID_Cuenta" class="form-label">Cuenta:</label>
            <select class="form-select mb-3" id="ID_Cuenta" name="ID_Cuenta" required>
                    <option value="" selected disabled>-- Seleccionar Cuenta --</option>
                    <?php
                    $sql = $conexion->query("SELECT * FROM Cuenta;");
                    while ($resultado = $sql->fetch_assoc()) {
                        $selected = ($row['ID_Cuentas'] == $resultado['ID']) ? 'selected' : '';
                        echo "<option value='" . $resultado['ID'] . "' $selected>" . $resultado['NombreCuenta'] . "</option>";
                    }
                    ?>
            </select>
            <div class="invalid-feedback">
                    Por favor, selecciona una opción.
            </div>
        </div>

        <div class="mb-3">
            <label for="Nombre_Region" class="form-label">Región:</label>
            <input type="text" class="form-control" id="Nombre_Region" name="Nombre_Region" value="<?php echo $row['Nombre_Region']; ?>" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 32)" required>
            <div class="invalid-feedback">
                Por favor, ingresa el Nombre de la región.
            </div>
        </div>

        <div class="mb-3">
            <label for="Nombre_Estado" class="form-label">Selecciona un estado:</label>
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
                Por favor, selecciona una opción.
            </div>
        </div>

        <!-- Botones -->
        <div class="mb-3">
            <button id="btn_ModificarRegionConEstado" type="button" class="btn btn-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-text-wrap" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M4 6l16 0" />
                    <path d="M4 18l5 0" />
                    <path d="M4 12h13a3 3 0 0 1 0 6h-4l2 -2m0 4l-2 -2" />
                </svg>Agregar Estado
            </button>
                            
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                    <path d="M16 19h6" />
                    <path d="M19 16v6" />
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                </svg>Guardar
            </button>
                
            <a href="../Regiones_Dev.php" class="btn btn-danger">
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

    <div class="table-responsive">
        <table class="table table-sm table-dark">
            <thead>
                <tr>
                    <th scope="col">Estado</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Comprobar si hay resultados antes de continuar
                    if ($resultadoConsulta->num_rows > 0) {
                        // Iterar sobre cada fila de resultados
                        while ($row1 = $resultadoConsulta->fetch_assoc()) {
                ?>
                    <tr>
                        <!-- Llamamos información de la consulta -->
                        <td data-id="<?php echo $row1['Id_Estado']; ?>"><?php echo $row1['Nombre_estado']; ?></td>
                        <td>
                            <button type="button" class="btn btn-warning btn-anular">
                            Eliminar
                            </button> 
                        </td>
                    </tr>
                <?php
                        }
                    } else {
                        // Mostrar un mensaje si no hay resultados
                        echo "<tr><td colspan='8'>No se encontraron productos.</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="../../../js/Update_Region_datosTabla.js"></script>
<script src="../../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Update_Region.js"></script>

<?php include('footer.php'); ?>