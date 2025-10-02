<?php
session_start();

// Jika belum login, alihkan ke login.php
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>
