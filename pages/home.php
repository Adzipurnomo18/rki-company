<?php 
$title = 'Home'; 
include __DIR__ . '/../inc/header.php'; 

// Ambil image gallery untuk hero
$gal = $pdo->query("SELECT image FROM gallery ORDER BY id DESC LIMIT 6")->fetchAll(PDO::FETCH_ASSOC);
$heroImages = [];
if ($gal) {
  foreach ($gal as $g) {
    $src = file_exists(__DIR__ . "/../uploads/gallery/".$g['image'])
      ? "uploads/gallery/".htmlspecialchars($g['image'])
      : "assets/img/rki.jpg";
    $heroImages[] = $src;
  }
} else {
  $heroImages = [
    "assets/img/rki.jpg",
    "assets/img/calcita.jpg",
    "assets/img/Arabescato.jpg"
  ];
}

/**
 * MODE HERO:
 *  - 'kenburns'  : satu layar full, efek zoom-pan halus (tanpa loncat-loncat slide)
 *  - 'slideshow' : fade antar gambar (versi sebelumnya, tapi dibuat lebih smooth)
 */
$HERO_MODE = 'kenburns'; // ganti ke 'slideshow' jika mau
?>
<!-- ==================== HOME (Modern BUMN) ==================== -->

<style>
/* =================================================================
   TOKENS
   ================================================================= */
:root{
  --brand:#e50914; --brand-600:#d50c16; --brand-700:#c00f18;
  --ink:#0f172a; --muted:#6b7280;
  --bg:#ffffff; --bg-alt:#f7f8fa; --card:#ffffff; --border:#e5e7eb;
  --shadow-sm:0 4px 14px rgba(2,6,23,.06); --shadow-md:0 12px 26px rgba(2,6,23,.08);
  --r-sm:12px; --r-md:16px; --r-lg:20px; --container:1200px;
}
:root[data-theme="dark"]{
  --ink:#e5e7eb; --muted:#9ca3af;
  --bg:#0b1220; --bg-alt:#0f172a; --card:#0f172a; --border:rgba(255,255,255,.08);
  --shadow-sm:0 4px 14px rgba(0,0,0,.35); --shadow-md:0 12px 26px rgba(0,0,0,.45);
}
.container-xl{max-width:var(--container); width:100%; margin:0 auto; padding:0 20px;}
.section{padding:72px 0;}
.section-alt{padding:72px 0; background:var(--bg-alt);}
.h1,.h2,.h3{font-weight:800; letter-spacing:-.02em;}
.h1{font-size:clamp(28px,3.3vw,46px);}
.h2{font-size:clamp(24px,2.5vw,34px);}
.h3{font-size:clamp(20px,2.2vw,26px);}
.muted{color:var(--muted);}

/* =================================================================
   HERO FULL – dua mode: Ken Burns & Slideshow
   ================================================================= */
.hero-full{
  position:relative; min-height:calc(100vh - 72px); /* selalu full screen di bawah navbar */
  isolation:isolate; overflow:hidden; color:#fff;
}
.hero-layer{position:absolute; inset:0; background-size:cover; background-position:center;}
.hero-overlay{
  position:absolute; inset:0;
  background: radial-gradient(1200px 600px at 25% 25%, rgba(229,9,20,.18), transparent 55%),
              linear-gradient(to bottom, rgba(2,6,23,.35), rgba(2,6,23,.65));
  z-index:2; pointer-events:none;
}
.hero-content{position:relative; z-index:3; display:grid; align-content:center; min-height:inherit;}
.hero-inner{max-width:var(--container); width:100%; padding:0 20px; margin:0 auto;}

