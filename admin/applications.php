<?php 
include '_top.php'; 

// =============================
// 1) Hapus lamaran (opsional: hapus file CV juga)
// =============================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = (int)$_POST['delete_id'];

    // (Opsional) Jika ingin ikut menghapus file CV dari server,
    // ambil dulu nama file CV lalu unlink.
    $cvRow = $pdo->prepare("SELECT cv_file FROM applications WHERE id=?");
    $cvRow->execute([$delete_id]);
    if ($cv = $cvRow->fetch()) {
         $file = __DIR__ . '/../uploads/cv/' . $cv['cv_file'];
         if (is_file($file)) @unlink($file);
     }

    $pdo->prepare("DELETE FROM applications WHERE id = ?")->execute([$delete_id]);
    echo "<script>alert('Lamaran berhasil dihapus!'); window.location.href='applications.php';</script>";
    exit;
}

// =============================
// 2) Ambil data lamaran
// =============================
$rows = $pdo->query("SELECT * FROM applications ORDER BY id DESC")->fetchAll();
?>

<!-- CSS Langsung di File -->
<style>
    /* ===== Background halaman tanpa blur ===== */
    body {
        background: url('https://cdn.pixabay.com/photo/2020/11/12/16/58/worker-5736096_1280.jpg') 
                    no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
    }

    /* Card utama */
    .card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        padding: 20px;
        max-width: 1200px;
        margin: 5px auto; /* jarak card dari menu */
    }

    /* Judul */
    .card h3 {
        margin-bottom: 20px;
        font-size: 22px;
        color: #333;
    }

    /* ===== Tabel ===== */
    .table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
    }

    .table thead {
        background: #f5f5f5;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        vertical-align: middle;
    }

    .table th {
        font-weight: bold;
    }

    /* Hover animasi baris */
    .table tbody tr:hover {
        background: #f9f9f9;
        transition: background 0.3s ease;
    }

    /* Tombol Lihat CV */
    .btn-view-cv {
        display: inline-block;
        padding: 6px 12px;
        background: #d32f2f;
        color: #fff;
        font-size: 0.9em;
        text-decoration: none;
        border-radius: 6px;
        transition: background 0.3s ease;
    }
    .btn-view-cv:hover { background: #b71c1c; }

    /* Tombol Hapus */
    .btn-delete {
        padding: 6px 12px;
        background: #e50914;
        color: #fff;
        font-size: 0.85rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.25s ease;
    }
    .btn-delete:hover { background: #c40710; }

    .aksi-group {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }
</style>

<!-- Import CSS AOS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

<!-- Card Container -->
<div class="card" data-aos="flip-right">
    <h3 data-aos="fade-down" data-aos-delay="100">Lamaran Masuk</h3>
    
    <table class="table" data-aos="fade-up" data-aos-delay="200">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Posisi</th>
                <th>CV</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (!$rows) {
                echo '<tr data-aos="fade-in"><td colspan="6" style="text-align:center;color:#888;">Belum ada lamaran masuk</td></tr>';
            } else {
                foreach($rows as $index => $r){
                    $cv = htmlspecialchars($r['cv_file']);
                    $cvUrl = "../uploads/cv/$cv";

                    echo '
                    <tr data-aos="zoom-in" data-aos-delay="'.($index * 120).'">
                        <td>'.htmlspecialchars($r['name']).'</td>
                        <td>'.htmlspecialchars($r['email']).'</td>
                        <td>'.htmlspecialchars($r['position']).'</td>
                        <td>
                            <a href="'.$cvUrl.'" target="_blank" class="btn-view-cv">Lihat CV</a>
                        </td>
                        <td>'.$r['created_at'].'</td>
                        <td>
                            <div class="aksi-group">
                                <form method="post" onsubmit="return confirm(\'Yakin ingin menghapus lamaran ini?\');">
                                    <input type="hidden" name="delete_id" value="'.$r['id'].'">
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>';
                }
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Script AOS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
AOS.init({
    duration: 1000,              // durasi animasi
    easing: 'ease-in-out-quart', // efek transisi yang halus
    once: true,                   // animasi hanya sekali
    mirror: false                 // tidak mengulang saat scroll balik
});
</script>

<?php include '_bottom.php'; ?>
