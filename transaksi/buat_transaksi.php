<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'penyewa') {
  header('Location: ../index.php');
  exit;
}

$id_barang = $_GET['id'];
$id_penyewa = $_SESSION['id_user'];
$query = mysqli_query($conn, "SELECT * FROM barang WHERE id='$id_barang'");
$barang = mysqli_fetch_assoc($query);

if (isset($_POST['pesan'])) {
  $id_penyewa = $_SESSION['id_user'];
  $tgl_mulai = $_POST['tgl_mulai'];
  $tgl_selesai = $_POST['tgl_selesai'];

  $selisih = (strtotime($tgl_selesai) - strtotime($tgl_mulai)) / (60*60*24);
  if ($selisih <= 0) {
    echo "<script>alert('Tanggal tidak valid!');</script>";
  } else {
    $total = $selisih * $barang['harga_sewa'];
    mysqli_query($conn, "INSERT INTO sewa (id_barang, id_penyewa, tanggal_mulai, tanggal_selesai, total_harga)
                         VALUES ('$id_barang', '$id_penyewa', '$tgl_mulai', '$tgl_selesai', '$total')");
    echo "<script>alert('sewa berhasil dibuat, menunggu konfirmasi perental.');window.location='../penyewa/dashboard.php';</script>";
  }
}
?>
<!DOCTYPE html>
<html>
<head><title>Pesan barang</title></head>
<body>
  <h2>Pesan barang: <?= htmlspecialchars($barang['nama_barang']) ?></h2>
  <form method="post">
    <h2>Catat sewa</h2>
    <p>barang: <strong><?= $barang['nama_barang'] ?></strong></p>
    <p>Harga: Rp<?= number_format($barang['harga_sewa'],0,',','.') ?>/hari</p>
    <label>Tanggal Mulai:</label><br>
    <input type="date" name="tgl_mulai" required><br>
    <label>Tanggal Selesai:</label><br>
    <input type="date" name="tgl_selesai" required><br><br>
    <button type="submit" name="pesan">Pesan Sekarang</button>
  </form>
</body>
</html>
