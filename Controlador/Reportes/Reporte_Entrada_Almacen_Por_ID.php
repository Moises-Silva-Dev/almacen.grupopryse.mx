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
    $ID_Entrada = isset($_POST['Id_Entrada']) ? $_POST['Id_Entrada'] : null;

    // Verificar que las fechas se recibieron correctamente
    if (empty($ID_Entrada)) {
        throw new Exception("ID no recibido correctamente.");
    }

    // Consultar la base de datos para obtener la información de EntradaE
    $sqlE = "SELECT 
                EE.IdEntE, U.Nombre, U.Apellido_Paterno, U.Apellido_Materno,
                EE.Fecha_Creacion, EE.Proveedor, EE.Receptor, EE.Comentarios, EE.Estatus 
             FROM 
                EntradaE EE
             INNER JOIN 
                Usuario U ON EE.Usuario_Creacion = U.ID_Usuario
             WHERE IdEntE = ?;";

    // Preparar y ejecutar la consulta para EntradaE
    $stmtE = $conexion->prepare($sqlE);
    
    // Verificar si la consulta falla
    if (!$stmtE) {
        throw new Exception("Error en la preparación de la consulta EntradaE: " . $conexion->error);
    }
    
    // Preparar los parametros
    $stmtE->bind_param('i', $ID_Entrada);
    $stmtE->execute();
    $resultadoE = $stmtE->get_result();
    $filaE = $resultadoE->fetch_assoc();
    
    if (!$filaE) {
        throw new Exception("No se encontró información para el ID de solicitud proporcionado.");
    }
    
    // Consultar la base de datos para obtener la información de EntradaD
    $sqlD = "SELECT 
                ED.IdProd AS Identificador, P.Descripcion AS Descripcion, 
                P.Especificacion AS Especificacion, T.Talla AS Talla, 
                ED.Cantidad AS Cantidad, CEM.Nombre_Empresa AS Nombre_Empresa, 
                CCA.Descrp AS Categoria
            FROM 
                EntradaD ED 
            INNER JOIN 
                Producto P ON ED.IdProd = P.IdCProducto 
            INNER JOIN 
                CTallas T ON ED.IdTalla = T.IdCTallas 
            INNER JOIN 
                EntradaE EE ON ED.IdEntradaE = EE.IdEntE 
            INNER JOIN 
                CEmpresas CEM ON P.IdCEmp = CEM.IdCEmpresa 
            INNER JOIN 
                CCategorias CCA ON P.IdCCat = CCA.IdCCate 
            INNER JOIN 
                CTipoTallas CTT ON P.IdCTipTal = CTT.IdCTipTall 
            WHERE 
                IdEntE = ?;";
                
    // Preparar y ejecutar la consulta para EntradaD
    $stmtD = $conexion->prepare($sqlD);
    
    if (!$stmtD) {
        throw new Exception("Error en la preparación de la consulta EntradaD: " . $conexion->error);
    }
    
    $stmtD->bind_param('i', $ID_Entrada);
    $stmtD->execute();
    $resultadoD = $stmtD->get_result();
    
    // Verificar si ambos resultados están vacíos
    if ($resultadoE->num_rows === 0 && $resultadoD->num_rows === 0) {
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
    $pdf->SetTitle('Reporte de Entrada');
    $pdf->SetSubject('Reporte de Entrada por ID');
    $pdf->SetMargins(10, 20, 10);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(15);
    $pdf->SetAutoPageBreak(TRUE, 15);
    $pdf->AddPage();

    // Tipo y tamaño de letra
    $pdf->SetFont('helvetica', 'B', 14);
    // Titulo de la tabla
    $pdf->Cell(0, 10, "Reporte Entrada", 0, 1, "C");

    // Definir el ancho de las celdas de etiqueta y contenido
    $labelWidth = 50;
    // Ajusta este valor según el tamaño del contenido y el tamaño de tu página
    $contentWidth = 150;
    
    // Nombre
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Nombre: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->MultiCell($contentWidth, 7, $filaE['Nombre'] . ' ' . $filaE['Apellido_Paterno'] . ' ' . $filaE['Apellido_Materno'], 0, "L");
    
    // Fecha de Creación
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Fecha de Creación: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell($contentWidth, 7, $filaE['Fecha_Creacion'], 0, 1, "L");
    
    // Proveedor
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Nombre del Proveedor: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell($contentWidth, 7, $filaE['Proveedor'], 0, 1, "L");
    
    // Receptor
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Nombre del Receptor: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->MultiCell($contentWidth, 7, $filaE['Receptor'], 0, "L");
    
    // Comentarios
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Comentarios: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->MultiCell($contentWidth, 7, $filaE['Comentarios'], 0, "L");
    
    // Estatus
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell($labelWidth, 7, 'Estatus de Entrada: ', 0, 0, "L");
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell($contentWidth, 7, $filaE['Estatus'], 0, 1, "L");

    // Agregar un salto de página antes de la tabla de EntradaD
    $pdf->Ln();

    // Título de la tabla EntradaD
    $pdf->SetFont("helvetica", "B", 14);
    $pdf->Cell(0, 10, "Productos de Entrada Almacén", 0, 1, "C");

    // Estilo de la tabla EntradaD
    $pdf->SetFillColor(200, 220, 255); // Color de fondo de las celdas
    $pdf->SetFont("helvetica", "B", 9);
    
    // Cabecera de la tabla EntradaD
    $pdf->Cell(25, 7, "Identificador", 1, 0, "C", true);
    $pdf->Cell(30, 7, "Empresa", 1, 0, "C", true);
    $pdf->Cell(50, 7, "Descripción", 1, 0, "C", true);
    $pdf->Cell(50, 7, "Especificación", 1, 0, "C", true);
    $pdf->Cell(20, 7, "Talla", 1, 0, "C", true);
    $pdf->Cell(20, 7, "Cantidad", 1, 1, "C", true);
    
    // Agregar datos a la tabla EntradaD
    $pdf->SetFont("helvetica", "", 10); // Restaurar el estilo de fuente normal
    while ($filaD = $resultadoD->fetch_assoc()) {
        // Calcular la altura de la fila más alta
        $cellHeights = [
            $pdf->getStringHeight(50, $filaD['Nombre_Empresa']),
            $pdf->getStringHeight(50, $filaD['Descripcion']),
            $pdf->getStringHeight(50, $filaD['Especificacion']),
            $pdf->getStringHeight(50, $filaD['Talla'])
        ];
    
        // Definir la altura máxima para la fila actual
        $maxHeight = max($cellHeights);
        
        $pdf->MultiCell(25, 7, $filaD['Identificador'], 1, 'C', false, 0);
        $pdf->MultiCell(30, 7, $filaD['Nombre_Empresa'], 1, 'C', false, 0);
        $pdf->MultiCell(50, 7, $filaD['Descripcion'], 1, 'C', false, 0);
        $pdf->MultiCell(50, 7, $filaD['Especificacion'], 1, 'C', false, 0);
        $pdf->MultiCell(20, 7, $filaD['Talla'], 1, 'C', false, 0);
        $pdf->MultiCell(20, 7, $filaD['Cantidad'], 1, 'C', false, 1);
    }
    
    // Cerrar el statement de productos
    $stmtD->close();

    // Cerrar el statement de Salida_E
    $stmtE->close();
    
    // Cerrar la conexión a la base de datos
    $conexion->close();
    
    // Generar el PDF
    $pdf->Output('Reporte_Entrada_Por_ID_' . date('YmdHis') . '.pdf', 'I');
    exit;
} catch (Exception $e) {
    // Si ocurre una excepción, responder con un mensaje de error en formato JSON
    header('Content-Type: application/json');
    echo json_encode(["error" => $e->getMessage()]);
}
?>