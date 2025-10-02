<?php 
$title='Hubungi Kami'; 
include __DIR__.'/../inc/header.php'; 
?>

<!-- Hero Section -->
<section class="kontak-hero" data-aos="fade-down" data-aos-duration="1200">
  <div class="container hero-content">
    <h1 class="kontak-title" data-aos="fade-up" data-aos-delay="150">
       Hubungi <span style="color: #e50914;">Kami</span>
    </h1>
    <p class="kontak-subtitle" data-aos="fade-up" data-aos-delay="300">
      Kami siap membantu Anda. Silakan kirim pesan, hubungi langsung, atau kunjungi kantor kami.
    </p>
  </div>
</section>

<!-- Form & Kontak Info -->
<section class="section kontak-section">
  <div class="container kontak-container">
    
    <!-- Form Kontak -->
    <div class="kontak-form" data-aos="fade-right" data-aos-duration="1200">
      <h3 class="section-heading">Kirim Pesan</h3>
      <?php
      $notice = '';
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if ($name && $phone && $message) {
          $pdo->prepare("INSERT INTO messages(name,email,phone,message) VALUES(?,?,?,?)")
              ->execute([$name, $email, $phone, $message]);
          $notice = 'Terima kasih, pesan Anda telah tersimpan.';
        } else {
          $notice = 'Harap lengkapi data yang diperlukan.';
        }
      }

      if ($notice) {
        echo '<div class="alert" data-aos="fade-in" style="margin-bottom:12px">'.$notice.'</div>';
      }
      ?>

      <form method="post" class="form kontak-form-grid" data-aos="zoom-in" data-aos-delay="150">
        <input class="input" name="name" placeholder="Nama" required>
        <input class="input" type="email" name="email" placeholder="Email (Opsional)">
        <input class="input" name="phone" placeholder="No. WhatsApp" required>
        <textarea class="textarea" name="message" placeholder="Pesan Anda" required></textarea>
        <button class="btn btn-primary">Kirim Pesan</button>
      </form>
    </div>

    <!-- Kontak Langsung -->
    <div class="kontak-info" data-aos="fade-left" data-aos-duration="1200">
      <h3 class="section-heading">Kontak Langsung</h3>
      <div class="info-card" data-aos="fade-up" data-aos-delay="200">
        <ul>
          <li><i class="fas fa-phone"></i> <span>WhatsApp: 08xx-xxxx-xxxx</span></li>
          <li><i class="fas fa-envelope"></i> <span>Email: info@pt-rki.co.id</span></li>
          <li><i class="fas fa-map-marker-alt"></i> <span>Alamat: Mangunsari, Kedawung, Kec. Banyuputih, 
            Kabupaten Batang, Jawa Tengah</span></li>
        </ul>
      </div>

      <!-- Google Map -->
      <div class="map-container" data-aos="zoom-in" data-aos-delay="300">
        <iframe 
          class="map-embed" 
          loading="lazy" 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d28674.337504159947!2d109.89071517431637!3d-6.917863099999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e703f149d5c62c5%3A0x84995e10e0dafcdc!2sPT.%20RUMAH%20KERAMIK%20INDONESIA%20(%20RKI%20)!5e1!3m2!1sid!2sid!4v1759194476497!5m2!1sid!2sid" 
          allowfullscreen>
        </iframe>
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
  once: true,
  offset: 80
});
</script>

<?php include __DIR__.'/../inc/footer.php'; ?>
