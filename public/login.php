<?php
session_start();

$conn = new mysqli("localhost", "root", "", "batamaero_system");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

// Ambil user berdasarkan username
$stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Cek password pakai password_verify
    if (password_verify($password, $row['password'])) {
        $_SESSION['username'] = $username;
        header("Location: ../public/admin/dashboard_admin.php");
        exit;
    } else {
        echo "<script>alert('Password salah!'); window.location.href='../public/login.html';</script>";
    }
} else {
    echo "<script>alert('Username tidak ditemukan!'); window.location.href='../public/login.html';</script>";
}

$stmt->close();
$conn->close();
?>
