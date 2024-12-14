<?php
// Evitar la caché del navegador
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Hora y lenguaje
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
    
    // Lee el contenido crudo enviado en el cuerpo de la solicitud HTTP 
    $input = file_get_contents('php://input');
    // Convierte la cadena JSON recibida en un array asociativo de PHP.
    $data = json_decode($input, true);
    // Intenta obtener el valor de 'Id_Solicitud' del array decodificado. 
    $ID_RequisionE = $data['Id_Solicitud'] ?? null;
    
    // Verificar que el ID se recibió correctamente
    if (empty($ID_RequisionE)) {
        // Establece el encabezado de la respuesta como JSON.
        header('Content-Type: application/json');
        // Envía un mensaje de error en formato JSON al cliente.
        echo json_encode(["error" => "ID de solicitud no recibido correctamente."]);
        exit;
    }
    
    // Consultar la base de datos para obtener la información de Salida_E
    $sqlE = "SELECT 
                C.NombreCuenta, U.Nombre, U.Apellido_Paterno, U.Apellido_Materno, RE.IDRequisicionE,
                RE.FchCreacion, RE.Estatus, RE.Supervisor, R.Nombre_Region, RE.CentroTrabajo, 
                RE.NroElementos, RE.Receptor, RE.TelReceptor, RE.RfcReceptor, RE.Justificacion,
                E.Nombre_estado, RE.Mpio, RE.Colonia, RE.Calle, RE.Nro, RE.CP
            FROM 
                RequisicionE RE
            INNER JOIN 
                Usuario U ON RE.IdUsuario = U.ID_Usuario
            INNER JOIN 
                Cuenta C ON RE.IdCuenta = C.ID
            INNER JOIN 
                Estados E on RE.IdEstado = E.Id_Estado
            INNER JOIN 
                Regiones R on RE.IdRegion = R.ID_Region
            WHERE 
                RE.IDRequisicionE = ?
            GROUP BY 
                IDRequisicionE";

    // Preparar y ejecutar la consulta para Salida_E
    $stmtE = $conexion->prepare($sqlE);
    
    if (!$stmtE) {
        throw new Exception("Error en la preparación de la consulta Salida_E: " . $conexion->error);
    }
    
    $stmtE->bind_param('i', $ID_RequisionE);
    $stmtE->execute();
    $resultadoE = $stmtE->get_result();
    $filaE = $resultadoE->fetch_assoc();

    if (!$filaE) {
        throw new Exception("No se encontró información para el ID de solicitud proporcionado.");
    }
    
    // Obtener datos de los productos relacionados con la requisición
    $stmtProductos = $conexion->prepare("SELECT 
                                            RE.IDRequisicionE AS Requisicion_ID,
                                            P.IdCProducto AS Producto_ID,
                                            P.IMG AS Imagen_Producto,
                                            CE.Nombre_Empresa AS Empresa,
                                            P.Descripcion AS Descripcion_Producto,
                                            P.Especificacion AS Especificacion_Producto,
                                            CC.Descrp AS Categoria,
                                            CT.Talla AS Talla,
                                            RD.Cantidad AS Cantidad_Solicitada,
                                            IFNULL(SUM(SD.Cantidad), 0) AS Cantidad_Salida
                                        FROM 
                                            RequisicionE RE
                                        INNER JOIN 
                                            RequisicionD RD ON RD.IdReqE = RE.IDRequisicionE
                                        LEFT JOIN 
                                            Salida_E SE ON RE.IDRequisicionE = SE.ID_ReqE
                                        LEFT JOIN 
                                            Salida_D SD ON SE.Id_SalE = SD.Id AND SD.IdCProd = RD.IdCProd AND SD.IdTallas = RD.IdTalla
                                        INNER JOIN 
                                            Producto P ON RD.IdCProd = P.IdCProducto
                                        INNER JOIN 
                                            CTallas CT ON RD.IdTalla = CT.IdCTallas
                                        INNER JOIN 
                                            CCategorias CC ON P.IdCCat = CC.IdCCate
                                        INNER JOIN 
                                            CTipoTallas CTT ON CT.IdCTipTal = CTT.IdCTipTall
                                        INNER JOIN 
                                            CEmpresas CE ON P.IdCEmp = CE.IdCEmpresa
                                        WHERE 
                                            RE.IDRequisicionE = ?
                                        GROUP BY 
                                            RE.IDRequisicionE, P.IdCProducto, P.IMG, CE.Nombre_Empresa, 
                                            P.Descripcion, P.Especificacion, CC.Descrp, CT.Talla, RD.Cantidad;");
                                            
    if (!$stmtProductos) {
        throw new Exception("Error en la preparación de la consulta de productos: " . $conexion->error);
    }
    
    $stmtProductos->bind_param('i', $ID_RequisionE);
    $stmtProductos->execute();
    $resultadoProductos = $stmtProductos->get_result();

    // Verificar si ambos resultados están vacíos
    if ($resultadoE->num_rows === 0 && $resultadoProductos->num_rows === 0) {
        // Configurar la respuesta JSON para error
        header('Content-Type: application/json');
        echo json_encode(["error " => " No hay informacion relacionada con la ID."]);
        return; // Termina la ejecución del script
    }
    
    // Crear un nuevo objeto PDF con orientación horizontal (Landscape)
    $pdf = new MYPDF('P', 'mm', 'LETTER');
    
    // Configuración general del PDF
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Sistema de Requisiciones');
    $pdf->SetTitle('Reporte de Requisición');
    $pdf->SetSubject('Reporte de Requisición por ID');
    $pdf->SetMargins(10, 20, 10);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(15);
    $pdf->SetAutoPageBreak(TRUE, 15);
    $pdf->AddPage();

    // Tipo y tamaño de letra
    $pdf->SetFont('helvetica', 'B', 14);
    // Titulo de la tabla
    $pdf->Cell(0, 10, "Reporte Requisición", 0, 1, "C");

    // Definir el ancho de las celdas de etiqueta y contenido
    $labelWidth = 50;
    // Ajusta este valor según el tamaño del contenido y el tamaño de tu página
    $contentWidth = 150; 
    
    // Identificador
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Numero de Requisición: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell($contentWidth, 7, $filaE['IDRequisicionE'], 0, 1, "L");

    // Nombre
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Nombre: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->MultiCell($contentWidth, 7, $filaE['Nombre'] . ' ' . $filaE['Apellido_Paterno'] . ' ' . $filaE['Apellido_Materno'], 0, "L");
    
    // Fecha de Creación
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Fecha de Creación: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell($contentWidth, 7, $filaE['FchCreacion'], 0, 1, "L");
    
    // Estatus de Solicitud
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Estatus de Solicitud: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell($contentWidth, 7, $filaE['Estatus'], 0, 1, "L");
    
    // Cuenta
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Cuenta: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell($contentWidth, 7, $filaE['NombreCuenta'], 0, 1, "L");
    
    // Supervisor
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Supervisor: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell($contentWidth, 7, $filaE['Supervisor'], 0, 1, "L");
    
    // Centro de Trabajo
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Centro de Trabajo: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell($contentWidth, 7, $filaE['CentroTrabajo'], 0, 1, "L");
    
    // Numero de Elementos
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Numero de Elementos: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell($contentWidth, 7, $filaE['NroElementos'], 0, 1, "L");
    
    // Nombre del Receptor
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Nombre del Receptor: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell($contentWidth, 7, $filaE['Receptor'], 0, 1, "L");
    
    // Número de Teléfono del Receptor
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Teléfono del Receptor: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell($contentWidth, 7, $filaE['TelReceptor'], 0, 1, "L");
    
    // RFC del Receptor
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'RFC del Receptor: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell($contentWidth, 7, $filaE['RfcReceptor'], 0, 1, "L");
    
    // Justificación
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Justificación: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->MultiCell($contentWidth, 7, $filaE['Justificacion'], 0, "L");
    
    // Dirección
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Dirección: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    
    // Construir dirección
    $address_parts = [];
    if (!empty($filaE['Nombre_estado'])) $address_parts[] = $filaE['Nombre_estado'];
    if (!empty($filaE['Mpio'])) $address_parts[] = $filaE['Mpio'];
    if (!empty($filaE['Colonia'])) $address_parts[] = $filaE['Colonia'];
    if (!empty($filaE['Calle'])) $address_parts[] = $filaE['Calle'];
    if (!empty($filaE['Nro'])) $address_parts[] = $filaE['Nro'];
    if (!empty($filaE['CP'])) $address_parts[] = $filaE['CP'];
    
    // Imprimir dirección
    $pdf->MultiCell($contentWidth, 7, implode(', ', $address_parts), 0, "L");
    
    // Agregar salto de página antes de la tabla
    $pdf->Ln();

    // Título de la tabla Salida_E
    $pdf->SetFont("helvetica", "B", 14);
    $pdf->Cell(0, 10, "Productos Solicitados", 0, 1, "C");
    
    // Estilo de la tabla 
    $pdf->SetFillColor(200, 220, 255); // Color de fondo de las celdas
    $pdf->SetFont("helvetica", "B", 9);
    
    // Cabecera de la tabla 
    $pdf->MultiCell(38, 7, 'Nombre de la Empresa', 1, 'C', true, 0);
    $pdf->MultiCell(50, 7, 'Descripción', 1, 'C', true, 0);
    $pdf->MultiCell(50, 7, 'Especificación', 1, 'C', true, 0);
    $pdf->MultiCell(20, 7, 'Talla', 1, 'C', true, 0);
    $pdf->MultiCell(18, 7, 'Solicitado', 1, 'C', true, 0);
    $pdf->MultiCell(18, 7, 'Entregado', 1, 'C', true, 1);
    
    // Agregar datos a la tabla
    $pdf->SetFont("helvetica", '', 10); // Restaurar el estilo de fuente normal
    while ($filaProducto = $resultadoProductos->fetch_assoc()) {
        // Calcular la altura de la fila más alta
        $cellHeights = [
            $pdf->getStringHeight(38, $filaProducto['Empresa']),
            $pdf->getStringHeight(50, $filaProducto['Descripcion_Producto']),
            $pdf->getStringHeight(50, $filaProducto['Especificacion_Producto']),
            $pdf->getStringHeight(20, $filaProducto['Talla'])
        ];
    
        // Definir la altura máxima para la fila actual
        $maxHeight = max($cellHeights);
    
        // Usar MultiCell para cada columna con la misma altura máxima y centrado
        $pdf->MultiCell(38, $maxHeight, $filaProducto['Empresa'], 1, 'C', false, 0);
        $pdf->MultiCell(50, $maxHeight, $filaProducto['Descripcion_Producto'], 1, 'C', false, 0);
        $pdf->MultiCell(50, $maxHeight, $filaProducto['Especificacion_Producto'], 1, 'C', false, 0);
        $pdf->MultiCell(20, $maxHeight, $filaProducto['Talla'], 1, 'C', false, 0);
        $pdf->MultiCell(18, $maxHeight, $filaProducto['Cantidad_Solicitada'], 1, 'C', false, 0);
        $pdf->MultiCell(18, $maxHeight, $filaProducto['Cantidad_Salida'], 1, 'C', false, 1);
    }
    
    // Después de procesar $resultadoProductos
    $stmtProductos->close();
    
    // Cerrar el statement de Salida_E
    $stmtE->close();
    
    // Cerrar la conexión a la base de datos
    $conexion->close();
    
    // Generar el PDF
    $pdf->Output('Reporte_Solicitud_Por_ID_' . date('YmdHis') . '.pdf', 'I');
    
    // Finaliza la ejecución
    exit;
} catch (Exception $e) {
        // Si ocurre una excepción, responder con un mensaje de error en formato JSON
    header('Content-Type: application/json');
    echo json_encode(["error" => $e->getMessage()]);
}
?>