<?php
require "../src/connect.php";
require "../public/includes/enviarEmail.php";
session_start();
//este es el codigo para registrar al usuario

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

if($_SERVER['REQUEST_METHOD'] == 'POST'){ //si el usuario hace click en el boton de register:
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $telefono = filter_input(INPUT_POST, "telefono", FILTER_SANITIZE_SPECIAL_CHARS);
    $cedula = filter_input(INPUT_POST, "cedula", FILTER_SANITIZE_SPECIAL_CHARS);
    $verify_token = bin2hex(random_bytes(32));

     //crea un token de verificacion y "limpia" los inputs
     
    if ($_POST["password"] == $_POST["passwordConfirm"]) { //si las dos contraseñas son iguales:
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        //guarda una variable con la contraseña hasheada
        $stmt = $conn -> prepare("SELECT email FROM usuarios WHERE email = ?");
        $stmt -> bind_param("s", $email);
        $stmt -> execute();
        $result = $stmt->get_result(); 
    // busca en la db si hay un usuario con el email puesto en el formulario
     
        
if ($result->num_rows > 0) { //si sale mas de una fila, significa que si
    $_SESSION['error'] = "El email ya existe";
    header("Location: inicio.php");
    exit; //termina la ejecucion
}
        

        //si llega hasta aca, sigue la ejecucion:
        $insert = $conn -> prepare("INSERT INTO usuarios (nombre, email, contraseña, telefono, cedula, token_verificacion) VALUES (?, ?, ?, ?, ?, ?)");
        $insert -> bind_param("sssiis", $name, $email, $password, $telefono, $cedula, $verify_token);
        $insert ->execute();
        //guarda en la tabla usuarios los datos ingresados del formulario por el usuario

         
            sendEmailVerification("$name", "$email", "$verify_token", 1); 
            //envia un email para confirmar si el email del usuario es de el


            $_SESSION["estado"] = "Verifica tu email y vuelve a logearte";
            header("Location: inicio.php");
            exit;
        
    }
    else  //si no es ninguna de las anteriores, significa que puso mal las dos contraseñas
    $_SESSION['error'] = "Las contraseñas no coinciden";
    header("Location: inicio.php");
    exit;
    }
?>