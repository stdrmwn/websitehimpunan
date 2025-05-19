<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "User tidak ditemukan.";
    exit;
}

$user_id_to_edit = $_GET['id'];

// Ambil data user
$stmt = $conn->prepare("SELECT id, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id_to_edit);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    echo "User tidak ditemukan.";
    exit;
}

$success = "";
$error = "";

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($new_password) || strlen($new_password) < 6) {
        $error = "Password harus minimal 6 karakter.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Konfirmasi password tidak cocok.";
    } else {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update->bind_param("si", $hashed, $user_id_to_edit);
        if ($update->execute()) {
            $success = "Password berhasil diubah.";
        } else {
            $error = "Terjadi kesalahan saat mengubah password.";
        }
        $update->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Password User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container">
        <h3>Ubah Password untuk: <?= htmlspecialchars($user['email']) ?></h3>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label>Password Baru</label>
                <input type="password" name="new_password" class="form-control" required minlength="6">
            </div>
            <div class="mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="confirm_password" class="form-control" required minlength="6">
            </div>
            <button type="submit" class="btn btn-primary">Ubah Password</button>
            <a href="kelolauser.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
