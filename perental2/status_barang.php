<?php
session_start();
include '../db.php';

// Pastikan hanya admin atau perental yang dapat ubah status
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'perental')) {
    header("Location: ../index.php");
    exit;
}

if (!isset($_GET['id']) || !isset($_GET['status'])) {
    die("Data tidak lengkap!");
}

$id_barang = $_GET['id'];
$status_baru = $_GET['status'];

// Update status barang
$update = mysqli_query($conn, "UPDATE barang SET status='$status_baru' WHERE id='$id_barang'");

if ($update) {
    echo "<script>alert('Status barang berhasil diperbarui!'); 
    window.location='detail_barang.php?id=$id_barang';</script>";
} else {
    echo "Gagal update status: " . mysqli_error($conn);
}
?>
