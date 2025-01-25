<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México
include('../../../Modelo/Conexion.php'); // Incluir el archivo de conexión
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php"); // Carga la clase de funciones de tipo de usuario
require_once("../../../Modelo/Funciones/Funciones_Usuarios.php"); // Carga la clase de funciones de la cuenta

$conexion = (new Conectar())->conexion(); // Conectar a la base de datos

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $id_Usuario = $_POST['id'];
    $ID_Tipo = $_POST['ID_Tipo'];
    $usuario = $_SESSION["usuario"]; // Recuperar el usuario de la sesión

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Verificamos si se ha recibido un tipo de usuario (ID_Tipo).
        if (!empty($ID_Tipo)) {
            // Si el tipo de usuario no es 3 o 4, realizamos las siguientes operaciones.
            if ($ID_Tipo != 3 && $ID_Tipo != 4) {

                // Actualizamos el rol del usuario en la base de datos.
                if (!UpdateRolUsuario($conexion, $ID_Tipo, $id_Usuario)) {
                    throw new Exception("Error al intentar modificar el rol.");
                }

                // Eliminamos cualquier vinculación existente entre el usuario y cuentas en la tabla `Usuario_Cuenta`.
                if (!EliminarUsuarioCuenta($conexion, $id_Usuario)) {
                    throw new Exception("Error al intentar eliminar la relacion.");
                }

                // Insertamos el registro en `Usuario_Cuenta` con `ID_Cuenta` como `NULL` ya que el tipo de usuario no es 3 o 4.
                if (!InsertarNuevoUsuarioCuenta($conexion, $id_Usuario, $cuentaId = NULL)) {
                    throw new Exception("Error al intentar eliminar la relacion.");
                }
            } else {
                // Si el tipo de usuario es 3 o 4, verificamos si se han recibido datos de la tabla `DatosTablaCuenta`.
                if (isset($_POST['DatosTablaCuenta'])) {
                    // Decodificamos los datos JSON enviados desde el formulario.
                    $datosTabla = json_decode($_POST['DatosTablaCuenta'], true);

                    // Comprobamos que la decodificación del JSON fue exitosa.
                    if (json_last_error() === JSON_ERROR_NONE) {
                        // Eliminamos las vinculaciones anteriores del usuario en `Usuario_Cuenta`.
                        if (!EliminarUsuarioCuenta($conexion, $id_Usuario)) {
                            throw new Exception("Error al intentar eliminar la relacion.");
                        }

                        // Actualizamos el rol del usuario.
                        if (!UpdateRolUsuario($conexion, $ID_Tipo, $id_Usuario)) {
                            throw new Exception("Error al intentar modificar el rol.");
                        }

                        // Contamos cuántas filas de datos se han enviado.
                        $numFilas = count($datosTabla);

                        // Recorremos los datos enviados y vinculamos cada cuenta con el usuario.
                        for ($i = 0; $i < $numFilas; $i++) {
                            // Variable que vincule la información
                            $cuentaId = $datosTabla[$i]['cuentaId'];
                            
                            // Inserta en la tabla Usuario_Cuenta
                            if (!InsertarNuevoUsuarioCuenta($conexion, $id_Usuario, $cuentaId)) {
                                throw new Exception("Error al insertar en usuario cuenta");
                            }
                        }
                    } else {
                        // Si la decodificación del JSON falla, mostramos un error y hacemos rollback.
                        throw new Exception("Los datos de la tabla no están en el formato JSON esperado.");
                    }
                } else {
                    // Lanzar una excepción en caso de error en la inserción
                    throw new Exception("Los datos de la tabla no están en el formato JSON esperado.");
                }
            }
        } else {
            // Variable que almacena cuentas pendientes con el usuario
            $CuentasPend = BuscarCuentasUsuario($conexion, $id_Usuario);

            // Verificamos si se recibieron datos actualizados de la tabla.
            if (isset($_POST['DatosTablaCuentaUpdate'])) {
                // Decodifica los datos del formulario
                $datosTabla = json_decode($_POST['DatosTablaCuentaUpdate'], true);
                
                // Comprobamos que la decodificación del JSON fue exitosa.
                if (json_last_error() === JSON_ERROR_NONE) {
                        
                    // Eliminar la vinculación en la Tabla Usuario_Cuenta
                    if (!EliminarUsuarioCuenta($conexion, $id_Usuario)) {
                        throw new Exception("Error al intentar eliminar la relacion.");
                    }
                        
                    // Obtiene la cantidad de filas en los datos de la tabla
                    $numFilas = count($datosTabla);
                    $numFilasPend = count($CuentasPend);
    
                    // Insertamos los nuevos registros en `Usuario_Cuenta`.
                    for ($i = 0; $i < $numFilas; $i++) {
                        // Variable que vincule la información
                        $cuentaId = $datosTabla[$i]['cuentaId'];
    
                        // Inserta en la tabla Usuario_Cuenta
                        if (!InsertarNuevoUsuarioCuenta($conexion, $id_Usuario, $cuentaId)) {
                            throw new Exception("Error al insertar en usuario cuenta");
                        }
                    }
                    
                    // Vinculamos las cuentas pendientes si no están ya asociadas al usuario.
                    for ($j = 0; $j < $numFilasPend; $j++) {
                        // Variable que vincule la información
                        $ID_CuentaP = $CuentasPend[$j]['ID'];
                        
                        // Verificamos si ya existe la vinculación y si no, la añadimos.
                        if (!VerificarUsuarioCuenta($conexion, $id_Usuario, $ID_CuentaP)) {
                            
                            // Si no está vinculada, insertarla
                            if (!InsertarNuevoUsuarioCuenta($conexion, $id_Usuario, $ID_CuentaP)) {
                                throw new Exception("Error al insertar en usuario cuenta existente");
                            }
                        }
                    }
                } else {
                    // Si la decodificación del JSON falla, mostramos un error y hacemos rollback.
                    throw new Exception("Los datos de la tabla no están en el formato JSON esperado.");
                }
            } else {
                // Lanzar una excepción en caso de error en la inserción
                throw new Exception("Los datos de la tabla no están en el formato JSON esperado.");
            }
        }

        // Confirmar la transacción
        $conexion->commit();

        $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion); // Buscar y retornar el tipo de usuario

        // Respuesta de éxito con la URL según tipo de usuario
        $urls = [
            1 => "../../../Vista/DEV/Registro_Usuario_Dev.php", // URL para el tipo de usuario 1
            2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php", // URL para el tipo de usuario 2
            3 => "../../../Vista/ADMIN/index_ADMIN.php", // URL para el tipo de usuario 3
            4 => "../../../Vista/USER/index_USER.php", // URL para el tipo de usuario 4
            5 => "../../../Vista/ALMACENISTA/index_ALMACENISTA.php" // URL para el tipo de usuario 5
        ];

        echo json_encode([  // Enviar la respuesta en formato JSON
            "success" => true, // Indicar que la operación fue exitosa
            "message" => "Se ha Cambiado el Rol Correctamente.",
            "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php" // Redireccionar a la página de inicio
        ]);
    } catch (Exception $e) {
        $conexion->rollback(); // Cancelar la transacción
        echo json_encode([ // Enviar la respuesta en formato JSON
            "success" => false, // Indicar que la operación falló
            "message" => "No se pudo realizar el registro: " . $e->getMessage()
        ]);
    } finally {
        // Cerrar la conexión
        $conexion->close();
    }
} else {
    echo json_encode([ // Devuelve un JSON con el resultado
        "success" => false, // Indica que la operación falló
        "message" => "No se proporcionó un ID válido."
    ]);
}
?>