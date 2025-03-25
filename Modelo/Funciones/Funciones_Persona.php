<?php
function InsertarNuevoPersona($conexion, $nombres, $ap_paterno, $ap_materno, $fecha_nacimiento, $estado_nacimiento, $municipio_nacimiento, $sexo, $telefono, $estado_civil, $escolaridad, $escuela, $especialidad, $rfc, $elector, $cartilla, $curp, $noolvides_el_matricula){
    // Preparar la consulta SQL para la inserción
    $SetenciaInsertarNuevoRecluta = "INSERT INTO Persona_IMG (Nombres, Ap_paterno, Ap_materno, Fecha_nacimiento, Estado_nacimiento, Municipio_nacimiento, Sexo, Telefono, Estado_civil, Escolaridad_maxima, Escuela, Especialidad, Rfc, Elector, Cartilla, Curp, Noolvides_el_matricula) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Preparar la sentencia
    $StmtInsertarNuevoRecluta = $conexion->prepare($SetenciaInsertarNuevoRecluta);

    // Vincular los parámetros
    $StmtInsertarNuevoRecluta->bind_param("sssssssssssssssss", $nombres, $ap_paterno, $ap_materno, $fecha_nacimiento, $estado_nacimiento, $municipio_nacimiento, $sexo, $telefono, $estado_civil, $escolaridad, $escuela, $especialidad, $rfc, $elector, $cartilla, $curp, $noolvides_el_matricula);

    // Ejecutar la consulta de inserción
    if ($StmtInsertarNuevoRecluta->execute()) {
        return $conexion->insert_id; // Devuelve el ID de la fila insertada
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar categoría: " . $conexion->error);
    }
}

function ActualizarPersona($conexion, $nombres, $ap_paterno, $ap_materno, $fecha_nacimiento, $estado_nacimiento, $municipio_nacimiento, $sexo, $telefono, $estado_civil, $escolaridad, $escuela, $especialidad, $rfc, $elector, $cartilla, $curp, $noolvides_el_matricula, $ID_Persona) {
    // Preparar la consulta SQL para la inserción
    $SetenciaActualizarPersona = "UPDATE Persona_IMG SET Nombres = ?, Ap_paterno = ?, Ap_materno = ?, Fecha_nacimiento = ?, Estado_nacimiento = ?, Municipio_nacimiento = ?, Sexo = ?, Telefono = ?, Estado_civil = ?, Escolaridad_maxima = ?, Escuela = ?, Especialidad = ?, Rfc = ?, Elector = ?, Cartilla = ?, Curp = ?, Noolvides_el_matricula = ? WHERE ID_Persona = ?";
    
    // Preparar la sentencia
    $StmtActualizarPersona = $conexion->prepare($SetenciaActualizarPersona);

    // Vincular los parámetros
    $StmtActualizarPersona->bind_param("sssssssssssssssssi", $nombres, $ap_paterno, $ap_materno, $fecha_nacimiento, $estado_nacimiento, $municipio_nacimiento, $sexo, $telefono, $estado_civil, $escolaridad, $escuela, $especialidad, $rfc, $elector, $cartilla, $curp, $noolvides_el_matricula, $ID_Persona);

    // Ejecutar la consulta de inserción
    if ($StmtActualizarPersona->execute()) {
        return true; // Devuelve true si la actualización fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar categoría: " . $conexion->error);
    }
}

function InsertarExtraInformacion($conexion, $ID_Persona, $tipo_sangre, $factor_rh, $lentes, $estatura, $peso, $complexion, $alergias, $nombre_SOS, $parentesco_SOS, $contactoTel_SOS, $altaimss, $padecimientos){
    // Preparar la consulta SQL para la inserción
    $SetenciaInsertarExtraInformacion = "INSERT INTO Extras (ID_Person, Tipo_sangre, Factor_rh, Lentes, Estatura, Peso, Complexion, Alergias, Nombre_SOS, Parentesco_SOS, ContactoTel_SOS, Altaimss, Padecimientos) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar la sentencia
    $StmtInsertarExtraInformacion = $conexion->prepare($SetenciaInsertarExtraInformacion);

    // Vincular los parámetros
    $StmtInsertarExtraInformacion->bind_param("iisssssssssss", $ID_Persona, $tipo_sangre, $factor_rh, $lentes, $estatura, $peso, $complexion, $alergias, $nombre_SOS, $parentesco_SOS, $contactoTel_SOS, $altaimss, $padecimientos);

    // Ejecutar la consulta de inserción
    if ($StmtInsertarExtraInformacion->execute()) {
        return true; // Devuelve true si la inserción se realizó correctamente
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar categoría: " . $conexion->error);
    }
}

