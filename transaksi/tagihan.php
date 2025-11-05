<?php
session_start();
include '../db.php';

// Pastikan hanya penyewa yang bisa mengakses
if ($_SESSION['role'] != 'penyewa') {
  header('Location: ../index.php');
  exit;
}

$id_sewa = $_GET['id'] ?? null;
if (!$id_sewa) {
  header('Location: ../dashboard.php');
  exit;
}

// Ambil data transaksi dan barang terkait
$query = mysqli_query($conn, "
  SELECT s.*, b.nama_barang, b.harga_sewa, b.foto, u.username AS pemilik
  FROM sewa s
  JOIN barang b ON s.id_barang = b.id
  JOIN users u ON b.id_perental = u.id
  WHERE s.id = '$id_sewa'
");
$data = mysqli_fetch_assoc($query);

// Ambil rekening admin
$rekening = mysqli_query($conn, "SELECT * FROM rekening_admin LIMIT 1");
$rek = mysqli_fetch_assoc($rekening);

// Proses upload bukti pembayaran
if (isset($_POST['upload'])) {
  $id_sewa = $_POST['id_sewa'];
  $bukti = $_FILES['bukti']['name'];
  $tmp = $_FILES['bukti']['tmp_name'];

  if ($bukti != '') {
    $ext = pathinfo($bukti, PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','gif'];
    if (in_array(strtolower($ext), $allowed)) {
      $newname = time() . '_' . rand(100,999) . '.' . $ext;
      move_uploaded_file($tmp, "../uploads/bukti/" . $newname);
      $bukti = $newname;

      // Simpan ke tabel pembayaran
      mysqli_query($conn, "
        INSERT INTO pembayaran (id_sewa, bukti_transfer, status)
        VALUES ('$id_sewa', '$bukti', 'Menunggu Verifikasi')
      ");

      // Update status transaksi
      mysqli_query($conn, "UPDATE sewa SET status = 'Menunggu Verifikasi' WHERE id = '$id_sewa'");

      echo "<script>alert('Bukti pembayaran berhasil dikirim!');window.location='transaksi_penyewa.php';</script>";
      exit;
    } else {
      echo "<script>alert('Format file tidak valid!');</script>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tagihan Pembayaran | Rental Barang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
          <h3>Pembayaran Sewa</h3>
        </div>
      </div>
    </div>
</div>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card p-4">
        <h4 class="text-center mb-4">Tagihan Pembayaran</h4>

        <div class="row mb-4">
          <div class="col-md-5">
            <img src="../uploads/<?= $data['foto'] ?>" class="w-100" alt="<?= htmlspecialchars($data['nama_barang']) ?>">
          </div>
          <div class="col-md-7">
            <h5><?= htmlspecialchars($data['nama_barang']) ?></h5>
            <p class="mb-1"><strong>Pemilik:</strong> <?= htmlspecialchars($data['pemilik']) ?></p>
            <p class="mb-1"><strong>Harga Sewa:</strong> Rp<?= number_format($data['harga_sewa'], 0, ',', '.') ?>/hari</p>
            <p class="mb-1"><strong>Tanggal Sewa:</strong> <?= htmlspecialchars($data['tanggal_mulai']) ?> s/d <?= htmlspecialchars($data['tanggal_selesai']) ?></p>
            <p class="mb-1"><strong>Total Bayar:</strong> Rp<?= number_format($data['total_harga'], 0, ',', '.') ?></p>
            <p class="mb-1"><strong>Status:</strong> <span class="badge bg-warning text-dark"><?= $data['status'] ?></span></p>
          </div>
        </div>

        <hr>

        <h6 class="fw-bold">Transfer ke Rekening Admin</h6>
        <ul>
          <li><strong>Bank:</strong> <?= htmlspecialchars($rek['nama_bank']) ?></li>
          <li><strong>No. Rekening:</strong> <?= htmlspecialchars($rek['no_rekening']) ?></li>
          <li><strong>Atas Nama:</strong> <?= htmlspecialchars($rek['atas_nama']) ?></li>
        </ul>

        <div class="alert alert-info mt-3">
          Silakan lakukan pembayaran sesuai total di atas, kemudian upload bukti transfer di bawah ini.
        </div>

        <form method="post" enctype="multipart/form-data">
          <input type="hidden" name="id_sewa" value="<?= $id_sewa ?>">
          <div class="mb-3">
            <label class="form-label">Upload Bukti Transfer</label>
            <input type="file" name="bukti" class="form-control" accept="image/*" required>
          </div>
          <button type="submit" name="upload" class="btn btn-primary w-100">
            Kirim Bukti Pembayaran
          </button>
        </form>

      </div>
    </div>
  </div>
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../include/vendor/jquery/jquery.min.js"></script>
  <script src="../include/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../include/assets/js/owl-carousel.js"></script>
  <script src="../include/assets/js/animation.js"></script>
  <script src="../include/assets/js/imagesloaded.js"></script>
  <script src="../include/assets/js/custom.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
