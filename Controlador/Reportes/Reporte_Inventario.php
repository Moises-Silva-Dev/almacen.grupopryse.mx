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

    // Establecer la consulta para la tabla Inventario
    $sql = "SELECT 
                P.IdCProducto,
                P.Descripcion AS Descripcion,
                P.Especificacion AS Especificacion, 
                T.Talla AS Talla, 
                I.Cantidad AS Cantidad, 
                CE.Nombre_Empresa AS Nombre_Empresa, 
                CCA.Descrp AS Categoria 
            FROM 
                Inventario I 
            INNER JOIN 
                Producto P ON I.IdCPro = P.IdCProducto 
            INNER JOIN 
                CTallas T ON I.IdCTal = T.IdCTallas 
            INNER JOIN 
                CEmpresas CE ON P.IdCEmp = CE.IdCEmpresa 
            INNER JOIN 
                CCategorias CCA ON P.IdCCat = CCA.IdCCate 
            INNER JOIN 
                CTipoTallas ON P.IdCTipTal = CTipoTallas.IdCTipTall 
            GROUP BY 
                CE.Nombre_Empresa, P.IdCProducto, P.Descripcion, T.Talla;";

    // Ejecutar la consulta
    $resultado = $conexion->query($sql);
    
    // Verificar si la consulta tuvo éxito
    if (!$resultado) {
        throw new Exception("Error en la ejecución de la consulta: " . $conexion->error);
    }
    
    // Verificar si el resultado está vacío
    if ($resultado->num_rows === 0) {
        echo json_encode(["error " => " No hay información relacionada con la ID."]);
        exit;
    }

    // Crear un nuevo objeto PDF con orientación horizontal (Landscape)
    $pdf = new MYPDF('P', 'mm', 'LETTER');
    
    // Configuración general del PDF
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Sistema de Requisiciones');
    $pdf->SetTitle('Reporte de Solicitud');
    $pdf->SetSubject('Reporte de Solicitud por ID');
    $pdf->SetMargins(10, 20, 10);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(15);
    $pdf->SetAutoPageBreak(TRUE, 15);
    $pdf->AddPage();

    // Establecer el ancho de la tabla y centrarla
    $anchoTabla = 190; // Ajusta este valor según tus necesidades
    $margenIzquierdo = ($pdf->GetPageWidth() - $anchoTabla) / 2;
    $pdf->SetLeftMargin($margenIzquierdo);

    // Título de la tabla Salida_E
    $pdf->SetFont("helvetica", "B", 14);
    $pdf->Cell(0, 10, "Productos Inventario", 0, 1, "C");
    
    // Estilo de la tabla
    $pdf->SetFillColor(200, 220, 255); // Color de fondo de las celdas
    $pdf->SetFont("helvetica", "B", 9);
    $pdf->MultiCell(40, 7, "Nombre de la Empresa", 1, 'C', true, 0);
    $pdf->MultiCell(40, 7, "Descripción", 1, 'C', true, 0);
    $pdf->MultiCell(40, 7, "Especificación", 1, 'C', true, 0);
    $pdf->MultiCell(30, 7, "Categoria", 1, 'C', true, 0);
    $pdf->MultiCell(20, 7, "Talla", 1, 'C', true, 0);
    $pdf->MultiCell(20, 7, "Cantidad", 1, 'C', true, 1);

    // Agregar datos a la tabla
    $pdf->SetFont("helvetica", "", 10); // Restaurar el estilo de fuente normal
    while ($fila = $resultado->fetch_assoc()) {
        // Calcular la altura de la fila más alta
        $cellHeights = [
            $pdf->getStringHeight(40, $fila['Nombre_Empresa']),
            $pdf->getStringHeight(40, $fila['Descripcion']),
            $pdf->getStringHeight(40, $fila['Especificacion']),
            $pdf->getStringHeight(30, $fila['Categoria']),
            $pdf->getStringHeight(20, $fila['Talla'])
        ];
    
        // Definir la altura máxima para la fila actual
        $maxHeight = max($cellHeights);
        
        $pdf->MultiCell(40, $maxHeight, $fila['Nombre_Empresa'], 1, 'C', false, 0);
        $pdf->MultiCell(40, $maxHeight, $fila['Descripcion'], 1, 'C', false, 0);
        $pdf->MultiCell(40, $maxHeight, $fila['Especificacion'], 1, 'C', false, 0);
        $pdf->MultiCell(30, $maxHeight, $fila['Categoria'], 1, 'C', false, 0);
        $pdf->MultiCell(20, $maxHeight, $fila['Talla'], 1, 'C', false, 0);
        $pdf->MultiCell(20, $maxHeight, $fila['Cantidad'], 1, 'C', false, 1);
    }
        
    // Liberar el resultado de la consulta
    $resultado->free();

    // Cerrar la conexión a la base de datos
    $conexion->close();
    
    // Limpiar el búfer de salida para evitar cualquier salida no deseada
    ob_end_clean(); 
        
    // Salida del PDF
    $pdf->Output();
        
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>