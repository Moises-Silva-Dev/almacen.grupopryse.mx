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
                C.NombreCuenta, U.Nombre, U.Apellido_Paterno, U.Apellido_Materno, RE.IDRequisicionE,
                DATE_FORMAT(RE.FchCreacion, '%Y-%m-%d') AS Fecha,
                DATE_FORMAT(RE.FchCreacion, '%H:%i') AS HoraMinutos, RE.Estatus, 
                RE.Supervisor, RE.CentroTrabajo, RE.Receptor, RE.Justificacion
            FROM 
                RequisicionD RD
            INNER JOIN 
                RequisicionE RE ON RD.IdReqE = RE.IDRequisicionE
            INNER JOIN 
                Usuario U ON RE.IdUsuario = U.ID_Usuario
            INNER JOIN 
                Cuenta C ON RE.IdCuenta = C.ID
            WHERE 
                DATE(RE.FchCreacion) BETWEEN ? AND ?
            GROUP BY
                RE.IDRequisicionE";
                
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
    $sheetE->setTitle('Solicitud');

    // Encabezados para EntradaE
    $sheetE->setCellValue('A1', 'Identificador')
           ->setCellValue('B1', 'Nombre Solicitante')
           ->setCellValue('C1', 'Fecha y Hora')
           ->setCellValue('D1', 'Estatus')
           ->setCellValue('E1', 'Cuenta')
           ->setCellValue('F1', 'Supervisor')
           ->setCellValue('G1', 'Centro de Trabajo')
           ->setCellValue('H1', 'Receptor')
           ->setCellValue('I1', 'Justificacion');

    // Insertar datos de EntradaE
    $row = 2;
    while ($filaE = $resultadoE->fetch_assoc()) {
        $sheetE->setCellValue('A' . $row, $filaE['IDRequisicionE'])
               ->setCellValue('B' . $row, $filaE['Nombre'] . ' ' . $filaE['Apellido_Paterno'] . ' ' . $filaE['Apellido_Materno'])
               ->setCellValue('C' . $row, $filaE['Fecha'] . ' ' . $filaE['HoraMinutos'])
               ->setCellValue('D' . $row, $filaE['Estatus'])
               ->setCellValue('E' . $row, $filaE['NombreCuenta'])
               ->setCellValue('F' . $row, $filaE['Supervisor'])
               ->setCellValue('G' . $row, $filaE['CentroTrabajo'])
               ->setCellValue('H' . $row, $filaE['Receptor'])
               ->setCellValue('I' . $row, $filaE['Justificacion']);
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