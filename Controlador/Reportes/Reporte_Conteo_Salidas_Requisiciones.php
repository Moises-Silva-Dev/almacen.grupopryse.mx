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
    
    // Calcular la altura de la fila más alta
    $cellHeightsEncabezado = [
        $pdf->getStringHeight(22, "Identificador"),
        $pdf->getStringHeight(25, "Fecha de Creación"),
        $pdf->getStringHeight(25, "Usuario"),
        $pdf->getStringHeight(20, "Cuenta"),
        $pdf->getStringHeight(25, "Región"),
        $pdf->getStringHeight(30, "Estado"),
        $pdf->getStringHeight(22, "Identificador de Prodcuto"),
        $pdf->getStringHeight(30, "Descripción"),
        $pdf->getStringHeight(30, "Especificación"),
        $pdf->getStringHeight(17, "Cantidad Pedida"),
        $pdf->getStringHeight(17, "Cantidad Salida")
    ];

    // Definir la altura máxima para la fila actual
    $maxHeightEncabezado = max($cellHeightsEncabezado);

    // Cabecera de la tabla EntradaE
    $pdf->MultiCell(22, $maxHeightEncabezado, "Identificador", 1, 'C', true, 0);
    $pdf->MultiCell(25, $maxHeightEncabezado, "Fecha de Creación", 1, 'C', true, 0);
    $pdf->MultiCell(25, $maxHeightEncabezado, "Usuario", 1, 'C', true, 0);
    $pdf->MultiCell(20, $maxHeightEncabezado, "Cuenta", 1, 'C', true, 0);
    $pdf->MultiCell(25, $maxHeightEncabezado, "Región", 1, 'C', true, 0);
    $pdf->MultiCell(30, $maxHeightEncabezado, "Estado", 1, 'C', true, 0);
    $pdf->MultiCell(22, $maxHeightEncabezado, "Identificador de Prodcuto", 1, 'C', true, 0);
    $pdf->MultiCell(30, $maxHeightEncabezado, "Descripción", 1, 'C', true, 0);
    $pdf->MultiCell(30, $maxHeightEncabezado, "Especificación", 1, 'C', true, 0);
    $pdf->MultiCell(17, $maxHeightEncabezado, "Cantidad Pedida", 1, 'C', true, 0);
    $pdf->MultiCell(17, $maxHeightEncabezado, "Cantidad Salida", 1, 'C', true, 1);

    // Agregar datos a la tabla EntradaE
    $pdf->SetFont("helvetica", "", 12); // Restaurar el estilo de fuente normal
    while ($filaE = $resultadoE->fetch_assoc()) {
        // Calcular la altura de la fila más alta
        $cellHeights = [
            $pdf->getStringHeight(22, $filaE['Identificador_Requisicion']),
            $pdf->getStringHeight(25, $filaE['Fecha_Creacion']),
            $pdf->getStringHeight(25, $filaE['Usuario']),
            $pdf->getStringHeight(20, $filaE['Cuenta']),
            $pdf->getStringHeight(25, $filaE['Region']),
            $pdf->getStringHeight(30, $filaE['Estado']),
            $pdf->getStringHeight(22, $filaE['Identificador_Producto']),
            $pdf->getStringHeight(30, $filaE['Descripcion']),
            $pdf->getStringHeight(30, $filaE['Especificacion']),
            $pdf->getStringHeight(17, $filaE['Cantidad_Requerida']),
            $pdf->getStringHeight(17, $filaE['Cantidad_Salida'])
        ];
        
        // Definir la altura máxima para la fila actual
        $maxHeight = max($cellHeights);
    
        // Usar MultiCell para cada columna con la misma altura máxima y centrado
        $pdf->MultiCell(22, $maxHeight, $filaE['Identificador_Requisicion'], 1, 'C', false, 0);
        $pdf->MultiCell(25, $maxHeight, $filaE['Fecha_Creacion'], 1, 'C', false, 0);
        $pdf->MultiCell(25, $maxHeight, $filaE['Usuario'], 1, 'C', false, 0);
        $pdf->MultiCell(20, $maxHeight, $filaE['Cuenta'], 1, 'C', false, 0);
        $pdf->MultiCell(25, $maxHeight, $filaE['Region'], 1, 'C', false, 0);
        $pdf->MultiCell(30, $maxHeight, $filaE['Estado'], 1, 'C', false, 0);
        $pdf->MultiCell(22, $maxHeight, $filaE['Identificador_Producto'], 1, 'C', false, 0);
        $pdf->MultiCell(30, $maxHeight, $filaE['Descripcion'], 1, 'C', false, 0);
        $pdf->MultiCell(30, $maxHeight, $filaE['Especificacion'], 1, 'C', false, 0);
        $pdf->MultiCell(17, $maxHeight, $filaE['Cantidad_Requerida'], 1, 'C', false, 0);
        $pdf->MultiCell(17, $maxHeight, $filaE['Cantidad_Salida'], 1, 'C', false, 1);
    }
    
    // Cerrar las sentencias
    $stmtE->close();

    // Cerrar la conexión a la base de datos
    $conexion->close();

    // Generar y descargar el PDF
    $pdf->Output('Reporte_Coteo_Salidas_Requisionces_Por_Fechas_' . date('YmdHis') . '.pdf', 'I');
    exit;
} catch (Exception $e) {
    // Si ocurre una excepción, responder con un mensaje de error en formato JSON
    header('Content-Type: application/json');
    echo json_encode(["error" => $e->getMessage()]);
}
?>