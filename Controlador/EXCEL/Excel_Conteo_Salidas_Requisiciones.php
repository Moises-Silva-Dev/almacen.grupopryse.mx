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
        // Lanzar una excepción si las fechas no se recibieron correctamente
        throw new Exception("Fechas no recibidas correctamente.");
    }

    // Convertir las fechas al formato esperado por MySQL (YYYY-MM-DD)
    $fecha_inicio = date("Y-m-d", strtotime($fecha_inicio));
    $fecha_fin = date("Y-m-d", strtotime($fecha_fin));

    // Consultar la base de datos para obtener la información de EntradaE
    $sqlE = "SELECT 
                T1.IDRequisicionE AS Identificador_Requisicion, T1.FchCreacion AS Fecha_Creacion,
                CONCAT(T2.Nombre, ' ', T2.Apellido_Paterno) AS Usuario, 
                T3.NombreCuenta AS Cuenta, T4.Nombre_Region AS Region,
                T5.Nombre_estado AS Estado, T6.IdCProd AS Identificador_Producto,
                T7.Descripcion, T7.Especificacion, 
                SUM(T6.Cantidad) AS Cantidad_Requerida,
                COALESCE(
                    (SELECT 
                        SUM(Ta.Cantidad) 
                    FROM 
                        Salida_D Ta 
                    WHERE 
                        Ta.Id IN (
                            SELECT 
                                Tb.Id_SalE 
                            FROM 
                                Salida_E Tb 
                            WHERE 
                                Tb.ID_ReqE = T1.IDRequisicionE
                        ) 
                    AND 
                        Ta.IdCProd = T6.IdCProd), 0
                ) AS Cantidad_Salida
            FROM 
                RequisicionE T1
            INNER JOIN Usuario T2 
                ON T2.ID_Usuario = T1.IdUsuario 
            INNER JOIN Cuenta T3 
                ON T3.ID = T1.IdCuenta 
            INNER JOIN Regiones T4 
                ON T4.ID_Region = T1.IdRegion 
            INNER JOIN Estados T5 
                ON T5.Id_Estado = T1.IdEstado 
            INNER JOIN RequisicionD T6 
                ON T6.IdReqE = T1.IDRequisicionE 
            INNER JOIN Producto T7 
                ON T7.IdCProducto = T6.IdCProd 
            WHERE 
                DATE(T1.FchCreacion) BETWEEN ? AND ?
            GROUP BY 
                T1.IDRequisicionE, T1.FchCreacion,
                CONCAT(T2.Nombre, ' ', T2.Apellido_Paterno), 
                T3.NombreCuenta, T4.Nombre_Region,
                T5.Nombre_estado, T6.IdCProd,
                T7.Descripcion, T7.Especificacion;";
                
    // Ejecutar la consulta para obtener los datos de EntradaE
    $stmtE = $conexion->prepare($sqlE);
    // Vincular los parámetros
    $stmtE->bind_param('ss', $fecha_inicio, $fecha_fin);
    // Ejecutar la consulta
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
    $sheetE->setTitle('Salidas'); // Establecer el título de la hoja

    // Encabezados para EntradaE
    $sheetE->setCellValue('A1', 'Identificador')
        ->setCellValue('B1', 'Fecha de Creación')
        ->setCellValue('C1', 'Usuario')
        ->setCellValue('D1', 'Cuenta')
        ->setCellValue('E1', 'Región')
        ->setCellValue('F1', 'Estado')
        ->setCellValue('G1', 'Identificador de Prodcuto')
        ->setCellValue('H1', 'Descripción')
        ->setCellValue('I1', 'Especificación')
        ->setCellValue('J1', 'Cantidad Pedida')
        ->setCellValue('K1', 'Cantidad Salida');

    // Insertar datos de EntradaE
    $row = 2;
    while ($filaE = $resultadoE->fetch_assoc()) { // Recorrer los resultados de la consulta
        $sheetE->setCellValue('A' . $row, $filaE['Identificador_Requisicion'])
            ->setCellValue('B' . $row, $filaE['Fecha_Creacion'])
            ->setCellValue('C' . $row, $filaE['Usuario'])
            ->setCellValue('D' . $row, $filaE['Cuenta'])
            ->setCellValue('E' . $row, $filaE['Region'])
            ->setCellValue('F' . $row, $filaE['Estado'])
            ->setCellValue('G' . $row, $filaE['Identificador_Producto'])
            ->setCellValue('H' . $row, $filaE['Descripcion'])
            ->setCellValue('I' . $row, $filaE['Especificacion'])
            ->setCellValue('J' . $row, $filaE['Cantidad_Requerida'])
            ->setCellValue('K' . $row, $filaE['Cantidad_Salida']);
        $row++; // Incrementar el contador de filas
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
    // Guardar el archivo en la salida de PHP (salida al navegador)
    $writer->save('php://output');
    exit; // Finalizar el script
} catch (Exception $e) {
    // Mostrar un mensaje de error si algo falla
    echo "Error: " . $e->getMessage();
}
?>