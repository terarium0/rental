<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'penyewa') {
  header('Location: ../index.php');
  exit;
}

$result = mysqli_query($conn, "
  SELECT m.*, u.username AS pemilik, u.telepon
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
    body { font-family: Arial; background: #f5f5f5; }
    .nav { background: #333; color: white; padding: 10px; }
    .nav a { color: white; text-decoration: none; margin-right: 10px; }
    .card { background: white; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 15px; margin: 15px; display: inline-block; width: 260px; vertical-align: top; }
    .card img { width: 100%; height: 150px; object-fit: cover; border-radius: 6px; }
    .btn { display: inline-block; padding: 8px 12px; border-radius: 4px; text-decoration: none; color: white; margin-top: 5px; }
    .wa { background: green; }
    .catat { background: #2196F3; }
  </style>
</head>
<body>

<div class="nav">
  <a href="dashboard.php">🏠 Beranda</a>
  <a href="../transaksi/transaksi_penyewa.php">🧾 Transaksi Saya</a>
  <a href="../logout.php">🚪 Logout</a>
</div>

<h2 style="margin-left:15px;">Daftar Mobil Tersedia</h2>

<?php while ($row = mysqli_fetch_assoc($result)): ?>
<div class="card">
  <img src="../uploads/<?= $row['gambar'] ?: 'default.png' ?>" alt="">
  <h3><?= htmlspecialchars($row['nama_mobil']) ?></h3>
  <p><strong>Harga:</strong> Rp<?= number_format($row['harga_sewa'],0,',','.') ?>/hari</p>
  <p><strong>Pemilik:</strong> <?= htmlspecialchars($row['pemilik']) ?></p>
  <p><strong>Telepon:</strong> <?= htmlspecialchars($row['telepon']) ?></p>

  <a class="btn wa" href="https://wa.me/<?= preg_replace('/\D/','',$row['telepon']) ?>?text=Halo%20saya%20tertarik%20menyewa%20mobil%20Anda" target="_blank">Hubungi via WhatsApp</a>
  <a class="btn catat" href="../transaksi/buat_transaksi.php?id=<?= $row['id'] ?>">Catat Transaksi</a>
</div>
<?php endwhile; ?>

</body>
</html>