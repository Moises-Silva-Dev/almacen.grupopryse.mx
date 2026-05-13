<?php
header('Content-Type: application/json');
session_start();
date_default_timezone_set('America/Mexico_City');

include('../../../Modelo/Conexion.php');
require_once("../../../Modelo/Funciones/Funciones_Control_Equipos.php");
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php");
require_once("../../../Modelo/Funciones/Funciones_Usuarios.php");

$conexion = (new Conectar())->conexion();

if (!$conexion || $conexion->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Error en la conexión: " . $conexion->connect_error
    ]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_SESSION["usuario"] ?? null;
    
    if (!$usuario) {
        echo json_encode([
            "success" => false,
            "message" => "Usuario no autenticado."
        ]);
        exit;
    }
    
    // Obtener datos del formulario
    $Id = $_POST['Id'] ?? null;
    $Nombre_Persona = trim($_POST['Nombre_Persona'] ?? '');
    $ID_Departamento = $_POST['ID_Departamento'] ?? null;
    $Tipo_PC = $_POST['Tipo_PC'] ?? null;
    $Marca_Equipo = $_POST['Marca_Equipo'] ?? null;
    $Modelo_Equipo = trim($_POST['Modelo_Equipo'] ?? '');
    $Numero_Serie = trim($_POST['Numero_Serie'] ?? '');
    $Sistema_Operativo = $_POST['Sistema_Operativo'] ?? null;
    $Procesador = $_POST['Procesador'] ?? null;
    $Tarjeta_Madre = $_POST['Tarjeta_Madre'] ?? null;
    $Tiene_Grafica_Dedicada = isset($_POST['Tiene_Grafica_Dedicada']) ? 1 : 0;
    $Datos_Tarjeta_Grafica = trim($_POST['Datos_Tarjeta_Grafica'] ?? '');
    $Tipo_RAM = $_POST['Tipo_RAM'] ?? null;
    $Capacidad_RAM = $_POST['Capacidad_RAM'] ?? null;
    $Marca_RAM = $_POST['Marca_RAM'] ?? null;
    $Tipo_Disco = $_POST['Tipo_Disco'] ?? null;
    $Capacidad_Disco = $_POST['Capacidad_Disco'] ?? null;
    $Teclado_Mouse = $_POST['Teclado_Mouse'] ?? null;
    $Camara_Web = $_POST['Camara_Web'] ?? 'Integrada';
    $Otro_Periferico = trim($_POST['Otro_Periferico'] ?? '');
    $Observaciones = trim($_POST['Observaciones'] ?? '');
    $Estatus = $_POST['Estatus'] ?? 'Activo';
    $Fecha_Modificacion = date('Y-m-d H:i:s');
    
    // Validar campos requeridos
    $errores = [];
    
    if (empty($Id)) $errores[] = "ID del equipo";
    if (empty($Nombre_Persona)) $errores[] = "Nombre de la persona";
    if (empty($ID_Departamento)) $errores[] = "Departamento";
    if (empty($Estatus)) $errores[] = "Estatus";
    if (empty($Tipo_PC)) $errores[] = "Tipo de PC";
    if (empty($Marca_Equipo)) $errores[] = "Marca del equipo";
    if (empty($Sistema_Operativo)) $errores[] = "Sistema Operativo";
    if (empty($Procesador)) $errores[] = "Procesador";
    if (empty($Tarjeta_Madre)) $errores[] = "Tarjeta Madre";
    if (empty($Tipo_RAM)) $errores[] = "Tipo de RAM";
    if (empty($Capacidad_RAM)) $errores[] = "Capacidad de RAM";
    if (empty($Marca_RAM)) $errores[] = "Marca de RAM";
    if (empty($Tipo_Disco)) $errores[] = "Tipo de disco";
    if (empty($Capacidad_Disco)) $errores[] = "Capacidad de disco";
    if (empty($Teclado_Mouse)) $errores[] = "Teclado/Mouse";
    
    if (!empty($errores)) {
        echo json_encode([
            "success" => false,
            "message" => "Faltan campos requeridos: " . implode(", ", $errores)
        ]);
        exit;
    }
    
    $conexion->begin_transaction();
    
    try {
        $result = ActualizarEquipo(
            $conexion,
            $Nombre_Persona,
            $ID_Departamento,
            $Tipo_PC,
            $Marca_Equipo,
            $Modelo_Equipo,
            $Numero_Serie,
            $Sistema_Operativo,
            $Procesador,
            $Tarjeta_Madre,
            $Tiene_Grafica_Dedicada,
            $Datos_Tarjeta_Grafica,
            $Tipo_RAM,
            $Capacidad_RAM,
            $Marca_RAM,
            $Tipo_Disco,
            $Capacidad_Disco,
            $Teclado_Mouse,
            $Camara_Web,
            $Otro_Periferico,
            $Observaciones,
            $Estatus,
            $Fecha_Modificacion,
            $Id,
        );
        
        if (!$result) {
            throw new Exception("Error al actualizar el equipo.");
        }
        
        $conexion->commit();
        
        $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion);
        
        $urls = [
            1 => "../../../Vista/DEV/Control_Equipos_Dev.php",
            2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php",
            3 => "../../../Vista/ADMIN/index_ADMIN.php",
            4 => "../../../Vista/USER/index_USER.php",
            5 => "../../../Vista/ALMACENISTA/Control_Equipos_ALMACENISTA.php"
        ];
        
        echo json_encode([
            "success" => true,
            "message" => "Equipo actualizado correctamente.",
            "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php"
        ]);
        
    } catch (Exception $e) {
        $conexion->rollback();
        echo json_encode([
            "success" => false,
            "message" => "Error: " . $e->getMessage()
        ]);
    } finally {
        $conexion->close();
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido."
    ]);
}
?>