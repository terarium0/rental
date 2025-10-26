<!-- navbar.php -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
  <div class="container-fluid px-4">
    <a class="navbar-brand text-primary fw-bold" href="dashboard.php">🚗 RentalApp</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-dark" href="dashboard.php">🏠 Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="tambah_mobil.php">➕ Tambah Mobil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="../logout.php">🚪 Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<style>
  body {
    padding-top: 70px; /* agar konten tidak tertutup navbar */
  }

  .nav-link {
    display: flex;
    align-items: center;
    gap: 5px;
    font-weight: 500;
  }

  .nav-link:hover {
    color: #0d6efd !important;
    transform: translateY(-1px);
  }
</style>
