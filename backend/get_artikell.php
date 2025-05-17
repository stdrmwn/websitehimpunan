<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include("config4.php");

$result = mysqli_query($link, "SELECT id, kategori, judul, informasi, tanggal_input, foto, slug FROM artikelfix ORDER BY tanggal_input DESC");

$artikels = array();
while ($row = mysqli_fetch_assoc($result)) {
    $artikels[] = $row;
}

echo json_encode($artikels);
?>
