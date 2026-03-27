<?php
header('Content-Type: application/json'); // Establece el tipo de contenido como JSON

try {
    include('../../Modelo/Conexion.php'); // Incluir la conexión a la base de datos
    $conexion = (new Conectar())->conexion(); // Crear un objeto de conexión

    if ($conexion->connect_error) { // Verificar si hay un error de conexión
        // Si hay un error de conexión, lanzar una excepción
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    if (!isset($_GET['id'])) { // Verificar si se proporcionó un ID de producto
        echo json_encode([
            "success" => false, // Indicar que la operación no fue exitosa
            "message" => "No se proporcionó un ID de persona." // Mensaje personalizado
        ]);
        exit; // Salir del script si no se proporciona un ID
    }
    
    $Id_producto = $_GET['id']; // Verificar si se proporcionó un ID

    // Consulta para obtener la información de la persona
    $sql = "SELECT * FROM 
                Producto P
            INNER JOIN 
                CEmpresas CE on P.IdCEmp = CE.IdCEmpresa
            INNER JOIN 
                CCategorias CC on P.IdCCat = CC.IdCCate
            INNER JOIN 
                CTipoTallas CTT on P.IdCTipTal = CTT.IdCTipTall 
            WHERE 
                IdCProducto = ?";

    $consulta = $conexion->prepare($sql); // Preparar la consulta
    $consulta->bind_param("i", $Id_producto); // Asignar el valor del parámetro
    $consulta->execute(); // Ejecutar la consulta
    $resultado = $consulta->get_result(); // Obtener los resultados

    if ($resultado->num_rows > 0) { // Verificar si se encontraron registros
        $row = $resultado->fetch_assoc(); // Obtener los datos de la fila

        // Crear un arreglo con los datos
        echo json_encode([
            "success" => true, // Indicar que la operación fue exitosa
            "producto" => [ // Arreglo con las fotos de la persona
                "IMG" => $row['IMG'] = str_replace("../../../", "../../", $row['IMG']),
                "Descripcion" => $row['Descripcion'],
                "Especificacion" => $row['Especificacion'],
                "Nombre_Empresa" => $row['Nombre_Empresa'],
                "Descrp" => $row['Descrp'],
                "Descrip" => $row['Descrip']
            ]
        ]);
    } else {
        echo json_encode([ 
            "success" => false, // Cambiar a true si se encuentra un registro
            "message" => "No se encontraron foto del producto especificado." // Cambiar a un mensaje personalizado
        ]);
    }
} catch (Exception $e) {
    // Manejo de excepciones
    echo json_encode([
        "success" => false, // Indicar que la operación no fue exitosa
        "message" => "Error al procesar la solicitud: " . $e->getMessage() // Mensaje de error
    ]);
    exit; // Salir del script
} finally {
    $consulta->close(); // Cerrar la consulta
    $conexion->close(); // Cerrar la conexión a la base de datos
}
?>