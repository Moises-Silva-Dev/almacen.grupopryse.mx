<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México

// Incluir dependencias necesarias
include('../../../Modelo/Conexion.php'); // Incluir el archivo de conexión
require_once("../../../Modelo/Funciones/Funciones_Borrador_RequisicionD.php"); // Carga la clase de funciones de requisionD
require_once("../../../Modelo/Funciones/Funciones_Borrador_RequisicionE.php"); // Carga la clase de funciones de requisionD
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php"); // Carga la clase de funciones de tipo de usuario
require_once("../../../Modelo/Funciones/Funciones_Usuarios.php"); // Carga la clase de funciones de usuarios

$conexion = (new Conectar())->conexion(); // Conectar a la base de datos

// Verificar si la conexión a la base de datos fue exitosa
if (!$conexion || $conexion->connect_error) {
    echo json_encode([ // Si la conexión falla, enviar un mensaje de error
        "success" => false, // Indicar si la operación fue exitosa
        "message" => "Error en la conexión: " . $conexion->connect_error // Mostrar el error de conexión
    ]);
    exit; // Salir del script
}

// Procesamiento del formulario cuando se recibe una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura los datos del formulario
    $Supervisor = $_POST['Supervisor'];
    $ID_Cuenta = $_POST['ID_Cuenta'];
    $Region = $_POST['Region'];
    $CentroTrabajo = $_POST['CentroTrabajo'];
    $NroElementos = $_POST['NroElementos'];
    $Estado = $_POST['Estado'];
    $Receptor = $_POST['Receptor'];
    $TelReceptor = $_POST['num_tel'];
    $RfcReceptor = $_POST['RFC'];
    $Opcion = $_POST['Opcion'];
    $Justificacion = $_POST['Justificacion'];            
    $FchCreacion = date('Y-m-d H:i:s', time()); // Obtiene la fecha y hora de creación de la requisición                 
    $usuario = $_SESSION['usuario']; // Obtiene el Correo del usuario actual

    if (!$Supervisor || !$ID_Cuenta || !$Region || !$NroElementos || !$Estado || 
        !$Receptor || !$TelReceptor || !$Opcion || !$Justificacion) { // Verificar que los campos no estén vacíos
        echo json_encode([ // Devuelve un arreglo JSON con el mensaje de error
            "success" => false, // Indica que la operación no se realizó con éxito
            "message" => "Datos inválidos. Por favor, revise la información enviada." // Muestra el mensaje de error
        ]);
        exit; // Salir del script
    }

    // Comenzar la transacción
    $conexion->begin_transaction();

    try {        
        // Buscar el identificador del usuario
        $id_Usuario = ObtenerIdentificadorUsuario($conexion, $usuario);

        if (!$id_Usuario) { // Si el usuario no existe, mostrar un mensaje de error
            // Si no se encuentra el identificador del usuario, se devuelve un mensaje de error
            throw new Exception("No se encontró el identificador del usuario");
        }

        // Buscar el identificador de la requisicion
        $ID_RequisionE = InsertarNuevoBorradorRequisicionE($conexion, $id_Usuario, $FchCreacion, $Supervisor, $ID_Cuenta, $Region, $CentroTrabajo, $NroElementos, $Estado, $Receptor, $TelReceptor, $RfcReceptor, $Justificacion);
        
        if (!$ID_RequisionE) { // Si la inserción falla, mostrar un mensaje de error
            // Si la inserción falla, se lanza una excepción
            throw new Exception("Error al insertar en la tabla RequisicionE");
        }

        // Si se seleccionó "Enviar a domicilio"
        if ($Opcion == 'SI') {
            // Captura los datos de envío
            $Mpio = $_POST['Mpio'];
            $Colonia = $_POST['Colonia'];
            $Calle = $_POST['Calle'];
            $Nro = $_POST['Nro'];
            $CP = $_POST['CP'];

            // Actualiza la requisición con los datos de envío
            if (!ActualizarDomicilioBorradorRequisicionE($conexion, $Mpio, $Colonia, $Calle, $Nro, $CP, $ID_RequisionE)) {
                // Si la actualización falla, se lanza una excepción
                throw new Exception("Error al actualizar la requisiciónE");
            }
        }

        // Verifica si $_POST['datosTabla'] está definido
        if (isset($_POST['datosTabla'])) {
            // Decodifica los datos del formulario
            $datosTabla = json_decode($_POST['datosTabla'], true);

            // Verifica si la decodificación fue exitosa
            if (json_last_error() === JSON_ERROR_NONE) {
                // Obtiene la cantidad de filas en los datos de la tabla
                $numFilas = count($datosTabla);

                // Itera sobre los datos de la tabla oculta utilizando un bucle for
                for ($i = 0; $i < $numFilas; $i++) {
                    // Obtiene los datos de la fila actual
                    $idProducto = $datosTabla[$i]['idProduct'];
                    $idtall = $datosTabla[$i]['idtall'];
                    $cant = $datosTabla[$i]['cant'];

                    // Inserta en la tabla RequisicionD
                    if (!InsertarNuevoBorradorRequisicionD($conexion, $ID_RequisionE, $idProducto, $idtall, $cant)) {
                        // Si la inserción falla, se lanza una excepción
                        throw new Exception("Error al insertar en la tabla RequisicionD");
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
            1 => "../../../Vista/DEV/index_DEV.php", // URL para el tipo de usuario 1
            2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php", // URL para el tipo de usuario 2
            3 => "../../../Vista/ADMIN/Solicitud_ADMIN.php", // URL para el tipo de usuario 3
            4 => "../../../Vista/USER/Solicitud_USER.php", // URL para el tipo de usuario 4
            5 => "../../../Vista/ALMACENISTA/index_ALMACENISTA.php" // URL para el tipo de usuario 5
        ];

        echo json_encode([  // Enviar la respuesta en formato JSON
            "success" => true, // Indicar que la operación fue exitosa
            "message" => "Se ha Guardado Correctamente.", // Mensaje de éxito
            "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php" // Redireccionar a la página de inicio
        ]);
    } catch (Exception $e) {
        $conexion->rollback(); // Cancelar la transacción
        echo json_encode([ // Enviar la respuesta en formato JSON
            "success" => false, // Indicar que la operación falló
            "message" => "Error al realizar el registro: " . htmlspecialchars($e->getMessage()) // Mensaje de error
        ]);
    } finally {
        // Cerrar la conexión
        $conexion->close();
    }
} else {
    echo json_encode([ // Devuelve un JSON con el resultado
        "success" => false, // Indica que la operación falló
        "message" => "No se proporcionó un ID válido." // Mensaje de error
    ]);
}
?>