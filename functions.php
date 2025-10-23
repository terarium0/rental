<?php
// functions.php
session_start();
include_once 'db.php';

// ---- Helper DB: prepared SELECT returning array ----
function db_query($conn, $sql, $types = null, $params = []) {
  $stmt = mysqli_prepare($conn, $sql);
  if ($stmt === false) {
    return false;
  }
  if ($types && $params) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
  }
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  mysqli_stmt_close($stmt);
  if ($res === true || $res === false) return $res;
  return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

// ---- Helper DB: prepared execute (INSERT/UPDATE/DELETE) ----
function db_execute($conn, $sql, $types = null, $params = []) {
  $stmt = mysqli_prepare($conn, $sql);
  if ($stmt === false) {
    return false;
  }
  if ($types && $params) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
  }
  $ok = mysqli_stmt_execute($stmt);
  if (!$ok) {
    $err = mysqli_error($conn);
    mysqli_stmt_close($stmt);
    return ['ok'=>false,'error'=>$err];
  }
  $last_id = mysqli_insert_id($conn);
  mysqli_stmt_close($stmt);
  return ['ok'=>true,'last_id'=>$last_id];
}

// ---- Auth helpers ----
function is_logged_in() {
  return isset($_SESSION['login']) && $_SESSION['login'] === true;
}
function require_login() {
  if (!is_logged_in()) {
    header('Location: ../index.php');
    exit;
  }
}
function require_role($role) {
  require_login();
  if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
    header('Location: ../index.php');
    exit;
  }
}

// ---- Get user ----
function get_user_by_id($conn, $id) {
  $r = db_query($conn, "SELECT id,nama,username,role FROM users WHERE id = ?", "i", [$id]);
  return $r ? $r[0] : null;
}

// ---- Get single row helper ----
function db_query_one($conn, $sql, $types = null, $params = []) {
  $rows = db_query($conn, $sql, $types, $params);
  return ($rows && count($rows) > 0) ? $rows[0] : null;
}
?>
