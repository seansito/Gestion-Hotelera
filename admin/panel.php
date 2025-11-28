<?php
require "../src/connect.php";
session_start();
$sql = "SELECT * FROM usuarios";
$resultado = $conn->query($sql);
$sqlTokens = "SELECT * FROM recordar_token";
$resultadoTokens = $conn->query($sqlTokens);


// Habitaciones
$sqlRooms = "SELECT * FROM habitaciones";
$resultadoRooms = $conn->query($sqlRooms);

$rooms = [];
while ($row = $resultadoRooms->fetch_assoc()) {
    $rooms[] = $row;
}


$sqlReservas = "SELECT * FROM reservas";
$resultadoReservas = $conn->query($sqlReservas);

$reservas = [];
while ($row = $resultadoReservas->fetch_assoc()) {
    $reservas[] = $row;
}


?>





<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin Panel - Hotel Violeta Boutique</title>
  <link rel="stylesheet" href="../public/assets/css/inicio.css">
  <style>
    /* ----- Reset básico + paleta (heredada de inicio.css) ----- */
    :root{
      --accent: #b79c65;
      --accent-dark: #9c854f;
      --img-ring: rgba(156,133,79,0.12);
      --text: #1b1b1b;
      --text-muted: #5f5f5f;
      --bg-light: #faf8f6;
      --white: #ffffff;
      --radius: 12px;
      --shadow: 0 8px 25px rgba(0,0,0,0.08);
      --table-border: #ececf4;
      font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
    }
    *{box-sizing:border-box}
    body{
      margin:0;
      background: var(--bg-light);
      color:var(--text);
      min-height:100vh;
      font-size:14px;
      /* Remove top padding inherited from site css so sidebar sits at top */
      padding-top: 0 !important;
    }

    /* ----- Layout ----- */
    .app {
      display:flex;
      min-height:100vh;
    }
    /* sidebar */
    .sidebar{
      width:260px;
      background: linear-gradient(180deg,var(--accent),var(--accent-dark));
      color:#fff;
      padding:8px 18px 28px 18px;
      display:flex;
      flex-direction:column;
      gap:18px;
      position:fixed; /* keep sidebar always at top-left */
      top:0;
      left:0;
      bottom:0;
      height:100vh;
      z-index:1000;
      overflow:auto;
    }

    /* Hide any global navbar coming from inicio.css to avoid duplicate header space */
    .navbar { display: none !important; }
    .brand{
      display:flex; align-items:center; gap:12px;
    }
    .logo {
      width:44px; height:44px;
      background: linear-gradient(135deg, rgba(183,156,101,0.95), rgba(156,133,79,0.95));
      border-radius:10px;
      display:flex; align-items:center; justify-content:center;
      font-weight:700; color: #fff; font-size:1.05rem;
      box-shadow: 0 6px 18px rgba(156,133,79,0.12);
    }
    .brand h1{ font-size:16px; margin:0; font-weight:700; letter-spacing:0.2px }
    .brand-text .muted { display:none }
    .menu{ margin-top:12px; display:flex; flex-direction:column; gap:6px }
    .menu a{
      display:flex; align-items:center; gap:12px;
      padding:10px 12px; border-radius:8px;
      text-decoration:none; color:rgba(255,255,255,0.95);
    }
    .menu a.active{ background:rgba(255,255,255,0.06); }

    .sidebar .bottom {
      margin-top:auto; font-size:13px; opacity:0.9;
    }

    /* main area */
    .main {
      flex:1; padding:22px; display:flex; flex-direction:column; gap:18px; margin-left:260px;
    }

    /* header */
    .topbar {
      display:flex; align-items:center; justify-content:space-between; gap:16px;
    }
    .searchbar{
      display:flex; gap:12px; align-items:center;
      background:var(--card); padding:8px 12px; border-radius:12px;
      box-shadow:0 1px 2px rgba(0,0,0,0.02);
      min-width:320px;
    }
    .searchbar input{
      border:0; outline:none; font-size:14px; width:100%;
      background:transparent;
    }
    .userbox{
      display:flex; align-items:center; gap:10px;
    }
    .avatar{
      width:38px; height:38px; border-radius:50%; background:linear-gradient(135deg,#ffd6e0,#ffd7b1);
      display:flex; align-items:center; justify-content:center; font-weight:600;
    }

    /* card */
    .card{
      background:var(--white); border-radius:12px; padding:18px;
      box-shadow:var(--shadow);
    }

    /* controls */
    .controls{ display:flex; gap:12px; align-items:center; margin-bottom:12px; flex-wrap:wrap; }
    .btn{
      padding:8px 12px; border-radius:10px; border:0; cursor:pointer; font-weight:600;
    }
    .btn-primary{ background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%); color:#fff }
    .btn-ghost{ background:transparent; border:1px solid var(--table-border); color:var(--text-muted); }

    .filters{ display:flex; gap:10px; align-items:center; }
    select, input[type="date"]{ padding:8px 10px; border-radius:8px; border:1px solid var(--table-border); }

    /* table */
    .table-wrap{ overflow:auto; background:var(--white); border-radius:8px; padding:6px; box-shadow:0 6px 18px rgba(0,0,0,0.04); }

    /* bottom horizontal controller (visible in 'usuario' view) */
    #hScrollWrap{
      position:fixed;
      left:260px; /* align with main area (sidebar width) */
      right:0;
      bottom:8px;
      height:40px;
      display:none;
      align-items:center;
      z-index:1200;
      pointer-events:auto;
      padding:6px 14px;
    }
    #hScroll{
      width:100%;
      appearance:none;
      height:8px;
      border-radius:8px;
      background:linear-gradient(90deg, rgba(183,156,101,0.18), rgba(156,133,79,0.18));
      outline:none;
    }
    /* thumb */
    #hScroll::-webkit-slider-thumb{ appearance:none; width:18px; height:18px; border-radius:50%; background:var(--accent); box-shadow:0 4px 12px rgba(156,133,79,0.25); cursor:pointer }
    #hScroll::-moz-range-thumb{ width:18px; height:18px; border-radius:50%; background:var(--accent); box-shadow:0 4px 12px rgba(156,133,79,0.25); cursor:pointer }
    table{
      width:100%; border-collapse:collapse; min-width:900px; font-size:13px;
    }
    thead th{
      text-align:left; padding:8px 10px; color:var(--muted); font-weight:600;
      border-bottom:1px solid var(--table-border); font-size:12px;
    }
    tbody td{
      padding:8px 10px; border-bottom:1px dashed #f0f0f5; vertical-align:middle; font-size:13px;
    }
    .col-photo{ width:48px; }
    .room-photo{ width:40px; height:30px; border-radius:6px; object-fit:cover; }

    .badge{
      display:inline-block; padding:6px 10px; border-radius:999px; font-weight:600; font-size:12px;
      color:#fff;
    }
    .badge.available{ background:var(--success); }
    .badge.occupied{ background:var(--info); }
    .badge.cleaning{ background:var(--warning); color:#222; }
    /* .badge.maintenance removed */

    .actions{ display:flex; gap:8px; }
    .icon-btn{ background:transparent; border:0; cursor:pointer; padding:6px 8px; border-radius:8px; }
    .icon-btn:hover{ background:rgba(0,0,0,0.03); }

    /* responsive */
    @media (max-width:900px){
      .sidebar{ /* off-canvas by default on mobile */
        transform: translateX(-100%);
        transition: transform .22s ease;
        position:fixed; left:0; top:0; bottom:0; z-index:1200;
      }
      .sidebar.open{ transform: translateX(0); }
      .main{ padding:14px; margin-left:0 }
      /* show mobile menu button in topbar */
      #mobileMenuBtn{ display:inline-flex }
      /* make horizontal controller stretch full width when sidebar hidden */
      #hScrollWrap{ left:0 }
    }

    /* mobile-specific UI helpers */
    #mobileMenuBtn{ display:none; align-items:center; justify-content:center; width:38px; height:38px; border-radius:8px }
    #mobileBackdrop{ display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:1100 }

    /* modal */
    .modal-backdrop{
      position:fixed; inset:0; background:rgba(12,12,20,0.45); display:none; align-items:center; justify-content:center;
      z-index:40;
    }
    .modal{
      width:720px; max-width:94%; background:var(--white); border-radius:12px; padding:18px;
      box-shadow:0 20px 60px rgba(9,8,29,0.12);
    }
    .form-grid{ display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:10px; }
    .form-row{ display:flex; flex-direction:column; gap:6px; }
    label{ font-size:13px; color:var(--muted) }
    input[type=text], input[type=number], textarea, select{
      padding:8px 10px; border-radius:8px; border:1px solid var(--table-border); font-size:14px;
    }
    textarea{ min-height:80px; resize:vertical; }

    /* small helpers */
    .muted{ color:var(--muted) }
    .h3{ font-size:18px; margin:0 0 6px 0; font-weight:700 }
    .flex{ display:flex; gap:12px; align-items:center }
    .right{ margin-left:auto }
    /* reserva panel displayed as centered square modal */
    .side-panel{
      position:fixed; left:50%; top:50%; transform:translate(-50%,-50%) scale(.96);
      /* wider, flexible height with scroll */
      width: min(960px, 96vw);
      max-width:1100px;
      height: auto; max-height:86vh;
      background:var(--white); z-index:120; padding:24px; box-shadow:var(--shadow);
      border-radius:14px; display:flex; flex-direction:column; opacity:0; transition:transform .22s ease, opacity .22s ease;
      pointer-events:none; overflow:auto;
    }
    .side-panel.open{ transform:translate(-50%,-50%) scale(1); opacity:1; pointer-events:auto }
    .side-panel .panel-header{ display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:12px }
    .side-panel .panel-footer{ display:flex; justify-content:flex-end; gap:8px; margin-top:14px }
    /* small screens: slightly smaller square */
    @media (max-width:900px){
      .side-panel{ width: min(94vw, 760px); max-height:86vh; }
    }
    @media (max-width:600px){
      .side-panel{ width: 94vw; max-height:90vh; border-radius:12px; padding:16px }
    }
    /* Mobile: transformar tablas en fichas (cards) para mejor legibilidad en celular */
    @media (max-width:700px){
      table{ min-width:0; }
      thead{ display:none; }
      /* cada fila se convierte en card */
      tbody tr{
        display:block; background:var(--white); margin:10px 0; padding:12px; border-radius:10px; box-shadow:0 6px 18px rgba(0,0,0,0.04);
      }
      tbody td{ display:flex; justify-content:space-between; align-items:center; padding:6px 0; border-bottom:0; }
      tbody td[data-label]::before{
        content: attr(data-label) ": ";
        color:var(--text-muted); font-weight:700; margin-right:8px; width:45%;
        display:inline-block;
      }
      .col-photo{ width:96px; }
      .room-photo{ width:96px; height:72px; object-fit:cover; border-radius:8px }
      .actions{ margin-left:8px; display:flex; gap:6px; }
      /* ocultar campos menos relevantes en móvil para reducir altura */
      tbody td[data-label="Descripción"],
      tbody td[data-label="Contraseña"],
      tbody td[data-label="Token Hash"],
      tbody td[data-label="Token"],
      tbody td[data-label="Fecha creación"]{
        display:none;
      }
      /* mostrar campos ocultos cuando la fila está expandida */
      tbody tr.expanded td[data-label="Descripción"],
      tbody tr.expanded td[data-label="Contraseña"],
      tbody tr.expanded td[data-label="Token Hash"],
      tbody tr.expanded td[data-label="Token"],
      tbody tr.expanded td[data-label="Fecha creación"]{
        display:flex; grid-column:2 / -1; padding-top:8px; flex-direction:row; justify-content:flex-start; gap:8px;
      }
      /* ajustar texto secundario */
      tbody td .muted{ display:block; text-align:left; color:var(--text-muted); font-size:12px }
      /* topViewBar: botones más compactos y adaptables en móvil */
      #topViewBar .buttons{ display:flex; gap:4px; overflow-x:auto; padding:2px 2px }
      #topViewBar .buttons button{ flex:0 0 auto; min-width:48px; max-width:110px; text-align:center; padding:4px 6px; font-size:12px; border-radius:8px; display:flex; gap:4px; align-items:center; justify-content:center }
      #topViewBar .view-btn .icon{ font-size:15px; display:inline-block }
      #topViewBar .view-btn .label{ display:inline-block }
      /* hide labels on very small phones to save space */
      @media (max-width:420px){ #topViewBar .view-btn .label{ display:none } }
      #topViewBar{ height:48px }
      .main{ padding-top:64px }
      /* small tweaks: compact search and avatar */
      .topbar .searchbar{ min-width:80px; padding:6px 8px }
      .avatar{ width:34px; height:34px; font-size:13px }
    }
    /* Top view bar for small screens: buttons to switch views horizontally */
    #topViewBar{
      display:none;
      position:fixed;
      top:0;
      left:0;
      right:0;
      height:52px;
      background:linear-gradient(180deg, rgba(255,255,255,0.98), rgba(250,248,246,0.98));
      border-bottom:1px solid rgba(0,0,0,0.04);
      z-index:1300;
      align-items:center;
      justify-content:space-between;
      padding:6px 12px;
      gap:8px;
      box-shadow:0 6px 18px rgba(0,0,0,0.06);
    }
    #topViewBar .left, #topViewBar .right{ display:flex; gap:8px; align-items:center }
    #topViewBar .view-btn{ padding:8px 10px; border-radius:10px; border:0; background:transparent; font-weight:700; cursor:pointer }
    #topViewBar .view-btn.active{ background:linear-gradient(135deg,var(--accent),var(--accent-dark)); color:#fff }

    @media (max-width:900px){
      /* show top view bar on small screens */
      #topViewBar{ display:flex }
      /* ensure main content sits below the fixed top bar */
      .main{ padding-top:72px }
      /* hide the in-header searchbar vertically to save space (kept accessible inside top bar if needed) */
      .topbar .searchbar{ min-width:120px; }
    }
  </style>
</head>
<body>
  <div class="app">
    <aside class="sidebar">
      <div class="brand">
        <div class="logo" aria-hidden="true">V</div>
        <div class="brand-text">
          <h1>Violeta Boutique</h1>
        </div>
      </div>

      <nav class="menu">
        <!-- Dashboard eliminado -->
        <!-- 'Reservas' cambiado a 'Usuario' según petición del usuario -->
        <a data-view="usuario">Usuario</a>
        <a data-view="habitaciones">Habitaciones</a>
        <a data-view="reservas">Reservas</a>
        <a data-view="tokens">Token</a>
        <!-- Enlaces eliminados por petición del usuario -->
      </nav>

      <div class="bottom muted">
        <div>Versión 1.0</div>
      </div>
    </aside>

    <div id="mobileBackdrop"></div>

    <!-- Top view bar (mobile): muestra botones horizontales para cambiar entre vistas -->
    <div id="topViewBar" aria-hidden="false">
      <div class="left">
        <button class="view-btn" data-view="habitaciones">Habitaciones</button>
        <button class="view-btn" data-view="reservas">Reservas</button>
      </div>
      <div class="right">
        <button class="view-btn" data-view="tokens">Token</button>
        <button class="view-btn" data-view="usuario">Usuario</button>
      </div>
    </div>

    <main class="main">
      <header class="topbar">
        <div class="searchbar card">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16zm9 3-5.2-5.2" stroke="#6b6b87" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
          <input id="globalSearch" placeholder="Buscar por habitación, cliente o ID..." />
        </div>
        <button id="mobileMenuBtn" class="icon-btn" aria-label="Abrir menú">☰</button>

        <div class="userbox">
          <div style="text-align:right">
            <div style="font-weight:700">Luke Asote</div>
            <div class="muted" style="font-size:12px">Administrador</div>
          </div>
          <div class="avatar">LA</div>
        </div>
      </header>

      <section class="card">
        <div class="flex" style="align-items:center; gap:18px;">
          <div>
            <div id="mainTitle" class="h3">Gestión del hotel</div>
            <div id="mainSubtitle" class="muted">Panel administrativo — Habitaciones, Usuarios, Reservas y Tokens</div>
          </div>

          <div class="right">
            <div class="controls">
              <div class="filters">
                <select id="statusFilter">
                  <option value="">Filtrar por estado</option>
                  <option value="available">Disponible</option>
                  <option value="occupied">Ocupada</option>
                  <option value="cleaning">En limpieza</option>
                  <!-- Mantenimiento eliminado -->
                </select>
                <select id="typeFilter">
                  <option value="">Filtrar por tipo</option>
                  <option value="Single">Single</option>
                  <option value="Double">Double</option>
                  <option value="Suite">Suite</option>
                </select>
                <!-- Reserva-specific filters (moved to reservas panel) -->
              </div>

                <button class="btn btn-ghost" id="exportBtn">Exportar CSV</button>
                <button class="btn btn-primary" id="addRoomBtn">+ Nueva Habitación</button>
                <div class="controls" id="usersControls" style="display:none; margin-top:8px;">
                  <button class="btn btn-primary" id="addUserBtn">+ Nuevo Usuario</button>
                </div>
            </div>
          </div>
        </div>

        <div id="roomsTableWrap" style="margin-top:14px" class="table-wrap">
          <table id="roomsTable" aria-describedby="roomsTable">
            <!-- table head will be rendered dynamically depending on the active view -->
            <thead id="tableHead">
            </thead>
            <tbody>
              <!-- JS render -->
            </tbody>
          </table>
        </div>
        <!-- Users table (for 'Todas' and 'Usuario' consolidated view) -->
        <div id="usersTableWrap" style="margin-top:14px; display:none" class="table-wrap">
          <table id="usersTable" aria-describedby="usersTable">
            <thead id="usersHead"></thead>
            <tbody>
              <!-- JS render usuarios -->
            </tbody>
          </table>
        </div>
        <div id="reservasControlsWrap" style="margin-top:14px; display:none">
          <div class="controls" id="reservasControls" style="display:none;">
            <button class="btn btn-primary" id="addReservaBtn">+ Nueva Reserva</button>
            <select id="reservaUserSelect" style="margin-left:8px;">
              <option value="">Filtrar por usuario</option>
            </select>
          </div>
        </div>
        <div id="reservasTableWrap" style="margin-top:14px; display:none" class="table-wrap">
          <table id="reservasTable" aria-describedby="reservasTable">
            <thead id="reservasHead">
            </thead>
            <tbody>
              <!-- JS render reservas -->
            </tbody>
          </table>
        </div>
        <div id="tokensTableWrap" style="margin-top:14px; display:none" class="table-wrap">
          <table id="tokensTable" aria-describedby="tokensTable">
            <thead id="tokensHead">
            </thead>
            <tbody>
              <!-- JS render tokens -->
            </tbody>
          </table>
        </div>
        <!-- horizontal scroll controller (shows only in usuario view) -->
        <div id="hScrollWrap">
          <input id="hScroll" type="range" min="0" value="0" />
        </div>
      </section>
    </main>
  </div>

  <!-- Modal: crear/editar habitación -->
  <div class="modal-backdrop" id="modalBackdrop">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
      <div style="display:flex; align-items:center; justify-content:space-between;">
        <div>
          <div id="modalTitle" class="h3">Nueva habitación</div>
          <div class="muted" id="modalSubtitle">Agregar detalles de la habitación</div>
        </div>
        <!-- Modal: crear/editar token -->
        <div class="modal-backdrop" id="tokenModalBackdrop" style="display:none">
          <div class="modal" role="dialog" aria-modal="true" aria-labelledby="tokenModalTitle">
            <div style="display:flex; align-items:center; justify-content:space-between;">
              <div>
                <div id="tokenModalTitle" class="h3">Nuevo token</div>
                <div class="muted" id="tokenModalSubtitle">Crear token de recordar sesión</div>
              </div>
              <div>
                <button class="icon-btn" id="tokenCloseModal">&times;</button>
              </div>
            </div>

            <form id="tokenForm" style="margin-top:12px">
              <input type="hidden" id="tokenId" />
              <div class="form-grid">
                <div class="form-row">
                  <label>User ID</label>
                  <input type="number" id="tokenUserId" required />
                </div>
                <div class="form-row">
                  <label>Token Hash</label>
                  <input type="text" id="tokenHash" required />
                </div>
                <div class="form-row">
                  <label>Fecha creación</label>
                  <input type="datetime-local" id="tokenFechaCreacion" />
                </div>
                <div class="form-row">
                  <label>Fecha expiración</label>
                  <input type="datetime-local" id="tokenFechaExpiracion" />
                </div>
              </div>

              <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:14px;">
                <button type="button" class="btn btn-ghost" id="tokenCancelBtn">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="tokenSaveBtn">Guardar token</button>
              </div>
            </form>
          </div>
        </div>
        <div>
          <button class="icon-btn" id="closeModal">&times;</button>
        </div>
      </div>

      <form id="roomForm" style="margin-top:12px">
        <div class="form-grid">
          <div class="form-row">
            <label>Número o nombre</label>
            <input type="text" id="roomNumber" required placeholder="e.g. 101 / Suite Violeta" />
          </div>
          <div class="form-row">
            <label>Tipo</label>
            <select id="roomType">
              <option>Single</option>
              <option>Double</option>
              <option>Suite</option>
            </select>
          </div>

          <div class="form-row">
            <label>Precio (pesos)</label>
            <input type="number" id="roomPrice" min="0" step="0.01" />
          </div>
          <div class="form-row">
            <label>Capacidad (personas)</label>
            <input type="number" id="roomCapacity" min="1" />
          </div>

          <div class="form-row">
            <label>Camas</label>
            <input type="number" id="roomCamas" min="1" />
          </div>
          <div class="form-row">
            <label>Tamaño</label>
            <input type="text" id="roomTamano" placeholder="e.g. 20 m²" />
          </div>


          <div class="form-row">
            <label>Estado</label>
            <select id="roomStatus">
              <option value="available">Disponible</option>
              <option value="occupied">Ocupada</option>
              <option value="cleaning">En limpieza</option>
              <!-- Mantenimiento eliminado -->
            </select>
          </div>

          <div class="form-row">
            <label>Imagen (URL)</label>
            <input type="text" id="roomImage" placeholder="https://..." />
          </div>

          <div class="form-row" style="display:flex; gap:8px; align-items:center">
            <label style="min-width:110px">Servicios</label>
            <div style="display:flex; gap:10px; align-items:center">
              <label style="display:flex; gap:6px; align-items:center"><input type="checkbox" id="roomWifi" /> Wifi</label>
              <label style="display:flex; gap:6px; align-items:center"><input type="checkbox" id="roomDucha" /> Ducha</label>
              <label style="display:flex; gap:6px; align-items:center"><input type="checkbox" id="roomDesayuno" /> Desayuno</label>
            </div>
          </div>

          <div style="grid-column:1 / -1;">
            <label>Descripción</label>
            <textarea id="roomDesc" placeholder="Descripción corta de la habitación"></textarea>
          </div>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:14px;">
          <button type="button" class="btn btn-ghost" id="cancelBtn">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="saveBtn">Guardar habitación</button>
        </div>
      </form>
    </div>
    </div>

    <!-- Modal: editar usuario -->
    <div class="modal-backdrop" id="userModalBackdrop" style="display:none">
      <div class="modal" role="dialog" aria-modal="true" aria-labelledby="userModalTitle">
        <div style="display:flex; align-items:center; justify-content:space-between;">
          <div>
            <div id="userModalTitle" class="h3">Editar usuario</div>
            <div class="muted" id="userModalSubtitle">Modificar datos del usuario</div>
          </div>
          <div>
            <button class="icon-btn" id="userCloseModal">&times;</button>
          </div>
        </div>

          <!-- Modal: crear/editar reserva -->
          <div class="modal-backdrop" id="reservaModalBackdrop" style="display:none">
            <div class="modal" role="dialog" aria-modal="true" aria-labelledby="reservaModalTitle">
              <div style="display:flex; align-items:center; justify-content:space-between;">
                <div>
                  <div id="reservaModalTitle" class="h3">Nueva reserva</div>
                  <div class="muted" id="reservaModalSubtitle">Crear reserva</div>
                </div>
                <div>
                  <button class="icon-btn" id="reservaCloseModal">&times;</button>
                </div>
              </div>

              <form id="reservaForm" style="margin-top:12px">
                <input type="hidden" id="reservaId" />
                <div class="form-grid">
                  <div class="form-row">
                    <label>Usuario</label>
                    <select id="reservaUsuario" required>
                      <option value="">Seleccione usuario</option>
                    </select>
                  </div>
                  <div class="form-row">
                    <label>Habitación</label>
                    <select id="reservaHabitacion" required>
                      <option value="">Seleccione habitación</option>
                    </select>
                  </div>
                  <div class="form-row">
                    <label>Fecha inicio</label>
                    <input type="date" id="reservaInicio" required />
                  </div>
                  <div class="form-row">
                    <label>Fecha fin</label>
                    <input type="date" id="reservaFin" required />
                  </div>
                  <div class="form-row">
                    <label>Precio total</label>
                    <input type="number" id="reservaPrecio" step="0.01" min="0" />
                  </div>
                  <div class="form-row">
                    <label>Estado</label>
                    <select id="reservaEstado">
                      <option value="confirmada">Confirmada</option>
                      <option value="pendiente">Pendiente</option>
                      <option value="cancelada">Cancelada</option>
                    </select>
                  </div>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:14px;">
                  <button type="button" class="btn btn-ghost" id="reservaCancelBtn">Cancelar</button>
                  <button type="submit" class="btn btn-primary" id="reservaSaveBtn">Guardar reserva</button>
                </div>
              </form>
            </div>
          </div>

    <form id="userForm" style="margin-top:12px" action="crear_usuario.php" method="POST">
  <input type="hidden" id="userId" name="id" />

  <div class="form-grid">
    
    <div class="form-row">
      <label>Nombre</label>
      <input type="text" id="userName" name="nombre" required />
    </div>

    <div class="form-row">
      <label>Email</label>
      <input type="email" id="userEmail" name="email" required />
    </div>

    <div class="form-row">
      <label>Contraseña (dejar en blanco para no cambiar)</label>
      <input type="password" id="userPassword" name="contraseña" />
    </div>

    <div class="form-row">
      <label>Cédula</label>
      <input type="number" id="userCedula" name="cedula" />
    </div>

    <div class="form-row">
      <label>Teléfono</label>
      <input type="number" id="userTelefono" name="telefono" />
    </div>

    <div class="form-row">
      <label>Verificado</label>
      <select id="userEstadoVerificacion" name="estado_verificacion">
        <option value="1">Sí</option>
        <option value="0">No</option>
      </select>
    </div>

    <div class="form-row">
      <label>Rol</label>
<select id="userRol" name="rol" required>
  <option value="user">Usuario</option>
  <option value="admin">Admin</option>
</select>
    </div>

    <div style="grid-column:1 / -1;">
      <label>Token de verificación (solo lectura)</label>
      <input type="text" id="userToken" name="token" readonly />
    </div>

  </div>

  <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:14px;">
    <button type="button" class="btn btn-ghost" id="userCancelBtn">Cancelar</button>
    <button type="submit" name="submit" class="btn btn-primary" id="userSaveBtn">Guardar usuario</button>
  </div>
</form>
      </div>
    </div>

    <!-- Side panel: editar reserva (centered square modal) -->
    <div id="resPanelBackdrop" class="modal-backdrop" style="display:none"></div>
    <aside id="reservaSidePanel" class="side-panel" aria-hidden="true" style="display:none">
      <div class="panel-header">
        <div>
          <div id="resSideTitle" class="h3">Editar reserva</div>
          <div class="muted" id="resSideSubtitle">Modificar datos de la reserva</div>
        </div>
        <div>
          <button class="icon-btn" id="resSideClose">&times;</button>
        </div>
      </div>

      <form id="reservaSideForm">
        <input type="hidden" id="resSideId" />
        <div class="form-grid">
          <div class="form-row">
            <label>Usuario</label>
            <select id="resSideUsuario" required>
              <option value="">Seleccione usuario</option>
            </select>
          </div>
          <div class="form-row">
            <label>Habitación</label>
            <select id="resSideHabitacion" required>
              <option value="">Seleccione habitación</option>
            </select>
          </div>
          <div class="form-row">
            <label>Fecha inicio</label>
            <input type="date" id="resSideInicio" required />
          </div>
          <div class="form-row">
            <label>Fecha fin</label>
            <input type="date" id="resSideFin" required />
          </div>
          <div class="form-row">
            <label>Precio total</label>
            <input type="number" id="resSidePrecio" step="0.01" min="0" />
          </div>
          <div class="form-row">
            <label>Estado</label>
            <select id="resSideEstado">
              <option value="confirmada">Confirmada</option>
              <option value="pendiente">Pendiente</option>
              <option value="cancelada">Cancelada</option>
            </select>
          </div>
        </div>

        <div class="panel-footer">
          <button type="button" class="btn btn-ghost" id="resSideCancel">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="resSideSave">Guardar</button>
        </div>
      </form>
    </aside>

    <script>
        /* ===== Datos de ejemplo: reservas ===== */
        // const reservas = [
        //   { id_reserva: 1, id_usuario: 1, id_habitaciones: 101, fecha_inicio: '2025-11-20', fecha_fin: '2025-11-22', precio_total: 90, estado: 'confirmada' },
        //   { id_reserva: 2, id_usuario: 2, id_habitaciones: 102, fecha_inicio: '2025-12-01', fecha_fin: '2025-12-03', precio_total: 156, estado: 'pendiente' },
        //   { id_reserva: 3, id_usuario: 3, id_habitaciones: 201, fecha_inicio: '2025-11-28', fecha_fin: '2025-11-30', precio_total: 320, estado: 'cancelada' }
        // ];

        /* ===== Modal: crear/editar reserva ===== */
        // We'll append a small modal block after the user modal in the DOM

        function renderReservasView() {
          currentView = 'reservas';
          tableHead.innerHTML = `
            <tr>
              <th>ID Reserva</th>
              <th>ID Usuario</th>
              <th>ID Habitación</th>
              <th>Fecha inicio</th>
              <th>Fecha fin</th>
              <th>Precio total</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          `;
          if(controls) controls.style.display = '';
          // adapt filters for reservas: status -> confirmada/pendiente/cancelada, type -> por usuario / por habitación
          if(statusFilter) statusFilter.innerHTML = `
            <option value="">Filtrar por estado</option>
            <option value="confirmada">Confirmada</option>
            <option value="pendiente">Pendiente</option>
            <option value="cancelada">Cancelada</option>
          `;
          if(typeFilter) typeFilter.innerHTML = `
            <option value="">Filtrar por tipo</option>
            <option value="por_usuario">Por usuario</option>
            <option value="por_habitacion">Por habitación</option>
          `;
          // show controls and show reserva-specific buttons/filters
          if(addRoomBtn) addRoomBtn.style.display = 'none';
          if(exportBtn) exportBtn.style.display = 'none';
          if(addReservaBtn) addReservaBtn.style.display = '';
          if(usersControls) usersControls.style.display = 'none';
          if(tokensControls) tokensControls.style.display = 'none';
          // ensure only the main table is visible for reservas (hide other dedicated table wrappers)
          if(tokensTableWrap) tokensTableWrap.style.display = 'none';
          if(usersTableWrap) usersTableWrap.style.display = 'none';
          if(reservasTableWrap) reservasTableWrap.style.display = 'none';
          if(roomsTableWrap) roomsTableWrap.style.display = '';
          // show reserva filters (status + usuario)
          if(reservaUserSelect) {
            reservaUserSelect.style.display = '';
            reservaUserSelect.innerHTML = '<option value="">Filtrar por usuario</option>' + users.map(u=>`<option value="${u.id}">${u.email || ('ID:'+u.id)}</option>`).join('');
          }
          globalSearch.placeholder = 'Buscar por reserva, usuario o habitación...';
          // use the helper to render current reservas array
          renderReservasRows(reservas);
          // hide bottom controller when not needed
          const hWrapHide2 = document.getElementById('hScrollWrap'); if(hWrapHide2) hWrapHide2.style.display='none';
        }
    /* ===== Datos de ejemplo ===== */
    // const rooms = [
    //   { id:1, number:"101", type:"Single", price:45, capacity:1, status:"available", image:"https://picsum.photos/seed/101/200/120", desc:"Habitación individual, cama sencilla" },
    //   { id:2, number:"102", type:"Double", price:78, capacity:2, status:"occupied", image:"https://picsum.photos/seed/102/200/120", desc:"Doble con balcón" },
    //   { id:3, number:"201", type:"Suite", price:160, capacity:3, status:"available", image:"https://picsum.photos/seed/201/200/120", desc:"Suite superior con sala" },
    //   { id:4, number:"202", type:"Double", price:85, capacity:2, status:"cleaning", image:"https://picsum.photos/seed/202/200/120", desc:"Doble, vista al jardín" },
    //   { id:5, number:"301", type:"Suite", price:210, capacity:4, status:"available", image:"https://picsum.photos/seed/301/200/120", desc:"Suite nupcial" },
    // ];

    /* ===== Datos de tokens (del servidor) ===== */
    const tokens = [
      <?php while ($t = $resultadoTokens->fetch_assoc()): ?>
        { id: <?php echo $t['id'];?>, user_id: <?php echo $t['user_id'];?>, token_hash: "<?php echo addslashes($t['token_hash']);?>", fecha_creacion: "<?php echo $t['fecha_creacion'];?>", fecha_expiracion: "<?php echo $t['fecha_expiracion'];?>" },
      <?php endwhile; ?>
    ];

    /* ===== utilidades DOM ===== */
    const tbody = document.querySelector("#roomsTable tbody");
    const tableHead = document.getElementById('tableHead');
    const menu = document.querySelector('.menu');
    const controls = document.querySelector('.controls');
    const usersControls = document.getElementById('usersControls');
    const tokensControls = document.getElementById('tokensControls');
    const globalSearch = document.getElementById("globalSearch");
    const statusFilter = document.getElementById("statusFilter");
    const typeFilter = document.getElementById("typeFilter");
    const addRoomBtn = document.getElementById("addRoomBtn");
    const addReservaBtn = document.getElementById('addReservaBtn');
    const modalBackdrop = document.getElementById("modalBackdrop");
    const roomForm = document.getElementById("roomForm");
    const modalTitle = document.getElementById("modalTitle");
    const modalSubtitle = document.getElementById("modalSubtitle");
    const cancelBtn = document.getElementById("cancelBtn");
    const closeModal = document.getElementById("closeModal");
    // user modal elements
    const userModalBackdrop = document.getElementById("userModalBackdrop");
    const userForm = document.getElementById("userForm");
    const userModalTitle = document.getElementById("userModalTitle");
    const userModalSubtitle = document.getElementById("userModalSubtitle");
    const userCancelBtn = document.getElementById("userCancelBtn");
    const userCloseModal = document.getElementById("userCloseModal");
    const addUserBtn = document.getElementById('addUserBtn');
    const exportBtn = document.getElementById("exportBtn");
    // addTokenBtn removed — creation handled elsewhere or via server
    const tokenModalBackdrop = document.getElementById('tokenModalBackdrop');
    const tokenForm = document.getElementById('tokenForm');
    const tokenModalTitle = document.getElementById('tokenModalTitle');
    const tokenModalSubtitle = document.getElementById('tokenModalSubtitle');
    const tokenCancelBtn = document.getElementById('tokenCancelBtn');
    const tokenCloseModal = document.getElementById('tokenCloseModal');
    const roomsTableWrap = document.getElementById('roomsTableWrap');
    const reservasControlsWrap = document.getElementById('reservasControlsWrap');
    const reservasControls = document.getElementById('reservasControls');
    const reservasTableWrap = document.getElementById('reservasTableWrap');
    const reservasTable = document.getElementById('reservasTable');
    const tokensTableWrap = document.getElementById('tokensTableWrap');
    const tokensTable = document.getElementById('tokensTable');
    const reservaUserSelect = document.getElementById('reservaUserSelect');
    const reservaModalBackdrop = document.getElementById('reservaModalBackdrop');
    const reservaForm = document.getElementById('reservaForm');
    const reservaCancelBtn = document.getElementById('reservaCancelBtn');
    const reservaCloseModal = document.getElementById('reservaCloseModal');
    const reservaUsuario = document.getElementById('reservaUsuario');
    const reservaHabitacion = document.getElementById('reservaHabitacion');
    const reservaInicio = document.getElementById('reservaInicio');
    const reservaFin = document.getElementById('reservaFin');
    const reservaPrecio = document.getElementById('reservaPrecio');
    const reservasTbody = reservasTable ? reservasTable.querySelector('tbody') : null;

const usersTable = document.getElementById("usersTable");
const usersTbody = usersTable ? usersTable.querySelector("tbody") : null;

const tokensTbody = tokensTable ? tokensTable.querySelector("tbody") : null;

    let editId = null; // id a editar si aplica
    let editUserId = null; // id del usuario a editar
    let editTokenId = null;
    let currentView = 'dashboard';

    /* ===== Datos de ejemplo: usuarios ===== */
  const users = <?= json_encode($resultado->fetch_all(MYSQLI_ASSOC)) ?>;
  const rooms = <?php echo json_encode($rooms); ?>;
  const reservas = <?php echo json_encode($reservas, JSON_UNESCAPED_UNICODE); ?>;


const tokensPHP = [
<?php
$first = true;
while ($t = $resultadoTokens->fetch_assoc()) {
    if (!$first) echo ",\n";
    echo json_encode($t, JSON_UNESCAPED_UNICODE);
    $first = false;
}
?>
];
console.log('users (count):', users.length, users[0] || null);

    function statusBadgeClass(status){
      switch(status){
        case "available": return "badge available";
        case "occupied": return "badge occupied";
        case "cleaning": return "badge cleaning";
        default: return "badge";
      }
    }
function renderTable(list){
    tbody.innerHTML = "";

    if(!list.length){
        tbody.innerHTML = '<tr><td colspan="12" style="text-align:center; padding:30px;">No hay habitaciones</td></tr>';
        return;
    }

    list.forEach(r => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td class="col-photo"><img src="${r.imagen}" alt="" class="table-img"></td>
            <td>${r.nombre_habitacion}</td>
            <td>${r.precio}</td>
            <td>${r.capacidad}</td>
            <td>${r.camas}</td>
            <td>${r.tamaño}</td>
            <td>${r.wifi == 1 ? "Sí" : "No"}</td>
            <td>${r.ducha == 1 ? "Sí" : "No"}</td>
            <td>${r.desayuno == 1 ? "Sí" : "No"}</td>
            <td>${r.estado == 1 ? "Disponible" : "Ocupada"}</td>
            <td>${r.descripcion}</td>
            <td>
                <div class="actions">
                    <button class="icon-btn" data-action="edit-room" data-id="${r.id}">✏️</button>
                    <button class="icon-btn" data-action="delete-room" data-id="${r.id}">🗑️</button>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

    /* ===== render de usuarios ===== */
    // generic renderer for users into a provided tbody
    function renderUsersList(targetTbody, list){
      targetTbody.innerHTML = "";
      if(!list.length){
        targetTbody.innerHTML = '<tr><td colspan="9" style="text-align:center; padding:30px; color:var(--muted)">No se encontraron usuarios</td></tr>';
        return;
      }
      list.forEach(u=>{
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td data-label="ID" style="font-weight:700">${u.id}</td>
          <td data-label="Email">${u.email}</td>
          <td data-label="Contraseña"><small class="muted">${u.contraseña}</small></td>
          <td data-label="Cédula">${u.cedula}</td>
          <td data-label="Teléfono">${u.telefono}</td>
          <td data-label="Fecha inicio">${u.fecha_creacion}</td>
          <td data-label="Verificado">${u.estado_verificacion === 1 ? '<span style="color:var(--success); font-weight:700">Sí</span>' : '<span style="color:var(--muted)">No</span>'}</td>
          <td data-label="Token"><small class="muted">${u.token_verificacion ? (u.token_verificacion.length>24 ? u.token_verificacion.slice(0,20)+ '...' : u.token_verificacion) : ''}</small></td>
          <td data-label="Rol">${u.rol}</td>
          <td data-label="Acciones">
            <div class="actions">
              <button class="icon-btn" data-action="edit-user" data-id="${u.id}" title="Editar">✏️</button>
              <button class="icon-btn" data-action="logout" data-id="${u.id}" title="Cerrar sesión">🚪</button>
            </div>
          </td>
        `;
        targetTbody.appendChild(tr);
      });
    }

    document.addEventListener("click", (e) => {
      
    const btn = e.target.closest(".icon-btn");
    if (!btn) return;

    const action = btn.dataset.action;
    const id = btn.dataset.id;

    if (action === "edit-user") {
        openUserModalFunc(id);
        return;
    }

    if (action === "edit-room") {
        openRoomModalFunc(id);
        return;
    }

    // === ELIMINAR USUARIO ===
    if (action === "logout") {
        if (!confirm("¿Seguro que quieres eliminar este usuario?")) return;

        fetch("eliminar_usuario.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id })
        })
        .then(r => r.text())
        .then(txt => {
            console.log("Eliminado:", txt);
            loadUsers();
        });

        return;
    }
});


    // backward compatible wrapper (renders into the main tbody as before)
    function renderUsers(list){
      renderUsersList(tbody, list);
      // After rendering users into main table, update horizontal controller visibility
      const hWrap = document.getElementById('hScrollWrap');
      const hRange = document.getElementById('hScroll');
      if(hWrap && hRange && roomsTableWrap){
        // compute overflow amount for the table container
        const max = Math.max(0, roomsTableWrap.scrollWidth - roomsTableWrap.clientWidth);
        if(max > 0){
          hWrap.style.display = 'flex';
          hRange.max = max;
          hRange.value = roomsTableWrap.scrollLeft || 0;
        } else {
          hWrap.style.display = 'none';
        }
      }
    }

    /* ===== filtros y búsqueda ===== */
    function applyFilters(){
      const q = (globalSearch.value || "").toLowerCase().trim();
      const s = statusFilter.value;
      const t = typeFilter.value;
      // If search box has content, perform global search across all datasets
      if(q !== ''){
        const results = [];
        // rooms
        rooms.forEach(r => {
          const hay = ((r.number||'') + ' ' + (r.type||'') + ' ' + (r.desc||'') + ' ' + (r.price||'')).toLowerCase();
          if(hay.includes(q) || String(r.id).includes(q)){
            results.push({ type: 'Habitación', id: r.id, idDisplay: r.number, title: `${r.number} — ${r.type}`, subtitle: `${r.tamano || ''} · ${r.camas ? r.camas+' camas' : ''} · $${Number(r.price).toFixed(2)}`, action: 'edit', actionId: r.id });
          }
        });
        // users
        users.forEach(u => {
          const hay = (String(u.id) + ' ' + (u.email||'') + ' ' + (u.cedula||'') + ' ' + (u.telefono||'')).toLowerCase();
          if(hay.includes(q)){
            results.push({ type: 'Usuario', id: u.id, title: u.email || ('ID:'+u.id), subtitle: `${u.cedula || ''} · ${u.telefono || ''}`, action: 'edit-user', actionId: u.id });
          }
        });
        // reservas
        reservas.forEach(r => {
          const hay = (String(r.id_reserva) + ' ' + String(r.id_usuario) + ' ' + String(r.id_habitaciones) + ' ' + (r.fecha_inicio||'') + ' ' + (r.fecha_fin||'')).toLowerCase();
          if(hay.includes(q)){
            results.push({ type: 'Reserva', id: r.id_reserva, title: `Reserva #${r.id_reserva}`, subtitle: `Usuario ${r.id_usuario} · Hab ${r.id_habitaciones} · ${r.fecha_inicio}→${r.fecha_fin}`, action: 'edit-reserva', actionId: r.id_reserva });
          }
        });
        // tokens
        tokens.forEach(tk => {
          const hay = (String(tk.id) + ' ' + String(tk.user_id) + ' ' + (tk.token_hash||'')).toLowerCase();
          if(hay.includes(q)){
            results.push({ type: 'Token', id: tk.id, title: `Token #${tk.id}`, subtitle: (tk.token_hash || '').slice(0,40), action: 'edit-token', actionId: tk.id });
          }
        });
        renderSearchResults(results);
        return;
      }

      // If we're viewing users, filter users; if reservas, filter reservas; if tokens, filter tokens; otherwise filter rooms
      if(currentView === 'usuario'){
        let filtered = users.filter(u => {
          const matchQ = q === "" || (String(u.id) + " " + (u.email||'')).toLowerCase().includes(q);
          const matchS = !s || String(u.estado_verificacion) === s; // s: '1' or '0'
          let matchT = true;
          if(t === 'with_token') matchT = Boolean(u.token_verificacion && u.token_verificacion.trim() !== '');
          else if(t === 'without_token') matchT = !(u.token_verificacion && u.token_verificacion.trim() !== '');
          return matchQ && matchS && matchT;
        });
        renderUsers(filtered);
        return;
      }

      if(currentView === 'reservas'){
        const userFilterVal = reservaUserSelect ? reservaUserSelect.value : '';

        let filtered = reservas.filter(r => {
          const matchQ = q === "" || (String(r.id_reserva) + " " + String(r.id_usuario) + " " + String(r.id_habitaciones)).toLowerCase().includes(q);
          const matchS = !s || r.estado === s;
          const matchUser = !userFilterVal || String(r.id_usuario) === userFilterVal;
          return matchQ && matchS && matchUser;
        });
        renderReservasView(); // ensure headers and UI set
        renderReservasRows(filtered);
        return;
      }

      if(currentView === 'tokens'){
        const now = new Date();
        let filtered = tokens.filter(tk => {
          const matchQ = q === "" || (String(tk.id) + " " + String(tk.user_id) + " " + (tk.token_hash||'')).toLowerCase().includes(q);
          let matchS = true;
          if(s === 'expired'){
            matchS = tk.fecha_expiracion && new Date(tk.fecha_expiracion) < now;
          } else if(s === 'active'){
            matchS = !tk.fecha_expiracion || new Date(tk.fecha_expiracion) >= now;
          }
          let matchT = true;
          if(t === 'with_expiration') matchT = Boolean(tk.fecha_expiracion && tk.fecha_expiracion.trim() !== '');
          else if(t === 'without_expiration') matchT = !(tk.fecha_expiracion && tk.fecha_expiracion.trim() !== '');
          return matchQ && matchS && matchT;
        });
        renderTokensView(); // ensure headers and UI set
        renderTokens(filtered);
        return;
      }

      let filtered = rooms.filter(r=>{
        const matchQ = q === "" || (r.number + " " + r.type + " " + r.desc + " " + r.price).toLowerCase().includes(q) || (r.id + "").includes(q);
        const matchS = !s || r.status === s;
        const matchT = !t || r.type === t;
        return matchQ && matchS && matchT;
      });
      renderTable(filtered);
    }

    globalSearch.addEventListener("input", applyFilters);
    statusFilter.addEventListener("change", applyFilters);
    typeFilter.addEventListener("change", applyFilters);
    if(reservaUserSelect) reservaUserSelect.addEventListener('change', applyFilters);

    // horizontal controller syncing: control the currently active table container
    const hRangeEl = document.getElementById('hScroll');
    const hWrapEl = document.getElementById('hScrollWrap');
    let activeHContainer = roomsTableWrap; // default

    function syncHRangeToContainer(container){
      if(!hRangeEl || !hWrapEl) return;
      if(!container){ hWrapEl.style.display = 'none'; return; }
      const max = Math.max(0, container.scrollWidth - container.clientWidth);
      if(max > 0){
        hWrapEl.style.display = 'flex';
        hRangeEl.max = max;
        hRangeEl.value = container.scrollLeft || 0;
      } else {
        hWrapEl.style.display = 'none';
      }
    }

    if(hRangeEl){
      const container = roomsTableWrap;
      // when the container scrolls, update range
      container.addEventListener('scroll', ()=>{
        hRangeEl.max = Math.max(0, container.scrollWidth - container.clientWidth);
        hRangeEl.value = container.scrollLeft;
      });
      // when range changes, scroll container
      hRangeEl.addEventListener('input', ()=>{
        if(activeHContainer) activeHContainer.scrollLeft = Number(hRangeEl.value);
      });

      // attach listeners to table wrappers so hovering/focusing makes them active
      [roomsTableWrap, usersTableWrap, reservasTableWrap, tokensTableWrap].forEach(c => {
        if(!c) return;
        c.addEventListener('scroll', ()=>{
          if(activeHContainer === c) hRangeEl.value = c.scrollLeft;
        });
        c.addEventListener('mouseenter', ()=>{ activeHContainer = c; syncHRangeToContainer(c); });
        c.addEventListener('focusin', ()=>{ activeHContainer = c; syncHRangeToContainer(c); });
      });

      // ensure correct max on resize
      window.addEventListener('resize', ()=>{ if(activeHContainer) syncHRangeToContainer(activeHContainer); });

      // initial sync: if any visible table has overflow, use it; otherwise use default
      function findFirstOverflowContainer(){
        const candidates = [roomsTableWrap, usersTableWrap, reservasTableWrap, tokensTableWrap];
        for(const c of candidates){
          if(!c) continue;
          if(getComputedStyle(c).display === 'none') continue;
          if(c.scrollWidth > c.clientWidth) return c;
        }
        return null;
      }

      const initial = findFirstOverflowContainer();
      if(initial) activeHContainer = initial;
      syncHRangeToContainer(activeHContainer);
    }

    /* ===== mobile sidebar toggle ===== */
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileBackdrop = document.getElementById('mobileBackdrop');
    function openSidebarMobile(){
      const sb = document.querySelector('.sidebar');
      if(!sb) return;
      sb.classList.add('open');
      if(mobileBackdrop) mobileBackdrop.style.display = 'block';
      document.body.style.overflow = 'hidden';
      // adjust hScroll left when sidebar open
      if(hWrapEl) hWrapEl.style.left = '260px';
    }
    function closeSidebarMobile(){
      const sb = document.querySelector('.sidebar');
      if(!sb) return;
      sb.classList.remove('open');
      if(mobileBackdrop) mobileBackdrop.style.display = 'none';
      document.body.style.overflow = '';
      if(hWrapEl) hWrapEl.style.left = '0';
    }
    if(mobileMenuBtn) mobileMenuBtn.addEventListener('click', openSidebarMobile);
    if(mobileBackdrop) mobileBackdrop.addEventListener('click', closeSidebarMobile);

    /* ===== top view bar (mobile) interactivity ===== */
    const topViewBar = document.getElementById('topViewBar');
    const topViewBtns = topViewBar ? Array.from(topViewBar.querySelectorAll('button.view-btn')) : [];
    function updateTopBarActive(view){
      topViewBtns.forEach(b=>{
        if(b.dataset.view === view) b.classList.add('active'); else b.classList.remove('active');
      });
    }

    // clicking a top bar button simulates selecting the sidebar menu and switches view
    topViewBtns.forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const view = btn.dataset.view;
        // toggle active class on top bar
        updateTopBarActive(view);
        // find and 'click' the corresponding sidebar link (keeps central logic in menu handler)
        const target = document.querySelector(`.menu a[data-view="${view}"]`);
        if(target) target.click();
        // if on mobile, close sidebar to reveal content
        if(window.innerWidth <= 900) closeSidebarMobile();
      });
    });

    // keep top bar in sync on resize (CSS primarily governs visibility)
    window.addEventListener('resize', ()=>{
      if(window.innerWidth > 900){
        // deactivate top bar buttons
        updateTopBarActive('');
      } else {
        // set active according to currentView
        updateTopBarActive(currentView);
      }
    });

    // update hScrollWrap left on resize depending on sidebar visibility
    window.addEventListener('resize', ()=>{
      const sb = document.querySelector('.sidebar');
      if(!hWrapEl) return;
      if(window.innerWidth <= 900){
        // if sidebar open, leave left at 260, otherwise 0
        if(sb && sb.classList.contains('open')) hWrapEl.style.left = '260px';
        else hWrapEl.style.left = '0';
      } else {
        hWrapEl.style.left = '260px';
      }
      // also re-sync active container
      if(activeHContainer) syncHRangeToContainer(activeHContainer);
    });

    /* ===== acciones de la tabla (delegation) ===== */
    tbody.addEventListener("click", (e)=>{
      const btn = e.target.closest("button");
      if(!btn) return;
      const action = btn.dataset.action;
      const id = Number(btn.dataset.id);

      // handlers for user actions
      if(action === 'edit-user'){
        openUserModal(id);
        return;
      }
      if(action === 'edit-token'){
        openTokenModal(id);
        return;
      }
      if(action === 'delete-token'){
        if(confirm('¿Eliminar este token?')){
          const idx = tokens.findIndex(x=>x.id===id);
          if(idx>=0){ tokens.splice(idx,1); if(currentView==='tokens') renderTokensView(); }
        }
        return;
      }
      if(action === 'logout'){
        // Demo logout action (attached to former "Eliminar" buttons per request)
        if(confirm('Cerrar sesión ahora?')){
          alert('Sesión cerrada (demo)')
          // In a real app here you would clear auth tokens and redirect to login
        }
        return;
      }
      if(action === 'delete-user'){
        if(confirm('¿Eliminar este usuario?')){
          const idx = users.findIndex(x=>x.id===id);
          if(idx>=0){ users.splice(idx,1); if(currentView==='usuario') renderUsuariosView(); }
        }
        return;
      }

      if(action === "edit") openEditModal(id);
      if(action === "delete") {
        if(confirm("¿Eliminar esta habitación?")) {
          const idx = rooms.findIndex(x=>x.id===id);
          if(idx>=0) { rooms.splice(idx,1); applyFilters(); }
        }
      }
      if(action === "toggle"){
        const r = rooms.find(x=>x.id===id);
        if(!r) return;
        // ciclo de estados: available -> occupied -> cleaning -> available
        const order = ["available","occupied","cleaning"];
        const next = order[(order.indexOf(r.status)+1) % order.length];
        r.status = next;
        applyFilters();
      }
      if(action === "edit-reserva"){
        openReservaPanel(id);
        return;
      }
      if(action === "delete-reserva"){
        if(confirm('¿Eliminar esta reserva?')){
          const idx = reservas.findIndex(x=>x.id_reserva===id);
          if(idx>=0){ reservas.splice(idx,1); if(currentView==='reservas') renderReservasView(); }
        }
        return;
      }
    });

    /* ===== modal open/close ===== */
    function openModal(){
      modalBackdrop.style.display = "flex";
      document.body.style.overflow = "hidden";
    }
    function closeModalFunc(){
      modalBackdrop.style.display = "none";
      document.body.style.overflow = "";
      roomForm.reset();
      editId = null;
    }
    addRoomBtn.addEventListener("click", ()=>{
      modalTitle.textContent = "Nueva habitación";
      modalSubtitle.textContent = "Agregar detalles de la habitación";
      openModal();
    });
    // addTokenBtn event listener removed (button eliminated)
    tokenCancelBtn.addEventListener('click', ()=>{ tokenModalBackdrop.style.display='none'; document.body.style.overflow=''; tokenForm.reset(); editTokenId=null; });
    tokenCloseModal.addEventListener('click', ()=>{ tokenModalBackdrop.style.display='none'; document.body.style.overflow=''; tokenForm.reset(); editTokenId=null; });
    tokenModalBackdrop.addEventListener('click', (e)=>{ if(e.target === tokenModalBackdrop){ tokenModalBackdrop.style.display='none'; document.body.style.overflow=''; tokenForm.reset(); editTokenId=null; } });

    function openTokenModal(id){
      const t = tokens.find(x=>x.id===id);
      if(!t) return;
      editTokenId = id;
      tokenModalTitle.textContent = 'Editar token';
      tokenModalSubtitle.textContent = `Editar token ${t.id}`;
      document.getElementById('tokenId').value = t.id;
      document.getElementById('tokenUserId').value = t.user_id;
      document.getElementById('tokenHash').value = t.token_hash;
      // convert datetime to input-friendly format if present
      if(t.fecha_creacion) document.getElementById('tokenFechaCreacion').value = t.fecha_creacion.replace(' ', 'T');
      if(t.fecha_expiracion) document.getElementById('tokenFechaExpiracion').value = t.fecha_expiracion.replace(' ', 'T');
      tokenModalBackdrop.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    }

    tokenForm.addEventListener('submit', (e)=>{
      // e.preventDefault();
      const id = editTokenId ? editTokenId : (tokens.length ? Math.max(...tokens.map(x=>x.id))+1 : 1);
      const user_id = Number(document.getElementById('tokenUserId').value);
      const token_hash = document.getElementById('tokenHash').value.trim();
      const fecha_creacion = document.getElementById('tokenFechaCreacion').value ? document.getElementById('tokenFechaCreacion').value.replace('T',' ') : new Date().toISOString().slice(0,19).replace('T',' ');
      const fecha_expiracion = document.getElementById('tokenFechaExpiracion').value ? document.getElementById('tokenFechaExpiracion').value.replace('T',' ') : '';
      const idx = tokens.findIndex(x=>x.id===id);
      if(idx>=0){
        tokens[idx].user_id = user_id;
        tokens[idx].token_hash = token_hash;
        tokens[idx].fecha_creacion = fecha_creacion;
        tokens[idx].fecha_expiracion = fecha_expiracion;
      } else {
        tokens.push({ id, user_id, token_hash, fecha_creacion, fecha_expiracion });
      }
      if(currentView === 'tokens') renderTokensView();
      tokenModalBackdrop.style.display='none'; document.body.style.overflow=''; tokenForm.reset(); editTokenId=null;
    });
    cancelBtn.addEventListener("click", closeModalFunc);
    closeModal.addEventListener("click", closeModalFunc);
    modalBackdrop.addEventListener("click", (e)=>{ if(e.target === modalBackdrop) closeModalFunc(); });

    /* ===== editar habitación ===== */
    function openEditModal(id){
      const r = rooms.find(x=>x.id===id);
      if(!r) return;
      editId = id;
      modalTitle.textContent = "Editar habitación";
      modalSubtitle.textContent = `Editar habitación ${r.number}`;
      // llenar form
      document.getElementById("roomNumber").value = r.number;
      document.getElementById("roomType").value = r.type;
      document.getElementById("roomPrice").value = r.price;
      document.getElementById("roomCapacity").value = r.capacity;
      // nuevos campos
      document.getElementById("roomCamas").value = r.camas ?? '';
      document.getElementById("roomTamano").value = r.tamano ?? '';
      document.getElementById("roomWifi").checked = Boolean(r.wifi);
      document.getElementById("roomDucha").checked = Boolean(r.ducha);
      document.getElementById("roomDesayuno").checked = Boolean(r.desayuno);
      document.getElementById("roomStatus").value = r.status;
      document.getElementById("roomImage").value = r.image;
      document.getElementById("roomDesc").value = r.desc;
      openModal();
    }

    /* ===== editar usuario (modal) ===== */
    function openUserModal(id){
      const u = users.find(x=>x.id===id);
      if(!u) return;
      editUserId = id;
      userModalTitle.textContent = "Editar usuario";
      userModalSubtitle.textContent = `Editar usuario ${u.email}`;
      // fill form fields
      document.getElementById('userId').value = u.id;
      document.getElementById('userName').value = u.nombre ?? '';
      document.getElementById('userEmail').value = u.email ?? '';
      document.getElementById('userPassword').value = '';
      document.getElementById('userCedula').value = u.cedula ?? '';
      document.getElementById('userTelefono').value = u.telefono ?? '';
      document.getElementById('userEstadoVerificacion').value = u.estado_verificacion === 1 ? '1' : '0';
      document.getElementById('userToken').value = u.token_verificacion ?? '';
      // open modal
      userModalBackdrop.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    }

    /* ===== editar reserva (modal) ===== */
    function openReservaModal(id){
      const r = reservas.find(x=>x.id_reserva===id);
      if(!r) return;
      editReservaId = id;
      document.getElementById('reservaId').value = r.id_reserva;
      if(reservaUsuario){
        // ensure options present
        reservaUsuario.innerHTML = '<option value="">Seleccione usuario</option>' + users.map(u=>`<option value="${u.id}">${u.email || ('ID:'+u.id)}</option>`).join('');
        reservaUsuario.value = r.id_usuario;
      }
      if(reservaHabitacion){
        reservaHabitacion.innerHTML = '<option value="">Seleccione habitación</option>' + rooms.map(rr=>`<option value="${rr.id}">${rr.number} - ${rr.type}</option>`).join('');
        reservaHabitacion.value = r.id_habitaciones;
      }
      if(reservaInicio) reservaInicio.value = r.fecha_inicio;
      if(reservaFin) reservaFin.value = r.fecha_fin;
      if(reservaPrecio) reservaPrecio.value = Number(r.precio_total) || '';
      if(document.getElementById('reservaEstado')) document.getElementById('reservaEstado').value = r.estado;
      document.getElementById('reservaModalTitle').textContent = 'Editar reserva';
      document.getElementById('reservaModalSubtitle').textContent = `Editar reserva ${r.id_reserva}`;
      reservaModalBackdrop.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    }

    /* ===== editar reserva (side panel) ===== */
    const resPanelBackdrop = document.getElementById('resPanelBackdrop');
    const reservaSidePanel = document.getElementById('reservaSidePanel');
    const resSideForm = document.getElementById('reservaSideForm');
    const resSideId = document.getElementById('resSideId');
    const resSideUsuario = document.getElementById('resSideUsuario');
    const resSideHabitacion = document.getElementById('resSideHabitacion');
    const resSideInicio = document.getElementById('resSideInicio');
    const resSideFin = document.getElementById('resSideFin');
    const resSidePrecio = document.getElementById('resSidePrecio');
    const resSideEstado = document.getElementById('resSideEstado');
    const resSideClose = document.getElementById('resSideClose');
    const resSideCancel = document.getElementById('resSideCancel');

    function openReservaPanel(id){
      const r = reservas.find(x=>x.id_reserva===id);
      if(!r) return;
      // populate selects
      resSideId.value = r.id_reserva;
      resSideUsuario.innerHTML = '<option value="">Seleccione usuario</option>' + users.map(u=>`<option value="${u.id}">${u.email || ('ID:'+u.id)}</option>`).join('');
      resSideUsuario.value = r.id_usuario;
      resSideHabitacion.innerHTML = '<option value="">Seleccione habitación</option>' + rooms.map(rr=>`<option value="${rr.id}">${rr.number} - ${rr.type}</option>`).join('');
      resSideHabitacion.value = r.id_habitaciones;
      resSideInicio.value = r.fecha_inicio;
      resSideFin.value = r.fecha_fin;
      resSidePrecio.value = Number(r.precio_total) || '';
      resSideEstado.value = r.estado;
      // show backdrop + panel centered
      if(resPanelBackdrop) resPanelBackdrop.style.display = 'flex';
      reservaSidePanel.style.display = 'flex';
      setTimeout(()=>{
        if(resPanelBackdrop) resPanelBackdrop.style.opacity = '1';
        reservaSidePanel.classList.add('open');
      }, 10);
      document.body.style.overflow = 'hidden';
    }

    function closeReservaPanel(){
      reservaSidePanel.classList.remove('open');
      if(resPanelBackdrop) resPanelBackdrop.style.opacity = '0';
      document.body.style.overflow = '';
      setTimeout(()=>{
        reservaSidePanel.style.display = 'none';
        if(resPanelBackdrop) resPanelBackdrop.style.display = 'none';
      }, 260);
      resSideForm.reset();
    }

    if(resSideClose) resSideClose.addEventListener('click', closeReservaPanel);
    if(resSideCancel) resSideCancel.addEventListener('click', closeReservaPanel);
    if(resPanelBackdrop) resPanelBackdrop.addEventListener('click', closeReservaPanel);

    resSideForm.addEventListener('submit', (e)=>{
      // e.preventDefault();
      const rawId = resSideId.value;
      const id = rawId ? Number(rawId) : null;
      const usuarioId = Number(resSideUsuario.value);
      const habitacionId = Number(resSideHabitacion.value);
      const fecha_inicio = resSideInicio.value;
      const fecha_fin = resSideFin.value;
      const precio = Number(resSidePrecio.value) || 0;
      const estado = resSideEstado.value;
      if(id){
        const idx = reservas.findIndex(x=>x.id_reserva===id);
        if(idx>=0){ reservas[idx].id_usuario = usuarioId; reservas[idx].id_habitaciones = habitacionId; reservas[idx].fecha_inicio = fecha_inicio; reservas[idx].fecha_fin = fecha_fin; reservas[idx].precio_total = precio; reservas[idx].estado = estado; }
      }
      if(currentView === 'reservas') renderReservasView();
      closeReservaPanel();
    });

    function closeUserModalFunc(){
      userModalBackdrop.style.display = 'none';
      document.body.style.overflow = '';
      userForm.reset();
      editUserId = null;
    }

    userCancelBtn.addEventListener('click', closeUserModalFunc);
    userCloseModal.addEventListener('click', closeUserModalFunc);
    userModalBackdrop.addEventListener('click', (e)=>{ if(e.target === userModalBackdrop) closeUserModalFunc(); });

    // Nuevo Usuario button opens the same user modal in "create" mode
    if(addUserBtn){
      addUserBtn.addEventListener('click', ()=>{
        if(currentView !== 'usuario') renderUsuariosView();
        editUserId = null;
        document.getElementById('userId').value = '';
        document.getElementById('userName').value = '';
        document.getElementById('userEmail').value = '';
        document.getElementById('userPassword').value = '';
        document.getElementById('userCedula').value = '';
        document.getElementById('userTelefono').value = '';
        document.getElementById('userEstadoVerificacion').value = '0';
        document.getElementById('userToken').value = '';
        userModalTitle.textContent = 'Nuevo usuario';
        userModalSubtitle.textContent = 'Crear un nuevo usuario';
        userModalBackdrop.style.display = 'flex';
        document.body.style.overflow = 'hidden';
      });
    }

    // Nuevo Reserva button opens the reserva modal in create mode
    if(addReservaBtn){
      addReservaBtn.addEventListener('click', ()=>{
        if(currentView !== 'reservas') renderReservasView();
        document.getElementById('reservaId').value = '';
        editReservaId = null;
        // populate modal selects with up-to-date users and rooms
        if(reservaUsuario){
          reservaUsuario.innerHTML = '<option value="">Seleccione usuario</option>' + users.map(u=>`<option value="${u.id}">${u.email || ('ID:'+u.id)}</option>`).join('');
          reservaUsuario.value = '';
        }
        if(reservaHabitacion){
          reservaHabitacion.innerHTML = '<option value="">Seleccione habitación</option>' + rooms.map(r=>`<option value="${r.id}">${r.number} - ${r.type}</option>`).join('');
          reservaHabitacion.value = '';
        }
        reservaInicio.value = '';
        reservaFin.value = '';
        reservaPrecio.value = '';
        document.getElementById('reservaModalTitle').textContent = 'Nueva reserva';
        document.getElementById('reservaModalSubtitle').textContent = 'Crear reserva';
        reservaModalBackdrop.style.display = 'flex';
        document.body.style.overflow = 'hidden';
      });
    }

    userForm.addEventListener('submit', (e)=>{
    // 🔥 Muy importante:
    // NO interceptar el submit
    // NO hacer nada de JS acá

    return true; // permitir el envío normal al PHP
});

    // reserva modal handlers
    reservaCancelBtn.addEventListener('click', ()=>{ reservaModalBackdrop.style.display='none'; document.body.style.overflow=''; reservaForm.reset(); editReservaId=null; });
    reservaCloseModal.addEventListener('click', ()=>{ reservaModalBackdrop.style.display='none'; document.body.style.overflow=''; reservaForm.reset(); editReservaId=null; });
    reservaModalBackdrop.addEventListener('click', (e)=>{ if(e.target === reservaModalBackdrop){ reservaModalBackdrop.style.display='none'; document.body.style.overflow=''; reservaForm.reset(); editReservaId=null; } });

    let editReservaId = null;
    reservaForm.addEventListener('submit', (e)=>{
      // e.preventDefault();
      const rawId = document.getElementById('reservaId').value;
      const id = rawId ? Number(rawId) : null;
      const usuarioId = Number(reservaUsuario.value);
      const habitacionId = Number(reservaHabitacion.value);
      const fecha_inicio = document.getElementById('reservaInicio').value;
      const fecha_fin = document.getElementById('reservaFin').value;
      const precio = Number(document.getElementById('reservaPrecio').value) || 0;
      const estado = document.getElementById('reservaEstado').value;
      if(id){
        const idx = reservas.findIndex(x=>x.id_reserva===id);
        if(idx>=0){ reservas[idx].id_usuario = usuarioId; reservas[idx].id_habitaciones = habitacionId; reservas[idx].fecha_inicio = fecha_inicio; reservas[idx].fecha_fin = fecha_fin; reservas[idx].precio_total = precio; reservas[idx].estado = estado; }
      } else {
        const newId = reservas.length ? Math.max(...reservas.map(x=>x.id_reserva))+1 : 1;
        reservas.push({ id_reserva: newId, id_usuario: usuarioId, id_habitaciones: habitacionId, fecha_inicio, fecha_fin, precio_total: precio, estado });
      }
      if(currentView === 'reservas') renderReservasView();
      reservaModalBackdrop.style.display='none'; document.body.style.overflow=''; reservaForm.reset(); editReservaId=null;
    });

    /* ===== guardar nueva / editar ===== */
      roomForm.addEventListener("submit", (e)=>{
        // e.preventDefault();
        const data = {
          id: editId || (rooms.length ? Math.max(...rooms.map(x=>x.id)) + 1 : 1),
          number: document.getElementById("roomNumber").value.trim(),
          type: document.getElementById("roomType").value,
          price: Number(document.getElementById("roomPrice").value) || 0,
          capacity: Number(document.getElementById("roomCapacity").value) || 1,
          camas: Number(document.getElementById("roomCamas").value) || 1,
          tamano: document.getElementById("roomTamano").value.trim() || '',
          wifi: Boolean(document.getElementById("roomWifi").checked),
          ducha: Boolean(document.getElementById("roomDucha").checked),
          desayuno: Boolean(document.getElementById("roomDesayuno").checked),
          status: document.getElementById("roomStatus").value,
          image: document.getElementById("roomImage").value || `https://picsum.photos/seed/${Math.random()}/200/120`,
          desc: document.getElementById("roomDesc").value.trim()
        };
        if(editId){
          const idx = rooms.findIndex(x=>x.id===editId);
          if(idx>=0) rooms[idx] = data;
        } else {
          rooms.push(data);
        }
        closeModalFunc();
        applyFilters();
      });

    /* ===== export CSV simple ===== */
    function exportCSV(array){
      const header = ["id","number","type","price","capacity","camas","tamano","wifi","ducha","desayuno","status","desc"];
      const rows = array.map(r => header.map(h => `"${String(r[h] ?? '')}"`).join(","));
      const csv = [header.join(","), ...rows].join("\n");
      const blob = new Blob([csv], {type:"text/csv;charset=utf-8;"});
      const url = URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = "habitaciones.csv";
      a.style.display="none";
      document.body.appendChild(a);
      a.click();
      a.remove();
      URL.revokeObjectURL(url);
    }
    exportBtn.addEventListener("click", ()=> {
      const q = (globalSearch.value || "").toLowerCase().trim();
      // exportar lo filtrado actualmente
      const filtered = Array.from(tbody.querySelectorAll("tr")).map(tr=>{
        const idAttr = tr.querySelector("button[data-id]")?.dataset.id;
        return rooms.find(r=>String(r.id) === String(idAttr));
      }).filter(Boolean);
      exportCSV(filtered.length ? filtered : rooms);
    });

    /* ===== funciones para cambiar vistas (Dashboard / Usuario) ===== */
    function renderDashboardView(){
      currentView = 'dashboard';
      // header for rooms view (columns updated to include features)
      tableHead.innerHTML = `
        <tr>
          <th class="col-photo">Foto</th>
          <th>Habitación</th>
          <th>Tipo</th>
          <th>Precio</th>
          <th>Capacidad</th>
          <th>Camas</th>
          <th>Tamaño</th>
          <th>Wifi</th>
          <th>Ducha</th>
          <th>Desayuno</th>
          <th>Estado</th>
          <th>Descripción</th>
          <th>Acciones</th>
        </tr>
      `;
      // show controls relevant for rooms
      if(controls) controls.style.display = '';
      // restore room filters
      if(statusFilter) statusFilter.innerHTML = `
        <option value="">Filtrar por estado</option>
        <option value="available">Disponible</option>
        <option value="occupied">Ocupada</option>
        <option value="cleaning">En limpieza</option>
      `;
      if(typeFilter) typeFilter.innerHTML = `
        <option value="">Filtrar por tipo</option>
        <option value="Single">Single</option>
        <option value="Double">Double</option>
        <option value="Suite">Suite</option>
      `;
      // show room-specific buttons
      if(addRoomBtn) addRoomBtn.style.display = '';
      if(exportBtn) exportBtn.style.display = '';
      // ensure user-specific controls are hidden when showing habitaciones/dashboard
      if(usersControls) usersControls.style.display = 'none';
      // hide tokens controls/table (tokensControls may not exist if button removed)
      if(tokensControls) tokensControls.style.display = 'none';
      if(tokensTableWrap) tokensTableWrap.style.display = 'none';
      if(usersTableWrap) usersTableWrap.style.display = 'none';
      if(reservasTableWrap) reservasTableWrap.style.display = 'none';
      if(roomsTableWrap) roomsTableWrap.style.display = '';
      // hide reserva-specific controls
      if(addReservaBtn) addReservaBtn.style.display = 'none';
      if(reservaUserSelect) reservaUserSelect.style.display = 'none';
      globalSearch.placeholder = 'Buscar por habitación, cliente o ID...';
      // Cambiar título principal según vista
      const mainTitle = document.getElementById('mainTitle');
      const mainSubtitle = document.getElementById('mainSubtitle');
      if(mainTitle) mainTitle.textContent = 'Gestión de habitaciones';
      if(mainSubtitle) mainSubtitle.textContent = 'Crea, edita y controla el estado y disponibilidad de las habitaciones';
      renderTable(rooms);
      // hide bottom controller when not needed
      const hWrapHide = document.getElementById('hScrollWrap'); if(hWrapHide) hWrapHide.style.display='none';
    }

    function renderUsuariosView(){
      currentView = 'usuario';
      // header for users view (render into dedicated users table)
      const uh = document.getElementById('usersHead');
      if(uh) uh.innerHTML = `
        <tr>
          <th>ID</th>
          <th>Email</th>
          <th>Contraseña</th>
          <th>Cédula</th>
          <th>Teléfono</th>
          <th>Fecha inicio</th>
          <th>Verificado</th>
          <th>Token</th>
          <th>Rol</th>
          <th>Acciones</th>
        </tr>
      `;
      // show the parent controls area but hide room buttons; show user-specific control
      if(controls) controls.style.display = '';
      if(addRoomBtn) addRoomBtn.style.display = 'none';
      if(exportBtn) exportBtn.style.display = 'none';
      if(addReservaBtn) addReservaBtn.style.display = 'none';
      if(usersControls) usersControls.style.display = '';
      // adapt filters for users: status -> Verificado (1/0), type -> token presence
      if(statusFilter){
        statusFilter.innerHTML = `
          <option value="">Filtrar por verificación</option>
          <option value="1">Verificados</option>
          <option value="0">No verificados</option>
        `;
      }
      if(typeFilter){
        typeFilter.innerHTML = `
          <option value="">Filtrar por token</option>
          <option value="with_token">Con token</option>
          <option value="without_token">Sin token</option>
        `;
      }
      // hide tokens controls/table
      if(tokensControls) tokensControls.style.display = 'none';
      if(tokensTableWrap) tokensTableWrap.style.display = 'none';
      // show users table and hide main rooms table
      if(roomsTableWrap) roomsTableWrap.style.display = 'none';
      if(usersTableWrap) usersTableWrap.style.display = '';
      globalSearch.placeholder = 'Buscar usuario por ID o email...';
      // sync bottom horizontal controller for users table
      const hWrap = document.getElementById('hScrollWrap');
      const hRange = document.getElementById('hScroll');
      if(hWrap && hRange && usersTableWrap){
        const container = usersTableWrap;
        const max = Math.max(0, container.scrollWidth - container.clientWidth);
        if(max > 0){ hWrap.style.display = 'flex'; hRange.max = max; hRange.value = container.scrollLeft || 0; }
        else { hWrap.style.display = 'none'; }
      }
      renderUsersList(usersTbody, users);
    }

    // helper to render reservas rows (used by applyFilters)
   function renderReservasRowsTo(targetTbody, list) {
    targetTbody.innerHTML = "";

    if (!list.length) {
        targetTbody.innerHTML = `
            <tr><td colspan="8" style="text-align:center; padding:20px;">
                No se encontraron reservas
            </td></tr>`;
        return;
    }

    list.forEach(r => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${r.id}</td>
            <td>${r.usuario_id}</td>
            <td>${r.habitacion_id}</td>
            <td>${r.fecha_entrada}</td>
            <td>${r.fecha_salida}</td>
            <td>$ ${r.precio_total}</td>
            <td>${r.estado}</td>
            <td>
                <button class="icon-btn edit-reserva" data-id="${r.id}">✏️</button>
                <button class="icon-btn delete-reserva" data-id="${r.id}">🗑️</button>
            </td>
        `;
        targetTbody.appendChild(tr);
    });
}

    // backward compatible wrapper (renders into main tbody)
    function renderReservasRows(list){
      renderReservasRowsTo(tbody, list);
    }

    /* ===== render tokens view ===== */
    function renderTokensView(){
      currentView = 'tokens';
      // hide rooms/users table and controls
      if(controls) controls.style.display = 'none';
      // adapt filters for tokens: status -> active/expired, type -> has expiration / no expiration
      if(statusFilter) statusFilter.innerHTML = `
        <option value="">Filtrar por estado</option>
        <option value="active">Activos</option>
        <option value="expired">Expirados</option>
      `;
      if(typeFilter) typeFilter.innerHTML = `
        <option value="">Filtrar por tipo</option>
        <option value="with_expiration">Con fecha de expiración</option>
        <option value="without_expiration">Sin fecha de expiración</option>
      `;
      if(usersControls) usersControls.style.display = 'none';
      if(addRoomBtn) addRoomBtn.style.display = 'none';
      if(exportBtn) exportBtn.style.display = 'none';
      if(addReservaBtn) addReservaBtn.style.display = 'none';
      if(reservaUserSelect) reservaUserSelect.style.display = 'none';
      if(tokensControls) tokensControls.style.display = '';
      if(roomsTableWrap) roomsTableWrap.style.display = 'none';
      // ensure reservas table (if present) is hidden when viewing tokens
      if(reservasTableWrap) reservasTableWrap.style.display = 'none';
      if(tokensTableWrap) tokensTableWrap.style.display = '';
      // render tokens table head
      const th = document.getElementById('tokensHead');
      if(th) th.innerHTML = `
        <tr>
          <th>ID</th>
          <th>User ID</th>
          <th>Token Hash</th>
          <th>Fecha creación</th>
          <th>Fecha expiración</th>
          <th>Acciones</th>
        </tr>
      `;
      globalSearch.placeholder = 'Buscar token por id o user_id...';
      renderTokens(tokens);
      // hide bottom controller when not needed
      const hWrapHide = document.getElementById('hScrollWrap'); if(hWrapHide) hWrapHide.style.display='none';
    }

    /* ===== render all tables view ===== */
    function renderAllView(){
      currentView = 'todas';
      // Show all wrappers
      if(roomsTableWrap) roomsTableWrap.style.display = '';
      if(usersTableWrap) usersTableWrap.style.display = '';
      if(reservasTableWrap) reservasTableWrap.style.display = '';
      if(tokensTableWrap) tokensTableWrap.style.display = '';

      // Hide single-table head (we'll use each table's own thead)
      if(tableHead) tableHead.innerHTML = '';

      // Rooms header + render
      const mainTitle = document.getElementById('mainTitle');
      const mainSubtitle = document.getElementById('mainSubtitle');
      if(mainTitle) mainTitle.textContent = 'Todas las tablas';
      if(mainSubtitle) mainSubtitle.textContent = 'Vista consolidada: Habitaciones, Usuarios, Reservas y Tokens';

      // rooms
      if(roomsTable){
        const th = document.getElementById('tableHead');
        if(th) th.innerHTML = `
          <tr>
            <th class="col-photo">Foto</th>
            <th>Habitación</th>
            <th>Tipo</th>
            <th>Precio</th>
            <th>Capacidad</th>
            <th>Camas</th>
            <th>Tamaño</th>
            <th>Wifi</th>
            <th>Ducha</th>
            <th>Desayuno</th>
            <th>Estado</th>
            <th>Descripción</th>
            <th>Acciones</th>
          </tr>
        `;
        renderTable(rooms);
      }

      // users
      if(usersTable){
        const uh = document.getElementById('usersHead');
        if(uh) uh.innerHTML = `
          <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Contraseña</th>
            <th>Cédula</th>
            <th>Teléfono</th>
            <th>Fecha inicio</th>
            <th>Verificado</th>
            <th>Token</th>
            <th>Acciones</th>
          </tr>
        `;
        renderUsersList(usersTbody, users);
      }

      // reservas
      if(reservasTable){
        const rh = document.getElementById('reservasHead');
        if(rh) rh.innerHTML = `
          <tr>
            <th>ID Reserva</th>
            <th>ID Usuario</th>
            <th>ID Habitación</th>
            <th>Fecha inicio</th>
            <th>Fecha fin</th>
            <th>Precio total</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        `;
        renderReservasRowsTo(reservasTbody, reservas);
      }

      // tokens
      if(tokensTable){
        const thk = document.getElementById('tokensHead');
        if(thk) thk.innerHTML = `
          <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Token Hash</th>
            <th>Fecha creación</th>
            <th>Fecha expiración</th>
            <th>Acciones</th>
          </tr>
        `;
        renderTokens(tokens);
      }

      // hide global horizontal controller
      const hWrapHide = document.getElementById('hScrollWrap'); if(hWrapHide) hWrapHide.style.display='none';
    }

    function renderTokens(list){
      const tbody = tokensTable.querySelector('tbody');
      tbody.innerHTML = '';
      if(!list.length){
        tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding:30px; color:var(--muted)">No se encontraron tokens</td></tr>';
        return;
      }
      list.forEach(t=>{
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td style="font-weight:700">${t.id}</td>
          <td>${t.user_id}</td>
          <td><small class="muted">${t.token_hash.length>24 ? t.token_hash.slice(0,24)+'...' : t.token_hash}</small></td>
          <td>${t.fecha_creacion}</td>
          <td>${t.fecha_expiracion}</td>
          <td>
            <div class="actions">
              <button class="icon-btn" data-action="edit-token" data-id="${t.id}" title="Editar">✏️</button>
              <button class="icon-btn" data-action="delete-token" data-id="${t.id}" title="Eliminar">🗑️</button>
            </div>
          </td>
        `;
        tbody.appendChild(tr);
      });
    }

    /* ===== render search results (unified across all datasets) ===== */
    function renderSearchResults(results){
      currentView = 'search';
      // Show the main table container and hide dedicated token/reserva wraps
      if(controls) controls.style.display = '';
      if(roomsTableWrap) roomsTableWrap.style.display = '';
      if(tokensTableWrap) tokensTableWrap.style.display = 'none';
      if(reservasTableWrap) reservasTableWrap.style.display = 'none';

      tableHead.innerHTML = `
        <tr>
          <th>Tipo</th>
          <th>Identificador</th>
          <th>Detalle</th>
          <th>Acciones</th>
        </tr>
      `;

      tbody.innerHTML = '';
      if(!results.length){
        tbody.innerHTML = '<tr><td colspan="4" style="text-align:center; padding:30px; color:var(--muted)">No se encontraron resultados</td></tr>';
        return;
      }

      results.forEach(r => {
        const tr = document.createElement('tr');
        // r has fields: type, id, title, subtitle, action, actionId
        tr.innerHTML = `
          <td style="font-weight:700">${r.type}</td>
          <td>${r.idDisplay || r.id}</td>
          <td>
            <div style="font-weight:700">${r.title || ''}</div>
            <div class="muted" style="font-size:12px">${r.subtitle || ''}</div>
          </td>
          <td>
            <div class="actions">
              <button class="icon-btn" data-action="${r.action}" data-id="${r.actionId}" title="Abrir">✏️</button>
            </div>
          </td>
        `;
        tbody.appendChild(tr);
      });
    }

    /* ===== navegación lateral: cambiar vista al hacer clic ===== */
    menu.addEventListener('click', (e)=>{
      const a = e.target.closest('a[data-view]');
      if(!a) return;
      // actualizar activo
      menu.querySelectorAll('a').forEach(x=>x.classList.remove('active'));
      a.classList.add('active');
      const view = a.dataset.view;
      if(view === 'dashboard' || view === 'habitaciones') renderDashboardView();
      else if(view === 'usuario') renderUsuariosView();
      else if(view === 'reservas') renderReservasView();
      else if(view === 'tokens') renderTokensView();
      else if(view === 'todas') renderAllView();
      else {
        // default fallback: dashboard
        renderDashboardView();
      }
      // keep top view bar buttons in sync (if present)
      if(typeof updateTopBarActive === 'function') updateTopBarActive(view);
    });

    /* ===== inicializar tabla por defecto ===== */
    renderDashboardView();
    // sync top bar active state after initial render
    if(typeof updateTopBarActive === 'function') updateTopBarActive('habitaciones');

    /* ===== explicación en consola (para mostrar mientras presentas) ===== */
    console.info("Panel de administración listo. Usa los botones para editar, eliminar o cambiar estado. Puedes crear nuevas habitaciones con '+ Nueva Habitación'.");
    
    document.getElementById("roomForm").addEventListener("submit", function (e) {
    e.preventDefault();

    let est = document.getElementById("roomStatus").value;
    let estado_num = (est === "available") ? 1 : 0;

    const data = {
        nombre_habitacion: document.getElementById("roomNumber").value.trim(),
        tipo: document.getElementById("roomType").value.trim(),
        precio: document.getElementById("roomPrice").value,
        capacidad: document.getElementById("roomCapacity").value,
        camas: document.getElementById("roomCamas").value,
        tamaño: document.getElementById("roomTamano").value.trim(),
        estado: estado_num,
        imagen: document.getElementById("roomImage").value.trim(),
        wifi: document.getElementById("roomWifi").checked ? 1 : 0,
        ducha: document.getElementById("roomDucha").checked ? 1 : 0,
        desayuno: document.getElementById("roomDesayuno").checked ? 1 : 0,
        descripcion: document.getElementById("roomDesc").value.trim(),
    };

    fetch("crear_habitacion.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    })
    .then(r => r.text())
    .then(res => {
        console.log(res);
        if (res.includes("OK")) {
            alert("Habitación creada exitosamente");
            window.location.reload();
        } else {
            alert("Error al crear habitación:\n" + res);
        }
    });
});
    
  </script>
</body>
</html>
