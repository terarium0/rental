<?php
include '../functions.php';
require_role('perental');

if (!isset($_GET['id']) || !isset($_GET['act'])) {
  header('Location: dashboard.php'); exit;
}
$id_trans = (int)$_GET['id'];
$action = $_GET['act'];

if ($action == 'approve') {
  $res = db_execute($conn, "UPDATE transaksi SET status = 'disetujui' WHERE id = ?", "i", [$id_trans]);
} elseif ($action == 'complete') {
  $res = db_execute($conn, "UPDATE transaksi SET status = 'selesai' WHERE id = ?", "i", [$id_trans]);
}

header('Location: dashboard.php');
exit;
