<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'perental') {
  header('Location: ../index.php');
  exit;
}

$id_user = $_SESSION['id_user'];
$id_mobil = $_GET['id'] ?? 0;

// Ambil data mobil berdasarkan ID dan pemilik
$query = mysqli_query($conn, "SELECT * FROM mobil WHERE id='$id_mobil' AND id_perental='$id_user'");
$data = mysqli_fetch_assoc($query);
if (!$data) {
  die("Mobil tidak ditemukan atau bukan milik Anda.");
}

if (isset($_POST['update'])) {
  $nama = $_POST['nama'];
  $harga = $_POST['harga'];
  $gambarLama = $data['gambar'];

  // Jika ada upload gambar baru
  if (!empty($_FILES['gambar']['name'])) {
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $ext = pathinfo($gambar, PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','gif'];
    if (in_array(strtolower($ext), $allowed)) {
      $newname = time() . '_' . rand(100,999) . '.' . $ext;
      move_uploaded_file($tmp, "../uploads/" . $newname);
      // hapus gambar lama
      if ($gambarLama && file_exists("../uploads/" . $gambarLama)) {
        unlink("../uploads/" . $gambarLama);
      }
      $gambar = $newname;
    } else {
      $gambar = $gambarLama;
    }
  } else {
    $gambar = $gambarLama;
  }

  mysqli_query($conn, "UPDATE mobil SET nama_mobil='$nama', harga_sewa='$harga', gambar='$gambar' WHERE id='$id_mobil'");
  echo "<script>alert('Data mobil berhasil diperbarui');window.location='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Mobil</title></head>
<body>
  <h2>Edit Mobil</h2>
  <form method="post" enctype="multipart/form-data">
    <input type="text" name="nama" value="<?= htmlspecialchars($data['nama_mobil']) ?>" required><br>
    <input type="number" name="harga" value="<?= htmlspecialchars($data['harga_sewa']) ?>" required><br>
    <p>Gambar Saat Ini:</p>
    <?php if ($data['gambar']): ?>
      <img src="../uploads/<?= $data['gambar'] ?>" width="150">
    <?php endif; ?>
    <p>Ganti Gambar (opsional):</p>
    <input type="file" name="gambar" accept="image/*"><br><br>
    <button type="submit" name="update">Simpan Perubahan</button>
  </form>
</body>
</html>
