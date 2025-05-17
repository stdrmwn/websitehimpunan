<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include("config4.php"); // pastikan koneksi ke database

$query = "SELECT foto_ke, foto FROM gallery_events ORDER BY foto_ke ASC";
$result = mysqli_query($link, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        "foto_ke" => intval($row["foto_ke"]),
        "url" => "uploads/" . $row["foto"]
    ];
}

echo json_encode($data);
?>
