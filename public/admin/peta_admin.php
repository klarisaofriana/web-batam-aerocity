<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Batam Aerocity – Peta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        :root {
            --brand: #1c5daa;
            --brand-dark: #144e8b;
        }
        body {
            background-color: #f8f9fa;
            font-family: "Segoe UI", sans-serif;
        }
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: #1c5daa;
            color: #fff;
            transition: all 0.3s;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }
        .sidebar .nav {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .sidebar .nav li {
            list-style: none;
        }
        .sidebar .nav-link {
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            margin: 3px 0;
            border-radius: 6px;
            text-decoration: none;
            transition: background 0.2s ease;
        }
        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .sidebar.collapsed {
            width: 70px;
        }
        .sidebar.collapsed .nav-link span {
            display: none;
        }
        .sidebar.collapsed .logo img {
            max-width: 50px;
        }
        .sidebar .logo {
            text-align: center;
            margin-bottom: 15px;
        }
        .sidebar .logo img {
            width: 100%;
            max-width: 160px;
            height: auto;
            object-fit: contain;
            display: block;
            margin: 0 auto;
            transition: all 0.3s ease;
        }
        .main-content {
            margin-left: 240px;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        .main-content.expanded {
            margin-left: 70px;
        }
        .sidebar .nav li.logout {
            margin-top: auto;
        }
        .navbar {
            position: relative;
            z-index: 1100;
        }
        #toggleSidebar {
            color: #1c5daa !important;
            border-color: #1c5daa !important;
            background-color: transparent !important;
            transition: all 0.2s ease-in-out;
            box-shadow: none !important;
        }
        #toggleSidebar:hover,
        #toggleSidebar:focus {
            background-color: #1c5daa !important;
            color: #fff !important;
            border-color: #1c5daa !important;
            transform: scale(1.05);
        }
        #toggleSidebar:active {
            background-color: #144e8b !important;
            color: #fff !important;
            border-color: #144e8b !important;
            transform: scale(0.95);
        }
        #toggleSidebar:focus,
        #toggleSidebar:active,
        #toggleSidebar.show,
        #toggleSidebar:focus-visible {
            background-color: transparent !important;
            color: #1c5daa !important;
            border-color: #1c5daa !important;
            box-shadow: none !important;
        }
        #map {
            height: 450px; 
            border-radius: 12px;
        }
        .map-instruction {
            margin-top: 4px;
        }
        .alert-info {
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: .5rem !important;
        }
        h4 {
            color: var(--brand);
            font-weight: 600;
        }
        #fitAllBtn:focus,
        #fitAllBtn:active,
        #fitAllBtn.show,
        #fitAllBtn:focus-visible {
            background-color: transparent !important;
            color: #1c5daa !important;
            border-color: #1c5daa !important;
            box-shadow: none !important;
        }
        #fitAllBtn:hover {
            background-color: #1c5daa !important;
            color: #fff !important;
            border-color: #1c5daa !important;
            transform: scale(1.05);
        }
        .form-container {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            height: 100%;
        }
        .row.g-4.align-items-stretch {
            margin-top: 0.5rem;
        }
        .form-container {
            background: #fff;
            padding: 24px 24px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }
        .form-title {
            color: var(--brand);
            margin-bottom: 12px;
            font-weight: 700;
            font-size: 18px;
        }
        .form-container label {
            display: block;
            margin-bottom: 6px;
            color: var(--brand);
            font-size: 14px;
        }
        .form-container input,
        .form-container textarea,
        .form-container select {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 12px;
            border: 1px solid #dcdfe4;
            border-radius: 8px;
            font-size: 14px;
        }
        .btn-brand {
            background: var(--brand);
            color: #fff;
            border: none;
        }
        .btn-brand:hover {
            background: var(--brand-dark);
            color: #fff;
        }
        .toolbar {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .toolbar .btn {
            border-radius: 10px;
        }
        .table thead th {
            background: var(--brand);
            color: #fff;
        }
        .badge-ghost {
            background: #eef5ff;
            color: var(--brand);
            border: 1px solid #d7e6ff;
        }
        .modal-header {
            background: var(--brand);
            color: #fff;
        }
        .img-preview {
            width: 100%;
            max-height: 180px;
            object-fit: cover;
            border-radius: 8px;
            display: none;
        }
        .coordinate-display {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(255, 255, 255, 0.9);
            padding: 8px 12px;
            border-radius: 4px;
            z-index: 1000;
            font-size: 14px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            pointer-events: none;
        }
        @media (max-width: 991.98px) {
            #map {
                height: 380px;
            }
            .toolbar {
                flex-wrap: wrap;
            }
        }
        #fitAllBtn {
            color: var(--brand) !important;
            border-color: var(--brand) !important;
            background-color: transparent !important;
            transition: all 0.2s ease-in-out;
            box-shadow: none !important;
        }
        #fitAllBtn:hover {
            background-color: var(--brand) !important;
            color: #fff !important;
            border-color: var(--brand) !important;
            transform: scale(1.05);
        }
        #fitAllBtn:active {
            background-color: var(--brand-dark) !important;
            color: #fff !important;
            border-color: var(--brand-dark) !important;
            transform: scale(0.95);
        }
        #fitAllBtn:focus,
        #fitAllBtn:focus-visible {
            box-shadow: none !important;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar p-3" id="sidebar">
        <div class="logo">
            <img src="../images/logo_BA.jpeg" alt="Logo Perusahaan" />
        </div>
        <ul class="nav flex-column">
            <li><a href="dashboard_admin.php" class="nav-link"><i class="bi bi-speedometer2"></i> <span>Beranda</span></a></li>
            <li><a href="peta_admin.php" class="nav-link active"><i class="bi bi-map"></i> <span>Peta</span></a></li>
            <li><a href="layanan_admin.php" class="nav-link"><i class="bi bi-gear"></i> <span>Layanan</span></a></li>
            <li class="logout"><a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" class="nav-link"><i class="bi bi-box-arrow-right"></i> <span>Keluar</span></a></li>
        </ul>
    </div>

    <!-- Navbar + Konten -->
    <div class="main-content" id="mainContent">
        <nav class="navbar navbar-light bg-light shadow-sm px-3 mb-3">
            <button class="btn btn-outline-primary" id="toggleSidebar"><i class="bi bi-list"></i></button>
            <div class="ms-auto d-flex align-items-center">
                <span class="me-2 fw-semibold" id="navbarAdminName">Halo, Admin 👋</span>
                <a href="profile_admin.html">
                    <img id="navbarProfileImg" src="https://cdn-icons-png.flaticon.com/512/847/847969.png" class="rounded-circle border" style="width: 40px; height: 40px; object-fit: cover; cursor: pointer;" alt="Profile" />
                </a>
            </div>
        </nav>

        <div class="container-xxl py-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="mb-0">Atur Lokasi Peta</h4>
                        <div class="toolbar">
                            <button class="btn btn-outline-success btn-sm" id="addLocationBtn"><i class="bi bi-plus-circle"></i> Tambah dari Peta</button>
                            <button id="fitAllBtn" class="btn btn-outline-primary btn-sm"><i class="bi bi-arrows-fullscreen"></i> Tampilkan Semua</button>
                        </div>
                    </div>
                    <div class="alert alert-info small py-2 px-3 mb-2">👉 Klik pada peta untuk menentukan lokasi baru, lalu isi detail pada form atau gunakan tombol <b>Tambah dari Peta</b>.</div>
                </div>

                <div class="row g-4 align-items-stretch mt-2">
                    <!-- Peta -->
                    <div class="col-lg-8 d-flex">
                        <div id="map" class="flex-grow-1 h-100">
                            <div class="coordinate-display" id="coordinateDisplay">Lat: 0.000000, Lng: 0.000000</div>
                        </div>
                    </div>

                    <!-- Form manual -->
                    <div class="col-lg-4 d-flex">
                        <div class="form-container flex-grow-1">
                            <div class="form-title">Tambah Lokasi (Manual)</div>
                            <div class="small text-muted mb-2">Klik peta untuk auto-isi lat/lng atau isi manual di bawah.</div>
                            <form id="manualForm">
                                <label>Latitude</label>
                                <input type="text" id="latitude" placeholder="Contoh: 1.116415" name="latitude" required/>
                                <label>Longitude</label>
                                <input type="text" id="longitude" placeholder="Contoh: 104.116058" name="longitude" required/>
                                <label>Zoom</label>
                                <input type="number" id="zoom" value="12" min="1" max="20" />
                                <label>Nama Lokasi</label>
                                <input type="text" id="note" placeholder="Contoh: Kantor Utama" name="nama_lokasi" required/>
                                <div class="mb-3">
                                    <label for="fotoManual" class="form-label">Upload Foto</label>
                                    <input type="file" id="fotoManual" accept="image/*" class="form-control" name="upload_foto"/>
                                </div>
                                <div class="d-grid gap-2 mt-2">
                                    <button class="btn btn-brand" id="updateBtn" type="submit"><i class="bi bi-plus-circle me-1"></i> Tambahkan</button>
                                    <button class="btn btn-outline-secondary" id="closeBtn" type="reset">Reset Form</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabel -->
                <div class="card mt-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Daftar Lokasi</h5>
                            <div class="toolbar">
                                <button class="btn btn-outline-danger" id="clearAllBtn"><i class="bi bi-trash3"></i> Hapus Semua</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 56px">#</th>
                                        <th>Nama</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Gambar</th>
                                        <th style="width: 160px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="lokasiTable"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Lokasi -->
    <div class="modal fade" id="lokasiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-geo-alt"></i> Tambah Lokasi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="lokasiForm">
                        <input type="hidden" id="latInput" />
                        <input type="hidden" id="lngInput" />
                        <div class="mb-2">
                            <label class="form-label">Nama Lokasi</label>
                            <input type="text" id="noteInput" class="form-control" required />
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Deskripsi</label>
                            <textarea id="descInput" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Upload Gambar (opsional)</label>
                            <input type="file" id="imgInput" class="form-control" accept="image/*" />
                            <img id="imgPreview" class="img-preview mt-2" alt="Preview" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-light btn-brand" id="saveLokasiBtn">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-box-arrow-right"></i> Konfirmasi Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">Apakah Anda yakin ingin keluar dari halaman admin?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="../index.html" class="btn btn-danger">Keluar</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    /* ===================== VARIABEL & STATE ===================== */
    let map = L.map("map").setView([1.116415, 104.116058], 12);
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "&copy; OpenStreetMap",
    }).addTo(map);

    let markersLayer = L.layerGroup().addTo(map);
    let lokasiList = [];
    const tbody = document.getElementById("lokasiTable");
    let currentMarker = null;

    /* ===================== SIDEBAR TOGGLE ===================== */
    document.getElementById("toggleSidebar").addEventListener("click", () => {
        document.getElementById("sidebar").classList.toggle("collapsed");
        document.getElementById("mainContent").classList.toggle("expanded");
    });

    // Navbar data
    document.getElementById("navbarAdminName").textContent =
        "Halo, " + (localStorage.getItem("adminName") || "Admin") + " 👋";
    document.getElementById("navbarProfileImg").src =
        localStorage.getItem("adminPhoto") ||
        "https://cdn-icons-png.flaticon.com/512/847/847969.png";

    // Highlight menu aktif sesuai halaman
    const currentPage = window.location.pathname.split("/").pop(); 
    document.querySelectorAll(".sidebar .nav-link").forEach(link => {
        const linkPage = link.getAttribute("href");
        if (linkPage === currentPage) {
            link.classList.add("active");
        } else {
            link.classList.remove("active");
        }
    });

    /* ===================== UTIL ===================== */
    function formatNum(num) {
        return parseFloat(num).toFixed(6);
    }

    /* ===================== LOAD DATA DARI API ===================== */
    async function loadLocations() {
        try {
            const response = await fetch('../api/locations.php');
            const locations = await response.json();
            lokasiList = locations;
            renderMarkers();
            renderTable();
        } catch (error) {
            console.error('Error loading locations:', error);
            // Fallback ke localStorage jika API tidak tersedia
            lokasiList = JSON.parse(localStorage.getItem("lokasiList") || "[]");
            renderMarkers();
            renderTable();
        }
    }

    /* ===================== RENDER MARKER ===================== */
    function renderMarkers() {
        markersLayer.clearLayers();

        lokasiList.forEach((location) => {
            const marker = L.marker([location.latitude, location.longitude]).addTo(markersLayer);

            // bikin isi popup
            let popupContent = `<b>${location.name}</b><br>${formatNum(location.latitude)}, ${formatNum(location.longitude)}`;
            if (location.image_path) {
                popupContent += `<br><img src="${location.image_path}" 
                    style="margin-top:6px;width:180px;max-height:120px;object-fit:cover;border-radius:8px;border:1px solid #ccc">`;
            }

            marker.bindPopup(popupContent);
        });
    }

    /* ===================== FIT ALL ===================== */
    function fitAll() {
        const markers = markersLayer.getLayers();
        if (markers.length === 0) return;

        if (markers.length === 1) {
            map.setView(markers[0].getLatLng(), 15);
        } else {
            const bounds = L.latLngBounds(markers.map(m => m.getLatLng()));
            map.fitBounds(bounds.pad(0.2));
        }
    }

    document.getElementById("fitAllBtn").addEventListener("click", fitAll);

    /* ===================== TAMPILKAN KOORDINAT ===================== */
    function updateCoordinateDisplay(lat, lng) {
        document.getElementById("coordinateDisplay").textContent = 
            `Lat: ${formatNum(lat)}, Lng: ${formatNum(lng)}`;
    }

    // Update koordinat saat mouse bergerak di peta
    map.on('mousemove', (e) => {
        updateCoordinateDisplay(e.latlng.lat, e.latlng.lng);
    });

    // Update koordinat saat peta diklik
    map.on('click', (e) => {
        const { lat, lng } = e.latlng;
        updateCoordinateDisplay(lat, lng);
        
        // Isi form manual dengan koordinat yang diklik
        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lng.toFixed(6);
        
        // Hapus marker sebelumnya jika ada
        if (currentMarker) {
            map.removeLayer(currentMarker);
        }
        
        // Tambahkan marker sementara
        currentMarker = L.marker([lat, lng]).addTo(map)
            .bindPopup("Lokasi yang dipilih: " + lat.toFixed(6) + ", " + lng.toFixed(6))
            .openPopup();
    });

    /* ===================== RENDER TABEL ===================== */
    function renderTable() {
        tbody.innerHTML = "";
        
        if (lokasiList.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data lokasi</td></tr>`;
            return;
        }
        
        lokasiList.forEach((location, i) => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${i + 1}</td>
                <td class="fw-semibold">${location.name}</td>
                <td>${formatNum(location.latitude)}</td>
                <td>${formatNum(location.longitude)}</td>
                <td>
                ${
                    location.image_path
                    ? `<img src="${location.image_path}" style="width:52px;height:36px;object-fit:cover;border-radius:6px;border:1px solid #e3e6ea">`
                    : `<span class="text-muted">-</span>`
                }
                </td>
                <td>
                <div class="btn-group">
                    <button class="btn btn-sm btn-outline-primary" onclick="panToLocation(${location.latitude}, ${location.longitude})">
                        <i class="bi bi-crosshair"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="hapusLokasi(${location.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    /* ===================== ADD LOCATION DARI PETA ===================== */
    document.getElementById("addLocationBtn").addEventListener("click", () => {
        Swal.fire("📍 Klik peta untuk pilih lokasi", "Setelah klik, isi detail lalu simpan.", "info");
        
        // sekali klik di peta → ambil koordinat & buka modal form
        map.once("click", (e) => {
            const { lat, lng } = e.latlng;
            document.getElementById("latInput").value = lat;
            document.getElementById("lngInput").value = lng;
            const modal = new bootstrap.Modal(document.getElementById("lokasiModal"));
            modal.show();
        });
    });

    /* ===================== TAMBAH LOKASI BARU KE DATABASE ===================== */
    async function tambahLokasiBaru(locationData) {
        try {
            const response = await fetch('../api/locations.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(locationData)
            });
            
            const result = await response.json();
            
            if (result.status === 'success') {
                Swal.fire("Berhasil!", result.message, "success");
                loadLocations(); // Reload data dari server
            } else {
                Swal.fire("Error!", result.message, "error");
            }
        } catch (error) {
            console.error('Error adding location:', error);
            Swal.fire("Error!", "Gagal menambahkan lokasi", "error");
        }
    }

    /* ===================== SAVE LOKASI DARI MODAL ===================== */
    document.getElementById("saveLokasiBtn").addEventListener("click", () => {
        const lat = parseFloat(document.getElementById("latInput").value);
        const lng = parseFloat(document.getElementById("lngInput").value);
        const name = document.getElementById("noteInput").value.trim();
        const description = document.getElementById("descInput").value.trim();

        if (!name) {
            Swal.fire("Oops", "Nama lokasi wajib diisi!", "warning");
            return;
        }

        const locationData = {
            name: name,
            latitude: lat,
            longitude: lng,
            zoom_level: 12,
            description: description,
            image_path: "" // Anda bisa menambahkan upload image nanti
        };

        tambahLokasiBaru(locationData);

        // reset modal
        document.getElementById("lokasiForm").reset();
        document.getElementById("imgPreview").style.display = "none";

        // tutup modal
        bootstrap.Modal.getInstance(document.getElementById("lokasiModal")).hide();
    });

    document.getElementById("imgInput").addEventListener("change", (e) => {
        const file = e.target.files[0];
        const preview = document.getElementById("imgPreview");
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = "block";
        } else {
            preview.style.display = "none";
        }
    });

    /* ===================== MANUAL FORM (Tambah & Reset) ===================== */
    function resetManualForm(e) {
        if (e) e.preventDefault();
        document.getElementById('latitude').value = '';
        document.getElementById('longitude').value = '';
        document.getElementById('note').value = '';
        document.getElementById('zoom').value = 12;
        document.getElementById('fotoManual').value = '';
        
        // Hapus marker sementara
        if (currentMarker) {
            map.removeLayer(currentMarker);
            currentMarker = null;
        }
    }

    async function addManualLocation(e) {
        if (e) e.preventDefault();

        const lat  = parseFloat(document.getElementById('latitude').value);
        const lng  = parseFloat(document.getElementById('longitude').value);
        const zoom = parseInt(document.getElementById('zoom').value, 10) || 12;
        const name = document.getElementById('note').value.trim();

        if (!name) {
            Swal.fire('Oops', 'Nama lokasi wajib diisi!', 'warning');
            return;
        }
        if (!Number.isFinite(lat) || !Number.isFinite(lng) || Math.abs(lat) > 90 || Math.abs(lng) > 180) {
            Swal.fire('Koordinat tidak valid', 'Isi latitude/longitude yang benar.', 'warning');
            return;
        }

        const locationData = {
            name: name,
            latitude: lat,
            longitude: lng,
            zoom_level: zoom,
            description: "",
            image_path: ""
        };

        await tambahLokasiBaru(locationData);
        resetManualForm();
    }

    // Hubungkan tombolnya
    document.getElementById('manualForm').addEventListener('submit', addManualLocation);
    document.getElementById('closeBtn').addEventListener('click', resetManualForm);

    /* ===================== GLOBAL HELPERS ===================== */
    function panToLocation(lat, lng) {
        map.setView([lat, lng], 16);
    }

    async function hapusLokasi(id) {
        const result = await Swal.fire({
            title: "Yakin hapus?",
            text: "Lokasi ini akan dihapus permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Ya, hapus!",
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch('../api/locations.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id })
                });
                
                const result = await response.json();
                
                if (result.status === 'success') {
                    Swal.fire("Terhapus!", result.message, "success");
                    loadLocations(); // Reload data dari server
                } else {
                    Swal.fire("Error!", result.message, "error");
                }
            } catch (error) {
                console.error('Error deleting location:', error);
                Swal.fire("Error!", "Gagal menghapus lokasi", "error");
            }
        }
    }

    document.getElementById("clearAllBtn").addEventListener("click", async () => {
        const result = await Swal.fire({
            title: "Yakin hapus semua?",
            text: "Semua data lokasi akan dihapus permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Ya, hapus semua!",
        });

        if (result.isConfirmed) {
            // Hapus semua data dari database
            try {
                // Anda perlu mengimplementasikan endpoint untuk hapus semua di API
                // Untuk sekarang, kita akan hapus satu per satu
                for (const location of lokasiList) {
                    await fetch('../api/locations.php', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: location.id })
                    });
                }
                
                Swal.fire("Terhapus!", "Semua lokasi berhasil dihapus.", "success");
                loadLocations(); // Reload data dari server
            } catch (error) {
                console.error('Error deleting all locations:', error);
                Swal.fire("Error!", "Gagal menghapus semua lokasi", "error");
            }
        }
    });

    // Initial render saat load
    document.addEventListener('DOMContentLoaded', function() {
        loadLocations();
        updateCoordinateDisplay(1.116415, 104.116058);
    });
</script>
</body>
</html>