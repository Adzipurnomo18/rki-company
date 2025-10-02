<?php 
$title='Karir'; 
include __DIR__.'/../inc/header.php'; 
?>

<!-- Hero Section -->
<section class="karir-hero" data-aos="fade-down" data-aos-duration="1200">
  <div class="container hero-content">
    <h1 class="karir-title" data-aos="fade-up" data-aos-delay="100">
      Karir di <span style="color: #e50914;">PT Rumah Keramik Indonesia</span>
    </h1>
    <p class="karir-subtitle" data-aos="fade-up" data-aos-delay="250">
      Bergabunglah bersama kami dan tumbuh dalam lingkungan kerja yang inovatif dan profesional.
    </p>
  </div>
</section>

<!-- Custom CSS -->
<style>
/* ===== Alert Notifikasi ===== */
.alert {
  background-color: #ffecec;
  color: #e50914;
  border: 1px solid #e50914;
  padding: 12px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  margin-bottom: 15px;
  text-align: center;
  transition: background-color 0.3s ease, color 0.3s ease;
  animation: fadeIn 0.4s ease-in-out;
}

/* Dark Mode untuk Alert */
[data-theme="dark"] .alert {
  background-color: #1e293b;
  color: #ff4c4c;
  border: 1px solid #ff4c4c;
}

/* Animasi muncul */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}

/* ===== Layout Karir ===== */
.karir-container {
  display: grid;
  grid-template-columns: 1fr 1fr; /* dua kolom di desktop */
  gap: 30px;
}

