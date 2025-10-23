<?php
session_start();
include '../db.php';

// pastikan hanya admin yang bisa mengakses
if ($_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit;
}

// ambil semua data mobil dan join dengan perental
$query = "
    SELECT m.*, u.nama AS nama_perental 
    FROM mobil m 
    JOIN users u ON m.id_perental = u.id
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Mobil - Admin</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f5f5f5; }
    .nav { background: #333; color: white; padding: 10px; }
    .nav a { color: white; text-decoration: none; margin-right: 10px; }
    .table { background: white; border-collapse: collapse; width: 95%; margin: 20px auto; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
    th { background: #333; color: white; }
    .tersedia { color: green; font-weight: bold; }
    .tidak { color: red; font-weight: bold; }
  </style>
</head>
<body>

<div class="nav">
  <a href="dashboard.php">🏠 Dashboard Admin</a>
  <a href="data_mobil.php">🚗 Data Mobil</a>
  <a href="data_user.php">👥 Data User</a>
  <a href="../logout.php">🚪 Logout</a>
</div>

<h2 style="margin-left:50px;">Data Semua Mobil</h2>

<table class="table">
  <tr>
    <th>No</th>
    <th>Nama Mobil</th>
    <th>Harga Sewa</th>
    <th>Perental</th>
    <th>Gambar</th>
    <th>Status</th>
  </tr>

  <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
  <tr>
    <td><?= $no++ ?></td>
    <td><?= htmlspecialchars($row['nama_mobil']) ?></td>
    <td>Rp<?= number_format($row['harga_sewa'], 0, ',', '.') ?>/hari</td>
    <td><?= htmlspecialchars($row['nama_perental']) ?></td>
    <td>
      <?php if ($row['gambar']): ?>
        <img src="../uploads/<?= $row['gambar'] ?>" width="100">
      <?php else: ?>
        (Tidak ada gambar)
      <?php endif; ?>
    </td>
    <td>
      <?php if ($row['status'] == 'tersedia'): ?>
        <span class="tersedia">Tersedia</span>
      <?php else: ?>
        <span class="tidak">Tidak Tersedia</span>
      <?php endif; ?>
    </td>
  </tr>
  <?php endwhile; ?>
</table>

</body>
</html>
