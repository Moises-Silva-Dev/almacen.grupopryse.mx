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

    // Obtener los filtros desde el formulario
    $Nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $Estatus = isset($_POST['estatus']) ? $_POST['estatus'] : '';
    $Reclutador = isset($_POST['reclutador']) ? $_POST['reclutador'] : '';

    // Construcción de la consulta SQL con parámetros de filtro
    $sql = "SELECT 
            Nombre, AP_Paterno, AP_Materno, Estatus, Observaciones, Reclutador 
        FROM 
            Recluta 
        WHERE 1=1";

    if (!empty($Nombre)) { // Si se recibió un valor para Nombre
        // Agregar la condición de filtro por Nombre
        $sql .= " AND (Nombre LIKE '%$Nombre%' OR AP_Paterno LIKE '%$Nombre%' OR AP_Materno LIKE '%$Nombre%')";
    }
    if (!empty($Estatus)) { // Si se recibió un valor para Estatus
        // Agregar la condición de filtro por Estatus
        $sql .= " AND Estatus = '$Estatus'";
    }
    if (!empty($Reclutador)) { // Si se recibió un valor para Reclutador
        // Agregar la condición de filtro por Reclutador
        $sql .= " AND Reclutador LIKE '%$Reclutador%'";
    }

    // Ejecutar la consulta
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) { // Si hay resultados
        // Crear un nuevo archivo Excel
        $spreadsheet = new Spreadsheet();
        // Seleccionar la hoja de cálculo activa
        $sheet = $spreadsheet->getActiveSheet();

        // Agregar encabezados
        $sheet->setCellValue('A1', 'Nombre');
        $sheet->setCellValue('B1', 'Apellido Paterno');
        $sheet->setCellValue('C1', 'Apellido Materno');
        $sheet->setCellValue('D1', 'Estatus');
        $sheet->setCellValue('E1', 'Observaciones');
        $sheet->setCellValue('F1', 'Reclutador');

        // Agregar los datos de la consulta
        $rowIndex = 2; // Inicia en la fila 2
        while ($row = $result->fetch_assoc()) { // Recorrer los resultados
            $sheet->setCellValue('A' . $rowIndex, $row['Nombre']);
            $sheet->setCellValue('B' . $rowIndex, $row['AP_Paterno']);
            $sheet->setCellValue('C' . $rowIndex, $row['AP_Materno']);
            $sheet->setCellValue('D' . $rowIndex, $row['Estatus']);
            $sheet->setCellValue('E' . $rowIndex, $row['Observaciones']);
            $sheet->setCellValue('F' . $rowIndex, $row['Reclutador']);
            $rowIndex++; // Incrementar el índice de fila
        }

        // Liberar el resultado
        $result->free();
        
        // Cerrar las sentencias y la conexión a la base de datos
        $conexion->close();

        // Configurar cabeceras para la descarga del archivo
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Excel_' . date('YmdHis') . '.xlsx"');
        header('Cache-Control: max-age=0');

        // Crear el escritor y enviar el archivo al navegador para la descarga automática
        $writer = new Xlsx($spreadsheet);
        // Guardar el archivo en el flujo de salida
        $writer->save('php://output');
        exit; // Finalizar la ejecución del script
    } else {
        // Si no hay resultados
        echo "No hay resultados para exportar.";
    }
} catch (Exception $e) {
    // Manejar cualquier excepción que se produzca durante la creación del archivo
    echo "Error: " . $e->getMessage();
}
?>