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
    
    // Obtener el ID de la solicitud enviado por el formulario
    $Id_Salida = isset($_POST['Id_Salida']) ? $_POST['Id_Salida'] : null;

    // Verificar que el ID se recibió correctamente
    if (empty($Id_Salida)) {
        throw new Exception("ID de solicitud no recibido correctamente.");
    }
    
    // Consultar la base de datos para obtener la información de Salida_E
    $sqlE = "SELECT 
                C.NombreCuenta, U.Nombre, U.Apellido_Paterno, U.Apellido_Materno, 
                SE.ID_ReqE, RE.FchCreacion, RE.CentroTrabajo, RE.Estatus, 
                E.Nombre_estado, RE.Mpio, RE.Colonia, RE.Calle, RE.Nro, RE.CP,
                U2.Nombre AS Nombre2, U2.Apellido_Paterno AS Apellido_Paterno2, U2.Apellido_Materno AS Apellido_Materno2
            FROM 
                Salida_D SD 
            INNER JOIN 
                Salida_E SE ON SE.Id_SalE = SD.Id 
            INNER JOIN 
                RequisicionE RE ON RE.IDRequisicionE = SE.Id_ReqE
            INNER JOIN 
                Estados E ON E.Id_Estado = RE.IdEstado
            INNER JOIN 
                Usuario U ON U.ID_Usuario = RE.IdUsuario
            INNER JOIN 
                Cuenta C ON C.ID = RE.IdCuenta
            INNER JOIN 
                Usuario U2 ON U2.ID_Usuario = SE.ID_Usuario_Salida
            WHERE 
                SE.Id_SalE = ?
            GROUP BY 
                RE.IDRequisicionE;";
                
    // Preparar y ejecutar la consulta para Salida_E
    $stmtE = $conexion->prepare($sqlE);
    
    if (!$stmtE) {
        throw new Exception("Error en la preparación de la consulta Salida_E: " . $conexion->error);
    }
    
    $stmtE->bind_param('i', $Id_Salida);
    $stmtE->execute();
    $resultadoE = $stmtE->get_result();
    $filaE = $resultadoE->fetch_assoc();

    if (!$filaE) {
        throw new Exception("No se encontró información para el ID de solicitud proporcionado.");
    }
    
    // Obtener datos de los productos relacionados con la requisición
    $stmtProductos = $conexion->prepare("SELECT
            sd.IdCProd AS Identificador_Producto,
            p.Descripcion AS Descripcion_Producto,
            p.Especificacion AS Especificacion_Producto,
            sd.IdTallas AS Identificador_Talla,
            ct.Talla AS Talla_Requisicion,
            sd.Cantidad AS Entregada
        FROM
            Salida_E se
        INNER JOIN
        	Salida_D sd ON sd.Id = se.Id_SalE
        INNER JOIN
            Producto p ON sd.IdCProd = p.IdCProducto
        INNER JOIN
            CTallas ct ON sd.IdTallas = ct.IdCTallas
        WHERE
            se.Id_SalE = ?
        ORDER BY 
            p.Descripcion;");
    
    if (!$stmtProductos) {
        throw new Exception("Error en la preparación de la consulta de productos: " . $conexion->error);
    }
    
    $stmtProductos->bind_param('i', $Id_Salida);
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
    $pdf->SetTitle('Reporte de Salida');
    $pdf->SetSubject('Reporte de Salida por ID');
    $pdf->SetMargins(10, 20, 10);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(15);
    $pdf->SetAutoPageBreak(TRUE, 15);
    $pdf->AddPage();

    // Número de Teléfono del Receptor
    $pdf->SetFont('helvetica', 'B', 14);
    // Titulo de la tabla
    $pdf->Cell(0, 10, "Reporte Requisición Salida", 0, 1, "C");
    
    // Definir el ancho de las celdas de etiqueta y contenido
    $labelWidth = 50;
    // Ajusta este valor según el tamaño del contenido y el tamaño de tu página
    $contentWidth = 150; 

    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Número de Requisición: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell($contentWidth, 7, $filaE['ID_ReqE'], 0, 1, "L");
    
    // Nombre
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Solicitante: ', 0, 0, "L");
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
    
    // Centro de Trabajo
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Centro de Trabajo: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell($contentWidth, 7, $filaE['CentroTrabajo'], 0, 1, "L");
    
    // Dirección
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Dirección: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    
    // Variable en Arreglo
    $address_parts = array();

    // Verificar y agregar partes de la dirección si no están vacías o NULL
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
        $address_parts[] = $filaE['Mpio']; // Ciudad o municipio
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
    $pdf->Cell($contentWidth, 7, $address_string, 0, 1, "L");
    
    // Entregado
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, ('Entregado: '), 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell($contentWidth, 7, $filaE['Nombre2'] . ' ' . $filaE['Apellido_Paterno2'] . ' ' . $filaE['Apellido_Materno2'], 0, 1, "L");

    // Agregar un salto de página antes de la tabla
    $pdf->Ln();

    // Título de la tabla Salida_E
    $pdf->SetFont("helvetica", "B", 14);
    $pdf->Cell(0, 10, "Productos Entregados", 0, 1, "C");

    // Estilo de la tabla 
    $pdf->SetFillColor(200, 220, 255); // Color de fondo de las celdas
    $pdf->SetFont("helvetica", "B", 9);

    // Calcular la altura de la fila más alta
    $cellHeightsEncabezado = [
        $pdf->getStringHeight(25, "Identificador"),
        $pdf->getStringHeight(55, "Descripción"),
        $pdf->getStringHeight(55, "Especificación"),
        $pdf->getStringHeight(20, "Talla"),
        $pdf->getStringHeight(35, "Cantidad Entregada")
    ];

    // Definir la altura máxima para la fila actual
    $maxHeightEncabezado = max($cellHeightsEncabezado);
    
    // Cabecera de la tabla 
    $pdf->MultiCell(25, $maxHeightEncabezado, "Identificador", 1, 'C', true, 0);
    $pdf->MultiCell(55, $maxHeightEncabezado, "Descripción", 1, 'C', true, 0);
    $pdf->MultiCell(55, $maxHeightEncabezado, "Especificación", 1, 'C', true, 0);
    $pdf->MultiCell(20, $maxHeightEncabezado, "Talla", 1, 'C', true, 0);
    $pdf->MultiCell(35, $maxHeightEncabezado, "Cantidad Entregada", 1, 'C', true, 1);

    // Agregar datos a la tabla
    $pdf->SetFont("helvetica", "", 10); // Restaurar el estilo de fuente normal
    while ($filaProducto = $resultadoProductos->fetch_assoc()) {
        // Calcular la altura de la fila más alta
        $cellHeights = [
            $pdf->getStringHeight(25, $filaProducto['Identificador_Producto']),
            $pdf->getStringHeight(55, $filaProducto['Descripcion_Producto']),
            $pdf->getStringHeight(55, $filaProducto['Especificacion_Producto']),
            $pdf->getStringHeight(20, $filaProducto['Talla_Requisicion']),
            $pdf->getStringHeight(35, $filaProducto['Entregada'])
        ];
    
        // Definir la altura máxima para la fila actual
        $maxHeight = max($cellHeights);
        
        $pdf->MultiCell(25, $maxHeight, $filaProducto['Identificador_Producto'], 1, 'C', false, 0);
        $pdf->MultiCell(55, $maxHeight, $filaProducto['Descripcion_Producto'], 1, 'C', false, 0);
        $pdf->MultiCell(55, $maxHeight, $filaProducto['Especificacion_Producto'], 1, 'C', false, 0);
        $pdf->MultiCell(20, $maxHeight, $filaProducto['Talla_Requisicion'], 1, 'C', false, 0);
        $pdf->MultiCell(35, $maxHeight, $filaProducto['Entregada'], 1, 'C', false, 1);
    }

    // Cerrar el statement de productos
    $stmtProductos->close();

    // Cerrar el statement de Salida_E
    $stmtE->close();

    // Cerrar la conexión
    $conexion->close();

    // Generar el PDF
    $pdf->Output('Reporte_Salida_Por_ID_' . date('YmdHis') . '.pdf', 'I');
    exit;
} catch (Exception $e) {
    // Si ocurre una excepción, responder con un mensaje de error en formato JSON
    header('Content-Type: application/json');
    echo json_encode(["error" => $e->getMessage()]);
}
?>