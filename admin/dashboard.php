<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'admin') {
  header('Location: ../index.php');
  exit;
}

$jmlUser = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$jmlMobil = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM mobil"));
$jmlTrans = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transaksi"));
?>
<!DOCTYPE html>
<html>
<head><title>Dashboard Admin</title></head>
<body>
  <h1>Dashboard Admin</h1>
  <p>Total Pengguna: <?= $jmlUser ?></p>
  <p>Total Mobil: <?= $jmlMobil ?></p>
  <p>Total Transaksi: <?= $jmlTrans ?></p>
  <a href="../transaksi/transaksi_admin.php">Kelola Transaksi</a>
  <a href="../logout.php">Logout</a>
</body>
</html>
