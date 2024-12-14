<?php
// Incluir el archivo de conexión para establecer la conexión con la base de datos
include('../../Modelo/Conexion.php');

// Verificar si se ha enviado el ID del producto a través de una solicitud POST
if(isset($_POST['ID_Producto'])) {
    // Obtener el ID del producto desde la solicitud POST
    $producto_id = $_POST['ID_Producto'];

    // Realizar la conexión a la base de datos
    $conexion = (new Conectar())->conexion();

    // Consultar la base de datos para obtener la URL de la imagen del producto
    $sql = $conexion->prepare("SELECT IMG FROM Producto WHERE IdCProducto = ?");
    $sql->bind_param("i", $producto_id); // Enlazar el parámetro ID del producto con el valor real
    $sql->execute(); // Ejecutar la consulta preparada
    $result = $sql->get_result(); // Obtener el resultado de la consulta

    // Verificar si se encontró la URL de la imagen
    if($result->num_rows > 0) {
        // Obtener la fila de resultados como un array asociativo
        $row = $result->fetch_assoc();
        $url_imagen = $row['IMG']; // Obtener la URL de la imagen del producto

        // Construir el array de respuesta que contiene la URL de la imagen
        $response = array(
            'url' => $url_imagen
        );

        // Devolver la respuesta como JSON
        echo json_encode($response);
    } else {
        // Si no se encuentra la imagen, devolver una respuesta vacía
        echo json_encode(array('url' => ''));
    }
}
?>