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
  <link rel="stylesheet" href="../public/assets/css/login.css?v=<?php echo time(); ?>">

  <style>
    /* Responsive tweaks to make the login/register forms look good on mobile */
    :root{--card-bg:#fff;--muted:#666}
    html,body{height:100%;background:var(--bg,#f6f7fb);font-family: 'Poppins', system-ui, sans-serif;color:#222}
    .container{display:flex;align-items:center;justify-content:center;gap:28px;padding:36px;min-height:100vh;box-sizing:border-box}
    .illustration img{width:320px;height:auto;display:block}
    .card{background:var(--card-bg);border-radius:12px;padding:28px;box-shadow:0 6px 18px rgba(20,20,40,0.08);width:420px;box-sizing:border-box}
    .card h2{margin:0 0 6px 0;font-size:20px}
    .card p{color:var(--muted);margin:0 0 14px}
    input{width:100%;padding:12px 14px;border:1px solid #e6e8ef;border-radius:8px;margin:8px 0;font-size:15px;box-sizing:border-box}
    .flex-between{display:flex;align-items:center;justify-content:space-between;gap:12px}
    .link{color:var(--accent,#5b6);cursor:pointer;text-decoration:underline}
    .btn{display:inline-block;padding:12px 16px;border-radius:10px;background:var(--accent,#6b4);color:#fff;border:none;font-weight:700;cursor:pointer;width:100%;font-size:15px}
    .hidden{display:none}

    /* Small screens: stack, tighten spacing, smaller illustration */
    @media (max-width:720px){
      .container{flex-direction:column;padding:18px;gap:14px}
      .illustration img{width:120px;margin-bottom:6px}
      .card{width:100%;padding:18px;border-radius:10px}
      .card h2{font-size:18px}
      input{padding:12px;font-size:15px}
      .flex-between{flex-direction:row;align-items:center;gap:8px}
      .flex-between .switch{display:flex;align-items:center;gap:8px}
      .link{font-size:14px}
      .btn{padding:12px;font-size:15px}
    }
  </style>

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
  // send via AJAX so we can show the change-password panel immediately
  const fd = new FormData();
  fd.append('email', forgotEmail.value);
  fetch('../src/recuperarContraseña.php', {method:'POST', body: fd, headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r=>r.json())
    .then(data=>{
      if(data.status === 'ok'){
        // show notification
        alert('📩 Correo enviado. Puedes cambiar la contraseña abajo.');
        // inject and show change-password panel with token
        showChangePasswordPanel(data.token);
      } else {
        alert(data.message || 'Ocurrió un error');
      }
    })
    .catch(err=>{
      console.error(err);
      alert('Error enviando email');
    });
}

function showChangePasswordPanel(token){
  // create modal if not exists
  if(document.getElementById('changePassModal')){
    document.getElementById('changePassToken').value = token || '';
    document.getElementById('changePassModal').classList.remove('hidden');
    return;
  }
  const modal = document.createElement('div');
  modal.id = 'changePassModal';
  modal.className = '';
  modal.innerHTML = `
    <div class="card" style="max-width:420px;margin:18px auto;padding:18px;">
      <h2>Cambiar contraseña</h2>
      <p>Introduce tu nueva contraseña</p>
      <form id="changePassForm" method="POST" action="../src/nuevaContraseña.php">
        <input type="hidden" name="token" id="changePassToken" value="${token||''}">
        <input type="password" name="password" id="newPass" placeholder="Nueva contraseña" required>
        <input type="password" name="passwordConfirm" id="newPass2" placeholder="Confirmar contraseña" required>
        <button class="btn" type="submit">Confirmar</button>
      </form>
      <p style="text-align:center;margin-top:12px;"><a class="link" onclick="document.getElementById('changePassModal').classList.add('hidden')">Cerrar</a></p>
    </div>
  `;
  const container = document.querySelector('.container') || document.body;
  container.appendChild(modal);

  // intercept submit to use AJAX and show success
  document.getElementById('changePassForm').addEventListener('submit', function(e){
    e.preventDefault();
    const fd = new FormData(this);
    fetch('../src/nuevaContraseña.php', {method:'POST', body:fd, headers:{'X-Requested-With':'XMLHttpRequest'}})
      .then(r=>r.json())
      .then(res=>{
        if(res.status === 'ok'){
          alert('✅ Contraseña actualizada. Ahora puedes iniciar sesión.');
          document.getElementById('changePassModal').classList.add('hidden');
          show('login');
        } else {
          alert(res.message || 'Error al actualizar contraseña');
        }
      })
      .catch(err=>{console.error(err);alert('Error de red');});
  });
}
</script>
</html>
</body>
</html>
