<?php
// Función para insertar la entrada en la tabla DevolucionE
function InsertarNuevaDevolucionE($conexion, $Nombre_Devuelve, $Telefono_Devuelve, $Comentarios, $registro, $id_Usuario, $Opcion, $Identificador) {
    if ($Opcion == 'Requisicion') {
        // Preparar la sentencia SQL
        $SetenciaInsertarEntradaE = "INSERT INTO DevolucionE (Nombre_Devuelve, Telefono_Devuelve, Justificacion, Fch_Devolucion, IdUsuario, IdRequiE) VALUES (?,?,?,?,?,?)";
    } else if ($Opcion == 'Prestamo') {
        // Preparar la sentencia SQL
        $SetenciaInsertarEntradaE = "INSERT INTO DevolucionE (Nombre_Devuelve, Telefono_Devuelve, Justificacion, Fch_Devolucion, IdUsuario, IdPrestE) VALUES (?,?,?,?,?,?)";
    } else {
        // Preparar la sentencia SQL
        $SetenciaInsertarEntradaE = "INSERT INTO DevolucionE (Nombre_Devuelve, Telefono_Devuelve, Justificacion, Fch_Devolucion, IdUsuario) VALUES (?,?,?,?,?)";
    }
    
    // Preparar la sentencia SQL con los parámetros
    $StmtInsertarEntradaE = $conexion->prepare($SetenciaInsertarEntradaE);
    
    if ($Opcion == 'Requisicion' || $Opcion == 'Prestamo') {
        // Asignar los valores a los parámetros
        $StmtInsertarEntradaE->bind_param("ssssii", $Nombre_Devuelve, $Telefono_Devuelve, $Comentarios, $registro, $id_Usuario, $Identificador);
    } else {
        // Asignar los valores a los parámetros
        $StmtInsertarEntradaE->bind_param("ssssi", $Nombre_Devuelve, $Telefono_Devuelve, $Comentarios, $registro, $id_Usuario);
    }
    
    // Ejecutar la sentencia SQL
    if ($StmtInsertarEntradaE->execute()) {
        return $conexion->insert_id; // Devuelve el ID de la entrada recién insertada
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar nueva entradaE: " . $conexion->error);
    }
}

// Función para actualizar el estatus de la devolución
function ModificarEstatusDevolucionE($conexion, $id_DevolucionE, $Identificador, $Opcion) {
    if ($Opcion == 'Requisicion') { // Si es una requisición
        // Preparar la sentencia SQL para modificar el estatus de la devolución
        $SetenciaModificarEstatus = "SELECT
                            DE.IdDevolucionE AS ID_Devolucion,
                            RE.IDRequisicionE AS ID_Requisicion,
                            SUM(RD.Cantidad) AS Cantidad_Requerida,
                            IFNULL(SUM(SD.Cantidad), 0) AS Cantidad_Salida,
                            IFNULL(SUM(DD.Cantidad), 0) AS Cantidad_Devuelta
                        FROM DevolucionE DE
                        LEFT JOIN Requisicione RE ON DE.IdRequiE = RE.IDRequisicionE
                        LEFT JOIN Requisiciond RD ON RD.IdReqE = RE.IDRequisicionE
                        LEFT JOIN Salida_E SE ON SE.ID_ReqE = RE.IDRequisicionE
                        LEFT JOIN Salida_D SD ON SD.Id = SE.Id_SalE AND SD.IdCProd = RD.IdCProd AND SD.IdTallas = RD.IdTalla
                        LEFT JOIN DevolucionD DD ON DD.IdDevE = DE.IdDevolucionE AND DD.IdCProd = RD.IdCProd AND DD.IdTalla = RD.IdTalla
                        WHERE DE.IdRequiE = ?
                        GROUP BY DE.IdDevolucionE";

    } elseif ($Opcion == 'Prestamo') { // Si es un préstamo
        // Preparar la sentencia SQL para modificar el estatus de la devolución
        $SetenciaModificarEstatus = "SELECT
                            DE.IdDevolucionE AS ID_Devolucion,
                            PE.IdPrestamoE AS ID_Requisicion,
                            SUM(PD.Cantidad) AS Cantidad_Requerida,
                            IFNULL(SUM(SPD.Cantidad), 0) AS Cantidad_Salida,
                            IFNULL(SUM(DD.Cantidad), 0) AS Cantidad_Devuelta
                        FROM DevolucionE DE
                        LEFT JOIN PrestamoE PE ON DE.IdPrestE = PE.IdPrestamoE
                        LEFT JOIN PrestamoD PD ON PD.IdPresE = PE.IdPrestamoE
                        LEFT JOIN Salida_PresE SPE ON SPE.ID_PresE = PE.IdPrestamoE
                        LEFT JOIN Salida_PresD SPD ON SPD.IdSalPresE = SPE.Id_SalPresE AND SPD.IdCProd = PD.IdCProd AND SPD.IdTallas = PD.IdTallas
                        LEFT JOIN DevolucionD DD ON DD.IdDevE = DE.IdDevolucionE AND DD.IdCProd = PD.IdCProd AND DD.IdTalla = PD.IdTallas
                        WHERE DE.IdPrestE = ?
                        GROUP BY DE.IdDevolucionE";
        
    } else {
        $estatus = 'Devolucion'; // Si no es ni Requisicion ni Prestamo, se considera una devolución normal
        goto actualizar; // Si no es ni Requisicion ni Prestamo, se considera una devolución normal
    }

    $ConsultaModificarEstatus = $conexion->prepare($SetenciaModificarEstatus); // Preparar la consulta
    $ConsultaModificarEstatus->bind_param("i", $Identificador); // Vincular el parámetro
    $ConsultaModificarEstatus->execute(); // Ejecutar la consulta
    $resultado = $ConsultaModificarEstatus->get_result(); // Obtener el resultado de la consulta

    if ($resultado->num_rows === 0) { // Si no se encontraron datos, lanzar una excepción
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("No se encontraron datos para actualizar estatus.");
    }

    $DatosModificarEstatus = $resultado->fetch_assoc(); // Obtener los datos de la consulta

    // Convertir a entero y comparar
    $salida = (int)$DatosModificarEstatus['Cantidad_Salida'];
    $devuelta = (int)$DatosModificarEstatus['Cantidad_Devuelta'];

    if ($salida === $devuelta) { // Si la cantidad de salida es igual a la cantidad devuelta
        $estatus = 'Devolucion_Completa';  // Se ha devuelto todo lo solicitado
    } elseif ($devuelta < $salida && $devuelta > 0) { // Si se ha devuelto una parte de lo solicitado
        $estatus = 'Devolucion_Parcial'; // Se ha devuelto una parte de lo solicitado
    } else {
        $estatus = 'Devolucion'; // Solo es una devolucion normal
    }

actualizar:
    // Actualizar el estatus en la tabla DevolucionE
    $SetenciaActualizar = "UPDATE DevolucionE SET Estatus = ? WHERE IdDevolucionE = ?";
    $StmtModificarEstatus = $conexion->prepare($SetenciaActualizar); // Preparar la sentencia SQL para actualizar el estatus
    $StmtModificarEstatus->bind_param("si", $estatus, $id_DevolucionE); // Vincular los parámetros

    if ($StmtModificarEstatus->execute()) { // Ejecutar la consulta
        return true; // Regresar true si la actualización fue exitosa
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al ejecutar actualización de estatus: " . $conexion->error);
    }
}
?>