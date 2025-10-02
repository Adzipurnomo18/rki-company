<?php 
$title = 'Pabrik Kami'; 
include __DIR__ . '/../inc/header.php'; 
?>

<!-- Hero Section -->
<section class="pabrik-hero" data-aos="fade-down" data-aos-duration="1200">
  <div class="container hero-content">
    <h1 class="pabrik-title" data-aos="fade-up" data-aos-delay="100">
      Pabrik & <span style="color: #e50914;">Proses Produksi</span>
    </h1>
    <p class="pabrik-subtitle" data-aos="fade-up" data-aos-delay="250">
      Foto-foto pabrik akan ditampilkan dari galeri yang dikelola melalui admin.
    </p>
  </div>
</section>

<!-- Galeri Foto -->
<section class="section pabrik-section">
  <div class="container">
    <div class="pabrik-grid">
      <?php
      // Ambil data galeri dari database
      $gal = $pdo->query("SELECT image, title FROM gallery ORDER BY id DESC")->fetchAll();

      if (!$gal) {
        echo '<p class="muted" data-aos="fade-up">Belum ada foto.</p>';
      } else {
        foreach ($gal as $index => $g) {
          $img = 'uploads/gallery/' . htmlspecialchars($g['image']);
          $title = htmlspecialchars($g['title'] ?? 'Galeri');

          echo '
          <div class="pabrik-card" 
               data-aos="zoom-in-up" 
               data-aos-delay="'.($index * 120).'" 
               data-aos-duration="1000"
               onclick="openModal(\''.$img.'\', \''.$title.'\')">
            <div class="pabrik-image">
              <img src="'.$img.'" alt="'.$title.'">
              <div class="overlay">
                <h3>'.$title.'</h3>
              </div>
            </div>
          </div>';
        }
      }
      ?>
    </div>
  </div>
</section>

<!-- Modal Popup -->
<div id="imageModal" class="modal">
  <span class="close" onclick="closeModal()">&times;</span>
  <img class="modal-content" id="modalImage">
  <div id="modalCaption"></div>
</div>

<!-- CSS Modal -->
<style>
  /* Grid galeri */
  .pabrik-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
  }

  .pabrik-card {
    cursor: pointer;
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    transition: transform 0.3s ease;
  }

  .pabrik-card:hover {
    transform: scale(1.03);
  }

  .pabrik-image img {
    width: 100%;
    height: 170px;
    object-fit: cover;
    border-radius: 10px;
    display: block;
  }

  .overlay {
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 10px;
    background: rgba(229, 9, 20, 0.8);
    text-align: center;
    color: #fff;
    font-weight: bold;
    display: none;
  }

  .pabrik-card:hover .overlay {
    display: block;
  }

  /* Modal background */
  .modal {
    display: none;
    position: fixed;
    z-index: 9999;
    padding-top: 60px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.9);
  }

  /* Modal image */
  .modal-content {
    margin: auto;
    display: block;
    max-width: 90%;
    max-height: 80vh;
    border-radius: 10px;
    animation: zoom 0.3s ease;
  }

  @keyframes zoom {
    from {transform: scale(0.7);}
    to {transform: scale(1);}
  }

  /* Caption */
  #modalCaption {
    margin: 15px auto;
    text-align: center;
    color: #f1f1f1;
    font-size: 18px;
    max-width: 80%;
  }

  /* Close button */
  .close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #fff;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
  }

  .close:hover {
    color: #e50914;
  }
</style>

<!-- JS Modal -->
<script>
  // Fungsi membuka modal
  function openModal(imageSrc, title) {
    document.getElementById("imageModal").style.display = "block";
    document.getElementById("modalImage").src = imageSrc;
    document.getElementById("modalCaption").innerText = title;
  }

  // Fungsi menutup modal
  function closeModal() {
    document.getElementById("imageModal").style.display = "none";
  }

  // Menutup modal jika klik di luar gambar
  window.onclick = function(event) {
    const modal = document.getElementById("imageModal");
    if (event.target === modal) {
      closeModal();
    }
  }
</script>

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

<?php include __DIR__ . '/../inc/footer.php'; ?>
