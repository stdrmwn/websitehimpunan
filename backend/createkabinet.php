<?php
require_once "config4.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nama = $_POST["nama_kabinet"];
    $deskripsi = $_POST["deskripsi"];
    $logo = $_FILES["logo"]["name"];
    $tmp_name = $_FILES["logo"]["tmp_name"];

    move_uploaded_file($tmp_name, "uploads/" . $logo);

    $sql = "INSERT INTO kabinet (nama_kabinet, deskripsi, logo) VALUES (?, ?, ?)";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "sss", $nama, $deskripsi, $logo);
        if(mysqli_stmt_execute($stmt)){
            header("location: dashboardkabinet.php");
            exit();
        } else {
            echo "Terjadi kesalahan.";
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
    <title>Tambah Kabinet</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h2>Tambah Kabinet</h2>
        <form action="createkabinet.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Kabinet</label>
                <input type="text" name="nama_kabinet" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label>Logo Kabinet</label>
                <input type="file" name="logo" accept="image/*" class="form-control" required>
            </div>
            <input type="submit" class="btn btn-primary" value="Simpan">
            <a href="dashboardkabinet.php" class="btn btn-default">Batal</a>
        </form>
    </div>
</body>
</html>
