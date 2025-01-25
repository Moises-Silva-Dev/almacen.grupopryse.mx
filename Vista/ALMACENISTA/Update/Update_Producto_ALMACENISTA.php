<?php include('head.php'); ?>

<?php
include('../../../Modelo/Conexion.php');

// Verifica si la variable $_GET['id'] está definida y no es nula
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_empleado = $_GET['id'];

    // Realiza la consulta para obtener la información del empleado
    $conexion = (new Conectar())->conexion();
    $consulta = $conexion->prepare("SELECT * FROM Producto P 
    INNER JOIN CCategorias CC on P.IdCCat = CC.IdCCate
    INNER JOIN CEmpresas CE on P.IdCEmp = CE.IdCEmpresa
    INNER JOIN CTipoTallas CTT on P.IdCTipTal = CTT.IdCTipTall WHERE IdCProducto = ?");
    $consulta->bind_param("i", $id_empleado);
    $consulta->execute();
    $resultado = $consulta->get_result();

    // Verifica si se encontraron resultados
    if ($row = $resultado->fetch_assoc()) {

        $imagen = $row['IMG']; // La ruta de la imagen que deseas procesar
        $nombre_archivo = basename($imagen);
        // Ahora, $row contiene la información del empleado que puedes usar en el formulario
    } else {
        // No se encontró ningún empleado con la ID proporcionada, puedes manejar esto según tus necesidades
        echo "No se encontró ningún registro con la ID proporcionada.";
        exit; // Puedes salir del script o redirigir a otra página
    }
} else {
    // La variable $_GET['id'] no está definida o es nula, puedes manejar esto según tus necesidades
    echo "ID de empleado no proporcionada.";
    exit; // Puedes salir del script o redirigir a otra página
}
?>

<div class="container mt-5">
<center><h2>Modificar Registro Producto</h2></center>
    <!-- Formulario -->
    <form id="FormUpdateProducto" class="needs-validation" action="../../../Controlador/Usuarios/UPDATE/Funcion_Update_Producto.php" method="post" enctype="multipart/form-data" novalidate>
        <!-- ID (para edición) -->
        <input type="hidden" name="id" id="id" value="<?php echo $row['IdCProducto']; ?>">

        <div class="mb-3">
            <label for="ID_Empresas" class="form-label">Nombre de Empresa:</label>
            <select class="form-select mb-3" id="ID_Empresas" name="ID_Empresas" required>
                <?php
                $sql_tipos_colaborador = $conexion->query("SELECT * FROM CEmpresas");
                while ($resultado_tipo_colaborador = $sql_tipos_colaborador->fetch_assoc()) {
                    $selected = ($row['IdCEmp'] == $resultado_tipo_colaborador['IdCEmpresa']) ? 'selected' : '';
                    echo "<option value='".$resultado_tipo_colaborador['IdCEmpresa']."' $selected>".$resultado_tipo_colaborador['Nombre_Empresa']."</option>";
                }
                ?>
            </select>
            <div class="invalid-feedback">
                Por favor, Selecciona una Opción.
            </div>
        </div>

        <div class="mb-3">
            <label for="Id_cate" class="form-label">Categorias:</label>
            <select class="form-select mb-3" id="Id_cate" name="Id_cate" required>
                <?php
                $sql_tipos_colaborador = $conexion->query("SELECT * FROM CCategorias");
                while ($resultado_tipo_colaborador = $sql_tipos_colaborador->fetch_assoc()) {
                    $selected = ($row['IdCCat'] == $resultado_tipo_colaborador['IdCCate']) ? 'selected' : '';
                    echo "<option value='".$resultado_tipo_colaborador['IdCCate']."' $selected>".$resultado_tipo_colaborador['Descrp']."</option>";
                }
                ?>
            </select>
            <div class="invalid-feedback">
                Por favor, Selecciona una Opción.
            </div>
        </div>

        <div class="mb-3">
            <label for="Id_TipTall" class="form-label">Tipo de Talla:</label>
            <select class="form-select mb-3" id="Id_TipTall" name="Id_TipTall" required>
                <?php
                $sql_tipos_colaborador = $conexion->query("SELECT * FROM CTipoTallas");
                while ($resultado_tipo_colaborador = $sql_tipos_colaborador->fetch_assoc()) {
                    $selected = ($row['IdCTipTal'] == $resultado_tipo_colaborador['IdCTipTall']) ? 'selected' : '';
                    echo "<option value='".$resultado_tipo_colaborador['IdCTipTall']."' $selected>".$resultado_tipo_colaborador['Descrip']."</option>";
                }
                ?>
            </select>
            <div class="invalid-feedback">
                Por favor, Selecciona una Opción.
            </div>
        </div>

        <div class="mb-3">
            <label for="Descripción" class="form-label">Descripción:</label>
            <textarea id="Descripcion" name="Descripcion" class="form-control" placeholder="Ingresa la Descripción" required><?php echo $row['Descripcion']; ?></textarea>
            <div class="invalid-feedback">
                Por favor, ingresa la Descripción.
            </div>
        </div>

        <div class="mb-3">
            <label for="Especificacion" class="form-label">Especificaciones:</label>
            <textarea id="Especificacion" name="Especificacion" class="form-control" placeholder="Ingresa la Especificación" required><?php echo $row['Especificacion']; ?></textarea>
            <div class="invalid-feedback">
                Por favor, ingresa la Especificación.
            </div>
        </div>

        <div class="mb-3">
            <label for="Imagen" class="form-label">Archivo Actual:</label>
            <input type="text" class="form-control" value="<?php echo $nombre_archivo ?>" disabled>
        </div>

        <div class="mb-3">
            <label for="Imagen" class="form-label">¿Subir nueva imagen?</label>
            <select class="form-select" id="opcion" name="opcion" onchange="mostrarOcultarInput()">
                <option value="" selected disabled>-- Selecciona una Opción --</option>
                <option value="SI">Sí</option>
                <option value="NO">No</option>
            </select>
        </div>

        <div class="mb-3" id="campoImagen" style="display:none;">
            <label for="Imagen" class="form-label">Selecciona un nuevo Archivo:</label>
            <input type="file" class="form-control" id="Imagen" name="Imagen">
            <div class="invalid-feedback">
                Por favor, selecciona un archivo válido.
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
                </svg>Guardar</button>
            <a href="../Producto_Dev.php" class="btn btn-danger">
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

<script src="../../../js/Form_Producto_Update.js"></script>
<script src="../../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Update_Producto.js"></script>

<?php include('footer.php'); ?>