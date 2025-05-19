<?php
session_start();
include 'db.php';
require_once "config4.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['addHistory'])) {
    $tahun_mulai = intval($_POST['tahun_mulai']);
    $tahun_akhir = $tahun_mulai + 1;
    $tahun_jabatan = "$tahun_mulai/$tahun_akhir";

    $ketua = $_POST['nama_ketua'];
    $wakil = $_POST['nama_wakil'];
    $kegiatan = $_POST['daftar_kegiatan'];

    $fotoProfilName = $_FILES['foto_profil']['name'];
    $fotoProfilTmp = $_FILES['foto_profil']['tmp_name'];
    move_uploaded_file($fotoProfilTmp, 'uploads/' . $fotoProfilName);

    $query = "INSERT INTO ourhistory (tahun_jabatan, nama_ketua, nama_wakil, foto_profil, daftar_kegiatan)
              VALUES ('$tahun_jabatan', '$ketua', '$wakil', '$fotoProfilName', '$kegiatan')";
    mysqli_query($link, $query);
    header("Location: inputhistory.php");
    exit;
}

// Edit Data
if (isset($_POST['editHistory'])) {
    $id = $_POST['id'];
    $tahun_mulai = intval($_POST['tahun_mulai']);
    $tahun_akhir = $tahun_mulai + 1;
    $tahun_jabatan = "$tahun_mulai/$tahun_akhir";
    $ketua = $_POST['nama_ketua'];
    $wakil = $_POST['nama_wakil'];
    $kegiatan = $_POST['daftar_kegiatan'];

    if (!empty($_FILES['foto_profil']['name'])) {
        $fotoProfilName = $_FILES['foto_profil']['name'];
        $fotoProfilTmp = $_FILES['foto_profil']['tmp_name'];
        move_uploaded_file($fotoProfilTmp, 'uploads/' . $fotoProfilName);
        $query = "UPDATE ourhistory 
                  SET tahun_jabatan='$tahun_jabatan', nama_ketua='$ketua', nama_wakil='$wakil', 
                      foto_profil='$fotoProfilName', daftar_kegiatan='$kegiatan' 
                  WHERE id=$id";
    } else {
        $query = "UPDATE ourhistory 
                  SET tahun_jabatan='$tahun_jabatan', nama_ketua='$ketua', nama_wakil='$wakil', 
                      daftar_kegiatan='$kegiatan' 
                  WHERE id=$id";
    }

    mysqli_query($link, $query);
    header("Location: inputhistory.php");
    exit;
}

