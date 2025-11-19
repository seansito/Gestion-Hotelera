<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// para iniciar una sesion si ya no esta iniciada


require_once "../../src/connect.php";

if (!isset($_SESSION["email"])) {
    $_SESSION["error"] = "Porfavor registrate o logeate primero.";
    header("Location: ../inicio.php");
    exit;
}

$email = $_SESSION["email"];
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    session_unset();
    session_destroy();
    session_start(); // start a new session to show messaeg
    $_SESSION["error"] = "Tu cuenta fue eliminada.";
    header("Location: ../../inicio.php");
    exit;
}
?>
