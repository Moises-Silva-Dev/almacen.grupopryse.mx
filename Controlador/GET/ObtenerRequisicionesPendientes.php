<?php
header('Content-Type: application/json'); // Indicar que se devuelve JSON

try {
    include('../../Modelo/Conexion.php'); // Incluir el archivo de conexión para establecer la conexión con la base de datos
    $conexion = (new Conectar())->conexion(); // Realizar la conexión a la base de datos

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

    $id_empleado = $_GET['id']; // Obtener el ID del empleado desde la solicitud GET

    $setencia = "SELECT 
                    COUNT(REQ.IDRequisicionE) AS TotalRequisiciones
                FROM 
                    RequisicionE REQ
                INNER JOIN 
                    Cuenta C ON REQ.IdCuenta = C.ID
                INNER JOIN 
                    Usuario U ON REQ.IdUsuario = U.ID_Usuario
                WHERE 
                    REQ.Estatus IN ('Pendiente', 'Parcial', 'Autorizado')
                AND 
                    U.ID_Usuario = ?";

    $consulta = $conexion->prepare($setencia); // Preparar la consulta SQL para evitar inyecciones SQL
    $consulta->bind_param("i", $id_empleado); // Enlazar el parámetro ID del empleado con el valor real
    $consulta->execute(); // Ejecutar la consulta preparada
    $resultado = $consulta->get_result(); // Obtener el resultado de la consulta

    // Verificar si se obtuvo un resultado de la consulta
    if ($row = $resultado->fetch_assoc()) {
        // Devolver el resultado como un JSON con el n��mero total de requisiciones
        echo json_encode(['totalRequisiciones' => $row['TotalRequisiciones']]);
    } else {
        // Si no se encuentra ning��n resultado, devolver un JSON con valor 0
        echo json_encode(['totalRequisiciones' => 0]);
    }
} catch (Exception $e) {
    http_response_code(400); // Código de error personalizado (puedes usar 500 si es del servidor)
    echo json_encode([
        "success" => false, // Indicar si la operación fue exitosa
        "message" => "Error: " . $e->getMessage() // Mostrar el mensaje de error
    ]);
    exit; // Salir del script
} finally {
    $consulta->close(); // Cerrar la consulta preparada
    $conexion->close(); // Cerrar la conexión a la base de datos
} 
?>