// Delete Data
if (isset($_POST['deleteHistory'])) {
    $id = $_POST['id'];
    mysqli_query($link, "DELETE FROM ourhistory WHERE id=$id");
    header("Location: inputhistory.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Our History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f5f6fa; }
        .sidebar {
            height: 100vh;
            background-color:#800040;
            padding-top: 1rem;
            color: white;
            position: fixed;
            width: 240px;
            top: 0;
            left: 0;
            z-index: 1050;
            transition: transform 0.3s ease-in-out;
        }
        .sidebar h4 { text-align: center; font-weight: bold; margin-bottom: 2rem; }
        .sidebar a {
            color: #cbd3da;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.bg-primary {
            background-color: #0d6efd;
            color: white;
        }
        .content {
            margin-left: 240px;
            padding: 2rem;
        }
        .close-sidebar { display: none; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .content { margin-left: 0; }
            .mobile-toggle { display: inline-block; }
            .close-sidebar {
                display: block;
                text-align: right;
                padding: 0.5rem 1rem;
                font-size: 2rem;
                cursor: pointer;
                color: #fff;
            }
        }
        img.foto-profil {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        td, th {
            vertical-align: middle !important;
        }
        .table-responsive {
            max-height: 70vh;
            overflow-y: auto;
        }
    </style>
</head>
<body>

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
        <a href="indexartikelfix.php"><i class="bi bi-journal-text"></i> Informasi Artikel</a>
        <a href="inputhistory.php" class="bg-primary"><i class="bi bi-clock-history"></i> Our History</a>
        <a href="logout.php" style="color: #ff9999;"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <div class="content w-100">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Our History</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Sejarah</button>
        </div>

<?php
// Asumsi: $link sudah koneksi database mysqli
$result = mysqli_query($link, "SELECT * FROM ourhistory ORDER BY id DESC");
if (mysqli_num_rows($result) > 0) {
    echo "<div class='table-responsive'>";
    echo "<table class='table table-bordered table-striped align-middle'>";
    echo "<thead class='table-dark text-center'>";
    echo "<tr>";
    echo "<th scope='col'>Tahun Periode</th>";
    echo "<th scope='col'>Foto Profil</th>";
    echo "<th scope='col'>Nama Ketua</th>";
    echo "<th scope='col'>Nama Wakil</th>";
    echo "<th scope='col'>Daftar Kegiatan</th>";
    echo "<th scope='col'>Pengaturan</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $tahun_periode = htmlspecialchars($row['tahun_jabatan']);
        $nama_ketua = htmlspecialchars($row['nama_ketua']);
        $nama_wakil = htmlspecialchars($row['nama_wakil']);
        $foto_profil = htmlspecialchars($row['foto_profil']);
        $daftar_kegiatan_arr = explode("\n", $row['daftar_kegiatan']);

        echo "<tr>";
        echo "<td class='text-center'>{$tahun_periode}</td>";

        echo "<td class='text-center'>
                <img src='uploads/{$foto_profil}' alt='Foto Profil' class='foto-profil' style='max-width: 80px; height: 80px; object-fit: cover; border-radius: 5px;'>
              </td>";

        echo "<td>{$nama_ketua}</td>";
        echo "<td>{$nama_wakil}</td>";

        echo "<td><ul class='mb-0 ps-3'>";
        foreach ($daftar_kegiatan_arr as $item) {
            $item = trim($item);
            if ($item !== "") {
                echo "<li>" . htmlspecialchars($item) . "</li>";
            }
        }
        echo "</ul></td>";

        echo "<td class='text-center'>
                <div class='d-flex justify-content-center gap-2'>
                    <button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal$id'>
                        Hapus
                    </button>
                    <button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#editModal$id'>
                        Edit
                    </button>
                </div>
              </td>";
        echo "</tr>";

                // Modal Edit
                $tahun_awal = explode("/", $row['tahun_jabatan'])[0];
                echo "<div class='modal fade' id='editModal$id' tabindex='-1' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <form method='post' enctype='multipart/form-data'>
                                <input type='hidden' name='id' value='$id'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title'>Edit Sejarah</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <div class='mb-3'>
                                            <label class='form-label'>Tahun Menjabat (Awal)</label>
                                            <input type='number' name='tahun_mulai' value='$tahun_awal' class='form-control' required>
                                            <small class='text-muted'>Akan otomatis menjadi $tahun_awal/" . ($tahun_awal+1) . "</small>
                                        </div>
                                        <div class='mb-3'>
                                            <label class='form-label'>Nama Ketua</label>
                                            <input type='text' name='nama_ketua' class='form-control' value='{$nama_ketua}' required>
                                        </div>
                                        <div class='mb-3'>
                                            <label class='form-label'>Nama Wakil</label>
                                            <input type='text' name='nama_wakil' class='form-control' value='{$nama_wakil}' required>
                                        </div>
                                        <div class='mb-3'>
                                            <label class='form-label'>Foto Profil (kosongkan jika tidak diganti)</label>
                                            <input type='file' name='foto_profil' class='form-control' accept='image/*'>
                                        </div>
                                        <div class='mb-3'>
                                            <label class='form-label'>Daftar Kegiatan</label>
                                            <textarea name='daftar_kegiatan' class='form-control' rows='4'>".htmlspecialchars($row['daftar_kegiatan'])."</textarea>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='submit' name='editHistory' class='btn btn-primary'>Simpan Perubahan</button>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>";

                // Modal Hapus
                echo "<div class='modal fade' id='deleteModal$id' tabindex='-1' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <form method='post'>
                                <input type='hidden' name='id' value='$id'>
                                <div class='modal-content'>
                                    <div class='modal-header bg-danger text-white'>
                                        <h5 class='modal-title'>Konfirmasi Hapus</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        Yakin ingin menghapus data sejarah tahun <strong>{$tahun_periode}</strong>?
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='submit' name='deleteHistory' class='btn btn-danger'>Ya, Hapus</button>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "<div class='alert alert-warning'>Belum ada data sejarah kepengurusan.</div>";
        }
        ?>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Sejarah HIMSI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tahun Menjabat (Awal)</label>
                        <input type="number" name="tahun_mulai" class="form-control" placeholder="Contoh: 2022" required>
                        <small class="text-muted">Akan otomatis menjadi 2022/2023</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Ketua</label>
                        <input type="text" name="nama_ketua" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Wakil</label>
                        <input type="text" name="nama_wakil" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto Profil</label>
                        <input type="file" name="foto_profil" class="form-control" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Daftar Kegiatan</label>
                        <textarea name="daftar_kegiatan" class="form-control" rows="4" placeholder="Pisahkan kegiatan dengan Enter" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="addHistory" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("show");
    }
</script>
</body>
</html>
