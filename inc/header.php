<?php
$title = $title ?? 'PT Rumah Keramik Indonesia';
$desc  = $desc  ?? 'Produsen ubin keramik (tile) untuk lantai & dinding.';
require_once __DIR__ . '/db.php';
$active = $_GET['page'] ?? 'home';
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

  <!-- Styles utama kamu -->
  <link rel="stylesheet" href="assets/css/style.css?v=2.0">

  <style>
    /* ===== Variabel theme dasar untuk header ===== */
    :root[data-theme="light"]{
      --nav-bg:#ffffff;
      --nav-text:#111111;
      --highlight:#e60000;
    }
    :root[data-theme="dark"]{
      --nav-bg:#111827;
      --nav-text:#f5f5f5;
      --highlight:#ff3333;
    }
    body{font-family:'Inter',sans-serif;}

    /* ================== HEADER ================== */
    .site-header{
      position:fixed; top:0; left:0; width:100%; z-index:1000;
      background: var(--nav-bg);
      color: var(--nav-text);
      box-shadow: 0 6px 18px rgba(2,6,23,.08);
      border-bottom: 1px solid rgba(0,0,0,.06);
      transition: background .25s, box-shadow .25s, border-color .25s, color .25s;
    }
    .container.navbar{
      max-width:1200px; margin:auto;
      display:flex; align-items:center; justify-content:space-between;
      padding:12px 20px;
    }
    .brand{display:flex; gap:8px; align-items:center; font-weight:700; color:inherit;}
    .brand img{height:40px; transition:.3s;}
    /* Underline untuk link biasa (sudah OK) */
#nav-menu a.active:not(.nav-cta) { color: var(--highlight); }
#nav-menu a.active:not(.nav-cta)::after { width: 100%; }

/* Pastikan semua link relatif (agar ::after bisa diposisikan) */
#nav-menu a { position: relative; }

/* CTA selalu terlihat */
#nav-menu a.nav-cta,
.mobile-menu a.nav-cta {
  background: var(--highlight) !important;
  color: #fff !important;
  padding: 8px 16px;
  border-radius: 8px;
  box-shadow: 0 6px 16px rgba(229, 9, 20, .25);
}

/* ==== Underline khusus untuk CTA ==== */
#nav-menu a.nav-cta::after{
  content:"";
  position:absolute;
  left:0; right:0;
  bottom:-6px;                /* sedikit di bawah pil */
  height:2px;
  background: var(--highlight);
  border-radius: 2px;
  opacity:0;
  transform: scaleX(0);
  transition: transform .25s ease, opacity .25s ease;
}
/* Muncul saat hover/active */
#nav-menu a.nav-cta:hover::after,
#nav-menu a.nav-cta.active::after{
  opacity:1;
  transform: scaleX(1);
}

/* Warna latar saat hover/active CTA */
#nav-menu a.nav-cta:hover,
#nav-menu a.nav-cta.active {
  background:#c40812 !important;
  color:#fff !important;
}

