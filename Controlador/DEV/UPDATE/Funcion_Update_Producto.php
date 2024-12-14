<?php
// Iniciamos sesión
session_start();
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/Mexico_City');

// Función para actualizar el producto
function actualizarProducto($conexion, $id_producto, $id_empresa, $id_categoria, $id_TipTalla, $descripcion, $especificacionProducto, $registro, $targetFile = null) {
    if ($targetFile !== null) {
        // Preparar la consulta SQL para actualizar el producto con la nueva imagen
        $stmtProducto = $conexion->prepare("UPDATE Producto SET IdCEmp = ?, IdCCat = ?, IdCTipTal = ?, Descripcion = ?, Especificacion = ?, IMG = ?, Fecha_Registro = ? WHERE IdCProducto = ?;");
        // Asociamos los parámetros a la consulta preparada
        $stmtProducto->bind_param("sssssssi", $id_empresa, $id_categoria, $id_TipTalla,  $descripcion, $especificacionProducto, $targetFile, $registro, $id_producto);
    } else {
        // Si no se está enviando un archivo de imagen, actualizamos el producto sin cambiar la imagen
        $stmtProducto = $conexion->prepare("UPDATE Producto SET IdCEmp = ?, IdCCat = ?, IdCTipTal = ?, Descripcion = ?, Especificacion = ?, Fecha_Registro = ? WHERE IdCProducto = ?;");
        // Asociamos los parámetros a la consulta preparada
        $stmtProducto->bind_param("iiisssi", $id_empresa, $id_categoria, $id_TipTalla,  $descripcion, $especificacionProducto, $registro, $id_producto);
    }

    // Ejecutar la consulta
    if ($stmtProducto->execute()) {
        return true;
    } else {
        return false;
    }
}

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conectar a la base de datos
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();

    // Obtener datos del formulario
    $id_producto = $_POST['id'];
    $id_empresa = $_POST['ID_Empresas'];
    $id_categoria = $_POST['Id_cate']; // Ajusta según el nombre real del campo en el formulario
    $id_TipTalla = $_POST['Id_TipTall'];
    $descripcion = $_POST['Descripción'];
    $opcion = $_POST['opcion'];
    $especificacionProducto = $_POST['Especificacion'];
    $registro = date('Y-m-d H:i:s', time());

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        if ($opcion === 'SI') {
            // Definimos la ruta donde se almacenarán las imágenes de los productos
            $targetDir = "../../../img/Productos/";
            // Creamos un nombre único para el archivo de imagen
            $filename = uniqid('product_') . '.' . pathinfo($_FILES["Imagen"]["name"], PATHINFO_EXTENSION);
            // Ruta completa del archivo de imagen
            $targetFile = $targetDir . $filename;

            // Definimos los tipos de archivo permitidos
            $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
            // Obtenemos la extensión del archivo
            $fileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            // Verificamos si la extensión del archivo es permitida
            if (!in_array($fileType, $allowedTypes)) {
                throw new Exception("Error: Solo se permiten archivos JPG, JPEG, PNG o GIF.");
            }

            // Movemos el archivo de imagen al directorio de destino
            if (!move_uploaded_file($_FILES["Imagen"]["tmp_name"], $targetFile)) {
                throw new Exception("Error: No se pudo mover el archivo de imagen al directorio de destino.");
            }
        }

        // Actualizar el producto en la base de datos
        if (actualizarProducto($conexion, $id_producto, $id_empresa, $id_categoria, $id_TipTalla, $descripcion, $especificacionProducto, $registro, ($opcion === 'SI' ? $targetFile : null))) {
            // Confirmar la transacción
            $conexion->commit();

            // Éxito: redirige o muestra un mensaje
            echo '<script type="text/javascript">';
            echo 'alert("¡Registro del Producto Modificado Exitosamente!");';
            echo 'window.location = "../../../Vista/DEV/Producto_Dev.php";';
            echo '</script>';
            exit();
        } else {
            throw new Exception("Error al intentar modificar el registro del producto.");
        }
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();

        // Muestra un mensaje de error
        echo '<script type="text/javascript">';
        echo 'alert("Error: ' . $e->getMessage() . '");';
        echo 'window.location = "../../../Vista/DEV/Producto_Dev.php";';
        echo '</script>';
        exit();
    } finally {
        // Cerrar la conexión
        $conexion->close();
    }
} else {
    // Si no es una solicitud POST, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: Acceso no permitido.");';
    echo 'window.location = "../../../Vista/DEV/Producto_Dev.php";';
    echo '</script>';
    exit();
}
?>