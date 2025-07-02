<?php
function registroAcceso($conexion, $IdentificadorUsuario, $fecha, $hora, $ip, $id_mac, $ciudad, $pais) {
    // Preparar la consulta SQL para insertar el registro de acceso
    $sqlRegistroAcceso = "INSERT INTO Registro_Acceso (IdUsuario, FchAcceso, HorAcceso, IP, ID_Mac, Ciudad, Pais) VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    // Preparar la sentencia
    $stmtregistroAcceso = $conexion->prepare($sqlRegistroAcceso);
    
    // Enlazar los parámetros
    $stmtregistroAcceso->bind_param("issssss", $IdentificadorUsuario, $fecha, $hora, $ip, $id_mac, $ciudad, $pais);
        
    // Ejecutar la sentencia
    $stmtregistroAcceso->execute();
}
?>