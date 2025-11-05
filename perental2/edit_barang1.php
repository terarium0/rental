<?php
session_start();
include '../db.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'perental' && $_SESSION['role'] != 'admin')) {
    header("Location: ../index.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID barang tidak ada di URL");
}

$id_barang = $_GET['id'];
$id_perental = $_SESSION['id_user'];

// Ambil data barang
$barangQuery = mysqli_query($conn, "SELECT * FROM barang WHERE id='$id_barang' AND id_perental='$id_perental'");
if (!$barangQuery) die("Query gagal: " . mysqli_error($conn));

$barang = mysqli_fetch_assoc($barangQuery);
if (!$barang) die("Barang tidak ditemukan");

// Update data barang
if (isset($_POST['update'])) {
    $nama = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $harga_sewa = $_POST['harga_sewa'];
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];
    $fotoUtama = $barang['foto']; // default

    // Ganti foto utama jika upload baru
    if (!empty($_FILES['foto_utama']['name'])) {
        $newFile = time() . "_" . $_FILES['foto_utama']['name'];
        move_uploaded_file($_FILES['foto_utama']['tmp_name'], "../uploads/" . $newFile);

        if (!empty($barang['foto']) && file_exists("../uploads/" . $barang['foto'])) {
            unlink("../uploads/" . $barang['foto']);
        }

        $fotoUtama = $newFile;
    }

    // Jalankan update barang
    $updateBarang = mysqli_query($conn,
        "UPDATE barang SET 
            nama_barang='$nama',
            kategori='$kategori',
            harga_sewa='$harga_sewa',
            deskripsi='$deskripsi',
            status='$status',
            foto='$fotoUtama'
        WHERE id='$id_barang'"
    );

    if (!$updateBarang) {
        die("Error update barang: " . mysqli_error($conn));
    }

    // Upload foto tambahan
    if (!empty($_FILES['foto_tambahan']['name'][0])) {
        foreach ($_FILES['foto_tambahan']['name'] as $key => $val) {
            $fileName = time() . "_" . $_FILES['foto_tambahan']['name'][$key];
            $tmp = $_FILES['foto_tambahan']['tmp_name'][$key];
            move_uploaded_file($tmp, "../uploads/" . $fileName);

            mysqli_query($conn,
                "INSERT INTO barang_foto(id_barang, file_foto) 
                 VALUES('$id_barang', '$fileName')"
            );
        }
    }

    echo "<script>alert('Barang berhasil diupdate!'); 
    window.location='detail_barang.php?id=$id_barang';</script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Barang</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="container mt-4" style="margin-left:260px;">
    <h4 class="fw-bold mb-3">Edit Barang</h4>

<form method="POST" enctype="multipart/form-data">

<div class="row">
<div class="col-md-6">

    <div class="mb-3">
        <label class="form-label">Nama Barang</label>
        <input type="text" name="nama_barang" class="form-control" 
        value="<?= $barang['nama_barang'] ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Kategori</label>
        <input type="text" name="kategori" class="form-control" 
        value="<?= $barang['kategori'] ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">harga_sewa Sewa / Hari</label>
        <input type="number" name="harga_sewa" class="form-control" 
        value="<?= $barang['harga_sewa'] ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-control">
            <option value="tersedia" <?= $barang['status']=='tersedia'?'selected':'' ?>>Tersedia</option>
            <option value="tidak tersedia" <?= $barang['status']=='tidak tersedia'?'selected':'' ?>>Tidak Tersedia</option>
        </select>
    </div>

</div>

<div class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Foto Utama Saat Ini</label><br>
        <img src="../uploads/<?= $barang['foto'] ?>" width="180" class="rounded shadow-sm">
        <input type="file" name="foto_utama" class="form-control mt-2">
    </div>

</div>
</div>

<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="deskripsi" class="form-control" rows="4"><?= $barang['deskripsi'] ?></textarea>
</div>

<button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
<a href="data_barang.php" class="btn btn-secondary">Kembali</a>

</form>

</div>
</body>
</html>
