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
    $sqlE = "SELECT IdEntE, Fecha_Creacion, Proveedor, Receptor, Comentarios, Estatus 
             FROM EntradaE 
             WHERE Fecha_Creacion BETWEEN ? AND ?";
    $stmtE = $conexion->prepare($sqlE);
    $stmtE->bind_param('ss', $fecha_inicio, $fecha_fin);
    $stmtE->execute();
    $resultadoE = $stmtE->get_result();

    // Consultar la base de datos para obtener la información de EntradaD
    $sqlD = "SELECT 
                ED.IdProd AS Identificador, P.Descripcion AS Descripcion, 
                P.Especificacion AS Especificacion, T.Talla AS Talla, 
                ED.Cantidad AS Cantidad, CEM.Nombre_Empresa AS Nombre_Empresa, 
                CCA.Descrp AS Categoria, DATE(EE.Fecha_Creacion) AS Fecha 
            FROM 
                EntradaD ED 
            INNER JOIN 
                Producto P ON ED.IdProd = P.IdCProducto 
            INNER JOIN 
                CTallas T ON ED.IdTalla = T.IdCTallas 
            INNER JOIN 
                EntradaE EE ON ED.IdEntradaE = EE.IdEntE 
            INNER JOIN 
                CEmpresas CEM ON P.IdCEmp = CEM.IdCEmpresa 
            INNER JOIN 
                CCategorias CCA ON P.IdCCat = CCA.IdCCate 
            WHERE 
                DATE(EE.Fecha_Creacion) BETWEEN ? AND ?";
    $stmtD = $conexion->prepare($sqlD);
    $stmtD->bind_param('ss', $fecha_inicio, $fecha_fin);
    $stmtD->execute();
    $resultadoD = $stmtD->get_result();

    // Crear un nuevo documento de Excel
    $spreadsheet = new Spreadsheet();

    // ======================
    // Hoja 1: EntradaE
    // ======================
    $spreadsheet->setActiveSheetIndex(0);
    $sheetE = $spreadsheet->getActiveSheet();
    $sheetE->setTitle('Entradas');

    // Encabezados para EntradaE
    $sheetE->setCellValue('A1', 'ID')
           ->setCellValue('B1', 'Fecha Creación')
           ->setCellValue('C1', 'Proveedor')
           ->setCellValue('D1', 'Receptor')
           ->setCellValue('E1', 'Comentarios')
           ->setCellValue('F1', 'Estatus');

    // Insertar datos de EntradaE
    $row = 2;
    while ($filaE = $resultadoE->fetch_assoc()) {
        $sheetE->setCellValue('A' . $row, $filaE['IdEntE'])
               ->setCellValue('B' . $row, $filaE['Fecha_Creacion'])
               ->setCellValue('C' . $row, $filaE['Proveedor'])
               ->setCellValue('D' . $row, $filaE['Receptor'])
               ->setCellValue('E' . $row, $filaE['Comentarios'])
               ->setCellValue('F' . $row, $filaE['Estatus']);
        $row++;
    }

    // ======================
    // Hoja 2: EntradaD
    // ======================
    $sheetD = $spreadsheet->createSheet();
    $sheetD->setTitle('EntradaD');

    // Encabezados para EntradaD
    $sheetD->setCellValue('A1', 'Identificador')
           ->setCellValue('B1', 'Empresa')
           ->setCellValue('C1', 'Descripción')
           ->setCellValue('D1', 'Especificación')
           ->setCellValue('E1', 'Talla')
           ->setCellValue('F1', 'Cantidad')
           ->setCellValue('G1', 'Fecha');

    // Insertar datos de EntradaD
    $row = 2;
    while ($filaD = $resultadoD->fetch_assoc()) {
        $sheetD->setCellValue('A' . $row, $filaD['Identificador'])
               ->setCellValue('B' . $row, $filaD['Nombre_Empresa'])
               ->setCellValue('C' . $row, $filaD['Descripcion'])
               ->setCellValue('D' . $row, $filaD['Especificacion'])
               ->setCellValue('E' . $row, $filaD['Talla'])
               ->setCellValue('F' . $row, $filaD['Cantidad'])
               ->setCellValue('G' . $row, $filaD['Fecha']);
        $row++;
    }

    // Cerrar las sentencias y la conexión a la base de datos
    $stmtE->close();
    $stmtD->close();
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