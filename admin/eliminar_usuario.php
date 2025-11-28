<?php
require "../src/connect.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["id"])) {
    echo "ERROR: Falta el ID del usuario";
    exit;
}

$userId = intval($data["id"]);

$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);

if ($stmt->execute()) {
    echo "Usuario eliminado";
} else {
    echo "Error al eliminar: " . $conn->error;
}

$stmt->close();
$conn->close();
?>