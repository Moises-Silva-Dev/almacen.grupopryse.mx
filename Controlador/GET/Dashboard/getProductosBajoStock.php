<?php
include('../../../Modelo/Conexion.php');
session_start();

$conexion = (new Conectar())->conexion();
$status = 'Pendiente';

$sql = "SELECT COUNT(*) as total_requisiciones_pendientes FROM RequisicionE RE WHERE RE.Estatus = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $status);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode(['total' => $row['total_requisiciones_pendientes']]);

$conexion->close();
?>