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
                T1.IDRequisicionE AS Identificador_Requisicion, 
                T1.FchCreacion AS Fecha_Creacion,
                ANY_VALUE(CONCAT(T2.Nombre, ' ', T2.Apellido_Paterno)) AS Usuario, 
                ANY_VALUE(T3.NombreCuenta) AS Cuenta, 
                ANY_VALUE(T4.Nombre_Region) AS Region,
                ANY_VALUE(T5.Nombre_estado) AS Estado, 
                T6.IdCProd AS Identificador_Producto,
                ANY_VALUE(T7.Descripcion) AS Descripcion, 
                ANY_VALUE(T7.Especificacion) AS Especificacion, 
                SUM(T6.Cantidad) AS Cantidad_Requerida,
                COALESCE(
                    (SELECT SUM(Ta.Cantidad) 
                    FROM Salida_D Ta 
                    INNER JOIN Salida_E Tb ON Ta.Id = Tb.Id_SalE 
                    WHERE Tb.ID_ReqE = T1.IDRequisicionE 
                    AND Ta.IdCProd = T6.IdCProd
                    ), 0
                ) AS Cantidad_Salida
            FROM 
                RequisicionE T1
            INNER JOIN Usuario T2 ON T2.ID_Usuario = T1.IdUsuario 
            INNER JOIN Cuenta T3 ON T3.ID = T1.IdCuenta 
            INNER JOIN Regiones T4 ON T4.ID_Region = T1.IdRegion 
            INNER JOIN Estados T5 ON T5.Id_Estado = T1.IdEstado 
            INNER JOIN RequisicionD T6 ON T6.IdReqE = T1.IDRequisicionE 
            INNER JOIN Producto T7 ON T7.IdCProducto = T6.IdCProd 
            WHERE 
                DATE(T1.FchCreacion) BETWEEN ? AND ?
            GROUP BY 
                T1.IDRequisicionE, 
                T6.IdCProd";

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
    $pdf->SetMargins(8, 20, 8);
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

    $html = '
    <table border="1" cellpadding="4">
        <thead>
            <tr style="background-color:#2c3e50;color:white;font-weight:bold;text-align:center;">
                <th width="8%">Identificador</th>
                <th width="10%">Fecha</th>
                <th width="10%">Usuario</th>
                <th width="8%">Cuenta</th>
                <th width="10%">Región</th>
                <th width="12%">Estado</th>
                <th width="6%">Identificador Producto</th>
                <th width="12%">Descripción</th>
                <th width="12%">Especificación</th>
                <th width="6%">Pedida</th>
                <th width="6%">Salida</th>
            </tr>
        </thead>
        <tbody>
    ';
    
    $color = true;

    while ($filaE = $resultadoE->fetch_assoc()) {

        $bg = $color ? '#f2f2f2' : '#ffffff';
        $color = !$color;

        $html .= '
            <tr style="background-color:'.$bg.'; text-align:center;">
                <td width="8%">'.$filaE['Identificador_Requisicion'].'</td>
                <td width="10%">'.$filaE['Fecha_Creacion'].'</td>
                <td width="10%">'.$filaE['Usuario'].'</td>
                <td width="8%">'.$filaE['Cuenta'].'</td>
                <td width="10%">'.$filaE['Region'].'</td>
                <td width="12%">'.$filaE['Estado'].'</td>
                <td width="6%">'.$filaE['Identificador_Producto'].'</td>
                <td width="12%">'.$filaE['Descripcion'].'</td>
                <td width="12%">'.$filaE['Especificacion'].'</td>
                <td width="6%">'.$filaE['Cantidad_Requerida'].'</td>
                <td width="6%">'.$filaE['Cantidad_Salida'].'</td>
            </tr>
        ';
    }

    $html .= '
        </tbody>
    </table>';

    $pdf->writeHTML($html, true, false, true, false, '');
    $stmtE->close(); // Cerrar las sentencias
    $conexion->close(); // Cerrar la conexión a la base de datos

    // Limpiar el buffer de salida
    if (ob_get_level()) {
        ob_end_clean();
    }

    // Generar y descargar el PDF
    $pdf->Output('Reporte_Coteo_Salidas_Requisionces_Por_Fechas_' . date('YmdHis') . '.pdf', 'I');
    exit;
} catch (Exception $e) {
    // Si ocurre una excepción, responder con un mensaje de error en formato JSON
    header('Content-Type: application/json');
    echo json_encode(["error" => $e->getMessage()]);
}
?>