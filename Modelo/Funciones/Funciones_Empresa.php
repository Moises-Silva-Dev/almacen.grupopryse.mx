<?php
// Función para obtener el ID de la empresa.
function InsertarNuevaEmpresa($conexion, $IdCEmpresa, $Nombre_Empresa, $RazonSocial, $RFC, $RegistroPatronal, $Especif) {
    // Verifica si se seleccionó una nueva empresa.
    if ($IdCEmpresa == 'nuevo_empresa') {
        // Preparar consulta SQL para insertar el registro
        $SetenciaInsertarNuevaEmpresa = "INSERT INTO CEmpresas(Nombre_Empresa, RazonSocial, RFC, RegistroPatronal, Especif) VALUES (?,?,?,?,?)";
    
        // Prepara una consulta para insertar la nueva empresa en la base de datos.
        $StmtInsertarNuevaEmpresa = $conexion->prepare($SetenciaInsertarNuevaEmpresa);
        
        // Vincula los parámetros de la consulta.
        $StmtInsertarNuevaEmpresa->bind_param("sssss", $Nombre_Empresa, $RazonSocial, $RFC, $RegistroPatronal, $Especif);

        // Ejecuta la consulta de inserción de la nueva empresa.
        if ($StmtInsertarNuevaEmpresa->execute()) {
            // Devuelve el ID de la empresa insertada.
            return $conexion->insert_id;
        } else {
            // Lanza una excepción si ocurre un error al insertar la empresa en la base de datos.
            throw new Exception("Error al insertar empresa: " . $StmtInsertarNuevaEmpresa->error);
        }
    } else {
        // Devuelve el ID de la empresa seleccionada.
        return $IdCEmpresa;
    }
}
?>