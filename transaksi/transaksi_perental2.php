<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'perental') {
  header('Location: ../index.php');
  exit;
}

$id_perental = $_SESSION['id_user'];
$result = mysqli_query($conn, "
  SELECT t.*, m.nama_barang, u.nama AS nama_penyewa, u.telepon AS telepon_penyewa
  FROM sewa t
  JOIN barang m ON t.id_barang = m.id
  JOIN users u ON t.id = u.id
  WHERE m.id_perental = '$id_perental'
  ORDER BY t.id DESC
");

?>
<!DOCTYPE html>
<html>
<head><title>sewa Masuk</title></head>
<body>
  <h2>sewa Masuk (Perental)</h2>
    <table border="1" cellpadding="8">
    <tr>
      <th>barang</th>
      <th>Nama Penyewa</th>
      <th>Telepon Penyewa</th>
      <th>Tgl Mulai</th>
      <th>Tgl Selesai</th>
      <th>Total Harga</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= htmlspecialchars($row['nama_barang']) ?></td>
        <td><?= htmlspecialchars($row['nama_penyewa']) ?></td>
        <td><?= htmlspecialchars($row['telepon_penyewa']) ?></td>
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
