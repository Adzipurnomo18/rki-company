<?php 
include '_top.php'; 
$msg=''; 

// === Proses Form ===
if($_SERVER['REQUEST_METHOD']==='POST'){
    // Tambah produk
    if(isset($_POST['add'])){
        $name = trim($_POST['name'] ?? '');
        $price = $_POST['price'] !== '' ? $_POST['price'] : null;
        $cat = $_POST['category'] ?: null;
        $desc = trim($_POST['description'] ?? '');
        $imgname = null;

        // Upload gambar
        if(!empty($_FILES['image']['name'])){
            $imgname = time().'_'.preg_replace('/[^a-zA-Z0-9\.\-_]/','',$_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__.'/../uploads/products/'.$imgname);
        }

        $pdo->prepare("INSERT INTO products(name,description,price,category,image) VALUES(?,?,?,?,?)")
            ->execute([$name,$desc,$price,$cat,$imgname]);

        $msg='Produk ditambahkan.';
    }

    // Hapus produk
    if(isset($_POST['delete'])){
        $id = (int)$_POST['id'];
        $pdo->prepare("DELETE FROM products WHERE id=?")->execute([$id]);
        $msg='Produk dihapus.';
    }
}

// === Ambil Data ===
$cats = $pdo->query("SELECT id,name FROM categories ORDER BY name")->fetchAll();
$rows = $pdo->query("SELECT p.*,c.name as cat FROM products p LEFT JOIN categories c ON c.id=p.category ORDER BY p.id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Produk</title>
  
  <!-- CSS Utama -->
  <link rel="stylesheet" href="../assets/css/admin.css">

  <!-- AOS CSS untuk animasi -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
</head>
<body>

<div class="container">

    <!-- Alert Pesan -->
    <?php if($msg): ?>
      <div class="alert" data-aos="fade-down"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <div class="grid grid-2">
        <!-- Form Tambah Produk -->
        <div class="card" data-aos="fade-right">
            <h3>Tambah Produk</h3>
            <form method="post" enctype="multipart/form-data" class="form" style="margin-top:10px">
                <input class="input" name="name" placeholder="Nama produk" required>

                <select class="input" name="category">
                    <option value="">Pilih kategori</option>
                    <?php foreach($cats as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>

                <input class="input" type="number" name="price" placeholder="Harga (opsional)">
                <textarea class="textarea" name="description" placeholder="Deskripsi"></textarea>
                <input type="file" name="image" accept="image/*">

                <button class="btn btn-primary" name="add">Simpan</button>
            </form>
        </div>

        <!-- Daftar Produk -->
        <div class="card" data-aos="fade-left">
            <h3>Daftar Produk</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($rows as $index => $r): 
                    $img = $r['image'] ? '../uploads/products/'.$r['image'] : '../assets/img/logo-red.png';
                ?>
                    <tr data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                        <td>
                            <img src="<?= $img ?>" style="width:80px;height:60px;object-fit:cover;border-radius:8px">
                        </td>
                        <td><?= htmlspecialchars($r['name']) ?></td>
                        <td><?= htmlspecialchars($r['cat'] ?? '') ?></td>
                        <td><?= $r['price'] !== null ? number_format($r['price'],0,',','.') : '-' ?></td>
                        <td>
                            <form method="post" onsubmit="return confirm('Hapus produk ini?')">
                                <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                <button class="btn" name="delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script AOS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
AOS.init({
    duration: 800,          // Durasi animasi
    easing: 'ease-in-out',  // Efek transisi
    once: true              // Animasi hanya sekali saat muncul
});
</script>

<?php include '_bottom.php'; ?>
</body>
</html>

