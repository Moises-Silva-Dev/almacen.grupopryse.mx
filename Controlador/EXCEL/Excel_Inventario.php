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
                P.IdCProducto, 
                P.Descripcion AS Descripcion, 
                P.Especificacion AS Especificacion, 
                T.Talla AS Talla, 
                I.Cantidad AS Cantidad, 
                CE.Nombre_Empresa AS Nombre_Empresa, 
                CCA.Descrp AS Categoria 
            FROM 
                Inventario I 
            INNER JOIN 
                Producto P ON I.IdCPro = P.IdCProducto 
            INNER JOIN 
                CTallas T ON I.IdCTal = T.IdCTallas 
            INNER JOIN 
                CEmpresas CE ON P.IdCEmp = CE.IdCEmpresa 
            INNER JOIN 
                CCategorias CCA ON P.IdCCat = CCA.IdCCate 
            INNER JOIN 
                CTipoTallas ON P.IdCTipTal = CTipoTallas.IdCTipTall 
            WHERE 
                I.Cantidad > 0 
            GROUP BY 
                CE.Nombre_Empresa, P.IdCProducto, P.Descripcion, T.Talla";
    
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
    $sheetE->setCellValue('A1', 'Nombre de la Empresa')
        ->setCellValue('B1', 'Descripción')
        ->setCellValue('C1', 'Especificación')
        ->setCellValue('D1', 'Categoria')
        ->setCellValue('E1', 'Talla')
        ->setCellValue('F1', 'Cantidad');
                
    // Insertar datos de EntradaE
    $row = 2;
    while ($filaE = $resultadoE->fetch_assoc()) { // Recorrer los resultados de la consulta
        $sheetE->setCellValue('A' . $row, $filaE['Nombre_Empresa'])
            ->setCellValue('B' . $row, $filaE['Descripcion'])
            ->setCellValue('C' . $row, $filaE['Especificacion'])
            ->setCellValue('D' . $row, $filaE['Categoria'])
            ->setCellValue('E' . $row, $filaE['Talla'])
            ->setCellValue('F' . $row, $filaE['Cantidad']);
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