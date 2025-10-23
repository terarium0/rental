<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'admin') {
  header('Location: ../index.php');
  exit;
}

$result = mysqli_query($conn, "
  SELECT t.*, m.nama_mobil, u.username AS penyewa
  FROM transaksi t
  JOIN mobil m ON t.id_mobil = m.id
  JOIN users u ON t.id_penyewa = u.id
  ORDER BY t.id DESC
");
?>
<!DOCTYPE html>
<html>
<head><title>Transaksi (Admin)</title></head>
<body>
  <h2>Semua Transaksi</h2>
  <table border="1" cellpadding="8">
    <tr>
      <th>Mobil</th>
      <th>Penyewa</th>
      <th>Tgl Mulai</th>
      <th>Tgl Selesai</th>
      <th>Total Harga</th>
      <th>Status</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= htmlspecialchars($row['nama_mobil']) ?></td>
        <td><?= htmlspecialchars($row['penyewa']) ?></td>
        <td><?= $row['tanggal_mulai'] ?></td>
        <td><?= $row['tanggal_selesai'] ?></td>
        <td>Rp<?= number_format($row['total_harga'],0,',','.') ?></td>
        <td><?= ucfirst($row['status']) ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
