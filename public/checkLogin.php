<?php
require_once ("../src/connect.php");


if (isset($_POST["login"])) {
    

    if (isset($_SESSION["email"])) {
        $_SESSION["estado"] = "Ya estás logeado";
        header("Location: index.php");
        exit;
    }
    
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    $stmt = $conn->prepare("SELECT id, nombre, contraseña, estado_verificacion FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();



    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user["id"];

        if ($user['estado_verificacion'] === 0) {
            $_SESSION['error'] = "Porfavor, verifica tu email antes de logearte.";
            header("Location: index.php");
            exit;
        }

        if (password_verify($password, $user["password"])) {


            // if (isset($_POST["rememberMe"])) {
                
            // createCookie($conn, $user_id);

            // }


            $_SESSION["username"] = $user["name"];
            $_SESSION["email"] = $email;
            $_SESSION["exito"] = "Login successful!";
            header("Location: index.php");
            exit;
        } else {
            $_SESSION["error"] = "Incorrect email or password.";
            header("Location: index.php");
            exit;
        }
    } else {
        $_SESSION["error"] = "Email not found.";
        header("Location: index.php");
        exit;
    }
}


?>