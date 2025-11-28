<?php
require_once "../src/connect.php";
require_once "../public/includes/enviarEmail.php";
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $stmt = $conn->prepare("SELECT token_verificacion FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result(); 

    if($result -> num_rows === 0){
        $_SESSION["estado"] = "No existe esta cuenta";
        header("Location: ../public/index.php");

    }
    else{
        $token = $result->fetch_assoc();
        // echo $token["verify_token"];

        sendEmailVerification("", $email, $token["token_verificacion"], $setTemplate = 2);
        $_SESSION["estado"] = "Email enviado! Porfavor revisa tu bandeja de entrada";
        header("Location: ../public/index.php");
    }


}


?>

<!-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
</head>
<body>
    
     <form action="" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <input type="submit" name="submit" value="Submit">
    </form>
    <h1>Introduce tu email y te enviaremos un correo para restablecer tu contraseña</h1>

</body>
</html> -->