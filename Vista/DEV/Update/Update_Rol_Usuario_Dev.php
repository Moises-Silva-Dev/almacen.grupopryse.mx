<?php include('head.php'); ?>

<?php
include('../../../Modelo/Conexion.php'); // Incluye la conexión a la base de datos

if (!isset($_GET['id']) || empty($_GET['id'])) { // Verifica si la ID de empleado no está vacía
    echo "ID de empleado no proporcionada."; // Muestra un mensaje de error si no se proporciona la ID
    exit; // Detiene la ejecución del script
}

$id_empleado = $_GET['id']; // Obtener la ID del empleado desde la URL
$conexion = (new Conectar())->conexion(); // Conectar a la base de datos

// Obtener información del usuario
$consulta = $conexion->prepare("SELECT * FROM Usuario U INNER JOIN Tipo_Usuarios TU ON U.ID_Tipo_Usuario = TU.ID WHERE U.ID_Usuario = ?");
$consulta->bind_param("i", $id_empleado); // Asignar el valor de la ID del empleado al parámetro
$consulta->execute(); // Ejecutar la consulta
$resultado = $consulta->get_result(); // Obtener el resultado de la consulta

if (!$row = $resultado->fetch_assoc()) { // Verificar si se encontró un empleado con la ID proporcionada
    echo "No se encontró ningún empleado con la ID proporcionada."; // Muestra un mensaje de error si no se encuentra el empleado
    exit; // Detiene la ejecución del script
}

$tipoActual = $row['ID_Tipo_Usuario']; // Obtener el tipo de usuario actual
$tipoActualNombre = $row['Tipo_Usuario']; // Obtener el nombre del tipo de usuario actual
$ID_Usuario = $row['ID_Usuario'];

