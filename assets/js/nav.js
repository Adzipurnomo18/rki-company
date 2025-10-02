// assets/js/nav.js
(function () {
    function $(sel) { return document.querySelector(sel); }
  
    const toggleBtn = $('.menu-toggle');
    // Cari salah satu elemen menu yang ada
    const menu = $('#nav-menu') || $('.nav-menu') || $('#main-nav');
  
    if (!toggleBtn) { console.error('menu-toggle tidak ditemukan'); return; }
    if (!menu)      { console.error('Elemen menu tidak ditemukan');  return; }
  
    // Buka/tutup
    function openMenu() {
      document.body.classList.add('nav-open');
      toggleBtn.setAttribute('aria-expanded', 'true');
    }
    function closeMenu() {
      document.body.classList.remove('nav-open');
      toggleBtn.setAttribute('aria-expanded', 'false');
    }
    function toggleMenu(e) {
      e && e.stopPropagation();
      if (document.body.classList.contains('nav-open')) closeMenu();
      else openMenu();
    }
  
    toggleBtn.addEventListener('click', toggleMenu);
  
    // Tutup bila klik di luar
    document.addEventListener('click', (e) => {
      if (!document.body.classList.contains('nav-open')) return;
      if (menu.contains(e.target) || toggleBtn.contains(e.target)) return;
      closeMenu();
    });
  
    // Tutup via ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeMenu();
    });
  })();
  