<?php
include '../functions.php';
require_role('admin');

if (isset($_GET['set'])) {
  $id = (int)$_GET['set'];
  $status = $_GET['status'] ?? 'menunggu';
  $res = db_execute($conn, "UPDATE transaksi SET status = ? WHERE id = ?", "si", [$status, $id]);
  $msg = $res['ok'] ? "Status transaksi diperbarui." : "Error: ".$res['error'];
}

$trans = db_query($conn, "SELECT t.*, u.nama as penyewa, m.nama_mobil FROM transaksi t LEFT JOIN users u ON t.id_penyewa=u.id LEFT JOIN mobil m ON t.id_mobil=m.id ORDER BY t.id DESC");
?>
<!DOCTYPE html>
<html><head><title>Transaksi</title></head><body>
<h2>Daftar Transaksi</h2>
<?php if(isset($msg)) echo "<p>$msg</p>"; ?>
<table border="1" cellpadding="6">
<tr><th>ID</th><th>Penyewa</th><th>Mobil</th><th>Tgl Sewa</th><th>Tgl Kembali</th><th>Total</th><th>Status</th><th>Aksi</th></tr>
<?php foreach($trans as $t): ?>
<tr>
  <td><?= $t['id'] ?></td>
  <td><?= htmlspecialchars($t['penyewa']) ?></td>
  <td><?= htmlspecialchars($t['nama_mobil']) ?></td>
  <td><?= $t['tgl_sewa'] ?></td>
  <td><?= $t['tgl_kembali'] ?></td>
  <td><?= number_format($t['total_harga']) ?></td>
  <td><?= $t['status'] ?></td>
  <td>
    <a href="?set=<?= $t['id'] ?>&status=menunggu">Menunggu</a> |
    <a href="?set=<?= $t['id'] ?>&status=disetujui">Disetujui</a> |
    <a href="?set=<?= $t['id'] ?>&status=selesai">Selesai</a>
  </td>
</tr>
<?php endforeach; ?>
</table>
<p><a href="dashboard.php">Kembali</a> | <a href="../logout.php">Logout</a></p>
</body></html>
