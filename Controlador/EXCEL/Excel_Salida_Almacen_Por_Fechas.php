<?php
// Iniciar la sesión PHP
session_start();

// Configurar la localización a español
setlocale(LC_ALL, 'es_ES');

// Configurar la zona horaria a Ciudad de México
date_default_timezone_set('America/Mexico_City');

// Incluir archivo de conexión a la base de datos y cargar la librería PhpSpreadsheet
include("../../Modelo/Conexion.php");
require_once '../../librerias/PhpSpreadsheet/vendor/autoload.php';

// Importar las clases de PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

try {
    // Obtener la instancia de conexión a la base de datos
    $conexion = (new Conectar())->conexion();

    // Obtener las fechas enviadas por el formulario
    $fecha_inicio = isset($_POST['Fecha_Inicio']) ? $_POST['Fecha_Inicio'] : null;
    $fecha_fin = isset($_POST['Fecha_Fin']) ? $_POST['Fecha_Fin'] : null;

    // Verificar que las fechas se recibieron correctamente
    if (empty($fecha_inicio) || empty($fecha_fin)) {
        throw new Exception("Fechas no recibidas correctamente.");
    }

    // Convertir las fechas al formato esperado por MySQL (YYYY-MM-DD)
    $fecha_inicio = date("Y-m-d", strtotime($fecha_inicio));
    $fecha_fin = date("Y-m-d", strtotime($fecha_fin));

    // Consultar la base de datos para obtener la información de EntradaE
    $sqlE = "SELECT 
                SE.Id_SalE, 
                DATE(SE.FchSalidad) AS FchSalida, 
                SE.ID_ReqE, 
                U.Nombre AS NombreUsuarioSolicitante, 
                U.Apellido_Paterno AS ApellidoPaternoUsuarioSolicitante, 
                U.Apellido_Materno AS ApellidoMaternoUsuarioSolicitante, 
                C.NombreCuenta, 
                DATE(RE.FchCreacion) AS FchCreacion, 
                RE.Estatus AS Estado,
                U2.Nombre AS NombreUsuarioSalida,
                U2.Apellido_Paterno AS ApellidoPaternoUsuarioSalida,
                U2.Apellido_Materno AS ApellidoMaternoUsuarioSalida
            FROM 
                Salida_D SD 
            INNER JOIN 
                Salida_E SE ON SE.Id_SalE = SD.Id 
            INNER JOIN 
                RequisicionE RE ON RE.IDRequisicionE = SE.ID_ReqE 
            INNER JOIN 
                Usuario U ON RE.IdUsuario = U.ID_Usuario
            INNER JOIN 
                Cuenta C ON RE.IdCuenta = C.ID 
            INNER JOIN 
                Usuario U2 ON U2.ID_Usuario = SE.ID_Usuario_Salida
            WHERE 
                DATE(SE.FchSalidad) BETWEEN ? AND ? 
            GROUP BY 
                SE.Id_SalE";
                
    $stmtE = $conexion->prepare($sqlE);
    $stmtE->bind_param('ss', $fecha_inicio, $fecha_fin);
    $stmtE->execute();
    $resultadoE = $stmtE->get_result();

    // Crear un nuevo documento de Excel
    $spreadsheet = new Spreadsheet();

    // ======================
    // Hoja 1: EntradaE
    // ======================
    $spreadsheet->setActiveSheetIndex(0);
    $sheetE = $spreadsheet->getActiveSheet();
    $sheetE->setTitle('Salidas');

    // Encabezados para EntradaE
    $sheetE->setCellValue('A1', 'Identificador')
           ->setCellValue('B1', 'Fecha de Salida')
           ->setCellValue('C1', 'IdReqE')
           ->setCellValue('D1', 'Estatus')
           ->setCellValue('E1', 'Nombre del Solicitante')
           ->setCellValue('F1', 'Cuenta')
           ->setCellValue('G1', 'Fecha de Solicitud')
           ->setCellValue('H1', 'Entrego');

    // Insertar datos de EntradaE
    $row = 2;
    while ($filaE = $resultadoE->fetch_assoc()) {
        $sheetE->setCellValue('A' . $row, $filaE['Id_SalE'])
               ->setCellValue('B' . $row, $filaE['FchSalida'])
               ->setCellValue('C' . $row, $filaE['ID_ReqE'])
               ->setCellValue('D' . $row, $filaE['Estado'])
               ->setCellValue('E' . $row, $filaE['NombreUsuarioSolicitante'] . ' ' . $filaE['ApellidoPaternoUsuarioSolicitante'] . ' ' . $filaE['ApellidoMaternoUsuarioSolicitante'])
               ->setCellValue('F' . $row, $filaE['NombreCuenta'])
               ->setCellValue('G' . $row, $filaE['FchCreacion'])
               ->setCellValue('H' . $row, $filaE['NombreUsuarioSalida'] . ' ' . $filaE['ApellidoPaternoUsuarioSalida'] . ' ' . $filaE['ApellidoMaternoUsuarioSalida']);
        $row++;
    }

    // Cerrar las sentencias y la conexión a la base de datos
    $stmtE->close();
    $conexion->close();

    // Configurar cabeceras para la descarga del archivo
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Excel_' . date('YmdHis') . '.xlsx"');
    header('Cache-Control: max-age=0');

    // Crear el escritor y enviar el archivo al navegador para la descarga automática
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>