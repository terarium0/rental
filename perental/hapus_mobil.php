<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'perental') {
  header('Location: ../index.php');
  exit;
}

$id_user = $_SESSION['id_user'];
$id_mobil = $_GET['id'] ?? 0;

// Pastikan mobil milik perental yang login
$query = mysqli_query($conn, "SELECT * FROM mobil WHERE id='$id_mobil' AND id_perental='$id_user'");
$data = mysqli_fetch_assoc($query);

if ($data) {
  // hapus gambar dari folder
  if ($data['gambar'] && file_exists("../uploads/" . $data['gambar'])) {
    unlink("../uploads/" . $data['gambar']);
  }
  mysqli_query($conn, "DELETE FROM mobil WHERE id='$id_mobil'");
  echo "<script>alert('Mobil berhasil dihapus');window.location='dashboard.php';</script>";
} else {
  echo "<script>alert('Mobil tidak ditemukan atau bukan milik Anda');window.location='dashboard.php';</script>";
}
?>