function ActualizarExtraInformacion($conexion, $tipo_sangre, $factor_rh, $lentes, $estatura, $peso, $complexion, $alergias, $nombre_SOS, $parentesco_SOS, $contactoTel_SOS, $altaimss, $padecimientos, $ID_Persona) {
    // Preparar la consulta SQL para la inserción
    $SetenciaInsertarExtraInformacion = "UPDATE Extras SET Tipo_sangre = ?, Factor_rh = ?, Lentes = ?, Estatura = ?, Peso = ?, Complexion = ?, Alergias = ?, Nombre_SOS = ?, Parentesco_SOS = ?, ContactoTel_SOS = ?, Altaimss = ?, Padecimientos = ? WHERE ID_Person = ?";

    // Preparar la sentencia
    $StmtInsertarExtraInformacion = $conexion->prepare($SetenciaInsertarExtraInformacion);

    // Vincular los parámetros
    $StmtInsertarExtraInformacion->bind_param("ssssssssssssi", $tipo_sangre, $factor_rh, $lentes, $estatura, $peso, $complexion, $alergias, $nombre_SOS, $parentesco_SOS, $contactoTel_SOS, $altaimss, $padecimientos, $ID_Persona);

    // Ejecutar la consulta de inserción
    if ($StmtInsertarExtraInformacion->execute()) {
        return true; // Devuelve true si la inserción se realizó correctamente
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar categoría: " . $conexion->error);
    }
}

function ActualizarFotosPersona($conexion, $Fotos, $ID_Persona) {
    // Preparar la consulta SQL para la actualización
    $SetenciaActualizarFotosPersona = "UPDATE Persona_IMG SET Imagen_frente = ?, Imagen_izquierda = ?, Imagen_derecha = ? WHERE ID_Persona = ?";

    // Preparar la sentencia
    $StmtActualizarFotosPersona = $conexion->prepare($SetenciaActualizarFotosPersona);

    // Vincular los parámetros
    $StmtActualizarFotosPersona->bind_param("sssi", $Fotos["frente"], $Fotos["izquierda"], $Fotos["derecha"], $ID_Persona);

    // Ejecutar la consulta de actualización
    if ($StmtActualizarFotosPersona->execute()) {
        return true; // Devuelve true si la actualización se realizó correctamente
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al actualizar fotos de persona: " . $conexion->error);
    }
}

function InsertarPersonaCuenta($conexion, $ID_Persona, $ID_Cuenta) {
    // Preparar la consulta SQL para la inserción
    $SetenciaInsertarPersonaCuenta = "INSERT INTO Persona_Cuenta (ID_Personas, ID_Cuentas) VALUES (?, ?)";
    
    // Preparar la sentencia
    $StmtInsertarPersonaCuenta = $conexion->prepare($SetenciaInsertarPersonaCuenta);

    // Vincular los parámetros
    $StmtInsertarPersonaCuenta->bind_param("ii", $ID_Persona, $ID_Cuenta);

    // Ejecutar la consulta de inserción
    if ($StmtInsertarPersonaCuenta->execute()) {
        return true; // Devuelve true si se insertó correctamente
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar categoría: " . $conexion->error);
    }
}

function UpdatePersonaCuenta($conexion, $ID_Cuenta, $ID_Persona) {
    // Preparar la consulta SQL para la inserción
    $SetenciaInsertarPersonaCuenta = "UPDATE Persona_Cuenta SET ID_Cuentas = ? WHERE ID_Personas = ?";
    
    // Preparar la sentencia
    $StmtInsertarPersonaCuenta = $conexion->prepare($SetenciaInsertarPersonaCuenta);

    // Vincular los parámetros
    $StmtInsertarPersonaCuenta->bind_param("ii", $ID_Cuenta, $ID_Persona);

    // Ejecutar la consulta de inserción
    if ($StmtInsertarPersonaCuenta->execute()) {
        return true; // Devuelve true si se insertó correctamente
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar categoría: " . $conexion->error);
    }
}

