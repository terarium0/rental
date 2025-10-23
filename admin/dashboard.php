<?php
session_start();
include '../db.php';

// pastikan hanya admin yang bisa akses
if ($_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit;
}

// ambil data ringkasan
$total_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM users"))['jml'];
$total_mobil = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM mobil"))['jml'];
$total_transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM transaksi"))['jml'];
$total_tersedia = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM mobil WHERE status='tersedia'"))['jml'];
$total_tidak = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM mobil WHERE status='tidak tersedia'"))['jml'];

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f5f5f5; }
    .nav { background: #333; color: white; padding: 10px; }
    .nav a { color: white; text-decoration: none; margin-right: 10px; }
    h2 { margin-left: 50px; }
    .container { display: flex; flex-wrap: wrap; justify-content: center; margin-top: 30px; }
    .card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        width: 220px;
        height: 120px;
        margin: 15px;
        text-align: center;
        padding: 20px;
        transition: transform 0.2s;
    }
    .card:hover { transform: scale(1.05); }
    .card h3 { margin: 10px 0 5px 0; }
    .card p { font-size: 28px; font-weight: bold; margin: 0; }
    .mobil { border-top: 5px solid #007BFF; }
    .user { border-top: 5px solid #28A745; }
    .transaksi { border-top: 5px solid #FFC107; }
    .tersedia { border-top: 5px solid #17A2B8; }
    .tidak { border-top: 5px solid #DC3545; }
  </style>
</head>
<body>

<div class="nav">
  <a href="dashboard.php">🏠 Dashboard</a>
  <a href="data_mobil.php">🚗 Data Mobil</a>
  <a href="data_user.php">👥 Data User</a>
  <a href="data_transaksi.php">📋 Data Transaksi</a>
  <a href="../logout.php">🚪 Logout</a>
</div>

<h2>Selamat Datang, Admin</h2>

<div class="container">
  <div class="card user">
    <h3>Total User</h3>
    <p><?= $total_user ?></p>
  </div>

  <div class="card mobil">
    <h3>Total Mobil</h3>
    <p><?= $total_mobil ?></p>
  </div>

  <div class="card transaksi">
    <h3>Total Transaksi</h3>
    <p><?= $total_transaksi ?></p>
  </div>

  <div class="card tersedia">
    <h3>Mobil Tersedia</h3>
    <p><?= $total_tersedia ?></p>
  </div>

  <div class="card tidak">
    <h3>Mobil Tidak Tersedia</h3>
    <p><?= $total_tidak ?></p>
  </div>
</div>

</body>
</html>
