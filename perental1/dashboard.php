<?php
session_start();
include '../db.php';

if ($_SESSION['role'] != 'perental') {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id_user'];

// Statistik
$total_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM barang WHERE id_perental='$id'"))['jml'];
$tersedia = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM barang WHERE id_perental='$id' AND status='tersedia'"))['jml'];
$disewa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM barang WHERE id_perental='$id' AND status='tidak tersedia'"))['jml'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Perental</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body { background:#f4f6f9; }
  .sidebar {
    width: 220px;
    min-height: 100vh;
    background: #2c3e50;
    color: white;
    position: fixed;
    left: 0;
    top: 0;
    padding: 20px 0;
  }
  .sidebar a {
    display: block;
    padding: 12px 20px;
    text-decoration: none;
    color: white;
    font-size: 15px;
  }
  .sidebar a:hover {
    background: #34495e;
  }
  .content {
    margin-left: 240px;
    padding: 20px;
  }
  .card-stat { border-radius: 15px }
</style>
</head>
<body>

<div class="sidebar">
  <h4 class="text-center mb-4">Menu</h4>
  <a href="dashboard.php">🏠 Dashboard</a>
  <a href="data_barang.php">📦 Data Barang</a>
  <a href="../transaksi/transaksi_perental.php">📦 Sewa</a>
  <a href="tambah_barang2.php">➕ Tambah Barang</a>
  <a href="../logout.php" class="text-danger">🚪 Logout</a>
</div>

<div class="content">
  <h3 class="fw-bold mb-4">Dashboard Statistik</h3>

  <div class="row g-4">
    <div class="col-md-4">
      <div class="card bg-primary text-white card-stat shadow">
        <div class="card-body text-center">
          <h6>Total Barang</h6>
          <h2><?= $total_barang ?></h2>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card bg-success text-white card-stat shadow">
        <div class="card-body text-center">
          <h6>Tersedia</h6>
          <h2><?= $tersedia ?></h2>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card bg-warning text-white card-stat shadow">
        <div class="card-body text-center">
          <h6>Sedang Disewa</h6>
          <h2><?= $disewa ?></h2>
        </div>
      </div>
    </div>
  </div>

</div>

</body>
</html>
