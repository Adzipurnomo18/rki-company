<?php
/**
 * inc/hero.php
 * Hero full-screen untuk semua halaman.
 * Variabel opsional sebelum include:
 *   $heroKicker, $heroTitle, $heroSubtitle,
 *   $HERO_MODE ('kenburns'|'slideshow'),
 *   $heroImages (array URL),
 *   $heroFull (bool) -> default true (100vh)
 *   $heroAccent (hex) -> warna aksen, default '#ff2a33'
 */

if (!isset($heroFull))   $heroFull   = true;
if (!isset($HERO_MODE))  $HERO_MODE  = 'kenburns';
if (!isset($heroKicker)) $heroKicker = 'PT Rumah Keramik Indonesia';
if (!isset($heroTitle))  $heroTitle  = 'Judul <span class="accent">Halaman</span>';
if (!isset($heroSubtitle)) $heroSubtitle = 'Subjudul halaman di sini.';
if (!isset($heroAccent) || !preg_match('/^#([0-9a-f]{3}|[0-9a-f]{6})$/i', $heroAccent)) {
  $heroAccent = '#ff2a33'; // default merah cerah
}

// helper: hex -> [r,g,b]
$__hex = ltrim($heroAccent, '#');
if (strlen($__hex) === 3) {
  $__hex = "{$__hex[0]}{$__hex[0]}{$__hex[1]}{$__hex[1]}{$__hex[2]}{$__hex[2]}";
}
$__r = hexdec(substr($__hex, 0, 2));
$__g = hexdec(substr($__hex, 2, 2));
$__b = hexdec(substr($__hex, 4, 2));

// Siapkan gambar (ambil dari DB jika $heroImages tidak diset)
if (!isset($heroImages) || !is_array($heroImages) || !$heroImages) {
  try {
    $rows = $pdo?->query("SELECT image FROM gallery ORDER BY id DESC LIMIT 6")?->fetchAll(PDO::FETCH_ASSOC) ?? [];
  } catch (\Throwable $e) { $rows = []; }
  $heroImages = [];
  foreach ($rows as $r) {
    $file = __DIR__ . '/../uploads/gallery/' . ($r['image'] ?? '');
    $src  = is_file($file) ? 'uploads/gallery/' . htmlspecialchars($r['image']) : 'assets/img/rki.jpg';
    $heroImages[] = $src;
  }
  if (!$heroImages) {
    $heroImages = [
      'assets/img/rki.jpg',
      'assets/img/Calcita.jpg',
      'assets/img/Arabescato.jpg'
    ];
  }
}

// CSS sekali saja
if (!defined('RKI_HERO_ONCE')): define('RKI_HERO_ONCE', true); ?>
<style>
/* ====== HERO FULL ====== */
.hero-full,
.hero-slim{
  position:relative;
  isolation:isolate;
  overflow:hidden;
  color:#fff;
}
.hero-full{ block-size:100svh; min-block-size:100svh; }
@supports(height: 100dvh){ .hero-full{ block-size:100dvh; min-block-size:100dvh; } }
.hero-slim{ block-size:55vh; min-block-size:55vh; }

.hero-layer{position:absolute; inset:0; background-size:cover; background-position:center;}
.hero-overlay{
  position:absolute; inset:0;
  /* radial glow pakai warna aksen (PHP injeksi rgba) */
  background:
    radial-gradient(1200px 600px at 25% 25%, rgba(<?= $__r ?>,<?= $__g ?>,<?= $__b ?>,.20), transparent 55%),
    linear-gradient(to bottom, rgba(2,6,23,.34), rgba(2,6,23,.68));
  z-index:2; pointer-events:none;
}
.hero-content{ position:relative; z-index:3; min-height:inherit; display:grid; align-content:center; }
.hero-inner{ max-width:1200px; width:100%; margin:0 auto; padding:0 20px; }

