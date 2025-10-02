<?php  
require_once __DIR__.'/../inc/db.php'; 
session_start();

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';

    $st = $pdo->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
    $st->execute([$u]);
    $user = $st->fetch();

    if ($user && password_verify($p, $user['password'])) {
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_user'] = $user['username'];
        header('Location: products.php');
        exit;
    } else {
        $msg = 'Username atau password salah!';
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login Admin - PT RKI</title>

  <!-- Favicon -->
  <link rel="icon" href="../assets/img/logo-red.png" type="image/png">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

  <style>
    /* Background */
    body {
      margin: 0;
      padding: 0;
      font-family: 'Inter', sans-serif;
      background: url('https://cdn.pixabay.com/photo/2020/11/12/16/58/worker-5736096_1280.jpg') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    /* Overlay */
    body::before {
      content: "";
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(255,255,255,0.75);
      z-index: 0;
    }

    /* Container Login */
    .login-container {
      position: relative;
      z-index: 1;
      background: #fff;
      padding: 40px 30px;
      border-radius: 20px;
      width: 100%;
      max-width: 420px;
      text-align: center;
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
      animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(20px);}
      to {opacity: 1; transform: translateY(0);}
    }

    /* Logo */
    .login-container img.logo {
      height: 80px;
      margin-bottom: 15px;
      animation: zoomLogo 1s ease;
    }
    @keyframes zoomLogo {
      from {transform: scale(0.8);}
      to {transform: scale(1);}
    }

    /* Jam & Tanggal */
    .date-time {
      font-size: 1rem;
      margin-bottom: 15px;
      font-weight: 600;
      color: #1f2937;
    }
    .date-time span {
      display: block;
      font-size: 0.9rem;
      color: #6b7280;
    }

    h2 {
      margin-bottom: 20px;
      font-weight: 700;
      color: #111827;
    }

    /* Input */
    .input {
      width: 100%;
      padding: 12px 14px;
      border-radius: 10px;
      border: 1px solid #d1d5db;
      margin-bottom: 16px;
      background: #fff;
      color: #0f172a;
      font-size: 1rem;
      outline: none;
      transition: all 0.3s ease;
    }
    .input::placeholder { color: #9ca3af; }
    .input:focus {
      border-color: #e50914;
      box-shadow: 0 0 0 3px rgba(229,9,20,0.2);
    }

    /* Button */
    .btn-primary {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 10px;
      background: linear-gradient(135deg, #e50914, #ff3b30);
      color: #fff;
      font-weight: 700;
      font-size: 1rem;
      cursor: pointer;
      transition: transform 0.2s ease, background 0.3s ease;
    }
    .btn-primary:hover {
      transform: translateY(-2px);
      background: linear-gradient(135deg, #ff3b30, #e50914);
    }

    /* Alert */
    .alert {
      background: rgba(229,9,20,0.1);
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 12px;
      color: #e50914;
      font-size: 0.9rem;
      border: 1px solid rgba(229,9,20,0.3);
    }

    /* Footer */
    .footer-text {
      margin-top: 15px;
      font-size: 0.85rem;
      color: #6b7280;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <!-- Logo -->
    <img src="../assets/img/logo.jpg" alt="PT RKI Logo" class="logo">

    <!-- Jam dan Tanggal -->
    <div class="date-time">
      <div id="clock">00:00:00</div>
      <span id="date">Senin, 01 Januari 2025</span>
    </div>

    <h2>Login Admin</h2>
    
    <?php if ($msg): ?>
      <div class="alert"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <!-- Form Login -->
    <form method="post">
      <input class="input" type="text" name="username" placeholder="Username" required>
      <input class="input" type="password" name="password" placeholder="Password" required>
      <button class="btn-primary">Masuk</button>
    </form>

    <div class="footer-text">© <?= date('Y') ?> PT Rumah Keramik Indonesia</div>
  </div>

  <!-- Script Jam & Tanggal -->
  <script>
    function updateClock() {
      const now = new Date();
      
      // Jam
      const h = String(now.getHours()).padStart(2, '0');
      const m = String(now.getMinutes()).padStart(2, '0');
      const s = String(now.getSeconds()).padStart(2, '0');
      document.getElementById('clock').textContent = `${h}:${m}:${s}`;

      // Tanggal
      const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
      const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
      const dayName = days[now.getDay()];
      const day = String(now.getDate()).padStart(2, '0');
      const month = months[now.getMonth()];
      const year = now.getFullYear();

      document.getElementById('date').textContent = `${dayName}, ${day} ${month} ${year}`;
    }

    setInterval(updateClock, 1000);
    updateClock();
  </script>
</body>
</html>
