<?php 
include '_top.php'; 

// =============================
// 1. Logic Hapus Pesan
// =============================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = (int)$_POST['delete_id'];
    $pdo->prepare("DELETE FROM messages WHERE id = ?")->execute([$delete_id]);

    // Setelah pesan dihapus, tampilkan alert lalu refresh halaman
    echo "<script>alert('Pesan berhasil dihapus!'); window.location.href='messages.php';</script>";
    exit;
}

// =============================
// 2. Ambil data pesan dari database
// =============================
$rows = $pdo->query("SELECT * FROM messages ORDER BY id DESC")->fetchAll();
?>

<!-- Tambahkan CSS di file ini -->
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
        margin: 5px auto; /* Jarak agar tidak terlalu rapat dengan menu */
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
    }

    .table th {
        font-weight: bold;
    }

    /* Hover efek */
    .table tbody tr:hover {
        background: #f9f9f9;
        transition: background 0.3s ease;
    }

    /* Tombol hapus */
    .btn-delete {
        padding: 6px 12px;
        background: #e50914;
        color: #fff;
        font-size: 0.85rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .btn-delete:hover {
        background: #c40710;
    }
</style>

<!-- AOS Animation Library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

<div class="card" data-aos="flip-up">
    <h3 data-aos="fade-zoom-in" data-aos-delay="100">Pesan Kontak</h3>
    
    <table class="table" data-aos="fade-up" data-aos-delay="200">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>HP</th>
                <th>Pesan</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (!$rows) {
                echo '<tr data-aos="fade-in">
                        <td colspan="6" style="text-align:center;color:#888;">
                            Belum ada pesan masuk
                        </td>
                      </tr>';
            } else {
                foreach($rows as $index => $r){
                    echo '
                    <tr data-aos="fade-up" data-aos-delay="'.($index * 120).'">
                        <td>'.htmlspecialchars($r['name']).'</td>
                        <td>'.htmlspecialchars($r['email']).'</td>
                        <td>'.htmlspecialchars($r['phone']).'</td>
                        <td>'.nl2br(htmlspecialchars($r['message'])).'</td>
                        <td>'.$r['created_at'].'</td>
                        <td>
                            <form method="post" onsubmit="return confirm(\'Yakin ingin menghapus pesan ini?\');">
                                <input type="hidden" name="delete_id" value="'.$r['id'].'">
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
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
    duration: 1000,              
    easing: 'ease-in-out-quart', 
    once: true,                   
    mirror: false                 
});
</script>

<?php include '_bottom.php'; ?>
