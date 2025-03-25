<?php
header('Content-Type: application/json'); // Establece el tipo de contenido como JSON

// Incluir la conexión a la base de datos
include('../../Modelo/Conexion.php');

// Crear un objeto de conexión
$conexion = (new Conectar())->conexion();

// Verificar si se proporcionó un ID de persona
if (!isset($_GET['id'])) {
    echo json_encode([
        "success" => false, // Indicar que la operación no fue exitosa
        "message" => "No se proporcionó un ID de persona." // Mensaje personalizado
    ]);
    exit; // Salir del script
}

// Verificar si se proporcionó un ID de persona
$idPersona = $_GET['id'];

// Consulta SQL para obtener las fotos de la persona
$sql = "SELECT 
            Imagen_frente, Imagen_izquierda, Imagen_derecha 
        FROM 
            Persona_IMG 
        WHERE 
            ID_Persona = ?";

// Preparar la consulta SQL
$stmt = $conexion->prepare($sql);

// Ejecutar la consulta SQL
$stmt->bind_param("i", $idPersona);

// Ejecutar la consulta SQL
$stmt->execute();

// Obtener los resultados de la consulta SQL
$result = $stmt->get_result();

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Obtener los datos de la fila
    $row = $result->fetch_assoc();

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

// Cerrar la setenncia 
$stmt->close();

// Cerrar la conexión a la base de datos
$conexion->close();
?>