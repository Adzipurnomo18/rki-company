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
 *  - 'kenburns'  : satu layar full, efek zoom-pan halus
 *  - 'slideshow' : fade antar gambar
 */
$HERO_MODE = 'kenburns';
?>
<style>
/* =================================================================
   TOKENS & BASE
   ================================================================= */
:root{
  --brand:#e50914; --brand-600:#d50c16; --brand-700:#c00f18;
  --ink:#0f172a; --muted:#6b7280;
  --bg:#ffffff; --bg-alt:#f7f8fa; --card:#ffffff; --border:#e5e7eb;
  --shadow-sm:0 4px 14px rgba(2,6,23,.06); --shadow-md:0 12px 26px rgba(2,6,23,.08);
  --r-xs:10px; --r-sm:12px; --r-md:16px; --r-lg:20px; --container:1200px;
  --ease: cubic-bezier(.22,.61,.36,1);
  --a-fast: 320ms var(--ease);
  --a-med: 600ms var(--ease);
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

/* Page enter fade */
@media (prefers-reduced-motion:no-preference){
  body{opacity:0; transform:translateY(6px); transition: opacity .6s var(--ease), transform .6s var(--ease);}
  body.page-entered{opacity:1; transform:none;}
}

/* =================================================================
   HERO FULL – Ken Burns / Slideshow
   ================================================================= */
.hero-full{
  position: relative;
  block-size: 100svh;
  min-block-size: 100svh;
  isolation: isolate;
  overflow: hidden;
  color: #fff;
}
@supports (height: 100dvh){
  .hero-full{ block-size: 100dvh; min-block-size: 100dvh; }
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
.btn-pill{display:inline-flex; align-items:center; gap:10px; padding:12px 20px; border-radius:999px; font-weight:800; text-decoration:none; border:2px solid transparent; transition:transform .28s var(--ease), box-shadow .28s var(--ease), background .28s var(--ease), color .28s var(--ease);}
.btn-brand{background:var(--brand); color:#fff; box-shadow:0 10px 28px rgba(229,9,20,.35);}
.btn-brand:hover{background:var(--brand-600); transform:translateY(-2px);}
.btn-outline{background:transparent; border-color:#fff; color:#fff;}
.btn-outline:hover{background:#fff; color:#111;}

/* Ken Burns */
.hero-kenburns .kb{opacity:0; animation:fadeIn 9s linear infinite; will-change:transform, opacity;}
.hero-kenburns .kb.kb-1{animation-name:ken1;}
.hero-kenburns .kb.kb-2{animation-name:ken2; animation-delay:3s;}
.hero-kenburns .kb.kb-3{animation-name:ken3; animation-delay:6s;}
@keyframes fadeIn{from{opacity:0}10%{opacity:1}70%{opacity:1}to{opacity:0}}
@keyframes ken1{0%{transform:scale(1.08) translate3d(-1.5%,-1%,0);opacity:0}10%{opacity:1}50%{transform:scale(1.12)}90%{opacity:1}100%{transform:scale(1.14) translate3d(1.5%,1%,0);opacity:0}}
@keyframes ken2{0%{transform:scale(1.10) translate3d(1%,-1.2%,0);opacity:0}10%{opacity:1}50%{transform:scale(1.14)}90%{opacity:1}100%{transform:scale(1.18) translate3d(-1%,1.2%,0);opacity:0}}
@keyframes ken3{0%{transform:scale(1.06) translate3d(.8%,1%,0);opacity:0}10%{opacity:1}50%{transform:scale(1.10)}90%{opacity:1}100%{transform:scale(1.13) translate3d(-.8%,-1%,0);opacity:0}}

/* Slideshow */
.hero-slideshow .slide{position:absolute; inset:0; background-size:cover; background-position:center; opacity:0; transition:opacity 900ms var(--ease);}
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
  transition:transform .25s var(--ease), box-shadow .25s var(--ease);
}
.card-feature:hover{transform:translateY(-3px); box-shadow:var(--shadow-md);}
.feature-icon{
  width:44px; height:44px; border-radius:10px; display:grid; place-items:center; color:#fff; font-size:20px;
  background:linear-gradient(135deg, var(--brand), var(--brand-700));
}

/* =================================================================
   PRODUCT CARDS
   ================================================================= */
.card-product{
  background:var(--card); border:1px solid var(--border); border-radius:14px; overflow:hidden; box-shadow:var(--shadow-sm);
  transition:transform .25s var(--ease), box-shadow .25s var(--ease);
}
.card-product:hover{transform:translateY(-4px); box-shadow:var(--shadow-md);}
.card-product .media{aspect-ratio:16/9; overflow:hidden;}
.card-product img{width:100%; height:100%; object-fit:cover; display:block; transform:scale(1.02); transition:transform .35s var(--ease);}
.card-product:hover img{transform:scale(1.06);}
.card-product .body{padding:14px 16px;}
.card-product h4{margin:0 0 6px; font-weight:800; font-size:16px;}
.card-product p{margin:0; color:var(--muted); font-size:14px;}

.section-title{display:flex; align-items:center; justify-content:space-between; margin-bottom:18px;}
.section-title .h2{margin:0; position:relative; padding-bottom:8px;}
.section-title .h2::after{
  content:""; position:absolute; left:0; bottom:0; height:4px; width:68px; border-radius:3px; background:var(--brand);
  transform-origin:left; transform:scaleX(0); transition: transform .6s var(--ease);
}
.section-title.in .h2::after{ transform:scaleX(1); }

/* =================================================================
   ABOUT
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
  box-shadow:0 12px 28px rgba(229,9,20,.35); position:relative; overflow:hidden; transition:.28s var(--ease);
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

/* ===== Partners Marquee (warna + loop kiri) ===== */
.partners-marquee{
  --marquee-duration: 28s;        /* default; diset ulang via JS sesuai panjang konten */
  --gap: 18px;
  position: relative;
  overflow: hidden;
  background: transparent;
  padding: 6px 0;
  /* fade lembut di tepi */
  -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 40px, #000 calc(100% - 40px), transparent);
          mask-image: linear-gradient(90deg, transparent 0, #000 40px, #000 calc(100% - 40px), transparent);
}
.marquee-inner{
  display:flex; align-items:center; gap:var(--gap);
  width: max-content;
  will-change: transform;
  animation: partners-marquee var(--marquee-duration) linear infinite;
}
.partners-marquee:hover .marquee-inner{ animation-play-state: paused; }

.partner-card{
  background:var(--card); border:1px solid var(--border); border-radius:12px; padding:16px;
  display:grid; place-items:center;
  /* LANGSUNG BERWARNA: tidak ada grayscale */
  opacity:1; transition:.2s; box-shadow:var(--shadow-sm);
  min-width: clamp(160px, 18vw, 240px);
  height: clamp(64px, 8vw, 84px);
}
.partner-card:hover{ transform:translateY(-3px); box-shadow:var(--shadow-md); }
.partner-card img{ height:clamp(26px,3.2vw,34px); max-width:100%; object-fit:contain; }

/* Animasi geser tak terputus (konten digandakan via JS) */
@keyframes partners-marquee {
  from { transform: translateX(0); }
  to   { transform: translateX(-50%); }  /* -50% karena isi track digandakan */
}

/* =================================================================
   REVEAL ENGINE (scroll animations + stagger)
   ================================================================= */
.reveal-set{ --stagger: 80ms; }
.reveal-set .reveal-item{ opacity:0; transform:translateY(16px); filter:blur(2px); transition: opacity var(--a-med), transform var(--a-med), filter var(--a-med); }
.reveal-set .fade-up{ transform:translateY(16px); }
.reveal-set .slide-up{ transform:translateY(28px); }
.reveal-set .zoom-in{ transform:scale(.98); }
.reveal-set .scale-in{ transform:scale(.92); }
.reveal-set.in .reveal-item{ opacity:1; transform:none; filter:none; }

@media (prefers-reduced-motion: reduce) {
  .reveal-set .reveal-item{ transition:none; opacity:1; transform:none; filter:none; }
  body{ transition:none;}
}

/* bantu spacing kecil */
.sp-24{height:24px;}
</style>

<!-- ==================== HERO ==================== -->
<section class="hero-full <?php echo $HERO_MODE==='kenburns'?'hero-kenburns':'hero-slideshow'; ?>" id="Hero">
  <?php if ($HERO_MODE === 'kenburns'): ?>
    <?php $kb = array_slice(array_pad($heroImages, 3, end($heroImages)), 0, 3); ?>
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
      <h1 class="h1">
        Produsen Ubin Keramik
        <span style="color:#ff2a33">Lantai</span> &
        <span style="color:#ff2a33">Dinding</span>
      </h1>
      <p class="muted" style="max-width:720px; color:#e5e7eb">Menghadirkan kualitas, ketahanan, dan estetika terbaik untuk setiap ruang.</p>
      <div class="hero-actions">
        <a href="index.php?page=produk" class="btn-pill btn-brand">📦 Lihat Produk</a>
        <a href="index.php?page=tentang" class="btn-pill btn-outline">ℹ️ Tentang Kami</a>
      </div>
    </div>
  </div>
</section>

<!-- ==================== MENGAPA MEMILIH KAMI ==================== -->
<section class="section-alt">
  <div class="container-xl">
    <div class="section-title" id="title-why"><h2 class="h2">Mengapa Memilih Kami?</h2></div>

    <div class="grid-3 reveal-set" data-stagger="100">
      <div class="card-feature reveal-item fade-up">
        <div class="feature-icon"><i class="fas fa-fire"></i></div>
        <div>
          <h3 class="h3" style="font-size:18px">Teknologi Glaze</h3>
          <p class="muted">Permukaan halus & tahan gores dengan teknologi mutakhir.</p>
        </div>
      </div>
      <div class="card-feature reveal-item fade-up">
        <div class="feature-icon"><i class="fas fa-award"></i></div>
        <div>
          <h3 class="h3" style="font-size:18px">Standar Mutu Tinggi</h3>
          <p class="muted">QC ketat dari bahan baku hingga tahap akhir produksi.</p>
        </div>
      </div>
      <div class="card-feature reveal-item fade-up">
        <div class="feature-icon"><i class="fas fa-th-large"></i></div>
        <div>
          <h3 class="h3" style="font-size:18px">Varian Motif Modern</h3>
          <p class="muted">Marmer, batu alam, kayu, dan motif modern sesuai tren.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ==================== PRODUK UNGGULAN ==================== -->
<section class="section">
  <div class="container-xl">
    <div class="section-title" id="title-products">
      <h2 class="h2">Produk Unggulan</h2>
      <a href="index.php?page=produk" class="btn-pill btn-brand" style="padding:10px 16px;">Lihat Semua</a>
    </div>

    <div class="grid-3 reveal-set" data-stagger="120">
      <article class="card-product reveal-item zoom-in">
        <div class="media"><img src="assets/img/alabstro.jpg" alt="Keramik Premium"></div>
        <div class="body">
          <h4>Keramik Premium</h4>
          <p>Kualitas terbaik untuk lantai rumah & bangunan.</p>
        </div>
      </article>
      <article class="card-product reveal-item zoom-in">
        <div class="media"><img src="assets/img/Arabescato.jpg" alt="Motif Marmer"></div>
        <div class="body">
          <h4>Motif Marmer</h4>
          <p>Elegan dengan nuansa alam yang mewah.</p>
        </div>
      </article>
      <article class="card-product reveal-item zoom-in">
        <div class="media"><img src="assets/img/Calcita.jpg" alt="Keramik Dinding"></div>
        <div class="body">
          <h4>Keramik Dinding</h4>
          <p>Hadir dalam berbagai motif modern.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ==================== TENTANG KAMI ==================== -->
<section class="section-alt">
  <div class="container-xl about-wrap">
    <div class="reveal-set" data-stagger="90">
      <h2 class="h2 reveal-item slide-up" style="margin-bottom:4px">Tentang Kami</h2>
      <div class="divider reveal-item scale-in"></div>
      <p class="lead reveal-item fade-up">
        <strong>PT Rumah Keramik Indonesia</strong> berkomitmen menghadirkan 
        <span style="color:var(--brand);font-weight:700;"> produk ubin berkualitas tinggi</span> 
        melalui teknologi modern dan pengendalian mutu berlapis.
      </p>
      <ul class="checklist">
        <li class="reveal-item fade-up"><i class="fas fa-check-circle"></i><span>Sertifikasi mutu & proses produksi terdokumentasi</span></li>
        <li class="reveal-item fade-up"><i class="fas fa-check-circle"></i><span>Desain marmer, batu alam, dan kayu yang realistis</span></li>
        <li class="reveal-item fade-up"><i class="fas fa-check-circle"></i><span>Ketahanan gores & beban sesuai standar</span></li>
        <li class="reveal-item fade-up"><i class="fas fa-check-circle"></i><span>Jaringan distribusi & layanan purna jual</span></li>
      </ul>
      <a href="index.php?page=tentang" class="btn-glow reveal-item scale-in">Pelajari Lebih Lanjut</a>
    </div>
    <div class="card-video reveal-set" data-stagger="0">
      <iframe class="reveal-item zoom-in"
              src="https://www.youtube.com/embed/ywDm7fHlj9Q?autoplay=0&mute=1&controls=1&modestbranding=1"
              title="Profil Pabrik" frameborder="0" allowfullscreen
              referrerpolicy="strict-origin-when-cross-origin"></iframe>
    </div>
  </div>
</section>

<!-- ==================== CAPAIAN & MITRA ==================== -->
<section class="section" id="Capaian">
  <div class="container-xl">
    <div class="section-title" id="title-counters"><h2 class="h2">Capaian & Kepercayaan</h2></div>

    <div class="stats reveal-set" data-stagger="120">
      <div class="stat reveal-item scale-in" data-target="15" data-suffix="+">
        <strong class="count">0</strong>
        <span>Tahun Pengalaman</span>
      </div>
      <div class="stat reveal-item scale-in" data-target="250" data-suffix="+">
        <strong class="count">0</strong>
        <span>Proyek Terselesaikan</span>
      </div>
      <div class="stat reveal-item scale-in" data-target="1200000" data-format="short" data-suffix="+">
        <strong class="count">0</strong>
        <span>m² Keramik Terpasang</span>
      </div>
      <div class="stat reveal-item scale-in" data-target="50" data-suffix="+">
        <strong class="count">0</strong>
        <span>Distribusi Kota</span>
      </div>
    </div>

    <div class="sp-24"></div>

    <!-- ===== PARTNERS MARQUEE (warna & looping kiri) ===== -->
    <div class="partners-marquee" aria-label="Mitra Kami">
      <div class="marquee-inner" id="PartnersMarqueeTrack">
        <!-- TRACK A -->
        <div class="partner-card"><img src="assets/img/mitra1.png" alt="Mitra 1"></div>
        <div class="partner-card"><img src="assets/img/mitra2.png" alt="Mitra 2"></div>
        <div class="partner-card"><img src="assets/img/mitra3.png" alt="Mitra 3"></div>
        <div class="partner-card"><img src="assets/img/mitra4.png" alt="Mitra 4"></div>
        <div class="partner-card"><img src="assets/img/mitra5.png" alt="Mitra 5"></div>
        <div class="partner-card"><img src="assets/img/mitra6.png" alt="Mitra 6"></div>
        <!-- (TRACK B akan otomatis dikloning via JS untuk loop mulus) -->
      </div>
    </div>

  </div>
</section>

<!-- ==================== JS: slideshow + page enter + reveal + counters ==================== -->
<script>
(function(){
  // Page enter
  window.addEventListener('load', ()=> document.body.classList.add('page-entered'));

  // Slideshow (kalau mode slideshow)
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
    dots.forEach((btn,idx)=>{ btn.addEventListener('click', ()=>{ clearInterval(T); show(idx); T = setInterval(next, 6000); }); });
  }

  // Section title underline animasi
  const titles = ['title-why','title-products','title-counters']
    .map(id => document.getElementById(id))
    .filter(Boolean);
  const ioTitle = new IntersectionObserver((entries)=>{
    entries.forEach(e=>{ if(e.isIntersecting){ e.target.classList.add('in'); ioTitle.unobserve(e.target); }});
  }, {threshold:.3});
  titles.forEach(t => ioTitle.observe(t));

  // Reveal + stagger
  const ioReveal = new IntersectionObserver((entries)=>{
    entries.forEach(entry=>{
      if(!entry.isIntersecting) return;
      const set = entry.target;
      const stagger = parseInt(set.dataset.stagger || '80', 10);
      const items = set.querySelectorAll('.reveal-item');
      items.forEach((el, idx)=>{ el.style.transitionDelay = (idx * stagger) + 'ms'; });
      set.classList.add('in');
      ioReveal.unobserve(set);
    });
  }, {threshold:.18});
  document.querySelectorAll('.reveal-set').forEach(set => ioReveal.observe(set));

  // Counter on Scroll
  const easeOutCubic = t => 1 - Math.pow(1 - t, 3);
  function formatShort(n){
    const abs = Math.abs(n);
    const fmt = (v)=> (Math.round(v * 10) / 10).toString().replace('.0','');
    if (abs >= 1e9) return fmt(n/1e9) + 'B';
    if (abs >= 1e6) return fmt(n/1e6) + 'M';
    if (abs >= 1e3) return fmt(n/1e3) + 'K';
    return Math.round(n).toLocaleString('id-ID');
  }
  function animateCount(el, target, {duration=1600, format='plain', suffix='' } = {}){
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
            animateCount(strong, to, {duration:2800, format, suffix});
          });
          ioCount.unobserve(capaian);
        }
      });
    }, {threshold:.25});
    ioCount.observe(capaian);
  }

  // Header transparan saat ada hero
  const html = document.documentElement;
  if (document.querySelector('.hero-full')) html.classList.add('has-hero');
  const header = document.querySelector('.site-header');
  function setHeaderVars(){
    const h = (header?.offsetHeight || 86);
    html.style.setProperty('--header-h', h + 'px');
  }
  function setSolid(){
    if (!document.querySelector('.hero-full') || window.scrollY > 16) html.classList.add('header-solid');
    else html.classList.remove('header-solid');
  }
  setHeaderVars(); setSolid();
  window.addEventListener('resize', setHeaderVars);
  document.addEventListener('scroll', setSolid, {passive:true});
})();
</script>

<script>
// Duplikasi isi trek supaya loop mulus & set durasi berdasar panjang konten
(function(){
  const track = document.getElementById('PartnersMarqueeTrack');
  if (!track) return;

  // Gandakan anak-anak sekali -> total konten 2x
  const items = Array.from(track.children);
  items.forEach(el => track.appendChild(el.cloneNode(true)));

  // Hitung total lebar konten agar kecepatan konsisten
  const gap = 18; // harus sama dengan CSS --gap
  function computeDuration(){
    let total = 0;
    Array.from(track.children).forEach(el => { total += el.getBoundingClientRect().width + gap; });
    const speed = 110; // px per detik (atur 90–140 sesuai selera)
    const duration = Math.max(16, Math.round(total / speed));
    track.style.setProperty('--marquee-duration', duration + 's');
  }
  // Tunggu layout stabil dulu
  window.addEventListener('load', computeDuration);
  computeDuration();
  // Responsif
  let timer;
  window.addEventListener('resize', () => {
    clearTimeout(timer);
    timer = setTimeout(computeDuration, 150);
  });
})();
</script>

<?php include __DIR__ . '/../inc/footer.php'; ?>
