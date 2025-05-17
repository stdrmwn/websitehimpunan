<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once "config4.php"; // pastikan file ini menghubungkan ke DB

$sql = "SELECT * FROM eventshimpunan ORDER BY tanggal_event DESC";
$result = $link->query($sql);

$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode($events);
?>