.kicker{ font-weight:800; letter-spacing:.12em; text-transform:uppercase; opacity:.95; margin-bottom:12px; }
.h1{ font-weight:900; letter-spacing:-.02em; font-size:clamp(28px,3.3vw,46px); }
.muted{ color:#e8eaee; max-width:720px; }

/* Aksen global untuk teks */
.hero-inner .accent{ color: <?= htmlspecialchars($heroAccent) ?> !important; }

/* Ken Burns */
.hero-kenburns .kb{opacity:0; animation:fadeIn 9s linear infinite; will-change:transform,opacity;}
.hero-kenburns .kb.kb-1{animation-name:ken1;}
.hero-kenburns .kb.kb-2{animation-name:ken2; animation-delay:3s;}
.hero-kenburns .kb.kb-3{animation-name:ken3; animation-delay:6s;}
@keyframes fadeIn{from{opacity:0}10%{opacity:1}70%{opacity:1}to{opacity:0}}
@keyframes ken1{0%{transform:scale(1.08) translate(-1.5%,-1%);opacity:0}10%{opacity:1}50%{transform:scale(1.12)}90%{opacity:1}100%{transform:scale(1.14) translate(1.5%,1%);opacity:0}}
@keyframes ken2{0%{transform:scale(1.10) translate(1%,-1.2%);opacity:0}10%{opacity:1}50%{transform:scale(1.14)}90%{opacity:1}100%{transform:scale(1.18) translate(-1%,1.2%);opacity:0}}
@keyframes ken3{0%{transform:scale(1.06) translate(.8%,1%);opacity:0}10%{opacity:1}50%{transform:scale(1.10)}90%{opacity:1}100%{transform:scale(1.13) translate(-.8%,-1%);opacity:0}}

/* Slideshow */
.hero-slideshow .slide{position:absolute; inset:0; background-size:cover; background-position:center; opacity:0; transition:opacity .9s;}
.hero-slideshow .slide.is-active{opacity:1;}
.hero-dots{position:absolute; left:50%; bottom:18px; transform:translateX(-50%); z-index:4; display:flex; gap:8px;}
.hero-dots button{width:10px; height:10px; border-radius:999px; background:rgba(255,255,255,.55); border:none; cursor:pointer;}
.hero-dots button.is-active{background:#fff;}
</style>
<?php endif; ?>

<?php
$rootClass = $heroFull ? 'hero-full' : 'hero-slim';
$modeClass = ($HERO_MODE === 'slideshow') ? 'hero-slideshow' : 'hero-kenburns';
?>

<section class="<?= $rootClass . ' ' . $modeClass ?>" id="PageHero">
  <?php if ($HERO_MODE === 'slideshow'): ?>
    <?php foreach ($heroImages as $i => $img): ?>
      <div class="hero-layer slide <?= $i===0?'is-active':'' ?>" style="background-image:url('<?= $img ?>')"></div>
    <?php endforeach; ?>
    <div class="hero-dots" id="HeroDots">
      <?php foreach ($heroImages as $i => $img): ?>
        <button class="<?= $i===0?'is-active':'' ?>" aria-label="slide <?= $i+1 ?>"></button>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <?php $kb = array_slice(array_pad($heroImages, 3, end($heroImages)), 0, 3); ?>
    <div class="hero-layer kb kb-1" style="background-image:url('<?= $kb[0] ?>')"></div>
    <div class="hero-layer kb kb-2" style="background-image:url('<?= $kb[1] ?>')"></div>
    <div class="hero-layer kb kb-3" style="background-image:url('<?= $kb[2] ?>')"></div>
  <?php endif; ?>

  <div class="hero-overlay"></div>

  <div class="hero-content">
    <div class="hero-inner">
      <?php if ($heroKicker): ?><div class="kicker"><?= $heroKicker ?></div><?php endif; ?>
      <h1 class="h1"><?= $heroTitle ?></h1>
      <?php if ($heroSubtitle): ?><p class="muted"><?= $heroSubtitle ?></p><?php endif; ?>
    </div>
  </div>
</section>

<script>
(function(){
  // Tandai halaman punya hero → header transparan
  const html = document.documentElement;
  html.classList.add('has-hero');

  // Solidkan header setelah scroll 16px
  function setSolid(){
    if (window.scrollY > 16) html.classList.add('header-solid');
    else html.classList.remove('header-solid');
  }
  setSolid();
  document.addEventListener('scroll', setSolid, {passive:true});

  // Slideshow kontrol
  const hero = document.getElementById('PageHero');
  if (hero && hero.classList.contains('hero-slideshow')) {
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
    dots.forEach((btn,idx)=> btn.addEventListener('click', ()=>{ clearInterval(T); show(idx); T = setInterval(next, 6000); }));
  }
})();
</script>
<?php
// end inc/hero.php
