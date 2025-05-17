<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include("config4.php");

if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];

    $stmt = mysqli_prepare($link, "SELECT * FROM artikelfix WHERE slug = ?");
    mysqli_stmt_bind_param($stmt, "s", $slug);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Artikel tidak ditemukan"]);
    }
} else {
    http_response_code(400);
    echo json_encode(["error" => "Slug tidak diberikan"]);
}
?>
