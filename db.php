<?php
$conn = mysqli_connect("localhost", "root", "", "rental_native");
if (!$conn) {
  die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
