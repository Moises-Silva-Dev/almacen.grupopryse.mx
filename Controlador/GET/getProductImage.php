<?php
header('Content-Type: application/json'); // Indicar que se devuelve JSON

try {
    include('../../Modelo/Conexion.php'); // Incluir el archivo de conexión para establecer la conexión con la base de datos
    $conexion = (new Conectar())->conexion(); // Realizar la conexión a la base de datos

    if ($conexion->connect_error) { // Verificar si hay un error de conexión
        // Si hay un error de conexión, lanzar una excepción
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    if (!isset($_POST['ID_Producto']) || !is_numeric($_POST['ID_Producto'])) { // Verificar si se ha enviado el ID del producto y si es un número válido
        throw new Exception("ID de producto no proporcionado o no válido."); // Mostrar un mensaje de error
    }

    $producto_id = $_POST['ID_Producto']; // Obtener el ID del producto desde la solicitud POST

    $sentencia = "SELECT IMG FROM Producto WHERE IdCProducto = ?"; // Consulta SQL para obtener la URL de la imagen del producto
    $sql = $conexion->prepare($sentencia); // Preparar la consulta SQL para evitar inyecciones SQL
    $sql->bind_param("i", $producto_id); // Enlazar el parámetro ID del producto con el valor real
    $sql->execute(); // Ejecutar la consulta preparada
    $result = $sql->get_result(); // Obtener el resultado de la consulta

    if($result->num_rows > 0) { // Verificar si se encontró la URL de la imagen
        $row = $result->fetch_assoc(); // Obtener la fila de resultados como un array asociativo
        $url_imagen = $row['IMG']; // Obtener la URL de la imagen del producto

        echo json_encode([ // Devolver la respuesta en formato JSON
            'success' => true, // Indicar que la operación fue exitosa
            'url' => $url_imagen // Incluir la URL de la imagen en la respuesta
        ]);
    } else {
        echo json_encode([ // No se encontró el producto
            'success' => false, // Indicar que la operación no fue exitosa
            'url' => '', // No se encontró la URL de la imagen, se devuelve una cadena vacía
            'message' => "No se encontró el producto con ID: $producto_id." // Mensaje de error personalizado
        ]);
    }
} catch (Exception $e) {
    http_response_code(400); // Código de error de cliente o 500 si es del servidor
    echo json_encode([
        'success' => false, // Indicar que la operación no fue exitosa
        'message' => $e->getMessage() // Mostrar el mensaje de error
    ]);
    exit; // Finalizar la ejecución del script
} finally {
    $sql->close(); // Cerrar la sentencia preparada
    $conexion->close(); // Cerrar la conexión con la base de datos
}
?>