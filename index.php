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
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Rental Barang</title>

  <!-- MDBootstrap CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" rel="stylesheet"/>
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>

  <style>
    .gradient-custom {
      background: linear-gradient(to right, #a8edea, #fed6e3);
      height: 100vh;
    }
    .password-toggle {
      position: absolute;
      right: 15px;
      top: 38px;
      cursor: pointer;
      color: #6c757d;
    }
  </style>
</head>

<body>
<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-8 col-lg-7 col-xl-6">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
          class="img-fluid" alt="Phone image">
      </div>
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5">

            <h3 class="mb-5 text-center">Login Rental Barang</h3>

            <?php if (isset($error)) : ?>
              <div class="alert alert-danger text-center" role="alert">
                <?= $error ?>
              </div>
            <?php endif; ?>

            <form method="post" autocomplete="off">
              <!-- Username -->
              <div class="mb-4">
                <label for="username" class="form-label fw-semibold">Username</label>
                <input 
                  type="text" 
                  id="username" 
                  name="username" 
                  class="form-control form-control-lg" 
                  required
                  value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" />
              </div>

              <!-- Password -->
              <div class="mb-4 position-relative">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input 
                  type="password" 
                  id="password" 
                  name="password" 
                  class="form-control form-control-lg" 
                  required />
                <i class="fa-solid fa-eye password-toggle" id="togglePassword"></i>
              </div>

              <!-- Tombol login -->
              <button class="btn btn-primary btn-lg w-100" type="submit" name="login">LOGIN</button>
            </form>

            <hr class="my-4">

            <p class="mb-0 text-center">Belum punya akun?
              <a href="register.php" class="text-decoration-none">Daftar Sekarang</a>
            </p>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MDBootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.js"></script>

<script>
  // Show/hide password
  const togglePassword = document.querySelector("#togglePassword");
  const password = document.querySelector("#password");

  togglePassword.addEventListener("click", function() {
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    this.classList.toggle("fa-eye-slash");
  });
</script>

</body>
</html>
