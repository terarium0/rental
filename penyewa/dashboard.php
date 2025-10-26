<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'penyewa') {
  header('Location: ../index.php');
  exit;
}

$result = mysqli_query($conn, "
  SELECT b.*, u.username AS pemilik, u.telepon
  FROM barang b
  JOIN users u ON b.id_perental = u.id
  WHERE b.status = 'tersedia'
");

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Penyewa</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .navbar-brand {
      font-weight: 600;
    }
    .card img {
      height: 180px;
      object-fit: cover;
    }
    .btn-wa {
      background-color: #25D366;
      color: white;
    }
    .btn-wa:hover {
      background-color: #1ebe5a;
      color: white;
    }
    .btn-catat {
      background-color: #2196F3;
      color: white;
    }
    .btn-catat:hover {
      background-color: #1976D2;
      color: white;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">🏠 Beranda</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="../transaksi/transaksi_penyewa.php">🧾 Transaksi Saya</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="../logout.php">🚪 Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Konten -->
<div class="container mt-5 pt-4">
  <h2 class="mb-4 text-center">Daftar Barang Tersedia</h2>

  <div class="row g-4">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <div class="col-md-4 col-sm-6">
        <div class="card h-100 shadow-sm">
          <img src="../uploads/<?= $row['foto'] ?: 'default.png' ?>" 
              class="card-img-top" 
              alt="<?= htmlspecialchars($row['nama_barang']) ?>">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($row['nama_barang']) ?></h5>
            <p class="card-text mb-1"><strong>Harga Sewa:</strong> Rp<?= number_format($row['harga_sewa'], 0, ',', '.') ?>/hari</p>
            <p class="card-text mb-1"><strong>Pemilik:</strong> <?= htmlspecialchars($row['pemilik']) ?></p>
            <p class="card-text mb-1"><strong>Telepon:</strong> <?= htmlspecialchars($row['telepon']) ?></p>
            <p class="card-text text-muted mb-3">
              <?= nl2br(htmlspecialchars($row['deskripsi'])) ?: '<em>Tidak ada deskripsi</em>' ?>
            </p>
            <div class="d-grid gap-2">
              <a class="btn btn-success" target="_blank"
                href="https://wa.me/62<?= preg_replace('/\D/', '', $row['telepon']) ?>?text=Halo%20saya%20tertarik%20menyewa%20barang%20Anda%20yang%20bernama%20<?= urlencode($row['nama_barang']) ?>">
                Hubungi via WhatsApp
              </a>
              <a class="btn btn-primary" href="../transaksi/buat_transaksi.php?id=<?= $row['id'] ?>">
                Catat Transaksi
              </a>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