.karir-lowongan,
.karir-form {
  background: var(--card-bg, #f9f9f9);
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

/* Heading */
.section-heading {
  font-size: 20px;
  font-weight: 700;
  margin-bottom: 15px;
  border-left: 4px solid #e50914;
  padding-left: 8px;
  color: var(--text, #111);
}

/* Input Form */
.karir-form-input .input,
.karir-form-input input[type="file"] {
  width: 100%;
  margin-bottom: 12px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 15px;
  background: #fff;
  color: #111;
}

/* Dark mode input */
[data-theme="dark"] .karir-form-input .input,
[data-theme="dark"] .karir-form-input input[type="file"] {
  background: #0f172a;
  color: #f1f5f9;
  border: 1px solid #334155;
}

/* Tombol */
.karir-form-input .btn-primary {
  width: 100%;
  padding: 12px;
  border-radius: 8px;
  font-weight: 600;
  background: #e50914;
  color: #fff;
  border: none;
  transition: all 0.3s ease;
}
.karir-form-input .btn-primary:hover {
  background: #b20710;
}

/* RESPONSIVE - Mobile */
@media (max-width: 768px) {
  .karir-container {
    grid-template-columns: 1fr; /* jadi satu kolom */
  }
  .karir-lowongan,
  .karir-form {
    margin: 0 auto;
    width: 100%;
  }
}
</style>

<!-- Lowongan dan Form Lamaran -->
<section class="section karir-section">
  <div class="container karir-container">
    
    <!-- Daftar Lowongan -->
    <div class="karir-lowongan" data-aos="fade-right" data-aos-duration="1200">
      <h3 class="section-heading">Lowongan Tersedia</h3>
      <div class="card lowongan-card">
        <?php
          $jobs = $pdo->query("SELECT * FROM jobs ORDER BY id DESC")->fetchAll();
          if (!$jobs) {
            echo '<p class="muted" data-aos="fade-up">Belum ada lowongan yang tersedia.</p>';
          } else {
            foreach ($jobs as $index => $j) {
              $title = htmlspecialchars($j['title'], ENT_QUOTES, 'UTF-8');
              $full  = (string)$j['description'];
              if (function_exists('mb_strimwidth')) {
                $short = mb_strimwidth($full, 0, 180, '…', 'UTF-8');
              } else {
                $short = strlen($full) > 180 ? substr($full, 0, 180).'…' : $full;
              }
              $full_json  = htmlspecialchars(json_encode($full),  ENT_QUOTES, 'UTF-8');
              $short_safe = htmlspecialchars($short, ENT_QUOTES, 'UTF-8');
              $id = (int)$j['id'];

              echo '
              <div class="lowongan-item" data-aos="fade-up" data-aos-delay="'.($index * 120).'" data-aos-duration="1000">
                <div class="lowongan-icon"><i class="fas fa-briefcase"></i></div>
                <div class="lowongan-info">
                  <h4>'.$title.'</h4>
                  <p class="muted desc-text"
                     id="desc-'.$id.'"
                     data-full="'.$full_json.'"
                     data-short="'.$short_safe.'">'.$short_safe.'</p>
                  <button type="button" class="toggle-btn job-toggle" data-target="desc-'.$id.'">
                    <span class="btn-text">Lihat Selengkapnya</span>
                    <i class="fas fa-chevron-down arrow"></i>
                  </button>
                </div>
              </div>';
            }
          }
        ?>
      </div>
    </div>

    <!-- Form Lamaran -->
    <div class="karir-form" data-aos="fade-left" data-aos-duration="1200">
      <h3 class="section-heading">Kirim Lamaran</h3>
      <?php 
        $msg='';
        if($_SERVER['REQUEST_METHOD']==='POST'){
          $name = trim($_POST['name'] ?? '');
          $email = trim($_POST['email'] ?? '');
          $pos = trim($_POST['position'] ?? '');
          
          if($name && $email && $pos && !empty($_FILES['cv']['name'])){
            $fn = time().'_'.preg_replace('/[^a-zA-Z0-9\.\-_]/','',$_FILES['cv']['name']);
            $dest = __DIR__.'/../uploads/cv/'.$fn;
            if(move_uploaded_file($_FILES['cv']['tmp_name'],$dest)){
              $pdo->prepare("INSERT INTO applications(name,email,position,cv_file) VALUES(?,?,?,?)")
                  ->execute([$name,$email,$pos,$fn]);
              $msg = 'Lamaran berhasil dikirim.';
            } else {
              $msg = 'Gagal mengunggah file. Coba lagi.';
            }
          } else {
            $msg = 'Lengkapi semua data dan unggah file CV dalam format PDF.';
          }
        }
        if($msg) echo '<div class="alert" data-aos="fade-in">'.$msg.'</div>'; 
      ?>

      <form method="post" enctype="multipart/form-data" class="form karir-form-input" data-aos="fade-up" data-aos-delay="150">
        <input class="input" name="name" placeholder="Nama Lengkap" required>
        <input class="input" type="email" name="email" placeholder="Email" required>
        <input class="input" name="position" placeholder="Posisi yang Dilamar" required>
        <input type="file" name="cv" accept=".pdf" required>
        <button class="btn btn-primary">Kirim Lamaran</button>
      </form>
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

<!-- Toggle "Lihat Selengkapnya" -->
<script>
document.addEventListener('click', function (e) {
  const btn = e.target.closest('.job-toggle');
  if (!btn) return;
  const targetId = btn.getAttribute('data-target');
  const p = document.getElementById(targetId);
  if (!p) return;
  const isOpen = btn.dataset.state === 'open';
  if (!isOpen) {
    const full = p.dataset.full ? JSON.parse(p.dataset.full) : '';
    p.innerHTML = nl2brSafe(full);
    btn.querySelector('.btn-text').textContent = 'Tutup';
    btn.classList.add('active');
    btn.dataset.state = 'open';
  } else {
    const shortText = p.dataset.short || '';
    p.textContent = shortText;
    btn.querySelector('.btn-text').textContent = 'Lihat Selengkapnya';
    btn.classList.remove('active');
    btn.dataset.state = '';
  }
});
function nl2brSafe(text) {
  return text.replace(/\n/g, "<br>");
}
</script>

<?php include __DIR__.'/../inc/footer.php'; ?>
