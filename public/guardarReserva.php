<?php
session_start();
require "../src/connect.php";

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$id_usuario = $_SESSION['id'];
$id_habitacion = $_POST['roomId'];

$fecha_inicio = $_POST['startDate'] . " 00:00:00";
$fecha_fin = $_POST['endDate'] . " 00:00:00";

// 1. Obtener precio de la habitación
$sql = "SELECT precio FROM habitaciones WHERE id = ?";
$stmt_price = $conn->prepare($sql);
$stmt_price->bind_param("i", $id_habitacion);
$stmt_price->execute();
$stmt_price->bind_result($precio_habitacion);
$stmt_price->fetch();
$stmt_price->close();

// 2. Calcular días de estancia
$inicio = new DateTime($_POST['startDate']);
$fin = new DateTime($_POST['endDate']);
$diff = $inicio->diff($fin);
$dias = $diff->days;

if ($dias < 1) $dias = 1; // opción recomendada

// 3. Calcular precio total
$precio_total = $dias * $precio_habitacion;

$estado = "confirmada";

// 4. Insertar en BD
$sql = "INSERT INTO reservas (usuario_id, habitacion_id, fecha_entrada, fecha_salida, precio_total, estado)
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iissis", $id_usuario, $id_habitacion, $fecha_inicio, $fecha_fin, $precio_total, $estado);

if ($stmt->execute()) {

    $sql_update = "UPDATE habitaciones SET estado = 0 WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $id_habitacion);
    $stmt_update->execute();
    $stmt_update->close();
    
            $_SESSION["exito"] = "Reserva exitosa!";
            header("Location: index.php");
            exit;
} else {
$_SESSION["error"] = "No se pudo realizar la reserva.";
header("Location: index.php");
exit;
}

$stmt->close();
$conn->close();
?>
