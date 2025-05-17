<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include "config4.php"; // pastikan koneksi sudah benar

if (isset($_GET['id'])) {
    // Jika parameter ID diberikan, ambil satu artikel berdasarkan ID
    $id = mysqli_real_escape_string($link, $_GET['id']); // hindari SQL injection
    $result = mysqli_query($link, "SELECT * FROM artikel WHERE id = '$id'");

    if ($row = mysqli_fetch_assoc($result)) {
        $row['foto'] = $row['foto'] ? "uploads/" . $row['foto'] : null;
        echo json_encode($row);
    } else {
        // Artikel tidak ditemukan
        http_response_code(404);
        echo json_encode(["message" => "Artikel tidak ditemukan"]);
    }
} else {
    // Jika tidak ada parameter ID, kembalikan semua artikel
    $result = mysqli_query($link, "SELECT * FROM artikel ORDER BY tanggal_input DESC");

    $artikels = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['foto'] = $row['foto'] ? "uploads/" . $row['foto'] : null;
        $artikels[] = $row;
    }

    echo json_encode($artikels);
}
?>
