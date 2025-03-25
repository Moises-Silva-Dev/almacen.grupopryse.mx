<?php
// Incluir el archivo de conexión a la base de datos
include('../../Modelo/Conexion.php'); 

// Crear una instancia de conexión a la base de datos utilizando la clase Conectar
$conexion = (new Conectar())->conexion();

// Obtener el valor de 'ID_Region' desde la solicitud POST
$region_id = $_POST['ID_Region'];

// Preparar una consulta SQL parametrizada para obtener los estados asociados a la región seleccionada
$sql = $conexion->prepare("SELECT 
                                E.Id_Estado, E.Nombre_estado 
                            FROM 
                                Estados E
                            INNER JOIN 
                                Estado_Region ER ON E.Id_Estado = ER.ID_Estados 
                            WHERE 
                                ER.ID_Regiones = ?");
                                
$sql->bind_param("i", $region_id); // Enlazar el parámetro ID de la región con el valor real
$sql->execute(); // Ejecutar la consulta preparada
$result = $sql->get_result(); // Obtener el resultado de la consulta

// Inicializar un array para almacenar los estados obtenidos
$estados = [];

// Iterar sobre el resultado de la consulta y almacenar cada estado en el array
while ($resultado = $result->fetch_assoc()) {
    $estados[] = $resultado; // Agregar cada estado al array
}

// Convertir el array de estados a formato JSON y enviarlo como respuesta
echo json_encode($estados);
?>