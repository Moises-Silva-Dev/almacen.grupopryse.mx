<?php
// Iniciar la sesión
session_start();
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/Mexico_City');

// Incluir autoload de Composer para cargar TCPDF
require_once('../../../librerias/TCPDF/vendor/autoload.php'); 

function generarPDF($conexion, $ID_RequisionE) {
    // Definir clase personalizada extendiendo de TCPDF para el encabezado/pie de página
    class MYPDF extends TCPDF {
        // Encabezado personalizado
        public function Header() {
            // Imagen a la izquierda
            $this->Image('../../../img/pryse.png', 10, 5, 0, 10, 'PNG');
            
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
    
    // Definir la ruta del PDF
    $nombrePDF = "Solicitud_" . date('Y-m-d_H-i-s') . ".pdf";
    $rutaPDF = $_SERVER['DOCUMENT_ROOT'] . "/pdfs/" . $nombrePDF; // Define la ruta absoluta
    
    // Crear la carpeta si no existe
    $carpetaDestino = dirname($rutaPDF);
    if (!file_exists($carpetaDestino)) {
        mkdir($carpetaDestino, 0777, true);
    }

    try {
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
                    Regiones R ON RE.IdRegion = R.ID_Region
                INNER JOIN 
                    Estados E ON RE.IdEstado = E.Id_Estado
                WHERE 
                    RE.IDRequisicionE = ?
                LIMIT 1";

        // Preparar y ejecutar la consulta para Salida_E
        $stmtE = $conexion->prepare($sqlE);
        if (!$stmtE) {
            throw new Exception("Error en la preparación de la consulta Salida_E: " . $conexion->error);
        }
        $stmtE->bind_param('i', $ID_RequisionE);
        $stmtE->execute();
        $resultadoE = $stmtE->get_result();

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

        // Iterar sobre los resultados de la consulta
        if ($filaE = $resultadoE->fetch_assoc()) {
            // Tipo y tamaño de letra
            $pdf->SetFont('helvetica', 'B', 14);
            // Titulo de la tabla
            $pdf->Cell(0, 10, "Reporte Requisición", 0, 1, "C");
    
            // Definir el ancho de las celdas de etiqueta y contenido
            $labelWidth = 50;
            // Ajusta este valor según el tamaño del contenido y el tamaño de tu página
            $contentWidth = 150; 
            
            // Numero de Requisición
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
            
            //Variable en Arreglo
            $address_parts = array();

            // Verificar y agregar partes de la dirección si no están vacías o NULL en el orden especificado
            if (!empty($filaE['Calle'])) {
                $address_parts[] = $filaE['Calle'];
            }
            if (!empty($filaE['Nro'])) {
                $address_parts[] = "No. " . $filaE['Nro'];
            }
            if (!empty($filaE['Colonia'])) {
                $address_parts[] = $filaE['Colonia'];
            }
            if (!empty($filaE['Mpio'])) {
                $address_parts[] = $filaE['Mpio']; // Ciudad o Municipio
            }
            if (!empty($filaE['Nombre_estado'])) {
                $address_parts[] = $filaE['Nombre_estado']; // Estado
            }
            if (!empty($filaE['CP'])) {
                $address_parts[] = $filaE['CP']; // Código postal
            }
            
            // Unir todas las partes de la dirección con una coma y espacio
            $address_string = implode(', ', $address_parts);
            
            // Imprimir en la celda del PDF
            $pdf->MultiCell($contentWidth, 7, $address_string, 0, "L");

            // Agregar un salto de página antes de la tabla
            $pdf->Ln();

            // Título de la tabla Salida_E
            $pdf->SetFont("helvetica", "B", 14);
            $pdf->Cell(0, 10, "Productos Solicitados", 0, 1, "C");

            // Estilo de la tabla 
            $pdf->SetFillColor(200, 220, 255); // Color de fondo de las celdas
            $pdf->SetFont("helvetica", "B", 9);

            // Calcular la altura de la fila más alta
            $cellHeightsEncabezado = [
                $pdf->getStringHeight(40, "Nombre de la Empresa"),
                $pdf->getStringHeight(55, "Descripción"),
                $pdf->getStringHeight(50, "Especificación"),
                $pdf->getStringHeight(25, "Talla"),
                $pdf->getStringHeight(20, "Cantidad")
            ];

            // Definir la altura máxima para la fila actual
            $maxHeightEncabezado = max($cellHeightsEncabezado);
            
            // Cabecera de la tabla 
            $pdf->MultiCell(40, $maxHeightEncabezado, "Nombre de la Empresa", 1, 'C', true, 0);
            $pdf->MultiCell(55, $maxHeightEncabezado, "Descripción", 1, 'C', true, 0);
            $pdf->MultiCell(50, $maxHeightEncabezado, "Especificación", 1, 'C', true, 0);
            $pdf->MultiCell(25, $maxHeightEncabezado, "Talla", 1, 'C', true, 0);
            $pdf->MultiCell(20, $maxHeightEncabezado, "Cantidad", 1, 'C', true, 1);

            // Obtener datos de los productos relacionados con la requisición
            $stmtProductos = $conexion->prepare("SELECT 
                                                    CE.Nombre_Empresa, P.Descripcion, P.Especificacion, 
                                                    CC.Descrp, CT.Talla, RD.Cantidad
                                                FROM 
                                                    RequisicionD RD
                                                INNER JOIN 
                                                    Producto P ON RD.IdCProd = P.IdCProducto
                                                INNER JOIN 
                                                    CEmpresas CE ON P.IdCEmp = CE.IdCEmpresa
                                                INNER JOIN 
                                                    CTallas CT ON RD.IdTalla = CT.IdCTallas
                                                INNER JOIN 
                                                    CCategorias CC ON P.IdCCat = CC.IdCCate
                                                WHERE 
                                                    RD.IdReqE = ?");
            if (!$stmtProductos) {
                throw new Exception("Error en la preparación de la consulta de productos: " . $conexion->error);
            }
            $stmtProductos->bind_param('i', $ID_RequisionE);
            $stmtProductos->execute();
            $resultadoProductos = $stmtProductos->get_result();

            // Agregar datos a la tabla
            $pdf->SetFont("helvetica", "", 10); // Restaurar el estilo de fuente normal
            while ($filaProducto = $resultadoProductos->fetch_assoc()) {
                // Calcular la altura de la fila más alta
                $cellHeights = [
                    $pdf->getStringHeight(40, $filaProducto['Nombre_Empresa']),
                    $pdf->getStringHeight(55, $filaProducto['Descripcion']),
                    $pdf->getStringHeight(50, $filaProducto['Especificacion']),
                    $pdf->getStringHeight(25, $filaProducto['Talla']),
                    $pdf->getStringHeight(20, $filaProducto['Cantidad'])
                ];
            
                // Definir la altura máxima para la fila actual
                $maxHeight = max($cellHeights);
                
                // Usar MultiCell para cada columna con la misma altura máxima y centrado
                $pdf->MultiCell(40, $maxHeight, $filaProducto['Nombre_Empresa'], 1, 'C', false, 0);
                $pdf->MultiCell(55, $maxHeight, $filaProducto['Descripcion'], 1, 'C', false, 0);
                $pdf->MultiCell(50, $maxHeight, $filaProducto['Especificacion'], 1, 'C', false, 0);
                $pdf->MultiCell(25, $maxHeight, $filaProducto['Talla'], 1, 'C', false, 0);
                $pdf->MultiCell(20, $maxHeight, $filaProducto['Cantidad'], 1, 'C', false, 1);
            }

            // Limpiar el resultado de la consulta de productos
            $stmtProductos->close();

        } else {
            // Si no se encontraron datos para la requisición
            throw new Exception("No se encontraron datos para la requisición con ID: " . $ID_RequisionE);
        }

        // Cerrar el statement de Salida_E
        $resultadoE->close();
        
        // Cerrar el statement de productos
        $resultadoProductos->close();
        
        // Cerrar la conexión a la base de datos
        $conexion->close();
        
        // Generar el PDF y guardarlo en la ruta especificada
        $pdf->Output($rutaPDF, 'F');

        return $nombrePDF; // Devolver el nombre del PDF generado
    } catch (Exception $e) {
        return ["success" => false, "message" => $e->getMessage()];
    }
}
?>