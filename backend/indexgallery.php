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

// Create
if (isset($_POST["addFoto"])) {
    $fotoKe = intval($_POST["foto_ke"]);
    $fotoName = $_FILES["foto"]["name"];
    $fotoTmp = $_FILES["foto"]["tmp_name"];
    move_uploaded_file($fotoTmp, "uploads/" . $fotoName);

    $query = "INSERT INTO gallery_events (foto_ke, foto) VALUES ($fotoKe, '$fotoName')";
    mysqli_query($link, $query);
    header("Location: indexgallery.php");
}

// Update
if (isset($_POST["updateFoto"])) {
    $id = intval($_POST["id"]);
    $fotoKe = intval($_POST["foto_ke"]);
    $fotoName = $_FILES["foto"]["name"];
    $fotoTmp = $_FILES["foto"]["tmp_name"];

    if ($fotoName != "") {
        move_uploaded_file($fotoTmp, "uploads/" . $fotoName);
        $query = "UPDATE gallery_events SET foto_ke=$fotoKe, foto='$fotoName' WHERE id=$id";
    } else {
        $query = "UPDATE gallery_events SET foto_ke=$fotoKe WHERE id=$id";
    }
    mysqli_query($link, $query);
    header("Location: indexgallery.php");
}

// Delete
if (isset($_POST["deleteFoto"])) {
    $id = intval($_POST["id"]);
    $query = "DELETE FROM gallery_events WHERE id=$id";
    mysqli_query($link, $query);
    header("Location: indexgallery.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Gallery of Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f6fa;
            margin: 0;
            padding: 0;
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
            z-index: 1050; /* lebih tinggi dari tombol */
            transform: translateX(0);
            transition: transform 0.3s ease;
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

        .foto-preview {
            width: 100px;
            height: auto;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .modal-header {
            background-color: #0d6efd;
            color: white;
        }

        .mobile-toggle {
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
            }

            .mobile-toggle {
                display: inline-block;
                position: relative;
                z-index: 1000; /* di bawah sidebar */
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
<div class="d-md-none p-2 bg-white shadow-sm position-relative" style="z-index: 1000;">
    <button class="btn btn-outline-dark mobile-toggle" onclick="toggleSidebar()">
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
<a href="indexdivisi.php"><i class="bi bi-diagram-3-fill"></i> Divisi Himpunan</a>
<a href="indexgallery.php"class="bg-primary"><i class="bi bi-images"></i> Gallery of Events</a>
<a href="indexachievement.php"><i class="bi bi-award-fill"></i> Pencapaian</a>
<a href="indexartikelfix.php"><i class="bi bi-journal-text"></i> Informasi Artikel</a>
<a href="logout.php" style="color: #ff9999;">
  <i class="bi bi-box-arrow-right"></i> Logout
</a>
    </div>

    <!-- Content -->
    <div class="content w-100">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Gallery of Events</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Foto</button>
        </div>

        <?php
        $sql = "SELECT * FROM gallery_events ORDER BY foto_ke ASC";
        if ($result = mysqli_query($link, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered table-striped'>";
                echo "<thead class='table-dark'>
                        <tr>
                            <th>ID</th>
                            <th>Foto ke-</th>
                            <th>Foto</th>
                            <th>Pengaturan</th>
                        </tr>
                      </thead>
                      <tbody>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['foto_ke']}</td>";
                    echo "<td><img src='uploads/{$row['foto']}' class='foto-preview'></td>";
                    echo "<td class='d-flex gap-1'>
                        <button type='button' class='btn btn-danger btn-sm deleteBtn' 
                            data-id='{$row['id']}'
                            data-bs-toggle='modal' data-bs-target='#deleteModal'>Hapus</button>
                        <button type='button' class='btn btn-primary btn-sm editBtn' 
                            data-id='{$row['id']}' 
                            data-fotoke='{$row['foto_ke']}'
                            data-bs-toggle='modal' data-bs-target='#editModal'>Edit</button>
                    </td>";
                    echo "</tr>";
                }
                echo "</tbody></table></div>";
            } else {
                echo "<div class='alert alert-warning'>Belum ada foto di galeri.</div>";
            }
        }
        ?>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Tambah Foto</h5></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Foto ke-</label>
                        <select name="foto_ke" class="form-control" required>
                            <?php for ($i = 1; $i <= 14; $i++) echo "<option value='$i'>$i</option>"; ?>
                        </select>
                    </div>
                    <div class="mb-3"><label class="form-label">Pilih Foto</label><input type="file" name="foto" class="form-control" required></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="addFoto" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" id="edit-id">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Edit Foto</h5></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Foto ke-</label>
                        <select name="foto_ke" id="edit-foto-ke" class="form-control" required>
                            <?php for ($i = 1; $i <= 14; $i++) echo "<option value='$i'>$i</option>"; ?>
                        </select>
                    </div>
                    <div class="mb-3"><label class="form-label">Ganti Foto (opsional)</label><input type="file" name="foto" class="form-control"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="updateFoto" class="btn btn-primary">Update</button>
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
                <div class="modal-body"><p>Apakah Anda yakin ingin menghapus foto ini?</p></div>
                <div class="modal-footer">
                    <button type="submit" name="deleteFoto" class="btn btn-danger">Hapus</button>
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
            $("#edit-foto-ke").val($(this).data("fotoke"));
        });

        $(".deleteBtn").click(function () {
            $("#delete-id").val($(this).data("id"));
        });
    });

    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("show");
    }
</script>
</body>
</html>
