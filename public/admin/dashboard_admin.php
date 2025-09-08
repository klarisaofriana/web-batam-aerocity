<?php
session_start();

// kalau belum login, redirect
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

// ambil role dari session

?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Batam Aerocity</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <style>
      body {
        background-color: #f8f9fa;
        font-family: "Segoe UI", sans-serif;
      }
      /* Sidebar */
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
      /* Logo Sidebar */
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
      /* Main content */
      .main-content {
        margin-left: 240px;
        padding: 20px;
        transition: margin-left 0.3s;
      }
      .main-content.expanded {
        margin-left: 70px;
      }
      /* Logout tetap di bawah */
      .sidebar .nav li.logout {
        margin-top: auto;
      }
      /* Navbar */
      .navbar {
        position: relative;
        z-index: 1100;
      }
      /* Tombol toggle */
      .btn-outline-primary {
        color: #1c5daa !important;
        border-color: #1c5daa !important;
        background-color: transparent !important;
        box-shadow: none !important;
      }
      .btn-outline-primary:hover,
      .btn-outline-primary:focus {
        background-color: #1c5daa !important;
        color: #fff !important;
        border-color: #1c5daa !important;
      }
      .btn-outline-primary:active {
        background-color: #1c5daa !important;
        color: #fff !important;
        border-color: #1c5daa !important;
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
        <li>
          <a href="dashboard_admin.php" class="nav-link active">
            <i class="bi bi-speedometer2"></i> <span>Beranda</span>
          </a>
        </li>
        <li>
          <a href="peta_admin.php" class="nav-link">
            <i class="bi bi-map"></i> <span>Peta</span>
          </a>
        </li>
        <li>
          <a href="layanan_admin.php" class="nav-link">
            <i class="bi bi-gear"></i> <span>Layanan</span>
          </a>
        </li>
        <li class="logout">
          <a
            href="#"
            data-bs-toggle="modal"
            data-bs-target="#logoutModal"
            class="nav-link"
          >
            <i class="bi bi-box-arrow-right"></i> <span>Keluar</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- Navbar + Konten -->
    <div class="main-content" id="mainContent">
      <nav class="navbar navbar-light bg-light shadow-sm px-3 mb-3">
        <button class="btn btn-outline-primary" id="toggleSidebar">
          <i class="bi bi-list"></i>
        </button>
        <div class="ms-auto d-flex align-items-center">
          <span class="me-2 fw-semibold" id="navbarAdminName"
            >Halo, Admin 👋</span
          >
          <a href="profile_admin.html">
            <img
              id="navbarProfileImg"
              src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
              class="rounded-circle border"
              style="
                width: 40px;
                height: 40px;
                object-fit: cover;
                cursor: pointer;
              "
              alt="Profile"
            />
          </a>
        </div>
      </nav>

      <!-- ==================== KONTEN UTAMA ==================== -->
      <div class="container-fluid">
        <h4 class="mb-4">📊 Dashboard Admin</h4>

        <!-- Statistik -->
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <div class="card shadow-sm border-0">
              <div
                class="card-body d-flex justify-content-between align-items-center"
              >
                <div>
                  <h6 class="text-muted">Total Lokasi</h6>
              
                </div>
                <i class="bi bi-map-fill text-primary fs-1"></i>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card shadow-sm border-0">
              <div
                class="card-body d-flex justify-content-between align-items-center"
              >
                <div>
                  <h6 class="text-muted">Total Layanan</h6>
                
                </div>
                <i class="bi bi-gear-fill text-success fs-1"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Tabel Data Terbaru -->
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h6 class="mb-3">📌 Data Terbaru</h6>
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>Nama Lokasi</th>
                  <th>Layanan</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
             
               
    
                  </td>
                </tr>
               
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- ====================================================== -->
    </div>

    <!-- Modal Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">
              <i class="bi bi-box-arrow-right"></i> Konfirmasi Keluar
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Tutup"
            ></button>
          </div>
          <div class="modal-body">
            Apakah Anda yakin ingin keluar dari beranda?
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Batal
            </button>
            <a href="../index.html" class="btn btn-danger">Keluar</a>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Toggle Sidebar
      document
        .getElementById("toggleSidebar")
        .addEventListener("click", function () {
          document.getElementById("sidebar").classList.toggle("collapsed");
          document.getElementById("mainContent").classList.toggle("expanded");
        });
      document
        .getElementById("toggleSidebar")
        .addEventListener("mouseup", function () {
          this.blur();
        });

      // Ambil data admin dari localStorage
      const adminName = localStorage.getItem("adminName") || "Admin";
      const adminPhoto =
        localStorage.getItem("adminPhoto") ||
        "https://cdn-icons-png.flaticon.com/512/847/847969.png";
      document.getElementById(
        "navbarAdminName"
      ).textContent = `Halo, ${adminName} 👋`;
      document.getElementById("navbarProfileImg").src = adminPhoto;
    </script>
  </body>
</html>
