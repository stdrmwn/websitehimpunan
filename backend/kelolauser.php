<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: login.php");
    exit;
}

if (isset($_POST['tambah_user'])) {
    $email = trim($_POST['email']);
    $password_plain = trim($_POST['password']);
    $role = $_POST['role'];

    // Validasi data
    if (empty($email) || empty($password_plain) || empty($role)) {
        echo "<script>alert('Semua field wajib diisi.'); window.location='kelolauser.php';</script>";
        exit;
    }

    // Cek apakah email sudah ada
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('Email sudah digunakan.'); window.location='kelolauser.php';</script>";
        $check->close();
        exit;
    }
    $check->close();

    // Hash dan simpan
    $password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $password_hashed, $role);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: kelolauser.php");
        exit;
    } else {
        echo "<script>alert('Gagal menyimpan user.'); window.location='kelolauser.php';</script>";
    }
}


if (isset($_POST['edit_user'])) {
    $id = $_POST['edit_id'];
    $email = $_POST['edit_email'];
    $role = $_POST['edit_role'];
    $password = $_POST['edit_password'];

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET email = ?, role = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssi", $email, $role, $hashed_password, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET email = ?, role = ? WHERE id = ?");
        $stmt->bind_param("ssi", $email, $role, $id);
    }

    $stmt->execute();
    $stmt->close();
    header("Location: kelolauser.php");
    exit;
}

// Handle Delete User
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: kelolauser.php");
    exit;
}

// Ambil semua user
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola User - Super Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background-color: #f5f6fa; }
        .sidebar {
            height: 100vh; background-color: #1e1e2f; padding-top: 1rem; color: white;
            position: fixed; width: 240px; top: 0; left: 0; z-index: 1050;
            transition: transform 0.3s ease-in-out;
        }
        .sidebar h4 { text-align: center; font-weight: bold; margin-bottom: 2rem; }
        .sidebar a {
            color: #cbd3da; padding: 12px 20px; display: block; text-decoration: none;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.bg-primary {
            background-color: #0d6efd; color: white;
        }
        .content { margin-left: 240px; padding: 2rem; transition: margin-left 0.3s ease-in-out; }
        .navbar {
            background-color: #2c3e50; color: #fff; padding: 1rem 2rem;
            display: flex; justify-content: space-between; align-items: center;
            position: sticky; top: 0; z-index: 999;
        }
        .navbar h1 { margin: 0; font-size: 1.5rem; }
        .profile-icon {
            width: 40px; height: 40px; background-color: #3498db;
            border-radius: 50%; text-align: center; line-height: 40px;
            font-weight: bold; color: white; cursor: pointer; position: relative;
        }
        .dropdown {
            display: none; position: absolute; right: 0; top: 50px;
            background-color: white; box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            border-radius: 8px; overflow: hidden; z-index: 100;
        }
        .dropdown a {
            display: block; padding: 12px 20px; color: #333; text-decoration: none;
        }
        .dropdown a:hover { background-color: #f0f0f0; }
        .profile-container { position: relative; }
        .close-sidebar { display: none; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .content { margin-left: 0; }
            .mobile-toggle { display: inline-block; }
            .close-sidebar {
                display: block; text-align: right; padding: 0.5rem 1rem;
                font-size: 2rem; cursor: pointer; color: #fff;
            }
        }
    </style>
    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("show");
        }
        function toggleDropdown() {
            const dropdown = document.getElementById("profileDropdown");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        }
        function fillEditModal(id, email, role) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
        function fillDeleteModal(id) {
            document.getElementById('delete_id').value = id;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
        window.onclick = function(event) {
            if (!event.target.closest('.profile-container')) {
                const dropdown = document.getElementById("profileDropdown");
                if (dropdown && dropdown.style.display === "block") {
                    dropdown.style.display = "none";
                }
            }
        }
    </script>
</head>
<body>

<!-- Toggle Button -->
<div class="d-md-none p-2 bg-white shadow-sm">
    <button class="btn btn-outline-dark mobile-toggle" onclick="toggleSidebar()">
        <i class="bi bi-list"></i> Menu
    </button>
</div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="close-sidebar d-md-none" onclick="toggleSidebar()">×</div>
    <h4>Super Admin</h4>
    <a href="dashboard_superadmin.php"><i class="bi bi-house-door-fill"></i> Home Page</a>
    <a href="kelolauser.php" class="bg-primary"><i class="bi bi-people-fill"></i> Kelola User</a>
    <a href="logout.php" style="color: #ff9999;"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- Navbar -->
<div class="navbar">
    <h1>Kelola User</h1>
    <div class="profile-container">
        <div class="profile-icon" onclick="toggleDropdown()">
            <?= strtoupper(substr($_SESSION['user_email'] ?? 'S', 0, 1)) ?>
        </div>
        <div class="dropdown" id="profileDropdown">
            <a href="edit_profile.php">Edit Profil</a>
        </div>
    </div>
</div>

<!-- Konten -->
<div class="content">
    <div class="container">
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal">
            <i class="bi bi-plus-circle"></i> Tambah User
        </button>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= $row['role'] ?></td>
                        <td>
<!-- Tombol Edit -->
<button class="btn btn-sm btn-primary"
    onclick="fillEditModal('<?= $row['id'] ?>', '<?= htmlspecialchars($row['email']) ?>', '<?= $row['role'] ?>')"
    data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">
    Edit
</button>

<!-- Tombol Hapus -->
<button class="btn btn-sm btn-danger"
    onclick="fillDeleteModal('<?= $row['id'] ?>')"
    data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row['id'] ?>">
    Hapus
</button>

                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST">
      <div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Tambah User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
          <div class="mb-3"><label>Email</label><input type="email" name="email" required class="form-control"></div>
          <div class="mb-3"><label>Password</label><input type="password" name="password" required class="form-control"></div>
          <div class="mb-3"><label>Role</label>
            <select name="role" class="form-select">
              <option value="admin">Admin</option>
              <option value="superadmin">Super Admin</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="tambah_user" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST">
      <input type="hidden" name="edit_id" id="edit_id">
      <div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
          <div class="mb-3"><label>Email</label><input type="email" name="edit_email" id="edit_email" required class="form-control"></div>
          <div class="mb-3"><label>Password (Kosongkan jika tidak diubah)</label><input type="password" name="edit_password" class="form-control"></div>
          <div class="mb-3"><label>Role</label>
            <select name="edit_role" id="edit_role" class="form-select">
              <option value="admin">Admin</option>
              <option value="superadmin">Super Admin</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="edit_user" class="btn btn-primary">Simpan Perubahan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="GET">
      <input type="hidden" name="hapus" id="delete_id">
      <div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
          <p>Apakah Anda yakin ingin menghapus user ini?</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Hapus</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
