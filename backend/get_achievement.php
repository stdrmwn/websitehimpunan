<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
require_once("config4.php"); // pastikan ini file koneksi databasenya

$query = "SELECT * FROM achievements ORDER BY id DESC";
$result = mysqli_query($link, $query);

$achievements = [];

while ($row = mysqli_fetch_assoc($result)) {
    $achievements[] = $row;
}

echo json_encode($achievements);
?>
