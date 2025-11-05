<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'perental') {
  header('Location: ../index.php');
  exit;
}

$id_perental = $_SESSION['id_user'];
$result = mysqli_query($conn, "
  SELECT t.*, m.nama_barang
  FROM sewa t
  JOIN barang m ON t.id_barang = m.id
  WHERE m.id_perental = '$id_perental'
  ORDER BY t.id DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Sewa Masuk (Perental)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <h2 class="mb-4 text-center fw-bold">Sewa Masuk (Perental)</h2>

  <div class="row g-4">
    <?php while($row = mysqli_fetch_assoc($result)): ?>
      <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-header bg-dark text-white text-center">
            <h5 class="mb-0"><?= htmlspecialchars($row['nama_barang']) ?></h5>
          </div>
          <div class="card-body">
            <p><strong>Tanggal Mulai:</strong> <?= htmlspecialchars($row['tanggal_mulai']) ?></p>
            <p><strong>Tanggal Selesai:</strong> <?= htmlspecialchars($row['tanggal_selesai']) ?></p>
            <p><strong>Total Harga:</strong> Rp<?= number_format($row['total_harga'],0,',','.') ?></p>
            <p><strong>Status:</strong> 
              <span class="badge bg-<?=
                $row['status']=='menunggu'?'warning':
                ($row['status']=='disetujui'?'success':'danger')
              ?>">
                <?= ucfirst($row['status']) ?>
              </span>
            </p>
            <div class="mt-3 text-center">
              <?php if ($row['status'] == 'Menunggu Verifikasi'): ?>
                <a href="update_status.php?id=<?= $row['id'] ?>&status=Lunas" class="btn btn-success btn-sm">Setujui</a>
                <a href="update_status.php?id=<?= $row['id'] ?>&status=Ditolak" class="btn btn-danger btn-sm">Tolak</a>
              <?php else: ?>
                <em class="text-muted">Tidak ada aksi</em>
              <?php endif; ?>
            </div>
          </div>

          <div class="card-footer bg-light">
            <h6 class="fw-bold text-center mb-2">Pembayaran</h6>
            <?php
              $id_sewa = $row['id'];
              $pembayaran = mysqli_query($conn, "SELECT * FROM pembayaran WHERE id_sewa = '$id_sewa'");
              if (mysqli_num_rows($pembayaran) > 0):
                while($pay = mysqli_fetch_assoc($pembayaran)):
            ?>
              <div class="card mb-2">
                <img src="../uploads/bukti/<?= htmlspecialchars($pay['bukti_transfer']) ?>" 
                     class="card-img-top" alt="Bukti Transfer" 
                     style="max-height:200px; object-fit:cover;">
                <div class="card-body p-2">
                  <p class="mb-1"><strong>Metode:</strong> <?= htmlspecialchars($pay['metode']) ?></p>
                  <p class="mb-1"><strong>Tgl Bayar:</strong> <?= htmlspecialchars($pay['tanggal_bayar']) ?></p>
                  <p class="mb-1"><strong>Status:</strong> 
                    <span class="badge bg-<?=
                      $pay['status']=='valid'?'success':
                      ($pay['status']=='menunggu'?'warning':'danger')
                    ?>">
                      <?= ucfirst($pay['status']) ?>
                    </span>
                  </p>
                </div>
              </div>
            <?php
                endwhile;
              else:
                echo "<p class='text-muted text-center mb-0'>Belum ada pembayaran</p>";
              endif;
            ?>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>
</body>
</html>
