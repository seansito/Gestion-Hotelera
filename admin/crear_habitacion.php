<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo "ERROR: No data received";
    exit;
}

require "../src/connect.php";

$stmt = $conn->prepare("
    INSERT INTO habitaciones
    (precio, estado, nombre_habitacion, descripcion, capacidad, tamaño, camas, wifi, ducha, desayuno, imagen)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "sisssssiiis",
    $data["precio"],
    $data["estado"],
    $data["nombre_habitacion"],
    $data["descripcion"],
    $data["capacidad"],
    $data["tamaño"],
    $data["camas"],
    $data["wifi"],
    $data["ducha"],
    $data["desayuno"],
    $data["imagen"]
);

if ($stmt->execute()) {
    echo "OK";
} else {
    echo "ERROR: " . $stmt->error;
}

$stmt->close();
$conn->close();
