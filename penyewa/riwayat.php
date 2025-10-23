<?php
include '../functions.php';
require_role('penyewa');

$trans = db_query($conn, "SELECT t.*, m.nama_mobil FROM transaksi t JOIN mobil m ON t.id_mobil=m.id WHERE t.id_penyewa = ? ORDER BY t.id DESC", "i", [$_SESSION['id_user']]);
?>
<!DOCTYPE html><html><head><title>Riwayat Sewa</title></head><body>
<h2>Riwayat Sewa Saya</h2>
<table border="1" cellpadding="6">
<tr><th>ID</th><th>Mobil</th><th>Tgl Sewa</th><th>Tgl Kembali</th><th>Total</th><th>Status</th></tr>
<?php foreach($trans as $t): ?>
<tr>
  <td><?= $t['id'] ?></td>
  <td><?= htmlspecialchars($t['nama_mobil']) ?></td>
  <td><?= $t['tgl_sewa'] ?></td>
  <td><?= $t['tgl_kembali'] ?></td>
  <td><?= number_format($t['total_harga']) ?></td>
  <td><?= $t['status'] ?></td>
</tr>
<?php endforeach; ?>
</table>
<p><a href="daftar_mobil.php">Kembali</a> | <a href="../logout.php">Logout</a></p>
</body></html>
