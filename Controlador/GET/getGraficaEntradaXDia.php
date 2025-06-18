<?php
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

try {
    include('../../Modelo/Conexion.php'); // Incluir el archivo de conexión para establecer la conexión con la base de datos
    $conexion = (new Conectar())->conexion(); // Establecer la conexión a la base de datos

    if ($conexion->connect_error) { // Verificar si hay un error de conexión
        // Si hay un error de conexión, lanzar una excepción
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    // Generar días del mes actual
    $fecha_inicio = date('Y-m-01'); // Primer día del mes actual
    $fecha_fin = date('Y-m-t'); // Último día del mes actual
    $fechas = []; // Array para almacenar las fechas del mes actual

    $dia = new DateTime($fecha_inicio); // Crear un objeto DateTime para el primer día del mes
    $fin = new DateTime($fecha_fin); // Crear un objeto DateTime para el último día del mes

    while ($dia <= $fin) { // Iterar a través de los días del mes
        $fechas[$dia->format('Y-m-d')] = 0; // inicializar en 0
        $dia->modify('+1 day'); // Avanzar al siguiente día
    }

    // Consulta SQL para obtener conteos reales
    $sql = "SELECT 
                DATE(EE.Fecha_Creacion) AS fecha,
                COUNT(*) AS total
            FROM 
                EntradaE EE
            WHERE 
                MONTH(EE.Fecha_Creacion) = MONTH(NOW())
            AND 
                YEAR(EE.Fecha_Creacion) = YEAR(NOW())
            GROUP BY 
                DATE(EE.Fecha_Creacion)";

    $stmt = $conexion->prepare($sql); // Preparar la consulta SQL

    $stmt->execute(); // Ejecutar la consulta SQL

    $result = $stmt->get_result(); // Obtener el resultado de la consulta

    while ($row = $result->fetch_assoc()) { // Recorrer los resultados de la consulta
        $fechas[$row['fecha']] = (int)$row['total']; // Asignar el total de requisiciones al día correspondiente
    }

    // Preparar datos finales
    $datos = []; // Array para almacenar los datos
    $contador = 1; // Contador para los días del mes

    foreach ($fechas as $fecha => $total) { // Iterar a través de las fechas y totales
        $datos[] = [
            'label' => "Day $contador", // Etiqueta para el día
            'total' => $total // Total de requisiciones para ese día
        ];
        $contador++; // Incrementar el contador
    }

    echo json_encode($datos); // Enviar los datos como respuesta en formato JSON

} catch (Exception $e) {
    http_response_code(500); // Establecer el código de estado HTTP a 500 (Error interno del servidor)
    echo json_encode(['error' => $e->getMessage()]); // 
    exit; // Enviar un mensaje de error en formato JSON y salir del script
} finally {
    $stmt->close(); // Cerrar la consulta preparada
    $conexion->close(); // Cerrar la conexión a la base de datos
}
?>