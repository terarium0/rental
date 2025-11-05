<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<div class="sidebar">
<h4 class="text-center mb-4">Menu</h4>
  <a href="dashboard.php">🏠 Dashboard</a>
  <a href="data_barang.php">📦 Data Barang</a>
  <a href="tambah_barang2.php">➕ Tambah Barang</a>
  <a href="../logout.php" class="text-danger">🚪 Logout</a>
</div>

<style>
  body { background:#f4f6f9; }
  .sidebar {
    width: 220px;
    min-height: 100vh;
    background: #2c3e50;
    color: white;
    position: fixed;
    left: 0;
    top: 0;
    padding: 20px 0;
  }
  .sidebar a {
    display: block;
    padding: 12px 20px;
    text-decoration: none;
    color: white;
    font-size: 15px;
  }
  .sidebar a:hover {
    background: #34495e;
  }
</style>
