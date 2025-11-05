<?php
session_start();
include '../db.php';

//Cek login role bila diperlukan
if ($_SESSION['role'] != 'penyewa') {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'] ?? 0;

// Ambil data barang + pemilik
$query = mysqli_query($conn, "
    SELECT b.*, u.username AS pemilik, u.telepon, u.nama
    FROM barang b 
    JOIN users u ON b.id_perental = u.id 
    WHERE b.id = $id
");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Barang tidak ditemukan'); window.location='dashboard.php';</script>";
    exit;
}

// Cek foto
$fotoPath = "../uploads/" . htmlspecialchars($data['foto']);
if (!file_exists($fotoPath) || empty($data['foto'])) {
    $fotoPath = "../include/assets/images/no-image.png";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Barang - <?= htmlspecialchars($data['nama_barang']) ?></title>

  <!-- Template CSS -->
  <link href="../include/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../include/assets/css/fontawesome.css">
  <link rel="stylesheet" href="../include/assets/css/templatemo-plot-listing.css">
  <link rel="stylesheet" href="../include/assets/css/animated.css">
  <link rel="stylesheet" href="../include/assets/css/owl.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body>

<!-- Navbar -->
<?php include 'navbar.php'; ?>

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
        <h3>Details Barang <?= htmlspecialchars($data['nama_barang']) ?></h3>
      </div>
    </div>
  </div>
</div>

<!-- Detail Section -->
<div class="section properties">
  <div class="container">
    <div class="row justify-content-center">
      
      <div class="col-lg-10">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
          <div class="row g-0">
            
            <!-- Gambar kiri -->
            <div class="col-md-5">
              <img src="<?= $fotoPath ?>" 
                   alt="<?= htmlspecialchars($data['nama_barang']) ?>" 
                   class="img-fluid" 
                   style="height:100%; object-fit:cover;">
            </div>

            <!-- Konten kanan -->
            <div class="col-md-7 p-4">
              <h3 class="fw-bold mb-3"><?= htmlspecialchars($data['nama_barang']) ?></h3>

              <p class="mb-2">
                <i class="bi bi-tags"></i> 
                <strong>Kategori:</strong> <?= htmlspecialchars($data['kategori']) ?>
              </p>

              <p class="mb-2">
                <i class="bi bi-cash-coin text-success"></i> 
                <strong>Harga Sewa:</strong> 
                Rp<?= number_format($data['harga_sewa'], 0, ',', '.') ?> / hari
              </p>

              <p class="mb-2">
                <i class="bi bi-person-circle"></i> 
                <strong>Pemilik:</strong> <?= htmlspecialchars($data['nama'])?> | <?= htmlspecialchars($data['pemilik']) ?>
              </p>

              <p class="mb-2">
                <i class="bi bi-telephone"></i> 
                <strong>Telepon:</strong> <?= htmlspecialchars($data['telepon']) ?>
              </p>

              <p class="mb-3">
                <i class="bi bi-box"></i> 
                <strong>Status:</strong> 
                <?= $data['status'] == "tersedia" ? 
                    "<span class='badge bg-success'>Tersedia</span>" : 
                    "<span class='badge bg-secondary'>Dipinjam</span>" ?>
              </p>

              <p class="text-secondary mb-4" style="font-size: 0.95rem;">
                <strong>Deskripsi:</strong><br>
                <?= nl2br(htmlspecialchars($data['deskripsi'] ?: 'Tidak ada deskripsi')) ?>
              </p>

              <div class="d-flex flex-wrap gap-2 mt-4">
                <a href="https://wa.me/62<?= preg_replace('/\D/', '', $data['telepon']) ?>?text=Halo%20Saya%20ingin%20menyewa%20barang%20Anda%20yang%20bernama%20<?= urlencode($data['nama_barang']) ?>"
                   class="btn btn-success flex-fill" target="_blank">
                   <i class="bi bi-whatsapp"></i> Hubungi via WhatsApp
                </a>

                <a href="../transaksi/buat_transaksi.php?id=<?= $data['id'] ?>" 
                   class="btn btn-primary flex-fill">
                   <i class="bi bi-receipt"></i> Catat Transaksi
                </a>

                <a href="listing.php" class="btn btn-outline-secondary flex-fill">
                   <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
  <?= include 'footer.php'; ?>
<!-- Footer JS -->
  <script src="../include/vendor/jquery/jquery.min.js"></script>
  <script src="../include/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../include/assets/js/owl-carousel.js"></script>
  <script src="../include/assets/js/animation.js"></script>
  <script src="../include/assets/js/imagesloaded.js"></script>
  <script src="../include/assets/js/custom.js"></script>
</body>
</html>
