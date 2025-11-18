<?php
require_once ("../src/connect.php");
require "./includes/mensajesSesion.php";

session_start();


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    

    if (isset($_SESSION["email"])) {
        $_SESSION["estado"] = "Ya estás logeado";
        header("Location: inicio.php");
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
            header("Location: inicio.php");
            exit;
        }

        if (password_verify($password, $user["contraseña"])) {


            // if (isset($_POST["rememberMe"])) {
                
            // createCookie($conn, $user_id);

            // }


            $_SESSION["username"] = $user["name"];
            $_SESSION["email"] = $email;
            $_SESSION["exito"] = "Login exitoso!";
            header("Location: inicio.php");
            exit;
        } else {
            $_SESSION["error"] = "Email o contraseña incorrecta.";
            // header("Location: inicio.php");
            // exit;
        }
    } else {
        $_SESSION["error"] = "Email no encontrado.";
        // header("Location: inicio.php");
        // exit;
    }
}


?>