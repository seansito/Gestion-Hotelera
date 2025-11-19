<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// to start a session if its not started yet
require_once "../src/connect.php";
function logAndCheck($conn){
    $token_hash = $_COOKIE["rememberMe"];

    $hashedToken = hash("sha256", $token_hash);
    $stmt = $conn->prepare("SELECT user_id FROM recordar_token WHERE token_hash = ? AND fecha_expiracion > NOW()");
    $stmt->bind_param("s", $hashedToken);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 1){
        $row = $result->fetch_assoc();

        $user_id = $row['user_id'];

        $userStmt = $conn->prepare("SELECT nombre, email FROM usuarios WHERE ID = ?");
        $userStmt->bind_param("i", $user_id);
        $userStmt->execute();
        $userResult = $userStmt->get_result();

        if ($userResult->num_rows === 1) {
            $user = $userResult->fetch_assoc();
            $_SESSION['username'] = $user['nombre'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['exito'] = "Logeado a traves de la cookie!";


            //update the  cookie both in the database and user's browser down here
            return true;
        }
    }

    return false;
}
    
if(isset($_COOKIE["rememberMe"]) && !isset($_SESSION["email"]) ){
        // header("Location: ../public/index.php");

    logAndCheck($conn);


}
else{
    // header("Location: ../public/index.php");
    // $_SESSION["status"] = "cookie does not exist";
}

?>