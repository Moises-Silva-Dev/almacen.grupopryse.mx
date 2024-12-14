<?php
// Iniciamos sesión
session_start();

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conectar a la base de datos
    include('../../../Modelo/Conexion.php');
    $conexion = (new Conectar())->conexion();

    // Obtener datos del formulario
    $id_usuario = $_POST['id'];
    $ID_Tipo = $_POST['ID_Tipo'];
    $idTipo = $_POST['idTipo'];

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Verificamos si se ha recibido un tipo de usuario (ID_Tipo).
        if (!empty($ID_Tipo)) {
            // Si el tipo de usuario no es 3 o 4, realizamos las siguientes operaciones.
            if ($ID_Tipo != 3 && $ID_Tipo != 4) {
                
                // Actualizamos el rol del usuario en la base de datos.
                UpdateRolUsuario($conexion, $ID_Tipo, $id_usuario);

                // Eliminamos cualquier vinculación existente entre el usuario y cuentas en la tabla `Usuario_Cuenta`.
                DeleteVincUsuario($conexion, $id_usuario);

                // Insertamos el registro en `Usuario_Cuenta` con `ID_Cuenta` como `NULL` ya que el tipo de usuario no es 3 o 4.
                insertarUsuarioCuenta($conexion, $id_usuario, $cuentaId = NULL);
            } else {
                // Si el tipo de usuario es 3 o 4, verificamos si se han recibido datos de la tabla `DatosTablaCuenta`.
                if (isset($_POST['DatosTablaCuenta'])) {
                    // Decodificamos los datos JSON enviados desde el formulario.
                    $datosTabla = json_decode($_POST['DatosTablaCuenta'], true);

                    // Comprobamos que la decodificación del JSON fue exitosa.
                    if (json_last_error() === JSON_ERROR_NONE) {
                        // Eliminamos las vinculaciones anteriores del usuario en `Usuario_Cuenta`.
                        DeleteVincUsuario($conexion, $id_usuario);

                        // Actualizamos el rol del usuario.
                        UpdateRolUsuario($conexion, $ID_Tipo, $id_usuario);

                        // Contamos cuántas filas de datos se han enviado.
                        $numFilas = count($datosTabla);

                        // Recorremos los datos enviados y vinculamos cada cuenta con el usuario.
                        for ($i = 0; $i < $numFilas; $i++) {
                            // Variable que vincule la información
                            $cuentaId = $datosTabla[$i]['cuentaId'];
                            
                            // Inserta en la tabla Usuario_Cuenta
                            insertarUsuarioCuenta($conexion, $id_usuario, $cuentaId);
                        }
                    } else {
                        // Si ocurre un error en la decodificación del JSON, mostramos un mensaje y hacemos rollback.
                        echo "Los datos de la tabla no están en el formato JSON esperado.";
                        $conexion->rollback();
                        exit();
                    }
                } else {
                    // Si no se recibieron los datos esperados, mostramos un mensaje de error y hacemos rollback.
                    echo "No se recibieron datos de la tabla.";
                    $conexion->rollback();
                    exit();
                }
            }
        } else {
            // Variable que almacena cuentas pendientes con el usuario
            $CuentasPend = BuscarCuentasUsuario($conexion, $id_usuario);
            
            // Verificamos si se recibieron datos actualizados de la tabla.
            if (isset($_POST['DatosTablaCuentaUpdate'])) {
                // Decodifica los datos del formulario
                $datosTabla = json_decode($_POST['DatosTablaCuentaUpdate'], true);
    
                // Comprobamos que la decodificación del JSON fue exitosa.
                if (json_last_error() === JSON_ERROR_NONE) {
                        
                    // Eliminar la vinculación en la Tabla Usuario_Cuenta
                    DeleteVincUsuario($conexion, $id_usuario);
                        
                    // Obtiene la cantidad de filas en los datos de la tabla
                    $numFilas = count($datosTabla);
                    $numFilasPend = count($CuentasPend);
    
                    // Insertamos los nuevos registros en `Usuario_Cuenta`.
                    for ($i = 0; $i < $numFilas; $i++) {
                        // Variable que vincule la información
                        $cuentaId = $datosTabla[$i]['cuentaId'];
    
                        // Inserta en la tabla Usuario_Cuenta
                        insertarUsuarioCuenta($conexion, $id_usuario, $cuentaId);
                    }
                    
                    // Vinculamos las cuentas pendientes si no están ya asociadas al usuario.
                    for ($j = 0; $j < $numFilasPend; $j++) {
                        // Variable que vincule la información
                        $ID_CuentaP = $CuentasPend[$j]['ID'];
                        
                        // Verificamos si ya existe la vinculación y si no, la añadimos.
                        if (!VerificarUsuarioCuenta($conexion, $id_usuario, $ID_CuentaP)) {
                            
                            // Si no está vinculada, insertarla
                            insertarUsuarioCuenta($conexion, $id_usuario, $ID_CuentaP);
                        }
                    }
                } else {
                    // Si la decodificación del JSON falla, mostramos un error y hacemos rollback.
                    echo "Los datos de la tabla no están en el formato JSON esperado.";
                    $conexion->rollback();
                    exit();
                }
            } else {
                // Si no se reciben los datos actualizados de la tabla, mostramos un error y hacemos rollback.
                echo "No se recibieron datos de la tabla.";
                $conexion->rollback();
                exit();
            }
        }
        
        // Si todo va bien, confirmamos la transacción.
        $conexion->commit();

        // Éxito: redirige o muestra un mensaje
        echo '<script type="text/javascript">';
        echo 'alert("¡Registro modificado exitosamente!");';
        echo 'window.location = "../../../Vista/DEV/Registro_Usuario_Dev.php";';
        echo '</script>';
        exit();
    } catch (Exception $e) {
        // Si ocurre algún error durante el proceso, hacemos rollback para deshacer los cambios.
        $conexion->rollback();

        // Mostramos el mensaje de error con el detalle del mismo.
        echo '<script type="text/javascript">';
        echo 'alert("Error: ' . $e->getMessage() . '");';
        echo 'window.location = "../../../Vista/DEV/Registro_Usuario_Dev.php";';
        echo '</script>';
        exit();
    } finally {
        // Cerramos la conexión a la base de datos.
        $conexion->close();
    }
} else {
    // Si no es una solicitud POST, redirige o muestra un mensaje de error
    echo '<script type="text/javascript">';
    echo 'alert("Error: Acceso no permitido.");';
    echo 'window.location = "../../../Vista/DEV/Registro_Usuario_Dev.php";';
    echo '</script>';
    exit();
}

