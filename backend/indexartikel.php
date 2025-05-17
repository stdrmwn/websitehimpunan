<?php
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

// Create
if (isset($_POST["addArticle"])) {
    $kategori = $_POST["kategori"];
    $judul = $_POST["judul"];
    $informasi = $_POST["informasi"];
    $tanggal_input = $_POST["tanggal_input"];
    $foto = uploadFoto("foto");

    $stmt = mysqli_prepare($link, "INSERT INTO artikel (kategori, judul, informasi, tanggal_input, foto) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssss", $kategori, $judul, $informasi, $tanggal_input, $foto);
    mysqli_stmt_execute($stmt);
    header("Location: indexartikel.php");
    exit;
}

// Delete
if (isset($_POST["deleteArticle"])) {
    $id = $_POST["id"];
    mysqli_query($link, "DELETE FROM artikel WHERE id=$id");
    header("Location: indexartikel.php");
    exit;
}

// Update
if (isset($_POST["editArticle"])) {
    $id = $_POST["id"];
    $kategori = $_POST["kategori"];
    $judul = $_POST["judul"];
    $informasi = $_POST["informasi"];
    $tanggal_input = $_POST["tanggal_input"];

    $foto = uploadFoto("foto");
    if ($foto) {
        $query = "UPDATE artikel SET kategori=?, judul=?, informasi=?, tanggal_input=?, foto=? WHERE id=?";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, "sssssi", $kategori, $judul, $informasi, $tanggal_input, $foto, $id);
    } else {
        $query = "UPDATE artikel SET kategori=?, judul=?, informasi=?, tanggal_input=? WHERE id=?";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, "ssssi", $kategori, $judul, $informasi, $tanggal_input, $id);
    }

    mysqli_stmt_execute($stmt);
    header("Location: indexartikel.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
    <!-- Tambahkan ini di atas </head> halaman kamu -->
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js"></script>
<script>
  tinymce.init({
    selector: 'textarea.rich-text',
    menubar: false,
    plugins: 'advlist autolink lists link charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime table help wordcount',
    toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | removeformat | help',
    height: 300,
    setup: function (editor) {
      editor.on('change', function () {
        editor.save(); // << Ini penting!
      });
    }
  });
</script>

<head>
    <meta charset="UTF-8">
    <title>Informasi Artikel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Informasi Artikel</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Artikel</button>
    </div>

    <?php
    $result = mysqli_query($link, "SELECT * FROM artikel ORDER BY tanggal_input DESC");
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead class='table-dark'><tr><th>ID</th><th>Kategori</th><th>Judul</th><th>Informasi</th><th>Tanggal</th><th>Foto</th><th>Aksi</th></tr></thead><tbody>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
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

</div>

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
</body>
</html>
