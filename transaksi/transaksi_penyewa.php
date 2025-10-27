<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'penyewa') {
  header('Location: ../index.php');
  exit;
}

$id_user = $_SESSION['id_user'];
$result = mysqli_query($conn, "
  SELECT t.*, m.nama_barang 
  FROM sewa t
  JOIN barang m ON t.id_barang = m.id
  WHERE t.id_penyewa = '$id_user'
  ORDER BY t.id DESC
");
?>
<!DOCTYPE html>
<html>
<head><title>sewa Saya</title></head>
<body>
  <h2>Daftar sewa Penyewa</h2>
  <a href="../logout.php">Logout</a>
  <table border="1" cellpadding="8">
    <tr>
      <th>barang</th>
      <th>Tgl Mulai</th>
      <th>Tgl Selesai</th>
      <th>Total Harga</th>
      <th>Status</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= htmlspecialchars($row['nama_barang']) ?></td>
        <td><?= $row['tanggal_mulai'] ?></td>
        <td><?= $row['tanggal_selesai'] ?></td>
        <td>Rp<?= number_format($row['total_harga'],0,',','.') ?></td>
        <td><?= ucfirst($row['status']) ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
