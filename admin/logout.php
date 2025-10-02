<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logout</title>

  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Popup konfirmasi logout
  Swal.fire({
    title: 'Yakin ingin logout?',
    text: "Kamu akan keluar dari akun ini.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#e50914',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Ya, Logout',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      // Jika user memilih logout, hapus session via process_logout.php
      fetch('process_logout.php')
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            Swal.fire({
              title: 'Berhasil Logout!',
              text: 'Kamu akan diarahkan ke halaman login.',
              icon: 'success',
              showConfirmButton: false,
              timer: 2000
            });
            // Redirect ke login.php setelah 2 detik
            setTimeout(() => {
              window.location.href = 'login.php';
            }, 2000);
          } else {
            Swal.fire('Error', 'Logout gagal, coba lagi.', 'error');
          }
        })
        .catch(error => {
          Swal.fire('Error', 'Tidak bisa menghubungi server.', 'error');
          console.error('Error:', error);
        });
    } else {
      // Jika user batal logout, kembali ke halaman sebelumnya
      window.history.back();
    }
  });
});
</script>

</body>
</html>
