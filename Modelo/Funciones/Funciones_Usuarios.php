<?php
// Función para obtener el ID del usuario a partir del correo electrónico
function ObtenerIdentificadorUsuario($conexion, $usuario) {
    // Consulta SQL para obtener el ID del usuario
    $SetenciaExistenciaIDUsuario = "SELECT ID_Usuario FROM Usuario WHERE Correo_Electronico = ?";

    // Preparar la sentencia SQL
    $StmtExistenciaIDUsuario = $conexion->prepare($SetenciaExistenciaIDUsuario);

    // Ejecutar la sentencia SQL
    $StmtExistenciaIDUsuario->bind_param("s", $usuario);

    // Ejecutar la sentencia SQL
    $StmtExistenciaIDUsuario->execute();

    // Obtener los resultados
    $ResultadoStmtExistenciaIDUsuario = $StmtExistenciaIDUsuario->get_result();

    // Verificamos si la consulta devolvió alguna fila
    if ($ResultadoStmtExistenciaIDUsuario->num_rows > 0) {
        // Verificar si se encontraron resultados
        $fila = $ResultadoStmtExistenciaIDUsuario->fetch_assoc();

        // Si se encontró un resultado, obtener el ID del usuario
        return $fila['ID_Usuario'];
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar nueva región: " . $conexion->error);
    }
}

// Función para verificar si el correo electrónico ya está registrado
function VerificarCorreoExistente($conexion, $correo_electronico) {
    // Preparar la consulta SQL
    $SetenciaExistenciaCorreo = "SELECT ID_Usuario FROM Usuario WHERE Correo_Electronico = ?";

    // Preparar la sentencia SQL
    $StmtExistenciaCorreo= $conexion->prepare($SetenciaExistenciaCorreo);

    // Ejecutar la sentencia SQL
    $StmtExistenciaCorreo->bind_param("s", $correo_electronico);

    // Ejecutar la sentencia SQL
    $StmtExistenciaCorreo->execute();

    // Obtener los resultados
    $StmtExistenciaCorreo->store_result();

    // Verificar si hay resultados
    $num_rows = $StmtExistenciaCorreo->num_rows;

    // Retorne el resultado
    if ($num_rows > 0) {
        return true; // El correo electrónico ya está registrado
    } else {
        // El correo electrónico no está registrado
        return false;
    }
}

// Función para insertar un nuevo usuario
function InsertarNuevoUsuario($conexion, $nombre, $apellido_materno, $apellido_paterno, $num_tel, $correo_electronico, $contrasena, $num_contacto_sos, $ID_Tipo) {
    // Preparar la consulta SQL para la inserción
    $SetenciaInsertarNuevoUsuario = "INSERT INTO Usuario (Nombre, Apellido_Paterno, Apellido_Materno, NumTel, Correo_Electronico, Constrasena, NumContactoSOS, ID_Tipo_Usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
    // Preparar la sentencia SQL
    $StmtInsertarNuevoUsuario = $conexion->prepare($SetenciaInsertarNuevoUsuario);

    // Enlazar los parámetros con los valores
    $StmtInsertarNuevoUsuario->bind_param("sssssssi", $nombre, $apellido_paterno, $apellido_materno, $num_tel, $correo_electronico, $contrasena, $num_contacto_sos, $ID_Tipo);

    // Ejecutar la consulta de inserción
    if ($StmtInsertarNuevoUsuario->execute()) {
        return $conexion->insert_id; // Devuelve el ID del último registro insertado
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar nueva región: " . $conexion->error);
    }
}

// Función para insertar un registro en la tabla Usuario_Cuenta
function InsertarNuevoUsuarioCuenta($conexion, $id_Usuario, $cuentaId) {
    // Comprobar si 'ID_Cuenta' está presente
    $SetenciaInsertarNuevoUsuarioCuenta = is_null($cuentaId) 
        ? "INSERT INTO Usuario_Cuenta (ID_Usuarios) VALUES (?);"
        : "INSERT INTO Usuario_Cuenta (ID_Usuarios, ID_Cuenta) VALUES (?, ?);";
        
    // Preparar la consulta
    $StmtInsertarNuevoUsuarioCuenta = $conexion->prepare($SetenciaInsertarNuevoUsuarioCuenta);

    // Vincular los parámetros
    if (is_null($cuentaId)) {
        $StmtInsertarNuevoUsuarioCuenta->bind_param("i", $id_Usuario);
    } else {
        $StmtInsertarNuevoUsuarioCuenta->bind_param("ii", $id_Usuario, $cuentaId);
    }

    // Ejecutar la consulta de inserción
    if ($StmtInsertarNuevoUsuarioCuenta->execute()) {
        return true; // Regresar true si la inserción fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de inserción.");
    }
}

