<?php
require "../src/connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Si vienen por POST normal (form), usar $_POST
    // Si vienen desde fetch JSON, leer php://input también
    $input = $_POST;

    if (empty($input)) {
        $input = json_decode(file_get_contents("php://input"), true);
    }

    if (!$input) {
        echo "ERROR: Datos inválidos";
        exit;
    }

    $nombre = $input["nombre"];
    $email = $input["email"];
    $password = $input["contraseña"];
    $cedula = $input["cedula"];
    $telefono = $input["telefono"];
    $estado_verificacion = $input["estado_verificacion"];  // 0 o 1
    $rol = $input["rol"];

    // Hash de contraseña (RECOMENDADO)
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Generar token aleatorio
    $token = bin2hex(random_bytes(16));
$sql = "INSERT INTO usuarios (nombre, email, contraseña, cedula, telefono, estado_verificacion, rol, token_verificacion)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssiiiss",
    $nombre,
    $email,
    $passwordHash,
    $cedula,
    $telefono,
    $estado_verificacion,
    $rol,
    $token
);


    if ($stmt->execute()) {
         $_SESSION["exito"] = "Usuario creado exitosamente";
        header("Location: panel.php");
        exit;
    } else {
        header("Location: panel.php");
        exit;

    }

    $stmt->close();
    $conn->close();
}
?>
