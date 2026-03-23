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
                P.Descripcion AS Descripcion, 
                P.Especificacion AS Especificacion, 
                T.Talla AS Talla, 
                SUM(I.Cantidad) AS Cantidad, 
                CE.Nombre_Empresa AS Nombre_Empresa, 
                CCA.Descrp AS Categoria 
            FROM Inventario I 
            INNER JOIN Producto P ON I.IdCPro = P.IdCProducto 
            INNER JOIN CEmpresas CE ON P.IdCEmp = CE.IdCEmpresa 
            INNER JOIN CCategorias CCA ON P.IdCCat = CCA.IdCCate 
            INNER JOIN CTipoTallas ON P.IdCTipTal = CTipoTallas.IdCTipTall 
            INNER JOIN CTallas T ON I.IdCTal = T.IdCTallas 
            WHERE I.Cantidad > 0 
            GROUP BY 
                P.IdCProducto,
                T.Talla 
            ORDER BY 
                FIELD(ANY_VALUE(CE.Nombre_Empresa), 'PRYSE', 'PRYSE/AICM', 'PRYSE/LIMP', 'PRYSE/PROTE', 'MULTISISTEMAS URIBE', 'Uribe', 'LATE') ASC,
                FIELD(ANY_VALUE(CCA.Descrp), 'Uniformes', 'Equipamiento', 'Accesorios') ASC, 
                P.Descripcion ASC, 
                P.Especificacion ASC, 
                T.Talla ASC";

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

    // Estilo de la tabla
    $pdf->SetFillColor(200, 220, 255); // Color de fondo de las celdas
    $pdf->SetFont("helvetica", "", 9);
    $html = '
        <h2 style="text-align:center; font-size:18px; color:#2c3e50;">Productos Inventario</h2>
        <table border="1" cellpadding="4">
            <thead>
                <tr style="background-color:#34495e; color:white; font-weight:bold; text-align:center;">
                    <th width="15%">Empresa</th>
                    <th width="21%">Descripción</th>
                    <th width="29%">Especificación</th>
                    <th width="13%">Categoría</th>
                    <th width="11%">Talla</th>
                    <th width="10%">Cantidad</th>
                </tr>
            </thead>
            <tbody>
    ';

    // Agregar datos a la tabla
    $pdf->SetFont("helvetica", "", 10); // Restaurar el estilo de fuente normal
    $color = true;
    while ($fila = $resultado->fetch_assoc()) {
        $fondo = $color ? '#f2f2f2' : '#ffffff';
        $color = !$color;
        $html .= '
                <tr style="background-color:'.$fondo.'; text-align:center;">
                    <td width="15%">'.$fila['Nombre_Empresa'].'</td>
                    <td width="21%">'.$fila['Descripcion'].'</td>
                    <td width="29%">'.$fila['Especificacion'].'</td>
                    <td width="13%">'.$fila['Categoria'].'</td>
                    <td width="11%">'.$fila['Talla'].'</td>
                    <td width="10%">'.$fila['Cantidad'].'</td>
                </tr>
        ';
    }

    $html .= '
            </tbody>
        </table>
    ';

    $pdf->setCellPadding(2);
    $pdf->setCellMargins(0,0,0,0);
    $pdf->SetAutoPageBreak(TRUE, 15);
    $pdf->writeHTML($html, true, false, true, false, '');
    $resultado->free(); // Liberar el resultado de la consulta
    $conexion->close(); // Cerrar la conexión a la base de datos
    ob_end_clean(); // Limpiar el búfer de salida para evitar cualquier salida no deseada
    $pdf->Output(); // Salida del PDF
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>