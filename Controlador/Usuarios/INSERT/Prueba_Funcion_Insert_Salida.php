<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México

// Incluir dependencias necesarias
include('../../../Modelo/Conexion.php');
require_once("../../../Modelo/Funciones/Funciones_Borrador_RequisicionD.php");
require_once("../../../Modelo/Funciones/Funciones_Borrador_RequisicionE.php");
require_once("../../../Modelo/Funciones/Funciones_Inventario.php");
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php");
require_once("../../../Modelo/Funciones/Funciones_SalidaE.php");
require_once("../../../Modelo/Funciones/Funciones_SalidaD.php");
require_once("../../../Modelo/Funciones/Funciones_RequisicionD.php");
require_once("../../../Modelo/Funciones/Funciones_RequisicionE.php");
require_once("../../../Modelo/Funciones/Funciones_Usuarios.php");

$conexion = (new Conectar())->conexion(); // Conectar a la base de datos

// Procesar solicitudes POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validar sesión de usuario
    if (!isset($_SESSION['usuario'])) {
        echo json_encode([
            "success" => false,
            "message" => "Sesión no iniciada. Por favor, inicie sesión nuevamente."
        ]);
        exit;
    }

    $usuario = $_SESSION['usuario'];            
    $ID_Requisicion = $_POST['ID_RequisicionE'] ?? null;
    $fecha_salida = date('Y-m-d H:i:s');

    if (!$ID_Requisicion || !is_numeric($ID_Requisicion)) { // Validar ID de requisición
        echo json_encode([
            "success" => false,
            "message" => "ID de requisición inválido o no proporcionado."
        ]);
        exit;
    }

    // Iniciar transacción
    $conexion->begin_transaction();

    try {
        // Obtener el ID del usuario
        $ID_Usuario = ObtenerIdentificadorUsuario($conexion, $usuario);
        if (!$ID_Usuario) {
            throw new Exception("Error al obtener el identificador del usuario.");
        }

        // Insertar en la tabla Salida_E
        $ID_SalidaE = InsertarNuevaSalidaE($conexion, $ID_Requisicion, $ID_Usuario, $fecha_salida);
        if (!$ID_SalidaE) {
            throw new Exception("Error al insertar en la tabla Salida_E.");
        }

        // Validar y procesar datos de la tabla
        if (isset($_POST['datosTablaInsertSalida'])) {
            $datosTabla = json_decode($_POST['datosTablaInsertSalida'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Los datos de la tabla no están en el formato JSON esperado.");
            }

            foreach ($datosTabla as $fila) {
                $IdCProd = $fila['IdCProd'] ?? null;
                $Id_Talla = $fila['Id_Talla'] ?? null;
                $Cant = isset($fila['Cant']) && is_numeric($fila['Cant']) ? (int)$fila['Cant'] : 0;

                if (!$IdCProd || !$Id_Talla || $Cant <= 0) {
                    continue; // Ignorar filas inválidas
                }

                // Insertar en Salida_D
                if (!InsertarNuevaSalidaD($conexion, $ID_SalidaE, $IdCProd, $Id_Talla, $Cant)) {
                    throw new Exception("Error al insertar en la tabla Salida_D.");
                }

                // Actualizar inventario
                if (!ActualizarInventarioPorSalidaRequisicion($conexion, $Cant, $IdCProd, $Id_Talla)) {
                    throw new Exception("Error al actualizar el inventario.");
                }
            }
        } else {
            throw new Exception("No se recibieron datos de la tabla.");
        }

        // Actualizar estatus de la requisición
        if (!ActualizarEstatusRequisionESalida($conexion, $ID_Requisicion)) {
            throw new Exception("Error al actualizar el estatus de la requisición.");
        }

        // Procesar productos pendientes
        $requisicionesD = RequisicionDProductosPendientes($conexion, $ID_Requisicion);
        if ($requisicionesD) {
            $InformacionRequisicionE = SeleccionarInformacionRequisicionE($conexion, $ID_Requisicion);
            if (!$InformacionRequisicionE) {
                throw new Exception("Error al obtener la información de la requisición.");
            }

            $ID_RequisionEProductos = InsertarBorradorRequisicionEProductosPendientes($conexion, $fecha_salida, $InformacionRequisicionE);
            if (!$ID_RequisionEProductos) {
                throw new Exception("Error al insertar en la tabla borrador_requisicionE.");
            }

            if (!InsertarBorradorRequisicionDProductosPendientes($conexion, $ID_RequisionEProductos, $requisicionesD)) {
                throw new Exception("Error al insertar en la tabla borrador_requisicionD.");
            }
        }

        // Confirmar transacción
        $conexion->commit();

        // Determinar la URL de redirección según el tipo de usuario
        $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion);
        $urls = [
            1 => "../../../Vista/DEV/Salidas_Dev.php",
            2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php",
            3 => "../../../Vista/ADMIN/index_ADMIN.php",
            4 => "../../../Vista/USER/index_USER.php",
            5 => "../../../Vista/ALMACENISTA/Salidas_ALMACENISTA.php"
        ];

        echo json_encode([
            "success" => true,
            "message" => "Se ha guardado correctamente.",
            "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php"
        ]);
    } catch (Exception $e) {
        $conexion->rollback(); // Revertir transacción en caso de error
        echo json_encode([
            "success" => false,
            "message" => "Error al realizar el registro: " . htmlspecialchars($e->getMessage())
        ]);
    } finally {
        $conexion->close(); // Cerrar conexión
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Solicitud inválida."
    ]);
}
?>