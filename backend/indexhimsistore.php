<?php
require_once "config4.php";

// Create
if (isset($_POST["addProduk"])) {
    $nama = $_POST["nama"];
    $fotoName = $_FILES["foto"]["name"];
    $fotoTmp = $_FILES["foto"]["tmp_name"];
    move_uploaded_file($fotoTmp, "uploads/" . $fotoName);

    $query = "INSERT INTO himsistore (nama, foto) VALUES ('$nama', '$fotoName')";
    mysqli_query($link, $query);
    header("Location: indexhimsistore.php");
}

// Update
if (isset($_POST["updateProduk"])) {
    $id = intval($_POST["id"]);
    $nama = $_POST["nama"];
    $fotoName = $_FILES["foto"]["name"];
    $fotoTmp = $_FILES["foto"]["tmp_name"];
    if ($fotoName != "") {
        move_uploaded_file($fotoTmp, "uploads/" . $fotoName);
        $query = "UPDATE himsistore SET nama='$nama', foto='$fotoName' WHERE id=$id";
    } else {
        $query = "UPDATE himsistore SET nama='$nama' WHERE id=$id";
    }
    mysqli_query($link, $query);
    header("Location: indexhimsistore.php");
}

// Delete
if (isset($_POST["deleteProduk"])) {
    $id = intval($_POST["id"]);
    $query = "DELETE FROM himsistore WHERE id=$id";
    mysqli_query($link, $query);
    header("Location: indexhimsistore.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>HIMSI Store</title>
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
            background-color: #1e1e2f;
            padding-top: 1rem;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            z-index: 1050; /* lebih tinggi dari hamburger */
            transition: transform 0.3s ease-in-out;
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
        .produk-foto {
            width: 70px;
            height: auto;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .modal-header {
            background-color: #0d6efd;
            color: white;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 240px;
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
                z-index: 1000;
            }

            .sidebar.show ~ .mobile-toggle {
                z-index: 900; /* berada di bawah sidebar */
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
<div class="d-md-none p-2 bg-white shadow-sm position-relative">
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
        <a href="indexhimsistore.php" class="bg-primary"><i class="bi bi-shop"></i> HIMSI Store</a>
        <a href="indexgallery.php"><i class="bi bi-images"></i> Gallery of Events</a>
        <a href="indexachievement.php"><i class="bi bi-award-fill"></i> Pencapaian</a>
        <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <!-- Content -->
    <div class="content w-100">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">HIMSI Store</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Produk</button>
        </div>

        <?php
        $sql = "SELECT * FROM himsistore";
        if ($result = mysqli_query($link, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered table-striped'>";
                echo "<thead class='table-dark'>
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Nama Produk</th>
                            <th>Pengaturan</th>
                        </tr>
                      </thead>
                      <tbody>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td><img src='uploads/{$row['foto']}' class='produk-foto'></td>";
                    echo "<td>{$row['nama']}</td>";
                    echo "<td class='d-flex gap-1'>
                        <button type='button' class='btn btn-danger btn-sm deleteBtn' 
                            data-id='{$row['id']}' 
                            data-bs-toggle='modal' 
                            data-bs-target='#deleteModal'>Hapus</button>
                        <button type='button' class='btn btn-primary btn-sm editBtn' 
                            data-id='{$row['id']}'
                            data-nama='{$row['nama']}'
                            data-bs-toggle='modal' 
                            data-bs-target='#editModal'>Edit</button>
                    </td>";
                    echo "</tr>";
                }
                echo "</tbody></table></div>";
            } else {
                echo "<div class='alert alert-warning'>Belum ada produk ditambahkan.</div>";
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
                <div class="modal-header"><h5 class="modal-title">Tambah Produk</h5></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Foto Produk</label><input type="file" name="foto" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Nama Produk</label><input type="text" name="nama" class="form-control" required></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="addProduk" class="btn btn-success">Simpan</button>
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
                <div class="modal-header"><h5 class="modal-title">Edit Produk</h5></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Foto Produk (kosongkan jika tidak diubah)</label><input type="file" name="foto" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Nama Produk</label><input type="text" name="nama" id="edit-nama" class="form-control" required></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="updateProduk" class="btn btn-primary">Update</button>
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
                <div class="modal-body"><p>Apakah Anda yakin ingin menghapus produk ini?</p></div>
                <div class="modal-footer">
                    <button type="submit" name="deleteProduk" class="btn btn-danger">Hapus</button>
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
            $("#edit-nama").val($(this).data("nama"));
        });

        $(".deleteBtn").click(function () {
            $("#delete-id").val($(this).data("id"));
        });
    });

    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("show");
    }
</script>
</body>
</html>
