<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'perental') {
  header('Location: ../index.php');
  exit;
}

if (isset($_POST['simpan'])) {
  $nama = $_POST['nama'];
  $harga = $_POST['harga'];
  $id = $_SESSION['id_user'];

  // --- upload foto ---
  $foto = $_FILES['foto']['name'];
  $tmp = $_FILES['foto']['tmp_name'];

  if ($foto != '') {
    $ext = pathinfo($foto, PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','gif'];
    if (in_array(strtolower($ext), $allowed)) {
      $newname = time() . '_' . rand(100,999) . '.' . $ext;
      move_uploaded_file($tmp, "../uploads/" . $newname);
      $foto = $newname;
    } else {
      echo "<script>alert('Format foto tidak valid');</script>";
      $foto = '';
    }
  }

  $query = "INSERT INTO barang (id_perental, nama_barang, harga_sewa, foto)
            VALUES ('$id','$nama','$harga','$foto')";
  mysqli_query($conn, $query);
  echo "<script>alert('barang berhasil ditambahkan');window.location='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head><title>Tambah barang</title></head>
<body>
  <h2>Tambah barang</h2>
  <form method="post" enctype="multipart/form-data">
    <input type="text" name="nama" placeholder="Nama barang" required><br>
    <input type="number" name="harga" placeholder="Harga Sewa per Hari" required><br>
    <input type="file" name="foto" accept="image/*" required><br>
    <button type="submit" name="simpan">Simpan</button>
  </form>
</body>
</html>
