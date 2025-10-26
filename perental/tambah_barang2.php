<?php
session_start();
include '../db.php';

// Pastikan user yang login adalah perental
if ($_SESSION['role'] != 'perental') {
  header('Location: ../index.php');
  exit;
}

if (isset($_POST['simpan'])) {
  $nama = mysqli_real_escape_string($conn, $_POST['nama']);
  $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
  $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
  $harga = mysqli_real_escape_string($conn, $_POST['harga']);
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
      echo "<script>alert('Format foto tidak valid! Hanya JPG, JPEG, PNG, GIF.');</script>";
      $foto = '';
    }
  }

  // Simpan ke database
  $query = "
    INSERT INTO barang (id_perental, nama_barang, deskripsi, kategori, harga_sewa, foto, status)
    VALUES ('$id', '$nama', '$deskripsi', '$kategori', '$harga', '$foto', 'tersedia')
  ";

  if (mysqli_query($conn, $query)) {
    echo "<script>alert('Barang berhasil ditambahkan!'); window.location='dashboard.php';</script>";
  } else {
    echo "<script>alert('Terjadi kesalahan: " . mysqli_error($conn) . "');</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Barang | Rental Barang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">Rental Barang</a>
    <div class="d-flex">
      <a href="dashboard.php" class="btn btn-outline-light btn-sm me-2">Dashboard</a>
      <a href="../logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>

<!-- Form Tambah Barang -->
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4">
        <h4 class="text-center mb-4">Tambah Barang</h4>
        <form method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama barang" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi Barang</label>
            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Tuliskan deskripsi singkat barang" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Harga Sewa (per hari)</label>
            <input type="number" name="harga" class="form-control" placeholder="Masukkan harga sewa" required>
          </div>
          <div class="mb-3">
            <label class="form-label">foto Barang</label>
            <input type="file" name="foto" class="form-control" accept="image/*" required>
          </div>
          <button type="submit" name="simpan" class="btn btn-primary w-100">Simpan Barang</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
