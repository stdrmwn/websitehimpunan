<?php
session_start(); // Mulai sesi
include 'db.php'; // Koneksi database

// Cek apakah session user_id sudah ada (login)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Jika belum login, arahkan ke halaman login
    exit;
}

// Menghubungkan config4.php
require_once "config4.php"; 


// Fungsi untuk buat slug dari string nama event
function generateSlug($string) {
    // ubah ke lowercase, hapus karakter yang bukan alphanumeric atau spasi, ganti spasi jadi tanda strip (-)
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    return rtrim($slug, '-');
}

// Fungsi untuk memastikan slug unik di database
function getUniqueSlug($link, $baseSlug) {
    $slug = $baseSlug;
    $i = 1;

    // cek apakah slug sudah ada
    $stmt = $link->prepare("SELECT COUNT(*) FROM eventshimpunan WHERE slug = ?");
    $stmt->bind_param("s", $slug);

    while(true) {
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();

        if ($count == 0) {
            break; // slug belum dipakai, kita pakai ini
        }
        // slug sudah ada, tambahkan angka di belakang
        $slug = $baseSlug . '-' . $i;
        $i++;
    }
    $stmt->close();

    return $slug;
}

// Tambah Event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {
    $nama = $_POST['nama_event'];
    $deskripsi = $_POST['deskripsi_event'];
    $tanggal = $_POST['tanggal_event'];
    $kategori = $_POST['kategori_event'];
    $linkTerkait = $_POST['link_terkait'];

    $foto = '';
    if (isset($_FILES['foto_event']) && $_FILES['foto_event']['error'] == 0) {
        $foto = time() . '_' . basename($_FILES['foto_event']['name']);
        move_uploaded_file($_FILES['foto_event']['tmp_name'], 'uploads/' . $foto);
    }

    // buat slug unik dari nama event
    $baseSlug = generateSlug($nama);
    $slug = getUniqueSlug($link, $baseSlug);

    $stmt = $link->prepare("INSERT INTO eventshimpunan (nama_event, deskripsi_event, tanggal_event, kategori_event, foto_event, link_terkait, slug) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nama, $deskripsi, $tanggal, $kategori, $foto, $linkTerkait, $slug);
    $stmt->execute();
    $stmt->close();

    header("Location: indexeventhimpunan.php");
    exit;
}

// Edit Event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'edit') {
    $id = $_POST['id'];
    $nama = $_POST['nama_event'];
    $deskripsi = $_POST['deskripsi_event'];
    $tanggal = $_POST['tanggal_event'];
    $kategori = $_POST['kategori_event'];
    $linkTerkait = $_POST['link_terkait'];

    // buat slug baru dari nama event (misal kalau nama diganti)
    $baseSlug = generateSlug($nama);

    // Untuk edit, kita harus cek slug unik tapi kecuali record yang ini sendiri (id yang diedit)
    function getUniqueSlugEdit($link, $baseSlug, $id) {
        $slug = $baseSlug;
        $i = 1;

        $stmt = $link->prepare("SELECT COUNT(*) FROM eventshimpunan WHERE slug = ? AND id != ?");
        $stmt->bind_param("si", $slug, $id);

        while(true) {
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();

            if ($count == 0) {
                break;
            }
            $slug = $baseSlug . '-' . $i;
            $i++;
        }
        $stmt->close();

        return $slug;
    }

    $slug = getUniqueSlugEdit($link, $baseSlug, $id);

    if (isset($_FILES['foto_event']) && $_FILES['foto_event']['error'] == 0) {
        $foto = time() . '_' . basename($_FILES['foto_event']['name']);
        move_uploaded_file($_FILES['foto_event']['tmp_name'], 'uploads/' . $foto);

        $stmt = $link->prepare("UPDATE eventshimpunan SET nama_event=?, deskripsi_event=?, tanggal_event=?, kategori_event=?, foto_event=?, link_terkait=?, slug=? WHERE id=?");
        $stmt->bind_param("sssssssi", $nama, $deskripsi, $tanggal, $kategori, $foto, $linkTerkait, $slug, $id);
    } else {
        $stmt = $link->prepare("UPDATE eventshimpunan SET nama_event=?, deskripsi_event=?, tanggal_event=?, kategori_event=?, link_terkait=?, slug=? WHERE id=?");
        $stmt->bind_param("ssssssi", $nama, $deskripsi, $tanggal, $kategori, $linkTerkait, $slug, $id);
    }

    $stmt->execute();
    $stmt->close();

    header("Location: indexeventhimpunan.php");
    exit;
}

// Delete Event
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $link->prepare("DELETE FROM eventshimpunan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: indexeventhimpunan.php");
    exit;
}

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

