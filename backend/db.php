<?php
$host = "localhost";
$user = "root";     // ganti kalau kamu pakai user lain
$pass = "";         // ganti kalau ada password
$db   = "himpunan"; // GANTI sesuai database kamu

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
