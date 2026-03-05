<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

try {
  include('../../Modelo/Conexion.php'); // Incluir el archivo de conexión para establecer la conexión con la base de datos
  $conexion = (new Conectar())->conexion(); // Establecer la conexión a la base de datos

  if ($conexion->connect_error) { // Verificar si hay un error de conexión
    // Si hay un error de conexión, lanzar una excepción
    throw new Exception("Error de conexión: " . $conexion->connect_error);
  }

  // Consulta para obtener el producto con cantidad menor o igual a 5 en inventario
  $sql = "SELECT P.IdCProducto AS Identificador, 
                P.Descripcion AS Descripcion, 
                ANY_VALUE(P.Especificacion) AS Especificacion, 
                T.Talla AS Talla,
                ANY_VALUE(CCA.Descrp) AS Categoria,  
                SUM(I.Cantidad) AS Cantidad 
          FROM Inventario I 
            INNER JOIN Producto P ON I.IdCPro = P.IdCProducto 
            INNER JOIN CTallas T ON I.IdCTal = T.IdCTallas 
            INNER JOIN CCategorias CCA ON P.IdCCat = CCA.IdCCate 
            INNER JOIN CTipoTallas ON P.IdCTipTal = CTipoTallas.IdCTipTall 
          WHERE I.Cantidad <= 20 
          GROUP BY P.IdCProducto, P.Descripcion, T.Talla
          ORDER BY 
              -- Orden personalizado por Categoría
              FIELD(ANY_VALUE(CCA.Descrp), 'Uniformes', 'Equipamiento', 'Accesorios') ASC,
              -- Orden secundario por descripción y talla
              P.Descripcion ASC,
              T.Talla ASC";
  
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

} catch (Exception $e) {
  // Manejar cualquier excepción que se produzca durante la ejecución del script
  echo json_encode([
    "success" => false, // Indicar si la operación fue exitosa
    "message" => "Error: " . $e->getMessage() // Mostrar el mensaje de error
  ]);
  exit; // Salir del script
} finally {
  $conexion->close(); // Cerrar la conexión a la base de datos
  $stmt->close(); // Cerrar la declaración preparada
}
?>