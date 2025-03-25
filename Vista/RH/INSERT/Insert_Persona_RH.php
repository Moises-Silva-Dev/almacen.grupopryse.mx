<?php include('head.php'); ?>

<div class="container mt-5">
<center><h2>Registrar Nuevo Recluta</h2></center>
    <form id="FormInsertPersonaNueva" class="needs-validation" action="../../../Controlador/Usuarios/INSERT/Funcion_Insert_Persona.php" method="POST" enctype="multipart/form-data" novalidate>
    
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
                        <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Ingresa el Nombre del Proveedor" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa el Nombre.
                        </div>
                    </div>
            
                    <div class="mb-3">
                        <label class="form-label"  for="ap_paterno" class="form-label">Apellido Paterno:</label>
                        <input type="text" class="form-control" id="ap_paterno" name="ap_paterno" placeholder="Ingresa el Apellido Paterno" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa el Apellido Paterno.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"  for="ap_materno" class="form-label">Apellido Materno:</label>
                        <input type="text" class="form-control" id="ap_materno" name="ap_materno" placeholder="Ingresa el Apellido Materno" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa el Apellido Materno.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"  for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" required><br>
                        <div class="invalid-feedback">
                            Por favor, ingresa la Fecha de Nacimiento.
                        </div>
                    </div>
            
                    <div class="mb-3">
                        <label class="form-label"  for="estado_nacimiento">Estado de Nacimiento:</label>
                        <input type="text" class="form-control" id="estado_nacimiento" name="estado_nacimiento" placeholder="Ingresa el Estado" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el Estado de Nacimiento.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"  for="municipio_nacimiento">Municipio de Nacimiento:</label>
                        <input type="text" class="form-control" id="municipio_nacimiento" name="municipio_nacimiento" placeholder="Ingresa el Municipio" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el Municipio de Nacimiento.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="sexo">Sexo:</label>
                        <select class="form-select" id="sexo" name="sexo" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, selecciona una opción.
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
                        <label class="form-label" for="estado_civil">Estado Civil:</label>
                        <select class="form-select" id="estado_civil" name="estado_civil" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="Soltero/a">Soltero/a</option>
                            <option value="Casado/a">Casado/a</option>
                            <option value="Divorciado/a">Divorciado/a</option>
                            <option value="Viudo/a">Viudo/a</option>
                            <option value="Unión Libre">Unión Libre</option>
                            <option value="Separado/a">Separado/a</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, selecciona una opción.
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
                        <label class="form-label" for="escuela">Escuela:</label>
                        <input type="text" class="form-control" id="escuela" name="escuela" placeholder="Ingresa la escuela" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa la escuela
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="especialidad">Especialidad:</label>
                        <input type="text" class="form-control" id="especialidad" name="especialidad" placeholder="Ingresa la Especialidad" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa la especialidad
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="rfc">RFC:</label>
                        <input type="text" class="form-control" id="rfc" name="rfc" placeholder="Ingresa el RFC" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el RFC
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="elector">Elector:</label>
                        <input type="text" class="form-control" id="elector" name="elector" placeholder="Ingresa el Elector" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el Elector
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="cartilla">Cartilla:</label>
                        <input type="text" class="form-control" id="cartilla" name="cartilla" placeholder="Ingresa la Cartilla" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el RFC
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="curp">CURP:</label>
                        <input type="text" class="form-control" id="curp" name="curp" placeholder="Ingresa el CURP" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa el CURP
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="noolvides_el_matricula">Elector:</label>
                        <input type="text" class="form-control" id="noolvides_el_matricula" name="noolvides_el_matricula" placeholder="Ingresa la Matricula" required>
                        <div class="invalid-feedback">
                            Por favor, ingresa la Matricula
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="ID_Cuenta" class="form-label">Cuenta:</label>
                            <select class="form-select mb-3" id="ID_Cuenta" name="ID_Cuenta" required>
                                <option value="" selected disabled>-- Seleccionar Cuenta --</option>
                                    <?php 
                                        include('../../../Modelo/Conexion.php');  // incluir la conexión a la base de datos
                                        $conexion = (new Conectar())->conexion(); // Conectar a la base de datos
                                        $sql = $conexion->query("SELECT * FROM Cuenta;"); // Consulta a la base de datos
                                        while ($resultado = $sql->fetch_assoc()) { // Recorrer los resultados de la consulta
                                            echo "<option value='" . $resultado['ID'] . "'>" . $resultado['NombreCuenta'] . "</option>"; // Mostrar los resultados
                                        }
                                    ?>
                            </select>
                        <div class="invalid-feedback">
                            Por favor, selecciona una opción.
                        </div>
                    </div>

                    <h3>Cargar imágenes de persona</h3>
                    <div style="display: flex; gap: 20px;">
                        <div class="mb-3">
                            <label class="form-label" for="imagen_izquierda">Imagen Izquierda:</label>
                            <input type="file" class="form-control" name="imagen_izquierda" id="imagen_izquierda" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="imagen_frente">Imagen Frente:</label>
                            <input type="file" class="form-control" name="imagen_frente" id="imagen_frente" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="imagen_derecha">Imagen Derecha:</label>
                            <input type="file" class="form-control" name="imagen_derecha" id="imagen_derecha" accept="image/*" required>
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
                        <input type="text" class="form-control" id="tipo_sangre" name="tipo_sangre" placeholder="Ingresa el Tipo de Sangre" maxlength="3" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa el Tipo de Sangre.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="factor_rh">Factor RH:</label>
                        <input type="text" name="factor_rh" id="factor_rh" class="form-control" placeholder="Ingresa el Factor RH" maxlength="1" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa el Factor RH.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="lentes">¿Usa lentes?:</label>
                        <select name="lentes" id="lentes" class="form-select" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="Sí">Sí</option>
                            <option value="No">No</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, Selecciona una opción.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="estatura">Estatura (en metros):</label>
                        <input type="number" name="estatura" id="estatura" step="0.01" class="form-control" placeholder="Ingresa la Estatura" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa la Estatura.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="peso">Peso (en kg):</label>
                        <input type="number" name="peso" id="peso" step="0.01" class="form-control" placeholder="Ingresa el Peso" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa el Peso.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="complexion">Complexión:</label>
                        <input type="text" name="complexion" id="complexion" maxlength="20" class="form-control" placeholder="Ingresa la Complexión" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa la Complexión.   
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="alergias">Alergias:</label>
                        <input type="text" name="alergias" id="alergias" maxlength="50" class="form-control" placeholder="Ingresa las Alergias" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa la Alergia.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="nombre_SOS">Nombre de Contacto de Emergencia:</label>
                        <input type="text" name="nombre_SOS" id="nombre_SOS" maxlength="50" class="form-control" placeholder="Ingresa el Contacto de Emergencia" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa Nombes de Contacto de Emergencia.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="parentesco_SOS">Parentesco:</label>
                        <input type="text" name="parentesco_SOS" id="parentesco_SOS" maxlength="50" class="form-control" placeholder="Ingresa el Parentesco" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa el Parentesco.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="contactoTel_SOS">Teléfono de Emergencia:</label>
                        <input type="text" name="contactoTel_SOS" id="contactoTel_SOS" maxlength="11" pattern="\d{10,11}" class="form-control" placeholder="Ingresa el Telefono de Emergencias" title="Introduce un número válido (10-11 dígitos)" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa el numero de telefono.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="altaimss">Altas Médicas:</label>
                        <input type="text" name="altaimss" id="altaimss" maxlength="50" class="form-control" placeholder="Ingresa las Altas Médicas" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa la Altas Médicas.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="padecimientos">Padecimientos:</label>
                        <input type="text" name="padecimientos" id="padecimientos" maxlength="50" class="form-control" placeholder="Ingresa los Padecimientos" required>
                        <div class="invalid-feedback">
                            Por favor, Ingresa el Padecimientos.
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
    <br>

        <button type="submit" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                <path d="M16 19h6" />
                <path d="M19 16v6" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
            </svg>Guardar
        </button>
        <button type="button" class="btn btn-danger" onclick="window.location.href='../Personas_RH.php'">
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

<script src="../../../js/SweetAlertNotificaciones/Notificacion_SweetAlert_Insertar_Persona.js"></script>

<?php include('footer.php'); ?>