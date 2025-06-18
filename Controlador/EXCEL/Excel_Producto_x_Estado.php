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

    // Consultar la base de datos para obtener la información de EntradaE
    $sqlE = "SELECT 
                E.Nombre_estado AS Estado, 
                C.NombreCuenta AS Cuenta, 
                P.Descripcion AS Producto_Descripcion, 
                P.Especificacion AS Producto_Especificacion, 
                CT.Talla AS Talla, 
                RD.Cantidad AS Cantidad, 
                DATE(RE.FchCreacion) AS Fecha 
            FROM 
                RequisicionE RE 
            JOIN 
                RequisicionD RD ON RE.IDRequisicionE = RD.IdReqE 
            JOIN 
                Cuenta C ON RE.IdCuenta = C.ID 
            JOIN 
                Estados E ON RE.IdEstado = E.Id_Estado 
            JOIN 
                Producto P ON RD.IdCProd = P.IdCProducto 
            JOIN 
                CTallas CT ON RD.IdTalla = CT.IdCTallas 
            ORDER BY 
                RE.IdEstado, C.NombreCuenta, P.Descripcion, P.Especificacion, RD.IdTalla, RD.Cantidad, RE.FchCreacion";
    
    // Ejecutar la consulta para obtener los datos de EntradaE
    $stmtE = $conexion->prepare($sqlE);
    // Asignar los parámetros a la consulta
    $stmtE->execute();
    // Obtener el resultado de la consulta
    $resultadoE = $stmtE->get_result();

    // Crear un nuevo documento de Excel
    $spreadsheet = new Spreadsheet();

    // ======================
    // Hoja 1: EntradaE
    // ======================
    $spreadsheet->setActiveSheetIndex(0); // Establecer la hoja activa
    $sheetE = $spreadsheet->getActiveSheet(); // Obtener la hoja activa
    $sheetE->setTitle('Productos Inventario'); // Establecer el título de la hoja

    // Encabezados para EntradaE
    $sheetE->setCellValue('A1', 'Estado')
        ->setCellValue('B1', 'Cuenta')
        ->setCellValue('C1', 'Descripción del Producto')
        ->setCellValue('D1', 'Especificación del Producto')
        ->setCellValue('E1', 'Talla')
        ->setCellValue('F1', 'Cantidad')
        ->setCellValue('G1', 'Fecha');
                
    // Insertar datos de EntradaE
    $row = 2;
    while ($filaE = $resultadoE->fetch_assoc()) { // Recorrer los resultados de la consulta
        $sheetE->setCellValue('A' . $row, $filaE['Estado'])
            ->setCellValue('B' . $row, $filaE['Cuenta'])
            ->setCellValue('C' . $row, $filaE['Producto_Descripcion'])
            ->setCellValue('D' . $row, $filaE['Producto_Especificacion'])
            ->setCellValue('E' . $row, $filaE['Talla'])
            ->setCellValue('F' . $row, $filaE['Cantidad'])
            ->setCellValue('G' . $row, $filaE['Fecha']);
        $row++; // Incrementar el número de fila
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
    // Guardar el archivo en la salida de la aplicación
    $writer->save('php://output');
    exit; // Salir del script
} catch (Exception $e) {
    // Manejar cualquier excepción que se produzca durante la ejecución del script
    echo "Error: " . $e->getMessage();
}
?>