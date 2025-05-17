<?php
require_once "config4.php";

if(isset($_GET["id"]) && !empty($_GET["id"])){
    $id = $_GET["id"];
    $sql = "DELETE FROM visimisi WHERE id = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $id);
        if(mysqli_stmt_execute($stmt)){
            header("location: index.php");
            exit();
        } else {
            echo "Gagal hapus data.";
        }
    }
}
?>
