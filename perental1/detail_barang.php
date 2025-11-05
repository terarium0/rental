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

<?php include 'sidebar.php'; ?>

<div class="container-detail p-4">
    <h4 class="fw-bold mb-3">Detail Barang</h4>

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
                <a href="edit_barang1.php?id=<?= $id_barang ?>" class="btn btn-warning">Edit</a>
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

</body>
</html>
