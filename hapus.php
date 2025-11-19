<?php
include_once 'koneksi.php';

$id = $_GET['id'] ?? null;

if ($id) {

    $stmt = $conn->prepare("SELECT gambar FROM data_barang WHERE id_barang = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result && !empty($result['gambar']) && file_exists($result['gambar'])) {
        @unlink($result['gambar']);
    }

    $stmt = $conn->prepare("DELETE FROM data_barang WHERE id_barang = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: index.php");
exit;
?>
