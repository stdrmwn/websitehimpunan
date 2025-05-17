<?php
require_once "config4.php";

if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    $sql = "SELECT * FROM kabinet WHERE id = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = trim($_GET["id"]);

        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            } else {
                echo "ID tidak valid.";
                exit();
            }
        } else {
            echo "Terjadi kesalahan.";
            exit();
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
} else {
    echo "ID tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lihat Kabinet</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h2>Detail Kabinet</h2>
        <p><strong>Nama:</strong> <?php echo $row["nama_kabinet"]; ?></p>
        <p><strong>Deskripsi:</strong> <?php echo $row["deskripsi"]; ?></p>
        <p><strong>Logo:</strong><br><img src="uploads/<?php echo $row["logo"]; ?>" width="150"></p>
        <a href="dashboardkabinet.php" class="btn btn-primary">Kembali</a>
    </div>
</body>
</html>
