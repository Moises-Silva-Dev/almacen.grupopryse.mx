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
    $Id_Usuario = isset($_POST['Id_Usuario']) ? $_POST['Id_Usuario'] : null;

    // Verificar que las fechas se recibieron correctamente
    if (empty($Id_Usuario)) {
        // Lanzar una excepción si la ID no se recibio correctamente
        throw new Exception("ID no recibida correctamente.");
    }

    // Consultar la base de datos para obtener la información de EntradaE
    $sqlE = "SELECT 
                C.NombreCuenta, U.Nombre, U.Apellido_Paterno, U.Apellido_Materno, RE.IDRequisicionE,
                RE.FchCreacion, RE.FchAutoriza, RE.Estatus, RE.Supervisor, R.Nombre_Region, 
                RE.CentroTrabajo, RE.NroElementos, RE.Receptor, RE.TelReceptor, RE.RfcReceptor, 
                RE.Justificacion, E.Nombre_estado, RE.Mpio, RE.Colonia, RE.Calle, RE.Nro, RE.CP
            FROM 
                RequisicionE RE
            INNER JOIN 
                Usuario U ON RE.IdUsuario = U.ID_Usuario
            INNER JOIN 
                Cuenta C ON RE.IdCuenta = C.ID
            INNER JOIN
                Regiones R ON RE.IdRegion = R.ID_Region
            INNER JOIN 
                Estados E ON RE.IdEstado = E.Id_Estado
            WHERE 
                RE.IdUsuario = ?";
    
    // Ejecutar la consulta para obtener los datos de EntradaE
    $stmtE = $conexion->prepare($sqlE);
    // vincular los parámetros
    $stmtE->bind_param('i', $Id_Usuario);
    // ejecutar la consulta
    $stmtE->execute();
    // obtener el resultado de la consulta
    $resultadoE = $stmtE->get_result();

    // Consultar la base de datos para obtener la información de EntradaD
    $sqlD = "SELECT
                RD.IdReqE, RD.IdCProd, P.Descripcion, P.Especificacion, T.Talla, 
                RD.Cantidad AS Cantidad, CEM.Nombre_Empresa AS Nombre_Empresa, 
                CCA.Descrp AS Categoria
            FROM 
                RequisicionD RD
            INNER JOIN
                RequisicionE RE ON RD.IdReqE = RE.IDRequisicionE
            INNER JOIN 
                Producto P ON RD.IdCProd = P.IdCProducto 
            INNER JOIN 
                CTallas T ON RD.IdTalla = T.IdCTallas 
            INNER JOIN 
                CEmpresas CEM ON P.IdCEmp = CEM.IdCEmpresa 
            INNER JOIN 
                CCategorias CCA ON P.IdCCat = CCA.IdCCate 
            WHERE 
                RE.IdUsuario = ?";

    // Ejecutar la consulta para obtener los datos de EntradaD
    $stmtD = $conexion->prepare($sqlD);
    // vincular los parámetros
    $stmtD->bind_param('i', $Id_Usuario);
    // ejecutar la consulta
    $stmtD->execute();
    // obtener el resultado de la consulta
    $resultadoD = $stmtD->get_result();

    // Crear un nuevo documento de Excel
    $spreadsheet = new Spreadsheet();

    // ======================
    // Hoja 1: EntradaE
    // ======================
    $spreadsheet->setActiveSheetIndex(0); // Establecer la hoja activa
    $sheetE = $spreadsheet->getActiveSheet(); // Obtener la hoja activa
    $sheetE->setTitle('Requisición_Especificación'); // Establecer el título de la hoja

    // Encabezados para EntradaE
    $sheetE->setCellValue('A1', 'Identificador')
        ->setCellValue('B1', 'Nombre Solicitante')
        ->setCellValue('C1', 'Fecha de Creación')
        ->setCellValue('D1', 'Fecha de Autorización')
        ->setCellValue('E1', 'Estatus')
        ->setCellValue('F1', 'Supervisor')
        ->setCellValue('G1', 'Cuenta')
        ->setCellValue('H1', 'Región')
        ->setCellValue('I1', 'Centro de Trabajo')
        ->setCellValue('J1', 'Número de Elementos')
        ->setCellValue('K1', 'Receptor')
        ->setCellValue('L1', 'Teléfono del Receptor')
        ->setCellValue('M1', 'RFC del Receptor')
        ->setCellValue('N1', 'Justificacion')
        ->setCellValue('O1', 'Estado')
        ->setCellValue('P1', 'Municipio')
        ->setCellValue('Q1', 'Colonia')
        ->setCellValue('R1', 'Calle')
        ->setCellValue('S1', 'Número')
        ->setCellValue('T1', 'Código Postal');

    // Insertar datos de EntradaE
    $row = 2;
    while ($filaE = $resultadoE->fetch_assoc()) { // Recorrer los resultados de la consulta
        $sheetE->setCellValue('A' . $row, $filaE['IDRequisicionE'])
            ->setCellValue('B' . $row, $filaE['Nombre'] . ' ' . $filaE['Apellido_Paterno'] . ' ' . $filaE['Apellido_Materno'])
            ->setCellValue('C' . $row, $filaE['FchCreacion'])
            ->setCellValue('D' . $row, $filaE['FchAutoriza'])
            ->setCellValue('E' . $row, $filaE['Estatus'])
            ->setCellValue('F' . $row, $filaE['Supervisor'])
            ->setCellValue('G' . $row, $filaE['NombreCuenta'])
            ->setCellValue('H' . $row, $filaE['Nombre_Region'])
            ->setCellValue('I' . $row, $filaE['CentroTrabajo'])
            ->setCellValue('J' . $row, $filaE['NroElementos'])
            ->setCellValue('K' . $row, $filaE['Receptor'])
            ->setCellValue('L' . $row, $filaE['TelReceptor'])
            ->setCellValue('M' . $row, $filaE['RfcReceptor'])
            ->setCellValue('N' . $row, $filaE['Justificacion'])
            ->setCellValue('O' . $row, $filaE['Nombre_estado'])
            ->setCellValue('P' . $row, $filaE['Mpio'])         
            ->setCellValue('Q' . $row, $filaE['Colonia'])
            ->setCellValue('R' . $row, $filaE['Calle'])
            ->setCellValue('S' . $row, $filaE['Nro'])
            ->setCellValue('T' . $row, $filaE['CP']);
        $row++; // Incrementar el contador de filas
    }

    // ======================
    // Hoja 2: EntradaD
    // ======================
    $sheetD = $spreadsheet->createSheet(); // Crear una nueva hoja
    $sheetD->setTitle('Requisición_Detalle'); // Establecer el título de la hoja

    // Encabezados para EntradaD
    $sheetD->setCellValue('A1', 'Identificador')
        ->setCellValue('B1', 'Empresa')
        ->setCellValue('C1', 'Categoría')
        ->setCellValue('D1', 'Identificador de Producto')
        ->setCellValue('E1', 'Descripción')
        ->setCellValue('F1', 'Especificación')
        ->setCellValue('G1', 'Talla')
        ->setCellValue('H1', 'Cantidad');

    // Insertar datos de EntradaD
    $row = 2;
    while ($filaD = $resultadoD->fetch_assoc()) { // Recorrer los resultados de la consulta
        $sheetD->setCellValue('A' . $row, $filaD['IdReqE'])
            ->setCellValue('B' . $row, $filaD['Nombre_Empresa'])
            ->setCellValue('C' . $row, $filaD['Categoria'])
            ->setCellValue('D' . $row, $filaD['IdCProd'])
            ->setCellValue('E' . $row, $filaD['Descripcion'])
            ->setCellValue('F' . $row, $filaD['Especificacion'])
            ->setCellValue('G' . $row, $filaD['Talla'])
            ->setCellValue('H' . $row, $filaD['Cantidad']);
        $row++; // Incrementar el contador de filas
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
    // Guardar el archivo en el flujo de salida
    $writer->save('php://output');
    exit; // Salir del script para evitar la salida adicional de datos
} catch (Exception $e) {
    // Manejar cualquier excepción que se produzca durante la creación del archivo
    echo "Error: " . $e->getMessage();
}
?>