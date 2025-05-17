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

// Fungsi upload file
function uploadFoto($fieldName) {
    if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] == UPLOAD_ERR_OK) {
        $filename = time() . '_' . basename($_FILES[$fieldName]['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $filename;

        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        move_uploaded_file($_FILES[$fieldName]["tmp_name"], $targetFile);

        return $filename;
    }
    return null;
}

// Fungsi slugify (judul => slug-url)
function slugify($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

// Create
if (isset($_POST["addArticle"])) {
    $kategori = $_POST["kategori"];
    $judul = $_POST["judul"];
    $informasi = $_POST["informasi"];
    $tanggal_input = $_POST["tanggal_input"];
    $foto = uploadFoto("foto");
    $slug = slugify($judul);

    $stmt = mysqli_prepare($link, "INSERT INTO artikelfix (kategori, judul, informasi, tanggal_input, foto, slug) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssss", $kategori, $judul, $informasi, $tanggal_input, $foto, $slug);
    mysqli_stmt_execute($stmt);
    header("Location: indexartikelfix.php");
    exit;
}

// Delete
if (isset($_POST["deleteArticle"])) {
    $id = $_POST["id"];
    mysqli_query($link, "DELETE FROM artikelfix WHERE id=$id");
    header("Location: indexartikelfix.php");
    exit;
}

// Update
if (isset($_POST["editArticle"])) {
    $id = $_POST["id"];
    $kategori = $_POST["kategori"];
    $judul = $_POST["judul"];
    $informasi = $_POST["informasi"];
    $tanggal_input = $_POST["tanggal_input"];
    $slug = slugify($judul);

    $foto = uploadFoto("foto");
    if ($foto) {
        $query = "UPDATE artikelfix SET kategori=?, judul=?, informasi=?, tanggal_input=?, foto=?, slug=? WHERE id=?";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, "ssssssi", $kategori, $judul, $informasi, $tanggal_input, $foto, $slug, $id);
    } else {
        $query = "UPDATE artikelfix SET kategori=?, judul=?, informasi=?, tanggal_input=?, slug=? WHERE id=?";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, "sssssi", $kategori, $judul, $informasi, $tanggal_input, $slug, $id);
    }

    mysqli_stmt_execute($stmt);
    header("Location: indexartikelfix.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Informasi Artikel</title>
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
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f5f6fa;
      margin: 0;
    }

    .sidebar {
      height: 100vh;
      background-color: #800040;
      padding-top: 1rem;
      color: white;
      position: fixed;
      width: 240px;
      top: 0;
      left: 0;
      transition: 0.3s ease;
      z-index: 1050;
    }

    .sidebar h4 {
      text-align: center;
      font-weight: bold;
      margin-bottom: 2rem;
    }

    .sidebar a {
      color: #cbd3da;
      padding: 12px 20px;
      display: block;
      text-decoration: none;
      transition: 0.3s;
    }

    .sidebar a:hover,
    .sidebar a.bg-primary {
      background-color: #0d6efd;
      color: white;
    }

    .content {
      margin-left: 240px;
      padding: 2rem;
      transition: 0.3s ease;
    }

    .mobile-header {
      display: none;
      width: 100%;
      position: sticky;
      top: 0;
      background-color: white;
      z-index: 1049;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .mobile-header .mobile-toggle {
      display: inline-block;
      background-color: #0d6efd;
      color: white;
      border: none;
      padding: 10px 15px;
      font-size: 20px;
      border-radius: 5px;
      margin: 0.75rem 1rem;
    }

    .close-sidebar {
      display: none;
    }

    @media (max-width: 768px) {
      .mobile-header {
        display: block;
      }

      .sidebar {
        transform: translateX(-100%);
        position: fixed;
        top: 0;
        left: 0;
        width: 240px;
        height: 100vh;
        background-color: #800040;
        z-index: 1050;
        transition: transform 0.3s ease;
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .content {
        margin-left: 0;
        padding-top: 1rem;
        padding-left: 1rem;
        padding-right: 1rem;
      }

      .close-sidebar {
        display: block;
        text-align: right;
        padding: 0.5rem 1rem;
        font-size: 2rem;
        cursor: pointer;
        color: #fff;
      }
    }

    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    table {
      min-width: 800px;
    }
  </style>
</head>

<body class="bg-light">
  <?php
  $limit = 5;
  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $start = ($page > 1) ? ($page * $limit) - $limit : 0;

  $query = "SELECT * FROM artikelfix ORDER BY tanggal_input DESC LIMIT $start, $limit";
  $result = mysqli_query($link, $query);

  $totalResult = mysqli_query($link, "SELECT COUNT(*) AS total FROM artikelfix");
  $totalRow = mysqli_fetch_assoc($totalResult);
  $totalPages = ceil($totalRow['total'] / $limit);
  ?>

<div class="d-md-none p-2 bg-white shadow-sm">
    <button class="btn btn-outline-dark mobile-toggle" onclick="toggleSidebar()">
        <i class="bi bi-list"></i> Menu
    </button>
</div>

  <div class="d-flex">
    <div class="sidebar" id="sidebar">
      <div class="close-sidebar d-md-none" onclick="toggleSidebar()">×</div>
      <h4>Admin Himpunan</h4>
      <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
      <a href="inputvisimisi.php"><i class="bi bi-bullseye"></i> Visi Misi</a>
      <a href="indexkabinet.php"><i class="bi bi-people-fill"></i> Profil Kabinet</a>
      <a href="indexevents.php"><i class="bi bi-calendar-event"></i> Our Events</a>
        <a href="indexeventhimpunan.php"><i class="bi bi-calendar2-event"></i> Event Himpunan</a>
      <a href="indexdivisi.php"><i class="bi bi-diagram-3-fill"></i> Divisi Himpunan</a>
      <a href="indexgallery.php"><i class="bi bi-images"></i> Gallery of Events</a>
      <a href="indexachievement.php"><i class="bi bi-award-fill"></i> Pencapaian</a>
      <a href="indexartikelfix.php" class="bg-primary"><i class="bi bi-journal-text"></i> Informasi Artikel</a>
      <a href="logout.php" style="color: #ff9999;"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <div class="container-fluid content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Informasi Artikel</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Artikel</button>
        </div>

        <?php
        if ($result && mysqli_num_rows($result) > 0) {
          echo "<div class='table-responsive'>";
          echo "<table class='table table-bordered table-striped'>";
          echo "<thead class='table-dark'><tr><th>Kategori</th><th>Judul</th><th>Informasi</th><th>Tanggal</th><th>Foto</th><th>Aksi</th></tr></thead><tbody>";
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['kategori']}</td>";
            echo "<td>{$row['judul']}</td>";
            echo "<td>{$row['informasi']}</td>";
            echo "<td>{$row['tanggal_input']}</td>";
            echo "<td>";
            if ($row['foto']) {
              echo "<img src='uploads/{$row['foto']}' width='80' class='img-thumbnail'>";
            } else {
              echo "—";
            }
            echo "</td>";
            echo "<td>
                    <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-id='{$row['id']}'>Hapus</button>
                    <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#editModal{$row['id']}'>Edit</button>
                  </td>";
            echo "</tr>";
          }
          echo "</tbody></table></div>";
        } else {
          echo "<div class='alert alert-warning'>Belum ada artikel yang ditambahkan.</div>";
        }
        ?>

        <?php if ($totalPages > 1): ?>
          <nav>
            <ul class="pagination justify-content-center mt-4">
              <?php if ($page > 1): ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">&laquo;</a></li>
              <?php endif; ?>
              <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
                  <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
              <?php endfor; ?>
              <?php if ($page < $totalPages): ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">&raquo;</a></li>
              <?php endif; ?>
            </ul>
          </nav>
        <?php endif; ?>
      </div>
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


<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Tambah Artikel</h5></div>
                <div class="modal-body">
                    <div class="mb-3"><label>Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <option value="Lomba">Lomba</option>
                            <option value="After Events">After Events</option>
                            <option value="Prestasi">Prestasi</option>
                            <option value="Dana Usaha">Dana Usaha</option>
                        </select>
                    </div>
                    <div class="mb-3"><label>Judul</label><input type="text" name="judul" class="form-control" required></div>
                    <div class="mb-3"><label>Informasi</label><textarea name="informasi" class="form-control rich-text" required></textarea></div>
                    <div class="mb-3"><label>Tanggal Input</label><input type="date" name="tanggal_input" class="form-control" required></div>
                    <div class="mb-3"><label>Foto</label><input type="file" name="foto" class="form-control"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="addArticle" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post">
            <input type="hidden" name="id" id="delete-id">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Konfirmasi Hapus</h5></div>
                <div class="modal-body">Yakin ingin menghapus artikel ini?</div>
                <div class="modal-footer">
                    <button type="submit" name="deleteArticle" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<?php
mysqli_data_seek($result, 0);
while ($row = mysqli_fetch_assoc($result)) {
?>
<div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Edit Artikel</h5></div>
                <div class="modal-body">
                    <div class="mb-3"><label>Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <option value="Lomba" <?= $row['kategori'] === 'Lomba' ? 'selected' : '' ?>>Lomba</option>
                            <option value="After Events" <?= $row['kategori'] === 'After Events' ? 'selected' : '' ?>>After Events</option>
                            <option value="Prestasi" <?= $row['kategori'] === 'Prestasi' ? 'selected' : '' ?>>Prestasi</option>
                            <option value="Dana Usaha" <?= $row['kategori'] === 'Dana Usaha' ? 'selected' : '' ?>>Dana Usaha</option>
                        </select>
                    </div>
                    <div class="mb-3"><label>Judul</label><input type="text" name="judul" value="<?= htmlspecialchars($row['judul']) ?>" class="form-control" required></div>
                    <div class="mb-3"><label>Informasi</label><textarea name="informasi" class="form-control rich-text" required><?= htmlspecialchars($row['informasi']) ?></textarea></div>
                    <div class="mb-3"><label>Tanggal Input</label><input type="date" name="tanggal_input" value="<?= $row['tanggal_input'] ?>" class="form-control" required></div>
                    <div class="mb-3"><label>Ganti Foto (opsional)</label><input type="file" name="foto" class="form-control"></div>
                    <?php if ($row['foto']) echo "<p><img src='uploads/{$row['foto']}' width='100'></p>"; ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="editArticle" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php } ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            document.getElementById('delete-id').value = id;
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }
</script>

</body>
</html>
