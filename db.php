<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "rental_barang"; // ubah dari rental_native

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}
?>