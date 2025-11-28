    <?php
    require "../src/connect.php";
    $sql = "SELECT * FROM usuarios";
    $resultado = $conn->query($sql);
    // cargar tokens de recordar_token para el panel
    $sqlTokens = "SELECT * FROM recordar_token";
    $resultadoTokens = $conn->query($sqlTokens);



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
    .table-wrap{ overflow:auto; background:var(--white); border-radius:10px; padding:10px; box-shadow:0 8px 24px rgba(0,0,0,0.04); }

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
      width:100%; border-collapse:collapse; min-width:760px;
    }
    thead th{
      text-align:left; padding:12px 14px; color:var(--muted); font-weight:600;
      border-bottom:1px solid var(--table-border);
    }
    tbody td{
      padding:12px 14px; border-bottom:1px dashed #f0f0f5; vertical-align:middle;
    }
    .col-photo{ width:64px; }
    .room-photo{ width:52px; height:42px; border-radius:8px; object-fit:cover; }

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
      .sidebar{ display:none }
      .main{ padding:14px }
    }

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

    <main class="main">
      <header class="topbar">
        <div class="searchbar card">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16zm9 3-5.2-5.2" stroke="#6b6b87" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
          <input id="globalSearch" placeholder="Buscar por habitación, cliente o ID..." />
        </div>

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
            <label>Precio (USD)</label>
            <input type="number" id="roomPrice" min="0" step="0.01" />
          </div>
          <div class="form-row">
            <label>Capacidad (personas)</label>
            <input type="number" id="roomCapacity" min="1" />
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

        <form id="userForm" style="margin-top:12px">
          <input type="hidden" id="userId" />
          <div class="form-grid">
            <div class="form-row">
              <label>Nombre</label>
              <input type="text" id="userName" required />
            </div>
            <div class="form-row">
              <label>Email</label>
              <input type="email" id="userEmail" required />
            </div>
            <div class="form-row">
              <label>Contraseña (dejar en blanco para no cambiar)</label>
              <input type="password" id="userPassword" />
            </div>
            <div class="form-row">
              <label>Cédula</label>
              <input type="text" id="userCedula" />
            </div>
            <div class="form-row">
              <label>Teléfono</label>
              <input type="text" id="userTelefono" />
            </div>
            <div class="form-row">
              <label>Verificado</label>
              <select id="userEstadoVerificacion"><option value="1">Sí</option><option value="0">No</option></select>
            </div>
            <div style="grid-column:1 / -1;">
              <label>Token de verificación (solo lectura)</label>
              <input type="text" id="userToken" readonly />
            </div>
          </div>

          <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:14px;">
            <button type="button" class="btn btn-ghost" id="userCancelBtn">Cancelar</button>
            <button type="submit" class="btn btn-primary" id="userSaveBtn">Guardar usuario</button>
          </div>
        </form>
      </div>
    </div>

    <script>
        /* ===== Datos de ejemplo: reservas ===== */
        const reservas = [
          { id_reserva: 1, id_usuario: 1, id_habitaciones: 101, fecha_inicio: '2025-11-20', fecha_fin: '2025-11-22', precio_total: 90, estado: 'confirmada' },
          { id_reserva: 2, id_usuario: 2, id_habitaciones: 102, fecha_inicio: '2025-12-01', fecha_fin: '2025-12-03', precio_total: 156, estado: 'pendiente' },
          { id_reserva: 3, id_usuario: 3, id_habitaciones: 201, fecha_inicio: '2025-11-28', fecha_fin: '2025-11-30', precio_total: 320, estado: 'cancelada' }
        ];

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
    const rooms = [
      { id:1, number:"101", type:"Single", price:45, capacity:1, status:"available", image:"https://picsum.photos/seed/101/200/120", desc:"Habitación individual, cama sencilla" },
      { id:2, number:"102", type:"Double", price:78, capacity:2, status:"occupied", image:"https://picsum.photos/seed/102/200/120", desc:"Doble con balcón" },
      { id:3, number:"201", type:"Suite", price:160, capacity:3, status:"available", image:"https://picsum.photos/seed/201/200/120", desc:"Suite superior con sala" },
      { id:4, number:"202", type:"Double", price:85, capacity:2, status:"cleaning", image:"https://picsum.photos/seed/202/200/120", desc:"Doble, vista al jardín" },
      { id:5, number:"301", type:"Suite", price:210, capacity:4, status:"available", image:"https://picsum.photos/seed/301/200/120", desc:"Suite nupcial" },
    ];

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

    let editId = null; // id a editar si aplica
    let editUserId = null; // id del usuario a editar
    let editTokenId = null;
    let currentView = 'dashboard';

    /* ===== Datos de ejemplo: usuarios ===== */
    const users = [
      <?php while ($usuario = $resultado->fetch_assoc()): ?>
        {id: <?php echo $usuario['id'];?>, 
        email: "<?php echo $usuario['email'];?>", 
        password: "<?php echo $usuario['contraseña'];?>", 
        cedula: "<?php echo $usuario['cedula'];?>", 
        telefono: "<?php echo $usuario['telefono'];?>", 
        inicio: "<?php echo $usuario['fecha_creacion'];?>", 
        estado_verificacion: <?php echo isset($usuario['estado_verificacion']) ? (int)$usuario['estado_verificacion'] : 0;?>,
        token_verificacion: "<?php echo isset($usuario['token_verificacion']) ? addslashes($usuario['token_verificacion']) : '';?>"},
      // { id:1, email:'ana@mail.com', password:'pass123', cedula:'12345678', telefono:'3001112222', inicio:'2025-11-20', fin:'2025-11-24' },
      // { id:2, email:'juan@mail.com', password:'abcd456', cedula:'87654321', telefono:'3003334444', inicio:'2025-12-01', fin:'2025-12-05' },
      // { id:3, email:'maria@mail.com', password:'maria789', cedula:'11223344', telefono:'3005556666', inicio:'2025-11-28', fin:'2025-11-30' }
      <?php endwhile; ?>
    ];

    function statusBadgeClass(status){
      switch(status){
        case "available": return "badge available";
        case "occupied": return "badge occupied";
        case "cleaning": return "badge cleaning";
        default: return "badge";
      }
    }

    function renderTable(items){
      tbody.innerHTML = "";
      if(items.length === 0){
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:30px; color:var(--muted)">No se encontraron habitaciones</td></tr>';
        return;
      }
      items.forEach(r=>{
        const tr = document.createElement("tr");

        tr.innerHTML = `
          <td class="col-photo">
            <img class="room-photo" src="${r.image || 'https://picsum.photos/seed/placeholder/200/120'}" alt="foto room ${r.number}">
          </td>
          <td>
            <div style="font-weight:700">${r.number}</div>
            <div class="muted" style="font-size:12px">${r.desc || ''}</div>
          </td>
          <td>${r.type}</td>
          <td>$ ${Number(r.price).toFixed(2)}</td>
          <td>${r.capacity} pax</td>
          <td><span class="${statusBadgeClass(r.status)}">${r.status.charAt(0).toUpperCase() + r.status.slice(1)}</span></td>
          <td>
            <div class="muted" style="font-size:13px">${r.desc || ''}</div>
          </td>
          <td>
            <div class="actions">
              <button class="icon-btn" data-action="edit" data-id="${r.id}" title="Editar">✏️</button>
              <button class="icon-btn" data-action="logout" data-id="${r.id}" title="Cerrar sesión">🚪</button>
              <button class="icon-btn" data-action="toggle" data-id="${r.id}" title="Cambiar estado">🔁</button>
            </div>
          </td>
        `;
        tbody.appendChild(tr);
      });
    }

    /* ===== render de usuarios ===== */
    function renderUsers(list){
      tbody.innerHTML = "";
      if(!list.length){
        tbody.innerHTML = '<tr><td colspan="9" style="text-align:center; padding:30px; color:var(--muted)">No se encontraron usuarios</td></tr>';
        return;
      }
      list.forEach(u=>{
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td style="font-weight:700">${u.id}</td>
          <td>${u.email}</td>
          <td><small class="muted">${u.password}</small></td>
          <td>${u.cedula}</td>
          <td>${u.telefono}</td>
          <td>${u.inicio}</td>
          <td>${u.estado_verificacion === 1 ? '<span style="color:var(--success); font-weight:700">Sí</span>' : '<span style="color:var(--muted)">No</span>'}</td>
          <td><small class="muted">${u.token_verificacion ? (u.token_verificacion.length>24 ? u.token_verificacion.slice(0,20)+ '...' : u.token_verificacion) : ''}</small></td>
          <td>
            <div class="actions">
              <button class="icon-btn" data-action="edit-user" data-id="${u.id}" title="Editar">✏️</button>
              <button class="icon-btn" data-action="logout" data-id="${u.id}" title="Cerrar sesión">🚪</button>
            </div>
          </td>
        `;
        tbody.appendChild(tr);
      });

      // After rendering users, update horizontal controller visibility and range
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

    // horizontal controller syncing
    const hRangeEl = document.getElementById('hScroll');
    if(hRangeEl){
      const container = roomsTableWrap;
      // when the container scrolls, update range
      container.addEventListener('scroll', ()=>{
        hRangeEl.max = Math.max(0, container.scrollWidth - container.clientWidth);
        hRangeEl.value = container.scrollLeft;
      });
      // when range changes, scroll container
      hRangeEl.addEventListener('input', ()=>{
        container.scrollLeft = Number(hRangeEl.value);
      });
      // on window resize update max
      window.addEventListener('resize', ()=>{
        hRangeEl.max = Math.max(0, container.scrollWidth - container.clientWidth);
      });
    }

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
        openReservaModal(id);
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
      e.preventDefault();
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
      e.preventDefault();
      const rawId = document.getElementById('userId').value;
      const id = rawId ? Number(rawId) : null;
      const idx = id ? users.findIndex(x=>x.id===id) : -1;
      const name = document.getElementById('userName').value.trim();
      const email = document.getElementById('userEmail').value.trim();
      const password = document.getElementById('userPassword').value;
      const cedula = document.getElementById('userCedula').value.trim();
      const telefono = document.getElementById('userTelefono').value.trim();
      const estado = Number(document.getElementById('userEstadoVerificacion').value);
      const token = document.getElementById('userToken').value;
      // Update or create local users array (demo). In a real app, submit to server.
      if(idx >= 0){
        users[idx].nombre = name;
        users[idx].email = email;
        if(password) users[idx].password = password; // note: plaintext in demo
        users[idx].cedula = cedula;
        users[idx].telefono = telefono;
        users[idx].estado_verificacion = estado;
        users[idx].token_verificacion = token;
      } else {
        const newId = users.length ? Math.max(...users.map(x=>x.id)) + 1 : 1;
        users.push({ id: newId, email: email, password: password || '', cedula: cedula, telefono: telefono, inicio: new Date().toISOString().slice(0,19).replace('T',' '), estado_verificacion: estado, token_verificacion: token, nombre: name });
      }
      if(currentView === 'usuario') renderUsuariosView();
      closeUserModalFunc();
    });

    // reserva modal handlers
    reservaCancelBtn.addEventListener('click', ()=>{ reservaModalBackdrop.style.display='none'; document.body.style.overflow=''; reservaForm.reset(); editReservaId=null; });
    reservaCloseModal.addEventListener('click', ()=>{ reservaModalBackdrop.style.display='none'; document.body.style.overflow=''; reservaForm.reset(); editReservaId=null; });
    reservaModalBackdrop.addEventListener('click', (e)=>{ if(e.target === reservaModalBackdrop){ reservaModalBackdrop.style.display='none'; document.body.style.overflow=''; reservaForm.reset(); editReservaId=null; } });

    let editReservaId = null;
    reservaForm.addEventListener('submit', (e)=>{
      e.preventDefault();
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
      e.preventDefault();
      const data = {
        id: editId || (rooms.length ? Math.max(...rooms.map(x=>x.id)) + 1 : 1),
        number: document.getElementById("roomNumber").value.trim(),
        type: document.getElementById("roomType").value,
        price: Number(document.getElementById("roomPrice").value) || 0,
        capacity: Number(document.getElementById("roomCapacity").value) || 1,
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
      const header = ["id","number","type","price","capacity","status","desc"];
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
      // header for rooms view (8 columns)
      tableHead.innerHTML = `
        <tr>
          <th class="col-photo">Foto</th>
          <th>Habitación</th>
          <th>Tipo</th>
          <th>Precio</th>
          <th>Capacidad</th>
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
      // header for users view (8 columns)
      tableHead.innerHTML = `
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
      if(roomsTableWrap) roomsTableWrap.style.display = '';
      globalSearch.placeholder = 'Buscar usuario por ID o email...';
      // show bottom horizontal controller for wide tables
      const hWrap = document.getElementById('hScrollWrap');
      const hRange = document.getElementById('hScroll');
      if(hWrap && hRange){
        hWrap.style.display = 'flex';
        // sync max using the visible table container
        const container = roomsTableWrap;
        const max = Math.max(0, container.scrollWidth - container.clientWidth);
        hRange.max = max;
        hRange.value = container.scrollLeft || 0;
      }
      renderUsers(users);
    }

    // helper to render reservas rows (used by applyFilters)
    function renderReservasRows(list){
      tbody.innerHTML = '';
      if(!list.length){
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:30px; color:var(--muted)">No se encontraron reservas</td></tr>';
        return;
      }
      list.forEach(r => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${r.id_reserva}</td>
          <td>${r.id_usuario}</td>
          <td>${r.id_habitaciones}</td>
          <td>${r.fecha_inicio}</td>
          <td>${r.fecha_fin}</td>
          <td>$ ${Number(r.precio_total).toFixed(2)}</td>
          <td>${r.estado.charAt(0).toUpperCase() + r.estado.slice(1)}</td>
          <td>
            <div class="actions">
              <button class="icon-btn" data-action="edit-reserva" data-id="${r.id_reserva}" title="Editar">✏️</button>
              <button class="icon-btn" data-action="delete-reserva" data-id="${r.id_reserva}" title="Eliminar">🗑️</button>
            </div>
          </td>
        `;
        tbody.appendChild(tr);
      });
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
      else {
        // default fallback: dashboard
        renderDashboardView();
      }
    });

    /* ===== inicializar tabla por defecto ===== */
    renderDashboardView();

    /* ===== explicación en consola (para mostrar mientras presentas) ===== */
    console.info("Panel de administración listo. Usa los botones para editar, eliminar o cambiar estado. Puedes crear nuevas habitaciones con '+ Nueva Habitación'.");
  </script>
</body>
</html>
