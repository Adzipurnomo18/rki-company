<?php 
$title = 'Produk'; 
include __DIR__ . '/../inc/header.php'; 
?>

<!-- Hero Section -->
<section class="produk-hero">
  <div class="container" data-aos="fade-up" data-aos-duration="1200">
    <h1 class="produk-title">Koleksi <span>Keramik</span> Kami</h1>
    <p class="produk-subtitle">Temukan berbagai pilihan keramik dengan kualitas terbaik untuk lantai dan dinding.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <!-- Form Pencarian -->
    <form class="form produk-filter" method="get" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
      <input type="hidden" name="page" value="produk">
      
      <!-- Cari -->
      <div class="filter-item">
        <label>Cari Produk</label>
        <input class="input" name="q" placeholder="Cari nama produk..." 
               value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
      </div>

      <!-- Kategori -->
      <div class="filter-item">
        <label>Kategori</label>
        <select name="cat" class="input">
          <option value="">Semua</option>
          <?php 
          $cats = $pdo->query("SELECT id,name FROM categories ORDER BY name")->fetchAll();
          foreach ($cats as $c) { 
            $sel = ((string)$c['id'] === ($_GET['cat'] ?? '')) ? 'selected' : '';
            echo "<option value='{$c['id']}' $sel>".htmlspecialchars($c['name'])."</option>"; 
          } 
          ?>
        </select>
      </div>

      <button class="btn btn-primary">Terapkan</button>
    </form>

    <!-- Daftar Produk -->
    <div class="produk-grid">
      <?php
        // Query produk
        $sql = "SELECT p.*, c.name as cat 
                FROM products p 
                LEFT JOIN categories c ON c.id = p.category 
                WHERE 1=1";
        $p = [];

        // Filter pencarian
        if (!empty($_GET['q'])) {
          $sql .= " AND p.name LIKE ?";
          $p[] = '%' . $_GET['q'] . '%';
        }

        // Filter kategori
        if (!empty($_GET['cat'])) {
          $sql .= " AND p.category = ?";
          $p[] = $_GET['cat'];
        }

        $sql .= " ORDER BY p.id DESC";

        $st = $pdo->prepare($sql);
        $st->execute($p);
        $rows = $st->fetchAll();

        if (!$rows) {
          echo '<p class="muted" data-aos="fade-in" data-aos-delay="300">Belum ada produk.</p>';
        }

        foreach ($rows as $index => $r) { 
          $img = $r['image'] ? 'uploads/products/' . htmlspecialchars($r['image']) : 'assets/img/logo-red.png';

          echo '
          <div class="produk-card" 
               data-aos="fade-up" 
               data-aos-delay="'.($index * 120).'" 
               data-aos-duration="1000"
               onclick="showProductModal(\''.htmlspecialchars($r['name']).'\',
                                         \''.$img.'\',
                                         \''.htmlspecialchars($r['cat']).'\',
                                         \''.number_format((float)$r['price'], 0, ',', '.').'\',
                                         \''.htmlspecialchars($r['description']).'\')">
            
            <div class="produk-image">
              <img src="'.$img.'" alt="'.htmlspecialchars($r['name']).'">
            </div>
            <div class="produk-info">
              <h3>'.htmlspecialchars($r['name']).'</h3>
              <p class="produk-cat">'.htmlspecialchars($r['cat'] ?? '').'</p>';
              if ($r['price'] !== null && $r['price'] !== '') {
                echo '<div class="produk-price">Rp '.number_format((float)$r['price'], 0, ',', '.').'</div>';
              }
            echo '
            </div>
          </div>';
        }
      ?>
    </div>
  </div>
</section>

<!-- Modal Produk -->
<div id="productModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeProductModal()">&times;</span>
    <img id="modalImage" src="" alt="Produk">
    <h2 id="modalTitle"></h2>
    <p id="modalCategory"></p>
    <h3 id="modalPrice"></h3>
    <p id="modalDescription"></p>
  </div>
</div>

<!-- CSS Modal -->
<style>
  .modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background: rgba(0,0,0,0.7);
    padding-top: 50px;
  }
  .modal-content {
    background: #fff;
    margin: auto;
    padding: 20px;
    border-radius: 10px;
    width: 90%;
    max-width: 500px;
    text-align: center;
    animation: fadeIn 0.4s ease;
  }
  .modal-content img {
    width: 100%;
    border-radius: 8px;
    margin-bottom: 15px;
  }
  .modal-content h2 {
    margin: 10px 0;
  }
  .modal-content h3 {
    color: #e50914;
    margin: 10px 0;
  }
  .close {
    position: absolute;
    right: 25px;
    top: 15px;
    color: #fff;
    font-size: 30px;
    cursor: pointer;
  }
  @keyframes fadeIn {
    from {opacity: 0;}
    to {opacity: 1;}
  }
  /* Modal Produk - Dark Mode */
:root[data-theme="dark"] .modal-content {
  background: #1e1e2e; /* lebih gelap */
  color: #f5f5f5;      /* teks putih agar terbaca */
}

:root[data-theme="dark"] .modal-content h3,
:root[data-theme="dark"] .modal-content p,
:root[data-theme="dark"] .modal-content span {
  color: #f5f5f5 !important;
}

/* Harga tetap merah di dark mode */
:root[data-theme="dark"] .modal-content .produk-price {
  color: #ff4444 !important;
}
</style>

<!-- Script Modal -->
<script>
function showProductModal(name, image, category, price, description) {
  document.getElementById('productModal').style.display = 'block';
  document.getElementById('modalTitle').innerText = name;
  document.getElementById('modalImage').src = image;
  document.getElementById('modalCategory').innerText = "Kategori: " + category;
  document.getElementById('modalPrice').innerText = "Rp " + price;
  document.getElementById('modalDescription').innerText = description;
}

function closeProductModal() {
  document.getElementById('productModal').style.display = 'none';
}

// Tutup modal jika klik di luar konten
window.onclick = function(event) {
  if (event.target == document.getElementById('productModal')) {
    closeProductModal();
  }
}
</script>

<!-- AOS Animation -->
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
