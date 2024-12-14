<?php
// Incluye el archivo de conexión a la base de datos.
include('../../Modelo/Conexion.php'); 

// Crea una instancia de la clase de conexión y establece la conexión a la base de datos.
$conexion = (new Conectar())->conexion();

// Define una consulta SQL para obtener información de varias tablas relacionadas mediante INNER JOIN.
$sql = "SELECT 
            P.IdCProducto AS Identificador, 
            CE.Nombre_Empresa AS Nombre_Empresa, 
            CCA.Descrp AS Categoria, 
            CTT.Descrip AS Tipo, 
            P.Descripcion AS Descripcion, 
            P.Especificacion AS Especificacion, 
            T.Talla AS Talla, 
            I.Cantidad AS Existencias
        FROM 
            Inventario I 
        INNER JOIN 
            Producto P ON I.IdCPro = P.IdCProducto 
        INNER JOIN 
            CTallas T ON I.IdCTal = T.IdCTallas 
        INNER JOIN 
            CEmpresas CE ON P.IdCEmp = CE.IdCEmpresa 
        INNER JOIN 
            CCategorias CCA ON P.IdCCat = CCA.IdCCate 
        INNER JOIN 
            CTipoTallas CTT ON P.IdCTipTal = CTT.IdCTipTall 
        GROUP BY 
            CE.Nombre_Empresa, P.IdCProducto, P.Descripcion, T.Talla;"; 
        // Ordena los resultados por el campo 'IdCProducto'.

// Ejecuta la consulta SQL en la conexión establecida.
$query = mysqli_query($conexion, $sql);

// Itera sobre los resultados de la consulta mientras haya filas disponibles.
while ($row = mysqli_fetch_array($query)) {
    // Genera una fila HTML para cada registro obtenido en la consulta.
    echo '<tr class="table-light">';
    
    // Agrega una celda con el ID del producto (de la tabla Producto).
    echo '<td>' . $row['Identificador'] . '</td>';
    
    // Agrega una celda con el nombre de la empresa asociada (de la tabla CEmpresas).
    echo '<td>' . $row['Nombre_Empresa'] . '</td>';
    
    // Agrega una celda con la Categoria del producto (de la tabla CCategorias).
    echo '<td>' . $row['Categoria'] . '</td>';
    
    // Agrega una celda con el tipo de talla del producto (de la tabla CTipoTallas).
    echo '<td>' . $row['Tipo'] . '</td>';
    
    // Agrega una celda con la descripción general (de la tabla Producto).
    echo '<td>' . $row['Descripcion'] . '</td>';
    
    // Agrega una celda con la especificación del producto (de la tabla Producto).
    echo '<td>' . $row['Especificacion'] . '</td>';

    // Agrega una celda con la talla producto (de la tabla CTallas).
    echo '<td>' . $row['Talla'] . '</td>';

    // Agrega una celda con las existencias del producto en el inventario (de la tabla Inventario).
    echo '<td>' . $row['Existencias'] . '</td>';
    
    // Cierra la fila HTML.
    echo '</tr>';
}

// Cierra la conexión a la base de datos para liberar recursos.
mysqli_close($conexion);
?>