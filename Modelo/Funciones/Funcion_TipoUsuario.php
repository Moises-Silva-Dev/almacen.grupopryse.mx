<?php
// Función para buscar y retornar el tipo de usuario
function buscarYRetornarTipoUsuario($usuario, $conexion) {
    try {
        // Preparar la consulta SQL
        $stmt = $conexion->prepare("SELECT ID_Tipo_Usuario FROM Usuario WHERE Correo_Electronico = ?");
        
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $conexion->error);
        }

        // Vincular los parámetros
        $stmt->bind_param("s", $usuario);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $resultado = $stmt->get_result();

        // Validar si hay resultados
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $stmt->close(); // Cerrar el statement
            return $fila['ID_Tipo_Usuario']; // Retornar el valor específico
        } else {
            $stmt->close();
            return null; // No se encontró ningún registro
        }
    } catch (Exception $e) {
        // Manejo de errores
        error_log("Error en buscarYRetornarTipoUsuario: " . $e->getMessage());
        return null; // Retornar null en caso de error
    }
}
?>