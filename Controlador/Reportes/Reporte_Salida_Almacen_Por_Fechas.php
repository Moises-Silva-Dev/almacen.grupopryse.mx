<?php
// Iniciar la sesión
session_start();
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/Mexico_City');

// Incluir archivo de conexión a la base de datos
include("../../Modelo/Conexion.php");

// Incluir autoload de Composer para cargar TCPDF
require_once('../../librerias/TCPDF/vendor/autoload.php');  

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
    $sqlD = "SELECT 
                SE.Id_SalE, 
                DATE(SE.FchSalidad) AS FchSalida, 
                SE.ID_ReqE, 
                U.Nombre AS NombreUsuarioSolicitante, 
                U.Apellido_Paterno AS ApellidoPaternoUsuarioSolicitante, 
                U.Apellido_Materno AS ApellidoMaternoUsuarioSolicitante, 
                C.NombreCuenta, 
                DATE(RE.FchCreacion) AS FchCreacion, 
                RE.Estatus AS Estado,
                U2.Nombre AS NombreUsuarioSalida,
                U2.Apellido_Paterno AS ApellidoPaternoUsuarioSalida,
                U2.Apellido_Materno AS ApellidoMaternoUsuarioSalida
            FROM 
                Salida_D SD 
            INNER JOIN 
                Salida_E SE ON SE.Id_SalE = SD.Id 
            INNER JOIN 
                RequisicionE RE ON RE.IDRequisicionE = SE.ID_ReqE 
            INNER JOIN 
                Usuario U ON RE.IdUsuario = U.ID_Usuario
            INNER JOIN 
                Cuenta C ON RE.IdCuenta = C.ID 
            INNER JOIN 
                Usuario U2 ON U2.ID_Usuario = SE.ID_Usuario_Salida
            WHERE 
                DATE(SE.FchSalidad) BETWEEN ? AND ? 
            GROUP BY 
                SE.Id_SalE;";

    // Preparar y ejecutar la consulta para Salida_D
    $stmtD = $conexion->prepare($sqlD);
    if (!$stmtD) {
        throw new Exception("Error en la preparación de la consulta Salida_D: " . $conexion->error);
    }
    $stmtD->bind_param('ss', $fecha_inicio, $fecha_fin);
    $stmtD->execute();
    $resultadoD = $stmtD->get_result();
    
    // Verificar si ambos resultados están vacíos
    if ($resultadoD->num_rows === 0) {
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
    $pdf->SetTitle('Reporte de Requisiciones Salidas');
    $pdf->SetSubject('Reporte Requisiciones de Salidas por Fecha');
    $pdf->SetMargins(10, 20, 10);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(15);
    $pdf->SetAutoPageBreak(TRUE, 15);
    $pdf->AddPage();

    // Tipo y tamaño de letra
    $pdf->SetFont('helvetica', 'B', 14);
    // Titulo de la tabla
    $pdf->Cell(0, 10, "Reporte Requisiciones Salidas", 0, 1, "C");
    
    // Estilo de la tabla Salida_D
    $pdf->SetFillColor(200, 220, 255); // Color de fondo de las celdas
    $pdf->SetFont("helvetica", "B", 8);

    // Calcular la altura de la fila más alta
    $cellHeightsEncabezado = [
        $pdf->getStringHeight(25, "Identificador"),
        $pdf->getStringHeight(30, "Fecha de Salida"),
        $pdf->getStringHeight(15, "IdReqE"),
        $pdf->getStringHeight(20, "Estatus"),
        $pdf->getStringHeight(50, "Nombre del Solicitante"),
        $pdf->getStringHeight(30, "Cuenta"),
        $pdf->getStringHeight(30, "Fecha de Solicitud"),
        $pdf->getStringHeight(50, "Entrego")
    ];

    // Definir la altura máxima para la fila actual
    $maxHeightEncabezado = max($cellHeightsEncabezado);
    
    // Cabecera de la tabla Salida_D
    $pdf->MultiCell(25, $maxHeightEncabezado, "Identificador", 1, 'C', true, 0);
    $pdf->MultiCell(30, $maxHeightEncabezado, "Fecha de Salida", 1, 'C', true, 0);
    $pdf->MultiCell(15, $maxHeightEncabezado, "IdReqE", 1, 'C', true, 0);
    $pdf->MultiCell(20, $maxHeightEncabezado, "Estatus", 1, 'C', true, 0);
    $pdf->MultiCell(50, $maxHeightEncabezado, "Nombre del Solicitante", 1, 'C', true, 0);
    $pdf->MultiCell(30, $maxHeightEncabezado, "Cuenta", 1, 'C', true, 0);
    $pdf->MultiCell(30, $maxHeightEncabezado, "Fecha de Solicitud", 1, 'C', true, 0);
    $pdf->MultiCell(50, $maxHeightEncabezado, "Entrego", 1, 'C', true, 1);

    // Agregar datos a la tabla Salida_D
    $pdf->SetFont("helvetica", "", 12); // Restaurar el estilo de fuente normal
    while ($filaD = $resultadoD->fetch_assoc()) {
        // Calcular la altura de la fila más alta
        $cellHeights = [
            $pdf->getStringHeight(25, $filaD['Id_SalE']),
            $pdf->getStringHeight(30, $filaD['FchSalida']),
            $pdf->getStringHeight(15, $filaD['ID_ReqE']),
            $pdf->getStringHeight(20, $filaD['Estado']),
            $pdf->getStringHeight(50, $filaD['NombreUsuarioSolicitante'] . ' ' . $filaD['ApellidoPaternoUsuarioSolicitante'] . ' ' . $filaD['ApellidoMaternoUsuarioSolicitante']),
            $pdf->getStringHeight(30, $filaD['NombreCuenta']),
            $pdf->getStringHeight(30, $filaD['FchCreacion']),
            $pdf->getStringHeight(50, $filaD['NombreUsuarioSalida'] . ' ' . $filaD['ApellidoPaternoUsuarioSalida'] . ' ' . $filaD['ApellidoMaternoUsuarioSalida'])
        ];
    
        // Definir la altura máxima para la fila actual
        $maxHeight = max($cellHeights);
        
        $pdf->MultiCell(25, $maxHeight, $filaD['Id_SalE'], 1, 'C', false, 0);
        $pdf->MultiCell(30, $maxHeight, $filaD['FchSalida'], 1, 'C', false, 0);
        $pdf->MultiCell(15, $maxHeight, $filaD['ID_ReqE'], 1, 'C', false, 0);
        $pdf->MultiCell(20, $maxHeight, $filaD['Estado'], 1, 'C', false, 0);
        $pdf->MultiCell(50, $maxHeight, $filaD['NombreUsuarioSolicitante'] . ' ' . $filaD['ApellidoPaternoUsuarioSolicitante'] . ' ' . $filaD['ApellidoMaternoUsuarioSolicitante'], 1, 'C', false, 0);
        $pdf->MultiCell(30, $maxHeight, $filaD['NombreCuenta'], 1, 'C', false, 0);
        $pdf->MultiCell(30, $maxHeight, $filaD['FchCreacion'],1, 'C', false, 0);
        $pdf->MultiCell(50, $maxHeight, $filaD['NombreUsuarioSalida'] . ' ' . $filaD['ApellidoPaternoUsuarioSalida'] . ' ' . $filaD['ApellidoMaternoUsuarioSalida'], 1, 'C', false, 1);
    }

    // Cerrar el statement
    $stmtD->close();

    // Cerrar la conexión a la base de datos
    $conexion->close();
    
    // Generar el PDF
    $pdf->Output('Reporte_Salida_Por_Fechas_' . date('YmdHis') . '.pdf', 'I');
    exit;
} catch (Exception $e) {
    // Si ocurre una excepción, responder con un mensaje de error en formato JSON
    header('Content-Type: application/json');
    echo json_encode(["error" => $e->getMessage()]);
}
?>