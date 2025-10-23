<?php
include '../functions.php';
require_role('admin');

if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  $res = db_execute($conn, "DELETE FROM mobil WHERE id = ?", "i", [$id]);
  $msg = $res['ok'] ? "Mobil dihapus." : "Error: ".$res['error'];
}

if (isset($_GET['setstatus'])) {
  $id = (int)$_GET['id'];
  $status = $_GET['status'] === 'tersedia' ? 'tersedia' : 'disewa';
  $res = db_execute($conn, "UPDATE mobil SET status = ? WHERE id = ?", "si", [$status, $id]);
  $msg = $res['ok'] ? "Status diperbarui." : "Error: ".$res['error'];
}

$mobils = db_query($conn, "SELECT m.*, u.nama as pemilik FROM mobil m LEFT JOIN users u ON m.id_perental = u.id ORDER BY m.id DESC");
?>
<!DOCTYPE html>
<html><head><title>Data Mobil</title></head><body>
<h2>Data Mobil</h2>
<?php if(isset($msg)) echo "<p>$msg</p>"; ?>
<table border="1" cellpadding="6">
<tr><th>ID</th><th>Nama</th><th>Harga</th><th>Pemilik</th><th>Status</th><th>Aksi</th></tr>
<?php foreach($mobils as $m): ?>
<tr>
  <td><?= $m['id'] ?></td>
  <td><?= htmlspecialchars($m['nama_mobil']) ?></td>
  <td><?= number_format($m['harga_sewa']) ?></td>
  <td><?= htmlspecialchars($m['pemilik']) ?></td>
  <td><?= $m['status'] ?></td>
  <td>
    <a href="?delete=<?= $m['id'] ?>" onclick="return confirm('Hapus mobil?')">Hapus</a> |
    <?php if($m['status']=='tersedia'): ?>
      <a href="?setstatus=1&id=<?= $m['id'] ?>&status=disewa">Set Disewa</a>
    <?php else: ?>
      <a href="?setstatus=1&id=<?= $m['id'] ?>&status=tersedia">Set Tersedia</a>
    <?php endif; ?>
  </td>
</tr>
<?php endforeach; ?>
</table>
<p><a href="dashboard.php">Kembali</a> | <a href="../logout.php">Logout</a></p>
</body></html>
