<?php
include '../functions.php';
require_role('admin');

if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  // prevent deleting self
  if ($id == $_SESSION['id_user']) {
    $msg = "Tidak bisa menghapus akun sendiri.";
  } else {
    $res = db_execute($conn, "DELETE FROM users WHERE id = ?", "i", [$id]);
    $msg = $res['ok'] ? "User dihapus." : "Error: ".$res['error'];
  }
}

$users = db_query($conn, "SELECT id,nama,username,role FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html><head><title>Data Users</title></head><body>
<h2>Data Users</h2>
<?php if(isset($msg)) echo "<p>$msg</p>"; ?>
<table border="1" cellpadding="6">
  <tr><th>ID</th><th>Nama</th><th>Username</th><th>Role</th><th>Aksi</th></tr>
  <?php foreach($users as $u): ?>
    <tr>
      <td><?= $u['id'] ?></td>
      <td><?= htmlspecialchars($u['nama']) ?></td>
      <td><?= htmlspecialchars($u['username']) ?></td>
      <td><?= $u['role'] ?></td>
      <td>
        <?php if($u['id'] != $_SESSION['id_user']): ?>
          <a href="?delete=<?= $u['id'] ?>" onclick="return confirm('Hapus user?')">Hapus</a>
        <?php else: ?>
          -
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<p><a href="dashboard.php">Kembali</a> | <a href="../logout.php">Logout</a></p>
</body></html>
