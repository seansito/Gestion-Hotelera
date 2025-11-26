<?php
session_start();
require "../src/connect.php";
if (!isset($_SESSION['email'])) {
header("Location: inicio.php");
exit();
}


$id_usuario = $_SESSION['email'];
$id_habitacion = $_POST['roomId'];

$fecha_inicio = $_POST['startDate'] . " 00:00:00";
$fecha_fin = $_POST['endDate'] . " 00:00:00";

$precio_total = 0; 
$estado = 0; 

$sql = "INSERT INTO reservas (id_usuario, id_habitacion, fecha_inicio, fecha_fin, precio_total, estado)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iissii", $id_usuario, $id_habitacion, $fecha_inicio, $fecha_fin, $precio_total, $estado);

if ($stmt->execute()) {
    header("Location: confirmacion_reserva.php");
    exit();
} else {
    echo "Error al guardar reserva: " . $conn->error;
}

$stmt->close();
$conn->close();
?>