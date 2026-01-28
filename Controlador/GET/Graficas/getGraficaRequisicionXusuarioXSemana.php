<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

try {
    include('../../../Modelo/Conexion.php'); // Incluir el archivo de conexión
    $conexion = (new Conectar())->conexion(); // Establecer la conexión a la base de datos

    if ($conexion->connect_error) { // Verificar si hay un error de conexión
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    // Obtener el inicio y fin de la semana actual
    $hoy = new DateTime();
    $usuario = $_GET['idUsuario']; // Obtener el ID del usuario desde la solicitud GET
    $diaSemana = (int)$hoy->format('w'); // 0 (domingo) a 6 (sábado)
    
    // Ajustar para que la semana empiece en lunes (1) y termine en domingo (7)
    if ($diaSemana == 0) {
        $diaSemana = 7; // Domingo se convierte en 7
    }
    
    $inicioSemana = clone $hoy;
    $inicioSemana->modify('-' . ($diaSemana - 1) . ' days');
    $inicioSemana->setTime(0, 0, 0);
    
    $finSemana = clone $inicioSemana;
    $finSemana->modify('+6 days');
    $finSemana->setTime(23, 59, 59);

    // Crear array con todos los días de la semana
    $diasSemana = [];
    $diaActual = clone $inicioSemana;
    
    // Nombres de los días en español
    $nombresDias = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        7 => 'Domingo'
    ];

    // Inicializar array con todos los días de la semana
    for ($i = 1; $i <= 7; $i++) {
        $fecha = clone $inicioSemana;
        $fecha->modify('+' . ($i - 1) . ' days');
        $fechaStr = $fecha->format('Y-m-d');
        $numDia = $fecha->format('N'); // 1 (lunes) a 7 (domingo)
        
        $diasSemana[$fechaStr] = [
            'total' => 0,
            'nombre_dia' => $nombresDias[$numDia],
            'fecha_formateada' => $fecha->format('d/m')
        ];
    }

    // Consulta SQL para obtener conteos de la semana actual
    $sql = "SELECT 
                DATE(RE.FchCreacion) AS fecha,
                COUNT(*) AS total
            FROM 
                RequisicionE RE
            WHERE 
                RE.FchCreacion >= ? 
            AND 
                RE.FchCreacion <= ?
            AND
                U.Correo_Electronico = ?
            GROUP BY 
                DATE(RE.FchCreacion)
            ORDER BY 
                fecha ASC";

    $stmt = $conexion->prepare($sql); // Preparar la consulta SQL
    
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . $conexion->error);
    }

    $inicioStr = $inicioSemana->format('Y-m-d H:i:s');
    $finStr = $finSemana->format('Y-m-d H:i:s');
    
    $stmt->bind_param("sss", $usuario, $inicioStr, $finStr); // Vincular parámetros
    $stmt->execute(); // Ejecutar la consulta SQL

    $result = $stmt->get_result(); // Obtener el resultado de la consulta

    // Actualizar los conteos reales
    while ($row = $result->fetch_assoc()) {
        $fecha = $row['fecha'];
        if (isset($diasSemana[$fecha])) {
            $diasSemana[$fecha]['total'] = (int)$row['total'];
        }
    }

    // Preparar datos finales en el orden correcto de la semana
    $datos = [];
    $contador = 1;
    
    $diaIterador = clone $inicioSemana;
    for ($i = 0; $i < 7; $i++) {
        $fechaStr = $diaIterador->format('Y-m-d');
        $numDia = $diaIterador->format('N');
        
        if (isset($diasSemana[$fechaStr])) {
            $dia = $diasSemana[$fechaStr];
            $datos[] = [
                'label' => $dia['nombre_dia'] . ' (' . $dia['fecha_formateada'] . ')',
                'total' => $dia['total'],
                'dia_semana' => $dia['nombre_dia'],
                'fecha_corta' => $dia['fecha_formateada']
            ];
        }
        
        $diaIterador->modify('+1 day');
        $contador++;
    }

    // Agregar información adicional sobre la semana
    $respuesta = [
        'datos' => $datos,
        'info_semana' => [
            'semana_del' => $inicioSemana->format('d/m/Y'),
            'semana_al' => $finSemana->format('d/m/Y'),
            'semana_numero' => $inicioSemana->format('W'),
            'total_semana' => array_sum(array_column($diasSemana, 'total'))
        ]
    ];

    echo json_encode($respuesta); // Enviar los datos como respuesta en formato JSON

} catch (Exception $e) {
    http_response_code(500); // Error interno del servidor
    echo json_encode(['error' => $e->getMessage()]); 
    exit;
} finally {
    if (isset($stmt) && is_object($stmt)) {
        $stmt->close();
    }
    if (isset($conexion) && is_object($conexion)) {
        $conexion->close();
    }
}
?>