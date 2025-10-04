<?php 
$title = 'Home'; 
include __DIR__ . '/../inc/header.php'; 
?>

<!-- ================= HERO SLIDER ================= -->
<section class="hero-home">
  <div class="hero-slider" id="heroSlider">
    <?php
    $gal = $pdo->query("SELECT image FROM gallery ORDER BY id DESC LIMIT 6")->fetchAll();
    if (!$gal) {
      echo '<div class="slide active" style="background-image:url(\'assets/img/rki.jpg\')"></div>';
      echo '<div class="slide" style="background-image:url(\'assets/img/calcita.jpg\')"></div>';
    } else {
      foreach ($gal as $k => $g) {
        $src = file_exists("uploads/gallery/".$g['image']) 
            ? "uploads/gallery/".htmlspecialchars($g['image']) 
            : "assets/img/rki.jpg";
        $cls = $k === 0 ? 'slide active' : 'slide';
        echo '<div class="'.$cls.'" style="background-image:url(\''.$src.'\')"></div>';
      }
    }
    ?>

    <!-- Overlay Konten -->
    <div class="overlay">
      <h1 data-aos="fade-up">
        Produsen Ubin Keramik <span class="highlight">Lantai</span> & <span class="highlight">Dinding</span>
      </h1>
      <p data-aos="fade-up" data-aos-delay="200">
        Menghadirkan kualitas, ketahanan, dan estetika terbaik untuk setiap ruang.
      </p>
      <div class="btn-group" data-aos="fade-up" data-aos-delay="300">
        <a href="index.php?page=produk" class="btn fancy-btn primary-btn">📦 Lihat Produk</a>
        <a href="index.php?page=tentang" class="btn fancy-btn secondary-btn">ℹ️ Tentang Kami</a>
      </div>
    </div>

    <!-- Dots Navigasi -->
    <div class="dots" id="heroDots">
      <?php 
      if ($gal) {
        for ($i=0; $i<count($gal); $i++) {
          echo '<button'.($i===0?' class="active"':'').'></button>';
        }
      } else {
        echo '<button class="active"></button><button></button>';
      }
      ?>
    </div>
  </div>
</section>

<!-- ================= FITUR UNGGULAN ================= -->
<section class="section" style="padding:60px 20px; background:var(--bg-section);">
  <div class="container">
    <h2 class="center-text" data-aos="fade-up">Mengapa Memilih Kami?</h2>
    <div class="grid grid-3 features-home">
      <div class="feature-card" data-aos="zoom-in" data-aos-delay="100">
        <div class="icon-circle"><i class="fas fa-fire"></i></div>
        <h3>Teknologi Glaze</h3>
        <p>Permukaan halus & tahan gores dengan teknologi mutakhir.</p>
      </div>
      <div class="feature-card" data-aos="zoom-in" data-aos-delay="200">
        <div class="icon-circle"><i class="fas fa-award"></i></div>
        <h3>Standar Mutu Tinggi</h3>
        <p>QC ketat dari bahan baku hingga tahap akhir produksi.</p>
      </div>
      <div class="feature-card" data-aos="zoom-in" data-aos-delay="300">
        <div class="icon-circle"><i class="fas fa-th-large"></i></div>
        <h3>Varian Motif Modern</h3>
        <p>Marmer, batu alam, kayu, dan motif modern sesuai tren.</p>
      </div>
    </div>
  </div>
</section>

<!-- ================= PRODUK UNGGULAN ================= -->
<section class="section" style="padding:60px 20px; background:var(--bg-section);">
  <div class="container">
    <h2 class="center-text" data-aos="fade-up">Produk Unggulan</h2>
    <div class="grid grid-3 products">
      <div class="product-card" data-aos="fade-up" data-aos-delay="100">
        <img src="assets/img/alabstro.jpg" alt="Alabstro">
        <h4>Keramik Premium</h4>
        <p>Kualitas terbaik untuk lantai rumah & bangunan.</p>
      </div>
      <div class="product-card" data-aos="fade-up" data-aos-delay="200">
        <img src="assets/img/Arabescato.jpg" alt="Arabescato">
        <h4>Motif Marmer</h4>
        <p>Elegan dengan nuansa alam yang mewah.</p>
      </div>
      <div class="product-card" data-aos="fade-up" data-aos-delay="300">
        <img src="assets/img/Calcita.jpg" alt="Calcita">
        <h4>Keramik Dinding</h4>
        <p>Hadir dalam berbagai motif modern.</p>
      </div>
    </div>
    <div style="text-align:center; margin-top:30px;">
  <a href="index.php?page=produk" class="btn-fancy">✨ Lihat Semua Produk</a>
</div>
  </div>
</section>

