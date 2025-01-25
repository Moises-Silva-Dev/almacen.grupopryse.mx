<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México
include('../../../Modelo/Conexion.php'); // Incluir el archivo de conexión
require_once("../../../Modelo/Funciones/Funciones_Inventario.php");
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php"); // Carga la clase de funciones de tipo de usuario
require_once("../../../Modelo/Funciones/Funciones_SalidaE.php"); // Carga la clase de funciones de salidaE
require_once("../../../Modelo/Funciones/Funciones_SalidaD.php"); // Carga la clase de funciones de salidD
require_once("../../../Modelo/Funciones/Funciones_Usuarios.php");
require_once("../../../Modelo/Funciones/Funciones_RequisicionD.php");

$conexion = (new Conectar())->conexion(); // Conectar a la base de datos

// Procesamiento del formulario cuando se recibe una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos del formulario
    $usuario = $_SESSION['usuario'];            
    $ID_Requisicion = $_POST['ID_RequisicionE'];
    $fecha_salida = date('Y-m-d H:i:s');

    if (!$ID_Requisicion) { // Verificar que los campos no estén vacíos
        echo json_encode([ // Devuelve un arreglo JSON con el mensaje de error
            "success" => false, // Indica que la operación no se realizó con éxito
            "message" => "Datos inválidos. Por favor, revise la información enviada."
        ]);
        exit; // Salir del script
    }

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Busca el ID del usuario
        $ID_Usuario = ObtenerIdentificadorUsuario($conexion, $usuario);
        
        if (!$ID_Usuario) { // Verificar si se ha insertado correctamente la región
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al insertar en la tabla region.");
        }

        // Inserta el registro de salida en la tabla Salida_E
        $ID_SalidaE = InsertarNuevaSalidaE($conexion, $ID_Requisicion, $ID_Usuario, $fecha_salida);

        if (!$ID_SalidaE) { // Verificar si se ha insertado correctamente la región
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al insertar en la tabla region.");
        }

        // Verifica si $_POST['datosTabla'] está definido
        if (isset($_POST['datosTablaInsertSalida'])) {
            // Decodifica los datos del formulario
            $datosTabla = json_decode($_POST['datosTablaInsertSalida'], true);
        
            // Verifica si la decodificación fue exitosa
            if (json_last_error() === JSON_ERROR_NONE) {
                // Obtiene la cantidad de filas en los datos de la tabla
                $numFilas = count($datosTabla);
        
                // Itera sobre los datos de la tabla oculta utilizando un bucle for
                for ($i = 0; $i < $numFilas; $i++) {
                    // Obtiene los datos de la fila actual
                    $IdCProd = $datosTabla[$i]['IdCProd'];
                    $Id_Talla = $datosTabla[$i]['Id_Talla'];

                    // Asegurarse de que Cant sea un número válido
                    $Cant = isset($datosTabla[$i]['Cant']) && is_numeric($datosTabla[$i]['Cant']) 
                    ? (int)$datosTabla[$i]['Cant'] 
                    : 0;

                    // Si la cantidad es 0, se ignora esta iteración
                    if ($Cant === 0) {
                        continue;
                    }

                    if (!InsertarNuevaSalidaD($conexion, $ID_SalidaE, $IdCProd, $Id_Talla, $Cant)){
                        // Lanzar una excepción en caso de error en la inserción
                        throw new Exception("Error al insertar en la tabla Salida_D");
                    }
                    
                    if (!ActualizarInventarioPorSalidaRequisicion($conexion, $Cant, $IdCProd, $Id_Talla)){
                        // Lanzar una excepción en caso de error en la inserción
                        throw new Exception("Error al actualizar el inventario.");
                    }
                }
            } else {
                // Maneja el caso en el que $_POST['datosTabla'] no es un JSON válido
                throw new Exception("Los datos de la tabla no están en el formato JSON esperado.");
            }
        } else {
            // Maneja el caso en el que $_POST['datosTabla'] no está definido
            throw new Exception("No se recibieron datos de la tabla.");
        }
        
        //Actualizar Estatus
        if (!ActualizarEstatusRequisionESalida($conexion, $ID_Requisicion)){
            throw new Exception("Error al actualizar el estatus en la tabla RequisicionE");
        }

        // Si todo fue bien, hacer commit de la transacción
        $conexion->commit();

        $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion); // Buscar y retornar el tipo de usuario

        // Respuesta de éxito con la URL según tipo de usuario
        $urls = [
            1 => "../../../Vista/DEV/Salidas_Dev.php", // URL para el tipo de usuario 1
            2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php", // URL para el tipo de usuario 2
            3 => "../../../Vista/ADMIN/index_ADMIN.php", // URL para el tipo de usuario 3
            4 => "../../../Vista/USER/index_USER.php", // URL para el tipo de usuario 4
            5 => "../../../Vista/ALMACENISTA/Salidas_ALMACENISTA.php" // URL para el tipo de usuario 5
        ];
        
        echo json_encode([  // Enviar la respuesta en formato JSON
            "success" => true, // Indicar que la operación fue exitosa
            "message" => "Se ha Guardado Correctamente.",
            "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php" // Redireccionar a la página de inicio
        ]);
    } catch (Exception $e) {
        $conexion->rollback(); // Cancelar la transacción
        echo json_encode([ // Enviar la respuesta en formato JSON
            "success" => false, // Indicar que la operación falló
            "message" => "Error al realizar el registro: " . htmlspecialchars($e->getMessage())
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