<?php
session_start();
include '../db.php';

if ($_SESSION['role'] != 'perental') {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id_user'];
$barang = mysqli_query($conn, "SELECT * FROM barang WHERE id_perental='$id'");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Barang</title>
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
  .content { margin-left: 240px; padding: 20px }
  .card-img-top { height: 150px; object-fit: cover }
</style>
 <div class="page-heading header-text">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10 text-center">
          <span class="breadcrumb">
          </span>
          <h3>Data Barang</h3>
        </div>
      </div>
    </div>
  </div>


<div class="content">
<br>
  <div class="row g-3">
    <?php while($row = mysqli_fetch_assoc($barang)): ?>
      <div class="col-md-4">
        <div class="card shadow-sm h-100">
          
          <?php if ($row['foto']): ?>
            <img src="../uploads/<?= $row['foto'] ?>" class="card-img-top">
          <?php else: ?>
            <div class="p-5 text-center text-muted">Tidak ada gambar</div>
          <?php endif; ?>

          <div class="card-body">
            <h6 class="text-center fw-bold"><?= strtoupper($row['nama_barang']) ?></h6>

            <p class="text-center mb-1">
              <span class="badge <?= $row['status']=='tersedia'?'bg-success':'bg-danger' ?>">
                <?= $row['status'] ?>
              </span>
            </p>

            <p class="text-center text-dark fw-semibold">
              Rp<?= number_format($row['harga_sewa'], 0, ',', '.') ?>/hari
            </p>

            <a href="detail_barang.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm w-100">
              Detail
            </a>

          </div>
        </div>
      </div>
    <?php endwhile; ?>
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
