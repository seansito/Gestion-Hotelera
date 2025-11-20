<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Perfil de Usuario — Demo</title>
  <link rel="stylesheet" href="../public/assets/css/inicio.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    /* Use the same palette tokens as `inicio.css` to keep colors and animations consistent */
    :root{
      --accent: #b79c65;
      --accent-dark: #9c854f;
      --img-ring: rgba(156,133,79,0.12);
      --img-ring-strong: rgba(156,133,79,0.20);
      --text: #1b1b1b;
      --text-muted: #5f5f5f;
      --bg-light: #faf8f6;
      --white: #ffffff;
      --radius: 12px;
      --shadow: 0 8px 25px rgba(0,0,0,0.08);
      --transition: all 0.3s ease;
      --topbar-height: 42px;
      --navbar-height: 64px;
      /* compatibility with existing us.html styles */
      --bg: var(--bg-light);
      --muted: var(--text-muted);
      --card: var(--white);
      --sidebar: linear-gradient(180deg,#7a5f34,#5b4729);
    }
    *{box-sizing:border-box}
    body{margin:0;background:linear-gradient(180deg,var(--bg),#eef3fb);min-height:100vh;color:#172033;padding-top:calc(var(--topbar-height) + var(--navbar-height));}

    /* Layout */
    .app{display:flex;gap:24px;padding:28px;align-items:flex-start}
    .sidebar{width:220px;background:linear-gradient(180deg,var(--sidebar),#5675d7);border-radius:16px;padding:20px;color:#fff;box-shadow:0 6px 20px rgba(31,45,80,0.12);position:sticky;top:28px;height:calc(100vh - 56px)}
    .brand{display:flex;gap:12px;align-items:center;margin-bottom:18px}
    .brand .logo{width:44px;height:44px;border-radius:10px;background:rgba(255,255,255,0.12);display:grid;place-items:center;font-weight:700}
    .nav{display:flex;flex-direction:column;gap:8px;margin-top:6px}
    .nav button{background:transparent;border:none;color:rgba(255,255,255,0.95);text-align:left;padding:10px;border-radius:10px;cursor:pointer;display:flex;gap:12px;align-items:center}
    .nav button.active{background:rgba(255,255,255,0.08)}
    .upgrade{margin-top:auto;background:linear-gradient(180deg,#7fb2ff,#4b86f0);padding:12px;border-radius:12px;color:#fff;text-align:center;box-shadow:0 6px 18px rgba(75,134,240,0.22)}

    /* Main */
    .main{flex:1}
    .header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
    .header h1{margin:0;font-size:20px}
    .actions{display:flex;gap:8px}
    .btn{padding:8px 12px;border-radius:10px;border:none;cursor:pointer}
    .btn.primary{background:var(--accent);color:#fff;box-shadow:0 6px 16px rgba(91,141,239,0.18)}
    .btn.ghost{background:transparent;border:1px solid #dbe6ff}

    .grid{display:grid;grid-template-columns:360px 1fr;gap:18px}

    /* Cards */
    .card{background:var(--card);border-radius:12px;padding:16px;box-shadow:0 8px 24px rgba(30,45,80,0.06);transition:transform .28s,box-shadow .28s}
    .card:hover{transform:translateY(-6px)}
    .profile-img{width:86px;height:86px;border-radius:14px;overflow:hidden;background:linear-gradient(180deg,var(--accent),#7cb1ff);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700}
    .profile-row{display:flex;gap:12px;align-items:center}

    .muted{color:var(--muted);font-size:13px}
    .info-list{display:flex;flex-direction:column;gap:6px;margin-top:10px}
    .info-item{display:flex;justify-content:space-between;align-items:center;padding:8px 10px;border-radius:8px;background:linear-gradient(180deg,rgba(99,131,238,0.04),rgba(99,131,238,0.02));}

    /* Tabs */
    .tabs{display:flex;border-bottom:1px solid #eef3fb;gap:8px;padding-bottom:10px}
    .tabs button{background:transparent;border:none;padding:8px 12px;border-radius:8px;cursor:pointer}
    .tabs button.active{background:var(--accent);color:#fff}

    .section{margin-top:12px}

    /* Reservation list */
    .reservation{display:flex;justify-content:space-between;align-items:center;padding:12px;border-radius:10px;border:1px solid #eef3fb}
    .pill{padding:6px 8px;border-radius:999px;font-size:12px}
    .pill.scheduled{background:rgba(107, 196, 255, 0.12);color:#2a7fbf}
    .pill.cancel{background:#ffdede;color:#b33}

    /* Right column */
    .file-item{display:flex;justify-content:space-between;align-items:center;padding:8px;border-radius:8px}

    /* Editable form */
    .editable input,.editable select{width:100%;padding:8px;border-radius:8px;border:1px solid #e6eefc}
    .field{display:flex;flex-direction:column;gap:6px}
    .field.inline{flex-direction:row;gap:12px}

    /* Modal */
    .modal{position:fixed;inset:0;display:grid;place-items:center;background:linear-gradient(0deg,rgba(7,15,35,0.48),rgba(7,15,35,0.48));visibility:hidden;opacity:0;transition:visibility 0s .28s,opacity .28s}
    .modal.open{visibility:visible;opacity:1;transition:opacity .28s}
    .modal .dialog{background:#fff;border-radius:12px;padding:18px;width:420px;box-shadow:0 10px 40px rgba(17,24,39,0.28)}

    /* small screens */
    @media (max-width:1000px){
      .grid{grid-template-columns:1fr;}
      .sidebar{display:none}
    }

    /* Additional responsive tweaks for smaller screens */
    @media (max-width:700px){
      .app{padding:16px;gap:12px}
      .header{flex-direction:column;align-items:flex-start;gap:10px}
      .header h1{font-size:18px}
      .actions{width:100%;display:flex;justify-content:space-between}
      .btn-nav{padding:6px 10px;font-size:14px}
      .btn-nav .user-icon{width:28px;height:28px;font-size:14px;margin-right:6px}
      .btn-nav.show-icon{padding:4px;border-radius:50%}
      .profile-row{flex-direction:row;gap:10px}
      .profile-img{width:72px;height:72px}
      .profile-img img{width:72px;height:72px}
      .grid{grid-template-columns:1fr}
      .card{padding:12px}
      .nav{flex-direction:row;gap:6px}
      .nav button{padding:8px}
      .topbar .container{padding:0 12px}
      .navbar{padding:10px 16px}
      /* ensure tabs and reservation blocks are stacked nicely */
      .tabs{flex-wrap:wrap}
      .reservation{flex-direction:column;align-items:flex-start;gap:8px}
    }

    /* Mobile navigation: show hamburger and adapt menu into a full-width panel */
    @media (max-width:850px){
      .nav-toggle{display:block}
      .main-nav{display:none;position:fixed;left:0;right:0;top:calc(var(--topbar-height) + var(--navbar-height));background:var(--white);padding:16px;flex-direction:column;gap:12px;z-index:1300;border-top:1px solid rgba(0,0,0,0.04);transform:translateY(-8px);opacity:0;transition:transform .22s ease,opacity .22s ease}
      .main-nav.open{display:flex;transform:translateY(0);opacity:1}
      .main-nav ul{flex-direction:column;gap:8px}
      .main-nav a{display:block;padding:10px 6px;border-radius:8px}
      /* ensure the access button stays visible on mobile and fits the header */
      .btn-nav{padding:6px 10px}
    }

    /* micro animations */
    .fade-in{animation:fadeIn .6s ease both}
    @keyframes fadeIn{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:none}}
    /* User icon for Acceder button */
    .btn-nav .user-icon{display:none;margin-right:8px;width:20px;height:20px;border-radius:50%;background:#fff;color:var(--accent);display:inline-flex;align-items:center;justify-content:center;font-size:12px}
    .btn-nav .btn-label{display:inline}
    /* when .show-icon is set, hide the label and show the icon only */
    .btn-nav.show-icon .user-icon{display:inline-flex}
    .btn-nav.show-icon .btn-label{display:none}
    .btn-nav.show-icon{display:inline-flex;align-items:center;gap:8px; background:transparent !important; border:none !important; box-shadow:none !important; padding:6px 8px !important}
  </style>
</head>
<body>
  <!-- TOPBAR (shared with inicio) -->
  <div class="topbar">
    <div class="container">
      <span>📞 +598 99 772 500 | 📧 violetahotelboutique@gmail.com</span>
      <span>📍 Dr. Luis Alberto de Herrera 438, Artigas</span>
    </div>
  </div>

  <!-- NAVBAR (shared with inicio) -->
    <header class="navbar">
    <div class="logo">Hotel Violeta <span>Boutique</span></div>
    <button class="nav-toggle" aria-expanded="false" aria-label="Abrir menú">
      <span class="hamburger"></span>
    </button>
    <nav class="main-nav" aria-label="Navegación principal">
      <ul>
        <li><a href="/rooms.html">Habitaciones</a></li>
        <li><a href="#">Galería</a></li>
        <li><a href="/contact.html">Contacto</a></li>
      </ul>
    </nav>
    <a id="accessBtn" href="/login.html" class="btn-nav"><span class="btn-label">Acceder</span></a>
  </header>
  <div class="app">
    <aside class="sidebar fade-in">
      <!-- Sidebar brand and default patient nav removed as requested -->
      <nav class="nav">
        <!-- Sidebar navigation intentionally left empty -->
      </nav>
    </aside>

    <main class="main">
      <div class="header">
        <h1>Perfil del cliente</h1>
        <div class="actions">
          <button class="btn ghost" onclick="openModal('passwordModal')">Cambiar contraseña</button>
          <button class="btn primary" id="editToggle">Cerrar sesión</button>
        </div>
      </div>

      <div class="grid">
        <!-- LEFT -->
        <section class="card">
          <div class="profile-row">
            <div class="profile-img" id="profileImgContainer">
              <img id="avatarImg" alt="avatar" style="display:none; width:86px; height:86px; border-radius:14px; object-fit:cover;" />
              <div id="avatarInitials" style="width:86px;height:86px;border-radius:14px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;background:var(--accent)">KF</div>
            </div>
            <!-- hidden file input for avatar upload -->
            <input id="avatarInput" type="file" accept="image/*" style="display:none" />
            <div>
              <div style="font-weight:700;font-size:16px">Kate Prokopchuk</div>
              <div class="muted">+30 098 23 45 678</div>
              <div class="muted">katep@example.com</div>
            </div>
          </div>

          <div class="section">
            <div class="tabs">
              <button class="active" data-tab="future">Visitas</button>
              <button data-tab="history">Historial</button>
            </div>

            <div id="tabContent">
              <div id="future" class="tabpane">
                <div class="reservation" style="margin-top:10px">
                  <div>
                    <div style="font-weight:700">Habitación: Suite</div>
                    <div class="muted">Fecha de inicio: 2025-02-26</div>
                    <div class="muted">Fecha de finalización: 2025-02-26</div>
                  </div>
                  <!-- Estado eliminado: 'Confirmada' removed per request -->
                  </div>

                <div class="reservation" style="margin-top:10px">
                  <div>
                    <div style="font-weight:700">Habitación: Doble</div>
                    <div class="muted">Fecha de inicio: 2025-03-03</div>
                    <div class="muted">Fecha de finalización: 2025-03-03</div>
                  </div>
                  <!-- Estado eliminado: 'Pendiente' removed per request -->
                  </div>
              </div>

              <div id="history" class="tabpane" style="display:none">
                <div class="reservation" style="margin-top:10px">
                  <div>
                    <div style="font-weight:700">05 Ene 2025</div>
                    <div class="muted">Habitación: Simple — Factura disponible</div>
                  </div>
                  <div><button class="btn" onclick="downloadPDF('factura-05-01-2025.pdf')">Descargar</button></div>
                </div>
              </div>

              <!-- Se eliminó la pestaña y contenido de 'Pagos' según requerimiento del proyecto -->
            </div>
          </div>

        </section>

        <!-- CENTER -->
        <section class="card" id="centerCard">
          <div style="display:flex;justify-content:space-between;align-items:center">
            <div style="font-weight:700">Información General</div>
            <div class="muted">Registrado: 23 Jul 2020</div>
          </div>

          <div class="info-list">
            <div class="info-item field inline">
              <div style="flex:1">
                <label class="muted">Nombre completo</label>
                <div id="fullName" style="padding:8px 6px">Kate Prokopchuk</div>
              </div>
              <div style="width:140px">
                <label class="muted">DNI / Pasaporte</label>
                <div id="doc" style="padding:8px 6px">A1234567</div>
              </div>
            </div>

            <div class="info-item field inline">
              <div style="flex:1">
                <label class="muted">Correo</label>
                <div id="email" style="padding:8px 6px">katep@example.com</div>
              </div>
              <div style="width:140px">
                <label class="muted">Teléfono</label>
                <div id="phone" style="padding:8px 6px">+30 098 23 45 678</div>
              </div>
            </div>

            <div class="info-item field">
              <label class="muted">Dirección</label>
              <div id="address" style="padding:8px 6px">Lehr, Chernoblyv street, 67</div>
            </div>

            <div class="info-item field inline">
              <div>
                <label class="muted">Fecha de nacimiento</label>
                <div id="dob" style="padding:8px 6px">1994-07-23</div>
              </div>
            </div>

            <div class="info-item field">
              <label class="muted">Notas</label>
              <div id="notes" rows="3" style="width:100%;padding:8px;border-radius:8px;border:1px solid #eef6ff">Paciente alérgica a la penicilina</div>
            </div>

            <!-- Información general: no editable según configuración del panel -->
          </div>

          <div class="section editable">
            <div style="display:flex;justify-content:space-between;align-items:center">
              <div style="font-weight:700">Seguridad</div>
              <div class="muted">Actividad reciente</div>
            </div>
            <div style="margin-top:8px" class="muted">Último login: 2025-02-12 — IP 192.168.1.12</div>
            <!-- Seguridad: opciones removidas según petición (2FA y verificación por email) -->
          </div>

        </section>

        <!-- RIGHT column removed as requested -->

      </div>

    </main>
  </div>

  <!-- Modal: change password -->
  <div id="passwordModal" class="modal" role="dialog" aria-hidden="true">
    <div class="dialog">
      <h3>Cambiar contraseña</h3>
      <div style="margin-top:10px" class="field">
        <input id="currentPwd" placeholder="Contraseña actual" type="password">
        <input id="newPwd" placeholder="Nueva contraseña" type="password">
        <input id="confirmPwd" placeholder="Confirmar nueva contraseña" type="password">
      </div>
      <div style="display:flex;gap:8px;margin-top:12px;justify-content:flex-end">
        <button class="btn" onclick="closeModal('passwordModal')">Cancelar</button>
        <button class="btn primary" onclick="changePassword()">Guardar</button>
      </div>
    </div>
  </div>

  <!-- FOOTER (shared with inicio) -->
  <footer class="footer">
    <div class="footer-content">
      <div>
        <h3>Hotel Violeta Boutique</h3>
        <p>Dr. Luis Alberto de Herrera 438, Artigas</p>
        <p>📞 +598 99 772 500</p>
        <p>📧 violetahotelboutique@gmail.com</p>
      </div>
      <div>
        <h3>Enlaces</h3>
        <a href="/contact.html">Contacto</a><br>
        <a href="/rooms.html">Habitaciones</a><br>
        <a href="#">Galería</a>
      </div>
      <div>
        <h3>Redes</h3>
        <a href="#">Instagram</a><br>
        <a href="#">WhatsApp</a>
      </div>
    </div>
    <p class="copy">© 2025 Hotel Violeta Boutique | Todos los derechos reservados</p>
  </footer>

  <script src="inicio/inicio2.js"></script>

  <script>
    // Tabs
    document.querySelectorAll('.tabs button').forEach(b=>b.addEventListener('click',e=>{
      document.querySelectorAll('.tabs button').forEach(x=>x.classList.remove('active'))
      e.currentTarget.classList.add('active')
      const t=e.currentTarget.dataset.tab
      document.querySelectorAll('.tabpane').forEach(p=>p.style.display='none')
      document.getElementById(t).style.display='block'
    }))

    // Modal helpers
    function openModal(id){document.getElementById(id).classList.add('open')}
    function closeModal(id){document.getElementById(id).classList.remove('open')}

    function changePassword(){
      const a=document.getElementById('newPwd').value
      const b=document.getElementById('confirmPwd').value
      if(!a||!b){alert('Rellena los campos');return}
      if(a!==b){alert('Las contraseñas no coinciden');return}
      alert('Contraseña actualizada (demo)')
      closeModal('passwordModal')
      document.getElementById('currentPwd').value=''
      document.getElementById('newPwd').value=''
      document.getElementById('confirmPwd').value=''
    }

    // Logout button (replacing the previous Edit toggle). Performs a demo logout.
    const logoutBtn = document.getElementById('editToggle')
    if(logoutBtn){
      logoutBtn.addEventListener('click', ()=>{
        if(confirm('¿Cerrar sesión ahora?')){
          // Demo behaviour: clear demo profile and show message
          try{ localStorage.removeItem('profileDemo') }catch(e){}
          alert('Sesión cerrada (demo)')
          // In a real app redirect to login page here
        }
      })
    }

    // initially disable editable fields (security section will be disabled by default)
    document.querySelectorAll('.editable input, .editable textarea, .editable select').forEach(i=>i.disabled=true)

    // Save/Load to localStorage (demo)
    function getElementValueById(id){
      const el = document.getElementById(id)
      if(!el) return ''
      // checkbox
      if(el.type === 'checkbox') return el.checked
      // inputs / selects / textareas
      if(el.tagName === 'IMG') return el.src || ''
      if('value' in el && el.tagName !== 'DIV') return el.value
      // plain text divs
      return el.textContent.trim()
    }

    function setElementValueById(id, value){
      const el = document.getElementById(id)
      if(!el) return
      if(el.type === 'checkbox') { el.checked = !!value; return }
      if(el.tagName === 'IMG') { if(value) { el.src = value; el.style.display='block'; const init=document.getElementById('avatarInitials'); if(init) init.style.display='none'; } else { el.removeAttribute('src'); el.style.display='none'; const init=document.getElementById('avatarInitials'); if(init) init.style.display='flex'; } return }
      if('value' in el && el.tagName !== 'DIV') { el.value = value; return }
      el.textContent = value
    }

    function saveProfile(){
      const data={
        fullName:getElementValueById('fullName'),
        doc:getElementValueById('doc'),
        email:getElementValueById('email'),
        phone:getElementValueById('phone'),
        address:getElementValueById('address'),
        dob:getElementValueById('dob'),
        notes:getElementValueById('notes'),
        avatar:getElementValueById('avatarImg')
      }
      localStorage.setItem('profileDemo',JSON.stringify(data))
      alert('Perfil guardado (demo)')
      editing=false
      document.querySelectorAll('.editable input, .editable textarea, .editable select').forEach(i=>i.disabled=true)
    }

    function loadProfile(){
      const raw=localStorage.getItem('profileDemo')
      if(!raw) return
      const data=JSON.parse(raw)
      Object.keys(data).forEach(k=>{ setElementValueById(k, data[k]) })
    }
    function resetForm(){ if(confirm('Revertir cambios?')) loadProfile() }

    function downloadPDF(name){
      alert('Demo: descargar '+name)
    }

    // small UX: enable pointer for inputs when editing
    document.addEventListener('click',e=>{
      if(e.target.tagName==='INPUT'&&e.target.disabled){
        alert('Activa modo editar para modificar los campos')
      }
    })

    // Avatar upload handling: click avatar to open file picker
    const avatarContainer = document.getElementById('profileImgContainer')
    const avatarInput = document.getElementById('avatarInput')
    const avatarImg = document.getElementById('avatarImg')
    const avatarInit = document.getElementById('avatarInitials')
    if(avatarContainer && avatarInput){
      avatarContainer.style.cursor = 'pointer'
      avatarContainer.addEventListener('click', ()=> avatarInput.click())
      avatarInput.addEventListener('change', (ev)=>{
        const f = ev.target.files && ev.target.files[0]
        if(!f) return
        const reader = new FileReader()
        reader.onload = function(evt){
          const dataUrl = evt.target.result
          // set image and persist
          if(avatarImg){ avatarImg.src = dataUrl; avatarImg.style.display='block' }
          if(avatarInit) avatarInit.style.display='none'
          // save immediately
          const raw = localStorage.getItem('profileDemo') || '{}'
          const obj = JSON.parse(raw)
          obj.avatar = dataUrl
          localStorage.setItem('profileDemo', JSON.stringify(obj))
        }
        reader.readAsDataURL(f)
      })
    }

      // Acceder button: show/hide user icon when clicked
      (function(){
        const accessBtn = document.getElementById('accessBtn')
        if(!accessBtn) return
        // create icon element (hidden by default via CSS)
        const icon = document.createElement('span')
        icon.className = 'user-icon'
        icon.textContent = '👤'
        // insert icon before the text
        accessBtn.insertBefore(icon, accessBtn.firstChild)
        accessBtn.addEventListener('click', function(e){
          e.preventDefault();
          // toggle showing only the user icon and hide the label
          accessBtn.classList.toggle('show-icon')
        })
      })()

    // initialize
    loadProfile()
  </script>
</body>
</html>
