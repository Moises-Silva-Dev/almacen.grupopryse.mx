<?php include('head.php'); ?>

<?php
// Incluye el archivo de conexión a la base de datos
include('../../../Modelo/Conexion.php');

// Verifica si la variable $_GET['id'] está definida y no es nula
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Asigna el valor de $_GET['id'] a la variable $id_empleado
    $id_empleado = $_GET['id'];

    // Establece la conexión con la base de datos
    $conexion = (new Conectar())->conexion();

    // Prepara una consulta SQL para obtener la información del empleado
    $consulta = $conexion->prepare("SELECT * FROM 
                                        Usuario U
                                    INNER JOIN 
                                        Tipo_Usuarios TU ON U.ID_Tipo_Usuario = TU.ID
                                    WHERE 
                                        U.ID_Usuario = ?");
    
    // Asigna el valor de $id_empleado como parámetro a la consulta preparada
    $consulta->bind_param("i", $id_empleado);
    
    // Ejecuta la consulta SQL
    $consulta->execute();
    
    // Obtiene los resultados de la consulta
    $resultado = $consulta->get_result();

    // Verifica si se encontró un registro correspondiente al empleado con el ID proporcionado
    if ($row = $resultado->fetch_assoc()) {
        // Si se encuentra un empleado, se prepara otra consulta para obtener información relacionada con las cuentas del usuario
        $consulta2 = $conexion->prepare("SELECT 
                                            C.ID, 
                                            C.NombreCuenta,
                                            COUNT(REQ.IDRequisicionE) AS TotalRequisiciones
                                        FROM 
                                            Usuario U
                                        INNER JOIN 
                                            Usuario_Cuenta UC ON U.ID_Usuario = UC.ID_Usuarios
                                        INNER JOIN 
                                            Cuenta C ON UC.ID_Cuenta = C.ID
                                        LEFT JOIN 
                                            RequisicionE REQ ON C.ID = REQ.IdCuenta 
                                            AND REQ.Estatus IN ('Pendiente', 'Parcial', 'Autorizado')
                                        WHERE 
                                            U.ID_Usuario = ?
                                        GROUP BY 
                                            C.ID, C.NombreCuenta");
                                            
        // Asigna el valor de $id_empleado como parámetro a la segunda consulta preparada
        $consulta2->bind_param("i", $id_empleado);
        
        // Ejecuta la segunda consulta SQL
        $consulta2->execute();
        
        // Obtiene los resultados de la segunda consulta
        $resultado2 = $consulta2->get_result();
        
        // Aquí puedes procesar el $resultado2 para mostrar las cuentas y las requisiciones relacionadas
    } else {
        // Si no se encuentra ningún empleado con el ID proporcionado, muestra un mensaje de error
        echo "No se encontró ningún empleado con la ID proporcionada.";
        exit; // Termina el script o puedes redirigir a otra página
    }
} else {
    // Si no se ha proporcionado un ID de empleado válido en la URL, muestra un mensaje de error
    echo "ID de empleado no proporcionada.";
    exit; // Termina el script o puedes redirigir a otra página
}
?>

<div class="container mt-5">
<center><h2>Modificar Rol Usuario</h2></center>
    <!-- Formulario -->
    <form id="FormUpdateRolUsuario" class="needs-validation" action="../../../Controlador/Usuarios/UPDATE/Funcion_Update_Rol_Usuario.php" method="post" enctype="multipart/form-data" novalidate>
        <!-- ID (para edición) -->
        <input type="hidden" name="idTipo" id="idTipo" value="<?php echo $row['ID_Tipo_Usuario']  ?>">
        <input type="hidden" name="id" id="id" value="<?php echo $row['ID_Usuario']  ?>">
        <input type="hidden" id="DatosTablaCuentaUpdate" name="DatosTablaCuentaUpdate">
        <input type="hidden" id="DatosTablaCuenta" name="DatosTablaCuenta">
        
        <!-- Crear DIV para notificación -->
        <div id="notificationContainer"></div>
            <?php 
                if ($row['ID_Tipo_Usuario'] == 3 || $row['ID_Tipo_Usuario'] == 4) {
                    echo '<div class="mb-3">
                            <label for="ID_Materia" class="form-label">Cuenta:</label>
                            <div class="input-group">
                                <select class="form-select" id="ID_Cuenta_Update">
                                    <option value="" selected>-- Seleccionar Cuenta --</option>';
                
                                    // Consulta SQL para el usuario tipo 4
                                    $sqlB = $conexion->query("SELECT 
                                                                c.ID, c.NombreCuenta
                                                            FROM 
                                                                Cuenta c
                                                            INNER JOIN 
                                                                Cuenta_Region cr ON c.ID = cr.ID_Cuentas
                                                            INNER JOIN 
                                                                Estado_Region er ON cr.ID_Regiones = er.ID_Regiones
                                                            WHERE 
                                                                er.ID_Regiones IS NOT NULL
                                                            AND 
                                                                er.ID_Estados IS NOT NULL
                                                            GROUP BY 
                                                                c.ID, c.NombreCuenta");
                
                                    // Genera las opciones del select
                                    while ($cuentaB = $sqlB->fetch_assoc()) {
                                        echo "<option value='" . $cuentaB['ID'] . "'>" . $cuentaB['NombreCuenta'] . "</option>";
                                    }
                
                    echo '      </select>
                                <button class="btn btn-secondary" type="button" id="addCuentaUpdateButton">Agregar</button>
                            </div>
                            <div class="invalid-feedback">
                                Por favor, selecciona una materia.
                            </div>
                        </div>
                
                        <div class="mb-3">
                            <label class="form-label">Cuentas Seleccionadas:</label>
                            <table class="table table-bordered" id="cuentaUpdateTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                // Asegúrate de haber hecho la consulta para obtener las cuentas seleccionadas
                                while($cuentaSeleccionada = $resultado2->fetch_assoc()) {
                                    if ($cuentaSeleccionada['TotalRequisiciones'] > 0) {
                                        echo "<tr>
                                                <td>" . $cuentaSeleccionada['ID'] . "</td>
                                                <td>" . $cuentaSeleccionada['NombreCuenta'] . "</td>
                                                <td><button type='button' class='btn btn-danger btn-sm removeCuentaUpdate' style='display: none;'>Eliminar</button></td>
                                        </tr>";
                                    } else {
                                        echo "<tr>
                                                <td>" . $cuentaSeleccionada['ID'] . "</td>
                                                <td>" . $cuentaSeleccionada['NombreCuenta'] . "</td>
                                                <td><button type='button' class='btn btn-danger btn-sm removeCuentaUpdate'>Eliminar</button></td>
                                        </tr>";
                                    }
                                }
                    echo '      </tbody>
                            </table>
                        </div>';
                } else {
                    echo '<div class="mb-3">
                            <label for="ID_Tipo" class="form-label">Tipo de Usuario:</label>
                                <select class="form-select mb-3" id="ID_Tipo" name="ID_Tipo">
                                    <option value="" selected disabled>-- Seleccionar Tipo de Usuario --</option>';
                                        $sql = $conexion->query("SELECT ID, Tipo_Usuario FROM Tipo_Usuarios");
                                        while ($resultado = $sql->fetch_assoc()) {
                                            $selected = ($row['ID_Tipo_Usuario'] == $resultado['ID']) ? 'selected' : '';
                                            echo "<option value='" . $resultado['ID'] . "'$selected>" . $resultado['Tipo_Usuario'] . "</option>";
                                        }
                echo'           </select>
                                <div class="invalid-feedback">
                                    Por favor, selecciona una opción.
                                </div>
                            </div>
                
                            <div id="cuenta-container" class="docente-fields user-fields" style="display: none;">
                                <div class="mb-3">
                                    <label for="ID_Cuenta" class="form-label">Cuenta:</label>
                                    <div class="input-group">
                                        <select class="form-select" id="ID_Cuenta">
                                            <option value="" selected>-- Seleccionar Cuenta --</option>
                                        </select>
                                        <button class="btn btn-outline-secondary" type="button" id="addCuentaButton">Agregar</button>
                                    </div>
                                    <div class="invalid-feedback">
                                        Por favor, selecciona una materia.
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Cuentas Seleccionadas:</label>
                                    <table class="table table-bordered" id="cuentaTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div> ';
                }
            ?>
            
        <div id="tipoUsuarioContainer" style="display: none;">
            <div class="mb-3">
                <label for="ID_Tipo" class="form-label">Tipo de Usuario:</label>
                <select class="form-select mb-3" id="ID_Tipo" name="ID_Tipo">
                    <option value="" selected disabled>-- Seleccionar Tipo de Usuario --</option>
                        <?php
                            $sql = $conexion->query("SELECT ID, Tipo_Usuario FROM Tipo_Usuarios");
                            while ($resultado = $sql->fetch_assoc()) {
                                echo "<option value='" . $resultado['ID'] . "'>" . $resultado['Tipo_Usuario'] . "</option>";
                            }
                        ?>
                </select>
                <div class="invalid-feedback">
                    Por favor, selecciona una opción.
                </div>
            </div>

            <div id="cuenta-container" class="docente-fields user-fields" style="display: none;">
                <div class="mb-3">
                    <label for="ID_Cuenta" class="form-label">Cuenta:</label>
                    <div class="input-group">
                        <select class="form-select" id="ID_Cuenta">
                            <option value="" selected>-- Seleccionar Cuenta --</option>
                        </select>
                        <button class="btn btn-outline-secondary" type="button" id="addCuentaButton">Agregar</button>
                    </div>
                    <div class="invalid-feedback">
                        Por favor, selecciona una materia.
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Cuentas Seleccionadas:</label>
                    <table class="table table-bordered" id="cuentaTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="mb-3">
            <button type="button" id="btn_CambiarRol" class="btn btn-warning" onclick="CambiarTipoRol()">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users-group" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                    <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                    <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                    <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                    <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                    <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                </svg>Modificar Rol</button>
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                    <path d="M16 19h6" />
                    <path d="M19 16v6" />
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                </svg>Guardar</button>
            <a href="../Registro_Usuario_Dev.php" class="btn btn-danger">
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

<script src="../../../js/Update_Rol.js"></script>
<script src="../../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Update_Rol_Usuario.js"></script>

<?php include('footer.php'); ?>