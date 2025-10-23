<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
  $user = mysqli_fetch_assoc($result);

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['login'] = true;
    $_SESSION['role'] = $user['role'];
    $_SESSION['id_user'] = $user['id'];

    if ($user['role'] == 'admin') header("Location: admin/dashboard.php");
    elseif ($user['role'] == 'perental') header("Location: perental/dashboard.php");
    else header("Location: penyewa/dashboard.php");
    exit;
  } else {
    $error = "Username atau password salah";
  }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login Rental</title></head>
<body>
  <h2>Login</h2>
  <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
  <form method="post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="login">Login</button>
  </form>
  <p><a href="register.php">Daftar Akun</a></p>
</body>
</html>
