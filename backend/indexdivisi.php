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
// CREATE
if (isset($_POST["addDivisi"])) {
    $nama = $_POST["nama_divisi"];
    $deskripsi = $_POST["deskripsi"];
    $program_kerja = $_POST["program_kerja"];
    $fotoName = $_FILES["foto"]["name"];
    $fotoTmp = $_FILES["foto"]["tmp_name"];
    move_uploaded_file($fotoTmp, "uploads/" . $fotoName);

    $query = "INSERT INTO divisi (foto, nama_divisi, deskripsi, program_kerja) VALUES ('$fotoName', '$nama', '$deskripsi', '$program_kerja')";
    mysqli_query($link, $query);
    header("Location: indexdivisi.php");
    exit;
}

// DELETE
if (isset($_POST["deleteDivisi"])) {
    $id = $_POST["id"];
    $query = "DELETE FROM divisi WHERE id=$id";
    mysqli_query($link, $query);
    header("Location: indexdivisi.php");
    exit;
}

// UPDATE
if (isset($_POST["editDivisi"])) {
    $id = $_POST["id"];
    $nama = $_POST["nama_divisi"];
    $deskripsi = $_POST["deskripsi"];
    $program_kerja = $_POST["program_kerja"];

    if (!empty($_FILES["foto"]["name"])) {
        $fotoName = $_FILES["foto"]["name"];
        $fotoTmp = $_FILES["foto"]["tmp_name"];
        move_uploaded_file($fotoTmp, "uploads/" . $fotoName);
        $query = "UPDATE divisi SET nama_divisi='$nama', deskripsi='$deskripsi', program_kerja='$program_kerja', foto='$fotoName' WHERE id=$id";
    } else {
        $query = "UPDATE divisi SET nama_divisi='$nama', deskripsi='$deskripsi', program_kerja='$program_kerja' WHERE id=$id";
    }

    mysqli_query($link, $query);
    header("Location: indexdivisi.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Divisi Himpunan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .foto-divisi {
            width: 80px;
            height: auto;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        .sidebar {
            height: 100vh;
            background-color:#800040;
            padding-top: 1rem;
            color: white;
            position: fixed;
            width: 240px;
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
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .modal-header {
            background-color: #0d6efd;
            color: white;
        }
        body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f5f6fa;
    margin: 0;
    padding: 0;
}
.sidebar {
    z-index: 1050;
    transition: transform 0.3s ease-in-out;
}
.close-sidebar {
    display: none;
}
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        position: fixed;
        top: 0;
        left: 0;
    }
    .sidebar.show {
        transform: translateX(0);
    }
    .content {
        margin-left: 0;
    }
    
    .mobile-toggle {
        display: inline-block;
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

    </style>
</head>
<body>

<!-- Toggle Button (Mobile Only) -->
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
<a href="indexdivisi.php" class="bg-primary"><i class="bi bi-diagram-3-fill"></i> Divisi Himpunan</a>
<a href="indexgallery.php"><i class="bi bi-images"></i> Gallery of Events</a>
<a href="indexachievement.php"><i class="bi bi-award-fill"></i> Pencapaian</a>
<a href="indexartikelfix.php"><i class="bi bi-journal-text"></i> Informasi Artikel</a>
<a href="logout.php" style="color: #ff9999;">
  <i class="bi bi-box-arrow-right"></i> Logout
</a>
    </div>

    <div class="container-fluid content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Divisi Himpunan</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Divisi</button>
        </div>



        <?php
        $sql = "SELECT * FROM divisi";
        $result = mysqli_query($link, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered table-striped'>";
            echo "<thead class='table-dark'><tr><th>Foto</th><th>Nama Divisi</th><th>Deskripsi</th><th>Program Kerja</th><th>Pengaturan</th></tr></thead><tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><img src='uploads/{$row['foto']}' class='foto-divisi'></td>";
                echo "<td>{$row['nama_divisi']}</td>";
                echo "<td>{$row['deskripsi']}</td>";
                echo "<td>";
                $programs = preg_split("/\r\n|\n|\r/", $row['program_kerja']);

                foreach ($programs as $prog) {
                    echo "<div class='border p-2 mb-1 rounded bg-light'>{$prog}</div>";
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
            echo "<div class='alert alert-warning'>Belum ada divisi yang ditambahkan.</div>";
        }
        ?>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Tambah Divisi</h5></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Foto</label><input type="file" name="foto" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Nama Divisi</label><input type="text" name="nama_divisi" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control" required></textarea></div>
                    <div class="mb-3"><label class="form-label">Program Kerja (pisahkan dengan enter)</label><textarea name="program_kerja" class="form-control" required></textarea></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="addDivisi" class="btn btn-success">Simpan</button>
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
                <div class="modal-body"><p>Yakin ingin menghapus divisi ini?</p></div>
                <div class="modal-footer">
                    <button type="submit" name="deleteDivisi" class="btn btn-danger">Hapus</button>
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
                <div class="modal-header"><h5 class="modal-title">Edit Divisi</h5></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Foto (biarkan kosong jika tidak diubah)</label><input type="file" name="foto" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Nama Divisi</label><input type="text" name="nama_divisi" class="form-control" value="<?= htmlspecialchars($row['nama_divisi']) ?>" required></div>
                    <div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control" required><?= htmlspecialchars($row['deskripsi']) ?></textarea></div>
                    <div class="mb-3"><label class="form-label">Program Kerja</label><textarea name="program_kerja" class="form-control" required><?= htmlspecialchars($row['program_kerja']) ?></textarea></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="editDivisi" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php } ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var inputId = deleteModal.querySelector('#delete-id');
        inputId.value = id;
    });
});

// Fungsi ini harus berada di luar agar bisa dipanggil dari tombol
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('show');
}
</script>
</body>
</html>
