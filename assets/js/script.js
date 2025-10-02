console.log("Script loaded!");
document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.getElementById('nav-menu');
  
    if (menuToggle && navMenu) {
      menuToggle.addEventListener('click', () => {
        navMenu.classList.toggle('active');
      });
    } else {
      console.error('Element menu-toggle atau nav-menu tidak ditemukan!');
    }
  });
  