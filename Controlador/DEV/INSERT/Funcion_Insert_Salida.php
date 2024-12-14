<?php
// Inicia sesión PHP
session_start();
// Configura la localización a español
setlocale(LC_ALL, 'es_ES');
// Configura la zona horaria a Ciudad de México
date_default_timezone_set('America/Mexico_City');

// Incluye el archivo de conexión a la base de datos
include('../../../Modelo/Conexion.php'); 
// Establece una conexión a la base de datos
$conexion = (new Conectar())->conexion();

// Procesamiento del formulario cuando se recibe una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si se recibieron los datos esperados
    if (!isset($_POST['ID_RequisicionE']) || !isset($_POST['datosTabla'])) {
        // Muestra una notificación de error y redirige
        echo '<script type="text/javascript">';
        echo 'alert("Ha ocurrido un error al procesar el formulario.");';
        echo 'window.location = "../../../Vista/DEV/INSERT/Insert_Salida_Dev.php";'; // Reemplaza con la ruta de redirección deseada
        echo '</script>';
        exit();
    }

    try {
        // Inicia una transacción
        $conexion->begin_transaction();

        // Obtiene los datos del formulario
        $usuario = $_SESSION['usuario'];
        $ID_Usuario = obtenerIDUsuario($conexion, $usuario);
        
        $id_requisicion = $_POST['ID_RequisicionE'];
        $datosTabla = json_decode($_POST['datosTabla'], true);
        $fecha_salida = date('Y-m-d H:i:s');

        // Inserta el registro de salida en la tabla Salida_E
        $idSalidaE = insertarSalidaE($conexion, $id_requisicion, $ID_Usuario, $fecha_salida);

        // Inserta cada fila de datos en la tabla Salida_D y actualiza el inventario
        $numFilas = count($datosTabla);
        for ($i = 0; $i < $numFilas; $i++) {
            $IdCProd = $datosTabla[$i]['IdCProd'];
            $Id_Talla = $datosTabla[$i]['Id_Talla'];
            $Cant = $datosTabla[$i]['Cant'];

            insertarSalidaD($conexion, $idSalidaE, $IdCProd, $Id_Talla, $Cant);
            actualizarInventario($conexion, $Cant, $IdCProd, $Id_Talla);
        }
        
        //Actualizar Estatus
        UpdateEstatus($conexion, $id_requisicion);

        // Confirma la transacción
        $conexion->commit();

        // Redirige a una página de éxito o muestra un mensaje de éxito
        echo '<script type="text/javascript">';
        echo 'alert("¡El registro fue exitoso!");';
        echo 'window.location = "../../../Vista/DEV/Salidas_Dev.php";'; // Reemplaza con la ruta de redirección deseada
        echo '</script>';
        exit();
    } catch (Exception $e) {
        // Revierte la transacción en caso de error
        $conexion->rollback();
        // Muestra un mensaje de error y redirige
        echo '<script type="text/javascript">';
        echo 'alert("Ha ocurrido un error al procesar el formulario. Por favor, inténtelo de nuevo.");';
        echo 'window.location = "../../../Vista/DEV/INSERT/Insert_Salida_Dev.php";'; // Reemplaza con la ruta de redirección deseada
        echo '</script>';
        exit();
    }
} else {
    // Si no es una solicitud POST, muestra un mensaje de error y redirige
    echo '<script type="text/javascript">';
    echo 'alert("Método de solicitud no permitido.");';
    echo 'window.location = "../../../Vista/DEV/INSERT/Insert_Salida_Dev.php";'; // Reemplaza con la ruta de redirección deseada
    echo '</script>';
    exit();
}

// Función para obtener el ID del usuario a partir del correo electrónico
function obtenerIDUsuario($conexion, $usuario) {
    $consulta = $conexion->prepare("SELECT ID_Usuario FROM Usuario WHERE Correo_Electronico = ?;");
    $consulta->bind_param("s", $usuario);
    $consulta->execute();
    $resultado = $consulta->get_result();
    $fila = $resultado->fetch_assoc();
    return $fila['ID_Usuario'];
}

// Función para insertar el registro de salida en la tabla Salida_E
function insertarSalidaE($conexion, $id_requisicion, $ID_Usuario, $fecha_salida) {
    $sqlSalidaE = $conexion->prepare("INSERT INTO Salida_E (ID_ReqE, ID_Usuario_Salida, FchSalidad) VALUES (?, ?, ?);");
    $sqlSalidaE->bind_param("iis", $id_requisicion, $ID_Usuario, $fecha_salida);
    $sqlSalidaE->execute();
    $idSalidaE = $sqlSalidaE->insert_id;
    $sqlSalidaE->close();
    return $idSalidaE;
}

// Función para insertar un registro de detalle de salida en la tabla Salida_D
function insertarSalidaD($conexion, $idSalidaE, $IdCProd, $Id_Talla, $Cant) {
    $sqlSalidaD = $conexion->prepare("INSERT INTO Salida_D (Id, IdCProd, IdTallas, Cantidad) VALUES (?, ?, ?, ?);");
    $sqlSalidaD->bind_param("iiii", $idSalidaE, $IdCProd, $Id_Talla, $Cant);
    $sqlSalidaD->execute();
    $sqlSalidaD->close();
}

// Función para actualizar el inventario
function actualizarInventario($conexion, $Cant, $IdCProd, $Id_Talla) {
    $sqlActualizarInventario = $conexion->prepare("UPDATE Inventario SET Cantidad = Cantidad - ? WHERE IdCPro = ? AND IdCTal = ?; ");
    $sqlActualizarInventario->bind_param("iii", $Cant, $IdCProd, $Id_Talla);
    $sqlActualizarInventario->execute();
    $sqlActualizarInventario->close();
}

//Función para actualizar el estatus de salida
function UpdateEstatus($conexion, $id_requisicion){
    $SQLBuscarEstatus = $conexion->prepare("SELECT 
        	CASE 
        		WHEN SD1.Cantidad = 0 THEN 'Pendiente'
        		WHEN SD1.Cantidad < SUM(RD.Cantidad) THEN 'Parcial'
        		ELSE 'Surtido' END AS Estado
            FROM 
                RequisicionD RD
            INNER JOIN 
            	(SELECT 
            	    SE.ID_ReqE, SUM(SD.Cantidad) Cantidad
                 FROM 
                    Salida_E SE
                 INNER JOIN 
            	 	Salida_D SD ON SE.Id_SalE = SD.Id
            	 WHERE 
            	    SE.ID_ReqE = ?) SD1 ON RD.IdReqE = SD1.ID_ReqE
            WHERE 
                RD.IdReqE = ?;");
            
    $SQLBuscarEstatus->bind_param("ii", $id_requisicion, $id_requisicion);
    $SQLBuscarEstatus->execute();
    $result = $SQLBuscarEstatus->get_result();
    $row = $result->fetch_assoc();
    $estado = $row['Estado'];

    $SQLActualizarEstatus = $conexion->prepare("
        UPDATE RequisicionE SET Estatus = ? WHERE IDRequisicionE = ?
    ");
    $SQLActualizarEstatus->bind_param("si", $estado, $id_requisicion);
    $SQLActualizarEstatus->execute();
    $SQLActualizarEstatus->close();
    $SQLBuscarEstatus->close();
}
?>