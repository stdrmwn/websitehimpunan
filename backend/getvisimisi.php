<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include "config4.php"; // gunakan $link dari sini

$query = "SELECT * FROM visimisi LIMIT 1";
$result = mysqli_query($link, $query); // Ganti dari $conn ke $link

if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
    echo json_encode([
        "vision" => $data['visi'],
        "mission" => $data['misi']
    ]);
} else {
    echo json_encode([
        "error" => "Data visi dan misi tidak ditemukan."
    ]);
}
?>
