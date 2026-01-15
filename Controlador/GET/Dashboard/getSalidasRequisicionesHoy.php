<?php
include('../../../Modelo/Conexion.php');
session_start();

$conexion = (new Conectar())->conexion();
$hoy = date('Y-m-d');

$sql = "SELECT COUNT(*) as total_salidas FROM Salida_E WHERE DATE(FchSalidad) = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $hoy);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode(['total' => $row['total_salidas']]);

$stmt->close();
$conexion->close();
?>