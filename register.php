<?php
include 'db.php';

if (isset($_POST['register'])) {
  $nama = $_POST['nama'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = $_POST['role'];

  $query = "INSERT INTO users (nama, username, password, role) VALUES ('$nama','$username','$password','$role')";
  if (mysqli_query($conn, $query)) {
    echo "<script>alert('Pendaftaran berhasil! Silakan login.');window.location='index.php';</script>";
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}
?>
<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
  <h2>Daftar Akun</h2>
  <form method="post">
    <input type="text" name="nama" placeholder="Nama Lengkap" required><br>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <select name="role" required>
      <option value="">-- Pilih Role --</option>
      <option value="penyewa">Penyewa</option>
      <option value="perental">Perental</option>
    </select><br>
    <button type="submit" name="register">Daftar</button>
  </form>
</body>
</html>
