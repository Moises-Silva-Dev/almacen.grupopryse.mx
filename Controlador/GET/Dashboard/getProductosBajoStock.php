<?php
include('../../../Modelo/Conexion.php');
session_start();

$conexion = (new Conectar())->conexion();

$sql = "SELECT COUNT(*) as total_bajos FROM inventario WHERE Cantidad < 5";
$result = $conexion->query($sql);
$row = $result->fetch_assoc();

echo json_encode(['total' => $row['total_bajos']]);

$conexion->close();
?>