<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include("config4.php"); // koneksi DB

$result = mysqli_query($link, "SELECT * FROM kabinet ORDER BY id DESC LIMIT 1");
$data = mysqli_fetch_assoc($result);

echo json_encode($data);
?>
