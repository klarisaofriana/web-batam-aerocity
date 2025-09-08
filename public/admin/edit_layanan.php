<?php
$koneksi = new mysqli("localhost", "root", "", "batamaero_system");
if ($koneksi->connect_error) {
  die("Koneksi gagal: " . $koneksi->connect_error);
}

$id = (int) $_GET['id'];
$result = $koneksi->query("SELECT * FROM layanan WHERE id=$id");
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama_layanan'];
  $harga = (int) $_POST['harga_layanan'];
  $desk = $_POST['deskripsi'];

  // cek jika ada upload foto baru
  if (!empty($_FILES['foto_layanan']['name'])) {
    $folder = "foto/";
    if (!is_dir($folder)) mkdir($folder);
    $nama_file = $_FILES['foto_layanan']['name'];
    $tmp = $_FILES['foto_layanan']['tmp_name'];
    $path = $folder . time() . "_" . $nama_file;

    if (move_uploaded_file($tmp, $path)) {
      if (file_exists($data['foto_layanan'])) unlink($data['foto_layanan']); // hapus lama
      $foto = $path;
    }
  } else {
    $foto = $data['foto_layanan'];
  }

  $stmt = $koneksi->prepare("UPDATE layanan SET nama_layanan=?, harga_layanan=?, deskripsi=?, foto_layanan=? WHERE id=?");
  $stmt->bind_param("sissi", $nama, $harga, $desk, $foto, $id);
  $stmt->execute();

  header("Location: layanan_admin.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Layanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
  <h3>Edit Layanan</h3>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Nama Layanan</label>
      <input type="text" class="form-control" name="nama_layanan" value="<?= $data['nama_layanan'] ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Harga Layanan</label>
      <input type="number" class="form-control" name="harga_layanan" value="<?= $data['harga_layanan'] ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Deskripsi</label>
      <textarea class="form-control" name="deskripsi" rows="3" required><?= $data['deskripsi'] ?></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Foto</label><br>
      <img src="<?= $data['foto_layanan'] ?>" width="120" class="mb-2"><br>
      <input type="file" class="form-control" name="foto_layanan" accept="image/*">
    </div>
    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    <a href="layanan_admin.php" class="btn btn-secondary">Kembali</a>
  </form>
</body>
</html>