// Función para eliminar un usuario con relación a su cuenta
function EliminarUsuarioCuenta($conexion, $id_Usuario) {
    // Preparar la consulta SQL para la eliminación
    $SetenciaEliminarUsuarioCuenta = "DELETE FROM Usuario_Cuenta WHERE ID_Usuarios = ?";
        
    // Preparar la sentencia SQL
    $StmtEliminarUsuarioCuenta = $conexion->prepare($SetenciaEliminarUsuarioCuenta);
    
    // Enlazar los parámetros con los valores
    $StmtEliminarUsuarioCuenta->bind_param("i", $id_Usuario);
    
    // Ejecutar la consulta de eliminado
    if ($StmtEliminarUsuarioCuenta->execute()) {
        return true; // Registro eliminado con éxito
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar nueva región: " . $conexion->error);
    }
}

function EliminarUsuario($conexion, $id_Usuario) {
    // Preparar la consulta SQL para la eliminación
    $SetenciaEliminarUsuario = "DELETE FROM Usuario WHERE ID_Usuario = ?";

    // Preparar la sentencia SQL
    $StmtEliminarUsuario = $conexion->prepare($SetenciaEliminarUsuario);

    // Enlazar los parámetros con los valores
    $StmtEliminarUsuario->bind_param("i", $id_Usuario);

    // Ejecutar la consulta de inserción
    if ($StmtEliminarUsuario->execute()) {
        return true; // Registro eliminado con éxito
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar nueva región: " . $conexion->error);
    }
}

// Función para actualizar usuario
function ActualizarUsuario($Opcion, $conexion, $nombre, $apellido_paterno, $apellido_materno, $num_tel, $correo_electronico, $contrasena, $num_contacto_sos, $id_Usuario) {
    if ($Opcion == "SI") {
        // Preparar la consulta SQL para actualizar el usuario sin ID_Cuenta
        $SetenciaActualizarUsuario = "UPDATE Usuario SET Nombre = ?, Apellido_Paterno = ?, Apellido_Materno = ?, NumTel = ?, Correo_Electronico = ?, Constrasena = ?, NumContactoSOS = ? WHERE ID_Usuario = ?";
        
        // Preparar la sentencia
        $StmtActualizarUsuario = $conexion->prepare($SetenciaActualizarUsuario);
        
        // Vincular parámetros
        $StmtActualizarUsuario->bind_param("sssssssi", $nombre, $apellido_paterno, $apellido_materno, $num_tel, $correo_electronico, $contrasena, $num_contacto_sos, $id_Usuario);
    } else {
        // Preparar la consulta SQL para actualizar el usuario con ID_Cuenta
        $SetenciaActualizarUsuario = "UPDATE Usuario SET Nombre = ?, Apellido_Paterno = ?, Apellido_Materno = ?, NumTel = ?, Correo_Electronico = ?, NumContactoSOS = ? WHERE ID_Usuario = ?";
        
        // Preparar la sentencia
        $StmtActualizarUsuario = $conexion->prepare($SetenciaActualizarUsuario);
        
        // Vincular parámetros
        $StmtActualizarUsuario->bind_param("ssssssi", $nombre, $apellido_paterno, $apellido_materno, $num_tel, $correo_electronico, $num_contacto_sos, $id_Usuario);
    }
    
    // Ejecutar la consulta
    if ($StmtActualizarUsuario->execute()) {
        return true; // Regresar true si la actualización fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de actualización.");
    }
}

