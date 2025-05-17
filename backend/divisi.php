<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include 'config4.php'; // file koneksi mysqli

$query = "SELECT * FROM divisi ORDER BY id ASC";
$result = mysqli_query($link, $query);

$divisi = [];

while ($row = mysqli_fetch_assoc($result)) {
    $divisi[] = $row;
}

header('Content-Type: application/json');
echo json_encode($divisi);
?>
