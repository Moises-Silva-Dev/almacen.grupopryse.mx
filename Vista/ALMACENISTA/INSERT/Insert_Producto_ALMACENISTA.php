<?php include('head.php'); ?>

<div class="container mt-5">
    <center><h2>Registrar Producto</h2></center>
    <!-- Formulario -->
    <form action="../../../Controlador/ALMACENISTA/INSERT/Funcion_Insert_Producto.php" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
            <div class="mb-3">
                <label for="IdCEmpresa" class="form-label">Nombre de Empresa:</label>
                <select class="form-select mb-3" id="IdCEmpresa" name="IdCEmpresa" required>
                    <option value="" selected disabled>-- Seleccionar una Empresa --</option>
                    <?php
                        // Tu código PHP para obtener las empresas desde la base de datos
                        include('../../../Modelo/Conexion.php'); 
                        $conexion = (new Conectar())->conexion();
                        $sql = $conexion->query("SELECT * FROM CEmpresas;");
                        while ($resultado = $sql->fetch_assoc()) {
                            echo "<option value='" . $resultado['IdCEmpresa'] . "'>" . $resultado['Nombre_Empresa'] . "</option>";
                        }
                    ?>
                    <option value="nuevo_empresa">Agregar Nuevo Registro</option>
                </select>
                <div class="invalid-feedback">
                    Por favor, selecciona una opción.
                </div>
            </div>

            <!-- Agregar div para el nuevo registro de empresa (inicialmente oculto) -->
            <div id="nuevoEmpresaDiv" class="mb-3" style="display: none;">
                <label for="Nombre_Empresa" class="form-label">Nuevo Nombre de Empresa:</label>
                <input type="text" class="form-control" id="Nombre_Empresa" name="Nombre_Empresa" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 32)" placeholder="Ingresa el Nuevo Nombre de Empresa">
                <div class="invalid-feedback">
                    Por favor, ingresa el Nombre de la Empresa.
                </div>
            <br>
                <label for="RazonSocial" class="form-label">Nueva Razón Social:</label>
                <input type="text" class="form-control" id="RazonSocial" name="RazonSocial" placeholder="Ingresa la Nueva Razón Social">
                <div class="invalid-feedback">
                    Por favor, ingresa la Razón Social de la Empresa.
                </div>
            <br>
                <label for="RFC" class="form-label">Nuevo RFC:</label>
                <input type="text" class="form-control" id="RFC" name="RFC" placeholder="Ingresa el Nuevo RFC">
                <div class="invalid-feedback">
                    Por favor, ingresa el RFC de la Empresa.
                </div>
            <br>            
                <label for="RegistroPatronal" class="form-label">Nuevo Registro Patronal:</label>
                <input type="text" class="form-control" id="RegistroPatronal" name="RegistroPatronal" placeholder="Ingresa el registro patronal">
                <div class="invalid-feedback">
                    Por favor, ingresa el Registro Patronal de la Empresa.
                </div>
            <br>
                <label for="Especif" class="form-label">Nuevo Especificación:</label>
                <input type="text" class="form-control" id="Especif" name="Especif" placeholder="Ingresa la Nueva Especificación">
                <div class="invalid-feedback">
                    Por favor, ingresa la Especificación de la Empres.
                </div>
            </div>

            <div class="mb-3">
                <label for="IdCCate" class="form-label">Categoría:</label>
                <select class="form-select mb-3" id="IdCCate" name="IdCCate" required>
                    <option value="" selected disabled>-- Seleccionar Categoría --</option>
                    <?php
                        $sql_tallas = $conexion->query("SELECT * FROM CCategorias;");
                        while ($resultado_talla = $sql_tallas->fetch_assoc()) {
                            echo "<option value='" . $resultado_talla['IdCCate'] . "'>" . $resultado_talla['Descrp'] . "</option>";
                        }
                    ?>
                    <option value="nueva_Cate">Agregar Nueva Categoría</option>
                </select>
                <div class="invalid-feedback">
                    Por favor, selecciona una opción.
                </div>
            </div>

            <!-- Agregar div para la nueva talla (inicialmente oculto) -->
            <div id="nuevaCateDiv" class="mb-3" style="display: none;">
                <label for="Descrp" class="form-label">Nueva Categoría del Producto:</label>
                <input type="text" class="form-control" id="Descrp" name="Descrp" placeholder="Ingresa la Nueva Categoría del Producto">
                <div class="invalid-feedback">
                    Por favor, ingresa la Nueva Categoría del Producto.
                </div>
            </div>

            <div class="mb-3">
                <label for="Especificaciones" class="form-label">Descripción del Producto:</label>
                <textarea id="Descripcion" name="Descripcion" id="Descripcion" class="form-control" placeholder="Ingresa la Descripción del Producto" required></textarea>
                <div class="invalid-feedback">
                    Por favor, ingresa la Descripción del Producto.
                </div>
            </div>

            <div class="mb-3">
                <label for="Especificaciones" class="form-label">Especificación del Producto:</label>
                <textarea id="Especificacion" name="Especificacion" class="form-control" placeholder="Ingresa la Especificación del Producto" required></textarea>
                <div class="invalid-feedback">
                    Por favor, ingresa la Especificación del Producto.
                </div>
            </div>

            <div class="mb-3">
                <label for="IdCTipTall" class="form-label">Tipo de Talla:</label>
                <select class="form-select mb-3" id="IdCTipTall" name="IdCTipTall" required onchange="showHideSections(this.value);">
                    <option value="" selected disabled>-- Seleccionar Tipo de Talla --</option>
                    <?php
                    $sql1 = $conexion->query("SELECT * FROM CTipoTallas;");
                    while ($resultado1 = $sql1->fetch_assoc()) {
                        echo "<option value='" . $resultado1['IdCTipTall'] . "'>" . $resultado1['Descrip'] . "</option>";
                    }
                    ?>
                    <option value="nueva_TipTall">Agregar Nuevo Tipo de Talla</option>
                </select>
                <div class="invalid-feedback">
                    Por favor, selecciona una opción.
                </div>
            </div>

            <!-- Agregar div para la nueva talla (inicialmente oculto) -->
            <div id="nuevaTipTalls" class="mb-3" style="display: none;">
                <label for="descrip" class="form-label">Nuevo Tipo de Talla del Producto:</label>
                <input type="text" class="form-control" id="descrip" name="descrip" placeholder="Ingresa la Nueva Categoría del Producto">
                <div class="invalid-feedback">
                    Por favor, ingresa el Nuevo Tipo de Talla.
                </div>
                <br>
                <label for="Talla" class="form-label">Descripcion:</label>
                <input type="text" class="form-control" id="Talla" name="Talla" placeholder="Ingresa la Nueva Categoría del Producto">
                <div class="invalid-feedback">
                    Por favor, ingresa la Nueva Descripcion.
                </div>
            </div>

            <div class="mb-3">
                <label for="Imagen" class="form-label">Subir Imagen:</label>
                <input type="file" class="form-control" id="Imagen" name="Imagen" required>
                <div class="invalid-feedback">
                    Por favor, completa el campo.
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
                <a href="../Producto_ALMACENISTA.php" class="btn btn-danger">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php include('footer.php'); ?>