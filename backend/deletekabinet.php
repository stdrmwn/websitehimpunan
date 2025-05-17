<?php
require_once "config4.php";

if(isset($_GET["id"]) && !empty($_GET["id"])){
    $id = $_GET["id"];

    // Ambil logo untuk dihapus dari folder
    $res = mysqli_query($link, "SELECT logo FROM kabinet WHERE id = $id");
    $data = mysqli_fetch_assoc($res);
    $logo = $data["logo"];

    if(mysqli_query($link, "DELETE FROM kabinet WHERE id = $id")){
        if(file_exists("uploads/$logo")){
            unlink("uploads/$logo");
        }
        header("location: dashboardkabinet.php");
        exit();
    } else {
        echo "Terjadi kesalahan saat menghapus data.";
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
