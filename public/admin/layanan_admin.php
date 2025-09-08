<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "batamaero_system");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Proses tambah data
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama_layanan'];
    $harga = $_POST['harga_layanan'];
    $desk = $_POST['deskripsi'];

    // upload foto
    $foto = $_FILES['foto_layanan']['name'];
    $tmp = $_FILES['foto_layanan']['tmp_name'];
    $folder = "../admin/foto/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $path = $folder . basename($foto);

    if (move_uploaded_file($tmp, $path)) {
        // GANTI DENGAN PREPARED STATEMENT
        $stmt = $koneksi->prepare("INSERT INTO layanan (nama_layanan, harga_layanan, deskripsi, foto_layanan) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $nama, $harga, $desk, $path);
        
        if ($stmt->execute()) {
            echo "<script>alert('Data berhasil ditambah'); window.location='layanan_admin.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Upload foto gagal.";
    }
}

// Proses edit data
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama_layanan'];
    $harga = $_POST['harga_layanan'];
    $desk = $_POST['deskripsi'];
    
    // Jika ada file foto baru diupload
    if (!empty($_FILES['foto_layanan']['name'])) {
        $foto = $_FILES['foto_layanan']['name'];
        $tmp = $_FILES['foto_layanan']['tmp_name'];
        $folder = "foto/";
        $path = $folder . basename($foto);
        
        if (move_uploaded_file($tmp, $path)) {
            // GANTI DENGAN PREPARED STATEMENT
            $stmt = $koneksi->prepare("UPDATE layanan SET nama_layanan=?, harga_layanan=?, deskripsi=?, foto_layanan=? WHERE id=?");
            $stmt->bind_param("sissi", $nama, $harga, $desk, $path, $id);
        } else {
            echo "Upload foto gagal.";
            exit;
        }
    } else {
        // Jika tidak ada foto baru, update tanpa mengubah foto
        // GANTI DENGAN PREPARED STATEMENT
        $stmt = $koneksi->prepare("UPDATE layanan SET nama_layanan=?, harga_layanan=?, deskripsi=? WHERE id=?");
        $stmt->bind_param("sisi", $nama, $harga, $desk, $id);
    }
    
    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diupdate'); window.location='layanan_admin.php';</script>";
    } else {
        echo "Error update: " . $stmt->error;
    }
    $stmt->close();
}

// Proses hapus data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    // GANTI DENGAN PREPARED STATEMENT
    $stmt = $koneksi->prepare("DELETE FROM layanan WHERE id=?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil dihapus'); window.location='layanan_admin.php';</script>";
    } else {
        echo "Error delete: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Batam Aerocity - Layanan</title>
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
      
      /* Tabel kustom */
      .table-custom {
        border-collapse: collapse;
        width: 100%;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
      }
      .table-custom thead {
        background: #1c5daa;
        color: #fff;
      }
      .service-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #ddd;
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
          <a href="dashboard_admin.php" class="nav-link">
            <i class="bi bi-speedometer2"></i> <span>Beranda</span>
          </a>
        </li>
        <li>
          <a href="peta_admin.php" class="nav-link">
            <i class="bi bi-map"></i> <span>Peta</span>
          </a>
        </li>
        <li>
          <a href="layanan_admin.php" class="nav-link active">
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

      <!-- Konten Utama -->
      <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Daftar Layanan</h4>
          <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#modalTambah"
          >
            <i class="bi bi-plus-circle"></i> Tambah Layanan
          </button>
        </div>

        <table class="table table-custom text-center align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Gambar</th>
              <th>Nama</th>
              <th>Harga</th>
              <th>Deskripsi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no=1;
            $res = $koneksi->query("SELECT * FROM layanan ORDER BY id DESC");
            while($row = $res->fetch_assoc()){ 
            ?>
            <tr>
              <td><?= $no++ ?></td>
              <td>
                <?php if($row['foto_layanan']){ ?>
                <img
                  src="<?= $row['foto_layanan'] ?>"
                  class="service-img"
                />
                <?php } ?>
              </td>
              <td><?= $row['nama_layanan'] ?></td>
              <td>
                Rp
                <?= number_format($row['harga_layanan'],0,',','.') ?>
              </td>
              <td><?= $row['deskripsi'] ?></td>
              <td>
                <button
                  class="btn btn-sm btn-warning"
                  data-bs-toggle="modal"
                  data-bs-target="#modalEdit<?= $row['id'] ?>"
                >
                  <i class="bi bi-pencil"></i>
                </button>
                <a
                  href="?hapus=<?= $row['id'] ?>"
                  onclick="return confirm('Yakin hapus?')"
                  class="btn btn-sm btn-danger"
                  ><i class="bi bi-trash"></i
                ></a>
              </td>
            </tr>

            <!-- Modal Edit -->
            <div
              class="modal fade"
              id="modalEdit<?= $row['id'] ?>"
              tabindex="-1"
            >
              <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header bg-primary text-white">
                    <h5>Edit Layanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>" />
                    <div class="modal-body">
                      <div class="mb-3">
                        <label>Nama</label
                        ><input
                          type="text"
                          name="nama_layanan"
                          value="<?= $row['nama_layanan'] ?>"
                          class="form-control"
                          required
                        />
                      </div>
                      <div class="mb-3">
                        <label>Harga</label
                        ><input
                          type="number"
                          name="harga_layanan"
                          value="<?= $row['harga_layanan'] ?>"
                          class="form-control"
                          required
                        />
                      </div>
                      <div class="mb-3">
                        <label>Deskripsi</label
                        ><textarea
                          name="deskripsi"
                          class="form-control"
                          rows="3"
                        ><?= $row['deskripsi'] ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label>Foto (kosongkan jika tidak ganti)</label
                        ><input
                          type="file"
                          name="foto_layanan"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                      >
                        Batal
                      </button>
                      <button
                        type="submit"
                        name="edit"
                        class="btn btn-primary"
                      >
                        Simpan
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title" id="modalTambahLabel">Tambah Layanan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <div class="mb-3">
                <label for="nama_layanan" class="form-label">Nama Layanan</label>
                <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" required>
              </div>

              <div class="mb-3">
                <label for="harga_layanan" class="form-label">Harga Layanan</label>
                <input type="number" class="form-control" id="harga_layanan" name="harga_layanan" required>
              </div>

              <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
              </div>

              <div class="mb-3">
                <label for="foto_layanan" class="form-label">Foto Layanan</label>
                <input type="file" class="form-control" id="foto_layanan" name="foto_layanan" accept="image/*" required>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
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

    <!-- Script -->
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

      // Update tampilan di navbar
      document.getElementById(
        "navbarAdminName"
      ).textContent = `Halo, ${adminName} 👋`;
      document.getElementById("navbarProfileImg").src = adminPhoto;
    </script>
  </body>
</html>