// Función para actualizar el tipo de usuario en la tabla `Usuario`
function UpdateRolUsuario($conexion, $ID_Tipo, $id_usuario) {
    // Consulta SQL para actualizar el tipo de usuario basado en su ID
    $SQLUpdate = "UPDATE Usuario SET ID_Tipo_Usuario = ? WHERE ID_Usuario = ?";
    
    // Preparamos la consulta
    $stmtUpdate = $conexion->prepare($SQLUpdate);
    
    // Vinculamos los parámetros: el tipo de usuario y el ID del usuario
    $stmtUpdate->bind_param("ii", $ID_Tipo, $id_usuario);
    
    // Ejecutamos la consulta
    $stmtUpdate->execute();
    
    // Cerramos la sentencia preparada
    $stmtUpdate->close();
    
    // Retornamos `true` para indicar que la actualización fue exitosa
    return true;
}

// Función para eliminar la vinculación entre un usuario y sus cuentas en la tabla `Usuario_Cuenta`
function DeleteVincUsuario($conexion, $id_usuario) {
    // Consulta SQL para eliminar las entradas de la tabla `Usuario_Cuenta` vinculadas a un usuario
    $SQLDelete = "DELETE FROM Usuario_Cuenta WHERE ID_Usuarios = ?";
    
    // Preparamos la consulta
    $stmtDelete = $conexion->prepare($SQLDelete);
    
    // Vinculamos el parámetro: el ID del usuario
    $stmtDelete->bind_param("i", $id_usuario);
    
    // Ejecutamos la consulta
    $stmtDelete->execute();
    
    // Cerramos la sentencia preparada
    $stmtDelete->close();
}

