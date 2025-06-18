<?php
header('Content-Type: application/json'); // Establece el tipo de contenido como JSON

try {
    include('../../Modelo/Conexion.php'); // Incluir el archivo de conexión a la base de datos
    $conexion = (new Conectar())->conexion(); // Crear una instancia de conexión a la base de datos utilizando la clase Conectar

    if ($conexion->connect_error) { // Verificar si hay un error de conexión
        // Si hay un error de conexión, lanzar una excepción
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    // Define una consulta SQL para obtener información de varias tablas relacionadas mediante INNER JOIN.
    $sql = "SELECT 
                P.IdCProducto AS Identificador, 
                CE.Nombre_Empresa AS Nombre_Empresa, 
                CCA.Descrp AS Categoria, 
                CTT.Descrip AS Tipo, 
                P.Descripcion AS Descripcion, 
                P.Especificacion AS Especificacion
            FROM 
                Producto P
            INNER JOIN 
                CEmpresas CE ON P.IdCEmp = CE.IdCEmpresa 
            INNER JOIN 
                CCategorias CCA ON P.IdCCat = CCA.IdCCate 
            INNER JOIN 
                CTipoTallas CTT ON P.IdCTipTal = CTT.IdCTipTall 
            GROUP BY 
                CE.Nombre_Empresa, P.IdCProducto, P.Descripcion"; 

    $stmt = $conexion->prepare($sql); // Preparar la sentencia SQL
    $stmt->execute(); // Ejecuta la consulta
    $resultado = $stmt->get_result(); // Obtiene el resultado de la consulta

    while ($row = $resultado->fetch_assoc()) { // Itera sobre los resultados de la consulta mientras haya filas disponibles.
        echo '<tr class="table-light">'; // Genera una fila HTML para cada registro obtenido en la consulta.
        echo '<td>' . $row['Identificador'] . '</td>'; // Agrega una celda con el ID del producto (de la tabla Producto).
        echo '<td>' . $row['Nombre_Empresa'] . '</td>'; // Agrega una celda con el nombre de la empresa asociada (de la tabla CEmpresas).
        echo '<td>' . $row['Categoria'] . '</td>'; // Agrega una celda con la Categoria del producto (de la tabla CCategorias).
        echo '<td>' . $row['Tipo'] . '</td>'; // Agrega una celda con el tipo de talla del producto (de la tabla CTipoTallas).
        echo '<td>' . $row['Descripcion'] . '</td>'; // Agrega una celda con la descripción general (de la tabla Producto).
        echo '<td>' . $row['Especificacion'] . '</td>'; // Agrega una celda con la especificación del producto (de la tabla Producto).
        echo '</tr>';// Cierra la fila HTML.
    }
} catch (Exception $e) {
    // Manejo de excepciones para errores de conexión o consultas
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
    exit; // Finalizar la ejecución del script en caso de error
} finally {
    $stmt->close(); // Cierra la declaración preparada.
    $conexion->close(); // Cierra la conexión a la base de datos.
}
?>