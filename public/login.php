<?php
// require "../public/includes/esUsuario.php";
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Pagina para gestionar y registrarse en el hotel Violeta Boutique">

<title>Acceso — Sistema</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../public/assets/css/login.css">

</head>

<body>

<div class="container">

  <div class="illustration">
    <img src="https://cdn-icons-png.flaticon.com/512/6012/6012913.png">
  </div>

  <!-- LOGIN -->
<form action="checkLogin.php" method="post">
  <div id="login" class="card">
    <h2>Iniciar sesión</h2>
    <p>Bienvenido de nuevo</p>

    <input id="loginEmail" placeholder="Correo electrónico" type="email" name="email" required>
    <input id="loginPass" placeholder="Contraseña" type="password" name="password" required>
 
    <div class="flex-between">
      <label class="switch">
        <input type="checkbox" id="rememberMe" name="rememberMe">
        <span class="toggle"></span>
        Recuérdame
      </label>
      <a class="link" onclick="show('forgot')">¿Olvidaste tu contraseña?</a>
    </div>

    <br>
    <button class="btn" type="submit">Entrar</button>

    <p style="text-align:center;margin-top:12px;">
      ¿No tienes cuenta? <a class="link" onclick="show('register')">Crear cuenta</a>
    </p>
  </div>
</form>
  <!-- REGISTRO -->
   <form action="checkRegistro.php" method="post">
  <div id="register" class="card hidden">
    <h2>Registro</h2>
    <p>Crea una nueva cuenta</p>
    <input id="regNombre" placeholder="Nombre" inputmode="latin" name="name" required>
    <input id="regEmail" placeholder="Correo electrónico" type="email" name="email" required>
    <input id="regPass" placeholder="Contraseña" type="password" name="password" required>
    <input id="regPass2" placeholder="Confirmar contraseña" type="password" name="passwordConfirm" required>
    <input id="regPhone" placeholder="Teléfono (ej. 099123456)" type="tel" name="telefono" required>
    <input id="regCedula" placeholder="Cédula / Documento (sólo números)" type="number" inputmode="numeric" name="cedula" required>
 <!-- error dos veces regcedula? -->

    <button class="btn" type="submit" name="register">Crear cuenta</button>
    <p style="text-align:center;margin-top:12px;">
      <a class="link" onclick="show('login')">Volver</a>
    </p>
  </div>
</form>
<form action="../src/recuperarContraseña.php" method="post">
  <!-- RECUPERAR -->

  <div id="forgot" class="card hidden">
    <h2>Recuperar acceso</h2>
    <p>Enviaremos un enlace a tu correo</p>

    <input id="forgotEmail" placeholder="Correo electrónico" type="email" name="email">
    <button class="btn" id="forgotBtn" type="submit">Enviar</button>

    <p style="text-align:center;margin-top:12px;">
      <a class="link" onclick="show('login')">Volver</a>
    </p>
  </div>

</div>
</form>

<script>

//   const forgotBtn = document.getElementById("forgotBtn");
//   console.log(forgotBtn);
// forgotBtn.addEventListener('click', ()=>{
//   fetch('../src/recuperarContraseña.php')
//   .then(response => response.json());
// })

document.getElementById("regNombre").addEventListener("input", function () {
    this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g, "");
});

function show(id){
  document.querySelectorAll('.card').forEach(e=>e.classList.add('hidden'));
  document.getElementById(id).classList.remove('hidden');
}

function login(){
  if(!loginEmail.value || !loginPass.value) return alert("Completa los campos");
  alert("✅ Inicio de sesión correcto");
}

function register(){
  if(!regEmail.value || !regPass.value || !regPass2.value || !regPhone.value || !regCedula.value)
    return alert("Completa todos los campos");
  if(regPass.value !== regPass2.value)
    return alert("Las contraseñas no coinciden");
  if(!/^[0-9]+$/.test(regPhone.value.replace(/\s+/g,'')) ) return alert('El teléfono debe contener sólo números');
  if(regPhone.value.replace(/\D/g,'').length < 6) return alert('Ingresa un teléfono válido');
  if(!/^[0-9]+$/.test(regCedula.value.replace(/\s+/g,'')) ) return alert('La cédula debe contener sólo números');
  if(regCedula.value.replace(/\D/g,'').length < 6) return alert('Ingresa una cédula válida');
  if(!acceptTerms.checked) return alert("Debes aceptar los términos");

  alert("🎉 Registro exitoso");
  show('login');
}

function recover(){
  if(!forgotEmail.value) return alert("Escribe tu correo");
  alert("📩 Correo enviado para recuperar acceso");
  show('login');
}
</script>
</body>
</html>

</html>
