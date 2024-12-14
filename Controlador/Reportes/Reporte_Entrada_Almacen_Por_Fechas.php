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

    // Consultar la base de datos para obtener la información de EntradaE
    $sqlE = "SELECT 
                IdEntE, Fecha_Creacion, Proveedor, Receptor, Comentarios, Estatus 
             FROM 
                EntradaE 
             WHERE 
                DATE(Fecha_Creacion) BETWEEN ? AND ?";

    // Preparar y ejecutar la consulta para EntradaE
    $stmtE = $conexion->prepare($sqlE);
    if (!$stmtE) {
        throw new Exception("Error en la preparación de la consulta EntradaE: " . $conexion->error);
    }
    $stmtE->bind_param('ss', $fecha_inicio, $fecha_fin);
    $stmtE->execute();
    $resultadoE = $stmtE->get_result();
    
    // Verificar si ambos resultados están vacíos
    if ($resultadoE->num_rows === 0) {
        // Configurar la respuesta JSON para error
        header('Content-Type: application/json');
        echo json_encode(["error" => "No hay información relacionada por esas fechas."]);
        return; // Termina la ejecución del script
    }

    // Crear un nuevo objeto PDF con orientación horizontal (Landscape)
    $pdf = new MYPDF('L', 'mm', 'LETTER');
    
    // Configuración general del PDF
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Sistema de Requisiciones');
    $pdf->SetTitle('Reporte de Solicitudes');
    $pdf->SetSubject('Reporte de Solicitudes por Fecha');
    $pdf->SetMargins(10, 20, 10);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(15);
    $pdf->SetAutoPageBreak(TRUE, 15);
    $pdf->AddPage();
    
    // Tipo y tamaño de letra
    $pdf->SetFont('helvetica', 'B', 14);
    // Titulo de la tabla
    $pdf->Cell(0, 10, "Reporte Entradas", 0, 1, "C");
    
    // Estilo de la tabla EntradaE
    $pdf->SetFillColor(200, 220, 255); // Color de fondo de las celdas
    $pdf->SetFont("helvetica", "B", 9);
    
    // Cabecera de la tabla EntradaE
    $pdf->MultiCell(25, 7, "Identificador", 1, 'C', true, 0);
    $pdf->MultiCell(40, 7, "Fecha Creación", 1, 'C', true, 0);
    $pdf->MultiCell(40, 7, "Proveedor", 1, 'C', true, 0);
    $pdf->MultiCell(40, 7, "Receptor", 1, 'C', true, 0);
    $pdf->MultiCell(40, 7, "Comentarios", 1, 'C', true, 0);
    $pdf->MultiCell(30, 7, "Estatus", 1, 'C', true, 1);

    // Agregar datos a la tabla EntradaE
    $pdf->SetFont("helvetica", "", 12); // Restaurar el estilo de fuente normal
    while ($filaE = $resultadoE->fetch_assoc()) {
        // Calcular la altura de la fila más alta
        $cellHeights = [
            $pdf->getStringHeight(40, $filaE['Fecha_Creacion']),
            $pdf->getStringHeight(40, $filaE['Proveedor']),
            $pdf->getStringHeight(40, $filaE['Receptor']),
            $pdf->getStringHeight(40, $filaE['Comentarios']),
            $pdf->getStringHeight(30, $filaE['Estatus'])
        ];
        
        // Definir la altura máxima para la fila actual
        $maxHeight = max($cellHeights);
    
        // Usar MultiCell para cada columna con la misma altura máxima y centrado
        $pdf->MultiCell(25, $maxHeight, $filaE['IdEntE'], 1, 'C', false, 0);
        $pdf->MultiCell(40, $maxHeight, $filaE['Fecha_Creacion'], 1, 'C', false, 0);
        $pdf->MultiCell(40, $maxHeight, $filaE['Proveedor'], 1, 'C', false, 0);
        $pdf->MultiCell(40, $maxHeight, $filaE['Receptor'], 1, 'C', false, 0);
        $pdf->MultiCell(40, $maxHeight, $filaE['Comentarios'], 1, 'C', false, 0);
        $pdf->MultiCell(30, $maxHeight, $filaE['Estatus'], 1, 'C', false, 1);
    }
    
    // Cerrar las sentencias
    $stmtE->close();

    // Cerrar la conexión a la base de datos
    $conexion->close();

    // Generar y descargar el PDF
    $pdf->Output('Reporte_Entradas_Por_Fechas_' . date('YmdHis') . '.pdf', 'I');
    exit;
} catch (Exception $e) {
    // Si ocurre una excepción, responder con un mensaje de error en formato JSON
    header('Content-Type: application/json');
    echo json_encode(["error" => $e->getMessage()]);
}
?>