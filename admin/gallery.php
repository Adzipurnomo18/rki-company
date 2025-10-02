<?php 
include '_top.php'; 
$msg=''; 

// === PROSES FORM ===
if($_SERVER['REQUEST_METHOD']==='POST'){
    // Tambah Foto
    if(isset($_POST['add'])){
        $title = trim($_POST['title'] ?? '');
        if(!empty($_FILES['image']['name'])){
            $fn = time().'_'.preg_replace('/[^a-zA-Z0-9\.\-_]/','',$_FILES['image']['name']);
            if(move_uploaded_file($_FILES['image']['tmp_name'], __DIR__.'/../uploads/gallery/'.$fn)){
                $pdo->prepare("INSERT INTO gallery(title,image) VALUES(?,?)")->execute([$title,$fn]);
                $msg = 'Foto ditambahkan.';
            } else {
                $msg = 'Gagal upload.';
            }
        }
    }

    // Hapus Foto
    if(isset($_POST['delete'])){
        $id = (int)$_POST['id'];
        $pdo->prepare("DELETE FROM gallery WHERE id=?")->execute([$id]);
        $msg = 'Foto dihapus.';
    }
}

// === AMBIL DATA ===
$rows = $pdo->query("SELECT * FROM gallery ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Galeri</title>

  <!-- CSS Utama -->
  <link rel="stylesheet" href="../assets/css/admin.css">

  <!-- CSS AOS Animation -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
</head>
<body>

<div class="container">

    <!-- ALERT PESAN -->
    <?php if($msg): ?>
        <div class="alert" data-aos="zoom-in"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <div class="grid grid-2">
        
        <!-- FORM TAMBAH FOTO -->
        <div class="card" data-aos="flip-right">
            <h3>Tambah Foto Galeri</h3>
            <form method="post" enctype="multipart/form-data" class="form" style="margin-top:10px">
                <input class="input" name="title" placeholder="Judul (opsional)">
                <input type="file" name="image" accept="image/*" required>
                <button class="btn btn-primary" name="add">Simpan</button>
            </form>
        </div>

        <!-- DAFTAR FOTO -->
        <div class="card" data-aos="fade-left">
            <h3>Daftar Foto</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Judul</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($rows as $index => $r){
                        echo '
                        <tr data-aos="zoom-in" data-aos-delay="'.($index * 100).'">
                            <td>
                                <img src="../uploads/gallery/'.$r['image'].'" 
                                     style="width:100px;height:70px;object-fit:cover;border-radius:8px">
                            </td>
                            <td>'.htmlspecialchars($r['title'] ?? '').'</td>
                            <td>
                                <form method="post" onsubmit="return confirm(\'Hapus?\')">
                                    <input type="hidden" name="id" value="'.$r['id'].'">
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

<!-- Script AOS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
AOS.init({
    duration: 900,          // Durasi animasi
    easing: 'ease-out-back',// Efek lebih smooth
    once: true,             // Animasi hanya sekali
    mirror: false           // Tidak mengulang saat scroll balik
});
</script>

<?php include '_bottom.php'; ?>
</body>
</html>
