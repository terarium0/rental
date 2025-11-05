<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'penyewa') {
  header('Location: ../index.php');
  exit;
}

$id = $_GET['id'] ?? 0;
// Ambil data per kategori
$kendaraan = mysqli_query($conn, "SELECT * FROM barang WHERE kategori = 'kendaraan' ORDER BY id DESC");
$elektronik = mysqli_query($conn, "SELECT * FROM barang WHERE kategori = 'elektronik' ORDER BY id DESC");
$lainnya = mysqli_query($conn, "SELECT * FROM barang WHERE kategori NOT IN ('kendaraan', 'elektronik') ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Plot Listing Page</title>

    <!-- Bootstrap core CSS -->
    <link href="../include/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="../include/assets/css/fontawesome.css">
    <link rel="stylesheet" href="../include/assets/css/templatemo-plot-listing.css">
    <link rel="stylesheet" href="../include/assets/css/animated.css">
    <link rel="stylesheet" href="../include/assets/css/owl.css">
<!--

TemplateMo 564 Plot Listing

https://templatemo.com/tm-564-plot-listing

-->
  </head>

<body>

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <?php include 'navbar.php'; ?>

  <div class="page-heading">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="top-text header-text">
            <h6>Check Out Our Listings</h6>
            <h2>Item listings of Different Categories</h2>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="listing-page">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="naccs">
          <div class="grid">
            <div class="row">
              <!-- MENU KATEGORI -->
              <div class="col-lg-3">
                <div class="menu">
                  <div class="first-thumb active">
                    <div class="thumb">
                      <span class="icon"><img src="assets/images/search-icon-01.png" alt=""></span>
                      Kendaraan
                    </div>
                  </div>
                  <div>
                    <div class="thumb">                 
                      <span class="icon"><img src="assets/images/search-icon-02.png" alt=""></span>
                      Elektronik
                    </div>
                  </div>
                  <div class="last-thumb">
                    <div class="thumb">                 
                      <span class="icon"><img src="assets/images/search-icon-03.png" alt=""></span>
                      Lainnya
                    </div>
                  </div>
                </div>
              </div> 

              <!-- DAFTAR PRODUK -->
              <div class="col-lg-9">
                <ul class="nacc">
                  <!-- ===== KATEGORI KENDARAAN ===== -->
                  <li class="active">
                    <div class="col-lg-12">
                      <?php while ($data = mysqli_fetch_assoc($kendaraan)) { ?>
                        <div class="card mb-4 shadow-sm border-0 rounded-3 overflow-hidden">
                          <div class="row g-0 align-items-center">
                            
                            <!-- Gambar kiri -->
                            <div class="col-md-5">
                              <?php
                              $fotoPath = "../uploads/" . htmlspecialchars($data['foto']);
                              if (!file_exists($fotoPath) || empty($data['foto'])) {
                                $fotoPath = "assets/images/no-image.png";
                              }
                              ?>
                              <a href="detail_barang.php?id=<?php echo $data['id']; ?>">
                                <img src="<?php echo $fotoPath; ?>" 
                                    alt="<?php echo htmlspecialchars($data['nama_barang']); ?>" 
                                    class="img-fluid rounded-start" 
                                    style="height: 220px; width: 100%; object-fit: cover;">
                              </a>
                            </div>

                            <!-- Konten kanan -->
                            <div class="col-md-7">
                              <div class="card-body">
                                <h4 class="card-title mb-2 text-dark fw-semibold">
                                  <?php echo htmlspecialchars($data['nama_barang']); ?>
                                </h4>
                                <h6 class="text-muted mb-2">
                                  <i class="bi bi-tags"></i> 
                                  Kategori: <span class="text-primary"><?php echo htmlspecialchars($data['kategori']); ?></span>
                                </h6>
                                <p class="card-text text-secondary mb-2" style="font-size: 0.95rem;">
                                  <?php echo nl2br(htmlspecialchars($data['deskripsi'])); ?>
                                </p>
                                
                                <div class="d-flex align-items-center justify-content-between mt-3">
                                  <span class="price fw-bold text-success">
                                    <i class="bi bi-cash-coin me-1"></i>
                                    Rp<?php echo number_format($data['harga_sewa'], 0, ',', '.'); ?> / hari
                                  </span>
                                  <span class="badge rounded-pill px-3 py-2" 
                                        style="background-color: <?php echo ($data['status'] == 'tersedia') ? '#d4edda' : '#f8d7da'; ?>;
                                              color: <?php echo ($data['status'] == 'tersedia') ? '#155724' : '#721c24'; ?>;">
                                    <?php echo ucfirst($data['status']); ?>
                                  </span>
                                </div>

                                <div class="mt-4">
                                  <a href="detail_barang.php?id=<?php echo $data['id']; ?>" 
                                    class="btn btn-outline-primary btn-sm px-3">
                                    <i class="fa fa-eye"></i> Lihat Detail
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  </li>

                  <!-- ===== KATEGORI ELEKTRONIK ===== -->
                  <li>
                    <div class="col-lg-12">
                      <?php while ($data = mysqli_fetch_assoc($elektronik)) { ?>
                        <div class="card mb-4 shadow-sm border-0 rounded-3 overflow-hidden">
                          <div class="row g-0 align-items-center">
                            
                            <!-- Gambar kiri -->
                            <div class="col-md-5">
                              <?php
                              $fotoPath = "../uploads/" . htmlspecialchars($data['foto']);
                              if (!file_exists($fotoPath) || empty($data['foto'])) {
                                $fotoPath = "assets/images/no-image.png";
                              }
                              ?>
                              <a href="detail_barang.php?id=<?php echo $data['id']; ?>">
                                <img src="<?php echo $fotoPath; ?>" 
                                    alt="<?php echo htmlspecialchars($data['nama_barang']); ?>" 
                                    class="img-fluid rounded-start" 
                                    style="height: 220px; width: 100%; object-fit: cover;">
                              </a>
                            </div>

                            <!-- Konten kanan -->
                            <div class="col-md-7">
                              <div class="card-body">
                                <h4 class="card-title mb-2 text-dark fw-semibold">
                                  <?php echo htmlspecialchars($data['nama_barang']); ?>
                                </h4>
                                <h6 class="text-muted mb-2">
                                  <i class="bi bi-laptop"></i> 
                                  Kategori: <span class="text-primary"><?php echo htmlspecialchars($data['kategori']); ?></span>
                                </h6>
                                <p class="card-text text-secondary mb-2" style="font-size: 0.95rem;">
                                  <?php echo nl2br(htmlspecialchars($data['deskripsi'])); ?>
                                </p>
                                
                                <div class="d-flex align-items-center justify-content-between mt-3">
                                  <span class="price fw-bold text-success">
                                    <i class="bi bi-cash-coin me-1"></i>
                                    Rp<?php echo number_format($data['harga_sewa'], 0, ',', '.'); ?> / hari
                                  </span>
                                  <span class="badge rounded-pill px-3 py-2" 
                                        style="background-color: <?php echo ($data['status'] == 'tersedia') ? '#d4edda' : '#f8d7da'; ?>;
                                              color: <?php echo ($data['status'] == 'tersedia') ? '#155724' : '#721c24'; ?>;">
                                    <?php echo ucfirst($data['status']); ?>
                                  </span>
                                </div>

                                <div class="mt-4">
                                  <a href="detail_barang.php?id=<?php echo $data['id']; ?>" 
                                    class="btn btn-outline-primary btn-sm px-3">
                                    <i class="fa fa-eye"></i> Lihat Detail
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  </li>

                  <!-- ===== KATEGORI LAINNYA ===== -->
                  <li>
                    <div class="col-lg-12">
                      <?php while ($data = mysqli_fetch_assoc($lainnya)) { ?>
                        <div class="card mb-4 shadow-sm border-0 rounded-3 overflow-hidden">
                          <div class="row g-0 align-items-center">
                            
                            <!-- Gambar kiri -->
                            <div class="col-md-5">
                              <?php
                              $fotoPath = "../uploads/" . htmlspecialchars($data['foto']);
                              if (!file_exists($fotoPath) || empty($data['foto'])) {
                                $fotoPath = "assets/images/no-image.png";
                              }
                              ?>
                              <a href="detail_barang.php?id=<?php echo $data['id']; ?>">
                                <img src="<?php echo $fotoPath; ?>" 
                                    alt="<?php echo htmlspecialchars($data['nama_barang']); ?>" 
                                    class="img-fluid rounded-start" 
                                    style="height: 220px; width: 100%; object-fit: cover;">
                              </a>
                            </div>

                            <!-- Konten kanan -->
                            <div class="col-md-7">
                              <div class="card-body">
                                <h4 class="card-title mb-2 text-dark fw-semibold">
                                  <?php echo htmlspecialchars($data['nama_barang']); ?>
                                </h4>
                                <h6 class="text-muted mb-2">
                                  <i class="bi bi-box-seam"></i> 
                                  Kategori: <span class="text-primary"><?php echo htmlspecialchars($data['kategori']); ?></span>
                                </h6>
                                <p class="card-text text-secondary mb-2" style="font-size: 0.95rem;">
                                  <?php echo nl2br(htmlspecialchars($data['deskripsi'])); ?>
                                </p>
                                
                                <div class="d-flex align-items-center justify-content-between mt-3">
                                  <span class="price fw-bold text-success">
                                    <i class="bi bi-cash-coin me-1"></i>
                                    Rp<?php echo number_format($data['harga_sewa'], 0, ',', '.'); ?> / hari
                                  </span>
                                  <span class="badge rounded-pill px-3 py-2" 
                                        style="background-color: <?php echo ($data['status'] == 'tersedia') ? '#d4edda' : '#f8d7da'; ?>;
                                              color: <?php echo ($data['status'] == 'tersedia') ? '#155724' : '#721c24'; ?>;">
                                    <?php echo ucfirst($data['status']); ?>
                                  </span>
                                </div>

                                <div class="mt-4">
                                  <a href="detail_barang.php?id=<?php echo $data['id']; ?>" 
                                    class="btn btn-outline-primary btn-sm px-3">
                                    <i class="fa fa-eye"></i> Lihat Detail
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  </li>
                </ul>

              </div>          
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <?= include 'footer.php'; ?>

  <!-- Scripts -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/animation.js"></script>
  <script src="assets/js/imagesloaded.js"></script>
  <script src="assets/js/custom.js"></script>

</body>

</html>