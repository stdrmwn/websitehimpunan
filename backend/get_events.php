<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include "config4.php"; // file koneksi ke database

$query = "SELECT * FROM events";
$result = mysqli_query($link, $query);

$events = [];

while ($row = mysqli_fetch_assoc($result)) {
    $events[] = [
        "id" => $row["id"],
        "title" => $row["nama_event"],
        "description" => $row["deskripsi"],
        "image" => "uploads/" . $row["foto"] // pastikan path benar
    ];
}

echo json_encode($events);
?>
