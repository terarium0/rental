<?php
session_start();
include '../db.php';

// Pastikan hanya role penyewa yang bisa masuk
if ($_SESSION['role'] != 'penyewa') {
  header('Location: ../index.php');
  exit;
}

// Ambil semua mobil yang tersedia
$result = mysqli_query($conn, "
  SELECT m.*, u.username AS pemilik 
  FROM mobil m 
  JOIN users u ON m.id_perental = u.id
  WHERE m.status = 'tersedia'
");

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Penyewa</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f9f9f9; }
    h1 { color: #333; }
    .nav { background: #333; padding: 10px; }
    .nav a { color: white; margin-right: 15px; text-decoration: none; }
    .card {
      background: white; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      padding: 15px; margin: 10px; display: inline-block; width: 250px; vertical-align: top;
    }
    .card img { width: 100%; height: 150px; object-fit: cover; border-radius: 6px; }
    .btn {
      background: #2196F3; color: white; border: none; padding: 8px 12px;
      text-decoration: none; border-radius: 4px; display: inline-block;
    }
  </style>
</head>
<body>

  <div class="nav">
    <a href="dashboard.php">🏠 Beranda</a>
    <a href="../transaksi/transaksi_penyewa.php">🧾 Transaksi Saya</a>
    <a href="../logout.php">🚪 Logout</a>
  </div>

  <div class="container">
    <h1>Daftar Mobil Tersedia</h1>

    <?php if (mysqli_num_rows($result) == 0): ?>
      <p>Tidak ada mobil tersedia saat ini.</p>
    <?php else: ?>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="card">
          <?php if ($row['gambar']): ?>
            <img src="../uploads/<?= $row['gambar'] ?>" alt="Mobil">
          <?php else: ?>
            <img src="../uploads/default.png" alt="Mobil">
          <?php endif; ?>

          <h3><?= htmlspecialchars($row['nama_mobil']) ?></h3>
          <p><strong>Harga:</strong> Rp<?= number_format($row['harga_sewa'], 0, ',', '.') ?>/hari</p>
          <p><strong>Pemilik:</strong> <?= htmlspecialchars($row['pemilik']) ?></p>
          <a class="btn" href="../transaksi/buat_transaksi.php?id=<?= $row['id'] ?>">Sewa Sekarang</a>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>

  </div>

</body>
</html>
