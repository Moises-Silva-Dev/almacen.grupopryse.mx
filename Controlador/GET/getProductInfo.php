<?php
// Incluir el archivo de conexión para establecer la conexión con la base de datos
include('../../Modelo/Conexion.php');

// Establecer la conexión a la base de datos
$conexion = (new Conectar())->conexion();

// Verificar si se ha enviado el ID del producto a través de una solicitud POST
if(isset($_POST['ID_Producto'])) {
    // Obtener el ID del producto desde la solicitud POST
    $producto_id = $_POST['ID_Producto'];

    // Obtener información del producto utilizando una consulta preparada para evitar inyección de SQL
    $sql_producto = $conexion->prepare("SELECT Producto.IdCTipTal, CEmpresas.Nombre_Empresa, CCategorias.Descrp AS Categoria, Producto.Descripcion, Producto.Especificacion, CTipoTallas.Descrip AS TipoTalla
                                        FROM Producto
                                        INNER JOIN CEmpresas ON Producto.IdCEmp = CEmpresas.IdCEmpresa
                                        INNER JOIN CCategorias ON Producto.IdCCat = CCategorias.IdCCate
                                        INNER JOIN CTipoTallas ON Producto.IdCTipTal = CTipoTallas.IdCTipTall
                                        WHERE Producto.IdCProducto = ?");
    $sql_producto->bind_param("i", $producto_id); // Enlazar el parámetro ID del producto con el valor real
    $sql_producto->execute(); // Ejecutar la consulta preparada
    $result_producto = $sql_producto->get_result(); // Obtener el resultado de la consulta
    $row_producto = $result_producto->fetch_assoc(); // Obtener la fila de resultados como un array asociativo

    // Obtener las tallas del producto utilizando una consulta preparada
    $sql_tallas = $conexion->prepare("SELECT * FROM CTallas WHERE IdCTipTal = ?");
    $sql_tallas->bind_param("i", $row_producto['IdCTipTal']); // Enlazar el parámetro IdCTipTal con el valor real
    $sql_tallas->execute(); // Ejecutar la consulta preparada
    $result_tallas = $sql_tallas->get_result(); // Obtener el resultado de la consulta
    $tallas = array(); // Inicializar un array para almacenar las tallas
    while ($row_talla = $result_tallas->fetch_assoc()) {
        // Iterar sobre cada fila de resultados y agregar las tallas al array de tallas
        $tallas[] = array(
            'id' => $row_talla['IdCTallas'],
            'nombre' => $row_talla['Talla']
        );
    }

    // Construir el array de respuesta que incluye la información del producto y sus tallas
    $response = array(
        'empresa' => $row_producto['Nombre_Empresa'],
        'categoria' => $row_producto['Categoria'],
        'descripcion' => $row_producto['Descripcion'],
        'especificacion' => $row_producto['Especificacion'],
        'tallas' => $tallas  // Agregar las tallas al array de respuesta
    );

    // Devolver la respuesta como JSON para que pueda ser consumida por JavaScript u otra aplicación
    echo json_encode($response);
}
?>