<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'perental') {
  header('Location: ../index.php');
  exit;
}

$id = $_GET['id'];
$status = $_GET['status'];
$id_perental = $_SESSION['id_user'];

// pastikan transaksi milik mobil dari perental
$q = mysqli_query($conn, "
  SELECT t.id FROM transaksi t
  JOIN mobil m ON t.id_mobil = m.id
  WHERE t.id='$id' AND m.id_perental='$id_perental'
");

if (mysqli_num_rows($q) > 0) {
  mysqli_query($conn, "UPDATE transaksi SET status='$status' WHERE id='$id'");
  echo "<script>alert('Status transaksi diperbarui.');window.location='transaksi_perental.php';</script>";
} else {
  echo "<script>alert('Akses ditolak.');window.location='transaksi_perental.php';</script>";
}
?>
