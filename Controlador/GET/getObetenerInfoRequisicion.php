<?php
header('Content-Type: application/json'); // Establece el tipo de contenido como JSON

try {
    include('../../Modelo/Conexion.php'); // Incluir la conexión a la base de datos
    $conexion = (new Conectar())->conexion(); // Crear un objeto de conexión

    if ($conexion->connect_error) { // Verificar si hay un error de conexión
        // Si hay un error de conexión, lanzar una excepción
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    if (!isset($_GET['id'])) { // Verificar si se proporcionó un ID de requisición
        echo json_encode([ 
            "success" => false, // Indicar que la operación no fue exitosa
            "message" => "No se proporcionó un ID de la requisición." // Mensaje de error
        ]);
        exit; // Salir del script si no se proporciona un ID
    }

    $Id = $_GET['id']; // Obtener el ID de la requisición desde la solicitud GET

    // ======================== //
    //    CONSULTA PRINCIPAL    //
    // ======================== //

    // Consulta para obtener la información de la requisición
    $sqlE = "SELECT 
                RE.Supervisor, C.NombreCuenta, R.Nombre_Region, 
                RE.CentroTrabajo, RE.NroElementos, RE.Receptor, 
                RE.TelReceptor, RE.RfcReceptor, RE.Justificacion, 
                RE.Mpio, RE.Colonia, RE.Calle, RE.Nro, 
                RE.CP, E.Nombre_estado 
            FROM 
                RequisicionE RE 
            INNER JOIN 
                Usuario U on RE.IdUsuario = U.ID_Usuario
            INNER JOIN 
                Cuenta C on RE.IdCuenta = C.ID
            INNER JOIN 
                Regiones R on RE.IdRegion = R.ID_Region
            INNER JOIN 
                Estados E on RE.IdEstado = E.Id_Estado
            WHERE 
                RE.IDRequisicionE = ?";
    
    $consultaE = $conexion->prepare($sqlE); // Preparar la consulta
    $consultaE->bind_param("i", $Id); // Asignar el valor del parámetro
    $consultaE->execute(); // Ejecutar la consulta
    $resultadoE = $consultaE->get_result(); // Obtener los resultados
    $infoRequisicion = $resultadoE->fetch_assoc(); // Verificar si se encontró una requisición con el ID proporcionado

    
    if (!$infoRequisicion) { // Verificar si se obtuvo información de la requisición
        // Si no se encontró información de la requisición, lanzar una excepción
        throw new Exception("No se encontró información para la requisición con ID: $Id.");
    }

    // ======================== //
    //     CONSULTA SEGUNDA     //
    // ======================== //

    // Consulta para obtener la información de los productos
    $sqlD = "SELECT 
                P.IdCProducto AS Producto_ID,
                P.IMG AS Imagen_Producto,
                P.Descripcion AS Descripcion_Producto,
                P.Especificacion AS Especificacion_Producto,
                CT.Talla AS Talla,
                RD.Cantidad AS Cantidad_Solicitada,
                IFNULL(SUM(SD.Cantidad), 0) AS Cantidad_Salida
            FROM 
                RequisicionE RE
            INNER JOIN 
                RequisicionD RD ON RD.IdReqE = RE.IDRequisicionE
            LEFT JOIN 
                Salida_E SE ON RE.IDRequisicionE = SE.ID_ReqE
            LEFT JOIN 
                Salida_D SD ON SE.Id_SalE = SD.Id AND SD.IdCProd = RD.IdCProd AND SD.IdTallas = RD.IdTalla
            INNER JOIN 
                Producto P ON RD.IdCProd = P.IdCProducto
            INNER JOIN 
                CTallas CT ON RD.IdTalla = CT.IdCTallas
            INNER JOIN 
                CCategorias CC ON P.IdCCat = CC.IdCCate
            INNER JOIN 
                CTipoTallas CTT ON CT.IdCTipTal = CTT.IdCTipTall
            INNER JOIN 
                CEmpresas CE ON P.IdCEmp = CE.IdCEmpresa
            WHERE 
                RE.IDRequisicionE = ?
            GROUP BY 
                P.IdCProducto, P.IMG, CE.Nombre_Empresa, 
                P.Descripcion, P.Especificacion, CC.Descrp, CT.Talla, RD.Cantidad";

    $consultaD = $conexion->prepare($sqlD); // Preparar la consulta
    $consultaD->bind_param("i", $Id); // Asignar el valor del parámetro
    $consultaD->execute(); // Ejecutar la consulta
    $resultadoD = $consultaD->get_result(); // Obtener los resultados    
    $productos = []; // Array para almacenar los productos

    // Verificar si se encontraron productos
    while ($row = $resultadoD->fetch_assoc()) {
        // Crear un arreglo con los datos del producto
        $productos[] = [
            "IMG" => str_replace("../../../", "../../", $row['Imagen_Producto']),
            "Descripcion" => $row['Descripcion_Producto'],
            "Especificacion" => $row['Especificacion_Producto'],
            "Talla" => $row['Talla'],
            "Cantidad_Solicitada" => $row['Cantidad_Solicitada'],
            "Cantidad_Salida" => $row['Cantidad_Salida']
        ];
    }
    
    if (empty($productos)) { // Verificar si el arreglo de productos está vacío
        // Si no se encontraron productos, lanzar una excepción
        throw new Exception("No se encontraron productos para la requisición con ID: $Id.");
    }

    echo json_encode([
        "success" => true, // Indicar que la operación fue exitosa
        "requisicion" => $infoRequisicion, // Información de la requisición
        "productos" => $productos // Arreglo con los productos
    ]);

} catch (Exception $e) {
    http_response_code(400); // Código de error personalizado (puedes usar 500 si es del servidor)
    echo json_encode([
        "success" => false, // Indicar si la operación fue exitosa
        "message" => "Error: " . $e->getMessage() // Mostrar el mensaje de error
    ]);
    exit; // Salir del script
} finally {
    $consultaE->close(); // Cerrar la consulta de requisición
    $consultaD->close(); // Cerrar la consulta de productos
    $conexion->close(); // Cerrar la conexión a la base de datos
}
?>