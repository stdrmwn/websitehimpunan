<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include "config4.php"; // pastikan file ini benar dan berisi koneksi ke DB

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // amankan input ID

    $query = "SELECT * FROM artikel WHERE id = $id";
    $result = mysqli_query($link, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $row['foto'] = $row['foto'] ? "uploads/" . $row['foto'] : null;

        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Artikel tidak ditemukan"]);
    }
} else {
    echo json_encode(["error" => "ID artikel tidak diberikan"]);
}
?>
