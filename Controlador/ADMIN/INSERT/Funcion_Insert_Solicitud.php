<?php
// Inicia la sesión PHP
session_start();

// Configura la localización a español
setlocale(LC_ALL, 'es_ES');

// Configura la zona horaria a Ciudad de México
date_default_timezone_set('America/Mexico_City');

// Incluye el archivo de conexión a la base de datos
include('../../../Modelo/Conexion.php');

// Obtiene la conexión a la base de datos
$conexion = (new Conectar())->conexion();

try {
    // Obtiene la fecha y hora de creación de la requisición 
    $FchCreacion = date('Y-m-d H:i:s', time());

    // Obtiene el Correo del usuario actual
    $usuario = $_SESSION['usuario'];

    // Obtiene el ID del usuario actual
    $ID_Usuario = obtenerIDUsuario($conexion, $usuario);

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

        // Inserta en la tabla RequisicionE
        insertarRequisicionE($conexion, $ID_Usuario, $FchCreacion, $Supervisor, $ID_Cuenta, $Region, $CentroTrabajo, $NroElementos, $Estado, $Receptor, $TelReceptor, $RfcReceptor, $Justificacion);

        // Obtiene el ID de la requisición insertada
        $ID_RequisionE = obtenerUltimoID($conexion);

        // Si se seleccionó "Enviar a domicilio"
        if ($Opcion == 'SI') {
            // Captura los datos de envío
            $Mpio = $_POST['Mpio'];
            $Colonia = $_POST['Colonia'];
            $Calle = $_POST['Calle'];
            $Nro = $_POST['Nro'];
            $CP = $_POST['CP'];

            // Actualiza la requisición con los datos de envío
            actualizarRequisicionE($conexion, $Mpio, $Colonia, $Calle, $Nro, $CP, $ID_RequisionE);
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
                    $idProducto = $datosTabla[$i]['idProduct'];
                    $idtall = $datosTabla[$i]['idtall'];
                    $cant = $datosTabla[$i]['cant'];

                    // Inserta en la tabla RequisicionD
                    insertarRequisicionD($conexion, $ID_RequisionE, $idProducto, $idtall, $cant);
                }
            } else {
                // Maneja el caso en el que $_POST['datosTabla'] no es un JSON válido
                echo "Los datos de la tabla no están en el formato JSON esperado.";
            }
        } else {
            // Maneja el caso en el que $_POST['datosTabla'] no está definido
            echo "No se recibieron datos de la tabla.";
        }
        
        // Notificación de inserción exitosa
        echo '<script type="text/javascript">';
        echo 'alert("¡El registro fue exitoso!");';
        echo 'window.location = "../../../Vista/ADMIN/Solicitud_ADMIN.php";';
        echo '</script>';

    }
} catch (Exception $e) {
    // Notificación de inserción incorrecta
    echo '<script type="text/javascript">';
    echo 'alert("¡Ocurrió un error durante el registro! ' . $e->getMessage() . '");';
    echo 'window.location = "../../../Vista/ADMIN/Solicitud_ADMIN.php";';
    echo '</script>';
}

// Función para obtener el ID de usuario
function obtenerIDUsuario($conexion, $usuario) {
    $consulta = $conexion->prepare("SELECT ID_Usuario FROM Usuario WHERE Correo_Electronico = ?");
    $consulta->bind_param("s", $usuario);
    $consulta->execute();
    $resultado = $consulta->get_result();
    $fila = $resultado->fetch_assoc();
    return $fila['ID_Usuario'];
}

// Función para insertar en la tabla RequisicionE
function insertarRequisicionE($conexion, $ID_Usuario, $FchCreacion, $Supervisor, $ID_Cuenta, $Region, $CentroTrabajo, $NroElementos, $Estado, $Receptor, $TelReceptor, $RfcReceptor, $Justificacion) {
    $estatus = 'Borrador'; // Define el estatus inicial 
    $consultaRequisicionE = $conexion->prepare("INSERT INTO Borrador_RequisicionE (BIdUsuario, BFchCreacion, BEstatus, BSupervisor, BIdCuenta, BIdRegion, BCentroTrabajo, BNroElementos, BIdEstado, BReceptor, BTelReceptor, BRfcReceptor, BJustificacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $consultaRequisicionE->bind_param("isssiississss", $ID_Usuario, $FchCreacion, $estatus, $Supervisor, $ID_Cuenta, $Region, $CentroTrabajo, $NroElementos, $Estado, $Receptor, $TelReceptor, $RfcReceptor, $Justificacion);
    $consultaRequisicionE->execute();
}

// Función para obtener el último ID insertado
function obtenerUltimoID($conexion) {
    return $conexion->insert_id;
}

// Función para actualizar la tabla RequisicionE con datos de envío
function actualizarRequisicionE($conexion, $Mpio, $Colonia, $Calle, $Nro, $CP, $ID_RequisionE) {
    $actualizarRequisicionE = $conexion->prepare("UPDATE Borrador_RequisicionE SET BMpio=?, BColonia=?, BCalle=?, BNro=?, BCP=? WHERE BIDRequisicionE=?");
    $actualizarRequisicionE->bind_param("sssssi", $Mpio, $Colonia, $Calle, $Nro, $CP, $ID_RequisionE);
    $actualizarRequisicionE->execute();
}

// Función para insertar en la tabla RequisicionD
function insertarRequisicionD($conexion, $ID_RequisionE, $idProducto, $idtall, $cant) {
    // Convierte $ID_RequisionE y $idProducto a enteros
    $ID_RequisionE = (int)$ID_RequisionE;
    $idProducto = (int)$idProducto;
    // Prepara la consulta
    $consultaRequisicionD = $conexion->prepare("INSERT INTO Borrador_RequisicionD (BIdReqE, BIdCProd, BIdTalla, BCantidad) VALUES (?, ?, ?, ?)");
    // Vincula los parámetros y ejecuta la consulta
    $consultaRequisicionD->bind_param("iiii", $ID_RequisionE, $idProducto, $idtall, $cant);
    $consultaRequisicionD->execute();
}
?>