<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "batamaero_system");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data layanan dari database
$result = $koneksi->query("SELECT * FROM layanan ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Layanan Kami - Batam Aerocity</title>

    <link rel="icon" href="../images/logo_BA.jpeg" type="brand" />

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css" />

    <!-- Font Awesome untuk Icon -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <style>  
     /* Gaya khusus untuk layanan card */
      .layanan-card {
        transition: transform 0.3s ease;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
      }
      
      .layanan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      }
      
      .card-title {
        color: #1C5DAA; /* Warna biru untuk judul */
        font-size: 1.25rem;
      }
      
      .harga-layanan {
        color: #1c5daa; /* Warna biru untuk harga (sesuai permintaan) */
        font-weight: bold;
        font-size: 1.1rem;
        margin-top: 10px;
      }

      /* Gaya untuk section B-FAST */
      .section-bfast {
        background-color: linear-gradient(135deg, #e0f7fa, #ffffff);
        padding: 40px 0;
        margin-top: 40px;
      }
      
     .bfast-images {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin: 30px 0;
  flex-wrap: wrap; /* biar turun ke bawah di layar kecil */
}

.bfast-img {
  max-width: 100%;   /* biar responsif */
  height: auto;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

      .btn-group {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
      }
      
      .btn-download, .btn-website {
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.3s ease;
      }
      
      .btn-download {
        background-color: #1c5daa;
        color: white;
        border: 2px solid #1c5daa;
      }
      
      .btn-download:hover {
        background-color: #164a8a;
        border-color: #164a8a;
      }
      
      .btn-website {
        background-color: transparent;
        color: #1c5daa;
        border: 2px solid #1c5daa;
      }
      
      .btn-website:hover {
        background-color: #1c5daa;
        color: white;
      }
    </style> 
  </head>
  <body>
    <div class="main-content">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
        <div class="container">
          <!-- Logo -->
          <a class="navbar-brand" href="#">
            <img
              src="../images/logo_BA.jpeg"
              alt="Logo Batam Aerocity"
              class="logo-img"
            />
          </a>

          <!-- Toggler -->
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <!-- Menu -->
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
              <li class="nav-item">
                <a class="nav-link" href="../index.html">Beranda</a>
              </li>
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  data-bs-toggle="dropdown"
                  >Tentang Kami</a
                >
                <ul class="dropdown-menu">
                  <li>
                    <a class="dropdown-item" href="../profile/latar_belakang.html"
                      >Latar Belakang</a
                    >
                  </li>
                  <li>
                    <a class="dropdown-item" href="../profile/tugas_fungsi.html"
                      >Tugas dan Fungsi</a
                    >
                  </li>
                  <li>
                    <a
                      class="dropdown-item"
                      href="../profile/struktur_organisasi.html"
                      >Struktur Organisasi</a
                    >
                  </li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="layananDropdown"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  Layanan
                </a>
                <ul class="dropdown-menu" aria-labelledby="layananDropdown">
                  <li>
                    <a class="dropdown-item" href="../layanan/layanan_kami.php"
                      >Layanan Kami</a
                    >
                  </li>
                  <li>
                    <a class="dropdown-item" href="../layanan/kemitraan.html"
                      >Kemitraan</a
                    >
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../galeri.html">Galeri</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../kontak.html">Kontak</a>
              </li>
            </ul>

            <!-- Tombol Masuk untuk Desktop -->
            <div class="d-flex align-items-center desktop-login-btn">
              <button
                class="btn masuk-btn"
                onclick="window.open('login.html', '_blank')"
              >
                <i class="fa-solid fa-user"></i> Masuk
              </button>
            </div>

            <!-- Tombol Masuk untuk Mobile -->
            <div class="mobile-login-btn">
              <button
                class="btn masuk-btn"
                onclick="window.open('login.html', '_blank')"
              >
                <i class="fa-solid fa-user"></i> Masuk
              </button>
            </div>
          </div>
        </div>
      </nav>


    <script>
    document.addEventListener("DOMContentLoaded", function () {
      const navLinks = document.querySelectorAll('.custom-navbar .nav-link');
      const currentPath = window.location.pathname.split("/").pop() || "index.html";

      // Set active berdasarkan URL
      navLinks.forEach(link => {
        const linkPath = link.getAttribute('href');

        if (linkPath === currentPath) {
          link.classList.add('active');
        }
      });

      // Tambahkan efek klik sementara (hilangkan active di yang lain)
      navLinks.forEach(link => {
        link.addEventListener('click', function () {
          navLinks.forEach(l => l.classList.remove('active'));
          this.classList.add('active');
        });
      });
    });
    </script>

    <!-- Deskripsi -->
    <!-- Layanan Section -->
    <div class="container py-5">
      <h3 class="fw-bold mb-4" style="color:#1C5DAA;">Layanan Kami</h3>

      <div class="row g-4">
        <?php
        // Tampilkan data layanan dari database
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            // Perbaikan path gambar - pastikan path benar
            $gambar_path = $row['foto_layanan'];
            
            // Jika path hanya berisi nama file (tanpa folder), tambahkan path folder
            if (strpos($gambar_path, '/') === false && strpos($gambar_path, '\\') === false) {
                $gambar_path = '../admin/foto/' . $gambar_path;
            }
            // Jika path sudah mengandung "foto/" tapi tanpa "admin/"
            else if (strpos($gambar_path, 'foto/') === 0) {
                $gambar_path = '../admin/' . $gambar_path;
            }
            
           echo '
<div class="col-12 col-sm-6 col-md-4 col-lg-3">
  <div class="card layanan-card h-100">
    <img src="' . $gambar_path . '" 
         class="card-img-top" 
         alt="' . $row['nama_layanan'] . '"
         style="height: 250px; object-fit: cover;"
         onerror="this.src=\'../images/placeholder.jpg\'; this.alt=\'Gambar tidak ditemukan\'">
    <div class="card-body d-flex flex-column">
      <h5 class="card-title fw-bold">' . $row['nama_layanan'] . '</h5>
      <p class="card-text flex-grow-1">' . $row['deskripsi'] . '</p>
      <p class="harga-layanan mt-auto">Rp ' . number_format($row['harga_layanan'], 0, ',', '.') . '</p>
    </div>
  </div>
</div>';

          }
        } else {
          echo '<div class="col-12"><p class="text-center">Tidak ada layanan tersedia.</p></div>';
        }
        ?>
      </div>
    </div>

    <!-- BFAST Section -->
    <div class="section-bfast">
      <div class="container">
        <h3 class="fw-bold mb-3 text-center" style="color:#1C5DAA;">B-FAST</h3>
        <p class="mb-4 text-center">
          Batam Facilities Superapp. Menyediakan lebih dari 10 jenis fasilitas yang siap membantu Anda dalam memenuhi kebutuhan gaya hidup melalui solusi menyeluruh untuk berbagai kebutuhan.
        </p>

        <!-- Gambar -->
        <div class="bfast-images">
          <img src="../images/bfast1.png" alt="B-FAST 1" class="bfast-img" />
          <img src="../images/bfast2.png" alt="B-FAST 2" class="bfast-img" />
        </div>

        <!-- Tombol -->
        <div class="btn-group">
          <!-- Tombol Download (Play Store) -->
          <a href="https://play.google.com/store/apps/details?id=id.go.bpbatam.bfast&hl=id" 
            target="_blank" 
            class="btn-download">
            Download
          </a>

          <!-- Tombol Website -->
          <a href="https://b-fast.bpbatam.go.id/" 
            target="_blank" 
            class="btn-website">
            Situs Website
          </a>
        </div>
      </div>
    </div>

        <!-- Footer -->
    <footer class="text-white pt-4 pb-2">
      <div class="container">
        <div class="row align-items-start">
          <!-- Kiri -->
          <div class="col-lg-6 col-md-12 mb-4 footer-logo">
            <div class="text-md-start footer-content">
              <img
                src="../images/aerocity_logo.png"
                alt="Batam Aerocity"
                style="width: 180px; max-width: 100%"
                class="mb-2"
              />
              <p style="font-size: 0.9rem">
                Aerocity merupakan sebuah pembangunan perekonomian yang
                memusatkan aktivitasnya di area sekitar bandar udara. Dalam
                konsep yang ditawarkan ini, investor dapat menggunakan
                transportasi udara dalam melakukan pengiriman barang.
              </p>
              <div class="social-icons mt-2">
                <a
                  href="https://www.facebook.com/share/1B16ggstpr/?mibextid=wwXIfr"
                  class="text-white me-3"
                  target="_blank"
                  rel="noopener noreferrer"
                >
                  <i class="bi bi-facebook fs-4"></i>
                </a>
                <a
                  href="https://www.instagram.com/bpbatam?igsh=MWJwMzlkNzBhb3AzOQ=="
                  class="text-white"
                  target="_blank"
                  rel="noopener noreferrer"
                >
                  <i class="bi bi-instagram fs-4"></i>
                </a>
              </div>
            </div>
          </div>

          <!-- Kanan -->
          <div
            class="col-lg-6 col-md-12 mb-4 footer-contact d-flex flex-column justify-content-start align-items-center"
          >
            <div class="pad-kontak footer-content">
              <h5 style="font-size: 1.1rem">Kontak</h5>
              <p style="margin-bottom: 0.8rem">
                <i class="bi bi-telephone me-2"></i> +123 456 7890
              </p>
              <p style="margin-bottom: 0.8rem">
                <i class="bi bi-envelope me-2"></i> Batamaerocity@bpbatam.go.id
              </p>
              <p style="margin-bottom: 0">
                <i class="bi bi-geo-alt me-2"></i> Gedung direktorat pengelolaan
                kawasan bandara
              </p>
            </div>
          </div>
        </div>

        <!-- Garis -->
        <hr class="border-light my-2" />

        <!-- Copyright -->
        <p class="footer-copyright mb-0 text-center text-md-start">
          Copyright © 2025 Batam Aerocity, All Rights Reserved.
        </p>
      </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <div id="whatsapp-widget">
      <div class="chat-bubble">Chat dengan kami</div>
      <div class="whatsapp-btn" onclick="toggleChatPopup()">
        <i class="fab fa-whatsapp"></i>
      </div>

      <!-- Popup Chat -->
      <div class="chat-popup" id="chatPopup">
        <div class="chat-header">
          <i class="fab fa-whatsapp"></i> Customer Service
          <span onclick="toggleChatPopup()" style="cursor: pointer"
            >&times;</span
          >
        </div>
        <div class="chat-body">
          <p>Halo 👋<br />Butuh bantuan? Silakan chat kami via WhatsApp.</p>
        </div>
        <div class="chat-footer">
          <a
            href="https://wa.me/6281234567890?text=Halo,%20saya%20mau%20bertanya"
            target="_blank"
          >
            <i class="fab fa-whatsapp"></i> Mulai Chat
          </a>
        </div>
      </div>
    </div>

    <script>
      // WhatsApp widget function
      function toggleChatPopup() {
        const popup = document.getElementById("chatPopup");
        popup.style.display =
          popup.style.display === "block" ? "none" : "block";
      }

      // Close popup when clicking outside
      document.addEventListener("click", function (event) {
        const popup = document.getElementById("chatPopup");
        const whatsappBtn = document.querySelector(".whatsapp-btn");

        if (
          popup.style.display === "block" &&
          !popup.contains(event.target) &&
          !whatsappBtn.contains(event.target)
        ) {
          popup.style.display = "none";
        }
      });

      // Navbar active link handling
      document.addEventListener("DOMContentLoaded", function () {
        const navLinks = document.querySelectorAll(".custom-navbar .nav-link");
        const currentPath =
          window.location.pathname.split("/").pop() || "index.html";

        // Set active berdasarkan URL
        navLinks.forEach((link) => {
          const linkPath = link.getAttribute("href");

          if (linkPath === currentPath) {
            link.classList.add("active");
          }
        });

        // Tambahkan efek klik sementara (hilangkan active di yang lain)
        navLinks.forEach((link) => {
          link.addEventListener("click", function () {
            navLinks.forEach((l) => l.classList.remove("active"));
            this.classList.add("active");
          });
        });
      });
    </script>

    <!-- Bootstrap Icons -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

<?php
// Tutup koneksi database
$koneksi->close();
?>