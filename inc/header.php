<?php
$title = $title ?? 'PT Rumah Keramik Indonesia';
$desc  = $desc  ?? 'Produsen ubin keramik (tile) untuk lantai & dinding.';
require_once __DIR__ . '/db.php';
?>
<!doctype html>
<html lang="id" data-theme="light">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title><?= htmlspecialchars($title) ?> | PT RKI</title>
  <meta name="description" content="<?= htmlspecialchars($desc) ?>"/>

  <!-- Fonts & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="icon" href="assets/img/logo-red.png">

  <!-- Styles -->
  <link rel="stylesheet" href="assets/css/style.css?v=2.0">

  <style>
    /* ================== THEME VARIABLES ================== */
    :root[data-theme="light"] {
      --bg-color: #ffffff;
      --text-color: #111111;
      --nav-bg: rgba(255, 255, 255, 0.95);
      --nav-text: #111111;
      --highlight: #e60000;
    }
    :root[data-theme="dark"] {
      --bg-color: #0b1220;
      --text-color: #f5f5f5;
      --nav-bg: rgba(20, 20, 30, 0.95);
      --nav-text: #f5f5f5;
      --highlight: #ff3333;
    }

    /* ================== BASE ================== */
    body {
      background: var(--bg-color);
      color: var(--text-color);
      font-family: 'Inter', sans-serif;
      transition: background .3s ease, color .3s ease;
    }
    main { padding-top: 80px; }
    a { text-decoration: none; color: var(--text-color); transition: color .3s; }

    /* ================== HEADER ================== */
    header {
      background: var(--nav-bg);
      color: var(--nav-text);
      position: fixed; top: 0; left: 0;
      width: 100%; z-index: 1000;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      transition: background .3s ease, color .3s ease;
    }
    .container.navbar {
      max-width: 1200px; margin:auto;
      display:flex; align-items:center; justify-content:space-between;
      padding: 12px 20px;
    }
    .brand { display:flex; gap:8px; align-items:center; font-weight:600; color:var(--nav-text); }
    .brand img { height:40px; transition:.3s ease; }

    /* ================== NAV MENU DESKTOP ================== */
    #nav-menu ul {
      display:flex; gap:24px; list-style:none; margin:0; padding:0;
    }
    #nav-menu ul li a {
      font-weight:600; padding:8px 6px; color:var(--nav-text);
      transition:color .3s ease;
    }
    #nav-menu ul li a:hover { color:var(--highlight); }
    .nav-cta { background:var(--highlight); color:#fff !important; padding:8px 16px; border-radius:6px; }
    .nav-cta:hover { opacity:.9; }

    /* ================== HAMBURGER ================== */
    .header-right { display:flex; align-items:center; gap:10px; }
    .menu-toggle {
      display:none; background:none; border:none; font-size:26px; cursor:pointer;
      color:var(--nav-text); transition:color .3s ease; z-index:2100;
    }

    /* ================== MOBILE SLIDE MENU ================== */
    .mobile-menu {
      position:fixed; top:0; right:-100%; width:80%; max-width:300px; height:100%;
      background:var(--bg-color); box-shadow:-2px 0 10px rgba(0,0,0,.3);
      transition:right .3s ease; z-index:2000; padding:20px;
    }
    .mobile-menu.active { right:0; }
    .mobile-menu .close-btn {
      position:absolute; top:15px; right:20px; background:none; border:none;
      font-size:28px; cursor:pointer; color:var(--text-color);
    }
    .mobile-menu ul {
      list-style:none; padding:60px 0 0 0; margin:0;
      display:flex; flex-direction:column; gap:20px;
    }
    .mobile-menu ul li a {
      font-size:18px; font-weight:600; color:var(--text-color); transition:color .3s;
    }
    .mobile-menu ul li a:hover { color:var(--highlight); }

    /* ================== RESPONSIVE ================== */
    @media (max-width: 992px) {
      #nav-menu { display:none !important; }
      .menu-toggle { display:block; }
    }

    /* ================== FLOATING DARK MODE ================== */
    .theme-toggle-floating {
      position:fixed; top:50%; right:20px; transform:translateY(-50%);
      background:var(--highlight); color:#fff; border:none; border-radius:50%;
      width:50px; height:50px; font-size:20px; cursor:pointer; z-index:2000;
      box-shadow:0 4px 10px rgba(0,0,0,0.3);
      transition:background .3s ease, transform .2s ease;
    }
    .theme-toggle-floating:hover { background:#c40812; transform:translateY(-50%) scale(1.1); }
  </style>
</head>

<body>
<header>
  <div class="container navbar">
    <!-- Logo & Brand -->
    <a class="brand" href="index.php">
      <img id="logo-header" src="assets/img/logo-red.png" alt="PT RKI">
      <strong>PT Rumah Keramik Indonesia</strong>
    </a>

    <!-- Hamburger Button -->
    <div class="header-right">
      <button class="menu-toggle" aria-label="Menu">
        <i class="fa fa-bars"></i>
      </button>
    </div>

    <!-- Menu Desktop -->
    <nav id="nav-menu">
      <ul>
        <li><a href="index.php?page=home">Home</a></li>
        <li><a href="index.php?page=produk">Produk</a></li>
        <li><a href="index.php?page=tentang">Tentang Kami</a></li>
        <li><a href="index.php?page=pabrik">Pabrik Kami</a></li>
        <li><a href="index.php?page=karir">Karir</a></li>
        <li><a class="nav-cta" href="index.php?page=kontak">Hubungi Kami</a></li>
      </ul>
    </nav>
  </div>
</header>

<!-- Menu Mobile -->
<div class="mobile-menu" id="mobileMenu">
  <button class="close-btn">&times;</button>
  <ul>
    <li><a href="index.php?page=home">Home</a></li>
    <li><a href="index.php?page=produk">Produk</a></li>
    <li><a href="index.php?page=tentang">Tentang Kami</a></li>
    <li><a href="index.php?page=pabrik">Pabrik Kami</a></li>
    <li><a href="index.php?page=karir">Karir</a></li>
    <li><a class="nav-cta" href="index.php?page=kontak">Hubungi Kami</a></li>
    <li><a href="admin/login.php" target="_blank">Login Admin</a></li>
  </ul>
</div>

<main>

<!-- Floating Dark Mode Button -->
<button id="theme-toggle-floating" class="theme-toggle-floating" aria-label="Ubah Tema">
  <i class="fa-solid fa-moon"></i>
</button>

<script>
document.addEventListener("DOMContentLoaded", () => {
  // Mobile Menu
  const menuToggle = document.querySelector(".menu-toggle");
  const mobileMenu = document.getElementById("mobileMenu");
  const closeBtn   = document.querySelector(".close-btn");

  menuToggle.addEventListener("click", () => mobileMenu.classList.add("active"));
  closeBtn.addEventListener("click", () => mobileMenu.classList.remove("active"));
  window.addEventListener("click", (e) => {
    if (!mobileMenu.contains(e.target) && !menuToggle.contains(e.target)) {
      mobileMenu.classList.remove("active");
    }
  });

  // Dark Mode
  const toggleBtn  = document.getElementById("theme-toggle-floating");
  const htmlTag    = document.documentElement;
  const logoHeader = document.getElementById("logo-header");
  const logoFooter = document.getElementById("logo-footer");

  function updateLogo(theme) {
    if (theme === "dark") {
      if (logoHeader) logoHeader.src = "assets/img/logo-white.png";
      if (logoFooter) logoFooter.src = "assets/img/logo-white.png";
    } else {
      if (logoHeader) logoHeader.src = "assets/img/logo-red.png";
      if (logoFooter) logoFooter.src = "assets/img/logo-red.png";
    }
  }

  const savedTheme = localStorage.getItem("theme") || "light";
  htmlTag.setAttribute("data-theme", savedTheme);
  updateLogo(savedTheme);
  toggleBtn.innerHTML = savedTheme === "dark" ? '<i class="fa-solid fa-sun"></i>' : '<i class="fa-solid fa-moon"></i>';

  toggleBtn.addEventListener("click", () => {
    const currentTheme = htmlTag.getAttribute("data-theme");
    const newTheme = currentTheme === "light" ? "dark" : "light";
    htmlTag.setAttribute("data-theme", newTheme);
    localStorage.setItem("theme", newTheme);
    updateLogo(newTheme);
    toggleBtn.innerHTML = newTheme === "dark" ? '<i class="fa-solid fa-sun"></i>' : '<i class="fa-solid fa-moon"></i>';
  });
});
</script>
