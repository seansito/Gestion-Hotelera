<?php
require_once("connect.php");
include("../public/includes/sessionMessages.php");
if(isset($_GET["token"])){
    $token = $_GET["token"];
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE token_verificacion = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $query = $result->fetch_assoc();
    // echo $query["id"];
if ($query) {

  if(isset($_POST["submit"])){
        if ($_POST["password"] === $_POST["passwordConfirm"]) {
            $newPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);

            $stmt = $conn->prepare("UPDATE usuarios SET contraseña = ? WHERE id = ?");
            $stmt->bind_param("si", $newPassword, $query["id"]);
            $stmt->execute();
            $_SESSION["exito"] = "Contraseña cambiada correctamente! Porfavor inicia sesion";
            header("Location: ../public/index.php");
            exit;   



        }
        else{
            $_SESSION["error"] = "Las contraseñas no son iguales!";
        }
    }


}
else{
    $_SESSION["estado"] = "Un error ha ocurrido. Porfavor vuelve a intentarlo.";
    header("Location: ../public/index.php");
    exit;

}

}
else{
    $_SESSION["error"] = "Acceso invalido.";
    header("Location: ../public/index.php");
    exit;
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
   
    
<div class="login-modal" id="login-modal">
  <div class="login-container">

     <form class="login-form" id="form-login" autocomplete="off" action="" method="POST">
      <h2>Pon tu nueva contraseña:</h2>
      <input type="password" placeholder="Contraseña" name="password" required>
      <input type="password" placeholder="Confirmar contraseña" name="passwordConfirm" required>
      <button type="submit" name="submit" class="login-btn-main">Confirmar</button>
    </form>

  </div>
</div>

</body>
</html>
<style>
    :root{
    --color-pen: #040529;
    --color-pen-0:#0D194B;
    --color-pen-1:#19386D;
    --color-pen-2:#2A6190;
    --color-pen-3:#4091B2;
    --color-pen-4:#59C6D4;
    --color-pen-5:#77F7F0;
}
body{
    background: var(--color-pen);
}
    .login-modal {
  display: flex;
  position: fixed;
  z-index: 2000;
  left: 0; top: 0; width: 100vw; height: 100vh;
  background: rgba(20,24,40,0.92);
  justify-content: center;
  align-items: center;
  animation: modal-fade-in 0.4s;
}
.login-modal.active {
  display: flex;
}
.login-container {
  background: linear-gradient(120deg,var(--color-pen) 60%, var(--color-pen-5) 100%);
  color: #fff;
  border-radius: 22px;
  padding: 38px 32px 28px 32px;
  min-width: 320px;
  max-width: 95vw;
  box-shadow: 0 8px 32px #000a;
  text-align: center;
  position: relative;
  animation: modal-fade-in 0.4s;
  width: 350px;
}
@keyframes modal-fade-in {
  from { transform: scale(0.8); opacity: 0;}
  to { transform: scale(1); opacity: 1;}
}
.login-form {
  display: flex;
  flex-direction: column;
  gap: 14px;
  animation: fade-form 0.4s;
}
@keyframes fade-form {
  from { opacity: 0; transform: translateY(20px);}
  to { opacity: 1; transform: none;}
}
.login-form.hidden {
  display: none;
}
.login-form h2 {
  margin-bottom: 8px;
  font-size: 1.3rem;
  font-weight: 900;
  letter-spacing: 1px;
  color: var(--color-pen-5);
  text-shadow: 0 2px 12px var(--color-pen-3);
}
.login-form input {
  padding: 12px 14px;
  border-radius: 10px;
  border: none;
  background: #fff;
  color: #23263a;
  font-size: 1rem;
  margin-bottom: 2px;
  outline: none;
  box-shadow: 0 2px 8px #23263a22;
  transition: box-shadow 0.2s;
}
.login-form input:focus {
  box-shadow: 0 4px 16px var(--color-pen-5);
}
.login-btn-main {
  background: linear-gradient(90deg, var(--color-pen-3) 60%, var(--color-pen-4) 100%);
  color: #082065;
  font-weight: 900;
  border: none;
  border-radius: 10px;
  padding: 12px 0;
  font-size: 1.08rem;
  cursor: pointer;
  margin-top: 6px;
  box-shadow: 0 2px 8px var(--color-pen-3);
  transition: background 0.3s, color 0.3s, transform 0.2s;
}
.login-btn-main:hover {
  background: linear-gradient(90deg, var(--color-pen-3) 20%, var(--color-pen-5) 100%);
  color: #114d94;
  transform: scale(1.04);
}
.login-link {
  color: var(--color-pen-4);
  font-size: 0.98rem;
  text-decoration: underline;
  margin-top: 2px;
  transition: color 0.2s;
}
.login-link:hover {
  color: #fff;
}
.login-switch {
  display: flex;
  justify-content: center;
  gap: 12px;
  margin-top: 22px;
}
h-btn {
  background: var(--color-pen-3);
  color: #082065;
  border: none;
  border-radius: 14px;
  padding: 10px 28px;
  font-size: 1.08rem;
  font-weight: 800;
  cursor: pointer;
  transition: background 0.3s, color 0.3s;
  outline: none;
}
.switch-btn.active, .switch-btn:hover {
  background: var(--color-pen-4);
  color: #fff;
}
.login-close {
  position: absolute;
  top: 12px; right: 18px;
  font-size: 2rem;
  color: var(--color-pen-3);
  cursor: pointer;
  font-weight: bold;
  transition: color 0.2s;
}
.login-close:hover {
  color: var(--color-pen-5);
}
@media (max-width: 500px) {
  .login-container {
    min-width: 0;
    width: 96vw;
    padding: 18px 4vw 18px 4vw;
  }
}
</style>