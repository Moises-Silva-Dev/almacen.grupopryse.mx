<?php
include('../../../Modelo/Conexion.php');
session_start();

$conexion = (new Conectar())->conexion();
$hoy = date('Y-m-d');
$palabra = "Autorizado";

$sql = "SELECT COUNT(*) as total_requisciones_autorizadas FROM RequisicionE WHERE DATE(FchAutoriza) = ? AND Estatus = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $hoy, $palabra);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode(['total' => $row['total_requisciones_autorizadas']]);

$stmt->close();
$conexion->close();
?>