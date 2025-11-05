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
    INSERT INTO barang (id_perental, nama_barang, deskripsi, kategori, harga, foto, status)
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
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">


    <!-- Bootstrap core CSS -->
    <link href="../include/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="../include/assets/css/fontawesome.css">
    <link rel="stylesheet" href="../include/assets/css/templatemo-plot-listing.css">
    <link rel="stylesheet" href="../include/assets/css/animated.css">
    <link rel="stylesheet" href="../include/assets/css/owl.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
  .page-heading {
    padding: 8rem 0 20px 0; /* kurangi tinggi atas-bawah */
    background-color: #00000;
    text-align: center;
    margin-bottom: 40px;
  }

  .page-heading .breadcrumb {
    font-size: 0.9rem;
    color: #6c757d;
  }

  .page-heading .breadcrumb a {
    text-decoration: none;
    color: #007bff;
  }

  .page-heading h3 {
    margin-top: 10px;
    font-weight: 600;
    font-size: 1.8rem;
    color: #f8f9fa;
  }
  </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<style>
  .page-heading {
    padding: 8rem 0 20px 0; /* kurangi tinggi atas-bawah */
    background-color: #00000;
    text-align: center;
    margin-bottom: 40px;
  }

  .page-heading .breadcrumb {
    font-size: 0.9rem;
    color: #6c757d;
  }

  .page-heading .breadcrumb a {
    text-decoration: none;
    color: #007bff;
  }

  .page-heading h3 {
    margin-top: 10px;
    font-weight: 600;
    font-size: 1.8rem;
    color: #f8f9fa;
  }
</style>
 <div class="page-heading header-text">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10 text-center">
          <span class="breadcrumb">
          </span>
          <h3>Tambah Barang</h3>
        </div>
      </div>
    </div>
  </div>
<br>
<!-- Form Tambah Barang -->
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4">
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
<!-- Scripts -->
  <script src="../include/vendor/jquery/jquery.min.js"></script>
  <script src="../include/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../include/assets/js/owl-carousel.js"></script>
  <script src="../include/assets/js/animation.js"></script>
  <script src="../include/assets/js/imagesloaded.js"></script>
  <script src="../include/assets/js/custom.js"></script>
</body>
</html>
