<?php
header('Content-Type: application/json'); // Establece el tipo de contenido como JSON

try {
    include('../../Modelo/Conexion.php'); // Incluir el archivo de conexión para establecer la conexión con la base de datos
    $conexion = (new Conectar())->conexion(); // Establecer la conexión a la base de datos

    if ($conexion->connect_error) { // Verificar si hay un error de conexión
        // Si hay un error de conexión, lanzar una excepción
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

        // Verificar si se ha enviado el ID del producto a través de una solicitud POST
    if (!isset($_POST['ID_Producto']) || !is_numeric($_POST['ID_Producto'])) {
        throw new Exception("ID de producto no proporcionado o no válido.");
    }

    // Obtener el ID del producto desde la solicitud POST
    $producto_id = $_POST['ID_Producto'];

    // Consulta SQL para obtener la información del producto
    $setencia_producto = "SELECT 
                                P.IdCTipTal, CE.Nombre_Empresa, 
                                CC.Descrp AS Categoria, P.Descripcion, 
                                P.Especificacion, CT.Descrip AS TipoTalla,
                                P.IMG
                            FROM 
                                Producto P
                            INNER JOIN 
                                CEmpresas CE ON P.IdCEmp = CE.IdCEmpresa
                            INNER JOIN 
                                CCategorias CC ON P.IdCCat = CC.IdCCate
                            INNER JOIN 
                                CTipoTallas CT ON P.IdCTipTal = CT.IdCTipTall
                            WHERE 
                                P.IdCProducto = ?";

    $sql_producto = $conexion->prepare($setencia_producto); // Preparar la consulta SQL
    $sql_producto->bind_param("i", $producto_id); // Enlazar el parámetro ID del producto con el valor real
    $sql_producto->execute(); // Ejecutar la consulta preparada
    $result_producto = $sql_producto->get_result(); // Obtener el resultado de la consulta
    $row_producto = $result_producto->fetch_assoc(); // Obtener la fila de resultados como un array asociativo

    $setencia_tallas = "SELECT * FROM CTallas WHERE IdCTipTal = ?"; // Consulta SQL para obtener las tallas del producto
    $sql_tallas = $conexion->prepare($setencia_tallas); // Preparar la consulta SQL para obtener las tallas
    $sql_tallas->bind_param("i", $row_producto['IdCTipTal']); // Enlazar el parámetro IdCTipTal con el valor real
    $sql_tallas->execute(); // Ejecutar la consulta preparada
    $result_tallas = $sql_tallas->get_result(); // Obtener el resultado de la consulta

    $tallas = array(); // Inicializar un array para almacenar las tallas

    while ($row_talla = $result_tallas->fetch_assoc()) { // Iterar sobre los resultados de las tallas
        $tallas[] = array( // Crear un objeto para cada talla
            'id' => $row_talla['IdCTallas'], // ID de la talla
            'nombre' => $row_talla['Talla'] // Nombre de la talla
        );
    }

    $response = array( // Crear un array de respuesta con la información del producto
        'empresa' => $row_producto['Nombre_Empresa'], // Nombre de la empresa
        'categoria' => $row_producto['Categoria'], // Categoría del producto
        'descripcion' => $row_producto['Descripcion'], // Descripción del producto
        'especificacion' => $row_producto['Especificacion'], // Especificación del producto
        'IMG' => $row_producto['IMG'], // URL de la imagen del producto
        'tallas' => $tallas  // Agregar las tallas al array de respuesta
    );

    echo json_encode($response); // Devolver la respuesta en formato JSON
} catch (Exception $e) {
    // Manejar cualquier excepción que se produzca durante la ejecución del script
    echo json_encode([
        "success" => false, // Indicar si la operación fue exitosa
        "message" => "Error: " . $e->getMessage() // Mostrar el mensaje de error
    ]);
    exit; // Salir del script
} finally {
    $sql_producto->close(); // Cerrar la consulta del producto
    $sql_tallas->close(); // Cerrar la consulta de tallas
    $conexion->close(); // Cerrar la conexión a la base de datos
}
?>