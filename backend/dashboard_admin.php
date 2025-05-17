<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<h2>Dashboard Admin</h2>
<p>Selamat datang, admin!</p>
<ul>
    <li><a href="tambah_data.php">Tambah Data</a></li>
    <li><a href="lihat_data.php">Lihat Data Saya</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>
