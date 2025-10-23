<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'perental') {
  header('Location: ../index.php');
  exit;
}

$id = $_SESSION['id_user'];
$result = mysqli_query($conn, "SELECT * FROM mobil WHERE id_perental='$id'");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard Perental</title>
  <style>
    img { width: 120px; height: 80px; object-fit: cover; }
    table, th, td { border: 1px solid #ddd; border-collapse: collapse; padding: 8px; }
    a.button { padding: 4px 8px; text-decoration: none; border-radius: 4px; }
    .edit { background: #2196F3; color: #fff; }
    .delete { background: #f44336; color: #fff; }
  </style>
</head>
<body>
  <h1>Dashboard Perental</h1>
  <a href="tambah_mobil.php">+ Tambah Mobil</a> |
  <a href="../transaksi/transaksi_perental.php">Lihat Transaksi Masuk</a> |
  <a href="../logout.php">Logout</a>
  <hr>

  <table>
    <tr>
      <th>Gambar</th>
      <th>Nama Mobil</th>
      <th>Harga</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
      <td>
        <?php if ($row['gambar']): ?>
          <img src="../uploads/<?= $row['gambar'] ?>" alt="mobil">
        <?php else: ?>
          <em>tidak ada</em>
        <?php endif; ?>
      </td>
      <td><?= htmlspecialchars($row['nama_mobil']) ?></td>
      <td>Rp<?= number_format($row['harga_sewa'],0,',','.') ?>/hari</td>
      <td><?= $row['status'] ?></td>
      <td>
        <a class="button edit" href="edit_mobil.php?id=<?= $row['id'] ?>">Edit</a>
        <a class="button delete" href="hapus_mobil.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus mobil ini?')">Hapus</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
