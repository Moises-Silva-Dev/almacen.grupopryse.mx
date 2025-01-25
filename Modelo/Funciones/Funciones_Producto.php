<?php
// Función para registrar el producto

use Complex\Functions;

function insertarNuevoProducto($conexion, $ID_Empresa, $ID_Categoria, $ID_TipoTalla, $Descripcion, $Especificacion, $imagen, $registro) {
    // Preparar consulta SQL para insertar el registro
    $SetenciaInsertarNuevoProducto = "INSERT INTO Producto (IdCEmp, IdCCat, IdCTipTal, Descripcion, Especificacion, IMG, Fecha_Registro) VALUES (?,?,?,?,?,?,?)";

    // Prepara una consulta para insertar el producto en la base de datos.
    $StmtInsertarNuevoProducto = $conexion->prepare($SetenciaInsertarNuevoProducto);
    
    // Vincula los parámetros de la consulta.
    $StmtInsertarNuevoProducto->bind_param("iiissss", $ID_Empresa, $ID_Categoria, $ID_TipoTalla, $Descripcion, $Especificacion, $imagen, $registro);

    // Ejecutar la consulta
    if ($StmtInsertarNuevoProducto->execute()) {
        return true; // Si se ejecuta correctamente, devuelve true
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar nueva región: " . $conexion->error);
    }
}

// Función para obtener el ID de la categoría.
function InsertarNuevaCategoria($conexion, $IdCCate, $Descrp) {
    // Verifica si se seleccionó una nueva categoría.
    if ($IdCCate == 'nueva_Cate') {
        // Preparar consulta SQL para insertar el registro
        $SetenciaInsertarNuevaCategoria = "INSERT INTO CCategorias (Descrp) VALUES (?)";

        // Prepara una consulta para insertar la nueva categoría en la base de datos.
        $StmtInsertarNuevaCategoria = $conexion->prepare($SetenciaInsertarNuevaCategoria);
        
        // Vincula los parámetros de la consulta.
        $StmtInsertarNuevaCategoria->bind_param("s", $Descrp);

        // Ejecuta la consulta de inserción de la nueva categoría.
        if ($StmtInsertarNuevaCategoria->execute()) {
            // Devuelve el ID de la categoría insertada.
            return $conexion->insert_id;
        } else {
            // Lanza una excepción si ocurre un error al insertar la categoría en la base de datos.
            throw new Exception("Error al insertar categoría: " . $conexion->error);
        }
    } else {
        // Devuelve el ID de la categoría seleccionada.
        return $IdCCate;
    }
}

// Función para obtener el ID de la talla.
function InsertarNuevaTipoTalla($conexion, $IdCTipTall, $Descrip, $Talla) {
    // Verifica si se seleccionó una nueva talla.
    if ($IdCTipTall == 'nueva_TipTall') {
        // Preparar consulta SQL para insertar el registro
        $SetenciaInsertarNuevaTipoTalla = "INSERT INTO CTipoTallas (descrip) VALUES (?)";

        // Prepara una consulta para insertar el nuevo tipo de talla en la base de datos.
        $StmtInsertarNuevaTipoTalla = $conexion->prepare($SetenciaInsertarNuevaTipoTalla);

        // Vincula los parámetros de la consulta.
        $StmtInsertarNuevaTipoTalla->bind_param("s", $Descrip);

        // Ejecuta la consulta de inserción del nuevo tipo de talla.
        if ($StmtInsertarNuevaTipoTalla->execute()) {
            // Obtiene el ID del tipo de talla insertado.
            $ID_TipTalla = $conexion->insert_id;

            // Preparar consulta SQL para insertar el registro
            $SetenciaInsertarNuevaTalla = "INSERT INTO CTallas (IdCTipTal, Talla) VALUES (?,?)";

            // Prepara una consulta para insertar la nueva talla en la base de datos.
            $StmtInsertarNuevaTalla = $conexion->prepare($SetenciaInsertarNuevaTalla);

            // Vincula los parámetros de la consulta.
            $StmtInsertarNuevaTalla->bind_param("is", $ID_TipTalla, $Talla);

            // Ejecuta la consulta de inserción de la nueva talla.
            if ($StmtInsertarNuevaTalla->execute()) {
                // Devuelve el ID de la talla insertada.
                return $conexion->insert_id;
            } else {
                // Lanza una excepción si ocurre un error al insertar la talla en la base de datos.
                throw new Exception("Error al insertar talla: " . $conexion->error);
            }
        } else {
            // Lanza una excepción si ocurre un error al insertar el tipo de talla en la base de datos.
            throw new Exception("Error al insertar tipo de tallas: " . $conexion->error);
        }
    } else {
        // Devuelve el ID de la talla seleccionada.
        return $IdCTipTall;
    }
}

