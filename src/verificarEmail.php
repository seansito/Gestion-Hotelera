<?php

session_start();
require("connect.php");
if (isset($_GET["token"])) {
    $token = $_GET["token"];
    $verifyQuery = $conn-> prepare("SELECT token_verificacion,estado_verificacion FROM usuarios WHERE token_verificacion = ? LIMIT 1");
    $verifyQuery ->bind_param("s", $token);
    $verifyQuery ->execute();

    $result = $verifyQuery->get_result();
    if ($result->num_rows >0) {
        $row = $result-> fetch_array();
        // echo $row['verify_token'];
        if ($row['estado_verificacion'] === 0) {
            $clicked_token = $row['token_verificacion'];
            $update_query = $conn->prepare("UPDATE usuarios SET estado_verificacion='1' WHERE token_verificacion= ? LIMIT 1");
            $update_query ->bind_param("s", $clicked_token);
            $update_query ->execute();

            if($update_query){
                $_SESSION["exito"] = "Tu cuenta ha sido verificada!";
                 echo "<div class='exito'>{$_SESSION['exito']}</div>";


            }
            else{
                $_SESSION["error"] = "Verificación fallida";
                echo "<div class='error'>{$_SESSION['error']}</div>";

            }


        }

    }
    else{
          $_SESSION["error"] = "Este token no existe";
            echo "<div class='error'>{$_SESSION['error']}</div>";

        //   header("Location: index.php");
    }
}


else{
    $_SESSION["error"] = "No permitido";
     echo "<div class='error'>{$_SESSION['error']}</div>";

    // header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <style>
        body{
            background-color: rgb(25, 27, 25);
        }
        
        .error, .exito{
            color: white;
        }
    </style>
    
</body>
</html>