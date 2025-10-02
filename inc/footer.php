<?php // --- footer.php --- ?>
</main>

<footer class="footer">
  <div class="container footer-container">
    <div class="cols">
      
      <!-- Kolom Logo dan Deskripsi -->
      <div>
        <div class="brand" style="gap:8px;margin-bottom:8px; display:flex; align-items:center;">
          <img id="logo-footer" src="assets/img/logo-red.png" style="height:36px" alt="PT RKI"/>
          <strong>PT Rumah Keramik Indonesia</strong>
        </div>
        <p class="footer-text">Produsen ubin keramik lantai & dinding berkualitas.</p>
      </div>

      <!-- Kolom Menu -->
      <div>
        <h4 class="footer-title">Menu</h4>
        <ul class="footer-links">
          <li><a href="index.php?page=home">Home</a></li>
          <li><a href="index.php?page=produk">Produk</a></li>
          <li><a href="index.php?page=tentang">Tentang Kami</a></li>
          <li><a href="index.php?page=pabrik">Pabrik Kami</a></li>
          <li><a href="index.php?page=karir">Karir</a></li>
          <li><a href="index.php?page=kontak">Hubungi Kami</a></li>
          <li><a class="btn-login" href="admin/login.php" target="_blank">Login Admin</a></li>
        </ul>
      </div>

      <!-- Kolom Kontak -->
      <div>
        <h4 class="footer-title">Kontak</h4>
        <ul class="footer-links">
          <li>WA: 08xx-xxxx-xxxx</li>
          <li>Email: info@pt-rki.co.id</li>
          <li>Alamat: Mangunsari, Kedawung, Kec. Banyuputih, 
            Kabupaten Batang, Jawa Tengah</li>
        </ul>
      </div>
    </div>

    <!-- Garis pemisah -->
    <hr class="footer-line">

    <!-- Bagian Copyright dan Sosmed -->
    <div class="footer-bottom">
      <div class="copy">
        © <span id="y"></span> PT Rumah Keramik Indonesia
      </div>

      <!-- Sosmed Icon -->
      <div class="social-icons">
        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.instagram.com/rumahkeramikindonesia/" aria-label="Instagram" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>
  </div>
</footer>

<!-- AOS Animation Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="assets/js/script.js?v=1.0"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="assets/js/main.js?v=1.2"></script>

<script>
  // Tahun otomatis
  document.getElementById('y').textContent = new Date().getFullYear();

  // Inisialisasi animasi AOS
  AOS.init({
    duration: 1000,
    once: true
  });
</script>

<style>
/* ====== FOOTER ====== */
.footer {
  background: #ffffff;
  color: #111827;
  padding: 40px 20px 20px;
  margin-top: 40px;
  transition: all 0.3s ease;
}
.footer-container { max-width: 1200px; margin: 0 auto; }
.cols { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 30px; }
.footer-title { margin-bottom: 10px; font-weight: 600; }
.footer-links { list-style: none; display: grid; gap: 8px; padding: 0; }
.footer-links a { color: inherit; text-decoration: none; transition: color 0.3s; }
.footer-links a:hover { color: #e50914; }
.footer-line { border: none; border-top: 1px solid rgba(0,0,0,0.1); margin: 20px 0; }
.footer-bottom { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
.copy { font-size: 0.9rem; color: #6b7280; }
.social-icons a { color: inherit; font-size: 1.2rem; margin-left: 15px; transition: color 0.3s, transform 0.2s; }
.social-icons a:hover { color: #e50914; transform: translateY(-3px); }

/* ====== DARK MODE ====== */
[data-theme="dark"] .footer { background: #0f172a; color: #e5e7eb; }
[data-theme="dark"] .footer-links a:hover { color: #ff4d4f; }
[data-theme="dark"] .footer-line { border-top: 1px solid rgba(255,255,255,0.2); }
[data-theme="dark"] .copy { color: #9ca3af; }

/* ====== RESPONSIVE ====== */
@media (max-width: 768px) {
  .cols { flex-direction: column; gap: 20px; }
  .footer-bottom { flex-direction: column; text-align: center; }
  .social-icons a { margin-left: 10px; }
}
</style>
