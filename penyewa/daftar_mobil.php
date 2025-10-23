<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'penyewa') {
  header('Location: ../index.php');
  exit;
}

$result = mysqli_query($conn, "SELECT m.*, u.nama AS nama_perental 
                               FROM mobil m 
                               JOIN users u ON m.id_perental = u.id
                               WHERE m.status='tersedia'");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Daftar Mobil</title>
  <style>
    .card {
      display: inline-block;
      border: 1px solid #ccc;
      border-radius: 8px;
      margin: 10px;
      padding: 10px;
      width: 220px;
      text-align: center;
    }
    img {
      width: 200px;
      height: 130px;
      object-fit: cover;
      border-radius: 6px;
    }
  </style>
</head>
<body>
  <h2>Daftar Mobil Tersedia</h2>
  <a href="dashboard.php">Kembali</a> | 
  <a href="../logout.php">Logout</a>
  <hr>

  <?php while($row = mysqli_fetch_assoc($result)): ?>
    <div class="card">
      <?php if ($row['gambar']): ?>
        <img src="../uploads/<?= $row['gambar'] ?>" alt="mobil">
      <?php else: ?>
        <div style="height:130px;background:#eee;line-height:130px;">No Image</div>
      <?php endif; ?>
      <h4><?= htmlspecialchars($row['nama_mobil']) ?></h4>
      <p>Perental: <?= htmlspecialchars($row['nama_perental']) ?></p>
      <p>Rp<?= number_format($row['harga_sewa'],0,',','.') ?>/hari</p>
      <form method="post" action="sewa.php">
        <input type="hidden" name="id_mobil" value="<?= $row['id'] ?>">
        <button type="submit" name="sewa">Sewa Sekarang</button>
      </form>
    </div>
  <?php endwhile; ?>
</body>
</html>
