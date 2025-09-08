<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

// GET - Ambil semua lokasi
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT * FROM locations ORDER BY created_at DESC";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    $locations = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $locations[] = $row;
    }
    
    echo json_encode($locations);
    exit;
}

// POST - Tambah lokasi baru
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $query = "INSERT INTO locations (name, latitude, longitude, zoom_level, description, image_path) 
              VALUES (:name, :latitude, :longitude, :zoom_level, :description, :image_path)";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':latitude', $data['latitude']);
    $stmt->bindParam(':longitude', $data['longitude']);
    $stmt->bindParam(':zoom_level', $data['zoom_level']);
    $stmt->bindParam(':description', $data['description']);
    $stmt->bindParam(':image_path', $data['image_path']);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Lokasi berhasil ditambahkan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan lokasi']);
    }
    exit;
}

// DELETE - Hapus lokasi
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $query = "DELETE FROM locations WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $data['id']);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Lokasi berhasil dihapus']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus lokasi']);
    }
    exit;
}
?>