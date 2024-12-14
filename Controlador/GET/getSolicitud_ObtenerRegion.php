<?php
// Incluir el archivo de conexión a la base de datos
include('../../Modelo/Conexion.php'); 

// Crear una instancia de conexión a la base de datos utilizando la clase Conectar
$conexion = (new Conectar())->conexion();

// Obtener el valor de 'ID_Cuenta' desde la solicitud POST
$cuenta_id = $_POST['ID_Cuenta'];

// Preparar una consulta SQL parametrizada para obtener las regiones asociadas a la cuenta seleccionada
$sql = $conexion->prepare("SELECT
                                R.ID_Region, R.Nombre_Region 
                            FROM 
                                Regiones R
                            INNER JOIN 
                                Cuenta_Region CR ON R.ID_Region = CR.ID_Regiones 
                            WHERE
                                CR.ID_Cuentas = ?");

$sql->bind_param("i", $cuenta_id); // Enlazar el parámetro ID de la cuenta con el valor real
$sql->execute(); // Ejecutar la consulta preparada
$result = $sql->get_result(); // Obtener el resultado de la consulta

// Inicializar un array para almacenar las regiones obtenidas
$regiones = [];

// Iterar sobre el resultado de la consulta y almacenar cada región en el array
while ($resultado = $result->fetch_assoc()) {
    $regiones[] = $resultado;
}

// Convertir el array de regiones a formato JSON y enviarlo como respuesta
echo json_encode($regiones);
?>