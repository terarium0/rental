<?php
session_start();
include '../db.php';

if ($_SESSION['role'] != 'perental') {
    header('Location: ../index.php');
    exit;
}

$id = $_SESSION['id_user'];

// Statistik dasar
$total_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM barang WHERE id_perental='$id'"))['jml'];
$tersedia = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM barang WHERE id_perental='$id' AND status='tersedia'"))['jml'];
$disewa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM barang WHERE id_perental='$id' AND status!='tersedia'"))['jml'];

// Grafik: jumlah penyewaan per bulan (tahun berjalan) untuk barang milik perental ini
$bulan_query = mysqli_query($conn,
    "SELECT MONTH(tanggal_mulai) AS bulan, COUNT(*) AS total
     FROM sewa s
     JOIN barang b ON s.id_barang = b.id
     WHERE b.id_perental = '$id' AND YEAR(tanggal_mulai) = YEAR(CURRENT_DATE())
     GROUP BY MONTH(tanggal_mulai)"
);

// Inisialisasi array 12 bulan (index 1..12)
$monthly = array_fill(1, 12, 0);
while ($r = mysqli_fetch_assoc($bulan_query)) {
    $m = (int)$r['bulan'];
    $monthly[$m] = (int)$r['total'];
}

// Top 3 barang paling sering disewa (hanya barang milik perental)
$top_query = mysqli_query($conn,
    "SELECT b.nama_barang, COUNT(s.id) AS total_sewa
     FROM sewa s
     JOIN barang b ON s.id_barang = b.id
     WHERE b.id_perental = '$id'
     GROUP BY s.id_barang
     ORDER BY total_sewa DESC
     LIMIT 3"
);
$toplist = [];
while ($t = mysqli_fetch_assoc($top_query)) {
    $toplist[] = $t;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Perental</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
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
  body { background:#f4f6f9; font-family: 'Montserrat', sans-serif; }
  .sidebar { width: 220px; min-height: 100vh; background: #2c3e50; color: white; position: fixed; left: 0; top: 0; padding: 20px 0; }
  .sidebar a { display: block; padding: 12px 20px; text-decoration: none; color: white; font-size: 15px; }
  .sidebar a:hover { background: #34495e; }
  .card-stat { border-radius: 12px; }
  .content { margin-left: 100px; margin-right: 100px; padding: 20px; }
  .card-img-top { height: 150px; object-fit: cover; }
  .top3-item { display:flex; align-items:center; justify-content:space-between; padding:12px; border-radius:8px; background:#fff; box-shadow:0 6px 18px rgba(0,0,0,0.04); margin-bottom:12px; }
  .small-muted { font-size:0.9rem; color:#6c757d; }
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

<div class="page-heading header-text">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 text-center">
        <h3>Dashboard</h3>
      </div>
    </div>
  </div>
</div>

<div class="content container">

  <!-- Statistik cards -->
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card bg-primary text-white card-stat shadow-sm">
        <div class="card-body text-center">
          <h6>Total Barang</h6>
          <h2><?= (int)$total_barang ?></h2>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card bg-success text-white card-stat shadow-sm">
        <div class="card-body text-center">
          <h6>Tersedia</h6>
          <h2><?= (int)$tersedia ?></h2>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card bg-warning text-dark card-stat shadow-sm">
        <div class="card-body text-center">
          <h6>Sedang Disewa</h6>
          <h2><?= (int)$disewa ?></h2>
        </div>
      </div>
    </div>
  </div>

  <!-- Grafik & Top 3 -->
  <div class="row mt-4">
    <div class="col-lg-8">
      <div class="card shadow-sm p-3 mb-4">
        <div class="card-body">
          <h5 class="card-title">Grafik Penyewaan per Bulan (Tahun <?= date('Y') ?>)</h5>
          <canvas id="chartSewa" style="max-height:360px;"></canvas>
        </div>
      </div>

      <!-- Optional: preview tabel transaksi terbaru (5) -->
      <div class="card shadow-sm p-3 mb-4">
        <div class="card-body">
          <h5 class="card-title">Transaksi Terbaru</h5>
          <?php
          $recent_q = mysqli_query($conn,
            "SELECT s.id, b.nama_barang, s.tanggal_mulai, s.tanggal_selesai, s.total_harga, s.status
             FROM sewa s
             JOIN barang b ON s.id_barang = b.id
             WHERE b.id_perental = '$id'
             ORDER BY s.id DESC
             LIMIT 5"
          );
          if (mysqli_num_rows($recent_q) == 0) {
              echo "<div class='alert alert-info mb-0'>Belum ada transaksi.</div>";
          } else {
              echo "<div class='table-responsive'><table class='table table-sm table-striped mb-0'><thead><tr><th>Barang</th><th>Mulai</th><th>Selesai</th><th>Total</th><th>Status</th></tr></thead><tbody>";
              while ($rr = mysqli_fetch_assoc($recent_q)) {
                  $st = htmlspecialchars(ucfirst($rr['status']));
                  $badge = $rr['status'] == 'menunggu' ? 'bg-warning text-dark' : ($rr['status']=='disetujui' ? 'bg-success' : 'bg-danger');
                  echo "<tr>
                          <td>".htmlspecialchars($rr['nama_barang'])."</td>
                          <td>".htmlspecialchars($rr['tanggal_mulai'])."</td>
                          <td>".htmlspecialchars($rr['tanggal_selesai'])."</td>
                          <td>Rp".number_format($rr['total_harga'],0,',','.')."</td>
                          <td><span class='badge $badge'>$st</span></td>
                        </tr>";
              }
              echo "</tbody></table></div>";
          }
          ?>
        </div>
      </div>

    </div>

    <div class="col-lg-4">
      <div class="card shadow-sm p-3 mb-4">
        <div class="card-body">
          <h5 class="card-title">Top 3 Barang Paling Banyak Disewa</h5>

          <?php if (empty($toplist)): ?>
            <div class="alert alert-info">Belum ada data sewa untuk barang Anda.</div>
          <?php else: ?>
            <?php $rank = 1; foreach ($toplist as $item): ?>
              <div class="top3-item">
                <div>
                  <div style="font-weight:600;"><?= htmlspecialchars($item['nama_barang']) ?></div>
                  <div class="small-muted">Terpinjam <?= (int)$item['total_sewa'] ?>x</div>
                </div>
                <div class="text-end">
                  <span class="badge bg-primary" style="font-size:0.9rem; padding:8px 10px; border-radius:8px;">
                    #<?= $rank ?>
                  </span>
                </div>
              </div>
            <?php $rank++; endforeach; ?>
          <?php endif; ?>

        </div>
      </div>

      <!-- Info / Tips -->
      <div class="card shadow-sm p-3">
        <div class="card-body">
          <h6 class="mb-2">Tips</h6>
          <ul class="small-muted mb-0" style="padding-left: 18px;">
            <li>Perbarui foto & deskripsi agar barang lebih cepat disewa.</li>
            <li>Respon cepat ke penyewa untuk tingkatkan rating.</li>
            <li>Periksa tabel <em>Transaksi</em> jika ada sewa menunggu konfirmasi.</li>
          </ul>
        </div>
      </div>

    </div>
  </div>

</div>

<!-- Scripts -->
<script src="../include/vendor/jquery/jquery.min.js"></script>
<script src="../include/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Data bulan (Bahasa Indonesia lengkap)
  const monthLabels = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

  // Ambil data dari PHP
  const monthlyData = <?= json_encode(array_values($monthly)) ?>;

  const ctx = document.getElementById('chartSewa').getContext('2d');
  const chartSewa = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: monthLabels,
      datasets: [{
        label: 'Jumlah Penyewaan',
        data: monthlyData,
        backgroundColor: '#0d6efd',
        borderColor: '#0b5ed7',
        borderWidth: 1,
        borderRadius: 6,
        maxBarThickness: 40
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            precision: 0
          }
        }
      },
      plugins: {
        legend: { display: false },
        tooltip: { mode: 'index', intersect: false }
      }
    }
  });
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