// Función para subir la imagen del producto.
function subirImagenesPersona($ID_Persona, $imagen_izquierda, $imagen_frente, $imagen_derecha) {
    $Puntos = "../../../";
    $targetDir = "img/Persona/" . $ID_Persona . "/";

    // Crear el directorio si no existe
    if (!file_exists($Puntos . $targetDir)) {
        mkdir($Puntos . $targetDir, 0777, true);
    }

    // Tipos de archivo permitidos
    $allowedTypes = array('jpg', 'jpeg', 'png');

    // Obtener las extensiones de los archivos originales
    $ext_izquierda = strtolower(pathinfo($imagen_izquierda["name"], PATHINFO_EXTENSION));
    $ext_frente = strtolower(pathinfo($imagen_frente["name"], PATHINFO_EXTENSION));
    $ext_derecha = strtolower(pathinfo($imagen_derecha["name"], PATHINFO_EXTENSION));

    // Verificar si las extensiones son permitidas
    if (!in_array($ext_izquierda, $allowedTypes) || !in_array($ext_frente, $allowedTypes) || !in_array($ext_derecha, $allowedTypes)) {
        throw new Exception("Error: Solo se permiten archivos JPG, JPEG o PNG.");
    }

    // Generar nombres únicos
    $filename_izquierda = uniqid('IMG_Izquierda_') . '.' . $ext_izquierda;
    $filename_frente = uniqid('IMG_Frente_') . '.' . $ext_frente;
    $filename_derecha = uniqid('IMG_Derecha_') . '.' . $ext_derecha;

    // Rutas finales
    $FileFinal_izquierda = $targetDir . $filename_izquierda;
    $FileFinal_frente = $targetDir . $filename_frente;
    $FileFinal_derecha = $targetDir . $filename_derecha;

    $targetFile_izquierda = $Puntos . $FileFinal_izquierda;
    $targetFile_frente = $Puntos . $FileFinal_frente;
    $targetFile_derecha = $Puntos . $FileFinal_derecha;

    // Mover archivos y verificar éxito
    if (!move_uploaded_file($imagen_izquierda["tmp_name"], $targetFile_izquierda) ||
        !move_uploaded_file($imagen_frente["tmp_name"], $targetFile_frente) ||
        !move_uploaded_file($imagen_derecha["tmp_name"], $targetFile_derecha)) {
        throw new Exception("Error al subir los archivos.");
    }

    // Retornar las rutas de los archivos subidos
    return [
        "izquierda" => $FileFinal_izquierda,
        "frente" => $FileFinal_frente,
        "derecha" => $FileFinal_derecha
    ];
}

// Función para eliminar la Imagenes de la persona
function DeleteIMGProducto($conexion, $ID_Persona) {
    // Obtener la ruta del directorio de imágenes
    $IMG_Frente = ""; 
    $IMG_Izquierda = "";
    $IMG_Derecha = "";

    // Consulta para obtener la ruta de las imágenes
    $SetenciaEliminarIMGPersona = "SELECT Imagen_frente, Imagen_izquierda, Imagen_derecha FROM Persona_IMG WHERE ID_Persona = ?";

    // Preparar la sentencia
    $StmtEliminarIMGPersona = $conexion->prepare($SetenciaEliminarIMGPersona);

    // Ejecutar la sentencia
    $StmtEliminarIMGPersona->bind_param("i", $ID_Persona);

    // Ejecutar la sentencia
    $StmtEliminarIMGPersona->execute();

    // Obtener los resultados
    $StmtEliminarIMGPersona->bind_result($IMG_Frente, $IMG_Izquierda, $IMG_Derecha);

    // Obtener los resultados
    if ($StmtEliminarIMGPersona->fetch()) {
        // Eliminar las imágenes
        $StmtEliminarIMGPersona->close();

        // Eliminar la imagen de la persona
        $imagenes = [$IMG_Frente, $IMG_Izquierda, $IMG_Derecha];

        // Eliminar las imágenes
        foreach ($imagenes as $imagen) {
            // Eliminar la imagen   
            if ($imagen && file_exists("../../../" . $imagen)) {
                // Eliminar la imagen
                unlink("../../../" . $imagen);
            }
        }
        return true; // Imagenes eliminadas correctamente
    } else {
        $StmtEliminarIMGPersona->close(); // Cerrar la sentencia
        return false; // No se encontraron imágenes para eliminar
    }
}
?>