/* Saat header transparan di atas hero – underline tetap terlihat */
html.has-hero:not(.header-solid) .site-header #nav-menu a.nav-cta::after {
  background: #ff4d57; /* sedikit lebih terang agar kontras di atas foto */
}


    /* Menu desktop */
    #nav-menu ul{list-style:none; display:flex; gap:26px; margin:0; padding:0;}
    #nav-menu a{
      position:relative; font-weight:700; padding:8px 6px; color:var(--nav-text); text-decoration:none;
      transition:color .25s, background .25s;
      border-radius:999px;
    }
    #nav-menu a:hover{ color: var(--highlight); }
    #nav-menu a.active{ color: var(--highlight); }
    #nav-menu a::after{
      content:""; position:absolute; left:0; bottom:-4px; height:2px; width:0; background:var(--highlight); transition:width .25s;
    }
    #nav-menu a:hover::after, #nav-menu a.active::after{ width:100%; }

    .nav-cta{ background: var(--highlight); color:#fff !important; padding:8px 16px; border-radius:8px; }
    .nav-cta:hover{ opacity:.9; }

    /* Mobile */
    .header-right{display:flex; align-items:center; gap:10px;}
    .menu-toggle{display:none; background:none; border:none; font-size:26px; cursor:pointer; color:var(--nav-text);}

    @media (max-width: 992px){
      #nav-menu{display:none !important;}
      .menu-toggle{display:block;}
    }

    /* ====== Header TRANSPARAN saat di atas hero ====== */
    html.has-hero:not(.header-solid) .site-header{
      background: transparent !important;
      box-shadow: none !important;
      border-bottom-color: transparent !important;
    }
    html.has-hero:not(.header-solid) .site-header .brand,
    html.has-hero:not(.header-solid) .site-header #nav-menu a{ color:#fff !important; }
    html.has-hero:not(.header-solid) .site-header #nav-menu a.active,
    html.has-hero:not(.header-solid) .site-header #nav-menu a:hover{
      background: transparent !important;
    }
    html.has-hero:not(.header-solid) .site-header #nav-menu a::after{ background:#fff; }

    /* ====== main padding: 0 saat transparan ====== */
    html.has-hero:not(.header-solid) main{ padding-top:0 !important; }
    html.header-solid main, html:not(.has-hero) main{ padding-top: var(--header-h, 86px) !important; }

    /* ================== MOBILE SLIDE MENU ================== */
    .mobile-menu{
      position:fixed; top:0; right:-100%; width:80%; max-width:300px; height:100%;
      background:var(--nav-bg); box-shadow:-2px 0 10px rgba(0,0,0,.3);
      transition:right .4s ease, opacity .4s ease;
      z-index:2000; padding:20px; opacity:0;
    }
    .mobile-menu.active{ right:0; opacity:1; }
    .mobile-menu .close-btn{
      position:absolute; top:15px; right:20px; background:none; border:none; font-size:28px; cursor:pointer; color:var(--nav-text);
    }
    .mobile-menu ul{ list-style:none; padding:60px 0 0 0; margin:0; display:flex; flex-direction:column; gap:20px;}
    .mobile-menu a{ font-weight:700; color:var(--nav-text); text-decoration:none; position:relative; }
    .mobile-menu a.active{ color: var(--highlight); }
    .mobile-menu a.active::after{ content:""; position:absolute; left:0; bottom:-4px; width:100%; height:2px; background: var(--highlight); }

    /* ================== FLOATING DARK MODE ================== */
    .theme-toggle-floating{
      position:fixed; top:50%; right:20px; transform:translateY(-50%);
      background:var(--highlight); color:#fff; border:none; border-radius:50%;
      width:50px; height:50px; font-size:20px; cursor:pointer; z-index:2000;
      box-shadow:0 4px 10px rgba(0,0,0,.3);
      transition:background .3s, transform .2s;
    }
    .theme-toggle-floating:hover{ background:#c40812; transform:translateY(-50%) scale(1.1); }
  </style>
</head>

<body>
<header class="site-header">
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
        <li><a href="index.php?page=home"    class="<?= $active=='home'?'active':'' ?>">Home</a></li>
        <li><a href="index.php?page=produk"  class="<?= $active=='produk'?'active':'' ?>">Produk</a></li>
        <li><a href="index.php?page=tentang" class="<?= $active=='tentang'?'active':'' ?>">Tentang Kami</a></li>
        <li><a href="index.php?page=pabrik"  class="<?= $active=='pabrik'?'active':'' ?>">Pabrik Kami</a></li>
        <li><a href="index.php?page=karir"   class="<?= $active=='karir'?'active':'' ?>">Karir</a></li>
        <li><a class="nav-cta <?= $active=='kontak'?'active':'' ?>" href="index.php?page=kontak">Hubungi Kami</a></li>
      </ul>
    </nav>
  </div>
</header>

<!-- Menu Mobile -->
<div class="mobile-menu" id="mobileMenu">
  <button class="close-btn" aria-label="Tutup">&times;</button>
  <ul>
    <li><a href="index.php?page=home"    class="<?= $active=='home'?'active':'' ?>">Home</a></li>
    <li><a href="index.php?page=produk"  class="<?= $active=='produk'?'active':'' ?>">Produk</a></li>
    <li><a href="index.php?page=tentang" class="<?= $active=='tentang'?'active':'' ?>">Tentang Kami</a></li>
    <li><a href="index.php?page=pabrik"  class="<?= $active=='pabrik'?'active':'' ?>">Pabrik Kami</a></li>
    <li><a href="index.php?page=karir"   class="<?= $active=='karir'?'active':'' ?>">Karir</a></li>
    <li><a class="nav-cta <?= $active=='kontak'?'active':'' ?>" href="index.php?page=kontak">Hubungi Kami</a></li>
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

  if (menuToggle) {
    menuToggle.addEventListener("click", () => mobileMenu.classList.add("active"));
  }
  if (closeBtn) {
    closeBtn.addEventListener("click", () => mobileMenu.classList.remove("active"));
  }
  window.addEventListener("click", (e) => {
    if (!mobileMenu.contains(e.target) && !menuToggle.contains(e.target)) {
      mobileMenu.classList.remove("active");
    }
  });

  // Dark Mode toggle
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
  if (toggleBtn) toggleBtn.innerHTML = savedTheme === "dark" ? '<i class="fa-solid fa-sun"></i>' : '<i class="fa-solid fa-moon"></i>';

  if (toggleBtn) {
    toggleBtn.addEventListener("click", () => {
      const currentTheme = htmlTag.getAttribute("data-theme");
      const newTheme = currentTheme === "light" ? "dark" : "light";
      htmlTag.setAttribute("data-theme", newTheme);
      localStorage.setItem("theme", newTheme);
      updateLogo(newTheme);
      toggleBtn.innerHTML = newTheme === "dark" ? '<i class="fa-solid fa-sun"></i>' : '<i class="fa-solid fa-moon"></i>';
    });
  }

  // Set tinggi header ke CSS var → dipakai padding main ketika solid
  const header = document.querySelector('.site-header');
  function setHeaderH(){
    const h = (header?.offsetHeight || 86);
    htmlTag.style.setProperty('--header-h', h + 'px');
  }
  setHeaderH();
  window.addEventListener('resize', setHeaderH);
});
</script>
