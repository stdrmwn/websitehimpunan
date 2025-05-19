<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include("config4.php"); // pastikan koneksi ke database

$query = "SELECT * FROM ourhistory ORDER BY id DESC";
$result = mysqli_query($link, $query);

$histories = [];

while ($row = mysqli_fetch_assoc($result)) {
    $histories[] = $row;
}

echo json_encode($histories);
?>
