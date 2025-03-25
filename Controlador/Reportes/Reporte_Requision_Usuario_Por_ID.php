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
    // Variable para almacenar la ID de la requisición
    protected $requisicionId;

    // Método para establecer la ID de la requisición
    public function setRequisicionId($id) {
        $this->requisicionId = $id; // Asignar la ID de la requisición
    }

    // Encabezado personalizado (sin cambios)
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

    // Pie de página personalizado (modificado)
    public function Footer() {
        $this->SetY(-15); // Posición a 15 mm desde el borde inferior
        $this->SetFont('helvetica', 'I', 8);

        // Mostrar la ID de la requisición en el lado izquierdo
        $this->Cell(50, 10, 'Requisición ID: ' . $this->requisicionId, 0, 0, 'L');

        // Mostrar el número de página en el lado derecho
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
    }
}

try {
    // Obtener la instancia de conexión a la base de datos
    $conexion = (new Conectar())->conexion();

    // Obtener las fechas enviadas por el formulario
    $Id_Usuario = isset($_POST['Id_Usuario']) ? $_POST['Id_Usuario'] : null;

    // Verificar que las fechas se recibieron correctamente
    if (empty($Id_Usuario)) {
        // Lanzar una excepción si la ID no se recibio correctamente
        throw new Exception("ID no recibida correctamente.");
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
                RE.IDRequisicionE IN (SELECT IDRequisicionE FROM RequisicionE WHERE IdUsuario = ?)
            GROUP BY 
                IDRequisicionE";

    // Preparar y ejecutar la consulta para Salida_E
    $stmtE = $conexion->prepare($sqlE);
    
    if (!$stmtE) { // Verificar si la preparación de la consulta falla
        // Lanzar una excepción si la preparación de la consulta falla
        throw new Exception("Error en la preparación de la consulta Salida_E: " . $conexion->error);
    }
    
    // Vincular los parámetros
    $stmtE->bind_param('i', $Id_Usuario);
    // Ejecutar la consulta
    $stmtE->execute();
    // Obtener el resultado de la consulta
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

    // Iterar sobre los 5 registros
    while ($filaE = $resultadoE->fetch_assoc()) {        
        // Crear un nuevo objeto PDF con orientación horizontal (Landscape)
        $pdf->AddPage();

        // Establecer la ID de la requisición en el PDF
        $pdf->setRequisicionId($filaE['IDRequisicionE']);

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
        
        // Construir dirección
        $address_parts = [];
        if (!empty($filaE['Calle'])) $address_parts[] = $filaE['Calle'];
        if (!empty($filaE['Nro'])) $address_parts[] = "No. " . $filaE['Nro'];
        if (!empty($filaE['Colonia'])) $address_parts[] = $filaE['Colonia'];
        if (!empty($filaE['Mpio'])) $address_parts[] = $filaE['Mpio'];
        if (!empty($filaE['Nombre_estado'])) $address_parts[] = $filaE['Nombre_estado'];
        if (!empty($filaE['CP'])) $address_parts[] = $filaE['CP'];
        
        // Imprimir dirección
        $pdf->MultiCell($contentWidth, 7, implode(', ', $address_parts), 0, "L");
        
        // Agregar salto de página antes de la tabla
        $pdf->Ln();

        // Consultar la base de datos para obtener la información de los productos relacionados con la requisición
        $sqlD = "SELECT
                    RD.IdCProd, P.Descripcion, P.Especificacion, T.Talla, 
                    RD.Cantidad AS Cantidad, CEM.Nombre_Empresa AS Nombre_Empresa, 
                    CCA.Descrp AS Categoria
                FROM 
                    RequisicionD RD
                INNER JOIN
                    RequisicionE RE ON RD.IdReqE = RE.IDRequisicionE
                INNER JOIN 
                    Producto P ON RD.IdCProd = P.IdCProducto 
                INNER JOIN 
                    CTallas T ON RD.IdTalla = T.IdCTallas 
                INNER JOIN 
                    CEmpresas CEM ON P.IdCEmp = CEM.IdCEmpresa 
                INNER JOIN 
                    CCategorias CCA ON P.IdCCat = CCA.IdCCate 
                WHERE 
                    RD.IdReqE = ?"; 

        // Obtener datos de los productos relacionados con la requisición
        $stmtD = $conexion->prepare($sqlD);
                                                
        if (!$stmtD) { // Verificar si la preparación de la consulta falla
            // Lanzar una excepción si la preparación de la consulta falla
            throw new Exception("Error en la preparación de la consulta de productos: " . $conexion->error);
        }
        
        // Vincular los parámetros
        $stmtD->bind_param('i', $filaE['IDRequisicionE']);
        // Ejecutar la consulta
        $stmtD->execute();
        // Obtener el resultado de la consulta
        $resultadoD = $stmtD->get_result();

        // Verificar si ambos resultados están vacíos
        if ($resultadoE->num_rows === 0 && $resultadoD->num_rows === 0) {
            // Configurar la respuesta JSON para error
            header('Content-Type: application/json');
            // Enviar un mensaje de error en formato JSON
            echo json_encode(["error " => " No hay informacion relacionada con la ID."]);
            return; // Termina la ejecución del script
        }

        // Título de la tabla Salida_E
        $pdf->SetFont("helvetica", "B", 14);
        $pdf->Cell(0, 10, "Productos Solicitados", 0, 1, "C");
        
        // Estilo de la tabla 
        $pdf->SetFillColor(200, 220, 255); // Color de fondo de las celdas
        $pdf->SetFont("helvetica", "B", 9); // Estilo de la fuente

        // Calcular la altura de la fila más alta
        $cellHeightsEncabezado2 = [
            $pdf->getStringHeight(30, "Empresa"),
            $pdf->getStringHeight(25, "Categoría"),
            $pdf->getStringHeight(25, "Identificador de Producto"),
            $pdf->getStringHeight(40, "Descripción"),
            $pdf->getStringHeight(40, "Especificación"),
            $pdf->getStringHeight(15, "Talla"),
            $pdf->getStringHeight(17, "Cantidad")
        ];

        // Definir la altura máxima para la fila actual
        $maxHeightEncabezado2 = max($cellHeightsEncabezado2);

        // Encabezados de la tabla usando MultiCell para cada columna
        $pdf->MultiCell(30, $maxHeightEncabezado2, 'Empresa', 1, 'C', true, 0);
        $pdf->MultiCell(25, $maxHeightEncabezado2, 'Categoría', 1, 'C', true, 0);
        $pdf->MultiCell(25, $maxHeightEncabezado2, 'Identificador de Producto', 1, 'C', true, 0);
        $pdf->MultiCell(40, $maxHeightEncabezado2, 'Descripción', 1, 'C', true, 0);
        $pdf->MultiCell(40, $maxHeightEncabezado2, 'Especificación', 1, 'C', true, 0);
        $pdf->MultiCell(15, $maxHeightEncabezado2, 'Talla', 1, 'C', true, 0);
        $pdf->MultiCell(17, $maxHeightEncabezado2, 'Cantidad', 1, 'C', true, 1);

        // Agregar datos a la tabla
        $pdf->SetFont("helvetica", '', 10); // Restaurar el estilo de fuente normal
        while ($filaD = $resultadoD->fetch_assoc()) {  
            // Calcular la altura de la fila más alta
            $cellHeights2 = [
                $pdf->getStringHeight(30, $filaD['Nombre_Empresa']),
                $pdf->getStringHeight(25, $filaD['Categoria']),
                $pdf->getStringHeight(25, $filaD['IdCProd']),
                $pdf->getStringHeight(40, $filaD['Descripcion']),
                $pdf->getStringHeight(40, $filaD['Especificacion']),
                $pdf->getStringHeight(15, $filaD['Talla']),
                $pdf->getStringHeight(17, $filaD['Cantidad'])
            ];

            // Definir la altura máxima para la fila actual
            $maxHeight2 = max($cellHeights2);
        
            // Usar MultiCell para cada columna con la misma altura máxima y centrado
            $pdf->MultiCell(30, $maxHeight2, $filaD['Nombre_Empresa'], 1, 'C', false, 0);
            $pdf->MultiCell(25, $maxHeight2, $filaD['Categoria'], 1, 'C', false, 0);
            $pdf->MultiCell(25, $maxHeight2, $filaD['IdCProd'], 1, 'C', false, 0);
            $pdf->MultiCell(40, $maxHeight2, $filaD['Descripcion'], 1, 'C', false, 0);
            $pdf->MultiCell(40, $maxHeight2, $filaD['Especificacion'], 1, 'C', false, 0);
            $pdf->MultiCell(15, $maxHeight2, $filaD['Talla'], 1, 'C', false, 0);
            $pdf->MultiCell(17, $maxHeight2, $filaD['Cantidad'], 1, 'C', false, 1);
        }

        // Después de procesar $resultadoProductos
        $stmtD->close();
    }

    // Cerrar el statement de Salida_E
    $stmtE->close();
        
    // Cerrar la conexión a la base de datos
    $conexion->close();
    
    // Generar el PDF
    $pdf->Output('Reporte_Solicitud_Por_ID_' . date('YmdHis') . '.pdf', 'I');
    exit; // Finalizar la ejecución del script
} catch (Exception $e) {
    // Si ocurre una excepción, responder con un mensaje de error en formato JSON
    header('Content-Type: application/json');
    // Enviar el mensaje de error
    echo json_encode(["error" => $e->getMessage()]);
}
?>