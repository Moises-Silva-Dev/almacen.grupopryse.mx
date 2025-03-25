<?php
// Iniciar la sesión
session_start();
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/Mexico_City');

// Incluir archivo de conexión a la base de datos
include("../../Modelo/Conexion.php");

// Incluir autoload de Composer para cargar TCPDF
require_once('../../librerias/TCPDF/vendor/autoload.php');  // Ajusta la ruta según la estructura de tu proyecto

// Definir clase personalizada extendiendo de TCPDF para el encabezado/pie de página
class MYPDF extends TCPDF {
    // Encabezado personalizado
    public function Header() {
        // Imagen a la izquierda
        $this->Image('../../img/pryse.png', 10, 5, 0, 10, 'PNG');
        
        // Establecer la fecha actual en la parte superior derecha
        $this->SetY(10); // Establecer la posición vertical
        $this->SetX(150); // Establecer la posición horizontal (ajusta según el tamaño de tu imagen)
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 10, date('d/m/Y'), 0, 0, 'R'); // Cambia el formato de la fecha si lo deseas
        $this->Ln(15); // Salto de línea después de la fecha
    }

    // Pie de página personalizado
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

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
    
    // Consultar la base de datos para obtener la información de Salida_D
    $sqlS = "SELECT 
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

    // Preparar y ejecutar la consulta
    $stmtD = $conexion->prepare($sqlS);
    if (!$stmtD) {
        throw new Exception("Error en la preparación de la consulta solicitud: " . $conexion->error);
    }
    $stmtD->bind_param('ss', $fecha_inicio, $fecha_fin);
    $stmtD->execute();
    $resultadoD = $stmtD->get_result();
    
    // Verificar si ambos resultados están vacíos
    if ($resultadoD->num_rows === 0) {
        // Configurar la respuesta JSON para error
        header('Content-Type: application/json');
        echo json_encode(["error " => "No hay información relacionada por esas fechas."]);
        return; // Termina la ejecución del script
    }

    // Crear un nuevo objeto PDF con orientación horizontal (Landscape)
    $pdf = new MYPDF('L', 'mm', 'LETTER');
    
    // Configuración general del PDF
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Sistema de Requisiciones');
    $pdf->SetTitle('Reporte de Requisiciones');
    $pdf->SetSubject('Reporte de Requisiciones por Fecha');
    $pdf->SetMargins(10, 20, 10);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(15);
    $pdf->SetAutoPageBreak(TRUE, 15);
    $pdf->AddPage();

    // Tipo y tamaño de letra
    $pdf->SetFont('helvetica', 'B', 14);
    // Titulo de la tabla
    $pdf->Cell(0, 10, "Reporte Requisiciones", 0, 1, "C");

    // Encabezado de la tabla
    $pdf->SetFillColor(200, 220, 255);
    $pdf->SetFont('helvetica', 'B', 8);

    // Calcular la altura de la fila más alta
    $cellHeightsEncabezado = [
        $pdf->getStringHeight(15, "ID"),
        $pdf->getStringHeight(30, "Nombre Solicitante"),
        $pdf->getStringHeight(30, "Fecha y Hora"),
        $pdf->getStringHeight(30, "Estatus"),
        $pdf->getStringHeight(30, "Cuenta"),
        $pdf->getStringHeight(30, "Supervisor"),
        $pdf->getStringHeight(30, "Centro de Trabajo"),
        $pdf->getStringHeight(30, "Receptor"),
        $pdf->getStringHeight(35, "Justificación")
    ];

    // Definir la altura máxima para la fila actual
    $maxHeightEncabezado = max($cellHeightsEncabezado);
    
    // Encabezados de la tabla usando MultiCell para cada columna
    $pdf->MultiCell(15, $maxHeightEncabezado, 'ID', 1, 'C', true, 0);
    $pdf->MultiCell(30, $maxHeightEncabezado, 'Nombre Solicitante', 1, 'C', true, 0);
    $pdf->MultiCell(30, $maxHeightEncabezado, 'Fecha y Hora', 1, 'C', true, 0);
    $pdf->MultiCell(30, $maxHeightEncabezado, 'Estatus', 1, 'C', true, 0);
    $pdf->MultiCell(30, $maxHeightEncabezado, 'Cuenta', 1, 'C', true, 0);
    $pdf->MultiCell(30, $maxHeightEncabezado, 'Supervisor', 1, 'C', true, 0);
    $pdf->MultiCell(30, $maxHeightEncabezado, 'Centro de Trabajo', 1, 'C', true, 0);
    $pdf->MultiCell(30, $maxHeightEncabezado, 'Receptor', 1, 'C', true, 0);
    $pdf->MultiCell(35, $maxHeightEncabezado, 'Justificación', 1, 'C', true, 1);

    // Contenido de la tabla
    $pdf->SetFont('helvetica', '', 12);
    while ($filaD = $resultadoD->fetch_assoc()) {
        // Calcular la altura de la fila más alta
        $cellHeights = [
            $pdf->getStringHeight(15, $filaD['IDRequisicionE']),
            $pdf->getStringHeight(30, $filaD['Nombre'] . ' ' . $filaD['Apellido_Paterno'] . ' ' . $filaD['Apellido_Materno']),
            $pdf->getStringHeight(30, $filaD['Fecha'] . ' ' . $filaD['HoraMinutos']),
            $pdf->getStringHeight(30, $filaD['Estatus']),
            $pdf->getStringHeight(30, $filaD['NombreCuenta']),
            $pdf->getStringHeight(30, $filaD['Supervisor']),
            $pdf->getStringHeight(30, $filaD['CentroTrabajo']),
            $pdf->getStringHeight(30, $filaD['Receptor']),
            $pdf->getStringHeight(35, $filaD['Justificacion'])
        ];
    
        // Definir la altura máxima para la fila actual
        $maxHeight = max($cellHeights);
    
        // Usar MultiCell para cada columna con la misma altura máxima y centrado
        $pdf->MultiCell(15, $maxHeight, $filaD['IDRequisicionE'], 1, 'C', false, 0);
        $pdf->MultiCell(30, $maxHeight, $filaD['Nombre'] . ' ' . $filaD['Apellido_Paterno'] . ' ' . $filaD['Apellido_Materno'], 1, 'C', false, 0);
        $pdf->MultiCell(30, $maxHeight, $filaD['Fecha'] . ' ' . $filaD['HoraMinutos'], 1, 'C', false, 0);
        $pdf->MultiCell(30, $maxHeight, $filaD['Estatus'], 1, 'C', false, 0);
        $pdf->MultiCell(30, $maxHeight, $filaD['NombreCuenta'], 1, 'C', false, 0);
        $pdf->MultiCell(30, $maxHeight, $filaD['Supervisor'], 1, 'C', false, 0);
        $pdf->MultiCell(30, $maxHeight, $filaD['CentroTrabajo'], 1, 'C', false, 0);
        $pdf->MultiCell(30, $maxHeight, $filaD['Receptor'], 1, 'C', false, 0);
        $pdf->MultiCell(35, $maxHeight, $filaD['Justificacion'], 1, 'C', false, 1);
    }    

    // Cerrar el statement y la conexión a la base de datos
    $stmtD->close();
    
    // Cerrar la conexión a la base de datos
    $conexion->close();

    // Generar y descargar el PDF
    $pdf->Output('Reporte_Solicitud_Por_Fechas_' . date('YmdHis') . '.pdf', 'I');
    exit;
} catch (Exception $e) {
    // Si ocurre una excepción, responder con un mensaje de error en formato JSON
    header('Content-Type: application/json');
    echo json_encode(["error" => $e->getMessage()]);
}
?>