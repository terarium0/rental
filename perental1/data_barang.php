<?php
session_start();
include '../db.php';

if ($_SESSION['role'] != 'perental') {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id_user'];
$barang = mysqli_query($conn, "SELECT * FROM barang WHERE id_perental='$id'");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Barang</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body { background:#f4f6f9 }
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
  .sidebar a:hover { background: #34495e }
  .content { margin-left: 240px; padding: 20px }
  .card-img-top { height: 150px; object-fit: cover }
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
  <h3 class="fw-bold mb-4">Data Barang Anda</h3>

  <div class="row g-3">
    <?php while($row = mysqli_fetch_assoc($barang)): ?>
      <div class="col-md-4">
        <div class="card shadow-sm h-100">
          
          <?php if ($row['foto']): ?>
            <img src="../uploads/<?= $row['foto'] ?>" class="card-img-top">
          <?php else: ?>
            <div class="p-5 text-center text-muted">Tidak ada gambar</div>
          <?php endif; ?>

          <div class="card-body">
            <h6 class="text-center fw-bold"><?= strtoupper($row['nama_barang']) ?></h6>

            <p class="text-center mb-1">
              <span class="badge <?= $row['status']=='tersedia'?'bg-success':'bg-danger' ?>">
                <?= $row['status'] ?>
              </span>
            </p>

            <p class="text-center text-dark fw-semibold">
              Rp<?= number_format($row['harga_sewa'], 0, ',', '.') ?>/hari
            </p>

            <a href="detail_barang.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm w-100">
              Detail
            </a>

          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>
