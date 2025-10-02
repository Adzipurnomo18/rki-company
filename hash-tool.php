<?php 
include '_top.php'; // header admin
?>

<div class="card">
  <h3>Generate Hash Password</h3>
  <p>Gunakan halaman ini untuk membuat hash password yang siap dimasukkan ke database.</p>

  <?php
  $hash = '';
  $error = '';

  // Proses form ketika tombol submit ditekan
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $plain = trim($_POST['plain'] ?? '');
      if (!empty($plain)) {
          $hash = password_hash($plain, PASSWORD_DEFAULT);
      } else {
          $error = 'Masukkan password terlebih dahulu.';
      }
  }
  ?>

  <form method="post" class="form" style="margin-top:15px;max-width:400px">
    <label>Masukkan Password</label>
    <input type="text" name="plain" class="input" placeholder="Password" required>
    <button class="btn btn-primary" type="submit">Generate Hash</button>
  </form>

  <?php if ($error): ?>
    <div class="alert" style="margin-top:15px"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if ($hash): ?>
    <div class="alert" style="margin-top:15px">
      <strong>Hash Password:</strong>
      <br>
      <code><?= htmlspecialchars($hash) ?></code>
    </div>

    <p style="margin-top:10px">
      Salin hash di atas, lalu update ke database:
      <br>
      <code>UPDATE users SET password = 'HASH_DI_ATAS' WHERE username = 'admin';</code>
    </p>
  <?php endif; ?>
</div>

<?php include '_bottom.php'; ?>