// Función para subir la imagen del producto.
function subirImagen($imagen) {
    // Directorio de destino para la imagen.
    $targetDir = "../../../img/Productos/";

    // Genera un nombre único para la imagen.
    $filename = uniqid('product_') . '.' . pathinfo($imagen["name"], PATHINFO_EXTENSION);

    // Ruta completa de destino para la imagen.
    $targetFile = $targetDir . $filename;

    // Tipos de archivo permitidos.
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');

    // Obtiene la extensión del archivo.
    $fileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    // Verifica si la extensión del archivo está permitida.
    if (!in_array($fileType, $allowedTypes)) {
        // Lanza una excepción si el tipo de archivo no está permitido.
        throw new Exception("Error: Solo se permiten archivos JPG, JPEG, PNG o GIF.");
    }

    // Sube el archivo al directorio de destino.
    if (move_uploaded_file($imagen["tmp_name"], $targetFile)) {
        // Devuelve la ruta de la imagen.
        return $targetFile;
    } else {
        // Lanza una excepción si ocurre un error al subir el archivo.
        throw new Exception("Error al subir el archivo.");
    }
}

// Función para eliminar la Imagen del producto.
function DeleteIMGProducto ($conexion, $ID_Producto){
    // Declarar variable
    $IMG = "";

    // Obtener la información del archivo y la carpeta antes de eliminar el registro
    $SetenciaEliminarIMGProducto = "SELECT IMG FROM Producto WHERE IdCProducto = ?";

    // Preparar la consulta
    $StmtEliminarIMGProducto = $conexion->prepare($SetenciaEliminarIMGProducto);

    // Ejecutar la consulta
    $StmtEliminarIMGProducto->bind_param("i", $ID_Producto);

    // Ejecutar la consulta
    $StmtEliminarIMGProducto->execute();
    
    // Obtener los datos
    $StmtEliminarIMGProducto->bind_result($IMG);

    // Obtener los datos
    $StmtEliminarIMGProducto->fetch();

    // Elimina el archivo
    if (unlink($IMG)) {
        return true;
    } else {
        return false;
    }
}

// Eliminar el producto
function DeleteProducto($conexion, $ID_Producto) {
    // Eliminar el registro de la base de datos
    $SetenciaEliminarProducto = "DELETE FROM Producto WHERE IdCProducto = ?";

    // Preparar la consulta
    $StmtEliminarProducto = $conexion->prepare($SetenciaEliminarProducto);

    // Ejecutar la consulta
    $StmtEliminarProducto->bind_param("i", $ID_Producto);
        
    // Ejecutar la consulta
    if ($StmtEliminarProducto->execute()) {
        return true; // Si se ejecuta correctamente, devuelve true
    } else {
        // Lanzar una excepción para activar el bloque catch
        throw new Exception("Error al insertar nueva región: " . $conexion->error);
    }
}

// Función para actualizar el producto
function ActualizarProducto($conexion, $ID_Empresa, $ID_Categoria, $ID_TipTalla, $Descripcion, $Especificacion, $imagen, $registro, $ID_Producto) {
    if ($imagen !== null) {
        // Actualizar el registro de la base de datos
        $SetenciaActualizarProducto = "UPDATE Producto SET IdCEmp = ?, IdCCat = ?, IdCTipTal = ?, Descripcion = ?, Especificacion = ?, IMG = ?, Fecha_Registro = ? WHERE IdCProducto = ?";
        
        // Preparar la consulta SQL para actualizar el producto con la nueva imagen
        $StmtActualizarProducto = $conexion->prepare($SetenciaActualizarProducto);
        
        // Asociamos los parámetros a la consulta preparada
        $StmtActualizarProducto->bind_param("iiissssi", $ID_Empresa, $ID_Categoria, $ID_TipTalla, $Descripcion, $Especificacion, $imagen, $registro, $ID_Producto);
    } else {
        // Actualizar el registro de la base de datos
        $ActualizarProducto = "UPDATE Producto SET IdCEmp = ?, IdCCat = ?, IdCTipTal = ?, Descripcion = ?, Especificacion = ?, Fecha_Registro = ? WHERE IdCProducto = ?";
        
        // Si no se está enviando un archivo de imagen, actualizamos el producto sin cambiar la imagen
        $StmtActualizarProducto = $conexion->prepare($ActualizarProducto);
        
        // Asociamos los parámetros a la consulta preparada
        $StmtActualizarProducto->bind_param("iiisssi", $ID_Empresa, $ID_Categoria, $ID_TipTalla, $Descripcion, $Especificacion, $registro, $ID_Producto);
    }

    // Ejecutar la consulta
    if ($StmtActualizarProducto->execute()) {
        return true;
    } else {
        return false;
    }
}
?>