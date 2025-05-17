<?php
require_once "config4.php";

if(isset($_POST["id"])){
    $id = $_POST["id"];
    $visi = $_POST["visi"];
    $misi = $_POST["misi"];

    $sql = "UPDATE visimisi SET visi=?, misi=? WHERE id=?";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "ssi", $visi, $misi, $id);
        if(mysqli_stmt_execute($stmt)){
            header("location: inputvisimisi.php");
            exit();
        } else {
            echo "Gagal update.";
        }
    }
} elseif(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    $id = trim($_GET["id"]);
    $sql = "SELECT * FROM visimisi WHERE id = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $id);
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $visi = $row["visi"];
                $misi = $row["misi"];
            } else {
                echo "Data tidak ditemukan.";
                exit();
            }
        }
    }
}
?>

<form action="updatevisimisi.php" method="post" style="margin: 50px;">
    <h2>Update Visi & Misi</h2>
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <label>Visi:</label><br>
    <textarea name="visi" rows="4" cols="60" required><?php echo $visi; ?></textarea><br><br>
    <label>Misi:</label><br>
    <textarea name="misi" rows="4" cols="60" required><?php echo $misi; ?></textarea><br><br>
    <input type="submit" class="btn btn-yellow" value="Update">
</form>