// Función para insertar un registro en la tabla `Usuario_Cuenta`
function insertarUsuarioCuenta($conexion, $id_usuario, $cuentaId) {
    try {
        // Verificamos si `ID_Cuenta` es `NULL` o tiene un valor y construimos la consulta SQL en consecuencia
        $SQLInsert = is_null($cuentaId) 
            // Si `ID_Cuenta` es `NULL`, solo insertamos `ID_Usuarios`
            ? "INSERT INTO Usuario_Cuenta (ID_Usuarios) VALUES (?)" 
            // Si `ID_Cuenta` tiene un valor, insertamos ambos
            : "INSERT INTO Usuario_Cuenta (ID_Usuarios, ID_Cuenta) VALUES (?, ?)";

        // Preparamos la consulta
        $stmtInsert = $conexion->prepare($SQLInsert);

        // Vinculamos los parámetros según el caso
        if (is_null($cuentaId)) {
            // Solo vinculamos `ID_Usuarios`
            $stmtInsert->bind_param("i", $id_usuario); 
        } else {
            // Vinculamos ambos, `ID_Usuarios` y `ID_Cuenta`
            $stmtInsert->bind_param("ii", $id_usuario, $cuentaId); 
        }

        // Ejecutamos la consulta de inserción
        $stmtInsert->execute();

        // Cerramos la sentencia preparada
        $stmtInsert->close();

        // Retornamos `true` para indicar que la inserción fue exitosa
        return true;

    } catch (Exception $e) {
        // En caso de error, registramos el mensaje de error en los logs
        error_log("Error en insertarUsuarioCuenta: " . $e->getMessage());
        // Retornamos `false` para indicar que ocurrió un error
        return false;
    }
}

// Función para obtener todas las cuentas vinculadas a un usuario y las requisiciones relacionadas
function BuscarCuentasUsuario($conexion, $id_usuario) {
    // Consulta SQL que selecciona las cuentas vinculadas a un usuario y cuenta el total de requisiciones pendientes o autorizadas
    $SQLSelect = "SELECT 
                        C.ID, C.NombreCuenta,
                        COUNT(REQ.IDRequisicionE) AS TotalRequisiciones
                    FROM 
                        RequisicionE REQ
                    INNER JOIN 
                        Cuenta C ON REQ.IdCuenta = C.ID
                    INNER JOIN 
                        Usuario U ON REQ.IdUsuario = U.ID_Usuario
                    WHERE 
                        REQ.Estatus IN ('Pendiente', 'Parcial', 'Autorizado') 
                    AND 
                        U.ID_Usuario = ?
                    GROUP BY 
                        C.ID, C.NombreCuenta";
    
    // Preparamos la consulta
    $stmtSelect = $conexion->prepare($SQLSelect);
    
    // Vinculamos el parámetro: el ID del usuario
    $stmtSelect->bind_param("i", $id_usuario);
    
    // Ejecutamos la consulta
    $stmtSelect->execute();
    
    // Obtenemos los resultados
    $resultSelect = $stmtSelect->get_result();

    // Verificamos si la consulta devolvió alguna fila
    if ($resultSelect->num_rows > 0) {
        // Creamos un array para almacenar los resultados
        $cuentas = array();
        
        // Recorremos las filas de los resultados
        while ($fila = $resultSelect->fetch_assoc()) {
            // Añadimos cada fila al array de cuentas
            $cuentas[] = $fila;
        }
        
        // Retornamos el array de cuentas
        return $cuentas;
    } else {
        // Si no hay resultados, retornamos `null` o un array vacío
        return null;
    }
}

// Función para verificar si un usuario ya está vinculado a una cuenta específica
function VerificarUsuarioCuenta($conexion, $id_Usuario, $id_Cuenta) {
    // Consulta SQL para contar cuántas veces aparece una combinación de `ID_Usuarios` y `ID_Cuenta` en la tabla `Usuario_Cuenta`
    $SQLVerifica = "SELECT COUNT(*) AS total FROM Usuario_Cuenta WHERE ID_Usuarios = ? AND ID_Cuenta = ?";
    
    // Preparamos la consulta
    $stmtVerifica = $conexion->prepare($SQLVerifica);
    
    // Vinculamos los parámetros: el ID del usuario y el ID de la cuenta
    $stmtVerifica->bind_param("ii", $id_Usuario, $id_Cuenta);
    
    // Ejecutamos la consulta
    $stmtVerifica->execute();
    
    // Obtenemos el resultado
    $result = $stmtVerifica->get_result();
    
    // Extraemos el resultado en un array asociativo
    $row = $result->fetch_assoc();
    
    // Cerramos la sentencia preparada
    $stmtVerifica->close();

    // Retornamos `true` si el usuario está vinculado a la cuenta (total > 0), de lo contrario, `false`
    return $row['total'] > 0;
}
?>