.kicker{font-weight:800; letter-spacing:.12em; text-transform:uppercase; opacity:.95; margin-bottom:12px;}
.hero-actions{display:flex; flex-wrap:wrap; gap:12px; margin-top:20px;}
.btn-pill{display:inline-flex; align-items:center; gap:10px; padding:12px 20px; border-radius:999px; font-weight:800; text-decoration:none; border:2px solid transparent; transition:.28s cubic-bezier(.22,.61,.36,1);}
.btn-brand{background:var(--brand); color:#fff; box-shadow:0 10px 28px rgba(229,9,20,.35);}
.btn-brand:hover{background:var(--brand-600); transform:translateY(-2px);}
.btn-outline{background:transparent; border-color:#fff; color:#fff;}
.btn-outline:hover{background:#fff; color:#111;}

/* Ken Burns frames: 3 layer (loop) untuk zoom-pan halus */
.hero-kenburns .kb{opacity:0; animation:fadeIn 9s linear infinite; will-change:transform, opacity;}
.hero-kenburns .kb.kb-1{animation-name:ken1;}
.hero-kenburns .kb.kb-2{animation-name:ken2; animation-delay:3s;}
.hero-kenburns .kb.kb-3{animation-name:ken3; animation-delay:6s;}
@keyframes fadeIn{from{opacity:0}10%{opacity:1}70%{opacity:1}to{opacity:0}}
@keyframes ken1{
  0%{transform:scale(1.08) translate3d(-1.5%, -1%, 0); opacity:0}
  10%{opacity:1}
  50%{transform:scale(1.12) translate3d(0%, 0%, 0)}
  90%{opacity:1}
  100%{transform:scale(1.14) translate3d(1.5%, 1%, 0); opacity:0}
}
@keyframes ken2{
  0%{transform:scale(1.10) translate3d(1%, -1.2%, 0); opacity:0}
  10%{opacity:1}
  50%{transform:scale(1.14) translate3d(0%, 0%, 0)}
  90%{opacity:1}
  100%{transform:scale(1.18) translate3d(-1%, 1.2%, 0); opacity:0}
}
@keyframes ken3{
  0%{transform:scale(1.06) translate3d(0.8%, 1%, 0); opacity:0}
  10%{opacity:1}
  50%{transform:scale(1.10) translate3d(0%, 0%, 0)}
  90%{opacity:1}
  100%{transform:scale(1.13) translate3d(-0.8%, -1%, 0); opacity:0}
}

/* Slideshow modern (fade + easing halus) */
.hero-slideshow .slide{
  position:absolute; inset:0; background-size:cover; background-position:center;
  opacity:0; transition:opacity 900ms cubic-bezier(.22,.61,.36,1);
}
.hero-slideshow .slide.is-active{opacity:1;}
.hero-dots{position:absolute; left:50%; bottom:18px; transform:translateX(-50%); z-index:5; display:flex; gap:8px;}
.hero-dots button{width:10px; height:10px; border-radius:999px; background:rgba(255,255,255,.55); border:none; cursor:pointer; transition:.2s;}
.hero-dots button.is-active{background:#fff}

/* =================================================================
   GRID + FEATURE
   ================================================================= */
.grid-3{display:grid; gap:20px; grid-template-columns:repeat(3,1fr);}
@media(max-width:980px){.grid-3{grid-template-columns:repeat(2,1fr)}}
@media(max-width:640px){.grid-3{grid-template-columns:1fr}}

.card-feature{
  background:var(--card); border:1px solid var(--border); border-radius:var(--r-sm);
  padding:22px; display:flex; gap:14px; align-items:flex-start; box-shadow:var(--shadow-sm);
  transition:transform .25s cubic-bezier(.22,.61,.36,1), box-shadow .25s;
}
.card-feature:hover{transform:translateY(-3px); box-shadow:var(--shadow-md);}
.feature-icon{
  width:44px; height:44px; border-radius:10px; display:grid; place-items:center; color:#fff; font-size:20px;
  background:linear-gradient(135deg, var(--brand), var(--brand-700));
}

/* =================================================================
   PRODUCT CARDS (lebih modern)
   ================================================================= */
.card-product{
  background:var(--card); border:1px solid var(--border); border-radius:14px; overflow:hidden; box-shadow:var(--shadow-sm);
  transition:transform .25s cubic-bezier(.22,.61,.36,1), box-shadow .25s;
}
.card-product:hover{transform:translateY(-4px); box-shadow:var(--shadow-md);}
.card-product .media{aspect-ratio:16/9; overflow:hidden;}
.card-product img{width:100%; height:100%; object-fit:cover; display:block; transform:scale(1.02); transition:transform .35s cubic-bezier(.22,.61,.36,1);}
.card-product:hover img{transform:scale(1.06);}
.card-product .body{padding:14px 16px;}
.card-product h4{margin:0 0 6px; font-weight:800; font-size:16px;}
.card-product p{margin:0; color:var(--muted); font-size:14px;}

.section-title{display:flex; align-items:center; justify-content:space-between; margin-bottom:18px;}
.section-title .h2{margin:0;}

/* =================================================================
   ABOUT – versi profesional (tipografi rapi + checklist)
   ================================================================= */
.about-wrap{display:grid; grid-template-columns:1fr 1fr; gap:28px; align-items:center;}
@media(max-width:980px){.about-wrap{grid-template-columns:1fr}}
.card-video{background:var(--card); border:1px solid var(--border); border-radius:16px; box-shadow:var(--shadow-md); overflow:hidden;}
.card-video iframe{width:100%; aspect-ratio:16/9; display:block;}
.lead{font-size:clamp(16px,1.4vw,18px); line-height:1.7; margin:10px 0 14px;}
.divider{width:68px; height:4px; background:var(--brand); border-radius:3px; margin:10px 0 18px;}
.checklist{display:grid; grid-template-columns:1fr 1fr; gap:8px 18px; margin:10px 0 20px;}
@media(max-width:640px){.checklist{grid-template-columns:1fr}}
.checklist li{list-style:none; display:flex; gap:10px; align-items:flex-start; color:var(--ink);}
.checklist i{color:var(--brand); margin-top:4px;}
.btn-glow{
  display:inline-flex; align-items:center; gap:10px; padding:12px 20px; border-radius:999px; color:#fff; font-weight:800;
  background:linear-gradient(135deg, var(--brand), var(--brand-700)); text-decoration:none;
  box-shadow:0 12px 28px rgba(229,9,20,.35); position:relative; overflow:hidden; transition:.28s cubic-bezier(.22,.61,.36,1);
}
.btn-glow::after{
  content:""; position:absolute; inset:0; background:linear-gradient(90deg,rgba(255,255,255,.10),transparent 45%,transparent 55%,rgba(255,255,255,.10));
  transform:translateX(-100%); transition:transform .7s ease;
}
.btn-glow:hover{transform:translateY(-2px)}
.btn-glow:hover::after{transform:translateX(100%)}

/* =================================================================
   STATS & PARTNERS
   ================================================================= */
.stats{display:grid; grid-template-columns:repeat(4,1fr); gap:18px; margin-top:12px;}
@media (max-width:980px){ .stats{grid-template-columns:repeat(2,1fr);} }
.stat{
  background:var(--card); border:1px solid var(--border); border-radius:var(--r-sm); padding:18px;
  box-shadow:var(--shadow-sm); text-align:center;
}
.stat strong{ font-size:clamp(22px,3vw,32px); display:block; font-weight:900; color:var(--brand); }
.stat span{ color:var(--muted); font-weight:600; }

.partners{ display:grid; grid-template-columns:repeat(6,1fr); gap:18px; align-items:center; }
@media (max-width:980px){ .partners{ grid-template-columns:repeat(3,1fr);} }
.partner-card{
  background:var(--card); border:1px solid var(--border); border-radius:12px; padding:16px; display:grid; place-items:center;
  filter:grayscale(1); opacity:.8; transition:.2s; box-shadow:var(--shadow-sm);
}
.partner-card:hover{ filter:grayscale(0); opacity:1; transform:translateY(-3px); box-shadow:var(--shadow-md); }
.partner-card img{ height:40px; max-width:100%; }

/* =================================================================
   SCROLL REVEAL (smooth)
   ================================================================= */
.reveal{opacity:0; transform:translateY(18px); transition:opacity .6s ease, transform .6s ease;}
.reveal.is-in{opacity:1; transform:none;}
</style>

<!-- ==================== HERO ==================== -->
<section class="hero-full <?php echo $HERO_MODE==='kenburns'?'hero-kenburns':'hero-slideshow'; ?>" id="Hero">
  <?php if ($HERO_MODE === 'kenburns'): ?>
    <?php 
      // gunakan 3 layer untuk loop halus
      $kb = array_slice(array_pad($heroImages, 3, end($heroImages)), 0, 3);
    ?>
    <div class="hero-layer kb kb-1" style="background-image:url('<?php echo $kb[0]; ?>')"></div>
    <div class="hero-layer kb kb-2" style="background-image:url('<?php echo $kb[1]; ?>')"></div>
    <div class="hero-layer kb kb-3" style="background-image:url('<?php echo $kb[2]; ?>')"></div>
  <?php else: ?>
    <?php foreach ($heroImages as $i => $img): ?>
      <div class="hero-layer slide <?php echo $i===0?'is-active':''; ?>" style="background-image:url('<?php echo $img; ?>')"></div>
    <?php endforeach; ?>
    <div class="hero-dots" id="HeroDots">
      <?php foreach ($heroImages as $i => $img): ?>
        <button class="<?php echo $i===0?'is-active':''; ?>" aria-label="slide <?php echo $i+1 ?>"></button>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div class="hero-overlay"></div>

  <div class="hero-content">
    <div class="hero-inner">
      <div class="kicker">PT Rumah Keramik Indonesia</div>
      <h1 class="h1">Produsen Ubin Keramik <span style="color:#ffb4b7">Lantai</span> & <span style="color:#ffb4b7">Dinding</span></h1>
      <p class="muted" style="max-width:720px; color:#e5e7eb">Menghadirkan kualitas, ketahanan, dan estetika terbaik untuk setiap ruang.</p>
      <div class="hero-actions">
        <a href="index.php?page=produk" class="btn-pill btn-brand">📦 Lihat Produk</a>
        <a href="index.php?page=tentang" class="btn-pill btn-outline">ℹ️ Tentang Kami</a>
      </div>
    </div>
  </div>
</section>

<!-- ==================== FITUR ==================== -->
<section class="section-alt reveal">
  <div class="container-xl">
    <div class="section-title"><h2 class="h2">Mengapa Memilih Kami?</h2></div>
    <div class="grid-3">
      <div class="card-feature">
        <div class="feature-icon"><i class="fas fa-fire"></i></div>
        <div>
          <h3 class="h3" style="font-size:18px">Teknologi Glaze</h3>
          <p class="muted">Permukaan halus & tahan gores dengan teknologi mutakhir.</p>
        </div>
      </div>
      <div class="card-feature">
        <div class="feature-icon"><i class="fas fa-award"></i></div>
        <div>
          <h3 class="h3" style="font-size:18px">Standar Mutu Tinggi</h3>
          <p class="muted">QC ketat dari bahan baku hingga tahap akhir produksi.</p>
        </div>
      </div>
      <div class="card-feature">
        <div class="feature-icon"><i class="fas fa-th-large"></i></div>
        <div>
          <h3 class="h3" style="font-size:18px">Varian Motif Modern</h3>
          <p class="muted">Marmer, batu alam, kayu, dan motif modern sesuai tren.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ==================== PRODUK ==================== -->
<section class="section reveal">
  <div class="container-xl">
    <div class="section-title">
      <h2 class="h2">Produk Unggulan</h2>
      <a href="index.php?page=produk" class="btn-pill btn-brand" style="padding:10px 16px;">Lihat Semua</a>
    </div>
    <div class="grid-3">
      <article class="card-product">
        <div class="media"><img src="assets/img/alabstro.jpg" alt="Keramik Premium"></div>
        <div class="body">
          <h4>Keramik Premium</h4>
          <p>Kualitas terbaik untuk lantai rumah & bangunan.</p>
        </div>
      </article>
      <article class="card-product">
        <div class="media"><img src="assets/img/Arabescato.jpg" alt="Motif Marmer"></div>
        <div class="body">
          <h4>Motif Marmer</h4>
          <p>Elegan dengan nuansa alam yang mewah.</p>
        </div>
      </article>
      <article class="card-product">
        <div class="media"><img src="assets/img/Calcita.jpg" alt="Keramik Dinding"></div>
        <div class="body">
          <h4>Keramik Dinding</h4>
          <p>Hadir dalam berbagai motif modern.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ==================== TENTANG (rapi & profesional) ==================== -->
<section class="section-alt reveal">
  <div class="container-xl about-wrap">
    <div>
      <h2 class="h2" style="margin-bottom:4px">Tentang Kami</h2>
      <div class="divider"></div>
      <p class="lead">
        <strong>PT Rumah Keramik Indonesia</strong> berkomitmen menghadirkan 
        <span style="color:var(--brand);font-weight:700;"> produk ubin berkualitas tinggi</span> 
        melalui teknologi modern dan pengendalian mutu berlapis.
      </p>
      <ul class="checklist">
        <li><i class="fas fa-check-circle"></i><span>Sertifikasi mutu & proses produksi terdokumentasi</span></li>
        <li><i class="fas fa-check-circle"></i><span>Desain marmer, batu alam, dan kayu yang realistis</span></li>
        <li><i class="fas fa-check-circle"></i><span>Ketahanan gores & beban sesuai standar</span></li>
        <li><i class="fas fa-check-circle"></i><span>Jaringan distribusi & layanan purna jual</span></li>
      </ul>
      <a href="index.php?page=tentang" class="btn-glow">Pelajari Lebih Lanjut</a>
    </div>
    <div class="card-video">
      <iframe src="https://www.youtube.com/embed/ywDm7fHlj9Q?autoplay=0&mute=1&controls=1&modestbranding=1"
              title="Profil Pabrik" frameborder="0" allowfullscreen
              referrerpolicy="strict-origin-when-cross-origin"></iframe>
    </div>
  </div>
</section>

<!-- ==================== CAPAIAN & MITRA (dengan counter) ==================== -->
<section class="section" id="Capaian">
  <div class="container-xl">
    <div class="section-title">
      <h2 class="h2">Capaian & Kepercayaan</h2>
    </div>

    <!-- Ubah angka di data-target; pakai data-format="short" untuk K/M/B; data-suffix="+" jika perlu plus -->
    <div class="stats">
      <div class="stat" data-target="15" data-suffix="+">
        <strong class="count">0</strong>
        <span>Tahun Pengalaman</span>
      </div>
      <div class="stat" data-target="250" data-suffix="+">
        <strong class="count">0</strong>
        <span>Proyek Terselesaikan</span>
      </div>
      <div class="stat" data-target="1200000" data-format="short" data-suffix="+">
        <strong class="count">0</strong>
        <span>m² Keramik Terpasang</span>
      </div>
      <div class="stat" data-target="50" data-suffix="+">
        <strong class="count">0</strong>
        <span>Distribusi Kota</span>
      </div>
    </div>

    <div style="height:24px"></div>

    <div class="partners">
      <div class="partner-card"><img src="assets/img/mitra1.png" alt="Mitra 1"></div>
      <div class="partner-card"><img src="assets/img/mitra2.png" alt="Mitra 2"></div>
      <div class="partner-card"><img src="assets/img/mitra3.png" alt="Mitra 3"></div>
      <div class="partner-card"><img src="assets/img/mitra4.png" alt="Mitra 4"></div>
      <div class="partner-card"><img src="assets/img/mitra5.png" alt="Mitra 5"></div>
      <div class="partner-card"><img src="assets/img/mitra6.png" alt="Mitra 6"></div>
    </div>
  </div>
</section>

<!-- ==================== JS: slideshow + scroll reveal + counters ==================== -->
<script>
(function(){
  // Slideshow fade (hanya berjalan kalau mode slideshow)
  const hero = document.getElementById('Hero');
  if(hero && hero.classList.contains('hero-slideshow')){
    const slides = [...hero.querySelectorAll('.slide')];
    const dots   = hero.querySelectorAll('#HeroDots button');
    let i = 0, T;
    const show = n => {
      slides.forEach((s,idx)=> s.classList.toggle('is-active', idx===n));
      dots.forEach((d,idx)=> d.classList.toggle('is-active', idx===n));
      i = n;
    };
    const next = () => show((i+1) % slides.length);
    T = setInterval(next, 6000);
    dots.forEach((btn,idx)=>{
      btn.addEventListener('click', ()=>{ clearInterval(T); show(idx); T = setInterval(next, 6000); });
    });
  }

  // Scroll reveal halus (tanpa library)
  const io = new IntersectionObserver((entries)=>{
    entries.forEach(e=>{
      if(e.isIntersecting){ e.target.classList.add('is-in'); io.unobserve(e.target); }
    });
  }, {threshold:.12});
  document.querySelectorAll('.reveal').forEach(el=> io.observe(el));

  // ================= Counter on Scroll =================
  // util easing + formatter
  const easeOutCubic = t => 1 - Math.pow(1 - t, 3);
  function formatShort(n){
    const abs = Math.abs(n);
    const fmt = (v)=> (Math.round(v * 10) / 10).toString().replace('.0','');
    if (abs >= 1e9) return fmt(n/1e9) + 'B';
    if (abs >= 1e6) return fmt(n/1e6) + 'M';
    if (abs >= 1e3) return fmt(n/1e3) + 'K';
    return Math.round(n).toLocaleString('id-ID');
  }
  function animateCount(el, target, {duration=2200, format='plain', suffix='' } = {}){
    const start = 0;
    const startTs = performance.now();
    const step = (now)=>{
      const p = Math.min(1, (now - startTs) / duration);
      const eased = easeOutCubic(p);
      const value = start + (target - start) * eased;
      el.textContent = (format === 'short' ? formatShort(value) : Math.round(value).toLocaleString('id-ID')) + (p===1 ? suffix : '');
      if (p < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  }

  let countersTriggered = false;
  const capaian = document.getElementById('Capaian');
  if (capaian){
    const ioCount = new IntersectionObserver((entries)=>{
      entries.forEach(entry=>{
        if(entry.isIntersecting && !countersTriggered){
          countersTriggered = true;
          capaian.querySelectorAll('.stat').forEach(card=>{
            const to = Number(card.dataset.target || 0);
            const format = (card.dataset.format || 'plain').toLowerCase();
            const suffix = card.dataset.suffix || '';
            const strong = card.querySelector('.count');
            animateCount(strong, to, {duration:1600, format, suffix});
          });
          ioCount.unobserve(capaian);
        }
      });
    }, {threshold:.25});
    ioCount.observe(capaian);
  }
})();
</script>

<?php include __DIR__ . '/../inc/footer.php'; ?>
