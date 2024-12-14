<?php
// Incluir el archivo de conexión para establecer la conexión con la base de datos
include('../../Modelo/Conexion.php');

// Establecer la conexión a la base de datos
$conexion = (new Conectar())->conexion();

// Consulta para obtener el producto con cantidad menor o igual a 5 en inventario
$sql = "SELECT P.IdCProducto AS Identificador, P.Descripcion AS NombreProducto, T.Talla AS Talla
        FROM Inventario I
        INNER JOIN Producto P ON I.IdCPro = P.IdCProducto
        INNER JOIN CTallas T ON I.IdCTal = T.IdCTallas
        WHERE I.Cantidad <= 5;";

// Preparar la consulta SQL
$stmt = $conexion->prepare($sql);

// Ejecutar la consulta SQL
$stmt->execute();

// Obtener el resultado de la consulta
$resultado = $stmt->get_result();

// Crear un array para almacenar la información del producto
$respuesta = array();

// Verificar si hay resultados en la consulta
if ($resultado->num_rows > 0) {
  // Recorrer todos los resultados
  while ($fila = $resultado->fetch_assoc()) {
    // Agregar cada fila al array de respuesta
    $respuesta[] = $fila;
  }
}

// Convertir el array de respuesta a formato JSON y devolverlo
echo json_encode($respuesta);

// Cerrar la conexión a la base de datos
$conexion->close();
?>