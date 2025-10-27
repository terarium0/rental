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

// pastikan sewa milik barang dari perental
$q = mysqli_query($conn, "
  SELECT t.id FROM sewa t
  JOIN barang m ON t.id_barang = m.id
  WHERE t.id='$id' AND m.id_perental='$id_perental'
");

if (mysqli_num_rows($q) > 0) {
  mysqli_query($conn, "UPDATE sewa SET status='$status' WHERE id='$id'");
  echo "<script>alert('Status sewa diperbarui.');window.location='transaksi_perental.php';</script>";
} else {
  echo "<script>alert('Akses ditolak.');window.location='transaksi_perental.php';</script>";
}
?>
