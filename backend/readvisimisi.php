<?php
require_once "config4.php";
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    $id = trim($_GET["id"]);
    $sql = "SELECT * FROM visimisi WHERE id = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $id);
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                echo "<h2>Detail Visi & Misi</h2>";
                echo "<p><strong>Visi:</strong> " . $row["visi"] . "</p>";
                echo "<p><strong>Misi:</strong> " . $row["misi"] . "</p>";
                echo "<a href='index.php'>Kembali</a>";
            } else {
                echo "Data tidak ditemukan.";
            }
        }
    }
}
?>