// Función para actualizar el tipo de usuario en la tabla `Usuario`
function UpdateRolUsuario($conexion, $ID_Tipo, $id_Usuario) {
    // Consulta SQL para actualizar el tipo de usuario basado en su ID
    $SetenciaActualizarRolUsuario = "UPDATE Usuario SET ID_Tipo_Usuario = ? WHERE ID_Usuario = ?";
    
    // Preparamos la consulta
    $StmtActualizarRolUsuario = $conexion->prepare($SetenciaActualizarRolUsuario);
    
    // Vinculamos los parámetros: el tipo de usuario y el ID del usuario
    $StmtActualizarRolUsuario->bind_param("ii", $ID_Tipo, $id_Usuario);
    
    // Ejecutamos la consulta
    if ($StmtActualizarRolUsuario->execute()) {
        // Retornamos `true` para indicar que la actualización fue exitosa
        return true;
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error en la ejecución de la consulta de actualización.");
    }
}

// Función para obtener todas las cuentas vinculadas a un usuario y las requisiciones relacionadas
function BuscarCuentasUsuario($conexion, $id_Usuario) {
    // Consulta SQL que selecciona las cuentas vinculadas a un usuario y cuenta el total de requisiciones pendientes o autorizadas
    $SetenciaBuscarRequisicionCuentasUsuario = "SELECT 
                        C.ID, C.NombreCuenta,
                        COUNT(REQ.IDRequisicionE) AS TotalRequisiciones
                    FROM 
                        RequisicionE REQ
                    INNER JOIN 
                        Cuenta C ON REQ.IdCuenta = C.ID
                    INNER JOIN 
                        Usuario U ON REQ.IdUsuario = U.id_Usuario
                    WHERE 
                        REQ.Estatus IN ('Pendiente', 'Parcial', 'Autorizado') 
                    AND 
                        U.id_Usuario = ?
                    GROUP BY 
                        C.ID, C.NombreCuenta";
    
    // Preparamos la consulta
    $StmtBuscarRequisicionCuentasUsuario = $conexion->prepare($SetenciaBuscarRequisicionCuentasUsuario);
    
    // Vinculamos el parámetro: el ID del usuario
    $StmtBuscarRequisicionCuentasUsuario->bind_param("i", $id_Usuario);
    
    // Ejecutamos la consulta
    $StmtBuscarRequisicionCuentasUsuario->execute();
    
    // Obtenemos los resultados
    $ResultStmtBuscarRequisicionCuentasUsuario = $StmtBuscarRequisicionCuentasUsuario->get_result();

    // Verificamos si la consulta devolvió alguna fila
    if ($ResultStmtBuscarRequisicionCuentasUsuario->num_rows > 0) {
        // Creamos un array para almacenar los resultados
        $cuentas = array();
        
        // Recorremos las filas de los resultados
        while ($fila = $ResultStmtBuscarRequisicionCuentasUsuario->fetch_assoc()) {
            // Añadimos cada fila al array de cuentas
            $cuentas[] = $fila;
        }
        
        // Retornamos el array de cuentas
        return $cuentas;
    } else {
        // Si no hay resultados, retornamos `null` o un array vacío
        return null;
    }
}

// Función para verificar si un usuario ya está vinculado a una cuenta específica
function VerificarUsuarioCuenta($conexion, $id_Usuario, $id_Cuenta) {
    // Consulta SQL para contar cuántas veces aparece una combinación de `id_Usuarios` y `ID_Cuenta` en la tabla `Usuario_Cuenta`
    $SetenciaBuscarRelacionCuentasUsuario = "SELECT COUNT(*) AS total FROM Usuario_Cuenta WHERE id_Usuarios = ? AND ID_Cuenta = ?";
    
    // Preparamos la consulta
    $BuscarRelacionCuentasUsuario = $conexion->prepare($SetenciaBuscarRelacionCuentasUsuario);
    
    // Vinculamos los parámetros: el ID del usuario y el ID de la cuenta
    $BuscarRelacionCuentasUsuario->bind_param("ii", $id_Usuario, $id_Cuenta);
    
    // Ejecutamos la consulta
    $BuscarRelacionCuentasUsuario->execute();
    
    // Obtenemos el resultado
    $ResultBuscarRelacionCuentasUsuario = $BuscarRelacionCuentasUsuario->get_result();
    
    // Extraemos el resultado en un array asociativo
    $row = $ResultBuscarRelacionCuentasUsuario->fetch_assoc();

    // Retornamos `true` si el usuario está vinculado a la cuenta (total > 0), de lo contrario, `false`
    return $row['total'] > 0;
}
?>