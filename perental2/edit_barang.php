<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'perental') {
  header('Location: ../index.php');
  exit;
}

$id_user = $_SESSION['id_user'];
$id_barang = $_GET['id'] ?? 0;

// Ambil data barang berdasarkan ID dan pemilik
$query = mysqli_query($conn, "SELECT * FROM barang WHERE id='$id_barang' AND id_perental='$id_user'");
$data = mysqli_fetch_assoc($query);
if (!$data) {
  die("barang tidak ditemukan atau bukan milik Anda.");
}

if (isset($_POST['update'])) {
  $nama = $_POST['nama'];
  $kategori = $_POST['kategori'];
  $deskripsi = $_POST['deskripsi'];
  $harga = $_POST['harga'];
  $fotoLama = $data['foto'];

  // Jika ada upload foto baru
  if (!empty($_FILES['foto']['name'])) {
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $ext = pathinfo($foto, PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','gif'];
    if (in_array(strtolower($ext), $allowed)) {
      $newname = time() . '_' . rand(100,999) . '.' . $ext;
      move_uploaded_file($tmp, "../uploads/" . $newname);
      // hapus foto lama
      if ($fotoLama && file_exists("../uploads/" . $fotoLama)) {
        unlink("../uploads/" . $fotoLama);
      }
      $foto = $newname;
    } else {
      $foto = $fotoLama;
    }
  } else {
    $foto = $fotoLama;
  }

  mysqli_query($conn, "UPDATE barang SET nama_barang='$nama', kategori='$kategori', deskripsi='$deskripsi', harga_sewa='$harga', foto='$foto' WHERE id='$id_barang'");
  echo "<script>alert('Data barang berhasil diperbarui');window.location='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit barang</title></head>
<body>
  <h2>Edit barang</h2>
  <form method="post" enctype="multipart/form-data">
    <input type="text" name="nama" value="<?= htmlspecialchars($data['nama_barang']) ?>" required><br>
    <input type="text" name="kategori" value="<?= htmlspecialchars($data['kategori']) ?>" required><br>
    <input type="text" name="deskripsi" value="<?= htmlspecialchars($data['deskripsi']) ?>" required><br>
    <input type="number" name="harga" value="<?= htmlspecialchars($data['harga_sewa']) ?>" required><br>
    <p>foto Saat Ini:</p>
    <?php if ($data['foto']): ?>
      <img src="../uploads/<?= $data['foto'] ?>" width="150">
    <?php endif; ?>
    <p>Ganti foto (opsional):</p>
    <input type="file" name="foto" accept="image/*"><br><br>
    <button type="submit" name="update">Simpan Perubahan</button>
  </form>
</body>
</html>