$query = "SELECT * FROM eventshimpunan ORDER BY tanggal_event DESC LIMIT $start, $limit";
$result = mysqli_query($link, $query);

$totalResult = mysqli_query($link, "SELECT COUNT(*) AS total FROM eventshimpunan");
$totalRow = mysqli_fetch_assoc($totalResult);
$totalPages = ceil($totalRow['total'] / $limit);
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Events Himpunan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script>
    tinymce.init({
      selector: 'textarea.rich-text',
      height: 400,
      menubar: false,
      plugins: ['link', 'textcolor', 'lists', 'code', 'fullscreen', 'preview', 'wordcount'],
      toolbar: 'undo redo | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | link unlink | removeformat | code fullscreen preview',
      toolbar_mode: 'sliding',
      branding: false,
      content_style: 'body { font-family:Arial,sans-serif; font-size:14px }',
      setup: function (editor) {
        editor.on('change', function () {
          editor.save();
        });
      }
    });
  </script>
  <style>
    body { font-family: 'Segoe UI', sans-serif; background-color: #f5f6fa; margin: 0; }
    .sidebar { height: 100vh; background-color: #800040; padding-top: 1rem; color: white; position: fixed; width: 240px; top: 0; left: 0; transition: 0.3s ease; z-index: 1050; }
    .sidebar h4 { text-align: center; font-weight: bold; margin-bottom: 2rem; }
    .sidebar a { color: #cbd3da; padding: 12px 20px; display: block; text-decoration: none; transition: 0.3s; }
    .sidebar a:hover, .sidebar a.bg-primary { background-color: #0d6efd; color: white; }
    .content { margin-left: 240px; padding: 2rem; transition: 0.3s ease; }
    .mobile-header { display: none; width: 100%; position: sticky; top: 0; background-color: white; z-index: 1049; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
    .mobile-header .mobile-toggle { background-color: #0d6efd; color: white; border: none; padding: 10px 15px; font-size: 20px; border-radius: 5px; margin: 0.75rem 1rem; }
    .close-sidebar { display: none; }
      .modal-content {
    background-color: #ffffff !important;
  }
    @media (max-width: 768px) {
      .mobile-header { display: block; }
      .sidebar { transform: translateX(-100%); }
      .sidebar.show { transform: translateX(0); }
      .content { margin-left: 0; padding: 1rem; }
      .close-sidebar { display: block; text-align: right; padding: 0.5rem 1rem; font-size: 2rem; cursor: pointer; color: #fff; }
    }
    table { min-width: 800px; }
  </style>
</head>
<body class="bg-light">

<div class="mobile-header d-md-none">
  <button class="mobile-toggle" onclick="toggleSidebar()">
    <i class="bi bi-list"></i> Menu
  </button>
</div>

<div class="d-flex">
  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="close-sidebar d-md-none" onclick="toggleSidebar()">×</div>
   <h4>Admin Himpunan</h4>
  <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
  <a href="inputvisimisi.php"><i class="bi bi-bullseye"></i> Visi Misi</a>
  <a href="indexkabinet.php"><i class="bi bi-people-fill"></i> Profil Kabinet</a>
  <a href="indexevents.php"><i class="bi bi-calendar-event"></i> Our Events</a>
  <a href="indexeventhimpunan.php" class="bg-primary"><i class="bi bi-calendar2-event"></i> Event Himpunan</a>
  <a href="indexdivisi.php"><i class="bi bi-diagram-3-fill"></i> Divisi Himpunan</a>
  <a href="indexgallery.php"><i class="bi bi-images"></i> Gallery of Events</a>
  <a href="indexachievement.php"><i class="bi bi-award-fill"></i> Pencapaian</a>
  <a href="indexartikelfix.php"><i class="bi bi-journal-text"></i> Informasi Artikel</a>
          <a href="inputhistory.php"><i class="bi bi-clock-history"></i> Our History</a>
  <a href="logout.php" style="color: #ff9999;"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>
 <!-- Main Content -->
<div class="content container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
    <h2 class="fw-bold mb-2">Daftar Events Himpunan</h2>
    <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Event</button>
  </div>

  <?php if ($result && mysqli_num_rows($result) > 0) { ?>
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-dark">
        <tr>
          <th>Foto</th>
          <th>Nama Event</th>
          <th>Kategori Event</th>
          <th>Deskripsi</th>
          <th>Tanggal</th>
          <th>Link</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td>
            <?php if ($row['foto_event']) { ?>
              <img src="uploads/<?= htmlspecialchars($row['foto_event']) ?>" alt="Foto Event" width="80" class="rounded">
            <?php } else { echo "—"; } ?>
          </td>
          <td><?= htmlspecialchars($row['nama_event']) ?></td>
          <td><?= htmlspecialchars($row['kategori_event']) ?></td>
<td style="max-width: 300px; white-space: pre-wrap;">
  <?= nl2br(htmlspecialchars(strip_tags($row['deskripsi_event']))) ?>
</td>

          <td><?= htmlspecialchars($row['tanggal_event']) ?></td>
          <td>
            <?php if ($row['link_terkait']) { ?>
              <a href="<?= htmlspecialchars($row['link_terkait']) ?>" target="_blank" class="btn btn-sm btn-info">Lihat Link</a>
            <?php } else { echo "—"; } ?>
          </td>
          <td>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row['id'] ?>">Hapus</button>
          </td>
        </tr>

<style>
  /* Pastikan modal tidak transparan */
  .modal-content {
    background-color: #ffffff !important;
  }
</style>

<!-- Modal Edit -->
<div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id'] ?>" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">

        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel<?= $row['id'] ?>">Edit Event</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_event_<?= $row['id'] ?>" class="form-label">Nama Event</label>
            <input type="text" id="nama_event_<?= $row['id'] ?>" name="nama_event" class="form-control" value="<?= htmlspecialchars($row['nama_event']) ?>" required>
          </div>
          <div class="mb-3">
            <label for="deskripsi_event_<?= $row['id'] ?>" class="form-label">Deskripsi</label>
            <textarea id="deskripsi_event_<?= $row['id'] ?>" name="deskripsi_event" class="form-control rich-text" rows="5" required><?= htmlspecialchars($row['deskripsi_event']) ?></textarea>
          </div>
          <div class="mb-3">
            <label for="tanggal_event_<?= $row['id'] ?>" class="form-label">Tanggal</label>
            <input type="date" id="tanggal_event_<?= $row['id'] ?>" name="tanggal_event" class="form-control" value="<?= $row['tanggal_event'] ?>" required>
          </div>
          <div class="mb-3">
            <label for="kategori_event_<?= $row['id'] ?>" class="form-label">Kategori</label>
            <select id="kategori_event_<?= $row['id'] ?>" name="kategori_event" class="form-select" required>
              <option value="PKKMB" <?= $row['kategori_event'] === 'PKKMB' ? 'selected' : '' ?>>PKKMB</option>
              <option value="LOMBA" <?= $row['kategori_event'] === 'LOMBA' ? 'selected' : '' ?>>LOMBA</option>
              <option value="AKADEMIK" <?= $row['kategori_event'] === 'AKADEMIK' ? 'selected' : '' ?>>AKADEMIK</option>
              <option value="DANA USAHA" <?= $row['kategori_event'] === 'DANA USAHA' ? 'selected' : '' ?>>DANA USAHA</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="foto_event_<?= $row['id'] ?>" class="form-label">Upload Foto (kosongkan jika tidak diubah)</label>
            <input type="file" id="foto_event_<?= $row['id'] ?>" name="foto_event" class="form-control">
          </div>
          <div class="mb-3">
            <label for="link_terkait_<?= $row['id'] ?>" class="form-label">Link Terkait</label>
            <input type="url" id="link_terkait_<?= $row['id'] ?>" name="link_terkait" class="form-control" value="<?= htmlspecialchars($row['link_terkait']) ?>">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>


              <!-- Modal Konfirmasi Hapus -->
              <div class="modal fade" id="deleteModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Konfirmasi Hapus</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      Apakah Anda yakin ingin menghapus event <strong><?= htmlspecialchars($row['nama_event']) ?></strong>?
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger">Ya, Hapus</a>
                    </div>
                  </div>
                </div>
              </div>

            <?php } ?>
          </tbody>
        </table>
      </div>
    <?php } else { ?>
      <p>Tidak ada data event tersedia.</p>
    <?php } ?>
  </div>
</div>

<!-- Modal Tambah Event -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="action" value="add">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Event Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label>Nama Event</label>
          <input type="text" name="nama_event" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Deskripsi</label>
          <textarea name="deskripsi_event" class="form-control rich-text" rows="5" required></textarea>
        </div>
        <div class="mb-3">
          <label>Tanggal</label>
          <input type="date" name="tanggal_event" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Kategori</label>
          <select name="kategori_event" class="form-select" required>
            <option value="PKKMB">PKKMB</option>
            <option value="LOMBA">LOMBA</option>
            <option value="AKADEMIK">AKADEMIK</option>
            <option value="DANA USAHA">DANA USAHA</option>
          </select>
        </div>
        <div class="mb-3">
          <label>Upload Foto</label>
          <input type="file" name="foto_event" class="form-control">
        </div>
        <div class="mb-3">
          <label>Link Terkait</label>
          <input type="url" name="link_terkait" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
  function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
