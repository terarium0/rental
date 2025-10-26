<?php
include 'db.php';

if (isset($_POST['register'])) {
  $nama = $_POST['nama'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $telepon = $_POST['telepon'];
  $role = $_POST['role'];

  $query = "INSERT INTO users (nama, username, password, telepon, role) VALUES ('$nama','$username','$password', '$telepon', '$role')";
  if (mysqli_query($conn, $query)) {
    echo "<script>alert('Pendaftaran berhasil! Silakan login.');window.location='index.php';</script>";
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Section: Design Block -->
<section class="">
  <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: #f5f5f5;">
    <div class="container">
      <div class="row gx-lg-5 align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <h1 class="my-5 display-5 fw-bold ls-tight">
            Platform Rental <br />
            <span class="text-primary">Barang Terpercaya</span>
          </h1>
          <p style="color: #555;">
            Daftarkan akun Anda untuk mulai menyewa atau merentalkan barang dengan mudah dan cepat.
          </p>
        </div>

        <div class="col-lg-6 mb-5 mb-lg-0">
          <div class="card shadow">
            <div class="card-body py-5 px-md-5">
              <h3 class="text-center mb-4">Daftar Akun</h3>
              <form method="post">
                
                <div class="mb-3">
                  <label class="form-label fw-semibold">Nama Lengkap</label>
                  <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-semibold">Username</label>
                  <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-semibold">Password</label>
                  <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-semibold">Nomor Telepon</label>
                  <input type="text" name="telepon" class="form-control" placeholder="Contoh: 628123456789" required pattern="[0-9]{10,15}">
                </div>

                <div class="mb-4">
                  <label class="form-label fw-semibold">Pilih Role</label>
                  <select name="role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="penyewa">Penyewa</option>
                    <option value="perental">Perental</option>
                  </select>
                </div>

                <button type="submit" name="register" class="btn btn-primary btn-block w-100">
                  Daftar
                </button>

                <div class="text-center mt-3">
                  <p>Sudah punya akun? <a href="index.php">Login di sini</a></p>
                </div>

              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
<!-- Section: Design Block -->
</body>
</html>
