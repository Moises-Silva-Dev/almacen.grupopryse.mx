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

    // Obtener filtros
    $Nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $Estatus = isset($_POST['estatus']) ? $_POST['estatus'] : '';
    $Reclutador = isset($_POST['reclutador']) ? $_POST['reclutador'] : '';

    // Construcción de consulta segura con prepared statements
    $sql = "SELECT Nombre, AP_Paterno, AP_Materno, Estatus, Observaciones, Reclutador FROM Recluta WHERE 1=1";
    $params = [];
    $types = "";

    if (!empty($Nombre)) {
        $sql .= " AND (Nombre LIKE ? OR AP_Paterno LIKE ? OR AP_Materno LIKE ?)";
        $params[] = "%$Nombre%"; $params[] = "%$Nombre%"; $params[] = "%$Nombre%";
        $types .= "sss";
    }
    if (!empty($Estatus)) {
        $sql .= " AND Estatus = ?";
        $params[] = $Estatus;
        $types .= "s";
    }
    if (!empty($Reclutador)) {
        $sql .= " AND Reclutador LIKE ?";
        $params[] = "%$Reclutador%";
        $types .= "s";
    }

    // Preparar y ejecutar consulta
    $stmt = $conexion->prepare($sql);
    if ($types) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verificar si ambos resultados están vacíos
    if ($result->num_rows === 0) {
        // Configurar la respuesta JSON para error
        header('Content-Type: application/json');
        echo json_encode(["error " => "No hay información relacionada."]);
        return; // Termina la ejecución del script
    }

    // Crear un nuevo objeto PDF con orientación horizontal (Landscape)
    $pdf = new MYPDF('L', 'mm', 'LETTER');
    
    // Configuración general del PDF
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Sistema de Requisiciones');
    $pdf->SetTitle('Reporte de Requisiciones');
    $pdf->SetSubject('Reporte Filtrar Reclutas');
    $pdf->SetMargins(10, 20, 10);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(15);
    $pdf->SetAutoPageBreak(TRUE, 15);
    $pdf->AddPage();

    // Tipo y tamaño de letra
    $pdf->SetFont('helvetica', 'B', 14);
    // Titulo de la tabla
    $pdf->Cell(0, 10, "Reporte Filtro Reclutas", 0, 1, "C");

    // Encabezado de la tabla
    $pdf->SetFillColor(200, 220, 255);
    $pdf->SetFont('helvetica', 'B', 9);

    // Calcular la altura de la fila más alta
    $cellHeightsEncabezado = [
        $pdf->getStringHeight(45, "Nombre"),
        $pdf->getStringHeight(45, "AP_Paterno"),
        $pdf->getStringHeight(45, "AP_Materno"),
        $pdf->getStringHeight(30, "Estatus"),
        $pdf->getStringHeight(50, "Observaciones"),
        $pdf->getStringHeight(40, "Reclutador")
    ];

    // Definir la altura máxima para la fila actual
    $maxHeightEncabezado = max($cellHeightsEncabezado);
    
    // Encabezados de la tabla usando MultiCell para cada columna
    $pdf->MultiCell(45, $maxHeightEncabezado, 'Nombre', 1, 'C', true, 0);
    $pdf->MultiCell(45, $maxHeightEncabezado, 'Apellido Paterno', 1, 'C', true, 0);
    $pdf->MultiCell(45, $maxHeightEncabezado, 'Apellido Materno', 1, 'C', true, 0);
    $pdf->MultiCell(30, $maxHeightEncabezado, 'Estatus', 1, 'C', true, 0);
    $pdf->MultiCell(50, $maxHeightEncabezado, 'Observaciones', 1, 'C', true, 0);
    $pdf->MultiCell(40, $maxHeightEncabezado, 'Reclutador', 1, 'C', true, 1);

    // Contenido de la tabla
    $pdf->SetFont('helvetica', '', 12);
    while ($row = $result->fetch_assoc()) {
        // Calcular la altura de la fila más alta
        $cellHeights = [
            $pdf->getStringHeight(45, $row['Nombre']),
            $pdf->getStringHeight(45, $row['AP_Paterno']),
            $pdf->getStringHeight(45, $row['AP_Materno']),
            $pdf->getStringHeight(30, $row['Estatus']),
            $pdf->getStringHeight(50, $row['Observaciones']),
            $pdf->getStringHeight(40, $row['Reclutador'])
        ];
    
        // Definir la altura máxima para la fila actual
        $maxHeight = max($cellHeights);
    
        // Usar MultiCell para cada columna con la misma altura máxima y centrado
        $pdf->MultiCell(45, $maxHeight, $row['Nombre'], 1, 'C', false, 0);
        $pdf->MultiCell(45, $maxHeight, $row['AP_Paterno'], 1, 'C', false, 0);
        $pdf->MultiCell(45, $maxHeight, $row['AP_Materno'], 1, 'C', false, 0);
        $pdf->MultiCell(30, $maxHeight, $row['Estatus'], 1, 'C', false, 0);
        $pdf->MultiCell(50, $maxHeight, $row['Observaciones'], 1, 'C', false, 0);
        $pdf->MultiCell(40, $maxHeight, $row['Reclutador'], 1, 'C', false, 1);
    }    

    // Liberar el resultado
    $result->free();
    
    // Cerrar la conexión a la base de datos
    $conexion->close();

    // Generar y descargar el PDF
    $pdf->Output('Reporte_Filtrar_Reclutas_' . date('YmdHis') . '.pdf', 'I');
    exit;
} catch (Exception $e) {
    // Si ocurre una excepción, responder con un mensaje de error en formato JSON
    header('Content-Type: application/json');
    echo json_encode(["error" => $e->getMessage()]);
}
?>