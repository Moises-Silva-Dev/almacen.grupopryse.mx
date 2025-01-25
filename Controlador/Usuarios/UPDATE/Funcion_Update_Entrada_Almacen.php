<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México
include('../../../Modelo/Conexion.php'); // Incluir el archivo de conexión
require_once("../../../Modelo/Funciones/Funciones_EntradaD.php"); // Carga la clase de funciones de la entradaD
require_once("../../../Modelo/Funciones/Funciones_EntradaE.php"); // Carga la clase de funciones de la entradaE
require_once("../../../Modelo/Funciones/Funciones_Inventario.php"); // Carga la clase de funciones de la inventario
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php"); // Carga la clase de funciones de tipo de usuario

$conexion = (new Conectar())->conexion(); // Conectar a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $id_EntradaE = $_POST['IdEntE'];
    $Proveedor = $_POST['Proveedor'];
    $Receptor = $_POST['Receptor'];
    $Comentarios = $_POST['Comentarios'];
    $estatus = 'Modificado';
    $nuevoNumeroModif = intval($_POST['Nro_Modif']) + 1;
    $registro = date('Y-m-d H:i:s', time()); // Obtiene la fecha y hora actual
    $usuario = $_SESSION["usuario"]; // Recuperar el usuario de la sesión

    if (!$Proveedor || !$Receptor || !$Comentarios) { // Verificar que los campos no estén vacíos
        echo json_encode([ // Devuelve un arreglo JSON con el mensaje de error
            "success" => false, // Indica que la operación no se realizó con éxito
            "message" => "Datos inválidos. Por favor, revise la información enviada."
        ]);
        exit; // Salir del script
    }

    // Comienza la transacción
    $conexion->begin_transaction();

    try {
        $InformacionEntradaD = SeleccionarInformacionEntradaD($conexion, $id_EntradaE);

        if (!$InformacionEntradaD) { // Verificar si se ha insertado correctamente la región
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al buscar en la tabla requisicionE.");
        }

        if (!ActualizarEntradE($conexion, $registro, $nuevoNumeroModif, $Proveedor, $Receptor, $Comentarios, $estatus, $id_EntradaE)) {// Verificar si se ha insertado correctamente la región
            // Lanzar una excepción en caso de error en la inserción
            throw new Exception("Error al buscar en la tabla entradaE.");
        }

        // Inserta en la tabla EntradaD
        if (!ActualizarInventario($conexion, $InformacionEntradaD)) {
            // Si la inserción falla, se lanza una excepción
            throw new Exception("Error al insertar en EntradaD");
        }

        // Eliminar la entrada en la tabla EntradaD
        if (!EliminarEntradaD($conexion, $id_EntradaE)) {
            // Si la eliminación falla, se lanza una excepción
            throw new Exception('Error al eliminar la entrada de la tabla EntradaD');
        }

        // Verifica si $_POST['datosTabla'] está definido
        if (isset($_POST['datosTablaUpdateEntrada'])) {
            // Decodifica los datos del formulario
            $datosTabla = json_decode($_POST['datosTablaUpdateEntrada'], true);
                    
            // Verifica si la decodificación fue exitosa
            if (json_last_error() === JSON_ERROR_NONE) {
                // Obtiene la cantidad de filas en los datos de la tabla
                $numFilas = count($datosTabla);
                    
                // Itera sobre los datos de la tabla oculta utilizando un bucle for
                for ($i = 0; $i < $numFilas; $i++) {
                    $idProducto = $datosTabla[$i]['idProduct'];
                    $idtall = $datosTabla[$i]['idtall'];
                    $cant = $datosTabla[$i]['cant'];
                                
                    // Inserta en la tabla EntradaD
                    if (!InsertarNuevaEntradaD($conexion, $id_EntradaE, $idProducto, $idtall, $cant)) {
                        // Si la inserción falla, se lanza una excepción
                        throw new Exception("Error al insertar en EntradaD");
                    }
    
                    // Inserta en la tabla Inventario
                    if (!insertarInventario($conexion, $idProducto, $idtall, $cant)){
                        // Si la inserción falla, se lanza una excepción
                        throw new Exception("Error al insertar en Inventario");
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

        // Si todo fue bien, hacer commit de la transacción
        $conexion->commit();

        $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion); // Buscar y retornar el tipo de usuario

        // Respuesta de éxito con la URL según tipo de usuario
        $urls = [
            1 => "../../../Vista/DEV/Almacen_Dev.php", // URL para el tipo de usuario 1
            2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php", // URL para el tipo de usuario 2
            3 => "../../../Vista/ADMIN/index_ADMIN.php", // URL para el tipo de usuario 3
            4 => "../../../Vista/USER/index_USER.php", // URL para el tipo de usuario 4
            5 => "../../../Vista/ALMACENISTA/Almacen_ALMACENISTA.php" // URL para el tipo de usuario 5
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