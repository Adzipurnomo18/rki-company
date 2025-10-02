document.addEventListener('DOMContentLoaded', () => {
  const themeToggle = document.getElementById('theme-toggle');
  const logoHeader = document.getElementById('logo-header');
  const logoFooter = document.getElementById('logo-footer');

  // Ganti tema
  function setTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);

    if (theme === 'dark') {
      logoHeader.src = 'assets/img/logo-white.png'; // Logo putih
      logoFooter.src = 'assets/img/logo-white.png';
      themeToggle.textContent = '☀️'; // Ikon matahari
    } else {
      logoHeader.src = 'assets/img/logo-red.png'; // Logo merah
      logoFooter.src = 'assets/img/logo-red.png';
      themeToggle.textContent = '🌙'; // Ikon bulan
    }
  }

  // Toggle ketika diklik
  themeToggle.addEventListener('click', () => {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    setTheme(currentTheme === 'dark' ? 'light' : 'dark');
  });

  // Cek tema terakhir dari localStorage
  const savedTheme = localStorage.getItem('theme') || 'light';
  setTheme(savedTheme);
});
document.addEventListener("DOMContentLoaded", function () {
  const slides = document.querySelectorAll('#slider img[data-slide]');
  const dots = document.querySelectorAll('#slider .dots button');
  let currentIndex = 0;
  let slideInterval;

  // Fungsi untuk menampilkan slide
  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.toggle('active', i === index);
      dots[i].classList.toggle('active', i === index);
    });
    currentIndex = index;
  }

  // Fungsi untuk slide berikutnya
  function nextSlide() {
    let nextIndex = (currentIndex + 1) % slides.length;
    showSlide(nextIndex);
  }

  // Interval otomatis
  function startAutoSlide() {
    slideInterval = setInterval(nextSlide, 2000); // 3 detik
  }

  // Hentikan slide saat hover
  const slider = document.getElementById('slider');
  slider.addEventListener('mouseenter', () => clearInterval(slideInterval));
  slider.addEventListener('mouseleave', startAutoSlide);

  // Klik dots manual
  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
      showSlide(index);
    });
  });

  // Jalankan slide otomatis
  if (slides.length > 0) {
    showSlide(0);
    startAutoSlide();
  }
});
document.addEventListener("scroll", function () {
  const navbar = document.querySelector(".navbar-modern");
  if (window.scrollY > 50) {
    navbar.classList.add("scrolled");
  } else {
    navbar.classList.remove("scrolled");
  }
});