<!-- ================= TENTANG KAMI (YOUTUBE VIDEO) ================= -->
<section class="section tentang-kami">
  <div class="container grid grid-2">
    <!-- Video YouTube Embed -->
    <div class="video-wrapper" data-aos="fade-right">
      <div id="ytplayer"></div>
      <button id="toggleSound" class="sound-btn">🔇</button>
    </div>

    <!-- Konten -->
    <div data-aos="fade-left" class="tentang-content">
      <h2>Tentang Kami</h2>
      <p>
        <strong>PT Rumah Keramik Indonesia</strong> berdiri dengan komitmen menghadirkan 
        <span class="highlight">produk ubin berkualitas tinggi</span> menggunakan teknologi modern.  
        Kami percaya bahwa setiap ruang pantas mendapatkan sentuhan estetika, 
        kekuatan, dan ketahanan terbaik.
      </p>
      <p>
        Dengan standar mutu yang konsisten dan inovasi yang berkelanjutan, 
        kami terus berkembang untuk menjadi produsen keramik terpercaya di Indonesia.
      </p>
      <a href="index.php?page=tentang" class="btn-primary">Pelajari Lebih Lanjut</a>
    </div>
  </div>
</section>

<!-- ================= STYLE ================= -->
<style>
/* === Grup Tombol === */
.btn-group {
  display: flex;
  gap: 15px;
  justify-content: center;
  margin-top: 20px;
}
.fancy-btn {
  display: inline-block;
  padding: 12px 28px;
  font-size: 16px;
  font-weight: 600;
  text-decoration: none;
  border-radius: 50px;
  position: relative;
  overflow: hidden;
  transition: all 0.3s ease;
  z-index: 1;
}
.fancy-btn::before {
  content: "";
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: rgba(255,255,255,0.2);
  transition: all 0.4s ease;
  z-index: -1;
}
.fancy-btn:hover::before { left: 0; }
.primary-btn {
  background: linear-gradient(135deg, #e60000, #ff4d4d);
  color: #fff;
  box-shadow: 0 4px 12px rgba(230, 0, 0, 0.4);
}
.primary-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 16px rgba(230, 0, 0, 0.6);
}
.secondary-btn {
  background: #fff;
  color: #e60000;
  border: 2px solid #e60000;
}
.secondary-btn:hover {
  background: #e60000;
  color: #fff;
  transform: translateY(-3px);
  box-shadow: 0 6px 16px rgba(230, 0, 0, 0.3);
}
[data-theme="dark"] .secondary-btn {
  background: #1f2937;
  color: #ff4d4d;
  border: 2px solid #ff4d4d;
}
[data-theme="dark"] .secondary-btn:hover {
  background: #ff4d4d;
  color: #fff;
  box-shadow: 0 6px 16px rgba(255, 77, 77, 0.5);
}
[data-theme="dark"] .primary-btn {
  background: linear-gradient(135deg, #ff3333, #e60000);
  box-shadow: 0 4px 12px rgba(255, 77, 77, 0.5);
}
[data-theme="dark"] .primary-btn:hover {
  box-shadow: 0 6px 18px rgba(255, 77, 77, 0.8);
}

/* ================= PRODUK UNGGULAN MODERN ================= */
.products {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 30px;
  margin-top: 40px;
}
.product-card {
  position: relative;
  border-radius: 16px;
  overflow: hidden;
  background: #fff;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
  transition: transform 0.35s ease, box-shadow 0.35s ease;
  cursor: pointer;
}
.product-card:hover {
  transform: translateY(-10px) scale(1.02);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
}
.product-card img {
  width: 100%;
  height: 230px;
  object-fit: cover;
  border-radius: 16px 16px 0 0;
  transition: transform 0.5s ease, filter 0.5s ease;
}
.product-card:hover img {
  transform: scale(1.1);
  filter: brightness(0.9);
}
.product-card::after {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,0.6), rgba(0,0,0,0));
  opacity: 0;
  transition: opacity 0.4s ease;
  border-radius: 16px;
}
.product-card:hover::after { opacity: 1; }
.product-card h4, 
.product-card p {
  margin: 12px 16px;
  position: relative;
  z-index: 2;
  transition: color 0.3s ease;
}
.product-card h4 {
  font-size: 1.2rem;
  font-weight: 700;
  color: #111;
}
.product-card p {
  font-size: 0.95rem;
  color: #444;
  line-height: 1.5;
}
.product-card:hover h4,
.product-card:hover p { color: #fff; }
.product-card:hover {
  border: 2px solid #e60000;
  box-shadow: 0 8px 25px rgba(230, 0, 0, 0.4);
}
@media (max-width: 768px) {
  .products { grid-template-columns: 1fr; }
  .product-card img { height: 200px; }
}
.btn-fancy {
  display: inline-block;
  padding: 14px 36px;
  font-size: 16px;
  font-weight: 600;
  color: #fff;
  text-decoration: none;
  border-radius: 50px;
  background: linear-gradient(135deg, #e60000, #ff3333);
  box-shadow: 0 6px 20px rgba(230, 0, 0, 0.4);
  position: relative;
  overflow: hidden;
  transition: all 0.3s ease;
}

/* Efek shine */
.btn-fancy::before {
  content: "";
  position: absolute;
  top: 0;
  left: -75%;
  width: 50%;
  height: 100%;
  background: rgba(255, 255, 255, 0.4);
  transform: skewX(-25deg);
  transition: left 0.6s ease;
}
.btn-fancy:hover::before {
  left: 130%;
}

/* Hover efek */
.btn-fancy:hover {
  transform: translateY(-3px) scale(1.05);
  box-shadow: 0 8px 25px rgba(230, 0, 0, 0.6);
  background: linear-gradient(135deg, #ff3333, #e60000);
}

/* ================= TENTANG KAMI ================= */
.tentang-kami {
  padding: 80px 20px;
  background: linear-gradient(to right, var(--bg-section), var(--bg-color));
}
.video-wrapper {
  position: relative;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}
#ytplayer { width: 100%; height: 320px; }
.sound-btn {
  position: absolute;
  bottom: 15px;
  right: 15px;
  background: rgba(0,0,0,0.6);
  color: #fff;
  border: none;
  padding: 8px 12px;
  border-radius: 6px;
  cursor: pointer;
  font-size: 18px;
}
.sound-btn:hover { background: rgba(0,0,0,0.8); }
.tentang-content h2 {
  font-size: 2rem;
  margin-bottom: 15px;
  position: relative;
}
.tentang-content h2::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: -5px;
  width: 60px;
  height: 3px;
  background: #e60000;
  border-radius: 2px;
}
.tentang-content p {
  margin-bottom: 15px;
  line-height: 1.7;
  color: var(--text-color);
}
.tentang-content .highlight {
  color: #e60000;
  font-weight: 600;
}
.tentang-content .btn-primary {
  display: inline-block;
  padding: 12px 26px;
  border-radius: 50px;
  background: linear-gradient(135deg, #e60000, #ff3333);
  color: #fff;
  font-weight: 600;
  font-size: 15px;
  letter-spacing: 0.5px;
  position: relative;
  overflow: hidden;
  transition: all 0.3s ease;
  box-shadow: 0 6px 18px rgba(230, 0, 0, 0.4);
  text-decoration: none;
}

/* Efek shine */
.tentang-content .btn-primary::before {
  content: "";
  position: absolute;
  top: 0;
  left: -100%;
  width: 80%;
  height: 100%;
  background: rgba(255, 255, 255, 0.35);
  transform: skewX(-25deg);
  transition: left 0.6s ease;
}
.tentang-content .btn-primary:hover::before {
  left: 120%;
}

/* Hover efek */
.tentang-content .btn-primary:hover {
  transform: translateY(-3px) scale(1.05);
  background: linear-gradient(135deg, #ff3333, #e60000);
  box-shadow: 0 10px 25px rgba(230, 0, 0, 0.6);
}

</style>

<!-- ================= YOUTUBE API ================= -->
<script src="https://www.youtube.com/iframe_api"></script>
<script>
let player;
function onYouTubeIframeAPIReady() {
  player = new YT.Player('ytplayer', {
    videoId: 'ywDm7fHlj9Q',
    playerVars: {
      autoplay: 1, mute: 1, loop: 1, playlist: 'ywDm7fHlj9Q',
      controls: 0, modestbranding: 1, showinfo: 0
    },
    events: {
      onReady: (event) => {
        event.target.mute();
        event.target.playVideo();
      }
    }
  });
}
document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("toggleSound");
  btn.addEventListener("click", () => {
    if (player.isMuted()) {
      player.unMute(); btn.textContent = "🔊";
    } else {
      player.mute(); btn.textContent = "🔇";
    }
  });
});
</script>

<!-- ================= JS HERO SLIDER ================= -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const slides = document.querySelectorAll("#heroSlider .slide");
  const dots   = document.querySelectorAll("#heroDots button");
  let current = 0;
  function showSlide(index) {
    slides.forEach((s,i) => s.classList.toggle("active", i===index));
    dots.forEach((d,i) => d.classList.toggle("active", i===index));
    current = index;
  }
  setInterval(() => {
    if(slides.length === 0) return;
    let next = (current + 1) % slides.length;
    showSlide(next);
  }, 5000);
  dots.forEach((dot,i) => {
    dot.addEventListener("click", () => showSlide(i));
  });
});
</script>

<?php include __DIR__ . '/../inc/footer.php'; ?>
