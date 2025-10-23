<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'perental') {
  header('Location: ../index.php');
  exit;
}

$id_perental = $_SESSION['id_user'];
$result = mysqli_query($conn, "
  SELECT t.*, m.nama_mobil
  FROM transaksi t
  JOIN mobil m ON t.id_mobil = m.id
  WHERE m.id_perental = '$id_perental'
  ORDER BY t.id DESC
");
?>
<!DOCTYPE html>
<html>
<head><title>Transaksi Masuk</title></head>
<body>
  <h2>Transaksi Masuk (Perental)</h2>
  <table border="1" cellpadding="8">
    <tr>
      <th>Mobil</th>
      <th>Tgl Mulai</th>
      <th>Tgl Selesai</th>
      <th>Total Harga</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= htmlspecialchars($row['nama_mobil']) ?></td>
        <td><?= $row['tanggal_mulai'] ?></td>
        <td><?= $row['tanggal_selesai'] ?></td>
        <td>Rp<?= number_format($row['total_harga'],0,',','.') ?></td>
        <td><?= ucfirst($row['status']) ?></td>
        <td>
          <?php if ($row['status'] == 'menunggu'): ?>
            <a href="update_status.php?id=<?= $row['id'] ?>&status=disetujui">Setujui</a> |
            <a href="update_status.php?id=<?= $row['id'] ?>&status=ditolak">Tolak</a>
          <?php else: ?>
            <em>-</em>
          <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
