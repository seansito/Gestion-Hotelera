<?php
require_once "../src/connect.php";
require_once "../public/includes/sendEmail.php";

session_start();
//este es el codigo para registrar al usuario

if (isset($_POST["register"])) { //si el usuario hace click en el boton de register:
     $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
     $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
     $verify_token = bin2hex(random_bytes(32));

     //crea un token de verificacion y "limpia" los inputs
     
    if ($_POST["password"] == $_POST["passwordConfirm"]) { //si las dos contraseñas son iguales:
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        //guarda una variable con la contraseña hasheada
        $stmt = $conn -> prepare("SELECT email FROM users WHERE email = ?");
        $stmt -> bind_param("s", $email);
        $stmt -> execute();
        $result = $stmt->get_result(); 
    // busca en la db si hay un usuario con el email puesto en el formulario
     
        
if ($result->num_rows > 0) { //si sale mas de una fila, significa que si
    $_SESSION['error'] = "El email ya existe";
    header("Location: index.php");
    exit; //termina la ejecucion
}
        

        //si llega hasta aca, sigue la ejecucion:
        $insert = $conn -> prepare("INSERT INTO users (name, password, email, verify_token) VALUES (?, ?, ?, ?)");
        $insert -> bind_param("ssss", $username, $password, $email, $verify_token);
        $insert ->execute();
        //guarda en la tabla users los datos ingresados del formulario por el usuario

         
            sendEmailVerification("$username", "$email", "$verify_token", 1); 
            //envia un email para confirmar si el email del usuario es de el


            $_SESSION["status"] = "Verifica tu email y vuelve a logearte";
            header("Location: index.php");
            exit;
        
    }
    else  //si no es ninguna de las anteriores, significa que puso mal las dos contraseñas
    $_SESSION['error'] = "Las contraseñas no coinciden";
    header("Location: index.php");
    exit;
    }
?>