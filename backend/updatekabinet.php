<?php
require_once "config4.php";

$id = $_GET["id"];
$sql = "SELECT * FROM kabinet WHERE id = $id";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nama = $_POST["nama_kabinet"];
    $deskripsi = $_POST["deskripsi"];

    // Cek apakah upload baru
    if(!empty($_FILES["logo"]["name"])){
        $logo = $_FILES["logo"]["name"];
        $tmp_name = $_FILES["logo"]["tmp_name"];
        move_uploaded_file($tmp_name, "uploads/" . $logo);
    } else {
        $logo = $row["logo"];
    }

    $sql = "UPDATE kabinet SET nama_kabinet=?, deskripsi=?, logo=? WHERE id=?";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "sssi", $nama, $deskripsi, $logo, $id);
        if(mysqli_stmt_execute($stmt)){
            header("location: dashboard_kabinet.php");
            exit();
        } else {
            echo "Terjadi kesalahan saat update.";
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Kabinet</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h2>Edit Kabinet</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Kabinet</label>
                <input type="text" name="nama_kabinet" class="form-control" value="<?php echo $row["nama_kabinet"]; ?>" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" required><?php echo $row["deskripsi"]; ?></textarea>
            </div>
            <div class="form-group">
                <label>Logo Saat Ini</label><br>
                <img src="uploads/<?php echo $row["logo"]; ?>" width="100"><br><br>
                <input type="file" name="logo" class="form-control">
                <small>Kosongkan jika tidak ingin mengganti.</small>
            </div>
            <input type="submit" class="btn btn-primary" value="Update">
            <a href="dashboardkabinet.php" class="btn btn-default">Batal</a>
        </form>
    </div>
</body>
</html>
