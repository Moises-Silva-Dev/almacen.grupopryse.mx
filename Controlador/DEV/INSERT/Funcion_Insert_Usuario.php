<?php
// Iniciar sesión
session_start();

// Función para verificar si el correo electrónico ya está registrado
function verificarCorreoExistente($conexion, $correo_electronico) {
    $consulta_existencia_correo = $conexion->prepare("SELECT ID_Usuario FROM Usuario WHERE Correo_Electronico = ?;");
    $consulta_existencia_correo->bind_param("s", $correo_electronico);
    $consulta_existencia_correo->execute();
    $consulta_existencia_correo->store_result();
    $num_rows = $consulta_existencia_correo->num_rows;
    $consulta_existencia_correo->free_result();
    $consulta_existencia_correo->close();
    return $num_rows > 0;
}

// Función para insertar un nuevo usuario
function insertarUsuario($conexion, $datos_usuario) {
    try {
        // Preparar la consulta SQL para la inserción
        $sql = "INSERT INTO Usuario (Nombre, Apellido_Paterno, Apellido_Materno, NumTel, Correo_Electronico, Constrasena, NumContactoSOS, ID_Tipo_Usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssssssi", $datos_usuario['nombre'], $datos_usuario['apellido_paterno'], 
                          $datos_usuario['apellido_materno'], $datos_usuario['num_tel'], 
                          $datos_usuario['correo_electronico'], $datos_usuario['contrasena'], 
                          $datos_usuario['num_contacto_sos'], $datos_usuario['id_tipo']);

        // Ejecutar la consulta de inserción
        $stmt->execute();
        
        // Obtener el ID del usuario insertado
        $id_Usuario = $conexion->insert_id;

        // Cerrar la sentencia
        $stmt->close();

        return $id_Usuario;
        
    } catch (Exception $e) {
        // En caso de error, deshacer la transacción
        error_log("Error en insertarUsuario: " . $e->getMessage());
        return false;
    }
}

// Función para insertar un registro en la tabla Usuario_Cuenta
function insertarUsuarioCuenta($conexion, $id_Usuario, $cuentaId) {
    try {
        // Comprobar si 'ID_Cuenta' está presente
        $sqlUC = is_null($cuentaId) 
                 ? "INSERT INTO Usuario_Cuenta (ID_Usuarios) VALUES (?);"
                 : "INSERT INTO Usuario_Cuenta (ID_Usuarios, ID_Cuenta) VALUES (?, ?);";
        
        // Preparar la consulta
        $stmt1 = $conexion->prepare($sqlUC);

        // Vincular los parámetros
        if (is_null($cuentaId)) {
            $stmt1->bind_param("i", $id_Usuario);
        } else {
            $stmt1->bind_param("ii", $id_Usuario, $cuentaId);
        }

        // Ejecutar la consulta de inserción
        $stmt1->execute();

        // Cerrar la sentencia
        $stmt1->close();

        return true;

    } catch (Exception $e) {
        // Manejo de errores: registrar el error y retornar false
        error_log("Error en insertarUsuarioCuenta: " . $e->getMessage());
        return false;
    }
}

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar a la base de datos 
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();

    // Recuperar el correo electrónico del formulario
    $correo_electronico = $_POST["correo_electronico"];

    // Verificar si el correo electrónico ya está registrado
    if (verificarCorreoExistente($conexion, $correo_electronico)) {
        echo '<script type="text/javascript">';
        echo 'alert("ERROR, El correo electrónico ya está registrado por otro usuario.");';
        echo 'window.location = "../../../Vista/DEV/INSERT/Insert_Usuario_Dev.php";';
        echo '</script>';
        exit();
    }

    // Recuperar otros datos del formulario
    $datos_usuario = [
        'nombre' => $_POST["nombre"],
        'apellido_paterno' => $_POST["apellido_paterno"],
        'apellido_materno' => $_POST["apellido_materno"],
        'num_tel' => $_POST["num_tel"],
        'correo_electronico' => $correo_electronico,
        'contrasena' => password_hash($_POST["contrasena"], PASSWORD_DEFAULT),
        'num_contacto_sos' => $_POST["num_contacto_sos"],
        'id_tipo' => $_POST["ID_Tipo"]
    ];
    
    // Comenzar la transacción
    $conexion->begin_transaction();
    
    // Insertar el usuario y obtener su ID
    $id_Usuario = insertarUsuario($conexion, $datos_usuario);
    
    if ($id_Usuario !== false) {
        // Si el tipo de usuario es 3 o 4, procesar las cuentas
        if ($datos_usuario['id_tipo'] == 3 || $datos_usuario['id_tipo'] == 4) {
            // Verifica si $_POST['datosTabla'] está definido
            if (isset($_POST['DatosTablaCuenta'])) {
                // Decodifica los datos del formulario
                $datosTabla = json_decode($_POST['DatosTablaCuenta'], true);

                // Verifica si la decodificación fue exitosa
                if (json_last_error() === JSON_ERROR_NONE) {
                    // Obtiene la cantidad de filas en los datos de la tabla
                    $numFilas = count($datosTabla);

                    // Itera sobre los datos de la tabla oculta utilizando un bucle for
                    for ($i = 0; $i < $numFilas; $i++) {
                        $cuentaId = $datosTabla[$i]['cuentaId'];

                        // Inserta en la tabla Usuario_Cuenta
                        insertarUsuarioCuenta($conexion, $id_Usuario, $cuentaId);
                    }
                } else {
                    echo "Los datos de la tabla no están en el formato JSON esperado.";
                    $conexion->rollback();
                    exit();
                }
            } else {
                echo "No se recibieron datos de la tabla.";
                $conexion->rollback();
                exit();
            }
        } else {
            // Si el tipo de usuario no es 3 o 4, insertar con ID_Cuenta como NULL
            insertarUsuarioCuenta($conexion, $id_Usuario, $cuentaId = NULL);
        }

        // Confirmar la transacción
        $conexion->commit();
        echo '<script type="text/javascript">';
        echo 'alert("¡¡El Registro fue Exitoso!!");';
        echo 'window.location = "../../../Vista/DEV/Registro_Usuario_Dev.php";';
        echo '</script>';
        exit();
    } else {
        // Deshacer la transacción
        $conexion->rollback();
        echo '<script type="text/javascript">';
        echo 'alert("ERROR al registrar el usuario.");';
        echo 'window.location = "../../../Vista/DEV/INSERT/Insert_Usuario_Dev.php";';
        echo '</script>';
        exit();
    }

    // Cierra la conexión
    $conexion->close();
}
?>