<?php
session_start();
include '../db.php';

if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'perental') {
    header('Location: ../index.php');
    exit;
}

$id_user = $_SESSION['id_user'];

if (!isset($_GET['id'])) {
    echo "Barang tidak ditemukan.";
    exit;
}

$id_barang = $_GET['id'];

// Query ambil barang
$query = "SELECT * FROM barang WHERE id='$id_barang'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Barang tidak ditemukan.";
    exit;
}

// Query foto tambahan
$query_foto = mysqli_query($conn, "SELECT * FROM barang WHERE id = '$id_barang'");

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Barang</title>
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
    .container-detail { margin-left:260px; }
    .thumb-img { width:70px; height:70px; object-fit:cover; cursor:pointer; border-radius:6px; }
    .main-img { width:100%; max-height:380px; object-fit:cover; border-radius:12px; }
    .badge-status { font-size: 14px; }
</style>

<script>
function changeImage(src){
    document.getElementById('mainImage').src = src;
}
</script>
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
          <h3>Detail Barang</h3>
        </div>
      </div>
    </div>
  </div>


<div class="container-detail p-4">

    <div class="row g-4">
        
        <!-- Bagian Gambar -->
        <div class="col-md-5">
            <img id="mainImage" src="../uploads/<?= $data['foto'] ?>" class="main-img mb-3">
            <!---
            <div class="d-flex gap-2">
                <img src="../uploads/<?= $data['foto'] ?>" class="thumb-img" onclick="changeImage(this.src)">
             --->   
                <?php
                // Galeri foto tambahan bila ada
                ?>
            </div>
        </div>

        <!-- Bagian Info -->
        <div class="col-md-7">
            <h5><?= $data['nama_barang'] ?></h5>
            <p class="text-muted"><?= $data['kategori'] ?></p>
            <p><?= nl2br($data['deskripsi']) ?></p>
            <h4 class="text-primary">Rp <?= number_format($data['harga_sewa'],0,',','.') ?>/hari</h4>

            <p class="mt-2">
                Status:
                <?php if ($data['status'] == 'tersedia') { ?>
                    <span class="badge bg-success badge-status">Tersedia</span>
                <?php } else { ?>
                    <span class="badge bg-danger badge-status">Tidak Tersedia</span>
                <?php } ?>
            </p>

            <div class="mt-4 d-flex gap-2">
                <a href="edit_barang.php?id=<?= $id_barang ?>" class="btn btn-warning">Edit</a>
                <a href="hapus_barang.php?id=<?= $id_barang ?>" class="btn btn-danger" onclick="return confirm('Hapus barang?')">Hapus</a>

                <?php if ($data['status'] == 'tersedia') { ?>
                    <a href="status_barang.php?id=<?= $id_barang ?>&status=tidak tersedia" class="btn btn-secondary">
                        Nonaktifkan
                    </a>
                <?php } else { ?>
                    <a href="status_barang.php?id=<?= $id_barang ?>&status=tersedia" class="btn btn-success">
                        Aktifkan
                    </a>
                <?php } ?>
            </div>
        </div>

    </div>
</div>
 <!-- Scripts -->
  <script src="../include/vendor/jquery/jquery.min.js"></script>
  <script src="../include/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../include/assets/js/owl-carousel.js"></script>
  <script src="../include/assets/js/animation.js"></script>
  <script src="../include/assets/js/imagesloaded.js"></script>
  <script src="../include/assets/js/custom.js"></script>
</body>
</html>
