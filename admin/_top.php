<?php 
require_once __DIR__.'/../inc/db.php'; 
session_start(); 

if (!isset($_SESSION['admin_id']) && basename($_SERVER['PHP_SELF']) !== 'login.php') { 
    header('Location: login.php'); 
    exit; 
} 
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Admin - PT RKI</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="../assets/img/logo-red.png">

  <!-- CSS Utama -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/admin.css"> <!-- CSS baru -->

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  
  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<section class="section">
  <div class="container">
    <!-- Header Admin -->
    <div class="admin-top">
      <h2>
        <i class="fas fa-cogs"></i> Admin PT RKI
      </h2>
      <div class="nav-links">
        <a href="products.php"><i class="fas fa-box"></i> Produk</a>
        <a href="categories.php"><i class="fas fa-tags"></i> Kategori</a>
        <a href="gallery.php"><i class="fas fa-image"></i> Galeri</a>
        <a href="jobs.php"><i class="fas fa-briefcase"></i> Lowongan</a>
        <a href="messages.php"><i class="fas fa-envelope"></i> Pesan</a>
        <a href="applications.php"><i class="fas fa-file-alt"></i> Lamaran</a>
        <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </div>
    </div>
  </div>
</section>
