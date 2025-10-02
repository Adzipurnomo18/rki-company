<?php 
include '_top.php'; 
$msg=''; 

// === PROSES FORM ===
if($_SERVER['REQUEST_METHOD']==='POST'){
    // Tambah kategori
    if(isset($_POST['add'])){
        $name = trim($_POST['name'] ?? '');
        if($name){
            $pdo->prepare("INSERT INTO categories(name) VALUES(?)")->execute([$name]);
            $msg='Kategori ditambahkan.';
        }
    }

    // Hapus kategori
    if(isset($_POST['delete'])){
        $id = (int)$_POST['id'];
        $pdo->prepare("DELETE FROM categories WHERE id=?")->execute([$id]);
        $msg='Kategori dihapus.';
    }
}

// === AMBIL DATA ===
$cats = $pdo->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Kategori</title>

  <!-- CSS utama -->
  <link rel="stylesheet" href="../assets/css/admin.css">

  <!-- AOS Animation -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
</head>
<body>

<div class="container">

  <!-- ALERT -->
  <?php if($msg): ?>
    <div class="alert" data-aos="fade-down"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>

  <div class="grid grid-2">
      <!-- FORM TAMBAH KATEGORI -->
      <div class="card" data-aos="fade-right">
          <h3>Tambah Kategori</h3>
          <form method="post" class="form" style="margin-top:10px">
              <input class="input" name="name" placeholder="Nama kategori" required>
              <button class="btn btn-primary" name="add">Simpan</button>
          </form>
      </div>

      <!-- DAFTAR KATEGORI -->
      <div class="card" data-aos="fade-left">
          <h3>Daftar Kategori</h3>
          <table class="table">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
                  <?php 
                  foreach($cats as $index => $c){
                      echo '
                      <tr data-aos="fade-up" data-aos-delay="'.($index * 100).'">
                          <td>'.$c['id'].'</td>
                          <td>'.htmlspecialchars($c['name']).'</td>
                          <td>
                              <form method="post" onsubmit="return confirm(\'Hapus?\')">
                                  <input type="hidden" name="id" value="'.$c['id'].'">
                                  <button class="btn" name="delete">Hapus</button>
                              </form>
                          </td>
                      </tr>';
                  } 
                  ?>
              </tbody>
          </table>
      </div>
  </div>
</div>

<!-- AOS Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
AOS.init({
    duration: 800,          // Durasi animasi (ms)
    easing: 'ease-in-out',  // Efek transisi
    once: true               // Animasi hanya muncul sekali
});
</script>

<?php include '_bottom.php'; ?>
</body>
</html>
