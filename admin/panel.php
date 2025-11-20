<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin Panel - Hotel Violeta Boutique</title>
  <style>
    /* ----- Reset básico ----- */
    :root{
      --purple:#5b31d8;
      --purple-dark:#4a26b8;
      --muted:#8c8c9a;
      --bg:#f5f6fb;
      --card:#ffffff;
      --success:#2ecc71;
      --info:#3498db;
      --warning:#f1c40f;
      --danger:#e74c3c;
      --table-border:#ececf4;
      --glass: rgba(255,255,255,0.85);
      font-family: "Inter", "Segoe UI", Roboto, Arial, sans-serif;
    }
    *{box-sizing:border-box}
    body{
      margin:0;
      background:linear-gradient(90deg, rgba(91,49,216,0.12) 0%, rgba(245,246,251,1) 25%);
      color:#222;
      min-height:100vh;
      font-size:14px;
    }

    /* ----- Layout ----- */
    .app {
      display:flex;
      min-height:100vh;
    }
    /* sidebar */
    .sidebar{
      width:260px;
      background:linear-gradient(180deg,var(--purple),var(--purple-dark));
      color:#fff;
      padding:28px 18px;
      display:flex;
      flex-direction:column;
      gap:18px;
    }
    .brand{
      display:flex; align-items:center; gap:12px;
    }
    .logo {
      width:44px; height:44px;
      background:#fff3; border-radius:8px;
      display:flex; align-items:center; justify-content:center;
      font-weight:700;
    }
    .brand h1{ font-size:16px; margin:0; font-weight:600; letter-spacing:0.2px }
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
      flex:1; padding:22px; display:flex; flex-direction:column; gap:18px;
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
      background:var(--card); border-radius:12px; padding:18px;
      box-shadow:0 6px 20px rgba(24,14,82,0.04);
    }

    /* controls */
    .controls{ display:flex; gap:12px; align-items:center; margin-bottom:12px; flex-wrap:wrap; }
    .btn{
      padding:8px 12px; border-radius:10px; border:0; cursor:pointer; font-weight:600;
    }
    .btn-primary{ background:var(--purple); color:#fff }
    .btn-ghost{ background:transparent; border:1px solid var(--table-border); color:var(--muted); }

    .filters{ display:flex; gap:10px; align-items:center; }
    select, input[type="date"]{ padding:8px 10px; border-radius:8px; border:1px solid var(--table-border); }

    /* table */
    .table-wrap{ overflow:auto; }
    table{
      width:100%; border-collapse:collapse; min-width:900px;
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
    .badge.maintenance{ background:var(--danger); }

    .actions{ display:flex; gap:8px; }
    .icon-btn{ background:transparent; border:0; cursor:pointer; padding:6px 8px; border-radius:8px; }
    .icon-btn:hover{ background:#f4f4ff; }

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
      width:680px; max-width:94%; background:var(--card); border-radius:12px; padding:18px;
      box-shadow:0 20px 60px rgba(9,8,29,0.18);
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
        <div class="logo">V</div>
        <div>
          <h1>Violeta Boutique</h1>
          <div style="font-size:12px; opacity:0.9">Admin Panel</div>
        </div>
      </div>

      <nav class="menu">
        <!-- Dashboard eliminado -->
        <!-- 'Reservas' cambiado a 'Usuario' según petición del usuario -->
        <a data-view="usuario">Usuario</a>
        <a data-view="habitaciones">Habitaciones</a>
        <a data-view="reservas">Reservas</a>
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
        <div class="flex" style="align-items:center;">
          <div>
            <!-- Título y subtítulo eliminados -->
          </div>

          <div class="right">
            <div class="controls">
              <div class="filters">
                <select id="statusFilter">
                  <option value="">Filtrar por estado</option>
                  <option value="available">Disponible</option>
                  <option value="occupied">Ocupada</option>
                  <option value="cleaning">En limpieza</option>
                  <option value="maintenance">Mantenimiento</option>
                </select>
                <select id="typeFilter">
                  <option value="">Filtrar por tipo</option>
                  <option value="Single">Single</option>
                  <option value="Double">Double</option>
                  <option value="Suite">Suite</option>
                </select>
              </div>

                <button class="btn btn-ghost" id="exportBtn">Exportar CSV</button>
              <button class="btn btn-primary" id="addRoomBtn">+ Nueva Habitación</button>
            </div>
          </div>
        </div>

        <div style="margin-top:14px" class="table-wrap">
          <table id="roomsTable" aria-describedby="roomsTable">
            <!-- table head will be rendered dynamically depending on the active view -->
            <thead id="tableHead">
            </thead>
            <tbody>
              <!-- JS render -->
            </tbody>
          </table>
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
              <option value="maintenance">Mantenimiento</option>
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

  <script>
        /* ===== Datos de ejemplo: reservas ===== */
        const reservas = [
          { id_reserva: 1, id_usuario: 1, id_habitaciones: 101, fecha_inicio: '2025-11-20', fecha_fin: '2025-11-22', precio_total: 90, estado: 'confirmada' },
          { id_reserva: 2, id_usuario: 2, id_habitaciones: 102, fecha_inicio: '2025-12-01', fecha_fin: '2025-12-03', precio_total: 156, estado: 'pendiente' },
          { id_reserva: 3, id_usuario: 3, id_habitaciones: 201, fecha_inicio: '2025-11-28', fecha_fin: '2025-11-30', precio_total: 320, estado: 'cancelada' }
        ];

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
          if(controls) controls.style.display = 'none';
          globalSearch.placeholder = 'Buscar por reserva, usuario o habitación...';
          tbody.innerHTML = '';
          if(!reservas.length){
            tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:30px; color:var(--muted)">No se encontraron reservas</td></tr>';
            return;
          }
          reservas.forEach(r => {
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
    /* ===== Datos de ejemplo ===== */
    const rooms = [
      { id:1, number:"101", type:"Single", price:45, capacity:1, status:"available", image:"https://picsum.photos/seed/101/200/120", desc:"Habitación individual, cama sencilla" },
      { id:2, number:"102", type:"Double", price:78, capacity:2, status:"occupied", image:"https://picsum.photos/seed/102/200/120", desc:"Doble con balcón" },
      { id:3, number:"201", type:"Suite", price:160, capacity:3, status:"available", image:"https://picsum.photos/seed/201/200/120", desc:"Suite superior con sala" },
      { id:4, number:"202", type:"Double", price:85, capacity:2, status:"cleaning", image:"https://picsum.photos/seed/202/200/120", desc:"Doble, vista al jardín" },
      { id:5, number:"301", type:"Suite", price:210, capacity:4, status:"maintenance", image:"https://picsum.photos/seed/301/200/120", desc:"Suite nupcial" },
    ];

    /* ===== utilidades DOM ===== */
    const tbody = document.querySelector("#roomsTable tbody");
    const tableHead = document.getElementById('tableHead');
    const menu = document.querySelector('.menu');
    const controls = document.querySelector('.controls');
    const globalSearch = document.getElementById("globalSearch");
    const statusFilter = document.getElementById("statusFilter");
    const typeFilter = document.getElementById("typeFilter");
    const addRoomBtn = document.getElementById("addRoomBtn");
    const modalBackdrop = document.getElementById("modalBackdrop");
    const roomForm = document.getElementById("roomForm");
    const modalTitle = document.getElementById("modalTitle");
    const modalSubtitle = document.getElementById("modalSubtitle");
    const cancelBtn = document.getElementById("cancelBtn");
    const closeModal = document.getElementById("closeModal");
    const exportBtn = document.getElementById("exportBtn");

    let editId = null; // id a editar si aplica
    let currentView = 'dashboard';

    /* ===== Datos de ejemplo: usuarios ===== */
    const users = [
      { id:1, email:'ana@mail.com', password:'pass123', cedula:'12345678', telefono:'3001112222', inicio:'2025-11-20', fin:'2025-11-24' },
      { id:2, email:'juan@mail.com', password:'abcd456', cedula:'87654321', telefono:'3003334444', inicio:'2025-12-01', fin:'2025-12-05' },
      { id:3, email:'maria@mail.com', password:'maria789', cedula:'11223344', telefono:'3005556666', inicio:'2025-11-28', fin:'2025-11-30' }
    ];

    function statusBadgeClass(status){
      switch(status){
        case "available": return "badge available";
        case "occupied": return "badge occupied";
        case "cleaning": return "badge cleaning";
        case "maintenance": return "badge maintenance";
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
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:30px; color:var(--muted)">No se encontraron usuarios</td></tr>';
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
          <td>${u.fin}</td>
          <td>
            <div class="actions">
              <button class="icon-btn" data-action="edit-user" data-id="${u.id}" title="Editar">✏️</button>
              <button class="icon-btn" data-action="logout" data-id="${u.id}" title="Cerrar sesión">🚪</button>
            </div>
          </td>
        `;
        tbody.appendChild(tr);
      });
    }

    /* ===== filtros y búsqueda ===== */
    function applyFilters(){
      const q = (globalSearch.value || "").toLowerCase().trim();
      const s = statusFilter.value;
      const t = typeFilter.value;

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

    /* ===== acciones de la tabla (delegation) ===== */
    tbody.addEventListener("click", (e)=>{
      const btn = e.target.closest("button");
      if(!btn) return;
      const action = btn.dataset.action;
      const id = Number(btn.dataset.id);

      // handlers for user actions
      if(action === 'edit-user'){
        alert('Editar usuario: ' + id + ' (no implementado por ahora)');
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
        // ciclo de estados: available -> occupied -> cleaning -> maintenance -> available
        const order = ["available","occupied","cleaning","maintenance"];
        const next = order[(order.indexOf(r.status)+1) % order.length];
        r.status = next;
        applyFilters();
      }
      if(action === "edit-reserva"){
        alert('Editar reserva: ' + id + ' (no implementado por ahora)');
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
      globalSearch.placeholder = 'Buscar por habitación, cliente o ID...';
      // Cambiar título principal según vista
      const mainTitle = document.getElementById('mainTitle');
      const mainSubtitle = document.getElementById('mainSubtitle');
      if(mainTitle) mainTitle.textContent = 'Gestión de habitaciones';
      if(mainSubtitle) mainSubtitle.textContent = 'Crea, edita y controla el estado y disponibilidad de las habitaciones';
      renderTable(rooms);
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
          <th>Fecha finalización</th>
          <th>Acciones</th>
        </tr>
      `;
      // hide room-specific controls
      if(controls) controls.style.display = 'none';
      globalSearch.placeholder = 'Buscar usuario por ID o email...';
      renderUsers(users);
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
