<?php
// Inicia una sesión PHP para manejar variables de sesión.
session_start();

// Configura la localización a español.
setlocale(LC_ALL, 'es_ES');

// Configura la zona horaria a Ciudad de México.
date_default_timezone_set('America/Mexico_City');

try {
    // Verifica si la solicitud es de tipo POST.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Incluye el archivo de conexión a la base de datos.
        include('../../../Modelo/Conexion.php');
        // Establece una conexión a la base de datos.
        $conexion = (new Conectar())->conexion();

        // Obtiene el ID de la empresa.
        $id_empresa = obtenerIdEmpresa($_POST, $conexion);
        // Obtiene el ID de la categoría.
        $id_categoria = obtenerIdCategoria($_POST, $conexion);
        // Obtiene el ID de la talla.
        $id_talla = obtenerIdTalla($_POST, $conexion);

        // Obtiene la descripción del producto.
        $descripcion = $_POST['Descripcion'];
        // Obtiene la especificación del producto.
        $especificacionProducto = $_POST['Especificacion'];
        // Obtiene la fecha y hora actual para el registro del producto.
        $registro = date('Y-m-d H:i:s', time());

        // Sube la imagen del producto y obtiene la ruta de la imagen.
        $imagen = subirImagen($_FILES['Imagen']);

        // Prepara una consulta para insertar el producto en la base de datos.
        $stmtProducto = $conexion->prepare("INSERT INTO Producto (IdCEmp, IdCCat, IdCTipTal, Descripcion, Especificacion, IMG, Fecha_Registro) VALUES (?,?,?,?,?,?,?);");
        // Vincula los parámetros de la consulta.
        $stmtProducto->bind_param("iiissss", $id_empresa, $id_categoria, $id_talla, $descripcion, $especificacionProducto, $imagen, $registro);

        // Ejecuta la consulta de inserción del producto.
        if ($stmtProducto->execute()) {
            // Muestra un mensaje de éxito en JavaScript y redirige a la página de productos.
            echo '<script type="text/javascript">';
            echo 'alert("¡Producto agregado exitosamente!");';
            echo 'window.location = "../../../Vista/DEV/Producto_Dev.php";';
            echo '</script>';
        } else {
            // Lanza una excepción si ocurre un error al insertar el producto en la base de datos.
            throw new Exception("Error al agregar el producto: " . $conexion->error);
        }

        // Cierra la consulta preparada del producto.
        $stmtProducto->close();
        // Cierra la conexión a la base de datos.
        $conexion->close();
    }
} catch (Exception $e) {
    // Captura y maneja cualquier excepción lanzada durante el proceso.
    echo '<script type="text/javascript">';
    echo 'alert("Error: ' . $e->getMessage() . '");';
    echo 'window.location = "../../../Vista/DEV/Producto_Dev.php";';
    echo '</script>';
}

// Función para obtener el ID de la empresa.
function obtenerIdEmpresa($datos, $conexion) {
    // Verifica si se seleccionó una nueva empresa.
    if ($datos['IdCEmpresa'] == 'nuevo_empresa') {
        // Obtiene los datos de la nueva empresa del formulario.
        $nombreEmpresa = $datos['Nombre_Empresa'];
        $razonSocial = $datos['RazonSocial'];
        $rfc = $datos['RFC'];
        $registroPatronal = $datos['RegistroPatronal'];
        $especificacion = $datos['Especif'];

        // Prepara una consulta para insertar la nueva empresa en la base de datos.
        $stmtNEmpresa = $conexion->prepare("INSERT INTO CEmpresas(Nombre_Empresa, RazonSocial, RFC, RegistroPatronal, Especif) VALUES (?,?,?,?,?);");
        // Vincula los parámetros de la consulta.
        $stmtNEmpresa->bind_param("sssss", $nombreEmpresa, $razonSocial, $rfc, $registroPatronal, $especificacion);

        // Ejecuta la consulta de inserción de la nueva empresa.
        if ($stmtNEmpresa->execute()) {
            // Devuelve el ID de la empresa insertada.
            return $conexion->insert_id;
        } else {
            // Lanza una excepción si ocurre un error al insertar la empresa en la base de datos.
            throw new Exception("Error al insertar empresa: " . $stmtNEmpresa->error);
        }
    } else {
        // Devuelve el ID de la empresa seleccionada.
        return $datos['IdCEmpresa'];
    }
}

// Función para obtener el ID de la categoría.
function obtenerIdCategoria($datos, $conexion) {
    // Verifica si se seleccionó una nueva categoría.
    if ($datos['IdCCate'] == 'nueva_Cate') {
        // Obtiene la descripción de la nueva categoría del formulario.
        $NCDescrip = $datos['Descrp'];

        // Prepara una consulta para insertar la nueva categoría en la base de datos.
        $stmtNCate = $conexion->prepare("INSERT INTO CCategorias (Descrp) VALUES (?);");
        // Vincula los parámetros de la consulta.
        $stmtNCate->bind_param("s", $NCDescrip);

        // Ejecuta la consulta de inserción de la nueva categoría.
        if ($stmtNCate->execute()) {
            // Devuelve el ID de la categoría insertada.
            return $conexion->insert_id;
        } else {
            // Lanza una excepción si ocurre un error al insertar la categoría en la base de datos.
            throw new Exception("Error al insertar categoría: " . $stmtNCate->error);
        }
    } else {
        // Devuelve el ID de la categoría seleccionada.
        return $datos['IdCCate'];
    }
}

// Función para obtener el ID de la talla.
function obtenerIdTalla($datos, $conexion) {
    // Verifica si se seleccionó una nueva talla.
    if ($datos['IdCTipTall'] == 'nueva_TipTall') {
        // Obtiene la descripción y talla de la nueva talla del formulario.
        $NTipTal = $datos['descrip'];
        $NTalla = $datos['Talla'];

        // Prepara una consulta para insertar el nuevo tipo de talla en la base de datos.
        $stmtNTipTalla = $conexion->prepare("INSERT INTO CTipoTallas (descrip) VALUES (?)");
        // Vincula los parámetros de la consulta.
        $stmtNTipTalla->bind_param("s", $NTipTal);

        // Ejecuta la consulta de inserción del nuevo tipo de talla.
        if ($stmtNTipTalla->execute()) {
            // Obtiene el ID del tipo de talla insertado.
            $id_TipTalla = $conexion->insert_id;

            // Prepara una consulta para insertar la nueva talla en la base de datos.
            $stmtNTalla = $conexion->prepare("INSERT INTO CTallas (IdCTipTal, Talla) VALUES (?,?)");
            // Vincula los parámetros de la consulta.
            $stmtNTalla->bind_param("is", $id_TipTalla, $NTalla);

            // Ejecuta la consulta de inserción de la nueva talla.
            if ($stmtNTalla->execute()) {
                // Devuelve el ID de la talla insertada.
                return $conexion->insert_id;
            } else {
                // Lanza una excepción si ocurre un error al insertar la talla en la base de datos.
                throw new Exception("Error al insertar talla: " . $stmtNTalla->error);
            }
        } else {
            // Lanza una excepción si ocurre un error al insertar el tipo de talla en la base de datos.
            throw new Exception("Error al insertar tipo de tallas: " . $stmtNTipTalla->error);
        }
    } else {
        // Devuelve el ID de la talla seleccionada.
        return $datos['IdCTipTall'];
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
?>