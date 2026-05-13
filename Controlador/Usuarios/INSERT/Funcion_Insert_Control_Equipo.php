<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
session_start(); // Iniciar sesión
setlocale(LC_ALL, 'es_ES'); // Establece el idioma de la aplicación
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México

// Incluir dependencias necesarias
include('../../../Modelo/Conexion.php'); // Conexión a la base de datos
require_once("../../../Modelo/Funciones/Funciones_Control_Equipos.php"); // Funciones para los equipos
require_once("../../../Modelo/Funciones/Funcion_TipoUsuario.php"); // Funciones para el tipo de usuario
require_once("../../../Modelo/Funciones/Funciones_Usuarios.php"); // Carga la clase de funciones de usuarios

$conexion = (new Conectar())->conexion(); // Conectar a la base de datos

// Verificar si la conexión a la base de datos fue exitosa
if (!$conexion || $conexion->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Error en la conexión: " . $conexion->connect_error
    ]);
    exit;
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Fecha_Registro = date('Y-m-d H:i:s'); // Obtiene la fecha y hora de creación                  
    $usuario = $_SESSION["usuario"] ?? null; // Recuperar el usuario de la sesión

    if (!$usuario) {
        echo json_encode([
            "success" => false,
            "message" => "Usuario no autenticado. Por favor, inicie sesión nuevamente."
        ]);
        exit;
    }

    // Obtener datos del formulario
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
    $Observaciones = trim($_POST['Observaciones_Equipo'] ?? '');
    $Estatus = $_POST['Estatus'] ?? 'Activo';

    // Validar campos requeridos
    $errores = [];
    
    if (empty($Nombre_Persona)) $errores[] = "Nombre de la persona";
    if (empty($ID_Departamento)) $errores[] = "Departamento";
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
            "message" => "Faltan los siguientes campos requeridos: " . implode(", ", $errores)
        ]);
        exit;
    }
    
    // Validar que el número de serie sea único (si se proporcionó)
    if (!empty($Numero_Serie)) {
        $stmtCheck = $conexion->prepare("SELECT Id FROM Control_Equipos WHERE Numero_Serie = ?");
        $stmtCheck->bind_param("s", $Numero_Serie);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
        
        if ($resultCheck->num_rows > 0) {
            echo json_encode([
                "success" => false,
                "message" => "El número de serie ya está registrado en el sistema."
            ]);
            $stmtCheck->close();
            exit;
        }
        $stmtCheck->close();
    }
    
    // Comenzar la transacción
    $conexion->begin_transaction();

    try {
        // Buscar el identificador del usuario
        $id_Usuario = ObtenerIdentificadorUsuario($conexion, $usuario);

        if (!$id_Usuario) {
            throw new Exception("No se encontró el identificador del usuario");
        }

        // Insertar el nuevo equipo
        $id_Equipo = InsertarNuevoEquipo(
            $conexion, 
            $Fecha_Registro, 
            $Nombre_Persona, 
            $ID_Departamento, 
            $id_Usuario, 
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
            $Estatus
        );

        if (!$id_Equipo) {
            throw new Exception("Error al insertar el equipo en la base de datos.");
        }

        $conexion->commit(); // Confirmar la transacción

        $RetornarTipoUsuario = buscarYRetornarTipoUsuario($usuario, $conexion);

        // Respuesta de éxito con la URL según tipo de usuario
        $urls = [
            1 => "../../../Vista/DEV/Control_Equipos_Dev.php",
            2 => "../../../Vista/SUPERADMIN/index_SUPERADMIN.php",
            3 => "../../../Vista/ADMIN/index_ADMIN.php",
            4 => "../../../Vista/USER/index_USER.php",
            5 => "../../../Vista/ALMACENISTA/Control_Equipos_ALMACENISTA.php"
        ];
        
        echo json_encode([
            "success" => true,
            "message" => "Equipo registrado correctamente.",
            "redirect" => $urls[$RetornarTipoUsuario] ?? "../../../index.php"
        ]);
        
    } catch (Exception $e) {
        $conexion->rollback();
        echo json_encode([
            "success" => false,
            "message" => "No se pudo realizar el registro: " . $e->getMessage()
        ]);
    } finally {
        if (isset($conexion)) $conexion->close();
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido."
    ]);
}
?>