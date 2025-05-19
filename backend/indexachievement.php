<?php
require_once "config4.php";

// Create
if (isset($_POST["addAchieve"])) {
    $pencapaian = mysqli_real_escape_string($link, $_POST["pencapaian"]);
    $angka = intval($_POST["angka"]);
    $query = "INSERT INTO achievements (pencapaian, angka) VALUES ('$pencapaian', $angka)";
    mysqli_query($link, $query);
    header("Location: indexachievement.php");
}

// Update
if (isset($_POST["updateAchieve"])) {
    $id = intval($_POST["id"]);
    $pencapaian = mysqli_real_escape_string($link, $_POST["pencapaian"]);
    $angka = intval($_POST["angka"]);
    $query = "UPDATE achievements SET pencapaian='$pencapaian', angka=$angka WHERE id=$id";
    mysqli_query($link, $query);
    header("Location: indexachievement.php");
}

// Delete
if (isset($_POST["deleteAchieve"])) {
    $id = intval($_POST["id"]);
    $query = "DELETE FROM achievements WHERE id=$id";
    mysqli_query($link, $query);
    header("Location: indexachievement.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pencapaian Himpunan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f6fa;
            margin: 0;
        }
        .sidebar {
            height: 100vh;
            background-color: #1e1e2f;
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
            width: 100%;
        }
        .mobile-header {
            display: none;
            width: 100%;
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 1049;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
                padding-top: 1rem;
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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pencapaian Himpunan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f6fa;
            margin: 0;
        }
        .sidebar {
            height: 100vh;
            background-color:#800040;
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
            width: 100%;
        }
        .mobile-header {
            display: none;
            width: 100%;
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 1049;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
                padding-top: 1rem;
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

<!-- Mobile Header -->
<div class="d-md-none p-2 bg-white shadow-sm">
    <button class="btn btn-outline-dark mobile-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i> Menu</button>
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
        <a href="indexachievement.php" class="bg-primary"><i class="bi bi-award-fill"></i> Pencapaian</a>
        <a href="indexartikelfix.php"><i class="bi bi-journal-text"></i> Informasi Artikel</a>
                <a href="inputhistory.php"><i class="bi bi-clock-history"></i> Our History</a>
        <a href="logout.php" style="color: #ff9999;">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>

    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Pencapaian Himpunan</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Pencapaian</button>
        </div>

        <?php
        $sql = "SELECT * FROM achievements ORDER BY id ASC";
        if ($result = mysqli_query($link, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered table-striped'>";
                echo "<thead class='table-dark'><tr>
                        <th>Pencapaian</th>
                        <th>Angka</th>
                        <th>Pengaturan</th>
                      </tr></thead><tbody>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['pencapaian']}</td>";
                    echo "<td>{$row['angka']}</td>";
                    echo "<td class='d-flex flex-wrap gap-1'>
                        <button type='button' class='btn btn-danger btn-sm deleteBtn' 
                            data-id='{$row['id']}'
                            data-bs-toggle='modal' data-bs-target='#deleteModal'>Hapus</button>
                        <button type='button' class='btn btn-primary btn-sm editBtn' 
                            data-id='{$row['id']}'
                            data-pencapaian='{$row['pencapaian']}'
                            data-angka='{$row['angka']}'
                            data-bs-toggle='modal' data-bs-target='#editModal'>Edit</button>
                    </td>";
                    echo "</tr>";
                }
                echo "</tbody></table></div>";
            } else {
                echo "<div class='alert alert-warning'>Belum ada pencapaian ditambahkan.</div>";
            }
        }
        ?>
    </div>
</div>
<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Tambah Pencapaian</h5></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pencapaian</label>
                        <select name="pencapaian" class="form-control" required>
                            <option value="Periode Kepengurusan">Periode Kepengurusan</option>
                            <option value="Mahasiswa Pengurus">Mahasiswa Pengurus</option>
                            <option value="Program Kerja Terlaksana">Program Kerja Terlaksana</option>
                            <option value="Impact ke Masyarakat">Impact ke Masyarakat</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Angka</label>
                        <input type="number" name="angka" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="addAchieve" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post">
            <input type="hidden" name="id" id="edit-id">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Edit Pencapaian</h5></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pencapaian</label>
                        <select name="pencapaian" id="edit-pencapaian" class="form-control" required>
                            <option value="Periode Kepengurusan">Periode Kepengurusan</option>
                            <option value="Mahasiswa Pengurus">Mahasiswa Pengurus</option>
                            <option value="Program Kerja Terlaksana">Program Kerja Terlaksana</option>
                            <option value="Impact ke Masyarakat">Impact ke Masyarakat</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Angka</label>
                        <input type="number" name="angka" id="edit-angka" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="updateAchieve" class="btn btn-primary">Update</button>
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
                <div class="modal-body"><p>Yakin ingin menghapus pencapaian ini?</p></div>
                <div class="modal-footer">
                    <button type="submit" name="deleteAchieve" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $(".editBtn").click(function () {
            $("#edit-id").val($(this).data("id"));
            $("#edit-pencapaian").val($(this).data("pencapaian"));
            $("#edit-angka").val($(this).data("angka"));
        });

        $(".deleteBtn").click(function () {
            $("#delete-id").val($(this).data("id"));
        });
    });

    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }
</script>
</body>
</html>
