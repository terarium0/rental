<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'penyewa') {
  header('Location: ../index.php');
  exit;
}

$id_barang = $_GET['id'];
$id_penyewa = $_SESSION['id_user'];

$query = mysqli_query($conn, "
    SELECT b.*, u.nama, u.username
    FROM barang b 
    JOIN users u ON b.id_perental = u.id 
    WHERE b.id = '$id_barang'
");
$barang = mysqli_fetch_assoc($query);

if (isset($_POST['pesan'])) {
  $id_penyewa = $_SESSION['id_user'];
  $tgl_mulai = $_POST['tgl_mulai'];
  $tgl_selesai = $_POST['tgl_selesai'];

  $selisih = (strtotime($tgl_selesai) - strtotime($tgl_mulai)) / (60*60*24);
  if ($selisih <= 0) {
    echo "<script>alert('Tanggal tidak valid!');</script>";
  } else {
    $total = $selisih * $barang['harga_sewa'];
    mysqli_query($conn, "INSERT INTO sewa (id_barang, id_penyewa, tanggal_mulai, tanggal_selesai, total_harga)
                         VALUES ('$id_barang', '$id_penyewa', '$tgl_mulai', '$tgl_selesai', '$total')");
    echo "<script>alert('sewa berhasil dibuat, menunggu konfirmasi perental.');window.location='../penyewa/dashboard.php';</script>";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Pesan barang</title>
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
</head>
<body>
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
              <li><a href="contact.php">Contact Us</a></li> 
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
          <h3>Catat Sewa <?= htmlspecialchars($barang['nama_barang']) ?> </h3>
        </div>
      </div>
    </div>
  </div>
  <div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <!-- Gambar di atas -->
                <?php 
                $fotoPath = !empty($barang['foto']) && file_exists("../uploads/" . $barang['foto']) 
                            ? "../uploads/" . $barang['foto'] 
                            : "../include/assets/images/no-image.png"; 
                ?>
                <img src="<?= $fotoPath ?>" 
                     alt="<?= htmlspecialchars($barang['nama_barang']) ?>" 
                     class="card-img-top" 
                     style="object-fit: cover; height: 300px;">

                <!-- Form di bawah gambar -->
                <div class="card-body">
                    <h4 class="fw-bold mb-3"><?= htmlspecialchars($barang['nama_barang']) ?></h4>
                    <p class="mb-2">
                        <strong>Harga Sewa:</strong> Rp<?= number_format($barang['harga_sewa'],0,',','.') ?> / hari
                    </p>

                    <form method="post">
                        <div class="mb-3">
                            <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" required>
                        </div>

                        <div class="mb-3">
                            <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Total Harga</label>
                            <input type="text" class="form-control" id="total_harga" readonly value="Rp0">
                        </div>

                        <button type="submit" name="pesan" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-cart-check"></i> Pesan Sekarang
                        </button>

                        <a href="dashboard2.php" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-left-circle"></i> Kembali
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>


<script>
// Ambil elemen input
const tglMulai = document.getElementById('tgl_mulai');
const tglSelesai = document.getElementById('tgl_selesai');
const totalHarga = document.getElementById('total_harga');
const hargaSewa = <?= (int)$barang['harga_sewa'] ?>; // harga sewa per hari

function hitungTotal() {
    if(tglMulai.value && tglSelesai.value) {
        const start = new Date(tglMulai.value);
        const end = new Date(tglSelesai.value);

        if(end >= start) {
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // termasuk hari pertama
            const total = diffDays * hargaSewa;
            totalHarga.value = "Rp" + total.toLocaleString('id-ID');
        } else {
            totalHarga.value = "Tanggal selesai tidak valid";
        }
    } else {
        totalHarga.value = "Rp0";
    }
}

tglMulai.addEventListener('change', hitungTotal);
tglSelesai.addEventListener('change', hitungTotal);

</script>
  <!-- Scripts -->
  <script src="../include/vendor/jquery/jquery.min.js"></script>
  <script src="../include/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../include/assets/js/owl-carousel.js"></script>
  <script src="../include/assets/js/animation.js"></script>
  <script src="../include/assets/js/imagesloaded.js"></script>
  <script src="../include/assets/js/custom.js"></script>
</body>
</html>
