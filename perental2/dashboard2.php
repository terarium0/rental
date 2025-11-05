<?php
session_start();
include '../db.php';

// Pastikan hanya perental yang bisa mengakses
if ($_SESSION['role'] != 'perental') {
    header('Location: ../index.php');
    exit;
}

$id_perental = $_SESSION['id_user'];

// === Fungsi ubah status barang ===
if (isset($_GET['ubah_status'])) {
    $id_barang = $_GET['ubah_status'];
    $status_baru = $_GET['status'];

    $query = "UPDATE barang SET status = '$status_baru' WHERE id = '$id_barang' AND id_perental = '$id_perental'";
    mysqli_query($conn, $query);

    echo "<script>alert('Status barang berhasil diubah!');window.location='dashboard.php';</script>";
    exit;
}

// === Fungsi hapus barang ===
if (isset($_GET['hapus'])) {
    $id_barang = $_GET['hapus'];

    // hapus gambar jika ada
    $gambar = mysqli_fetch_assoc(mysqli_query($conn, "SELECT foto FROM barang WHERE id='$id_barang' AND id_perental='$id_perental'"));
    if ($gambar && $gambar['gambar'] && file_exists("../uploads/" . $gambar['foto'])) {
        unlink("../uploads/" . $gambar['gambar']);
    }

    mysqli_query($conn, "DELETE FROM barang WHERE id='$id_barang' AND id_perental='$id_perental'");
    echo "<script>alert('barang berhasil dihapus!');window.location='dashboard.php';</script>";
    exit;
}

// Ambil data barang milik perental
$result = mysqli_query($conn, "SELECT * FROM barang WHERE id_perental='$id_perental'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Perental</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f5f5f5; }
    .nav { background: #333; color: white; padding: 10px; }
    .nav a { color: white; text-decoration: none; margin-right: 10px; }
    .table { background: white; border-collapse: collapse; width: 90%; margin: 20px auto; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
    th { background: #333; color: white; }
    .btn { padding: 6px 10px; border-radius: 4px; text-decoration: none; color: white; }
    .tersedia { background: green; }
    .tidak { background: red; }
    .edit { background: #2196F3; }
    .hapus { background: #f44336; }
  </style>
</head>
<body>

<div class="nav">
  <a href="dashboard.php">🏠 Dashboard</a>
  <a href="tambah_barang.php">➕ Tambah barang</a>
  <a href="../logout.php">🚪 Logout</a>
</div>

<h2 style="margin-left:50px;">Daftar barang Saya</h2>

<table class="table">
  <tr>
    <th>No</th>
    <th>Nama barang</th>
    <th>Deskripsi</th>
    <th>kategori</th>
    <th>Harga Sewa</th>
    <th>Gambar</th>
    <th>Status</th>
    <th>Aksi</th>
  </tr>

  <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
  <tr>
    <td><?= $no++ ?></td>
    <td><?= htmlspecialchars($row['nama_barang']) ?></td>
    <td><?= htmlspecialchars($row['deskripsi']) ?></td>
    <td><?= htmlspecialchars($row['kategori']) ?></td>
    <td>Rp<?= number_format($row['harga_sewa'], 0, ',', '.') ?>/hari</td>
    <td>
      <?php if ($row['foto']): ?>
        <img src="../uploads/<?= $row['foto'] ?>" width="100">
      <?php else: ?>
        (Tidak ada gambar)
      <?php endif; ?>
    </td>
    <td>
      <?php if ($row['status'] == 'tersedia'): ?>
        <span style="color:green;font-weight:bold;">Tersedia</span>
      <?php else: ?>
        <span style="color:red;font-weight:bold;">Tidak Tersedia</span>
      <?php endif; ?>
    </td>
    <td>
      <!-- Tombol ubah status -->
      <?php if ($row['status'] == 'tersedia'): ?>
        <a class="btn tidak" href="?ubah_status=<?= $row['id'] ?>&status=tidak tersedia">Nonaktifkan</a>
      <?php else: ?>
        <a class="btn tersedia" href="?ubah_status=<?= $row['id'] ?>&status=tersedia">Aktifkan</a>
      <?php endif; ?>

      <!-- Tombol edit & hapus -->
      <a class="btn edit" href="edit_barang.php?id=<?= $row['id'] ?>">Edit</a>
      <a class="btn hapus" href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a>
    </td>
  </tr>
  <?php endwhile; ?>
</table>

</body>
</html>
