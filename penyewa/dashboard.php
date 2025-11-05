<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'penyewa') {
  header('Location: ../index.php');
  exit;
}

// Ambil data dari tabel barang (ubah nama tabel sesuai kebutuhan)
$query = mysqli_query($conn, "SELECT * FROM barang ORDER BY id DESC");
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

    <title>Plot Listing HTML5 Website Template</title>

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

  <!-- ***** Header Area Start ***** -->
  <?php include 'navbar.php'; ?>
  <!-- ***** Header Area End ***** -->

  <div class="main-banner">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="top-text header-text">
            <h6>Over 36,500+ Active Listings</h6>
            <h2>Find Nearby Places &amp; Things</h2>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="popular-categories">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading">
            <h2>Popular Categories</h2>
            <h6>Check Them Out</h6>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="naccs">
            <div class="grid">
              <div class="row">
                <div class="col-lg-3">
                  <div class="menu">
                    <div class="">
                      <div class="thumb" class="active">
                        <span class="icon"><img src="assets/images/search-icon-03.png" alt=""></span>
                        Kendaraan
                      </div>
                    </div>
                    <div>
                      <div class="thumb">                 
                        <span class="icon"><img src="assets/images/search-icon-04.png" alt=""></span>
                        Elektronik
                      </div>
                    </div>
                    <div class="last-thumb">
                      <div class="thumb">                 
                        <span class="icon"><img src="assets/images/search-icon-0.png" alt=""></span>
                        Lainnya
                      </div>
                    </div>
                  </div>
                </div> 
                <div class="col-lg-9 align-self-center">
                  <ul class="nacc">
                    <li class="active">
                      <div>
                        <div class="thumb">
                          <div class="row">
                            <div class="col-lg-5 align-self-center">
                              <div class="left-text">
                                <h4>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium non molestiae exercitationem dolore a illum ut odio, nesciunt quasi recusandae nobis blanditiis veniam laborum asperiores ipsa sapiente suscipit. Possimus, repellat?</p>
                                <div class="main-white-button"><a href="#"><i class="fa fa-eye"></i> Discover More</a></div>
                              </div>
                            </div>
                            <div class="col-lg-7 align-self-center">
                              <div class="right-image">
                                <img src="assets/images/tabs-image-01.jpg" alt="">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div>
                        <div class="thumb">
                          <div class="row">
                            <div class="col-lg-5 align-self-center">
                              <div class="left-text">
                                <h4>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium non molestiae exercitationem dolore a illum ut odio, nesciunt quasi recusandae nobis blanditiis veniam laborum asperiores ipsa sapiente suscipit. Possimus, repellat?</p>                                
                                <div class="main-white-button"><a href="#"><i class="fa fa-eye"></i> Explore More</a></div>
                              </div>
                            </div>
                            <div class="col-lg-7 align-self-center">
                              <div class="right-image">
                                <img src="assets/images/tabs-image-02.jpg" alt="Foods on the table">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div>
                        <div class="thumb">
                          <div class="row">
                            <div class="col-lg-5 align-self-center">
                              <div class="left-text">
                                <h4>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium non molestiae exercitationem dolore a illum ut odio, nesciunt quasi recusandae nobis blanditiis veniam laborum asperiores ipsa sapiente suscipit. Possimus, repellat?</p>                                
                                <div class="main-white-button"><a href="listing.php"><i class="fa fa-eye"></i> More Listing</a></div>
                              </div>
                            </div>
                            <div class="col-lg-7 align-self-center">
                              <div class="right-image">
                                <img src="assets/images/tabs-image-03.jpg" alt="cars in the city">
                              </div>
                            </div>
                          </div>
                        </div>
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


  <div class="recent-listing">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading">
            <h2>Recent Listing</h2>
            <h6>Check Them Out</h6>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="owl-carousel owl-listing">
            <?php while ($data = mysqli_fetch_assoc($query)) { ?>
            <div class="item">
              <div class="row">
                <div class="col-lg-12">
                  <div class="listing-item">
                    <div class="left-image">
                      <a href="#">
                        <img src="../uploads/<?php echo htmlspecialchars($data['foto']); ?>" 
                            alt="<?php echo htmlspecialchars($data['nama_barang']); ?>" 
                            style="height: 350px; object-fit: cover; border-radius: 10px;">
                      </a>
                    </div>
                    <div class="right-content align-self-center">
                      <a href="#"><h4><?php echo htmlspecialchars($data['nama_barang']); ?></h4></a>
                      <h6>Kategori: <?php echo htmlspecialchars($data['kategori']); ?></h6>
                      <p><?php echo nl2br(htmlspecialchars($data['deskripsi'])); ?></p>
                      <span class="price">
                        <div class="icon">
                          <img src="assets/images/listing-icon-01.png" alt="">
                        </div>
                        Rp<?php echo number_format($data['harga_sewa'], 0, ',', '.'); ?> / hari
                      </span>
                      <span class="details">
                        Status: 
                        <em style="color: <?php echo ($data['status'] == 'tersedia') ? 'green' : 'red'; ?>;">
                          <?php echo ucfirst($data['status']); ?>
                        </em>
                      </span>
                      <div class="main-white-button mt-3">
                        <a href="detail_barang.php?id=<?php echo $data['id']; ?>">
                          <i class="fa fa-eye"></i> Lihat Detail
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?= include 'footer.php'; ?>

  <!-- Scripts -->
  <script src="../include/vendor/jquery/jquery.min.js"></script>
  <script src="../include/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../include/assets/js/owl-carousel.js"></script>
  <script src="../include/assets/js/animation.js"></script>
  <script src="../include/assets/js/imagesloaded.js"></script>
  <script src="../include/assets/js/custom.js"></script>

</body>

</html>
