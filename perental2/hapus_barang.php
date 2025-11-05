<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'perental') {
  header('Location: ../index.php');
  exit;
}

$id_user = $_SESSION['id_user'];
$id_barang = $_GET['id'] ?? 0;

// Pastikan barang milik perental yang login
$query = mysqli_query($conn, "SELECT * FROM barang WHERE id='$id_barang' AND id_perental='$id_user'");
$data = mysqli_fetch_assoc($query);

if ($data) {
  // hapus foto dari folder
  if ($data['foto'] && file_exists("../uploads/" . $data['foto'])) {
    unlink("../uploads/" . $data['foto']);
  }
  mysqli_query($conn, "DELETE FROM barang WHERE id='$id_barang'");
  echo "<script>alert('barang berhasil dihapus');window.location='dashboard.php';</script>";
} else {
  echo "<script>alert('barang tidak ditemukan atau bukan milik Anda');window.location='dashboard.php';</script>";
}
?>
