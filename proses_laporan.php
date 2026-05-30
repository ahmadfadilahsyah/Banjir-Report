<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $jalan = $_POST['jalan'];
    $keterangan = $_POST['keterangan'];
    $gps = $_POST['gps'];

    // Validasi GPS harus terisi
    if(empty($gps)) {
        $_SESSION['success'] = "Lokasi GPS tidak ditemukan. Mohon izinkan akses lokasi.";
        header("Location: index.php");
        exit();
    }

    // Upload foto
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
    $foto_name = time() . "_" . basename($_FILES["foto"]["name"]);
    $target_file = $target_dir . $foto_name;
    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);

    $sql = "INSERT INTO laporan (nama_pelapor, email, jalan, foto, keterangan, gps_location) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nama, $email, $jalan, $foto_name, $keterangan, $gps);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Laporan berhasil dikirim. ID Laporan: " . $conn->insert_id;
    } else {
        $_SESSION['success'] = "Gagal mengirim laporan.";
    }
    header("Location: index.php");
    exit();
}
?>