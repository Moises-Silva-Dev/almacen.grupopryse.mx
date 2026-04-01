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
                DATE(RE.FchCreacion) BETWEEN ? AND ?";

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

    $html = '
    <table border="1" cellpadding="4">
        <thead>
            <tr style="background-color:#34495e; color:white; text-align:center; font-weight:bold;">
                <th width="5%">ID</th>
                <th width="15%">Solicitante</th>
                <th width="10%">Fecha</th>
                <th width="10%">Hora</th>
                <th width="10%">Estatus</th>
                <th width="10%">Cuenta</th>
                <th width="10%">Supervisor</th>
                <th width="10%">Centro Trabajo</th>
                <th width="10%">Receptor</th>
                <th width="10%">Justificación</th>
            </tr>
        </thead>
        <tbody>
    ';   

    $color = true;

    while ($filaD = $resultadoD->fetch_assoc()) {
        $fondo = $color ? '#f2f2f2' : '#ffffff';
        $color = !$color;

        $html .= '
            <tr style="background-color:'.$fondo.'; text-align:center;">
                <td width="5%">'.$filaD['IDRequisicionE'].'</td>
                <td width="15%">'.$filaD['Nombre'].' '.$filaD['Apellido_Paterno'].' '.$filaD['Apellido_Materno'].'</td>
                <td width="10%">'.$filaD['Fecha'].'</td>
                <td width="10%">'.$filaD['HoraMinutos'].'</td>
                <td width="10%">'.$filaD['Estatus'].'</td>
                <td width="10%">'.$filaD['NombreCuenta'].'</td>
                <td width="10%">'.$filaD['Supervisor'].'</td>
                <td width="10%">'.$filaD['CentroTrabajo'].'</td>
                <td width="10%">'.$filaD['Receptor'].'</td>
                <td width="10%">'.$filaD['Justificacion'].'</td>
            </tr>
        ';
    }

    $html .= '
        </tbody>
    </table>';

    $pdf->writeHTML($html, true, false, true, false, '');
    $stmtD->close(); // Cerrar el statement y la conexión a la base de datos
    $conexion->close(); // Cerrar la conexión a la base de datos

    // Limpiar el buffer de salida
    if (ob_get_level()) {
        ob_end_clean();
    }

    // Generar y descargar el PDF
    $pdf->Output('Reporte_Solicitud_Por_Fechas_' . date('YmdHis') . '.pdf', 'I');
    exit;
} catch (Exception $e) {
    // Si ocurre una excepción, responder con un mensaje de error en formato JSON
    header('Content-Type: application/json');
    echo json_encode(["error" => $e->getMessage()]);
}
?>