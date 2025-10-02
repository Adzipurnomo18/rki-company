<?php 
include '_top.php'; 
$msg=''; 

// === PROSES FORM ===
if($_SERVER['REQUEST_METHOD']==='POST'){

    // Tambah lowongan
    if(isset($_POST['add'])){
        $title = trim($_POST['title'] ?? '');
        $desc  = trim($_POST['description'] ?? '');
        if($title){
            $pdo->prepare("INSERT INTO jobs(title,description) VALUES(?,?)")->execute([$title,$desc]);
            $msg='Lowongan ditambahkan.';
        } else {
            $msg='Judul wajib diisi.';
        }
    }

    // Update lowongan
    if(isset($_POST['update'])){
        $id    = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $desc  = trim($_POST['description'] ?? '');
        if($id && $title){
            $pdo->prepare("UPDATE jobs SET title=?, description=? WHERE id=?")->execute([$title,$desc,$id]);
            $msg='Lowongan diperbarui.';
        } else {
            $msg='Gagal memperbarui: pastikan data valid.';
        }
    }

    // Hapus lowongan
    if(isset($_POST['delete'])){
        $id = (int)$_POST['id'];
        $pdo->prepare("DELETE FROM jobs WHERE id=?")->execute([$id]);
        $msg='Lowongan dihapus.';
    }
}

// === AMBIL DATA ===
$rows = $pdo->query("SELECT * FROM jobs ORDER BY id DESC")->fetchAll();
?>

<!-- CSS AOS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

<!-- Sedikit gaya tombol tambahan -->
<style>
  .btn-secondary{ background:#0ea5e9; color:#fff; border:none; padding:8px 12px; border-radius:8px; cursor:pointer }
  .btn-secondary:hover{ background:#0284c7 }
  .btn-danger{ background:#e50914; color:#fff; border:none; padding:8px 12px; border-radius:8px; cursor:pointer }
  .btn-danger:hover{ background:#c40710 }
  .btn-outline-muted{ background:transparent; border:1px solid #cbd5e1; color:#475569; padding:8px 12px; border-radius:8px; cursor:pointer }
  .btn-outline-muted:hover{ background:#f1f5f9 }
  .aksi{ display:flex; gap:8px; align-items:center; flex-wrap:wrap }
</style>

<div class="admin-bg"><!-- Background Wrapper -->
  <div class="container">

    <!-- ALERT -->
    <?php if($msg): ?>
      <div class="alert" data-aos="fade-down"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <div class="grid grid-2">
      <!-- FORM TAMBAH / EDIT -->
      <div class="card" data-aos="flip-left">
        <h3 id="formHeading">Tambah Lowongan</h3>
        <form method="post" class="form" id="jobForm" style="margin-top:10px">
          <input type="hidden" name="id" value="">
          <input class="input" name="title" placeholder="Judul posisi" required>
          <textarea class="textarea" name="description" placeholder="Deskripsi"></textarea>

          <div style="display:flex; gap:10px; align-items:center; margin-top:6px">
            <button class="btn btn-primary" name="add" id="btnAdd">Simpan</button>
            <button class="btn-secondary" name="update" id="btnUpdate" style="display:none;">Update</button>
            <button type="button" class="btn-outline-muted" id="cancelEdit" style="display:none;">Batal</button>
          </div>
        </form>
      </div>

      <!-- LIST LOWONGAN -->
      <div class="card" data-aos="fade-up">
        <h3>Daftar Lowongan</h3>
        <table class="table">
          <thead>
            <tr>
              <th>Judul</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php 
            if(!$rows){
              echo '<tr><td colspan="2" class="muted" style="text-align:center">Belum ada data</td></tr>';
            }
            foreach($rows as $index => $r){
              // untuk data-attribute gunakan ENT_QUOTES agar aman
              $t = htmlspecialchars($r['title'], ENT_QUOTES);
              $d = htmlspecialchars($r['description'], ENT_QUOTES);
              echo '
              <tr data-aos="zoom-in" data-aos-delay="'.($index * 120).'">
                <td>'.htmlspecialchars($r['title']).'</td>
                <td>
                  <div class="aksi">
                    <button type="button" 
                            class="btn-secondary btn-edit"
                            data-id="'.$r['id'].'"
                            data-title="'.$t.'"
                            data-desc="'.$d.'">Edit</button>

                    <form method="post" onsubmit="return confirm(\'Hapus lowongan ini?\')">
                      <input type="hidden" name="id" value="'.$r['id'].'">
                      <button class="btn-danger" name="delete">Hapus</button>
                    </form>
                  </div>
                </td>
              </tr>';
            } 
          ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div><!-- END Background Wrapper -->

<!-- AOS + JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
AOS.init({ duration: 900, easing: 'ease-in-out-back', once: true, mirror: false });

// ====== Mode Edit (aman tanpa inline-JS) ======
const form      = document.getElementById('jobForm');
const heading   = document.getElementById('formHeading');
const btnAdd    = document.getElementById('btnAdd');
const btnUpdate = document.getElementById('btnUpdate');
const btnCancel = document.getElementById('cancelEdit');

const fldId    = form.querySelector('input[name="id"]');
const fldTitle = form.querySelector('input[name="title"]');
const fldDesc  = form.querySelector('textarea[name="description"]');

function enterEdit(id, title, desc){
  fldId.value    = id;
  fldTitle.value = title;
  fldDesc.value  = desc;

  heading.textContent     = 'Edit Lowongan';
  btnAdd.style.display    = 'none';
  btnUpdate.style.display = 'inline-block';
  btnCancel.style.display = 'inline-block';

  fldTitle.focus();
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function exitEdit(){
  form.reset();
  fldId.value = '';
  heading.textContent     = 'Tambah Lowongan';
  btnAdd.style.display    = 'inline-block';
  btnUpdate.style.display = 'none';
  btnCancel.style.display = 'none';
}

// Klik tombol edit (pakai data-attribute -> aman dari kutip / baris baru)
document.querySelectorAll('.btn-edit').forEach(btn => {
  btn.addEventListener('click', () => {
    enterEdit(btn.dataset.id, btn.dataset.title, btn.dataset.desc);
  });
});

btnCancel.addEventListener('click', exitEdit);
</script>

<?php include '_bottom.php'; ?>