// Obtener cuentas asociadas y requisiciones pendientes
$consulta2 = $conexion->prepare("SELECT 
                                    C.ID, C.NombreCuenta, COUNT(REQ.IDRequisicionE) AS TotalRequisiciones
                                FROM Cuenta C
                                JOIN 
                                    Usuario_Cuenta UC ON C.ID = UC.ID_Cuenta
                                JOIN 
                                    Usuario U ON UC.ID_Usuarios = U.ID_Usuario
                                LEFT JOIN 
                                    RequisicionE REQ ON C.ID = REQ.IdCuenta 
                                    AND REQ.IdUsuario = U.ID_Usuario
                                    AND REQ.Estatus IN ('Pendiente', 'Parcial', 'Autorizado')
                                WHERE 
                                    U.ID_Usuario = ?
                                GROUP BY 
                                    C.ID, C.NombreCuenta
                                ORDER BY 
                                    C.NombreCuenta");

$consulta2->bind_param("i", $id_empleado);
$consulta2->execute();
$resultado2 = $consulta2->get_result();

// Verificar requisiciones pendientes
$tieneRequisiciones = false;
$cuentasConRequisiciones = [];
while ($cuenta = $resultado2->fetch_assoc()) {
    if ($cuenta['TotalRequisiciones'] > 0) {
        $tieneRequisiciones = true;
        $cuentasConRequisiciones[] = $cuenta['ID'];
    }
}
// Resetear  nel puntero para usarlo nuevamente
$resultado2->data_seek(0);
?>

<div class="container mt-5">
    <center><h2>Modificar Rol Usuario</h2></center>
    <form id="FormUpdateRolUsuario" class="needs-validation" action="../../../Controlador/Usuarios/UPDATE/Funcion_Update_Rol_Usuario.php" method="post" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="idTipoActual" value="<?php echo $tipoActual; ?>">
        <input type="hidden" name="id" value="<?php echo $ID_Usuario; ?>">
        <input type="hidden" id="DatosTablaCuenta" name="DatosTablaCuenta">
        
        <!-- Notificación -->
        <div id="notificationContainer">
            <?php if ($tieneRequisiciones && in_array($tipoActual, [3, 4])): ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> El usuario tiene requisiciones pendientes en algunas cuentas. 
                    No se puede cambiar el rol hasta que se completen, pero puede agregar más cuentas.
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Sección para cambiar tipo de usuario -->
        <div class="mb-3" id="seccionTipoUsuario" style="<?= in_array($tipoActual, [3, 4]) && $tieneRequisiciones ? 'display:none;' : '' ?>">
            <label for="ID_Tipo" class="form-label">Tipo de Usuario:</label>
            <select class="form-select" id="ID_Tipo" name="ID_Tipo" <?= in_array($tipoActual, [3, 4]) && $tieneRequisiciones ? 'disabled' : '' ?>>
                <option value="">-- Seleccionar Tipo de Usuario --</option>
                <?php
                $sql = $conexion->query("SELECT ID, Tipo_Usuario FROM Tipo_Usuarios WHERE ID != $tipoActual");
                while ($tipo = $sql->fetch_assoc()): ?>
                    <option value="<?= $tipo['ID'] ?>" <?= $tipoActual == $tipo['ID'] ? 'selected disabled' : '' ?>>
                        <?= $tipo['Tipo_Usuario'] ?>
                        <?= $tipoActual == $tipo['ID'] ? '(Actual)' : '' ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <small class="text-muted">Actual: <?= $tipoActualNombre ?></small>
        </div>
        
        <!-- Sección de cuentas (solo para tipos 3 y 4) -->
        <div id="seccionCuentas" style="<?= !in_array($tipoActual, [3, 4]) ? 'display:none;' : '' ?>">
            <div class="mb-3">
                <label for="ID_Cuenta" class="form-label">Agregar Cuenta:</label>
                <div class="input-group">
                    <select class="form-select" id="ID_Cuenta">
                        <option value="" selected>-- Seleccionar Cuenta --</option>
                        <?php
                        $sqlB = $conexion->query("SELECT c.ID, c.NombreCuenta
                                                FROM Cuenta c
                                                INNER JOIN Cuenta_Region cr ON c.ID = cr.ID_Cuentas
                                                INNER JOIN Estado_Region er ON cr.ID_Regiones = er.ID_Regiones
                                                WHERE er.ID_Regiones IS NOT NULL
                                                AND er.ID_Estados IS NOT NULL
                                                GROUP BY c.ID, c.NombreCuenta");
                        while ($cuenta = $sqlB->fetch_assoc()): ?>
                            <option value="<?= $cuenta['ID'] ?>"><?= $cuenta['NombreCuenta'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <button class="btn btn-secondary" type="button" id="btnAgregarCuenta">
                        <i class="fas fa-plus">Agregar</i>
                    </button>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Cuentas Asociadas:</label>
                <table class="table table-bordered" id="tablaCuentas">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Requisiciones</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($cuenta = $resultado2->fetch_assoc()): ?>
                            <tr data-cuenta-id="<?= $cuenta['ID'] ?>">
                                <td><?= $cuenta['ID'] ?></td>
                                <td><?= $cuenta['NombreCuenta'] ?></td>
                                <td><?= $cuenta['TotalRequisiciones'] > 0 ? '<span class="badge bg-warning">'.$cuenta['TotalRequisiciones'].' pendientes</span>' : '<span class="badge bg-success">Ninguna</span>' ?></td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm btnEliminarCuenta" 
                                        <?= $cuenta['TotalRequisiciones'] > 0 ? 'disabled title="No se puede eliminar porque tiene requisiciones pendientes"' : '' ?>>
                                        <i class="fas fa-trash">Eliminar</i>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Botones -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary" <?= $tieneRequisiciones && in_array($tipoActual, [3, 4]) ? '' : '' ?>>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                    <path d="M16 19h6" />
                    <path d="M19 16v6" />
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                </svg>Guardar Cambios
            </button>
            <a href="../Registro_Usuario_Dev.php" class="btn btn-danger">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
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

<!-- Paso 1: PHP to JS -->
<script>
    const tipoActual = <?= $tipoActual ?>;
    const tieneRequisiciones = <?= $tieneRequisiciones ? 'true' : 'false' ?>;
    const cuentasConRequisiciones = <?= json_encode($cuentasConRequisiciones) ?>;
</script>

<script src="../../../js/Update_Rol.js"></script>
<script src="../../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Update_Rol_Usuario.js"></script>

<?php include('footer.php'); ?>