<?php include('head.php'); ?>

<?php
// Verifica si la variable $_GET['id'] está definida y no es nula
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $ID_Persona = $_GET['id'];

    // Realiza la consulta para obtener la información de la región
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();
    $consulta = $conexion->prepare("SELECT * 
                                    FROM 
                                        Persona_IMG P
                                    INNER JOIN
                                        Extras E ON P.ID_Persona = E.ID_Person
                                    LEFT JOIN 
                                        Persona_Cuenta PU ON P.ID_Persona = PU.ID_Personas
                                    LEFT JOIN 
                                        Cuenta C ON PU.ID_Cuentas = C.ID
                                    WHERE
                                        P.ID_Persona = ?");

    $consulta->bind_param("i", $ID_Persona);
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
    <center><h2>Modificar información Persona</h2></center>

    <!-- Formulario -->
    <form id="FormUpdatePersona" class="needs-validation" action="../../../Controlador/Usuarios/UPDATE/Funcion_Update_Persona.php" method="post" enctype="multipart/form-data" novalidate>
    <input type="hidden" id="ID_Persona" name="ID_Persona" value="<?php echo $ID_Persona; ?>" >
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header " id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Información General
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="mb-3">
                        <label class="form-label"  for="nombres" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo $row['Nombres']; ?>" placeholder="Ingresa el Nombre del Proveedor" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa el Nombre.
                        </div>
                    </div>
            
                    <div class="mb-3">
                        <label class="form-label"  for="ap_paterno" class="form-label">Apellido Paterno:</label>
                        <input type="text" class="form-control" id="ap_paterno" name="ap_paterno" value="<?php echo $row['Ap_paterno']; ?>" placeholder="Ingresa el Apellido Paterno" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa el Apellido Paterno.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"  for="ap_materno" class="form-label">Apellido Materno:</label>
                        <input type="text" class="form-control" id="ap_materno" name="ap_materno" value="<?php echo $row['Ap_materno']; ?>" placeholder="Ingresa el Apellido Materno" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa el Apellido Materno.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"  for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo $row['Fecha_nacimiento']; ?>" required><br>
                        <div class="invalid-feedback">
                            Por favor, ingresa la Fecha de Nacimiento.
                        </div>
                    </div>
            
                    <div class="mb-3">
                        <label class="form-label"  for="estado_nacimiento">Estado de Nacimiento:</label>
                        <input type="text" class="form-control" id="estado_nacimiento" name="estado_nacimiento" value="<?php echo $row['Estado_nacimiento']; ?>" placeholder="Ingresa el Estado" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el Estado de Nacimiento.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"  for="municipio_nacimiento">Municipio de Nacimiento:</label>
                        <input type="text" class="form-control" id="municipio_nacimiento" name="municipio_nacimiento" value="<?php echo $row['Municipio_nacimiento']; ?>" placeholder="Ingresa el Municipio" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el Municipio de Nacimiento.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="sexo">Sexo:</label>
                        <select class="form-select" id="sexo" name="sexo" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="M" <?php echo ($row['Sexo'] == 'M') ? 'selected' : ''; ?>>Masculino</option>
                            <option value="F" <?php echo ($row['Sexo'] == 'F') ? 'selected' : ''; ?>>Femenino</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, selecciona una opción.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="telefono">Teléfono:</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $row['Telefono']; ?>" pattern="\d{10}" placeholder="Ingresa el Numero Telefonico" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el Numero Telefonico
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="estado_civil">Estado Civil:</label>
                        <select class="form-select" id="estado_civil" name="estado_civil" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="Soltero/a" <?php echo ($row['Estado_civil'] == 'Soltero/a') ? 'selected' : ''; ?>>Soltero/a</option>
                            <option value="Casado/a" <?php echo ($row['Estado_civil'] == 'Casado/a') ? 'selected' : ''; ?>>Casado/a</option>
                            <option value="Divorciado/a" <?php echo ($row['Estado_civil'] == 'Divorciado/a') ? 'selected' : ''; ?>>Divorciado/a</option>
                            <option value="Viudo/a" <?php echo ($row['Estado_civil'] == 'Viudo/a') ? 'selected' : ''; ?>>Viudo/a</option>
                            <option value="Unión Libre" <?php echo ($row['Estado_civil'] == 'Unión Libre/a') ? 'selected' : ''; ?>>Unión Libre</option>
                            <option value="Separado/a" <?php echo ($row['Estado_civil'] == 'Separado/a') ? 'selected' : ''; ?>>Separado/a</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, selecciona una opción.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="escolaridad">Escolaridad:</label>
                        <select class="form-select" id="escolaridad" name="escolaridad" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="Primaria" <?php echo ($row['Escolaridad_maxima'] == 'Primaria') ? 'selected' : ''; ?>>Primaria</option>
                            <option value="Secundaria" <?php echo ($row['Escolaridad_maxima'] == 'Secundaria') ? 'selected' : ''; ?>>Secundaria</option>
                            <option value="Preparatoria" <?php echo ($row['Escolaridad_maxima'] == 'Preparatoria') ? 'selected' : ''; ?>>Preparatoria</option>
                            <option value="Licenciatura" <?php echo ($row['Escolaridad_maxima'] == 'Licenciatura') ? 'selected' : ''; ?>>Licenciatura</option>
                            <option value="Maestría" <?php echo ($row['Escolaridad_maxima'] == 'Maestría') ? 'selected' : ''; ?>>Maestría</option>
                            <option value="Doctorado" <?php echo ($row['Escolaridad_maxima'] == 'Doctorado') ? 'selected' : ''; ?>>Doctorado</option>
                            <option value="Otro" <?php echo ($row['Escolaridad_maxima'] == 'Otro') ? 'selected' : ''; ?>>Otro</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, selecciona una opción.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="escuela">Escuela:</label>
                        <input type="text" class="form-control" id="escuela" name="escuela" value="<?php echo $row['Escuela']; ?>" placeholder="Ingresa la escuela" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa la escuela
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="especialidad">Especialidad:</label>
                        <input type="text" class="form-control" id="especialidad" name="especialidad" value="<?php echo $row['Especialidad']; ?>" placeholder="Ingresa la Especialidad" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa la especialidad
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="rfc">RFC:</label>
                        <input type="text" class="form-control" id="rfc" name="rfc" value="<?php echo $row['Rfc']; ?>" placeholder="Ingresa el RFC" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el RFC
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="elector">Elector:</label>
                        <input type="text" class="form-control" id="elector" name="elector" value="<?php echo $row['Elector']; ?>" placeholder="Ingresa el Elector" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el Elector
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="cartilla">Cartilla:</label>
                        <input type="text" class="form-control" id="cartilla" name="cartilla" value="<?php echo $row['Cartilla']; ?>" placeholder="Ingresa la Cartilla" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el RFC
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="curp">CURP:</label>
                        <input type="text" class="form-control" id="curp" name="curp" value="<?php echo $row['Curp']; ?>" placeholder="Ingresa el CURP" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el CURP
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="noolvides_el_matricula">Elector:</label>
                        <input type="text" class="form-control" id="noolvides_el_matricula" name="noolvides_el_matricula" value="<?php echo $row['Noolvides_el_matricula']; ?>" placeholder="Ingresa la Matricula" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa la Matricula
                        </div>
                    </div>

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
                        <label for="Imagen" class="form-label">¿Subir Nuevas Fotos Imagenes?</label>
                        <select class="form-select" id="opcion" name="opcion" onchange="mostrarOcultarInput()" required>
                            <option value="" selected disabled>-- Selecciona una Opción --</option>
                            <option value="SI">Sí</option>
                            <option value="NO">No</option>
                        </select>
                    </div>

                    <div class="mb-3" id="campoImagen" style="display:none;">
                        <h3>Cargar imágenes de persona</h3>
                        <div style="display: flex; gap: 20px;">
                            <div class="mb-3">
                                <label class="form-label" for="imagen_izquierda">Imagen Izquierda:</label>
                                <input type="file" class="form-control" name="imagen_izquierda" id="imagen_izquierda" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="imagen_frente">Imagen Frente:</label>
                                <input type="file" class="form-control" name="imagen_frente" id="imagen_frente" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="imagen_derecha">Imagen Derecha:</label>
                                <input type="file" class="form-control" name="imagen_derecha" id="imagen_derecha" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Datos Extras
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="mb-3">
                        <label class="form-label" for="tipo_sangre" class="form-label">Tipo de Sangre:</label>
                        <input type="text" class="form-control" id="tipo_sangre" name="tipo_sangre" value="<?php echo $row['Tipo_sangre']; ?>" placeholder="Ingresa el Tipo de Sangre" maxlength="3" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa el Tipo de Sangre.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="factor_rh">Factor RH:</label>
                        <input type="text" name="factor_rh" id="factor_rh" class="form-control" value="<?php echo $row['Factor_rh']; ?>" placeholder="Ingresa el Factor RH" maxlength="1" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa el Factor RH.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="lentes">¿Usa lentes?:</label>
                        <select name="lentes" id="lentes" class="form-select" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="Sí" <?php echo ($row['Lentes'] == 'Sí') ? 'selected' : ''; ?>>Sí</option>
                            <option value="No" <?php echo ($row['Lentes'] == 'No') ? 'selected' : ''; ?>>No</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, Selecciona una opción.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="estatura">Estatura (en metros):</label>
                        <input type="number" name="estatura" id="estatura" value="<?php echo $row['Estatura']; ?>" step="0.01" class="form-control" placeholder="Ingresa la Estatura" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa la Estatura.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="peso">Peso (en kg):</label>
                        <input type="number" name="peso" id="peso" value="<?php echo $row['Peso']; ?>" step="0.01" class="form-control" placeholder="Ingresa el Peso" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa el Peso.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="complexion">Complexión:</label>
                        <input type="text" name="complexion" id="complexion" value="<?php echo $row['Complexion']; ?>" maxlength="20" class="form-control" placeholder="Ingresa la Complexión" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa la Complexión.   
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="alergias">Alergias:</label>
                        <input type="text" name="alergias" id="alergias" value="<?php echo $row['Alergias']; ?>" maxlength="50" class="form-control" placeholder="Ingresa las Alergias" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa la Alergia.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="nombre_SOS">Nombre de Contacto de Emergencia:</label>
                        <input type="text" name="nombre_SOS" id="nombre_SOS" value="<?php echo $row['Nombre_SOS']; ?>" maxlength="50" class="form-control" placeholder="Ingresa el Contacto de Emergencia" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa Nombes de Contacto de Emergencia.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="parentesco_SOS">Parentesco:</label>
                        <input type="text" name="parentesco_SOS" id="parentesco_SOS" value="<?php echo $row['Parentesco_SOS']; ?>" maxlength="50" class="form-control" placeholder="Ingresa el Parentesco" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa el Parentesco.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="contactoTel_SOS">Teléfono de Emergencia:</label>
                        <input type="text" name="contactoTel_SOS" id="contactoTel_SOS" value="<?php echo $row['ContactoTel_SOS']; ?>" maxlength="11" pattern="\d{10,11}" class="form-control" placeholder="Ingresa el Telefono de Emergencias" title="Introduce un número válido (10-11 dígitos)" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa el numero de telefono.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="altaimss">Altas Médicas:</label>
                        <input type="text" name="altaimss" id="altaimss" value="<?php echo $row['Altaimss']; ?>" maxlength="50" class="form-control" placeholder="Ingresa las Altas Médicas" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa la Altas Médicas.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="padecimientos">Padecimientos:</label>
                        <input type="text" name="padecimientos" id="padecimientos" value="<?php echo $row['Padecimientos']; ?>" maxlength="50" class="form-control" placeholder="Ingresa los Padecimientos" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa el Padecimientos.
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
    <br>

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

<script src="../../../js/Form_Producto_Update.js"></script>
<script src="../../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Update_Persona.js"></script>

<?php include('footer.php'); ?>