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
    $sqlD = "SELECT DISTINCT
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
                DATE(SE.FchSalidad) BETWEEN ? AND ?";

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

    $html = '
    <table border="1" cellpadding="4">
        <thead>
            <tr style="background-color:#2c3e50;color:white;text-align:center;font-weight:bold;">
                <th width="8%">Identificador</th>
                <th width="12%">Fecha Salida</th>
                <th width="8%">Req</th>
                <th width="10%">Estatus</th>
                <th width="20%">Solicitante</th>
                <th width="12%">Cuenta</th>
                <th width="12%">Fecha Solicitud</th>
                <th width="18%">Entregó</th>
            </tr>
        </thead>
        <tbody>
    ';

    $color = true;

    while ($filaD = $resultadoD->fetch_assoc()) {
        $fondo = $color ? '#f2f2f2' : '#ffffff';
        $color = !$color;

        $html .= '
            <tr style="background-color:'.$fondo.'; tect-align:center;">
                <td width="8%">'.$filaD['Id_SalE'].'</td>
                <td width="12%">'.$filaD['FchSalida'].'</td>
                <td width="8%">'.$filaD['ID_ReqE'].'</td>
                <td width="10%">'.$filaD['Estado'].'</td>
                <td width="20%">'.$filaD['NombreUsuarioSolicitante'].' '.$filaD['ApellidoPaternoUsuarioSolicitante'].' '.$filaD['ApellidoMaternoUsuarioSolicitante'].'</td>
                <td width="12%">'.$filaD['NombreCuenta'].'</td>
                <td width="12%">'.$filaD['FchCreacion'].'</td>
                <td width="18%">'.$filaD['NombreUsuarioSalida'].' '.$filaD['ApellidoPaternoUsuarioSalida'].' '.$filaD['ApellidoMaternoUsuarioSalida'].'</td>
            </tr>
        ';
    }

    $html .= '
        </tbody>
    </table>';

    $pdf->writeHTML($html, true, false, true, false, '');
    $stmtD->close(); // Cerrar el statement
    $conexion->close(); // Cerrar la conexión a la base de datos
    
    // Limpiar el buffer de salida
    if (ob_get_level()) {
        ob_end_clean();
    }

    // Generar el PDF
    $pdf->Output('Reporte_Salida_Por_Fechas_' . date('YmdHis') . '.pdf', 'I');
    exit;
} catch (Exception $e) {
    // Si ocurre una excepción, responder con un mensaje de error en formato JSON
    header('Content-Type: application/json');
    echo json_encode(["error" => $e->getMessage()]);
}
?>