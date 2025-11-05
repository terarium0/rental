<?php 
session_start();
include '../db.php'; 

if ($_SESSION['role'] != 'penyewa') {
    header('Location: ../index.php');
    exit;
}

$id_user = $_SESSION['id_user'];

// Ambil data user
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id_user'");
$user_data = mysqli_fetch_assoc($user_query);

// Ambil data sewa beserta foto barang
$result = mysqli_query($conn, "
    SELECT t.*, m.nama_barang, m.foto, m.harga_sewa 
    FROM sewa t 
    JOIN barang m ON t.id_barang = m.id 
    WHERE t.id_penyewa = '$id_user' 
    ORDER BY t.id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Sewa Saya</title>

  <meta charset="UTF-8">
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
  
<!-- Navbar -->
<!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
    <div class="container">
      <div class="row"> 
        <div class="col-12">
          <nav class="main-nav">
            <!-- ***** Logo Start ***** -->
            <a href="index.html" class="logo">
            </a>
            <!-- ***** Logo End ***** -->
            <!-- ***** Menu Start ***** -->
            <ul class="nav">
              <li><a href="../penyewa/dashboard.php">Home</a></li>
              <li><a href="../penyewa/listing.php">Listing</a></li>
              <li><a href="transaksi_penyewa.php">History</a></li>
              <li><a href="../penyewa/contact.php">Contact Us</a></li> 
              <li><div class="main-white-button"><a href="../logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a></div></li> 
            </ul>        
            <a class='menu-trigger'>
                <span>Menu</span>
            </a>
            <!-- ***** Menu End ***** -->
          </nav>
        </div>
      </div>
    </div>
  </header>

<!-- Header Section -->
<style>
  .page-heading {
    padding: 8rem 0 20px 0; /* kurangi tinggi atas-bawah */
    background-color: #f8f9fa;
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
          <h3>Riwayat Sewa <?= htmlspecialchars($user_data['nama']) ?> (<?= htmlspecialchars($user_data['username']) ?>)</h3>
        </div>
      </div>
    </div>
  </div>

  <div class="container my-4">
    <div class="row">
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="row g-0">
                        <!-- Gambar kiri -->
                        <div class="col-5">
                            <?php $fotoPath = '../uploads/' . ($row['foto'] ?? 'default.png'); ?>
                            <img src="<?= $fotoPath ?>" 
                                 alt="<?= htmlspecialchars($row['nama_barang']) ?>" 
                                 class="img-fluid h-100" 
                                 style="object-fit: cover;">
                        </div>
                        
                        <!-- Konten kanan -->
                        <div class="col-7 p-3">
                            <h5 class="card-title"><?= htmlspecialchars($row['nama_barang']) ?></h5>
                            <p class="card-text mb-1">
                                <strong>Tanggal Mulai:</strong> <?= $row['tanggal_mulai'] ?><br>
                                <strong>Tanggal Selesai:</strong> <?= $row['tanggal_selesai'] ?><br>
                                <strong>Harga Sewa: </strong> Rp <?=  number_format($row['harga_sewa'],0,',','.')?></strong><br>
                                <strong>Total Harga: </strong> Rp <?= number_format($row['total_harga'],0,',','.') ?><br>
                                <strong>Status:</strong> 
                                <span class="badge bg-<?= 
                                    $row['status'] == 'Menunggu Pembayaran' ? 'warning text-dark' :
                                    ($row['status'] == 'Menunggu Verifikasi' ? 'info text-dark' :
                                    ($row['status'] == 'Disetujui' ? 'success' : 'secondary')) 
                                  ?> status-badge"><?= htmlspecialchars($row['status']) ?>
                                </span>
                            </p>
                        </div>
                        <div class="card-footer text-center bg-white">
                          <?php if ($row['status'] == 'Menunggu Pembayaran' || $row['status'] == 'Menunggu Verifikasi'): ?>
                            <a href="tagihan.php?id=<?= $row['id'] ?>" class="btn btn-primary w-100">
                              Lihat Tagihan
                            </a>
                          <?php else: ?>
                            <a href="tagihan.php?id=<?= $row['id'] ?>" class="btn btn-outline-secondary w-100">
                              Lihat Detail
                            </a>
                          <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>

        <?php if(mysqli_num_rows($result) == 0): ?>
            <p class="text-center">Belum ada data sewa.</p>
        <?php endif; ?>
    </div>
  </div>
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="about">
            <div class="logo">
              <img src="../include/assets/images/black-logo.png" alt="Plot Listing">
            </div>
            <p>If you consider that <a rel="nofollow" href="https://templatemo.com/tm-564-plot-listing" target="_parent">Plot Listing template</a> is useful for your website, please <a rel="nofollow" href="https://www.paypal.me/templatemo" target="_blank">support us</a> a little via PayPal.</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="helpful-links">
            <h4>Helpful Links</h4>
            <div class="row">
              <div class="col-lg-6 col-sm-6">
                <ul>
                  <li><a href="#">Categories</a></li>
                  <li><a href="#">Reviews</a></li>
                  <li><a href="#">Listing</a></li>
                  <li><a href="#">Contact Us</a></li>
                </ul>
              </div>
              <div class="col-lg-6">
                <ul>
                  <li><a href="#">About Us</a></li>
                  <li><a href="#">Awards</a></li>
                  <li><a href="#">Useful Sites</a></li>
                  <li><a href="#">Privacy Policy</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="contact-us">
            <h4>Contact Us</h4>
            <p>27th Street of New Town, Digital Villa</p>
            <div class="row">
              <div class="col-lg-6">
                <a href="#">010-020-0340</a>
              </div>
              <div class="col-lg-6">
                <a href="#">090-080-0760</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="sub-footer">
            <p>Copyright © 2021 Plot Listing Co., Ltd. All Rights Reserved.
            <br>
			Design: <a rel="nofollow" href="https://templatemo.com" title="CSS Templates">TemplateMo</a></p>
          </div>
        </div>
      </div>
    </div>
  </footer>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../include/vendor/jquery/jquery.min.js"></script>
  <script src="../include/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../include/assets/js/owl-carousel.js"></script>
  <script src="../include/assets/js/animation.js"></script>
  <script src="../include/assets/js/imagesloaded.js"></script>
  <script src="../include/assets/js/custom.js"></script>
  </body>
</html>
