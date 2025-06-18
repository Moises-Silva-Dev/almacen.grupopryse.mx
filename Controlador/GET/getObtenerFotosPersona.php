<?php
header('Content-Type: application/json'); // Establece el tipo de contenido como JSON

try {
    
    include('../../Modelo/Conexion.php'); // Incluir la conexión a la base de datos
    $conexion = (new Conectar())->conexion(); // Crear un objeto de conexión

    if ($conexion->connect_error) { // Verificar si hay un error de conexión
        // Si hay un error de conexión, lanzar una excepción
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    if (!isset($_GET['id'])) { // Verificar si se proporcionó un ID de persona
        echo json_encode([
            "success" => false, // Indicar que la operación no fue exitosa
            "message" => "No se proporcionó un ID de persona." // Mensaje personalizado
        ]);
        exit; // Salir del script
    }

    $idPersona = $_GET['id']; // Verificar si se proporcionó un ID de persona

    // Consulta SQL para obtener las fotos de la persona
    $sql = "SELECT 
                Imagen_frente, Imagen_izquierda, Imagen_derecha 
            FROM 
                Persona_IMG 
            WHERE 
                ID_Persona = ?";

    $stmt = $conexion->prepare($sql); // Preparar la consulta SQL
    $stmt->bind_param("i", $idPersona); // Ejecutar la consulta SQL
    $stmt->execute(); // Ejecutar la consulta SQL
    $result = $stmt->get_result(); // Obtener los resultados de la consulta SQL

    if ($result->num_rows > 0) { // Verificar si se encontraron resultados
        $row = $result->fetch_assoc(); // Obtener los datos de la fila

        // Crear un arreglo con los datos
        echo json_encode([
            "success" => true, // Indicar que la operación fue exitosa
            "fotos" => [ // Arreglo con las fotos de la persona
                "frente" => $row['Imagen_frente'],
                "izquierda" => $row['Imagen_izquierda'],
                "derecha" => $row['Imagen_derecha'] 
            ]
        ]);
    } else {
        echo json_encode([ 
            "success" => false, // Cambiar a true si se encuentra un registro
            "message" => "No se encontraron fotos para la persona especificada." // Cambiar a un mensaje personalizado
        ]);
    }
} catch (Exception $e) {
    // Manejar cualquier excepción que se produzca durante la ejecución del script
    echo json_encode([
        "success" => false, // Indicar si la operación fue exitosa
        "message" => "Error: " . $e->getMessage() // Mostrar el mensaje de error
    ]);
    exit; // Salir del script
} finally {
    $stmt->close(); // Cerrar la setenncia 
    $conexion->close(); // Cerrar la conexión a la base de datos
}
?>