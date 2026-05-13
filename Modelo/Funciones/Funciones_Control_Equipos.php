<?php
// Inserta un nuevo equipo en la base de datos
function InsertarNuevoEquipo(
    $conexion, 
    $Fecha_Registro, 
    $Nombre_Persona, 
    $ID_Departamento, 
    $ID_Usuarios, 
    $Tipo_PC, 
    $Marca_Equipo, 
    $Modelo_Equipo, 
    $Numero_Serie, 
    $Sistema_Operativo, 
    $Procesador, 
    $Tarjeta_Madre, 
    $Tiene_Grafica_Dedicada, 
    $Datos_Tarjeta_Grafica, 
    $Tipo_RAM, 
    $Capacidad_RAM, 
    $Marca_RAM, 
    $Tipo_Disco, 
    $Capacidad_Disco, 
    $Teclado_Mouse, 
    $Camara_Web, 
    $Otro_Periferico, 
    $Observaciones, 
    $Estatus
) {
    $sql = "INSERT INTO Control_Equipos (
                Fecha_Registro, 
                Nombre_Persona, 
                ID_Departamento, 
                ID_Usuarios, 
                Tipo_PC, 
                Marca_Equipo, 
                Modelo_Equipo, 
                Numero_Serie, 
                Sistema_Operativo, 
                Procesador, 
                Tarjeta_Madre, 
                Tiene_Grafica_Dedicada, 
                Datos_Tarjeta_Grafica, 
                Tipo_RAM, 
                Capacidad_RAM, 
                Marca_RAM, 
                Tipo_Disco, 
                Capacidad_Disco, 
                Teclado_Mouse, 
                Camara_Web, 
                Otro_Periferico, 
                Observaciones, 
                Estatus
            ) VALUES (?, ?, ?, ?, ?, 
                        ?, ?, ?, ?, ?, 
                        ?, ?, ?, ?, ?, 
                        ?, ?, ?, ?, ?, 
                        ?, ?, ?)";
    
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        error_log("Error en prepare: " . $conexion->error);
        return false;
    }
    
    $stmt->bind_param(
        "ssiisssssssssssssssssss",
        $Fecha_Registro, $Nombre_Persona, $ID_Departamento, $ID_Usuarios, $Tipo_PC, $Marca_Equipo, 
        $Modelo_Equipo, $Numero_Serie, $Sistema_Operativo, $Procesador, $Tarjeta_Madre, $Tiene_Grafica_Dedicada,
        $Datos_Tarjeta_Grafica, $Tipo_RAM, $Capacidad_RAM, $Marca_RAM, $Tipo_Disco,
        $Capacidad_Disco, $Teclado_Mouse, $Camara_Web, $Otro_Periferico, $Observaciones, $Estatus
    );
    
    $result = $stmt->execute();
    $insertId = $result ? $conexion->insert_id : false;
    
    $stmt->close();
    
    return $insertId;
}

// Actualiza un equipo existente en la base de datos
function ActualizarEquipo(
            $conexion,
            $Nombre_Persona,
            $ID_Departamento,
            $Tipo_PC,
            $Marca_Equipo,
            $Modelo_Equipo,
            $Numero_Serie,
            $Sistema_Operativo,
            $Procesador,
            $Tarjeta_Madre,
            $Tiene_Grafica_Dedicada,
            $Datos_Tarjeta_Grafica,
            $Tipo_RAM,
            $Capacidad_RAM,
            $Marca_RAM,
            $Tipo_Disco,
            $Capacidad_Disco,
            $Teclado_Mouse,
            $Camara_Web,
            $Otro_Periferico,
            $Observaciones,
            $Estatus,
            $Fecha_Modificacion,
            $Id,
){
    $sql = "UPDATE Control_Equipos SET 
                Nombre_Persona = ?,
                ID_Departamento = ?,
                Tipo_PC = ?,
                Marca_Equipo = ?,
                Modelo_Equipo = ?,
                Numero_Serie = ?,
                Sistema_Operativo = ?,
                Procesador = ?,
                Tarjeta_Madre = ?,
                Tiene_Grafica_Dedicada = ?,
                Datos_Tarjeta_Grafica = ?,
                Tipo_RAM = ?,
                Capacidad_RAM = ?,
                Marca_RAM = ?,
                Tipo_Disco = ?,
                Capacidad_Disco = ?,
                Teclado_Mouse = ?,
                Camara_Web = ?,
                Otro_Periferico = ?,
                Observaciones = ?,
                Estatus = ?,
                Fecha_Modificacion = ?
            WHERE Id = ?";
    
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        error_log("Error en prepare: " . $conexion->error);
        return false;
    }
    
    $stmt->bind_param(
        "sissssssssssssssssssssi",
        $Nombre_Persona, $ID_Departamento, $Tipo_PC, $Marca_Equipo, $Modelo_Equipo, $Numero_Serie, 
        $Sistema_Operativo, $Procesador, $Tarjeta_Madre, $Tiene_Grafica_Dedicada, $Datos_Tarjeta_Grafica, $Tipo_RAM, 
        $Capacidad_RAM, $Marca_RAM, $Tipo_Disco, $Capacidad_Disco, $Teclado_Mouse, $Camara_Web, 
        $Otro_Periferico, $Observaciones, $Estatus, $Fecha_Modificacion, $Id
    );
    
    $result = $stmt->execute();
    
    $stmt->close();
    
    return $result;
}
?>