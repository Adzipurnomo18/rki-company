<?php 
$title = 'Tentang Kami'; 
include __DIR__ . '/../inc/header.php'; 
?>

<!-- Hero Section -->
<section class="hero-about">
  <div class="container hero-content" data-aos="fade-down" data-aos-duration="1200">
    <h1 data-aos="fade-up" data-aos-delay="100">
      Tentang <span class="highlight">PT Rumah Keramik Indonesia</span>
    </h1>
    <p data-aos="fade-up" data-aos-delay="300">
      Berdiri untuk membantu pemerintah, dalam membatasi impor dan mendukung produk lokal Indonesia, 
      serta bersinergi dengan masyarakat sekitar.
      Kami bangga sebagai warga Negara Indonesia dengan keanekaragamannya, keunikan dan kreatifitasnya yang menginspirasi dunia.
    </p>
  </div>
</section>

<!-- Visi & Misi -->
<section class="section about-vision-mission">
  <div class="container grid grid-2">
    <div class="card vision-mission" data-aos="fade-right" data-aos-duration="1200">
      <h2>Visi</h2>
      <p>
        Ikut memajukan industri dan perekonomian di Indonesia serta menjadi produk lokal yang unggul dan membanggakan Indonesia dimata dunia.
      </p>
    </div>

    <div class="card vision-mission" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="200">
      <h2>Misi</h2>
      <ul>
        <li>Menjadi mitra terpercaya dalam menghadirkan ruang indah & tahan lama.</li>
        <li>Menghadirkan produk dengan desain modern dan teknologi terkini.</li>
        <li>Memberikan layanan purna jual yang profesional dan responsif.</li>
      </ul>
    </div>
  </div>
</section>

<!-- Keunggulan Section -->
<section class="section">
  <div class="container">
    <h2 class="center-text" data-aos="fade-up" data-aos-duration="1200">Keunggulan Kami</h2>
    <div class="grid grid-3 features">
      
      <div class="feature-card" data-aos="zoom-in-up" data-aos-delay="100" data-aos-duration="1000">
        <div class="icon-circle">
          <i class="fas fa-fire"></i>
        </div>
        <h3>Pembakaran Suhu Tinggi</h3>
        <p>Memberikan daya tahan ekstra dan kualitas permukaan terbaik.</p>
      </div>

      <div class="feature-card" data-aos="zoom-in-up" data-aos-delay="250" data-aos-duration="1000">
        <div class="icon-circle">
          <i class="fas fa-paint-brush"></i>
        </div>
        <h3>Motif Realistis</h3>
        <p>Motif marmer, kayu, dan batu alam dengan digital printing modern.</p>
      </div>

      <div class="feature-card" data-aos="zoom-in-up" data-aos-delay="400" data-aos-duration="1000">
        <div class="icon-circle">
          <i class="fas fa-truck"></i>
        </div>
        <h3>Distribusi & Layanan</h3>
        <p>Jaringan distribusi luas dan layanan purna jual yang responsif.</p>
      </div>

    </div>
  </div>
</section>

<!-- AOS Animation Library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
  AOS.init({
    duration: 1200,
    easing: 'ease-in-out',
    offset: 80,
    once: true
  });
</script>

<?php include __DIR__ . '/../inc/footer.php'; ?>
