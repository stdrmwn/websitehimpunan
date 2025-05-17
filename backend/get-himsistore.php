<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include "config4.php"; // Pastikan koneksi database benar

$query = "SELECT * FROM himsistore";
$result = mysqli_query($link, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>
