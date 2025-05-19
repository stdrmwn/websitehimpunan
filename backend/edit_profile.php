<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success = '';
$error = '';
$role = '';
$plain_password = ''; // akan diisi nanti untuk admin

// Ambil data user
$stmt = $conn->prepare("SELECT email, role, password FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($email, $role, $hashed_password);
$stmt->fetch();
$stmt->close();

// Hanya admin yang akan mendapatkan password ditampilkan (jika memungkinkan)
if ($role === 'admin') {
    // Tidak bisa reverse hash password, jadi bisa diisi placeholder atau info
    $plain_password = '[TERENKRIPSI]'; // Atau beri tahu tidak bisa ditampilkan
}

// Proses form (hanya jika bukan admin)
if ($_SERVER["REQUEST_METHOD"] == "POST" && $role !== 'admin') {
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if (empty($password) || empty($confirm)) {
        $error = "Semua field harus diisi.";
    } elseif ($password !== $confirm) {
        $error = "Password dan konfirmasi tidak cocok.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update->bind_param("si", $hashed, $user_id);
        if ($update->execute()) {
            $success = "Password berhasil diperbarui.";
        } else {
            $error = "Terjadi kesalahan saat memperbarui password.";
        }
        $update->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
        }

        .container {
            max-width: 500px;
            margin-top: 4rem;
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Profil</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email Anda</label>
            <input type="email" id="email" class="form-control" value="<?= htmlspecialchars($email) ?>" disabled>
        </div>

        <?php if ($role === 'admin'): ?>
            <div class="mb-3">
                <label class="form-label">Password (Admin tidak dapat mengubah)</label>
                <input type="text" class="form-control" value="<?= $plain_password ?>" readonly>
            </div>
            <div class="alert alert-warning">Admin tidak diizinkan untuk mengubah password.</div>
            <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
        <?php else: ?>
            <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password baru" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Ulangi password baru" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="dashboard_superadmin.php" class="btn btn-secondary">Kembali</a>
        <?php endif; ?>
    </form>
</div>

</body>
</html>
