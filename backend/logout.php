<?php
session_start();  // Memulai sesi untuk memastikan bisa mengakses variabel sesi

include 'db.php'; // Koneksi database

// Cek apakah session user_id sudah ada (login)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Jika belum login, arahkan ke halaman login
    exit;
}

// Fungsi untuk konfirmasi logout
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    // Hancurkan semua sesi untuk logout
    session_unset();  // Menghapus semua variabel sesi
    session_destroy();  // Menghancurkan sesi

    // Arahkan user ke halaman login setelah logout
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Logout</title>
    <script>
        function confirmLogout() {
            // Menampilkan pesan konfirmasi logout
            if (confirm("Apakah Anda yakin ingin logout?")) {
                // Jika user konfirmasi logout, arahkan ke logout.php dengan parameter 'confirm=yes'
                window.location.href = "logout.php?confirm=yes";
            } else {
                // Jika user batal logout, arahkan kembali ke halaman inputvisimisi.php
                window.location.href = "inputvisimisi.php";
            }
        }

        window.onload = confirmLogout; // Memanggil fungsi konfirmasi saat halaman dimuat
    </script>
</head>
<body>
</body>
</html>
