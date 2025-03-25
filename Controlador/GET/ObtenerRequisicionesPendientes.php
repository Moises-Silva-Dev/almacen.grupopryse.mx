<?php
// Incluir el archivo de conexi��n a la base de datos
include('../../Modelo/Conexion.php');

// Verificar si se ha recibido el par��metro 'id' a trav��s de GET
if (isset($_GET['id'])) {
    // Asignar el valor del par��metro 'id' a la variable $id_empleado
    $id_empleado = $_GET['id'];

    // Establecer la conexi��n a la base de datos utilizando el archivo de conexi��n
    $conexion = (new Conectar())->conexion();

    // Preparar una consulta SQL para contar las requisiciones con estatus 'Pendiente', 'Parcial' o 'Autorizado'
    $consulta = $conexion->prepare("SELECT 
                                        COUNT(REQ.IDRequisicionE) AS TotalRequisiciones
                                    FROM 
                                        RequisicionE REQ
                                    INNER JOIN 
                                        Cuenta C ON REQ.IdCuenta = C.ID
                                    INNER JOIN 
                                        Usuario U ON REQ.IdUsuario = U.ID_Usuario
                                    WHERE 
                                        REQ.Estatus IN ('Pendiente', 'Parcial', 'Autorizado')
                                    AND 
                                        U.ID_Usuario = ?");
    
    // Enlazar el par��metro recibido ($id_empleado) con la consulta preparada
    $consulta->bind_param("i", $id_empleado);
    
    // Ejecutar la consulta preparada
    $consulta->execute();
    
    // Obtener los resultados de la consulta
    $resultado = $consulta->get_result();

    // Verificar si se obtuvo un resultado de la consulta
    if ($row = $resultado->fetch_assoc()) {
        // Devolver el resultado como un JSON con el n��mero total de requisiciones
        echo json_encode(['totalRequisiciones' => $row['TotalRequisiciones']]);
    } else {
        // Si no se encuentra ning��n resultado, devolver un JSON con valor 0
        echo json_encode(['totalRequisiciones' => 0]);
    }
}
?>